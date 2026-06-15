<?php

namespace App\Mcp\Tools;

use App\Models\JobOffer;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('get_job_offer_details')]
#[Description('Get full details of a specific job offer by its ID.')]
class GetJobOfferDetails extends Tool
{
    /**
     * Handle the tool execution.
     */
    public function handle(string $id): mixed
    {
        $offer = JobOffer::with(['recruiterProfile', 'jobRequiredSkills.skill'])
            ->findOrFail($id);

        return [
            'id' => $offer->id,
            'title' => $offer->title,
            'company' => $offer->recruiterProfile->company_name,
            'city' => $offer->city,
            'region' => $offer->region,
            'country' => $offer->country,
            'description' => $offer->description,
            'budget' => $offer->budget_min . ' - ' . $offer->budget_max . ' FCFA',
            'required_education' => $offer->required_education->value,
            'required_experience' => $offer->required_experience->value,
            'required_availability' => $offer->required_availability->value,
            'skills' => $offer->jobRequiredSkills->map(fn ($s) => [
                'name' => $s->skill->name,
                'level' => $s->level_required,
            ]),
            'published_at' => $offer->published_at?->toDateTimeString(),
        ];
    }
}
