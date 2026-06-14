<?php

use App\Enums\RoleEnum;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
    $this->user = User::factory()->create([
        'role' => RoleEnum::CANDIDATE->value,
        'email_verified_at' => now(),
    ]);
    $this->user->assignRole(RoleEnum::CANDIDATE->value);
    $this->actingAs($this->user);
});

test('candidate onboarding form can be saved', function () {
    Livewire::test('pages::candidate.onboarding')
        ->set('phone', '612345678')
        ->set('city', 'Douala')
        ->set('region', 'Littoral')
        ->set('language', 'bilingue')
        ->call('nextStep')
        ->assertSet('step', 2)
        ->set('education_level', 'bac')
        ->set('education_field', 'IT')
        ->set('experience', '2')
        ->call('nextStep')
        ->assertSet('step', 3)
        ->call('nextStep')
        ->assertSet('step', 4)
        ->set('availability', 'immediate')
        ->call('save');

    expect($this->user->fresh()->candidateProfile)->not->toBeNull();
});
