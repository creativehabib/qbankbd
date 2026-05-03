<?php

namespace App\Livewire\Students;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class BookmarkedQuestions extends Component
{
    use WithPagination;

    public function mount(): void
    {
        abort_unless(auth()->user()?->isStudent(), 403);
    }

    // --- Dynamic Actions ---

    public function toggleLike(int $questionId): void
    {
        $question = Question::findOrFail($questionId);
        $toggled = $question->likes()->toggle(auth()->id());

        if (count($toggled['attached']) > 0) {
            $question->increment('likes_count');
        } elseif (count($toggled['detached']) > 0) {
            $question->decrement('likes_count');
        }
    }

    public function toggleBookmark(int $questionId): void
    {
        $question = Question::findOrFail($questionId);
        $toggled = $question->bookmarks()->toggle(auth()->id());

        if (count($toggled['attached']) > 0) {
            $question->increment('bookmarks_count');
        } elseif (count($toggled['detached']) > 0) {
            $question->decrement('bookmarks_count');
        }
    }

    public function recordView(int $questionId): void
    {
        $viewerId = auth()->check() ? 'user_' . auth()->id() : 'ip_' . request()->ip();
        $cacheKey = "viewed_question_{$questionId}_by_{$viewerId}";

        if (!Cache::has($cacheKey)) {
            Question::where('id', $questionId)->increment('views_count');
            Cache::put($cacheKey, true, now()->addHours(24));
        }
    }

    // --- Fetching Data ---

    protected function bookmarkedQuestions(): LengthAwarePaginator
    {
        return Question::query()
            ->where('status', 'active')
            // শুধুমাত্র এই স্টুডেন্টের বুকমার্ক করা প্রশ্নগুলো ফিল্টার করা হচ্ছে
            ->whereHas('bookmarks', function (Builder $query) {
                $query->where('user_id', auth()->id());
            })
            ->with(['academicClass:id,name', 'subject:id,name', 'chapter:id,name'])
            ->withExists([
                'likes as is_liked' => fn (Builder $q) => $q->where('user_id', auth()->id()),
                'bookmarks as is_bookmarked' => fn (Builder $q) => $q->where('user_id', auth()->id()),
            ])
            ->latest('id')
            ->paginate(20);
    }

    public function render(): View
    {
        return view('livewire.students.bookmarked-questions', [
            'questions' => $this->bookmarkedQuestions(),
        ])->layout('layouts.app', ['title' => 'My Bookmarks']);
    }
}
