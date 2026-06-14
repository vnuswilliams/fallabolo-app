<?php

use App\Enums\RoleEnum;
use App\Models\RecruiterProfile;
use App\Models\Skill;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Livewire\Livewire;

beforeEach(function () {
    // Run seeders for roles
    $this->seed(RoleAndPermissionSeeder::class);

    $this->user = User::factory()->create([
        'role' => RoleEnum::RECRUITER->value,
        'email_verified_at' => now(),
    ]);

    // Assign Spatie role
    $this->user->assignRole(RoleEnum::RECRUITER->value);

    $this->profile = RecruiterProfile::factory()->create([
        'user_id' => $this->user->id,
        'is_suspended' => false,
    ]);

    $this->actingAs($this->user);
});

test('recruiter can visit create offer page', function () {
    $this->get(route('recruiter.offers.create'))
        ->assertOk();
});

test('simulations are empty when no skills selected', function () {
    Livewire::test('pages::recruiter.offers.create')
        ->assertSet('step', 1)
        ->set('step', 3)
        ->assertCount('simulations', 0);
});

test('simulations provide results when skills are added', function () {
    $skill = Skill::factory()->create(['name' => 'PHP']);

    Livewire::test('pages::recruiter.offers.create')
        ->set('step', 3)
        ->set('selected_skills', [$skill->id => 4])
        ->assertCount('simulations', 3)
        ->assertSee('Candidat Idéal')
        ->assertSee('100%');
});

test('blocking criteria correctly blocks simulation candidates', function () {
    $skill = Skill::factory()->create(['name' => 'PHP']);

    // Candidat Junior has experience tier 0 and education BAC
    Livewire::test('pages::recruiter.offers.create')
        ->set('step', 3)
        ->set('selected_skills', [$skill->id => 4])
        // Set blocking criteria that Junior won't meet (e.g. Experience 3)
        ->set('block_experience', true)
        ->set('min_experience', '3')
        ->assertSee('Bloqué');
});

test('changing template affects simulated scores', function () {
    $skill = Skill::factory()->create(['name' => 'PHP']);

    // We compare scores between Technicien and Dirigeant for the same skill gap

    $component = Livewire::test('pages::recruiter.offers.create')
        ->set('step', 3)
        ->set('selected_skills', [$skill->id => 5])
        ->set('template', 'technicien');

    $scoreTechnicien = $component->get('simulations')->where('name', 'Candidat Junior')->first()['result']['score_principal'];

    $component->set('template', 'dirigeant');
    $scoreDirigeant = $component->get('simulations')->where('name', 'Candidat Junior')->first()['result']['score_principal'];

    expect($scoreDirigeant)->toBeLessThan($scoreTechnicien);
});
