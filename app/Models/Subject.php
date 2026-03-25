<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Subject extends Model
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

    // রিলেশনশিপ: এই সাবজেক্টটি কোন ক্লাসের
    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }

    // রিলেশনশিপ: একটি সাবজেক্টের অধীনে অনেক চ্যাপ্টার থাকে
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
