<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_premium' => 'boolean',
        'is_paid' => 'boolean',
        'extra_content' => 'array',
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    protected static function booted(): void
    {
        static::saving(function (Question $question): void {
            if ($question->topic_id) {
                $topic = Topic::query()->find($question->topic_id);

                if ($topic) {
                    $question->chapter_id = $topic->chapter_id;
                }
            }

            if ($question->chapter_id) {
                $chapter = Chapter::query()->find($question->chapter_id);

                if ($chapter) {
                    $question->subject_id = $chapter->subject_id;
                }
            }

            if ($question->subject_id) {
                $subject = Subject::query()->find($question->subject_id);

                if ($subject) {
                    $question->academic_class_id = $subject->academic_class_id;
                }
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function academicClass(): BelongsTo
    {
        return $this->belongsTo(AcademicClass::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'question_tag', 'question_id', 'tag_id');
    }

    public function examCategories(): BelongsToMany
    {
        return $this->belongsToMany(ExamCategory::class, 'exam_category_question', 'question_id', 'exam_category_id');
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'question_user_likes')->withTimestamps();
    }

    public function bookmarks()
    {
        return $this->belongsToMany(User::class, 'question_user_bookmarks')->withTimestamps();
    }

    protected function generateUniqueSlug(string $title): string
    {
        // ছোট হাতে রূপান্তর
        $slug = mb_strtolower(trim($title), 'UTF-8');

        // শুধু বাংলা, ইংরেজি, সংখ্যা এবং স্পেস রাখুন
        $slug = preg_replace('/[^\p{Bengali}a-z0-9\s]/u', '', $slug);

        // স্পেস → হাইফেন
        $slug = preg_replace('/\s+/u', '-', $slug);

        // একাধিক হাইফেন → একটি
        $slug = preg_replace('/-+/', '-', $slug);

        $slug = trim($slug, '-');

        $base = $slug ?: Str::lower(Str::random(10));

        // Unique check
        $finalSlug = $base;
        $counter = 1;

        while (Question::where('slug', $finalSlug)->exists()) {
            $finalSlug = $base.'-'.$counter;
            $counter++;
        }

        return $finalSlug;
    }
}
