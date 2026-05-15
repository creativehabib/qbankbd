import cv2
import numpy as np
import sys
import json
import os
import time
import base64 # 🌟 Base64 ইম্পোর্ট করা হলো

# 🌟 output_dir বাদ দিয়ে answer_key_json রিসিভ করার ব্যবস্থা করা হলো
def process_omr(image_path, fallback_total_q=60, fallback_cols=3, expected_options=4, answer_key_json="{}"):
    try:
        if not os.path.exists(image_path):
            return json.dumps({"error": "ফাইলটি পাওয়া যায়নি!"})

        stream = open(image_path, "rb")
        bytes_array = bytearray(stream.read())
        numpy_array = np.asarray(bytes_array, dtype=np.uint8)
        image = cv2.imdecode(numpy_array, cv2.IMREAD_COLOR)

        if image is None:
            return json.dumps({"error": "ইমেজটি রিড করা যায়নি!"})

        target_width = 1200
        target_height = 1600
        image = cv2.resize(image, (target_width, target_height), interpolation=cv2.INTER_AREA)
        display_image = image.copy()

        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        thresh = cv2.threshold(gray, 200, 255, cv2.THRESH_BINARY_INV)[1]

        cnts, _ = cv2.findContours(thresh.copy(), cv2.RETR_LIST, cv2.CHAIN_APPROX_SIMPLE)

        bars = []
        bubbles = []

        border_rect = (0, 0, target_width, target_height)
        max_area = 0
        for c in cnts:
            x, y, w, h = cv2.boundingRect(c)
            area = w * h
            if area > (target_width * target_height * 0.4) and area < (target_width * target_height * 0.95):
                if area > max_area:
                    max_area = area
                    border_rect = (x, y, w, h)

        bx, by, bw, bh = border_rect

        for c in cnts:
            x, y, w, h = cv2.boundingRect(c)
            ar = w / float(h)

            if x > bx and y > by and (x+w) < (bx+bw) and (y+h) < (by+bh):
                if y < (by + 300) and 10 <= w <= 50 and 30 <= h <= 100 and 0.2 <= ar <= 0.8:
                    mask = np.zeros(thresh.shape, dtype="uint8")
                    cv2.drawContours(mask, [c], -1, 255, -1)
                    total_pixels = cv2.countNonZero(cv2.bitwise_and(thresh, thresh, mask=mask))
                    if total_pixels / float(w * h) > 0.6:
                        bars.append({'x': x, 'y': y, 'w': w, 'h': h, 'cx': x + w // 2, 'cy': y + h // 2})

                elif 15 <= w <= 50 and 15 <= h <= 50 and 0.75 <= ar <= 1.25:
                    bubbles.append({
                        'contour': c, 'cx': x + w // 2, 'cy': y + h // 2,
                        'x': x, 'y': y, 'w': w, 'h': h
                    })

        detected_cols = fallback_cols
        detected_questions = fallback_total_q
        first_anchor_y = by + 200

        if len(bars) > 0:
            bars.sort(key=lambda b: b['cx'])
            groups = []
            current_group = [bars[0]]
            for i in range(1, len(bars)):
                gap = bars[i]['x'] - (bars[i-1]['x'] + bars[i-1]['w'])
                if gap > 30:
                    groups.append(current_group)
                    current_group = [bars[i]]
                else:
                    current_group.append(bars[i])
            groups.append(current_group)

            if len(groups) >= 4:
                detected_cols = len(groups[1])
                detected_questions = len(groups[3]) * 10

            first_anchor_y = max([b['y'] + b['h'] for b in bars]) + 20

            cv2.putText(display_image, f"Visual Decode: {detected_cols} Cols, {detected_questions} Qs",
                        (bx + 20, by - 20), cv2.FONT_HERSHEY_SIMPLEX, 1, (255, 0, 0), 2)

        unique_bubbles = []
        seen_points = set()
        for b in bubbles:
            if b['cy'] > first_anchor_y:
                point_key = (b['cx'] // 8, b['cy'] // 8)
                if point_key not in seen_points:
                    seen_points.add(point_key)
                    unique_bubbles.append(b)
        bubbles = unique_bubbles

        if len(bubbles) < 10:
            return json.dumps({"error": "পর্যাপ্ত ওএমআর বৃত্ত ডিটেক্ট করা যায়নি!"})

        bubbles.sort(key=lambda b: b['cx'])
        left_anchor = bubbles[0]['cx']
        right_anchor = bubbles[-1]['cx']
        span = right_anchor - left_anchor

        if detected_cols <= 0:
            detected_cols = fallback_cols if fallback_cols > 0 else 3

        col_width = span / detected_cols

        col_groups = [[] for _ in range(detected_cols)]
        for b in bubbles:
            relative_x = b['cx'] - left_anchor
            col_idx = int(relative_x / col_width)
            if col_idx < 0: col_idx = 0
            if col_idx >= detected_cols: col_idx = detected_cols - 1
            col_groups[col_idx].append(b)

        results = {}

        questions_per_col = int(np.ceil(detected_questions / detected_cols))

        char_map = {0: 'A', 1: 'B', 2: 'C', 3: 'D'}

        for col_idx, col_bubbles in enumerate(col_groups):
            if len(col_bubbles) < 10: continue

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

            clean_rows = [r for r in rows if len(r) >= 2]

            perfect_rows = [r for r in clean_rows if len(r) >= expected_options]
            if len(perfect_rows) > 0:
                for r in perfect_rows:
                    r.sort(key=lambda b: b['cx'])
                slot_cx = [np.mean([r[i]['cx'] for r in perfect_rows]) for i in range(expected_options)]
            else:
                clean_rows[0].sort(key=lambda b: b['cx'])
                slot_cx = [b['cx'] for b in clean_rows[0]]
                while len(slot_cx) < expected_options:
                    slot_cx.append(slot_cx[-1] + 35)

            valid_rows = []
            for r in clean_rows:
                mapped_options = [{'missing': True}] * expected_options
                for b in r:
                    distances = [abs(b['cx'] - scx) for scx in slot_cx]
                    best_slot = np.argmin(distances)
                    if mapped_options[best_slot].get('missing'):
                        mapped_options[best_slot] = b
                valid_rows.append(mapped_options)

            for row_idx, options in enumerate(valid_rows):
                if row_idx >= questions_per_col:
                    break

                fill_percentages = []
                valid_bubble_indices = []

                for opt_idx, b in enumerate(options):
                    if b.get('missing'):
                        fill_percentages.append(0)
                        continue

                    pad_w = int(b['w'] * 0.15)
                    pad_h = int(b['h'] * 0.15)

                    roi_thresh = thresh[b['y']+pad_h : b['y']+b['h']-pad_h, b['x']+pad_w : b['x']+b['w']-pad_w]

                    filled_pixels = cv2.countNonZero(roi_thresh)
                    total_pixels = roi_thresh.shape[0] * roi_thresh.shape[1]

                    fill_ratio = (filled_pixels / float(total_pixels)) * 100 if total_pixels > 0 else 0

                    fill_percentages.append(fill_ratio)
                    valid_bubble_indices.append(opt_idx)

                actual_q_num = (col_idx * questions_per_col) + row_idx + 1

                if len(valid_bubble_indices) == 0:
                    results[str(actual_q_num)] = {"option_idx": -1, "all_options": options}
                    continue

                bubbled = np.argmin([-val for val in fill_percentages])
                max_fill = fill_percentages[bubbled]

                if max_fill > 55:
                    other_fills = [fill_percentages[idx] for idx in valid_bubble_indices if idx != bubbled]
                    second_max = max(other_fills) if len(other_fills) > 0 else 0

                    if (max_fill - second_max) > 15:
                        results[str(actual_q_num)] = {"option_idx": int(bubbled), "all_options": options}
                    else:
                        results[str(actual_q_num)] = {"option_idx": -1, "all_options": options}
                else:
                    results[str(actual_q_num)] = {"option_idx": -1, "all_options": options}

        # 🌟 sys.argv[5] এর বদলে প্যারামিটার থেকে JSON পড়া হচ্ছে
        correct_answers_dict = {}
        try:
            correct_answers_dict = json.loads(answer_key_json)
        except:
            pass

        logical_limit = detected_questions
        if correct_answers_dict and len(correct_answers_dict) > 0:
            logical_limit = len(correct_answers_dict)

        formatted_answers = {}
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
                    if opt.get('missing'): continue

                    if idx == student_idx and student_idx == correct_idx:
                        cv2.circle(display_image, (opt['cx'], opt['cy']), int(opt['w'] // 1.6), (0, 200, 0), 4)
                    elif idx == student_idx and student_idx != correct_idx:
                        cv2.circle(display_image, (opt['cx'], opt['cy']), int(opt['w'] // 1.6), (0, 0, 255), 4)
                    elif idx == correct_idx:
                        cv2.circle(display_image, (opt['cx'], opt['cy']), int(opt['w'] // 1.6), (0, 200, 0), 4)
            else:
                formatted_answers[q_str] = 'N/A'

        # 🌟 ম্যাজিক: File সেভ না করে Image কে সরাসরি Base64 স্ট্রিংয়ে কনভার্ট করা হচ্ছে 🌟
        _, buffer = cv2.imencode('.jpg', display_image, [int(cv2.IMWRITE_JPEG_QUALITY), 80])
        base64_image = base64.b64encode(buffer).decode('utf-8')
        image_data_uri = f"data:image/jpeg;base64,{base64_image}"

        return json.dumps({
            "status": "success",
            "answers": formatted_answers,
            "detected_columns": detected_cols,
            "detected_questions": detected_questions,
            "result_image_base64": image_data_uri
        })

    except Exception as e:
        return json.dumps({"error": str(e)})

# 🌟 লারাভেল থেকে আসা ৪টি ডাটা সঠিকভাবে রিসিভ করার কোড 🌟
if __name__ == "__main__":
    if len(sys.argv) > 1:
        img_path = sys.argv[1]
        total_q = 60
        cols = 3
        answer_key = "{}"

        # sys.argv[2] হলো মোট প্রশ্ন ($this->totalQuestions)
        if len(sys.argv) > 2:
            try: total_q = int(sys.argv[2])
            except: pass

        # sys.argv[3] হলো কলাম সংখ্যা (লারাভেল থেকে 0 বা 3 পাঠানো হচ্ছে)
        if len(sys.argv) > 3:
            try: cols = int(sys.argv[3])
            except: pass

        # sys.argv[4] হলো JSON Answer Key
        if len(sys.argv) > 4:
            answer_key = sys.argv[4]

        print(process_omr(img_path, total_q, cols, 4, answer_key))
    else:
        print(json.dumps({"error": "No image path provided!"}))
