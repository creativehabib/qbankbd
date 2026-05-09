<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OmrToken extends Model
{
    protected $fillable = [
        'token_id',
        'omr_template_id',
        'title',
        'answer_key',
        'correct_mark',
        'negative_mark',
        'total_questions',
        'created_by'
    ];

    // answer_key কে অটোমেটিক অ্যারেতে কাস্ট করার লজিক
    protected $casts = [
        'answer_key' => 'array',
    ];

    public function template(): BelongsTo {
        return $this->belongsTo(OmrTemplate::class, 'omr_template_id');
    }
}
