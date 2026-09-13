<?php
$content = file_get_contents('app/Http/Controllers/DashboardController.php');

$searchMock = <<<'MOCK'
                return [
                    'id' => 'mock_'.$test->id,
                    'name' => $test->subject ? $test->subject->name . ' এর মক টেস্ট' : 'সাধারণ মক টেস্ট',
                    'score' => $test->total_score,
                    'total' => $test->total_questions,
                    'time' => $start->diffInMinutes($end) . ' Mins',
                    'right' => $test->correct_answers,
                    'wrong' => $test->wrong_answers,
                    'skipped' => $skipped > 0 ? $skipped : 0,
                    'date' => $test->created_at,
                    'date_human' => $test->created_at->diffForHumans()
                ];
MOCK;

$replaceMock = <<<'REPLACEMOCK'
                return [
                    'id' => 'mock_'.$test->id,
                    'url' => route('student.mock-test.result', ['testId' => $test->id]),
                    'name' => $test->subject ? $test->subject->name . ' এর মক টেস্ট' : 'সাধারণ মক টেস্ট',
                    'score' => $test->total_score,
                    'total' => $test->total_questions,
                    'time' => $start->diffInMinutes($end) . ' Mins',
                    'right' => $test->correct_answers,
                    'wrong' => $test->wrong_answers,
                    'skipped' => $skipped > 0 ? $skipped : 0,
                    'date_obj' => $test->created_at,
                    'date' => $test->created_at->diffForHumans()
                ];
REPLACEMOCK;

$searchModel = <<<'MODEL'
                return [
                    'id' => 'model_'.$test->id,
                    'name' => ($test->modelTest->title ?? 'মডেল টেস্ট'),
                    'score' => $test->total_score,
                    'total' => $total,
                    'time' => $timeMins . ' Mins',
                    'right' => $test->correct_count,
                    'wrong' => $test->wrong_count,
                    'skipped' => $test->unanswered_count,
                    'date' => $test->created_at,
                    'date_human' => $test->created_at->diffForHumans()
                ];
MODEL;

$replaceModel = <<<'REPLACEMODEL'
                return [
                    'id' => 'model_'.$test->id,
                    'url' => route('student.model-tests.result', ['resultId' => $test->id]),
                    'name' => ($test->modelTest->title ?? 'মডেল টেস্ট'),
                    'score' => $test->total_score,
                    'total' => $total,
                    'time' => $timeMins . ' Mins',
                    'right' => $test->correct_count,
                    'wrong' => $test->wrong_count,
                    'skipped' => $test->unanswered_count,
                    'date_obj' => $test->created_at,
                    'date' => $test->created_at->diffForHumans()
                ];
REPLACEMODEL;

$searchSort = <<<'SORT'
        $attendedExams = $mockExamsList->concat($modelExamsList)
            ->sortByDesc('date')
            ->take(5)
            ->values();
SORT;

$replaceSort = <<<'REPLACESORT'
        $attendedExams = $mockExamsList->concat($modelExamsList)
            ->sortByDesc('date_obj')
            ->take(5)
            ->values();
REPLACESORT;

$content = str_replace($searchMock, $replaceMock, $content);
$content = str_replace($searchModel, $replaceModel, $content);
$content = str_replace($searchSort, $replaceSort, $content);

file_put_contents('app/Http/Controllers/DashboardController.php', $content);
echo "Fixed!\n";
