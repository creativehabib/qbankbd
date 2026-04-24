<?php

namespace App\Livewire;

use Livewire\Component;

class OmrGenerator extends Component
{
    // ডিফল্ট ভ্যালু
    public string $schoolName = 'গাজীপুর মর্নিং সান স্কুল';

    public string $address = 'গাজীপুর সদর, গাজীপুর';

    public string $themeColor = 'rose'; // rose, blue, green

    public int $questionCount = 100; // 40, 60, 80, 100

    public string $headerSize = 'BIG';

    public string $infoType = 'DIGITAL';

    // থিম পরিবর্তন করার মেথড
    public function updateTheme(string $color): void
    {
        if (in_array($color, ['rose', 'blue', 'green'], true)) {
            $this->themeColor = $color;
        }
    }


    /**
     * @return array<string, string>
     */
    public function themeClassSet(): array
    {
        return [
            'rose' => ['border' => 'border-rose-500', 'bg' => 'bg-rose-300/70'],
            'blue' => ['border' => 'border-blue-500', 'bg' => 'bg-blue-300/70'],
            'green' => ['border' => 'border-green-500', 'bg' => 'bg-green-300/70'],
        ][$this->themeColor] ?? ['border' => 'border-rose-500', 'bg' => 'bg-rose-300/70'];
    }

    public function updatedQuestionCount(int $value): void
    {
        if (! in_array($value, [40, 60, 80, 100], true)) {
            $this->questionCount = 100;
        }
    }

    public function toBanglaNumber(int $value): string
    {
        return strtr((string) $value, [
            '0' => '০',
            '1' => '১',
            '2' => '২',
            '3' => '৩',
            '4' => '৪',
            '5' => '৫',
            '6' => '৬',
            '7' => '৭',
            '8' => '৮',
            '9' => '৯',
        ]);
    }

    public function render()
    {
        return view('livewire.omr-generator')->layout('layouts.app', [
            'title' => 'OMR Generator',
        ]);
    }
}
