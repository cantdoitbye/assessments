<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'question_text',
        'type',
        'order',
    ];

    public function assessment(): BelongsTo
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

    public function getTypeDisplayAttribute(): string
    {
        return match($this->type) {
            'true_false' => 'True/False',
            'likert_3' => 'Likert Scale (1-3)',
            'likert_5' => 'Likert Scale (1-5)',
            'likert_7' => 'Likert Scale (1-7)',
            'multiple_choice' => 'Multiple Choice',
            'situational_choice' => 'Situational Choice',
            default => ucfirst(str_replace('_', ' ', $this->type))
        };
    }

    public static function getTypeOptions(): array
    {
        return [
            'true_false' => 'True/False',
            'likert_3' => 'Likert Scale (1-3)',
            'likert_5' => 'Likert Scale (1-5)',
            'likert_7' => 'Likert Scale (1-7)',
            'multiple_choice' => 'Multiple Choice',
            'situational_choice' => 'Situational Choice',
        ];
    }

    public function generateDefaultOptions(): void
    {
        $categories = $this->assessment->resultCategories;
        
        switch ($this->type) {
            case 'true_false':
                $this->options()->create([
                    'option_text' => 'True',
                    'value' => 'true',
                    'order' => 1,
                    'scoring' => $categories->pluck('code')->mapWithKeys(fn($code) => [$code => 0])->toArray()
                ]);
                $this->options()->create([
                    'option_text' => 'False',
                    'value' => 'false',
                    'order' => 2,
                    'scoring' => $categories->pluck('code')->mapWithKeys(fn($code) => [$code => 0])->toArray()
                ]);
                break;
                
            case 'likert_3':
                for ($i = 1; $i <= 3; $i++) {
                    $this->options()->create([
                        'option_text' => (string)$i,
                        'value' => (string)$i,
                        'order' => $i,
                        'scoring' => $categories->pluck('code')->mapWithKeys(fn($code) => [$code => 0])->toArray()
                    ]);
                }
                break;
                
            case 'likert_5':
                for ($i = 1; $i <= 5; $i++) {
                    $this->options()->create([
                        'option_text' => (string)$i,
                        'value' => (string)$i,
                        'order' => $i,
                        'scoring' => $categories->pluck('code')->mapWithKeys(fn($code) => [$code => 0])->toArray()
                    ]);
                }
                break;
                
            case 'likert_7':
                for ($i = 1; $i <= 7; $i++) {
                    $this->options()->create([
                        'option_text' => (string)$i,
                        'value' => (string)$i,
                        'order' => $i,
                        'scoring' => $categories->pluck('code')->mapWithKeys(fn($code) => [$code => 0])->toArray()
                    ]);
                }
                break;
        }
    }
}