<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswer extends Model
{
     protected $fillable = [
        'user_assessment_id',
        'question_id',
        'option_id',
    ];

    public function userAssessment()
    {
        return $this->belongsTo(UserAssessment::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}