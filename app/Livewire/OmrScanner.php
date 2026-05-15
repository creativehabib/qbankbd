<?php

namespace App\Livewire;

use App\Models\AnswerKey;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class OmrScanner extends Component
{
    use WithFileUploads;

    public $photo;

    // 🌟 এখন আর কোনো Path সেভ রাখার দরকার নেই, শুধু Base64 কোড থাকবে
    public $scannedImageUrl;

    public int $totalQuestions = 20;
    public float $negativeMark = 0;
    public array $correctAnswers = [];
    public array $scannedAnswers = [];
    public array $stats = [];
    public bool $isScanning = false;

    public function mount(): void
    {
        $savedKey = AnswerKey::first();
        if ($savedKey) {
            $this->totalQuestions = $savedKey->total_questions;
            $dbAnswers = json_decode($savedKey->answers, true);
            if (is_array($dbAnswers)) {
                $this->correctAnswers = $dbAnswers;
            }
        }
    }

    public function toggleAnswer($questionNumber, $option): void
    {
        if (isset($this->correctAnswers[$questionNumber]) && $this->correctAnswers[$questionNumber] === $option) {
            unset($this->correctAnswers[$questionNumber]);
        } else {
            $this->correctAnswers[$questionNumber] = $option;
        }
    }

    public function saveAnswers(): void
    {
        $cleanedAnswers = [];
        for ($i = 1; $i <= $this->totalQuestions; $i++) {
            if (isset($this->correctAnswers[$i])) {
                $cleanedAnswers[$i] = $this->correctAnswers[$i];
            }
        }

        $this->correctAnswers = $cleanedAnswers;

        AnswerKey::updateOrCreate(
            ['id' => 1],
            [
                'total_questions' => $this->totalQuestions,
                'answers' => json_encode($this->correctAnswers),
            ]
        );
        session()->flash('message', 'সঠিক উত্তরপত্র সফলভাবে ডাটাবেজে সেভ হয়েছে!');
    }

    public function scanOmr(): void
    {
        $this->validate([
            'photo' => 'required|file|max:10240|mimes:jpg,jpeg,png,pdf',
        ]);

        $this->isScanning = true;

        try {
            // 🌟 ম্যাজিক: File কোথাও সেভ না করে লাইভওয়্যারের Temporary Path ব্যবহার করা হচ্ছে 🌟
            $absolutePath = $this->photo->getRealPath();
            $tempPdfConvertedPath = null;

            $extension = strtolower($this->photo->getClientOriginalExtension());
            if ($extension === 'pdf') {
                // PDF হলে সাময়িক ফোল্ডারে (tmp) একটি ছবি বানাবে
                $tempPdfConvertedPath = sys_get_temp_dir() . '/' . uniqid('pdf_') . '.jpg';
                $command = 'convert -density 300 '.escapeshellarg($absolutePath).'[0] -quality 90 '.escapeshellarg($tempPdfConvertedPath);
                exec($command);

                if (file_exists($tempPdfConvertedPath)) {
                    $absolutePath = $tempPdfConvertedPath;
                } else {
                    throw new \Exception('PDF কে Image এ কনভার্ট করা যায়নি।');
                }
            }

            $process = new Process([
                '/usr/bin/python3',
                base_path('scripts/omr_scanner.py'),
                $absolutePath,
                $this->totalQuestions,
                0,
                json_encode($this->correctAnswers),
            ]);

            $process->setTimeout(60);
            $process->run();

            // 🌟 কাজ শেষে PDF এর সাময়িক ছবিটাও সাথে সাথে ডিলিট 🌟
            if ($tempPdfConvertedPath && file_exists($tempPdfConvertedPath)) {
                unlink($tempPdfConvertedPath);
            }

            if (! $process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $output = $process->getOutput();
            $result = json_decode($output, true);

            if (isset($result['error'])) {
                $this->addError('scan', $result['error']);
                $this->isScanning = false;
                return;
            }

            $this->scannedAnswers = $result['answers'] ?? [];

            // 🌟 পাইথনের পাঠানো Base64 কোড সরাসরি ভেরিয়েবলে সেট করা হলো 🌟
            if (isset($result['result_image_base64'])) {
                $this->scannedImageUrl = $result['result_image_base64'];
            }

            $correct = 0;
            $wrong = 0;
            $unanswered = 0;

            for ($i = 1; $i <= $this->totalQuestions; $i++) {
                $studentAns = $this->scannedAnswers[(string) $i] ?? 'N/A';
                $correctAns = $this->correctAnswers[$i] ?? null;

                if ($studentAns === 'N/A' || $studentAns === null) {
                    $unanswered++;
                } elseif ($studentAns === $correctAns) {
                    $correct++;
                } else {
                    $wrong++;
                }
            }

            $score = $correct - ($wrong * $this->negativeMark);

            $this->stats = [
                'total' => $this->totalQuestions,
                'correct' => $correct,
                'wrong' => $wrong,
                'unanswered' => $unanswered,
                'score' => max(0, $score),
            ];

        } catch (\Exception $e) {
            $this->addError('scan', 'স্ক্যানিং ব্যর্থ হয়েছে: '.$e->getMessage());
        }

        $this->isScanning = false;
    }

    public function removePhoto()
    {
        // 🌟 সার্ভারে কোনো ফাইলই নেই, তাই শুধু ভেরিয়েবল রিসেট করলেই হবে 🌟
        $this->reset(['photo', 'scannedImageUrl', 'scannedAnswers', 'stats']);
    }

    public function render()
    {
        return view('livewire.omr-scanner')->layout('layouts.app', ['title' => 'OMR Scanner']);
    }
}
