<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionReport extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'reason',
        'description',
        'is_resolved',
    ];

    // রিলেশনশিপ: এই রিপোর্টটি কোন ইউজারের
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // রিলেশনশিপ: এই রিপোর্টটি কোন প্রশ্নের
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
