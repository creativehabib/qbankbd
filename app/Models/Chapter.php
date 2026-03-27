<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

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

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
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
