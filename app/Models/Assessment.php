<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
   protected $fillable = [
        'title',
        'slug', 
        'description',
        'status',
        'link_url',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function resultCategories(): HasMany
    {
        return $this->hasMany(ResultCategory::class);
    }

    public function userAssessments(): HasMany
    {
        return $this->hasMany(UserAssessment::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}