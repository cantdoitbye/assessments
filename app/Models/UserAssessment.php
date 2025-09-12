<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assessment_id',
        'category_scores',
        'dominant_category',
        'started_at',
        'completed_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'category_scores' => 'array',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function calculateResults(): void
    {
        $categoryScores = [];
        $categories = $this->assessment->resultCategories;
        
        // Initialize scores
        foreach ($categories as $category) {
            $categoryScores[$category->code] = 0;
        }

        // Calculate scores from answers
        foreach ($this->userAnswers as $answer) {
            $scoring = $answer->option->scoring ?? [];
            foreach ($scoring as $categoryCode => $score) {
                $categoryScores[$categoryCode] = ($categoryScores[$categoryCode] ?? 0) + $score;
            }
        }

        // Find dominant category
        $dominantCategory = array_keys($categoryScores, max($categoryScores))[0];

        $this->update([
            'category_scores' => $categoryScores,
            'dominant_category' => $dominantCategory,
            'completed_at' => now(),
            'status' => 'completed'
        ]);
    }

    public function getDominantCategoryNameAttribute(): string
    {
        $category = $this->assessment->resultCategories()
            ->where('code', $this->dominant_category)
            ->first();
        
        return $category ? $category->name : $this->dominant_category;
    }
}