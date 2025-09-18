<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
   protected $fillable = [
        'question_id',
        'option_text',
        'score_map',
    ];

    protected $casts = [
        'score_map' => 'array',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }
}