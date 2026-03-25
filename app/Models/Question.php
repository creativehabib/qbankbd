<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    protected $casts = [
        'is_premium' => 'boolean',
        'extra_content' => 'array', // JSON ডেটাকে Array তে কনভার্ট করবে
    ];

    /**
     * Model Event: প্রশ্ন সেভ হওয়ার আগে অটোমেটিক ক্যাটাগরি আইডি বসিয়ে দেওয়া
     */
    protected static function booted()
    {
        static::saving(function ($question) {
            if ($question->topic_id) {
                $topic = Topic::find($question->topic_id);
                if ($topic) {
                    $question->chapter_id = $topic->chapter_id;
                }
            }

            if ($question->chapter_id) {
                $chapter = Chapter::find($question->chapter_id);
                if ($chapter) {
                    $question->subject_id = $chapter->subject_id;
                }
            }

            if ($question->subject_id) {
                $subject = Subject::find($question->subject_id);
                if ($subject) {
                    $question->academic_class_id = $subject->academic_class_id;
                }
            }
        });
    }

    // --- রিলেশনশিপসমূহ ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
