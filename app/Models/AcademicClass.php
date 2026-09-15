<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AcademicClass extends Model
{
    use HasFactory, \App\Traits\LogsActivity, HasUuids;

    protected $guarded = [];

    // UUID কলামটি চিনিয়ে দেওয়া
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    // ডাটা কাস্টিং
    protected $casts = [
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
    ];

    // রিলেশনশিপ: একটি ক্লাসের অধীনে অনেক সাবজেক্ট থাকে
        public function parent()
    {
        return $this->belongsTo(AcademicClass::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(AcademicClass::class, 'parent_id')->orderBy('order_sequence');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    // রিলেশনশিপ: একটি ক্লাসের অধীনে অনেক প্রশ্ন থাকে
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
