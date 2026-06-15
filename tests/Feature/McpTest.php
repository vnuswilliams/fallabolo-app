<?php

use App\Models\JobOffer;
use App\Models\RecruiterProfile;
use App\Models\User;
use App\Enums\JobStatusEnum;
use App\Mcp\Tools\ListJobOffers;
use App\Mcp\Tools\CreateJobOffer;
use App\Mcp\Tools\ListRecruiters;
use App\Mcp\Tools\GetJobOfferDetails;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('list_job_offers tool returns published offers', function () {
    $recruiter = RecruiterProfile::factory()->create();
    
    JobOffer::create([
        'recruiter_profile_id' => $recruiter->id,
        'title' => 'Test Offer Published',
        'description' => 'Description',
        'city' => 'Douala',
        'template' => 'technicien',
        'required_education' => 'bac',
        'required_experience' => '1',
        'required_availability' => 'immediate',
        'status' => JobStatusEnum::PUBLISHED,
        'published_at' => now(),
    ]);

    JobOffer::create([
        'recruiter_profile_id' => $recruiter->id,
        'title' => 'Test Offer Draft',
        'description' => 'Description',
        'city' => 'Yaoundé',
        'template' => 'technicien',
        'required_education' => 'bac',
        'required_experience' => '1',
        'required_availability' => 'immediate',
        'status' => JobStatusEnum::DRAFT,
    ]);

    $tool = new ListJobOffers();
    $result = $tool->handle();

    expect($result)->toHaveCount(1);
    expect($result[0]['title'])->toBe('Test Offer Published');
});

test('create_job_offer tool creates a new offer', function () {
    $recruiter = RecruiterProfile::factory()->create();

    $tool = new CreateJobOffer();
    $result = $tool->handle(
        recruiter_profile_id: $recruiter->id,
        title: 'New MCP Offer',
        description: 'Created via MCP tool',
        city: 'Limbe',
        template: 'cadre',
        min_education: 'licence',
        min_experience: '2',
        max_availability: '30_days'
    );

    expect($result)->toContain('Job offer created successfully');
    
    $offer = JobOffer::where('title', 'New MCP Offer')->first();
    expect($offer)->not->toBeNull();
    expect($offer->city)->toBe('Limbe');
    expect($offer->status)->toBe(JobStatusEnum::PUBLISHED);
});

test('list_recruiters tool returns all recruiters', function () {
    RecruiterProfile::factory()->count(3)->create();

    $tool = new ListRecruiters();
    $result = $tool->handle();

    expect($result)->toHaveCount(3);
});

test('get_job_offer_details tool returns full details', function () {
    $recruiter = RecruiterProfile::factory()->create(['company_name' => 'Test Corp']);
    $offer = JobOffer::create([
        'recruiter_profile_id' => $recruiter->id,
        'title' => 'Detailed Offer',
        'description' => 'Full description here',
        'city' => 'Kribi',
        'region' => 'Sud',
        'country' => 'Cameroon',
        'template' => 'dirigeant',
        'required_education' => 'master',
        'required_experience' => '4',
        'required_availability' => 'more',
        'status' => JobStatusEnum::PUBLISHED,
        'published_at' => now(),
    ]);

    $tool = new GetJobOfferDetails();
    $result = $tool->handle(id: $offer->id);

    expect($result['title'])->toBe('Detailed Offer');
    expect($result['company'])->toBe('Test Corp');
    expect($result['city'])->toBe('Kribi');
    expect($result['description'])->toBe('Full description here');
});
