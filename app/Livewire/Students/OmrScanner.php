<?php

namespace App\Livewire\Students;

use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\Process\Process;

class OmrScanner extends Component
{
    use WithFileUploads;

    public $omrImage;
    public $scanResult = null;

    protected $rules = [
        'omrImage' => 'required|image|mimes:jpeg,png,jpg|max:5120',
    ];

    public function processOmr()
    {
        $this->validate();
        $this->scanResult = null;

        // ১. Livewire এর টেম্পোরারি ফাইল পাথ সরাসরি নেওয়া (store বা unlink করার দরকার নেই)
        $fullPath = $this->omrImage->getRealPath();
        $fullPath = str_replace('\\', '/', $fullPath);

        // ২. Python স্ক্রিপ্টের পাথ
        $scriptPath = str_replace('\\', '/', base_path('scripts/omr_scanner.py'));

        // ৩. Python কে কল করা (প্রয়োজনে python এর বদলে python3 বা py ব্যবহার করবেন)
        $process = new \Symfony\Component\Process\Process(['python3', $scriptPath, $fullPath]);
        $process->run();

        // ৪. সফল না হলে এরর দেখানো
        if (!$process->isSuccessful()) {
            $this->addError('omrImage', 'স্ক্রিপ্ট রান করতে সমস্যা হয়েছে: ' . $process->getErrorOutput());
            return;
        }

        // ৫. Python থেকে আসা JSON রেজাল্ট পড়া
        $output = json_decode($process->getOutput(), true);

        // ৬. পাইথন কোনো এরর দিলে সেটা দেখানো
        if (isset($output['error'])) {
            $this->addError('omrImage', 'স্ক্যান এরর: ' . $output['error']);
            return;
        }

        // ৭. স্ক্যান সাকসেসফুল হলে রেজাল্ট প্রপার্টিতে সেভ করা
        $this->scanResult = $output['answers'];
        $this->dispatch('success', ['message' => 'OMR সফলভাবে স্ক্যান করা হয়েছে!']);
    }

    public function render()
    {
        return view('livewire.students.omr-scanner')->layout('layouts.app', ['title' => 'OMR Scanner']);
    }
}
