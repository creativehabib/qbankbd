<?php

namespace App\Livewire\Students;

use App\Models\Question;
use App\Models\AcademicClass;
use App\Models\Subject;
use App\Models\MockTest;
use App\Models\MockTestQuestion;
use App\Services\AiService;
use Livewire\Component;

class AiMagicSearch extends Component
{
    public string $searchQuery = '';
    public bool $isSearching = false;
    public string $errorMessage = '';

    public function search(AiService $aiService)
    {
        $this->isSearching = true;
        $this->errorMessage = '';

        if (strlen(trim($this->searchQuery)) < 5) {
            $this->errorMessage = 'দয়া করে আরেকটু বিস্তারিত লিখুন।';
            $this->isSearching = false;
            return;
        }

        try {
            $intent = $aiService->parseSearchIntent($this->searchQuery);
            
            if (!$intent) {
                $this->errorMessage = 'দুঃখিত, আমি আপনার কথা বুঝতে পারিনি। আবার চেষ্টা করুন।';
                $this->isSearching = false;
                return;
            }

            $query = Question::query()->where('question_type', 'mcq')->where('status', 'active');

            if (!empty($intent['class_name'])) {
                $classIds = AcademicClass::where('name', 'like', '%' . $intent['class_name'] . '%')->pluck('id');
                if ($classIds->isNotEmpty()) {
                    $query->whereIn('academic_class_id', $classIds);
                }
            }

            if (!empty($intent['subject_name'])) {
                $subjectIds = Subject::where('name', 'like', '%' . $intent['subject_name'] . '%')->pluck('id');
                if ($subjectIds->isNotEmpty()) {
                    $query->whereIn('subject_id', $subjectIds);
                }
            }

            if (!empty($intent['difficulty'])) {
                $query->where('difficulty', $intent['difficulty']);
            }

            if (!empty($intent['tags'])) {
                $tags = $intent['tags'];
                $query->whereHas('tags', function ($q) use ($tags) {
                    $q->whereIn('name', $tags);
                });
            }

            $limit = intval($intent['limit'] ?? 10);
            if ($limit > 50) $limit = 50;
            if ($limit < 1) $limit = 10;

            $questions = $query->inRandomOrder()->limit($limit)->get();

            if ($questions->isEmpty()) {
                $this->errorMessage = 'আপনার দেওয়া তথ্যের সাথে মিলে এমন কোনো প্রশ্ন পাওয়া যায়নি।';
                $this->isSearching = false;
                return;
            }

            // Create a dynamic Mock Test for the student
            $mockTest = MockTest::create([
                'user_id' => auth()->id(),
                'total_questions' => $questions->count(),
                'duration_minutes' => $questions->count(),
                'status' => 'started',
                'started_at' => now(),
            ]);

            $mockTestQuestionsData = $questions->map(function ($question) use ($mockTest) {
                return [
                    'mock_test_id' => $mockTest->id,
                    'question_id' => $question->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            MockTestQuestion::insert($mockTestQuestionsData);

            session()->flash('success', 'আপনার জন্য কাস্টম পরীক্ষা তৈরি করা হয়েছে!');
            $this->redirectRoute('student.mock-test.take', ['testId' => $mockTest->id], navigate: true);

        } catch (\Exception $e) {
            $this->errorMessage = 'সিস্টেমে একটি সমস্যা হয়েছে। আবার চেষ্টা করুন।';
            $this->isSearching = false;
        }
    }

    public function render()
    {
        return view('livewire.students.ai-magic-search');
    }
}
