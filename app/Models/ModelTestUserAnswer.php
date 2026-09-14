<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTestUserAnswer extends Model
{
    protected $guarded = ['id'];

    public function modelTestResult()
    {
        return $this->belongsTo(ModelTestResult::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
