<?php

namespace App\Models;

use App\Enums\AvailabilityEnum;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\LanguageProfileEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CandidateProfile extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'phone',
        'city',
        'region',
        'country',
        'language_profile',
        'availability',
        'experience_tier',
        'education_level',
        'education_field',
        'salary_min',
        'salary_max',
        'cv_path',
        'is_suspended',
        'suspended_at',
    ];

    protected function casts(): array
    {
        return [
            'language_profile' => LanguageProfileEnum::class,
            'availability' => AvailabilityEnum::class,
            'experience_tier' => ExperienceTierEnum::class,
            'education_level' => EducationLevelEnum::class,
            'is_suspended' => 'boolean',
            'suspended_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::addGlobalScope('not_suspended', function (Builder $query) {
            $query->where('is_suspended', false);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function candidateSkills(): HasMany
    {
        return $this->hasMany(CandidateSkill::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'candidate_skills')
            ->withPivot('level')
            ->withTimestamps();
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function matchResults(): HasMany
    {
        return $this->hasMany(MatchResult::class);
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function withSuspended(): static
    {
        return $this->withoutGlobalScope('not_suspended');
    }
}
