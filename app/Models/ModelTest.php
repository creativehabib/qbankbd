<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTest extends Model
{
    protected $guarded = ['id'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'model_test_question')
            ->withPivot('sort_order')
            ->orderBy('sort_order');
    }

    public function results()
    {
        return $this->hasMany(ModelTestResult::class);
    }
}
