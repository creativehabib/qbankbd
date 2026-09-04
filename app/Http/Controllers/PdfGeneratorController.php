<?php

namespace App\Http\Controllers;

use App\Models\QuestionSet;
use Illuminate\Support\Facades\File;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

class PdfGeneratorController extends Controller
{
    public function downloadQuestionPaper($setId)
    {
        $questionSet = QuestionSet::with([
            'questions',
            'questions.subject'
        ])->findOrFail($setId);

        $data = [
            'institution_name' => 'Example School Name',
            'exam_title'       => $questionSet->name,
            'subject'          => $questionSet->questions->first()?->subject?->name ?? '',
            'time'             => '১ ঘণ্টা',
            'total_marks'      => $questionSet->questions->sum('marks'),
            'questions'        => $questionSet->questions,
        ];

        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $tempDir = storage_path('app/mpdf');

        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0777, true);
        }

        // Debug (একবার চালিয়ে দেখুন)
        /*
        dd([
            'regular' => file_exists(public_path('fonts/NotoSansBengali-Regular.ttf')),
            'bold'    => file_exists(public_path('fonts/NotoSansBengali-Bold.ttf')),
        ]);
        */

        $mpdf = new Mpdf([
            'mode' => 'utf-8',

            'tempDir' => $tempDir,

            'fontDir' => array_merge($fontDirs, [
                public_path('fonts'), // নিশ্চিত করুন আপনার কালপুরুষ ফন্ট এই ফোল্ডারে আছে
            ]),

            'fontdata' => $fontData + [
                    'kalpurush' => [ // 'nikosh'-এর পরিবর্তে 'kalpurush' কনফিগারেশন যোগ করুন
                        'R' => 'Kalpurush.ttf', // নিশ্চিত করুন ফাইলের নাম পুরোপুরি মিলেছে
                        'B' => 'Kalpurush.ttf', // কালপুরুষের বোল্ড ভার্সন থাকলে সেটিও দিতে পারেন, নতুবা একই নাম দিন
                        'useOTL' => 0xFF, // যুক্তবর্ণ ঠিকমতো রেন্ডার করার জন্য এটি অত্যন্ত জরুরি
                    ],
                ],

            'default_font' => 'kalpurush', // ডিফল্ট ফন্ট হিসেবে 'kalpurush' সেট করুন

            // এই দুটি অবশ্যই true রাখতে হবে এবং কমপ্লেক্স টেক্সট লেআউটের জন্য জরুরি
            'autoScriptToLang' => true,
            'autoLangToFont'   => true,

            'format' => 'A4',
        ]);

        $html = view('pdf.question-paper', $data)->render();

        $mpdf->WriteHTML($html);

        return response(
            $mpdf->Output(
                'Question_Paper_'.$questionSet->id.'.pdf',
                \Mpdf\Output\Destination::STRING_RETURN
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="Question_Paper_'.$questionSet->id.'.pdf"',
            ]
        );
    }
}
