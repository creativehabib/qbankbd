<?php

namespace App\Livewire;

use Livewire\Component;

class OmrGenerator extends Component
{
    public string $schoolName = 'গাজীপুর মর্নিং সান স্কুল';

    public string $address = 'গাজীপুর সদর, গাজীপুর';

    public string $themeColor = 'rose';

    public int $questionCount = 100;

    public string $headerSize = 'BIG';

    public string $infoType = 'DIGITAL';

    public function updateTheme(string $color): void
    {
        if (array_key_exists($color, $this->themePalette())) {
            $this->themeColor = $color;
        }
    }

    public function updatedQuestionCount(int $value): void
    {
        $allowedCounts = $this->questionCountOptions();

        if (! in_array($value, $allowedCounts, true)) {
            $this->questionCount = 100;
        }
    }

    public function updatedHeaderSize(string $value): void
    {
        if (! in_array($value, $this->headerSizeOptions(), true)) {
            $this->headerSize = 'BIG';
        }
    }

    public function updatedInfoType(string $value): void
    {
        if (! in_array($value, $this->infoTypeOptions(), true)) {
            $this->infoType = 'DIGITAL';
        }
    }

    /**
     * @return array<string, string>
     */
    public function themeClasses(): array
    {
        return $this->themePalette()[$this->themeColor] ?? $this->themePalette()['rose'];
    }

    /**
     * @return array<int, string>
     */
    public function headerSizeOptions(): array
    {
        return ['BIG', 'SMALL'];
    }

    /**
     * @return array<int, string>
     */
    public function infoTypeOptions(): array
    {
        return ['DIGITAL', 'MANUAL'];
    }

    /**
     * @return array<int, int>
     */
    public function questionCountOptions(): array
    {
        return [40, 60, 80, 100];
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

    /**
     * @return array<string, array<string, string>>
     */
    private function themePalette(): array
    {
        return [
            'rose' => [
                'label' => 'Rose',
                'border' => 'border-rose-500',
                'option' => 'bg-rose-300/70 border-rose-500',
                'button' => 'bg-rose-600 hover:bg-rose-700',
                'buttonMuted' => 'bg-rose-100 text-rose-700 hover:bg-rose-200',
            ],
            'blue' => [
                'label' => 'Blue',
                'border' => 'border-blue-500',
                'option' => 'bg-blue-300/70 border-blue-500',
                'button' => 'bg-blue-600 hover:bg-blue-700',
                'buttonMuted' => 'bg-blue-100 text-blue-700 hover:bg-blue-200',
            ],
            'green' => [
                'label' => 'Green',
                'border' => 'border-green-500',
                'option' => 'bg-green-300/70 border-green-500',
                'button' => 'bg-green-600 hover:bg-green-700',
                'buttonMuted' => 'bg-green-100 text-green-700 hover:bg-green-200',
            ],
        ];
    }

    /**
     * @return array<string, array<string, string>>
     */
    public function themeOptions(): array
    {
        return $this->themePalette();
    }
}
