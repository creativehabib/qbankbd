<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MockTest extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // এই মেথডটি মিসিং থাকার কারণেই এররটি আসছিল
    public function testQuestions(): HasMany
    {
        return $this->hasMany(MockTestQuestion::class, 'mock_test_id');
    }
}
