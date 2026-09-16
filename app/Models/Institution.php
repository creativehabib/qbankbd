<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institution extends Model
{
    protected $fillable = ['name', 'short_name', 'slug', 'logo_path', 'description', 'official_website', 'established_year'];

    public function pastExams(): HasMany
    {
        return $this->hasMany(PastExam::class);
    }
}
