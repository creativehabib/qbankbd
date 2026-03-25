<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Chapter extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $guarded = [];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    protected $casts = [
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
    ];

    // রিলেশনশিপ: এই চ্যাপ্টারটি কোন সাবজেক্টের
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // রিলেশনশিপ: একটি চ্যাপ্টারের অধীনে অনেক টপিক থাকে
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
