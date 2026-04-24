<?php

namespace App\Support;

class QuestionTextParser
{
    /**
     * @return array<int, array{title: string, options: array<int, array{option_text: string, is_correct: bool}>}>
     */
    public static function parseMcqText(string $text): array
    {
        $questions = [];
        $labels    = ['ক', 'খ', 'গ', 'ঘ'];

        // বাংলা ও English উভয় নম্বর সাপোর্ট (১. বা 1.)
        // `u` flag অবশ্যই থাকতে হবে UTF-8 এর জন্য
        $pattern = '/(?:^|\n)\s*(?:[০-৯\d]+)[.)।]\s*(.+?)(?=\n\s*(?:[০-৯\d]+)[.)।]|\z)/su';

        preg_match_all($pattern, $text, $questionBlocks);

        foreach ($questionBlocks[0] as $block) {
            $block = trim($block);
            if ($block === '') continue;

            // বাংলা অপশন: (ক) (খ) (গ) (ঘ) বা (a) (b) (c) (d)
            $optionPattern = '/\(\s*([কখগঘa-dA-D])\s*\)\s*(.+)/u';
            preg_match_all($optionPattern, $block, $optionMatches, PREG_SET_ORDER);

            if (count($optionMatches) < 2) continue;

            // প্রশ্নের title বের করা
            $titleLine = preg_split('/\n/', $block, 2)[0];
            $title     = trim(preg_replace('/^[০-৯\d]+[.)।]\s*/u', '', $titleLine));

            $options = [];
            foreach ($optionMatches as $match) {
                $options[] = [
                    'option_text' => trim($match[2]),
                    'is_correct'  => false,
                ];
            }

            if ($title !== '') {
                $questions[] = [
                    'title'   => $title,
                    'options' => $options,
                ];
            }
        }

        return $questions;
    }

    /**
     * @return array{title: string, options: array<int, array{option_text: string, is_correct: bool}>}|null
     */
    protected static function parseSingleMcqChunk(string $chunk): ?array
    {
        if ($chunk === '') {
            return null;
        }

        preg_match_all('/\(([কখগঘ]|[a-dA-D])\)\s*(.+?)(?=(?:\s*\([কখগঘa-dA-D]\)\s*)|$)/us', $chunk, $matches, PREG_SET_ORDER);

        if (count($matches) < 2) {
            return null;
        }

        $firstOptionStart = mb_strpos($chunk, $matches[0][0]);
        $title = trim($firstOptionStart === false ? $chunk : mb_substr($chunk, 0, $firstOptionStart));

        if ($title === '') {
            return null;
        }

        $options = [];

        foreach ($matches as $optionMatch) {
            $options[] = [
                'option_text' => trim($optionMatch[2]),
                'is_correct' => false,
            ];
        }

        return [
            'title' => $title,
            'options' => $options,
        ];
    }
}
