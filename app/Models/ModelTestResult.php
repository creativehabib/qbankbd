<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTestResult extends Model
{
    protected $guarded = ['id'];

    public function modelTest()
    {
        return $this->belongsTo(ModelTest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
