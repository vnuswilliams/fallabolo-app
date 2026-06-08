<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\CandidateProfile;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\AvailabilityEnum;
use App\Enums\LanguageProfileEnum;
use Illuminate\Support\Facades\Auth;

new #[Title('Compléter mon profil')] class extends Component {
    public int $step = 1;

    // Step 1: Personal
    public string $phone = '';
    public string $city = 'Douala';
    public string $region = 'Littoral';
    public string $language = 'bilingue';

    // Step 2: Professional
    public string $education_level = 'bac';
    public string $education_field = '';
    public string $experience = '1';

    // Step 3: Skills
    public array $selected_skills = [];

    // Step 4: Availability & Salary
    public string $availability = 'immediate';
    public ?int $salary_min = null;
    public ?int $salary_max = null;

    public function nextStep()
    {
        $this->step++;
    }

    public function prevStep()
    {
        $this->step--;
    }

    public function save()
    {
        // UI Scaffolding - Simulate profile creation
        Auth::user()->candidateProfile()->create([
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
        ]);

        return redirect()->route('candidate.dashboard');
    }

    public function getStepTitle() {
        return match($this->step) {
            1 => 'Informations personnelles',
            2 => 'Parcours professionnel',
            3 => 'Vos compétences',
            4 => 'Disponibilité & Prétentions',
        };
    }
}; ?>

