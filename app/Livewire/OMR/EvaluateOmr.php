<?php

namespace App\Livewire\OMR;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\OmrToken;
use Symfony\Component\Process\Process;

class EvaluateOmr extends Component
{
    use WithFileUploads;

    public $tokenId;
    public $omrImage;
    public $result = null;

    /**
     * ওএমআর খাতা স্ক্যান এবং সরাসরি পাবলিক ডিস্কে সংরক্ষণ করে মূল্যায়ন
     */
    public function evaluate() {
        // ১. ইনপুট ভ্যালিডেশন
        $this->validate([
            'tokenId' => 'required|exists:omr_tokens,token_id',
            'omrImage' => 'required|image|max:4096',
        ]);

        $token = OmrToken::where('token_id', $this->tokenId)->first();
        $template = $token->template;

        try {
            // ২. ইউনিক ফাইল নেম তৈরি করা
            $fileName = time() . '_' . $this->omrImage->getClientOriginalName();

            // 🌟 লারাভেলের ডিফল্ট পাবলিক ডিস্কের মাধ্যমে সরাসরি ফাইল আপলোড করা (কোনো পারমিশন ইস্যু হবে না)
            // এটি ফাইলটিকে সরাসরি 'storage/app/public/omr_scans' এ সেভ করবে
            $this->omrImage->storeAs('omr_scans', $fileName, 'public');

            // ৩. ফাইলটির রিয়েল পাথ নির্ধারণ করা
            $realPath = storage_path('app/public/omr_scans/' . $fileName);
            $destinationPath = storage_path('app/public/omr_scans');

            // যদি স্টোরেজ ফোল্ডারটি পাবলিক ডিস্কে তৈরি হতে না পারে, তবে একদম সরাসরি পাবলিক ফোল্ডারে সেভ করবে 🌟
            if (!file_exists($realPath)) {
                $destinationPath = public_path('storage/omr_scans');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                // ফিজিক্যালি মুভ করা
                move_uploaded_file($this->omrImage->getRealPath(), $destinationPath . '/' . $fileName);
                $realPath = $destinationPath . '/' . $fileName;
            }

        } catch (\Exception $e) {
            $this->addError('omrImage', 'আপলোড এরর: ' . $e->getMessage());
            return;
        }

        // ৪. ওএমআর টোকেনের সঠিক উত্তরপত্র জেসন আকারে এনকোড করা
        $correctAnswersJson = json_encode($token->answer_key);

        // ৫. পাইথন প্রসেস কল করা
        $process = new Process([
            'python3',
            base_path('scripts/omr_scanner.py'),
            $realPath,
            $destinationPath, // রেজাল্ট ইমেজ সেভ করার ডিরেক্টরি
            $template->total_questions,
            $template->columns,
            $correctAnswersJson
        ]);

        $process->setTimeout(60);
        $process->run();

        // ৬. সিস্টেম লেভেলের কোনো ব্লকিং এরর আছে কি না চেক করা
        if (!$process->isSuccessful()) {
            $this->addError('omrImage', 'পাইথন রান হতে পারেনি! সিস্টেম এরর: ' . $process->getErrorOutput());
            return;
        }

        $rawOutput = $process->getOutput();
        $output = json_decode($rawOutput, true);

        // ৭. পাইথনের রিটার্ন করা JSON খালি কি না চেক করা
        if (is_null($output)) {
            $this->addError('omrImage', 'স্ক্যানের ফলাফল প্রসেস করা যায়নি। র-আউটপুট: ' . $rawOutput);
            return;
        }

        // ৮. ওএমআর ডিটেকশন ট্রাবলশুটিং চেক
        if (isset($output['error']) || !isset($output['answers'])) {
            $errorMessage = $output['error'] ?? 'ওএমআর বৃত্ত বা কালো বার সনাক্ত করা যায়নি।';
            $this->addError('omrImage', 'স্ক্যান এরর: ' . $errorMessage);
            return;
        }

        // ৯. সফলভাবে স্ক্যান শেষ হলে লুপ শুরু করা
        $studentAnswers = $output['answers'];
        $correctAnswers = $token->answer_key;

        $correct = 0;
        $wrong = 0;
        $blank = 0;

        for ($q = 1; $q <= $token->total_questions; $q++) {
            $questionKey = (string)$q;

            $studentAns = $studentAnswers[$questionKey] ?? 'N/A';
            $correctAns = $correctAnswers[$questionKey] ?? '';

            if ($studentAns === 'N/A' || empty($studentAns)) {
                $blank++;
            } elseif ($studentAns === $correctAns) {
                $correct++;
            } else {
                $wrong++;
            }
        }

        // প্রাপ্ত নম্বর ও রেজাল্ট ক্যালকুলেশন
        $obtained = ($correct * $token->correct_mark) - ($wrong * $token->negative_mark);

        // জেনারেট হওয়া রেজাল্ট ইমেজসহ সম্পূর্ণ ডাটা ব্লেড ভিউতে পাঠানো
        $this->result = [
            'exam_name' => $token->title,
            'total_questions' => $token->total_questions,
            'correct' => $correct,
            'wrong' => $wrong,
            'blank' => $blank,
            'obtained' => max(0, $obtained),
            'result_image' => $output['result_image']
        ];
    }

    public function render() {
        return view('livewire.omr.evaluate-omr', [
            'tokens' => OmrToken::all()
        ]);
    }
}
