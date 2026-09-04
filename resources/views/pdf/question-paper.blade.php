<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Question Paper</title>

    <style>

        @page {
            margin-top: 10mm;
            margin-bottom: 10mm;
            margin-left: 10mm;
            margin-right: 10mm;
        }

        body,
        div,
        span,
        p,
        td,
        th,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'kalpurush', sans-serif;
            font-size: 14px;
            color: #111827;
        }

        body {
            line-height: 1.5;
        }

        .header-section {
            text-align: center;
            border-bottom: 2px solid #10b981;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-section h1 {
            margin: 0;
            font-size: 24px;
            color: #059669;
            font-weight: bold;
        }

        .header-section p {
            margin: 5px 0 0;
            font-size: 16px;
            font-weight: bold;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 20px;
            font-weight: bold;
            border-collapse: collapse;
        }

        .meta-table td {
            padding: 5px 0;
        }

        .columns-wrapper {
            width: 100%;
        }

        .column-left {
            float: left;
            width: 48%;
        }

        .column-right {
            float: right;
            width: 48%;
        }

        .clear-float {
            clear: both;
        }

        .question-block {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .question-text {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .options-table {
            width: 100%;
            border-collapse: collapse;
        }

        .options-table td {
            width: 50%;
            padding: 3px 0;
            vertical-align: top;
        }

        .option {
            padding-right: 5px;
        }

    </style>
</head>
<body>

<div class="header-section">
    <h1>{{ $institution_name }}</h1>
    <p>{{ $exam_title }}</p>
</div>

<table class="meta-table">
    <tr>
        <td align="left">
            বিষয়: {{ $subject }}
        </td>

        <td align="center">
            সময়: {{ $time }}
        </td>

        <td align="right">
            পূর্ণমান: {{ $total_marks }}
        </td>
    </tr>
</table>

<div class="columns-wrapper">

    @php
        $labels = ['ক', 'খ', 'গ', 'ঘ'];
    @endphp

        <!-- LEFT COLUMN -->
    <div class="column-left">

        @foreach($questions as $index => $question)

            @if($index % 2 == 0)

                <div class="question-block">

                    <div class="question-text">
                        {{ $index + 1 }}.
                        {!! strip_tags($question->title) !!}
                    </div>

                    @if($question->question_type === 'mcq')

                        @php
                            $rawOptions = is_string($question->extra_content)
                                ? json_decode($question->extra_content, true)
                                : $question->extra_content;

                            $optionChunks = collect($rawOptions)
                                ->values()
                                ->take(4)
                                ->chunk(2);
                        @endphp

                        <table class="options-table">

                            @foreach($optionChunks as $chunkIndex => $chunk)

                                <tr>

                                    @foreach($chunk as $optionIndex => $option)

                                        @php
                                            $globalIndex = ($chunkIndex * 2) + $optionIndex;
                                        @endphp

                                        <td>
                                            <span class="option">
                                                {{ $labels[$globalIndex] ?? '' }})
                                            </span>

                                            {!! strip_tags($option['option_text'] ?? '') !!}
                                        </td>

                                    @endforeach

                                    @if($chunk->count() == 1)
                                        <td></td>
                                    @endif

                                </tr>

                            @endforeach

                        </table>

                    @endif

                </div>

            @endif

        @endforeach

    </div>

    <!-- RIGHT COLUMN -->
    <div class="column-right">

        @foreach($questions as $index => $question)

            @if($index % 2 != 0)

                <div class="question-block">

                    <div class="question-text">
                        {{ $index + 1 }}.
                        {!! strip_tags($question->title) !!}
                    </div>

                    @if($question->question_type === 'mcq')

                        @php
                            $rawOptions = is_string($question->extra_content)
                                ? json_decode($question->extra_content, true)
                                : $question->extra_content;

                            $optionChunks = collect($rawOptions)
                                ->values()
                                ->take(4)
                                ->chunk(2);
                        @endphp

                        <table class="options-table">

                            @foreach($optionChunks as $chunkIndex => $chunk)

                                <tr>

                                    @foreach($chunk as $optionIndex => $option)

                                        @php
                                            $globalIndex = ($chunkIndex * 2) + $optionIndex;
                                        @endphp

                                        <td>
                                            <span class="option">
                                                {{ $labels[$globalIndex] ?? '' }})
                                            </span>

                                            {!! strip_tags($option['option_text'] ?? '') !!}
                                        </td>

                                    @endforeach

                                    @if($chunk->count() == 1)
                                        <td></td>
                                    @endif

                                </tr>

                            @endforeach

                        </table>

                    @endif

                </div>

            @endif

        @endforeach

    </div>

    <div class="clear-float"></div>

</div>

</body>
</html>
