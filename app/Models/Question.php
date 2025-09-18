<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
   protected $fillable = [
        'assessment_id',
        'question_text',
        'order',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }
}