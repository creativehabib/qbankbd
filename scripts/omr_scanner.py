import cv2
import numpy as np
import sys
import json
import os
import time

def process_omr(image_path, output_dir, total_questions=60, columns=3, expected_options=4):
    try:
        if not os.path.exists(image_path):
            return json.dumps({"error": "ফাইলটি পাওয়া যায়নি!"})

        # ১. ইমেজ লোড করা
        stream = open(image_path, "rb")
        bytes_array = bytearray(stream.read())
        numpy_array = np.asarray(bytes_array, dtype=np.uint8)
        image = cv2.imdecode(numpy_array, cv2.IMREAD_COLOR)

        if image is None:
            return json.dumps({"error": "ইমেজটি রিড করা যায়নি!"})

        # ২. স্ট্যান্ডার্ড সাইজ করা
        target_width = 1200
        target_height = 1600
        image = cv2.resize(image, (target_width, target_height), interpolation=cv2.INTER_AREA)
        display_image = image.copy()

        # ৩. প্রিপ্রসেসিং
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        thresh = cv2.threshold(gray, 225, 255, cv2.THRESH_BINARY_INV)[1]

        # ৪. কন্ট্যুর লোড
        cnts, _ = cv2.findContours(thresh.copy(), cv2.RETR_LIST, cv2.CHAIN_APPROX_SIMPLE)

        bubbles = []
        anchors = []

        for c in cnts:
            x, y, w, h = cv2.boundingRect(c)
            ar = w / float(h)

            if y < 350 and 8 <= w <= 110 and 6 <= h <= 80 and 0.5 <= ar <= 4.5:
                mask = np.zeros(thresh.shape, dtype="uint8")
                cv2.drawContours(mask, [c], -1, 255, -1)
                total_pixels = cv2.countNonZero(cv2.bitwise_and(thresh, thresh, mask=mask))
                area = w * h
                if total_pixels / float(area) > 0.6:
                    anchors.append({'cx': x + w // 2, 'cy': y + h // 2, 'x': x, 'w': w, 'y': y})

            elif 12 <= w <= 40 and 12 <= h <= 40 and 0.75 <= ar <= 1.25:
                bubbles.append({
                    'contour': c,
                    'cx': x + w // 2,
                    'cy': y + h // 2,
                    'x': x, 'y': y, 'w': w, 'h': h
                })

        unique_bubbles = []
        seen_points = set()
        for b in bubbles:
            point_key = (b['cx'] // 8, b['cy'] // 8)
            if point_key not in seen_points:
                seen_points.add(point_key)
                unique_bubbles.append(b)
        bubbles = unique_bubbles

        if len(anchors) < 2:
            if len(bubbles) > 30:
                bubbles.sort(key=lambda b: b['cx'])
                left_anchor = bubbles[0]['cx']
                right_anchor = bubbles[-1]['cx']
                first_anchor_y = min([b['y'] for b in bubbles]) - 25
            else:
                return json.dumps({"error": "ওএমআর বৃত্ত ডিটেক্ট করা যায়নি!"})
        else:
            anchors.sort(key=lambda a: a['cx'])
            left_anchor = anchors[0]['cx']
            right_anchor = anchors[-1]['cx']
            first_anchor_y = min([a['y'] for a in anchors])

        span = right_anchor - left_anchor
        col_width = span / columns

        valid_bubbles = [b for b in bubbles if b['cy'] > first_anchor_y]

        col_groups = [[] for _ in range(columns)]
        for b in valid_bubbles:
            relative_x = b['cx'] - left_anchor
            col_idx = int(relative_x / col_width)
            if col_idx < 0: col_idx = 0
            if col_idx >= columns: col_idx = columns - 1
            col_groups[col_idx].append(b)

        results = {}
        questions_per_col = total_questions // columns
        char_map = {0: 'A', 1: 'B', 2: 'C', 3: 'D'}

        for col_idx, col_bubbles in enumerate(col_groups):
            if len(col_bubbles) < 40: continue

            col_bubbles.sort(key=lambda b: b['cy'])

            rows = []
            for b in col_bubbles:
                placed = False
                for r in rows:
                    if abs(b['cy'] - r[0]['cy']) < 18:
                        r.append(b)
                        placed = True
                        break
                if not placed:
                    rows.append([b])

            rows.sort(key=lambda r: r[0]['cy'])

            valid_rows = []
            for r in rows:
                if len(r) >= expected_options:
                    r.sort(key=lambda b: b['cx'])
                    valid_rows.append(r[-expected_options:])

            for row_idx, options in enumerate(valid_rows):
                if row_idx >= questions_per_col:
                    break

                darkness_values = []
                for b in options:
                    pad_w = int(b['w'] * 0.25)
                    pad_h = int(b['h'] * 0.25)
                    roi = gray[b['y']+pad_h : b['y']+b['h']-pad_h, b['x']+pad_w : b['x']+b['w']-pad_w]
                    mean_val = cv2.mean(roi)[0]
                    darkness_values.append(mean_val)

                bubbled = np.argmin(darkness_values)
                min_val = darkness_values[bubbled]
                other_vals = [darkness_values[idx] for idx in range(len(darkness_values)) if idx != bubbled]
                avg_others = np.mean(other_vals)

                actual_q_num = (col_idx * questions_per_col) + row_idx + 1

                if (avg_others - min_val > 4) and (min_val < 240):
                    results[str(actual_q_num)] = {
                        "option_idx": int(bubbled),
                        "all_options": options
                    }
                else:
                    results[str(actual_q_num)] = {
                        "option_idx": -1,
                        "all_options": options
                    }

        # ৫. ফলাফল ইমেজের ওপর ড্র করা
        correct_answers_dict = {}
        if len(sys.argv) > 5:
            try:
                correct_answers_dict = json.loads(sys.argv[5])
            except:
                pass

        # 🌟 ম্যাজিক: লজিক্যাল লিমিট সেট করা 🌟
        # টোকেনে যদি ৫৯টি প্রশ্ন থাকে, তবে JSON এ ৫৯টি ডাটা থাকবে।
        # পাইথন সেটি গুণে নিয়ে তার লিমিট ৫৯ সেট করে নেবে।
        logical_limit = total_questions
        if correct_answers_dict and len(correct_answers_dict) > 0:
            logical_limit = len(correct_answers_dict)

        formatted_answers = {}

        # 🌟 এখন লুপটি ৬০ এর বদলে ৫৯ (লজিক্যাল লিমিট) পর্যন্ত চলবে 🌟
        for q in range(1, logical_limit + 1):
            q_str = str(q)
            q_data = results.get(q_str, None)
            correct_opt_char = correct_answers_dict.get(q_str, '')

            char_to_idx = {'A': 0, 'B': 1, 'C': 2, 'D': 3}
            correct_idx = char_to_idx.get(correct_opt_char, -1)

            if q_data is not None and isinstance(q_data, dict):
                student_idx = q_data.get("option_idx", -1)
                options = q_data.get("all_options", [])

                if student_idx != -1:
                    formatted_answers[q_str] = char_map.get(student_idx, 'N/A')
                else:
                    formatted_answers[q_str] = 'N/A'

                for idx, opt in enumerate(options):
                    if idx >= len(options): break

                    if idx == student_idx and student_idx == correct_idx:
                        cv2.circle(display_image, (opt['cx'], opt['cy']), int(opt['w'] // 1.6), (0, 200, 0), 4)
                    elif idx == student_idx and student_idx != correct_idx:
                        cv2.circle(display_image, (opt['cx'], opt['cy']), int(opt['w'] // 1.6), (0, 0, 255), 4)
                    elif idx == correct_idx:
                        cv2.circle(display_image, (opt['cx'], opt['cy']), int(opt['w'] // 1.6), (0, 200, 0), 4)
            else:
                formatted_answers[q_str] = 'N/A'

        result_filename = "evaluated_" + str(int(time.time())) + ".png"
        result_path = os.path.join(output_dir, result_filename)
        cv2.imwrite(result_path, display_image)

        return json.dumps({
            "status": "success",
            "answers": formatted_answers, # এখানে শুধুমাত্র ৫৯টি রেজাল্ট যাবে
            "result_image": "/storage/omr_scans/" + result_filename
        })

    except Exception as e:
        return json.dumps({"error": str(e)})


if __name__ == "__main__":
    if len(sys.argv) > 2:
        img_path = sys.argv[1]
        out_dir = sys.argv[2]

        total_q = 60
        cols = 3

        # 🌟 স্মার্ট OMR কোড ডিকোডিং (১ বাদ দেওয়ার লজিক) 🌟
        if len(sys.argv) > 3:
            arg3 = sys.argv[3]

            if arg3.isdigit() and len(arg3) >= 4 and arg3[:2] in ['12', '13', '14']:
                prefix = arg3[:2]
                if prefix == '12': cols = 2
                elif prefix == '13': cols = 3
                elif prefix == '14': cols = 4

                q_part_str = arg3[2:]

                if q_part_str.startswith('1') and len(q_part_str) > 1:
                    total_q = int(q_part_str[1:])
                else:
                    total_q = int(q_part_str)
            else:
                try:
                    total_q = int(arg3)
                except ValueError:
                    total_q = 60
                cols = int(sys.argv[4]) if len(sys.argv) > 4 else 3

        print(process_omr(img_path, out_dir, total_q, cols))
    else:
        print(json.dumps({"error": "No image path provided!"}))
