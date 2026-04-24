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
