<?php

namespace App\Support;

class QuestionTextParser
{
    /**
     * @return array<int, array{title: string, options: array<int, array{option_text: string, is_correct: bool}>}>
     */
    public static function parseMcqText(string $text): array
    {
        $normalized = preg_replace('/\R+/u', "\n", trim($text)) ?? '';

        if ($normalized === '') {
            return [];
        }

        $chunks = preg_split('/\n\s*(?:\d+|[০-৯]+)\s*[\).।]\s*/u', "\n".$normalized, -1, PREG_SPLIT_NO_EMPTY);

        if (! is_array($chunks)) {
            return [];
        }

        $questions = [];

        foreach ($chunks as $chunk) {
            $question = self::parseSingleMcqChunk(trim($chunk));

            if ($question !== null) {
                $questions[] = $question;
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
