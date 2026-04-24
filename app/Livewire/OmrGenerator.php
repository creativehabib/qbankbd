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

    /**
     * @return array<string, string>
     */
    public function themeClasses(): array
    {
        return $this->themePalette()[$this->themeColor] ?? $this->themePalette()['rose'];
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
                'border' => 'border-rose-500',
                'option' => 'bg-rose-300/70 border-rose-500',
                'button' => 'bg-rose-600 hover:bg-rose-700',
            ],
            'blue' => [
                'border' => 'border-blue-500',
                'option' => 'bg-blue-300/70 border-blue-500',
                'button' => 'bg-blue-600 hover:bg-blue-700',
            ],
            'green' => [
                'border' => 'border-green-500',
                'option' => 'bg-green-300/70 border-green-500',
                'button' => 'bg-green-600 hover:bg-green-700',
            ],
        ];
    }
}
