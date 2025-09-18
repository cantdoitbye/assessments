<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultCategory extends Model
{
     protected $fillable = [
        'assessment_id',
        'name',
        'description',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}