<?php

namespace App\Mcp\Tools;

use App\Models\JobOffer;
use App\Enums\JobStatusEnum;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('list_job_offers')]
#[Description('List all available job offers on MatchRH.')]
class ListJobOffers extends Tool
{
    /**
     * Handle the tool execution.
     */
    public function handle(): mixed
    {
        return JobOffer::with('recruiterProfile')
            ->where('status', JobStatusEnum::PUBLISHED)
            ->latest()
            ->get()
            ->map(fn ($offer) => [
                'id' => $offer->id,
                'title' => $offer->title,
                'company' => $offer->recruiterProfile->company_name,
                'city' => $offer->city,
                'description' => $offer->description,
                'salary' => $offer->budget_min . ' - ' . $offer->budget_max . ' FCFA',
                'published_at' => $offer->published_at?->toDateTimeString(),
            ]);
    }
}
