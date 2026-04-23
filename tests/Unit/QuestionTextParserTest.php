<?php

use App\Support\QuestionTextParser;

it('parses bangla formatted mcq text into question payloads', function () {
    $rawText = <<<'TEXT'
১. শব্দটির অর্থ কী? (ক) কলসি (খ) চরকি (গ) কুলফি (ঘ) বাড়ি
২. নিচের কোনটি পুরুষ-বাচক? (ক) জনতা (খ) পরিবার (গ) মানুষ (ঘ) গ্রাম
TEXT;

    $parsed = QuestionTextParser::parseMcqText($rawText);

    expect($parsed)->toHaveCount(2)
        ->and($parsed[0]['title'])->toBe('শব্দটির অর্থ কী?')
        ->and($parsed[0]['options'])->toHaveCount(4)
        ->and($parsed[0]['options'][2]['option_text'])->toBe('কুলফি')
        ->and($parsed[1]['title'])->toBe('নিচের কোনটি পুরুষ-বাচক?');
});

it('ignores malformed blocks that do not have at least two options', function () {
    $rawText = <<<'TEXT'
১. অসম্পূর্ণ প্রশ্ন (ক) শুধু একটি অপশন
২. সম্পূর্ণ প্রশ্ন (ক) এক (খ) দুই (গ) তিন (ঘ) চার
TEXT;

    $parsed = QuestionTextParser::parseMcqText($rawText);

    expect($parsed)->toHaveCount(1)
        ->and($parsed[0]['title'])->toBe('সম্পূর্ণ প্রশ্ন');
});
