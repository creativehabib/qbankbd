<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OmrTemplate extends Model
{
    protected $fillable = ['name', 'unique_code', 'total_questions', 'columns', 'type'];

    public function tokens(): HasMany {
        return $this->hasMany(OmrToken::class);
    }
}
