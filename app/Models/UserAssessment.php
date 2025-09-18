<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserAssessment extends Model
{
      protected $fillable = [
        'user_id',
        'assessment_id',
        'result_json',
        'final_result',
    ];

    protected $casts = [
        'result_json' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }
}