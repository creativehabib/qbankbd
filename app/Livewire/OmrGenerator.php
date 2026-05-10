<?php

namespace App\Livewire;

use Livewire\Component;

class OmrGenerator extends Component
{
    public string $schoolName = 'অনলাইন ডিজিটাল স্কুল';

    public string $address = 'গাজীপুর সদর, গাজীপুর';

    // ইপ্রশ্নব্যাংকের জন্য ডিফল্ট সাইজ ২৪ করা হয়েছে
    public int $schoolNameSize = 24;

    public int $addressSize = 14;

    public string $themeColor = 'rose';       // rose | gray | blue | green | purple | orange | cyan | pink | yellow | lime

    // ইপ্রশ্নব্যাংকের জন্য ডিফল্ট প্রশ্ন সংখ্যা ১০০ করা হয়েছে
    public int $questionCount = 100;           // 10 to 100

    public int $columns = 2;                  // 2 | 3 | 4

    public string $headerSize = 'BIG';        // BIG | SMALL

    public string $infoType = 'DIGITAL';      // DIGITAL | MANUAL

    // ডিফল্ট টেমপ্লেট 'iproshbang' সেট করা হয়েছে
    public string $templateType = 'iproshbang'; // iproshbang | standard

    /* ─── Template Switch Hook ───────────────────────────── */

    public function updatedTemplateType($value): void
    {
        // টেমপ্লেট চেঞ্জ করলে ডিফল্ট ভ্যালুগুলো এডজাস্ট করার জন্য
        if ($value === 'standard') {
            $this->schoolNameSize = 14;
            $this->addressSize = 14;
            $this->questionCount = 20;
        } else {
            $this->schoolNameSize = 24;
            $this->addressSize = 14;
            $this->questionCount = 100;
        }
    }

    /* ─── Theme ─────────────────────────────────────────── */

    public function updateTheme(string $color): void
    {
        $allowed = ['rose', 'gray', 'blue', 'green', 'purple', 'orange', 'cyan', 'pink', 'yellow', 'lime'];
        if (in_array($color, $allowed, true)) {
            $this->themeColor = $color;
        }
    }

    /** @return array<string,string> */
    public function themeClassSet(): array
    {
        $themes = [
            'rose' => ['border' => 'border-rose-500',   'bg' => 'bg-rose-300/70',   'header' => 'bg-rose-500',   'text' => 'text-rose-600',   'hex' => '#f43f5e', 'border2' => 'border-rose-500',   'bg50' => 'bg-rose-50'],
            'gray' => ['border' => 'border-gray-500',   'bg' => 'bg-gray-300/70',   'header' => 'bg-gray-500',   'text' => 'text-gray-600',   'hex' => '#6b7280', 'border2' => 'border-gray-500',   'bg50' => 'bg-gray-50'],
            'blue' => ['border' => 'border-blue-500',   'bg' => 'bg-blue-300/70',   'header' => 'bg-blue-500',   'text' => 'text-blue-600',   'hex' => '#3b82f6', 'border2' => 'border-blue-500',   'bg50' => 'bg-blue-50'],
            'green' => ['border' => 'border-green-500',  'bg' => 'bg-green-300/70',  'header' => 'bg-green-500',  'text' => 'text-green-700',  'hex' => '#22c55e', 'border2' => 'border-green-500',  'bg50' => 'bg-green-50'],
            'purple' => ['border' => 'border-purple-500', 'bg' => 'bg-purple-300/70', 'header' => 'bg-purple-500', 'text' => 'text-purple-600', 'hex' => '#a855f7', 'border2' => 'border-purple-500', 'bg50' => 'bg-purple-50'],
            'orange' => ['border' => 'border-orange-500', 'bg' => 'bg-orange-300/70', 'header' => 'bg-orange-500', 'text' => 'text-orange-600', 'hex' => '#f97316', 'border2' => 'border-orange-500', 'bg50' => 'bg-orange-50'],
            'cyan' => ['border' => 'border-cyan-500',   'bg' => 'bg-cyan-300/70',   'header' => 'bg-cyan-500',   'text' => 'text-cyan-700',   'hex' => '#06b6d4', 'border2' => 'border-cyan-500',   'bg50' => 'bg-cyan-50'],
            'pink' => ['border' => 'border-pink-500',   'bg' => 'bg-pink-300/70',   'header' => 'bg-pink-500',   'text' => 'text-pink-600',   'hex' => '#ec4899', 'border2' => 'border-pink-500',   'bg50' => 'bg-pink-50'],
            'yellow' => ['border' => 'border-yellow-500', 'bg' => 'bg-yellow-300/70', 'header' => 'bg-yellow-500', 'text' => 'text-yellow-700', 'hex' => '#eab308', 'border2' => 'border-yellow-500', 'bg50' => 'bg-yellow-50'],
            'lime' => ['border' => 'border-lime-500',   'bg' => 'bg-lime-300/70',   'header' => 'bg-lime-500',   'text' => 'text-lime-700',   'hex' => '#84cc16', 'border2' => 'border-lime-500',   'bg50' => 'bg-lime-50'],
        ];

        return $themes[$this->themeColor] ?? $themes['rose'];
    }

    /* ─── Validation ─────────────────────────────────────── */

    public function updatedQuestionCount($value): void
    {
        $val = (int) $value;
        if ($val < 10) {
            $this->questionCount = 10;
        } elseif ($val > 100) {
            $this->questionCount = 100;
        } else {
            $this->questionCount = $val;
        }
    }

    /* ─── Helper ─────────────────────────────────────────── */

    public function toBanglaNumber(int $value): string
    {
        return strtr((string) $value, [
            '0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪',
            '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯',
        ]);
    }

    // Dynamic OMR Code Generator
    public function getOmrCodeProperty(): string
    {
        $tType = $this->templateType === 'standard' ? '1' : '2';
        $qCount = str_pad($this->questionCount, 2, '0', STR_PAD_LEFT);
        return $tType . $this->columns . '1' . $qCount;
    }

    /* ─── Render ─────────────────────────────────────────── */

    public function render()
    {
        return view('livewire.omr-generator')->layout('layouts.app', [
            'title' => 'OMR Generator',
        ]);
    }
}
