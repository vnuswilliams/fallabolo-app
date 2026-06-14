<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\CandidateProfile;
use App\Enums\StudyFieldEnum;
use App\Models\CandidateSkill;
use App\Models\Skill;
use App\Models\Asset;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\AvailabilityEnum;
use App\Enums\LanguageProfileEnum;
use App\Enums\CityEnum;
use App\Enums\RegionEnum;
use App\Enums\AssetEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Flux\Flux;

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

    // Step 3: Skills & Assets
    public array $selected_skills = []; // [skill_id => level]
    public array $selected_assets = []; // [asset_id]
    public string $skill_search = '';
    public string $asset_search = '';

    // Step 4: Availability & Salary
    public string $availability = 'immediate';
    public ?int $salary_min = null;
    public ?int $salary_max = null;

public string $skill_search_select = '';
public string $asset_search_select = '';

public function updatedSkillSearchSelect($value): void
{
    if ($value) {
        $this->addSkill((int) $value);
        $this->skill_search_select = '';
    }
}

public function updatedAssetSearchSelect($value): void
{
    if ($value) {
        $this->addAsset((int) $value);
        $this->asset_search_select = '';
    }
}
    public function nextStep()
    {
        $this->validateSteps();
        $this->step++;
    }

    public function prevStep()
    {
        $this->step--;
    }

    protected function validateSteps()
    {
        if ($this->step === 1) {
            $this->validate([
                'phone' => 'required|string|min:9',
                'city' => 'required|string',
                'region' => 'required|string',
                'language' => 'required|string',
            ]);
        }
        if ($this->step === 2) {
            $this->validate([
                'education_level' => 'required',
                'experience' => 'required',
            ]);
        }
    }

    public function addSkill($skillId)
    {
        if (!isset($this->selected_skills[$skillId])) {
            $this->selected_skills[$skillId] = 3;
        }
        $this->skill_search = '';
    }

    public function removeSkill($skillId)
    {
        unset($this->selected_skills[$skillId]);
    }

    public function updateSkillLevel($skillId, $level)
    {
        $this->selected_skills[$skillId] = $level;
    }

    public function addAsset($assetId)
    {
        if (!in_array($assetId, $this->selected_assets)) {
            $this->selected_assets[] = $assetId;
        }
        $this->asset_search = '';
    }

    public function removeAsset($assetId)
    {
        $this->selected_assets = array_filter($this->selected_assets, fn($id) => $id != $assetId);
    }

    public function save()
    {
        $this->validateSteps();

        $profile = Auth::user()->candidateProfile()->create([
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
             'assets' => $this->selected_assets,
        ]);

        foreach ($this->selected_skills as $id => $level) {
            CandidateSkill::create([
                'candidate_profile_id' => $profile->id,
                'skill_id' => $id,
                'level' => $level,
            ]);
        }

        Flux::toast(
            variant: 'success',
            heading: 'Profil complété',
            text: 'Bienvenue sur MatchRH ! Votre profil est maintenant prêt.',
        );

        return redirect()->route('candidate.dashboard');
    }

    public function with()
    {
        return [
            'available_skills' => $this->skill_search ? Skill::whereAny(['name', 'category'], 'like', "%{$this->skill_search}%")
                ->whereNotIn('id', array_keys($this->selected_skills))
                ->limit(10)->get() : collect(),
            'available_assets' => $this->asset_search ? Asset::whereAny(['name', 'category'], 'like', "%{$this->asset_search}%")
                ->whereNotIn('id', $this->selected_assets)
                ->limit(10)->get() : collect(),
             'selected_skills_models' => Skill::whereIn('id', array_keys($this->selected_skills))->get(),
             'selected_assets_models' => Asset::whereIn('id', $this->selected_assets)->get(),
        ];
    }

    public function getStepTitle() {
        return match($this->step) {
            1 => 'Informations personnelles',
            2 => 'Parcours professionnel',
            3 => 'Vos compétences & Atouts',
            4 => 'Disponibilité & Prétentions',
        };
    }
}; ?>

