<?php

namespace App\Mcp\Tools;

use App\Models\JobOffer;
use App\Enums\JobStatusEnum;
use App\Enums\JobTemplateEnum;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\AvailabilityEnum;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('create_job_offer')]
#[Description('Create a new job offer on MatchRH.')]
class CreateJobOffer extends Tool
{
    /**
     * Handle the tool execution.
     * 
     * @param string $recruiter_profile_id The UUID of the recruiter profile.
     * @param string $title The title of the job offer.
     * @param string $description A detailed description of the job.
     * @param string $city The city where the job is located.
     * @param string $template The job template (e.g., technicien, commercial, manager).
     * @param string $min_education Minimum education level (bac, bts, licence, master, doctorat).
     * @param string $min_experience Minimum experience (0, 1, 3, 5, 10).
     * @param string $max_availability Maximum availability (immediate, 15_days, 30_days, 60_days, 90_days).
     */
    public function handle(
        string $recruiter_profile_id,
        string $title,
        string $description,
        string $city,
        string $template,
        string $min_education,
        string $min_experience,
        string $max_availability
    ): mixed {
        $offer = JobOffer::create([
            'recruiter_profile_id' => $recruiter_profile_id,
            'title' => $title,
            'description' => $description,
            'template' => JobTemplateEnum::tryFrom($template) ?? JobTemplateEnum::TECHNICIEN,
            'city' => $city,
            'required_education' => EducationLevelEnum::tryFrom($min_education) ?? EducationLevelEnum::BAC,
            'required_experience' => ExperienceTierEnum::tryFrom($min_experience) ?? ExperienceTierEnum::TIER_0,
            'required_availability' => AvailabilityEnum::tryFrom($max_availability) ?? AvailabilityEnum::IMMEDIATE,
            'status' => JobStatusEnum::PUBLISHED,
            'published_at' => now(),
        ]);

        return "Job offer created successfully with ID: {$offer->id}";
    }
}
