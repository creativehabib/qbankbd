<?php

namespace App\Livewire\Teacher;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class InstitutionInfo extends Component
{
    public string $institutionName = '';

    public string $institutionType = '';

    public string $institutionAddress = '';

    public function mount(): void
    {
        abort_unless(auth()->user()?->isTeacher(), 403);

        $this->institutionName = (string) auth()->user()->institution_name;
        $this->institutionType = (string) auth()->user()->institution_type;
        $this->institutionAddress = (string) auth()->user()->institution_address;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'institutionName' => ['required', 'string', 'max:255'],
            'institutionType' => ['required', 'string', 'max:255'],
            'institutionAddress' => ['required', 'string', 'max:1000'],
        ]);

        auth()->user()->update([
            'institution_name' => $validated['institutionName'],
            'institution_type' => $validated['institutionType'],
            'institution_address' => $validated['institutionAddress'],
        ]);

        session()->flash('success', 'প্রতিষ্ঠানের তথ্য সফলভাবে আপডেট হয়েছে।');
    }

    public function render(): View
    {
        return view('livewire.teacher.institution-info');
    }
}
