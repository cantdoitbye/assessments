<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
class AssessmentCode extends Model
{
    protected $fillable = [
        'assessment_id',
        'code',
        'description',
        'is_active',
        'usage_count',
        'max_usage',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_usage && $this->usage_count >= $this->max_usage) {
            return false;
        }

        return true;
    }

    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    public static function findValidCode(string $code, int $assessmentId): ?self
    {
        return self::where('code', $code)
            ->where('assessment_id', $assessmentId)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->where(function ($query) {
                $query->whereNull('max_usage')
                    ->orWhereRaw('usage_count < max_usage');
            })
            ->first();
    }

}
