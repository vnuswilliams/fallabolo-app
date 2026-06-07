<?php

namespace App\Models;

use App\Enums\AvailabilityEnum;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\LanguageProfileEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CandidateProfile extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id', 'phone', 'city', 'region', 'country',
        'language_profile', 'availability', 'experience_tier',
        'education_level', 'education_field', 'salary_min',
        'salary_max', 'cv_path'
    ];

    protected $casts = [
        'language_profile' => LanguageProfileEnum::class,
        'availability' => AvailabilityEnum::class,
        'experience_tier' => ExperienceTierEnum::class,
        'education_level' => EducationLevelEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function candidateSkills(): HasMany
    {
        return $this->hasMany(CandidateSkill::class);
    }

    public function matchResults(): HasMany
    {
        return $this->hasMany(MatchResult::class);
    }
}
