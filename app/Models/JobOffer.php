<?php

namespace App\Models;

use App\Enums\AvailabilityEnum;
use App\Enums\DrivingPermitEnum;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\JobStatusEnum;
use App\Enums\JobTemplateEnum;
use App\Enums\LanguageProfileEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOffer extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'recruiter_profile_id', 'title', 'description', 'template',
        'city', 'region', 'country', 'blocking_language',
        'blocking_education', 'blocking_experience', 'blocking_availability',
        'blocking_permit', 'required_experience', 'required_education',
        'required_availability', 'budget_min', 'budget_max', 'required_assets',
        'status', 'published_at', 'expires_at'
    ];

    protected $casts = [
        'template' => JobTemplateEnum::class,
        'blocking_language' => LanguageProfileEnum::class,
        'blocking_education' => EducationLevelEnum::class,
        'blocking_experience' => ExperienceTierEnum::class,
        'blocking_availability' => AvailabilityEnum::class,
        'blocking_permit' => DrivingPermitEnum::class,
        'required_experience' => ExperienceTierEnum::class,
        'required_education' => EducationLevelEnum::class,
        'required_availability' => AvailabilityEnum::class,
        'status' => JobStatusEnum::class,
        'required_assets' => 'json',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function recruiterProfile(): BelongsTo
    {
        return $this->belongsTo(RecruiterProfile::class);
    }

    public function jobRequiredSkills(): HasMany
    {
        return $this->hasMany(JobRequiredSkill::class);
    }

    public function matchResults(): HasMany
    {
        return $this->hasMany(MatchResult::class);
    }
}