<div class="min-h-screen bg-zinc-950 flex flex-col items-center justify-center p-6 pb-12">
    <div class="w-full max-w-2xl space-y-8">
        {{-- Header --}}
        <div class="text-center space-y-2">
            <div class="flex justify-center mb-6">
                 <span class="grid size-12 place-items-center rounded-xl bg-zinc-50 text-zinc-950 font-black text-xl">
                    sq
                </span>
            </div>
            <flux:heading size="xl" class="text-white">Finalisez votre profil</flux:heading>
            <flux:text >Étape {{ $step }} sur 4 : {{ $this->getStepTitle() }}</flux:text>

            <div class="flex gap-2 justify-center mt-6">
                @for ($i = 1; $i <= 4; $i++)
                    <div @class([
                        'h-1.5 w-16 rounded-full transition-colors',
                        'bg-emerald-500' => $i <= $step,
                        'bg-zinc-800' => $i > $step,
                    ])></div>
                @endfor
            </div>
        </div>

        <flux:card class="p-8 bg-zinc-900 border-zinc-800">
            @if ($step === 1)
                {{-- Étape 1 — Informations personnelles --}}
                <div class="space-y-6">
                    <flux:field>
                        <flux:label class="text-zinc-300">Numéro de téléphone</flux:label>
                        <flux:input wire:model="phone" type="tel" placeholder="6XX XX XX XX" class="bg-zinc-800 border-zinc-700 text-white" />
                    </flux:field>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label class="text-zinc-300">Ville</flux:label>
                            <flux:select wire:model="city" class="bg-zinc-800 border-zinc-700 text-white">
                                <flux:select.option value="Douala">Douala</flux:select.option>
                                <flux:select.option value="Yaoundé">Yaoundé</flux:select.option>
                                <flux:select.option value="Bafoussam">Bafoussam</flux:select.option>
                                <flux:select.option value="Autre">Autre</flux:select.option>
                            </flux:select>
                        </flux:field>

                        <flux:field>
                            <flux:label class="text-zinc-300">Région</flux:label>
                            <flux:select wire:model="region" class="bg-zinc-800 border-zinc-700 text-white">
                                <flux:select.option value="Littoral">Littoral</flux:select.option>
                                <flux:select.option value="Centre">Centre</flux:select.option>
                                <flux:select.option value="Ouest">Ouest</flux:select.option>
                                <flux:select.option value="Sud-Ouest">Sud-Ouest</flux:select.option>
                                <flux:select.option value="Nord-Ouest">Nord-Ouest</flux:select.option>
                            </flux:select>
                        </flux:field>
                    </div>

                    <flux:field>
                        <flux:label class="text-zinc-300">Profil linguistique</flux:label>
                        <flux:select wire:model="language" class="bg-zinc-800 border-zinc-700 text-white">
                            <flux:select.option value="francophone">Francophone</flux:select.option>
                            <flux:select.option value="anglophone">Anglophone</flux:select.option>
                            <flux:select.option value="bilingue">Bilingue</flux:select.option>
                        </flux:select>
                    </flux:field>
                </div>
            @elseif ($step === 2)
                {{-- Étape 2 — Parcours professionnel --}}
                <div class="space-y-6">
                    <flux:field>
                        <flux:label class="text-zinc-300">Niveau de formation</flux:label>
                        <flux:select wire:model="education_level" class="bg-zinc-800 border-zinc-700 text-white">
                            @foreach (EducationLevelEnum::cases() as $level)
                                <flux:select.option value="{{ $level->value }}">{{ $level->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label class="text-zinc-300">Domaine d'études</flux:label>
                        <flux:input wire:model="education_field" placeholder="Ex: Génie Logiciel, Comptabilité..." class="bg-zinc-800 border-zinc-700 text-white" />
                    </flux:field>

                    <flux:field>
                        <flux:label class="text-zinc-300">Expérience globale</flux:label>
                        <flux:select wire:model="experience" class="bg-zinc-800 border-zinc-700 text-white">
                            @foreach (ExperienceTierEnum::cases() as $tier)
                                <flux:select.option value="{{ $tier->value }}">{{ $tier->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                </div>
            @elseif ($step === 3)
                {{-- Étape 3 — Compétences --}}
                <div class="space-y-6">
                    <flux:heading size="lg" class="text-white">Quelles sont vos compétences ?</flux:heading>
                    <flux:text >Ajoutez au moins 3 compétences pour un meilleur matching.</flux:text>

                    <div class="flex gap-2">
                        <flux:input placeholder="Rechercher une compétence..." class="flex-1 bg-zinc-800 border-zinc-700 text-white" />
                        <flux:button icon="plus" class="bg-emerald-500 text-zinc-950">Ajouter</flux:button>
                    </div>

                    <div class="space-y-4 pt-4">
                        @foreach (['Laravel', 'PHP', 'MySQL'] as $s)
                            <div class="flex items-center justify-between p-4 bg-zinc-800/50 rounded-xl border border-zinc-700">
                                <flux:text class="text-white font-medium">{{ $s }}</flux:text>
                                <div class="flex items-center gap-4">
                                    <div class="flex gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button class="w-6 h-6 rounded-lg border border-zinc-700 flex items-center justify-center transition-colors {{ $i <= 4 ? 'bg-emerald-500 border-emerald-400 text-zinc-950' : 'text-zinc-500' }}">
                                                {{ $i }}
                                            </button>
                                        @endfor
                                    </div>
                                    <flux:button size="xs" variant="ghost" icon="x-mark" class="text-zinc-500" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif ($step === 4)
                {{-- Étape 4 — Disponibilité & Prétentions --}}
                <div class="space-y-6">
                    <flux:field>
                        <flux:label class="text-zinc-300">Votre disponibilité</flux:label>
                        <flux:select wire:model="availability" class="bg-zinc-800 border-zinc-700 text-white">
                            @foreach (AvailabilityEnum::cases() as $avail)
                                <flux:select.option value="{{ $avail->value }}">{{ $avail->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label class="text-zinc-300">Salaire min. souhaité (FCFA)</flux:label>
                            <flux:input wire:model="salary_min" type="number" placeholder="Ex: 250000" class="bg-zinc-800 border-zinc-700 text-white" />
                        </flux:field>

                        <flux:field>
                            <flux:label class="text-zinc-300">Salaire max. souhaité (FCFA)</flux:label>
                            <flux:input wire:model="salary_max" type="number" placeholder="Ex: 500000" class="bg-zinc-800 border-zinc-700 text-white" />
                        </flux:field>
                    </div>

                    <flux:field>
                        <flux:label class="text-zinc-300">Curriculum Vitae (Optionnel)</flux:label>
                        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-zinc-700 border-dashed rounded-xl bg-zinc-800/30">
                            <div class="space-y-1 text-center">
                                <flux:icon.document-arrow-up class="mx-auto h-12 w-12 text-zinc-500" />
                                <div class="flex text-sm text-zinc-400">
                                    <label class="relative cursor-pointer rounded-md font-medium text-emerald-500 hover:text-emerald-400">
                                        <span>Téléverser un fichier</span>
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-zinc-500">PDF jusqu'à 5Mo</p>
                            </div>
                        </div>
                    </flux:field>
                </div>
            @endif
        </flux:card>

        {{-- Footer Actions --}}
        <div class="flex justify-between items-center">
            @if ($step > 1)
                <flux:button wire:click="prevStep" variant="ghost" class="text-zinc-400 hover:text-white">Précédent</flux:button>
            @else
                <div></div>
            @endif

            <div class="flex gap-4">
                @if ($step < 4)
                    <flux:button wire:click="nextStep" variant="primary" class="bg-emerald-500 text-zinc-950 font-bold px-8">Continuer</flux:button>
                @else
                    <flux:button wire:click="save" variant="primary" class="bg-emerald-500 text-zinc-950 font-bold px-8">Terminer mon profil</flux:button>
                @endif
            </div>
        </div>
    </div>
</div>
