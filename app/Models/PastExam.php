<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PastExam extends Model
{
    protected $fillable = [
        'title', 'slug', 'institution_id', 'exam_category_id', 'exam_date', 
        'grade', 'total_marks', 'total_questions', 'description', 'type'
    ];

    protected $casts = [
        'exam_date' => 'date',
    ];

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function examCategory(): BelongsTo
    {
        return $this->belongsTo(ExamCategory::class);
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'past_exam_question')
            ->withPivot('order')
            ->orderByPivot('order');
    }
}
