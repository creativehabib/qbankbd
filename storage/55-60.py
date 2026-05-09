import cv2
import numpy as np
import sys
import json
import os

def process_omr(image_path, total_questions=60, columns=4, expected_options=4):
    try:
        if not os.path.exists(image_path):
            return json.dumps({"error": "ফাইলটি পাওয়া যায়নি!"})

        # ১. ইমেজ লোড করা
        stream = open(image_path, "rb")
        bytes_array = bytearray(stream.read())
        numpy_array = np.asarray(bytes_array, dtype=np.uint8)
        image = cv2.imdecode(numpy_array, cv2.IMREAD_COLOR)

        if image is None:
            return json.dumps({"error": "ইমেজটি রিড করা যায়নি!"})

        # ২. ইমেজের প্রসেসিং (গ্রে-স্কেল এবং শক্তিশালী ডাইনামিক বাইনারি থ্রেশহোল্ড)
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

        # ডিজিটাল ফাইলের জন্য পারফেক্ট ব্ল্যাক অ্যান্ড হোয়াইট তৈরি
        thresh = cv2.threshold(gray, 0, 255, cv2.THRESH_BINARY_INV | cv2.THRESH_OTSU)[1]

        # ৩. বৃত্ত খোঁজার জন্য ক্লোজিং অপারেশন (ভেতরের ক/খ/গ/ঘ লেখা মুছে শুধু বৃত্তটাকে সলিড করার ম্যাজিক 🌟)
        kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
        thresh = cv2.morphologyEx(thresh, cv2.MORPH_CLOSE, kernel)

        # ৪. বৃত্ত খোঁজা (Contours)
        cnts, _ = cv2.findContours(thresh.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

        bubbles = []
        for c in cnts:
            x, y, w, h = cv2.boundingRect(c)
            ar = w / float(h)

            # 🌟 হাই-রেজোলিউশন ইমেজের জন্য সাইজ লিমিট ৫ পিক্সেল থেকে বাড়িয়ে ১২০ পিক্সেল করা হলো 🌟
            if 5 <= w <= 120 and 5 <= h <= 120 and 0.5 <= ar <= 1.5:
                bubbles.append({
                    'contour': c,
                    'cx': x + w // 2,
                    'cy': y + h // 2,
                    'x': x, 'y': y, 'w': w, 'h': h
                })

        # সেফটি চেক লিমিট ৭০ করা হলো (কারণ ৬০টি প্রশ্নে ৪টি অপশন করে ২৪০টি বৃত্ত পাওয়ার কথা)
        if len(bubbles) < 70:
            return json.dumps({"error": f"পর্যাপ্ত বৃত্ত পাওয়া যায়নি! মাত্র {len(bubbles)} টি ডিটেক্ট হয়েছে।"})

        # ৫. কলাম বিভক্তিকরণ (X-অক্ষের রেঞ্জ অনুযায়ী নিখুঁত ভাগ)
        bubbles.sort(key=lambda b: b['cx'])

        x_coords = [b['cx'] for b in bubbles]
        min_x = min(x_coords)
        max_x = max(x_coords)
        col_width = (max_x - min_x) / (columns - 1)

        col_groups = [[] for _ in range(columns)]
        for b in bubbles:
            col_idx = int((b['cx'] - min_x + (col_width / 2)) / col_width)
            if col_idx >= columns:
                col_idx = columns - 1
            col_groups[col_idx].append(b)

        results = {}
        questions_per_col = total_questions // columns

        # ৬. প্রতিটি কলামের সারি প্রসেস করা
        for col_idx, col_bubbles in enumerate(col_groups):
            if not col_bubbles:
                continue

            # উপর থেকে নিচে সাজানো
            col_bubbles.sort(key=lambda b: b['cy'])

            # ১৫টি সারিতে গ্রুপ করা
            rows = []
            current_row = [col_bubbles[0]]
            for i in range(1, len(col_bubbles)):
                if abs(col_bubbles[i]['cy'] - current_row[-1]['cy']) < 20: # গ্যাপ লিমিট ২০ পিক্সেল
                    current_row.append(col_bubbles[i])
                else:
                    rows.append(current_row)
                    current_row = [col_bubbles[i]]
            rows.append(current_row)

            # সারিগুলোকে উপর থেকে নিচে সাজানো
            rows.sort(key=lambda r: r[0]['cy'])

            for row_idx, row in enumerate(rows):
                if len(row) < expected_options:
                    continue

                row.sort(key=lambda b: b['cx'])

                # যদি ৫টি বৃত্ত থাকে (প্রশ্ন নম্বর সহ), প্রথমটি বাদ দিয়ে শেষ ৪টি অপশন নেওয়া
                options = row[-expected_options:]

                # প্রতিটি অপশনের ভেতরের অংশের রিলেটিভ অন্ধকার বা কালচে ভাব চেক করা
                darkness_values = []
                for b in options:
                    # বর্ডারের কালো দাগ এড়াতে ভেতরের ৬০% অংশ নেওয়া হচ্ছে (প্যাডিং)
                    pad_w = int(b['w'] * 0.2)
                    pad_h = int(b['h'] * 0.2)
                    roi = gray[b['y']+pad_h : b['y']+b['h']-pad_h, b['x']+pad_w : b['x']+b['w']-pad_w]

                    mean_val = cv2.mean(roi)[0]
                    darkness_values.append(mean_val)

                # সবচেয়ে কালচে (কম ব্রাইটনেস) বৃত্তের ইনডেক্স বের করা
                bubbled = np.argmin(darkness_values)
                min_val = darkness_values[bubbled]

                # বাকি ৩টি বৃত্তের গড় উজ্জ্বলতা
                other_vals = [darkness_values[idx] for idx in range(len(darkness_values)) if idx != bubbled]
                avg_others = np.mean(other_vals)

                # 🌟 থ্রেশহোল্ড চেক: ভরাট করা বৃত্তটি অন্য ফাঁকা বৃত্তগুলোর চেয়ে অন্তত ১৫ ইউনিট বেশি অন্ধকার হতে হবে
                if avg_others - min_val > 15:
                    actual_q_num = (col_idx * questions_per_col) + row_idx + 1
                    results[str(actual_q_num)] = bubbled

        # ফলাফল A, B, C, D ফরম্যাটে সাজানো
        formatted_answers = {}
        for q in range(1, total_questions + 1):
            val = results.get(str(q), None)
            if val is not None:
                char_map = {0: 'A', 1: 'B', 2: 'C', 3: 'D'}
                formatted_answers[str(q)] = char_map.get(val, 'N/A')
            else:
                formatted_answers[str(q)] = 'N/A'

        return json.dumps({
            "status": "success",
            "answers": formatted_answers,
            "total_detected": len(bubbles)
        })

    except Exception as e:
        return json.dumps({"error": str(e)})

if __name__ == "__main__":
    if len(sys.argv) > 1:
        print(process_omr(sys.argv[1]))
    else:
        print(json.dumps({"error": "No image path provided!"}))
