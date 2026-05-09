import cv2
import numpy as np
import sys
import json
import os

def process_omr(image_path, num_questions=10, choices_per_question=4):
    try:
        # ১. পাথ চেক করা (ফাইলটি আসলেই আছে কিনা)
        if not os.path.exists(image_path):
            return json.dumps({"error": f"ফাইলটি এই পাথে পাওয়া যায়নি: {image_path}"})

        # ২. ইমেজ লোড করা (OpenCV এর Unicode/Space বাগ ফিক্স করতে numpy ব্যবহার করা হলো)
        stream = open(image_path, "rb")
        bytes_array = bytearray(stream.read())
        numpy_array = np.asarray(bytes_array, dtype=np.uint8)
        image = cv2.imdecode(numpy_array, cv2.IMREAD_COLOR)

        if image is None:
            return json.dumps({"error": "ইমেজটি রিড করা যায়নি! ফাইলটি করাপ্টেড হতে পারে।"})

        # ৩. ইমেজের প্রিপ্রসেসিং (সাদাকালো এবং ব্লার করা)
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        blurred = cv2.GaussianBlur(gray, (5, 5), 0)
        edged = cv2.Canny(blurred, 75, 200)

        # ৪. বৃত্ত (Contours) খোঁজা
        cnts, _ = cv2.findContours(edged.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

        # OMR এর বৃত্তগুলো আলাদা করা
        question_cnts = []
        for c in cnts:
            (x, y, w, h) = cv2.boundingRect(c)
            ar = w / float(h)
            # একটি বৃত্তের সাধারণ সাইজ এবং অনুপাত চেক করা হচ্ছে (প্রয়োজনে w >= 15 করতে পারেন)
            if w >= 20 and h >= 20 and ar >= 0.9 and ar <= 1.1:
                question_cnts.append(c)

        # বৃত্তগুলোকে ওপর থেকে নিচে সাজানো (প্রতিটি প্রশ্নের জন্য)
        if len(question_cnts) > 0:
            question_cnts = sorted(question_cnts, key=lambda c: cv2.boundingRect(c)[1])
        else:
            return json.dumps({"error": "কোনো OMR বৃত্ত খুঁজে পাওয়া যায়নি! ছবিটি পরিষ্কার হতে হবে।"})

        results = {}

        # ৫. প্রতিটি প্রশ্নের জন্য বৃত্তগুলো চেক করা
        for (q, i) in enumerate(np.arange(0, len(question_cnts), choices_per_question)):

            # একটি প্রশ্নের সব অপশন নেওয়া এবং বাম থেকে ডানে সাজানো
            cnts_row = sorted(question_cnts[i:i + choices_per_question], key=lambda c: cv2.boundingRect(c)[0])

            bubbled = None
            max_pixels = 0

            # প্রতিটি বৃত্তের ভেতরে কালো পিক্সেল গোনা
            for (j, c) in enumerate(cnts_row):
                mask = np.zeros(gray.shape, dtype="uint8")
                cv2.drawContours(mask, [c], -1, 255, -1)

                thresh = cv2.threshold(gray, 0, 255, cv2.THRESH_BINARY_INV | cv2.THRESH_OTSU)[1]
                mask = cv2.bitwise_and(thresh, thresh, mask=mask)
                total = cv2.countNonZero(mask)

                if total > max_pixels:
                    max_pixels = total
                    bubbled = j

            if bubbled is not None:
                results[str(q + 1)] = bubbled

        return json.dumps({
            "status": "success",
            "answers": results,
            "total_detected": len(question_cnts)
        })

    except Exception as e:
        return json.dumps({"error": str(e)})

if __name__ == "__main__":
    if len(sys.argv) > 1:
        img_path = sys.argv[1]
        print(process_omr(img_path))
    else:
        print(json.dumps({"error": "ইমেজ পাথ দেওয়া হয়নি!"}))
