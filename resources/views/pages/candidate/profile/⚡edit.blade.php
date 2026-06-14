<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\CandidateProfile;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\AvailabilityEnum;
use App\Enums\LanguageProfileEnum;
use App\Enums\CityEnum;
use App\Enums\RegionEnum;
use Illuminate\Support\Facades\Auth;
use Flux\Flux;

new #[Title('Modifier mon Profil')] class extends Component {
    public string $name = '';
    public string $phone = '';
    public string $city = '';
    public string $region = '';
    public string $language = '';
    public string $education_level = '';
    public string $education_field = '';
    public string $experience = '';
    public string $availability = '';
    public ?int $salary_min = null;
    public ?int $salary_max = null;

    public function mount()
    {
        $user = Auth::user();
        $profile = $user->candidateProfile;

        $this->name = $user->name;

        if ($profile) {
            $this->phone = $profile->phone ?? '';
            $this->city = $profile->city ?? 'Douala';
            $this->region = $profile->region ?? 'Littoral';
            $this->language = $profile->language_profile->value;
            $this->education_level = $profile->education_level->value;
            $this->education_field = $profile->education_field ?? '';
            $this->experience = $profile->experience_tier->value;
            $this->availability = $profile->availability->value;
            $this->salary_min = $profile->salary_min;
            $this->salary_max = $profile->salary_max;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|min:3',
            'phone' => 'required|string|min:9',
            'city' => 'required|string',
            'region' => 'required|string',
            'language' => 'required|string',
            'education_level' => 'required|string',
            'experience' => 'required|string',
            'availability' => 'required|string',
        ]);

        $user = Auth::user();
        $user->update(['name' => $this->name]);

        $user->candidateProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $this->phone,
                'city' => $this->city,
                'region' => $this->region,
                'language_profile' => $this->language,
                'education_level' => $this->education_level,
                'education_field' => $this->education_field,
                'experience_tier' => $this->experience,
                'availability' => $this->availability,
                'salary_min' => $this->salary_min,
                'salary_max' => $this->salary_max,
            ]
        );

        Flux::toast(
            variant: 'success',
            heading: 'Profil mis à jour',
            text: 'Vos informations ont été enregistrées avec succès.',
        );

        return redirect()->route('candidate.profile.index');
    }
}; ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <flux:button :href="route('candidate.profile.index')" variant="ghost" icon="arrow-left" size="sm" class="mb-4" wire:navigate>
            Retour au profil
        </flux:button>
        <flux:heading size="xl">Modifier mon profil</flux:heading>
        <flux:subheading>Mettez à jour vos informations personnelles et professionnelles.</flux:subheading>
    </div>

    <flux:card class="p-8">
        <form wire:submit="save" class="space-y-8">
            {{-- Informations de base --}}
            <div class="space-y-6">
                <flux:heading size="lg">Informations de base</flux:heading>
                
                <flux:field>
                    <flux:label>Nom complet</flux:label>
                    <flux:input wire:model="name" />
                    <flux:error name="name" />
                </flux:field>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Téléphone</flux:label>
                        <flux:input wire:model="phone" type="tel" placeholder="6XX XX XX XX" />
                        <flux:error name="phone" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Profil linguistique</flux:label>
                        <flux:select wire:model="language">
                            @foreach(LanguageProfileEnum::cases() as $item)
                                <flux:select.option value="{{ $item->value }}">{{ $item->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Ville</flux:label>
                        <flux:select wire:model="city">
                            @foreach(CityEnum::cases() as $item)
                                <flux:select.option value="{{ $item->value }}">{{ $item->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Région</flux:label>
                        <flux:select wire:model="region">
                            @foreach(RegionEnum::cases() as $item)
                                <flux:select.option value="{{ $item->value }}">{{ $item->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                </div>
            </div>

            <flux:separator />

            {{-- Parcours & Formation --}}
            <div class="space-y-6">
                <flux:heading size="lg">Parcours & Formation</flux:heading>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Niveau de formation</flux:label>
                        <flux:select wire:model="education_level">
                            @foreach (EducationLevelEnum::cases() as $level)
                                <flux:select.option value="{{ $level->value }}">{{ $level->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Domaine d'études</flux:label>
                        <flux:input wire:model="education_field" placeholder="Ex: Génie Logiciel" />
                    </flux:field>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Expérience globale</flux:label>
                        <flux:select wire:model="experience">
                            @foreach (ExperienceTierEnum::cases() as $tier)
                                <flux:select.option value="{{ $tier->value }}">{{ $tier->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Votre disponibilité</flux:label>
                        <flux:select wire:model="availability">
                            @foreach (AvailabilityEnum::cases() as $avail)
                                <flux:select.option value="{{ $avail->value }}">{{ $avail->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                </div>
            </div>

            <flux:separator />

            {{-- Prétentions --}}
            <div class="space-y-6">
                <flux:heading size="lg">Prétentions salariales</flux:heading>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Salaire min. souhaité (FCFA)</flux:label>
                        <flux:input wire:model="salary_min" type="number" placeholder="Ex: 250000" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Salaire max. souhaité (FCFA)</flux:label>
                        <flux:input wire:model="salary_max" type="number" placeholder="Ex: 500000" />
                    </flux:field>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <flux:button type="submit" variant="primary" class="flex-1">
                    Enregistrer les modifications
                </flux:button>
                <flux:button :href="route('candidate.profile.index')" variant="ghost" class="flex-1" wire:navigate>
                    Annuler
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>


