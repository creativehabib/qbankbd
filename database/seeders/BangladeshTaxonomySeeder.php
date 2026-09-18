<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\AcademicClass;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Topic;
use App\Models\Question;
use App\Models\User;
use App\Models\Institution;
use App\Models\PastExam;
use Illuminate\Support\Facades\DB;

class BangladeshTaxonomySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first() ?? User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // 1. Create Institutions
        $bpsc = Institution::firstOrCreate(['slug' => 'bpsc'], [
            'name' => 'Bangladesh Public Service Commission',
            'short_name' => 'BPSC',
            'established_year' => '1972',
            'official_website' => 'http://www.bpsc.gov.bd/'
        ]);

        $bb = Institution::firstOrCreate(['slug' => 'bangladesh-bank'], [
            'name' => 'Bangladesh Bank',
            'short_name' => 'BB',
            'established_year' => '1971',
            'official_website' => 'https://www.bb.org.bd/'
        ]);

        $du = Institution::firstOrCreate(['slug' => 'dhaka-university'], [
            'name' => 'University of Dhaka',
            'short_name' => 'DU',
            'established_year' => '1921',
            'official_website' => 'https://www.du.ac.bd/'
        ]);

        // 2. Create Past Exams
        $bcs45 = PastExam::firstOrCreate(['slug' => '45th-bcs-preliminary'], [
            'title' => '45th BCS Preliminary Exam',
            'institution_id' => $bpsc->id,
            'exam_date' => '2023-05-19',
            'total_marks' => 200,
            'duration' => 120,
            'total_questions' => 200,
            'type' => 'mcq'
        ]);

        $bbAd = PastExam::firstOrCreate(['slug' => 'bb-ad-2023'], [
            'title' => 'Bangladesh Bank Assistant Director 2023',
            'institution_id' => $bb->id,
            'exam_date' => '2023-10-20',
            'total_marks' => 100,
            'duration' => 60,
            'total_questions' => 100,
            'type' => 'mcq'
        ]);

        $duA = PastExam::firstOrCreate(['slug' => 'du-a-unit-2023'], [
            'title' => 'DU A-Unit Admission 2023-24',
            'institution_id' => $du->id,
            'exam_date' => '2024-03-01',
            'total_marks' => 100,
            'duration' => 90,
            'total_questions' => 100,
            'type' => 'mcq'
        ]);

        // 3. Taxonomy Data Structure
        $taxonomy = [
            [
                'class' => 'BCS Preparation',
                'past_exam' => $bcs45,
                'subjects' => [
                    [
                        'name' => 'Bangladesh Affairs',
                        'chapters' => [
                            [
                                'name' => 'History of Bengal',
                                'topics' => [
                                    [
                                        'name' => 'Ancient History',
                                        'questions' => [
                                            [
                                                'title' => 'মহাস্থানগড় কোন প্রাচীন জনপদের রাজধানী ছিল?',
                                                'options' => ['সমতট', 'পুন্ড্রবর্ধন', 'হরিকেল', 'গৌড়'],
                                                'correct' => 1,
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'class' => 'Bank Jobs',
                'past_exam' => $bbAd,
                'subjects' => [
                    [
                        'name' => 'Basic Mathematics',
                        'chapters' => [
                            [
                                'name' => 'Arithmetic',
                                'topics' => [
                                    [
                                        'name' => 'Percentage',
                                        'questions' => [
                                            [
                                                'title' => '১০০ টাকার ১০% কত?',
                                                'options' => ['৫ টাকা', '১০ টাকা', '১৫ টাকা', '২০ টাকা'],
                                                'correct' => 1,
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'class' => 'University Admission',
                'past_exam' => $duA,
                'subjects' => [
                    [
                        'name' => 'Physics',
                        'chapters' => [
                            [
                                'name' => 'Motion',
                                'topics' => [
                                    [
                                        'name' => 'Velocity & Acceleration',
                                        'questions' => [
                                            [
                                                'title' => 'ত্বরণের একক কী?',
                                                'options' => ['m/s', 'm/s²', 'N/m', 'J/s'],
                                                'correct' => 1,
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        // Process Data
        $classOrder = 1;
        foreach ($taxonomy as $catData) {
            $classSlug = Str::slug($catData['class']);
            
            $academicClass = AcademicClass::firstOrCreate(['slug' => $classSlug], [
                'name' => $catData['class'],
                'is_active' => true,
                'is_premium' => false,
                'order_sequence' => $classOrder++,
                'uuid' => (string) Str::uuid(),
            ]);

            $subjectOrder = 1;
            foreach ($catData['subjects'] as $subData) {
                $subSlug = Str::slug($subData['name']);
                
                $subject = Subject::firstOrCreate(['slug' => $subSlug], [
                    'name' => $subData['name'],
                    'is_active' => true,
                    'order_sequence' => $subjectOrder++,
                    'uuid' => (string) Str::uuid(),
                ]);

                $subject->academicClasses()->syncWithoutDetaching([$academicClass->id]);

                foreach ($subData['chapters'] as $chapData) {
                    $chapSlug = Str::slug($chapData['name']) . '-' . rand(100, 999);
                    
                    $chapter = Chapter::firstOrCreate(['slug' => $chapSlug], [
                        'subject_id' => $subject->id,
                        'name' => $chapData['name'],
                        'is_active' => true,
                        'uuid' => (string) Str::uuid(),
                    ]);

                    $topicOrder = 1;
                    foreach ($chapData['topics'] as $topicData) {
                        $topSlug = Str::slug($topicData['name']) . '-' . rand(100, 999);

                        $topic = Topic::firstOrCreate(['slug' => $topSlug], [
                            'chapter_id' => $chapter->id,
                            'subject_id' => $subject->id,
                            'name' => $topicData['name'],
                            'is_active' => true,
                            'order_sequence' => $topicOrder++,
                            'uuid' => (string) Str::uuid(),
                        ]);

                        foreach ($topicData['questions'] as $qData) {
                            $qSlug = Str::slug($qData['title']);
                            if (empty($qSlug)) {
                                $qSlug = Str::random(10);
                            } else {
                                $qSlug .= '-' . rand(1000, 9999);
                            }

                            $optionsArray = [];
                            foreach ($qData['options'] as $index => $optText) {
                                $optionsArray[] = [
                                    'option_text' => $optText,
                                    'is_correct' => ($index === $qData['correct'])
                                ];
                            }

                            $question = Question::firstOrCreate(['slug' => $qSlug], [
                                'uuid' => (string) Str::uuid(),
                                'title' => $qData['title'],
                                'description' => 'Detailed explanation for this question.',
                                'extra_content' => $optionsArray,
                                'difficulty' => 'easy',
                                'question_type' => 'mcq',
                                'marks' => 1,
                                'status' => 'active',
                                'user_id' => $admin->id,
                                'subject_id' => $subject->id,
                                'chapter_id' => $chapter->id,
                                'topic_id' => $topic->id,
                            ]);

                            // Attach to Class
                            $question->academicClasses()->syncWithoutDetaching([$academicClass->id]);

                            // Attach to Past Exam
                            if (isset($catData['past_exam'])) {
                                $question->pastExams()->syncWithoutDetaching([$catData['past_exam']->id]);
                            }
                        }
                    }
                }
            }
        }
    }
}