<div class="min-h-screen bg-zinc-950 flex flex-col items-center justify-center p-6 pb-12">
    <div class="w-full max-w-2xl space-y-8">
        {{-- Header --}}
        <div class="text-center space-y-2">
            <div class="flex justify-center mb-6">
                 <x-app-logo-icon class="size-12" />
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
                <div class="space-y-6" wire:key="step-1-container">
                    <flux:field wire:key="field-phone">
                        <flux:label class="text-zinc-300">Numéro de téléphone</flux:label>
                        <flux:input wire:model="phone" type="tel" placeholder="6XX XX XX XX" class="bg-zinc-800 border-zinc-700 text-white" />
                        <flux:error name="phone" />
                    </flux:field>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" wire:key="grid-location">
                        <flux:field wire:key="field-city">
                            <flux:label class="text-zinc-300">Ville</flux:label>
                            <flux:select wire:model="city" class="bg-zinc-800 border-zinc-700 text-white">
                                @foreach(CityEnum::cases() as $item)
                                    <flux:select.option value="{{ $item->value }}">{{ $item->label() }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:field>

                        <flux:field wire:key="field-region">
                            <flux:label class="text-zinc-300">Région</flux:label>
                            <flux:select wire:model="region" class="bg-zinc-800 border-zinc-700 text-white">
                                @foreach(RegionEnum::cases() as $item)
                                    <flux:select.option value="{{ $item->value }}">{{ $item->label() }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:field>
                    </div>

                    <flux:field wire:key="field-language">
                        <flux:label class="text-zinc-300">Profil linguistique</flux:label>
                        <flux:select wire:model="language" class="bg-zinc-800 border-zinc-700 text-white">
                            @foreach(LanguageProfileEnum::cases() as $item)
                                <flux:select.option value="{{ $item->value }}">{{ $item->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                </div>
            @elseif ($step === 2)
                {{-- Étape 2 — Parcours professionnel --}}
                <div class="space-y-6" wire:key="step-2-container">
                    <flux:field wire:key="field-education-level">
                        <flux:label class="text-zinc-300">Niveau de formation</flux:label>
                        <flux:select wire:model="education_level" class="bg-zinc-800 border-zinc-700 text-white">
                            @foreach (EducationLevelEnum::cases() as $level)
                                <flux:select.option value="{{ $level->value }}">{{ $level->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <flux:field wire:key="field-education-field">
                        <flux:label class="text-zinc-300">Domaine d'études</flux:label>
                        <flux:select wire:model="education_field" >
                            <flux:select.option value="" >Choisir un domaine d'etude </flux:select.option>
@foreach(StudyFieldEnum::cases as $field)
                        <flux:select.option value="{{ $field->value }}" >{{ $field->label() }} </flux:select.option>
                        @endforeach
                        </flux:select>
                    </flux:field>

                    <flux:field wire:key="field-experience">
                        <flux:label class="text-zinc-300">Expérience globale</flux:label>
                        <flux:select wire:model="experience" class="bg-zinc-800 border-zinc-700 text-white">
                            @foreach (ExperienceTierEnum::cases() as $tier)
                                <flux:select.option value="{{ $tier->value }}">{{ $tier->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                </div>
            @elseif ($step === 3)
                {{-- Étape 3 — Compétences & Atouts --}}
                <div class="space-y-8" wire:key="step-3-container">
                    <div class="space-y-4" wire:key="skills-section">
                        <flux:heading size="lg" class="text-white">Vos compétences</flux:heading>
                        <flux:text >Ajoutez vos compétences clés et évaluez votre niveau (1 à 5).</flux:text>

                        <div class="space-y-2" wire:key="skills-search-container">
    {{-- Select groupé par catégorie --}}
    <flux:select
        wire:model.live="skill_search_select"
        placeholder="Choisir depuis la liste..."
        searchable
        class="bg-zinc-800 border-zinc-700 text-white"
    >
        @foreach (\App\Enums\SkillCategoryEnum::cases() as $cat)
            @php
                $skillsInCat = \App\Models\Skill::where('category', $cat->label())
                    ->whereNotIn('id', array_keys($selected_skills))
                    ->get();
            @endphp
            @if ($skillsInCat->isNotEmpty())
                <flux:select.option  class="text-zinc-500 font-bold text-xs uppercase">
                    ── {{ $cat->label() }}
                </flux:select.option>
                @foreach ($skillsInCat as $skill)
                    <flux:select.option value="{{ $skill->id }}">
                        {{ \App\Enums\SkillEnum::tryFrom(Str::lower($skill->name))?->label() ?? $skill->name }}
                    </flux:select.option>
                @endforeach
            @endif
        @endforeach
    </flux:select>

    {{-- Barre de recherche libre (existante) --}}
    <div class="relative" wire:key="skills-search-input-wrapper">
        <flux:input wire:model.live.debounce.300ms="skill_search" icon="magnifying-glass" placeholder="Ou rechercher librement..." class="bg-zinc-800 border-zinc-700 text-white" />
        @if ($available_skills->isNotEmpty())
            <div class="absolute z-10 w-full mt-1 bg-zinc-800 border border-zinc-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                @foreach ($available_skills as $skill)
                    <button wire:click="addSkill({{ $skill->id }})" class="w-full text-left px-4 py-2 hover:bg-zinc-700 transition-colors" wire:key="available-skill-{{ $skill->id }}">
                        <flux:text class="text-white font-medium">
                            {{ \App\Enums\SkillEnum::tryFrom(Str::lower($skill->name))?->label() ?? $skill->name }}
                        </flux:text>
                        <flux:text size="xs" class="block text-zinc-400">{{ $skill->category }}</flux:text>
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</div>

                        <div class="space-y-3" wire:key="selected-skills-list">
                            @foreach ($selected_skills_models as $skill)
                                <div class="flex items-center justify-between p-3 bg-zinc-800/30 rounded-xl border border-zinc-800" wire:key="skill-{{ $skill->id }}">
                                    <flux:text class="text-white font-medium">
                                        {{ \App\Enums\SkillEnum::tryFrom(Str::lower($skill->name))?->label() ?? $skill->name }}
                                    </flux:text>
                                    <div class="flex items-center gap-4">
                                        <div class="flex gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <button wire:click="updateSkillLevel({{ $skill->id }}, {{ $i }})" @class([
                                                    'w-5 h-5 rounded-md text-[10px] font-bold flex items-center justify-center transition-colors',
                                                    'bg-emerald-500 text-zinc-950' => $i <= $selected_skills[$skill->id],
                                                    'bg-zinc-800 text-zinc-500 border border-zinc-700 hover:border-emerald-500' => $i > $selected_skills[$skill->id],
                                                ]) wire:key="skill-{{ $skill->id }}-level-{{ $i }}">
                                                    {{ $i }}
                                                </button>
                                            @endfor
                                        </div>
                                        <flux:button size="xs" variant="ghost" icon="x-mark" class="text-zinc-500" wire:click="removeSkill({{ $skill->id }})" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <flux:separator class="bg-zinc-800" />

                    <div class="space-y-4" wire:key="assets-section">
                        <flux:heading size="lg" class="text-white">Vos atouts supplémentaires</flux:heading>
                        <flux:text >Secteurs d'expérience, certifications, soft skills...</flux:text>
                        
                        <div class="space-y-2" wire:key="assets-search-container">
    {{-- Select groupé par catégorie --}}
    <flux:select
        wire:model.live="asset_search_select"
        placeholder="Choisir depuis la liste..."
        searchable
        class="bg-zinc-800 border-zinc-700 text-white"
    >
        @foreach (\App\Enums\AssetCategoryEnum::cases() as $cat)
            @php
                $assetsInCat = \App\Models\Asset::where('category', $cat->label())
                    ->whereNotIn('id', $selected_assets)
                    ->where('is_active', true)
                    ->get();
            @endphp
            @if ($assetsInCat->isNotEmpty())
                <flux:select.option  class="text-zinc-500 font-bold text-xs uppercase">
                    ── {{ $cat->label() }}
                </flux:select.option>
                @foreach ($assetsInCat as $asset)
                    <flux:select.option value="{{ $asset->id }}">
                        {{ \App\Enums\AssetEnum::tryFrom(Str::lower($asset->name))?->label() ?? $asset->name }}
                        </flux:select.option>
                @endforeach
            @endif
        @endforeach
    </flux:select>

    {{-- Barre de recherche libre (existante) --}}
    <div class="relative" wire:key="assets-search-input-wrapper">
        <flux:input wire:model.live.debounce.300ms="asset_search" icon="magnifying-glass" placeholder="Ou rechercher librement..." class="bg-zinc-800 border-zinc-700 text-white" />
        @if ($available_assets->isNotEmpty())
            <div class="absolute z-10 w-full mt-1 bg-zinc-800 border border-zinc-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                @foreach ($available_assets as $asset)
                    <button wire:click="addAsset({{ $asset->id }})" class="w-full text-left px-4 py-2 hover:bg-zinc-700 transition-colors" wire:key="available-asset-{{ $asset->id }}">
                        <flux:text class="text-white font-medium">{{ $asset->name }}</flux:text>
                        <flux:text size="xs" class="block text-zinc-400">{{ \App\Enums\AssetCategoryEnum::from($asset->category)->label() }}</flux:text>
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</div>

                        <div class="flex flex-wrap gap-2" wire:key="selected-assets-list">
                            @foreach ($selected_assets_models as $asset)
                                <flux:badge color="emerald" variant="pill" class="pl-3 pr-1 py-1 gap-2 bg-emerald-500/10 border-emerald-500/20 text-emerald-400" wire:key="asset-badge-{{ $asset->id }}">
                        {{ \App\Enums\AssetEnum::tryFrom(Str::lower($asset->name))?->label() ?? $asset->name }}
                                    <button wire:click="removeAsset({{ $asset->id }})" class="hover:text-white">
                                        <flux:icon.x-mark class="size-3" />
                                    </button>
                                </flux:badge>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif ($step === 4)
                {{-- Étape 4 — Disponibilité & Prétentions --}}
                <div class="space-y-6" wire:key="step-4-container">
                    <flux:field wire:key="field-availability">
                        <flux:label class="text-zinc-300">Votre disponibilité</flux:label>
                        <flux:select wire:model="availability" class="bg-zinc-800 border-zinc-700 text-white">
                            @foreach (AvailabilityEnum::cases() as $avail)
                                <flux:select.option value="{{ $avail->value }}">{{ $avail->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" wire:key="grid-salary">
                        <flux:field wire:key="field-salary-min">
                            <flux:label class="text-zinc-300">Salaire min. souhaité (FCFA)</flux:label>
                            <flux:input wire:model="salary_min" type="number" placeholder="Ex: 250000" class="bg-zinc-800 border-zinc-700 text-white" />
                        </flux:field>

                        <flux:field wire:key="field-salary-max">
                            <flux:label class="text-zinc-300">Salaire max. souhaité (FCFA)</flux:label>
                            <flux:input wire:model="salary_max" type="number" placeholder="Ex: 500000" class="bg-zinc-800 border-zinc-700 text-white" />
                        </flux:field>
                    </div>

                    <flux:field wire:key="field-cv">
                        <flux:label class="text-zinc-300">Curriculum Vitae (Optionnel)</flux:label>
                        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-zinc-700 border-dashed rounded-xl bg-zinc-800/30">
                            <div class="space-y-1 text-center">
                                <flux:icon.document-arrow-up class="mx-auto h-12 w-12 text-zinc-500" />
                                <div class="flex text-sm text-zinc-400">
                                    <label class="relative cursor-pointer rounded-md font-medium text-emerald-500 hover:text-emerald-400">
                                        <span>Téléverser un fichier</span>
                                    </label>
                                    <p class="pl-1 text-zinc-500">ou glisser-déposer</p>
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
                <flux:button wire:click="prevStep" variant="ghost" class="text-zinc-400 hover:text-zinc-100">Précédent</flux:button>
            @else
                <div></div>
            @endif

            <div class="flex gap-4">
                @if ($step < 4)
                    <flux:button wire:click="nextStep" variant="primary" class="bg-emerald-500 hover:bg-emerald-400 text-zinc-950 font-bold px-8 border-none transition-all">Continuer</flux:button>
                @else
                    <flux:button wire:click="save" color="emerald" variant="primary" class="bg-emerald-500 hover:bg-emerald-400 text-zinc-950 font-bold px-8 border-none transition-all shadow-lg shadow-emerald-500/20">Terminer mon profil</flux:button>
                @endif
            </div>
        </div>
    </div>
</div>

