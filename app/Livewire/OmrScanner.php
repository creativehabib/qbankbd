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

    public $scannedImageUrl;

    public int $totalQuestions = 20;

    public float $negativeMark = 0;

    public array $correctAnswers = [];

    public array $scannedAnswers = [];

    public array $stats = [];

    public bool $isScanning = false;

    public function mount()
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

    public function toggleAnswer($questionNumber, $option)
    {
        if (isset($this->correctAnswers[$questionNumber]) && $this->correctAnswers[$questionNumber] === $option) {
            unset($this->correctAnswers[$questionNumber]);
        } else {
            $this->correctAnswers[$questionNumber] = $option;
        }
    }

    public function saveAnswers()
    {
        // 🌟 ম্যাজিক লজিক: ইউজার যেই কয়টি প্রশ্ন সিলেক্ট করবে, শুধু সেই কয়টির উত্তরই রাখা হবে।
        // যদি আগে ৬০টি প্রশ্নের উত্তর সেভ করা থাকে, আর এখন ২০ সিলেক্ট করে সেভ দেওয়া হয়,
        // তবে ২১ থেকে ৬০ পর্যন্ত সব উত্তর ডাটাবেজ থেকে চিরতরে মুছে যাবে।
        $cleanedAnswers = [];
        for ($i = 1; $i <= $this->totalQuestions; $i++) {
            if (isset($this->correctAnswers[$i])) {
                $cleanedAnswers[$i] = $this->correctAnswers[$i];
            }
        }

        $this->correctAnswers = $cleanedAnswers; // লাইভওয়্যার অ্যারেটি আপডেট করা হলো

        AnswerKey::updateOrCreate(
            ['id' => 1],
            [
                'total_questions' => $this->totalQuestions,
                'answers' => json_encode($this->correctAnswers),
            ]
        );
        session()->flash('message', 'সঠিক উত্তরপত্র সফলভাবে ডাটাবেজে সেভ হয়েছে!');
    }

    public function scanOmr()
    {
        $this->validate([
            'photo' => 'required|file|max:10240|mimes:jpg,jpeg,png,pdf',
        ]);

        $this->isScanning = true;

        try {
            $imagePath = $this->photo->store('omr_uploads', 'public');
            $absolutePath = storage_path('app/public/'.$imagePath);
            $outputDir = storage_path('app/public/omr_scans');

            if (! file_exists($outputDir)) {
                mkdir($outputDir, 0777, true);
            }

            // 🌟 PDF to JPG Conversion (ImageMagick) 🌟
            $extension = strtolower($this->photo->getClientOriginalExtension());
            if ($extension === 'pdf') {
                $jpgPath = storage_path('app/public/omr_uploads/'.uniqid('pdf_').'.jpg');
                $command = 'convert -density 300 '.escapeshellarg($absolutePath).'[0] -quality 90 '.escapeshellarg($jpgPath);
                exec($command);

                if (file_exists($jpgPath)) {
                    $absolutePath = $jpgPath;
                } else {
                    throw new \Exception('PDF কে Image এ কনভার্ট করা যায়নি। সার্ভারে ImageMagick ইন্সটল করা আছে কি না চেক করুন।');
                }
            }

            $cols = 0;

            $process = new Process([
                '/usr/bin/python3', // আপনার লাইভ সার্ভারের পাথ
                base_path('scripts/omr_scanner.py'),
                $absolutePath,
                $outputDir,
                $this->totalQuestions,
                $cols, // 0 পাঠানো হচ্ছে, যাতে পাইথন নিজের অটো-ডিটেকশন ব্যবহার করে
                json_encode($this->correctAnswers),
            ]);

            $process->setTimeout(60);
            $process->run();

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
            if (isset($result['result_image'])) {
                $this->scannedImageUrl = asset($result['result_image']);
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
        $this->reset(['photo', 'scannedImageUrl', 'scannedAnswers', 'stats']);
    }

    public function render()
    {
        return view('livewire.omr-scanner')->layout('layouts.app', ['title' => 'OMR Scanner']);
    }
}
