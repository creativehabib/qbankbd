<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MockTestQuestion extends Model
{
    protected $guarded = ['id'];

    public function mockTest()
    {
        return $this->belongsTo(MockTest::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
