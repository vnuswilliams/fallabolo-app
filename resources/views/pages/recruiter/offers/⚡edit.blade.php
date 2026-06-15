<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\RecruiterProfile;
use App\Models\Skill;
use App\Models\Asset;
use App\Models\JobOffer;
use App\Models\JobRequiredSkill;
use App\Enums\JobTemplateEnum;
use App\Services\GeoService;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\AvailabilityEnum;
use App\Enums\LanguageProfileEnum;
use App\Enums\DrivingPermitEnum;
use App\Enums\JobStatusEnum;
use App\Enums\SkillEnum;
use App\Enums\AssetEnum;
use App\Services\Scoring\MatchingService;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Flux\Flux;

new #[Title('Modifier l\'offre')] class extends Component {
    public JobOffer $offer;
    public int $step = 1;

    // Geographic properties
    public string $country = 'Cameroon';
    public ?string $region = null;
    public ?string $city = null;
    
    public array $availableCountries = [];
    public array $availableRegions = [];
    public array $availableCities = [];

    public function updatedCountry(string $value)
    {
        $geo = app(GeoService::class);
        $this->region = '';
        $this->city   = '';
        $this->availableRegions = $geo->getStatesByCountry($value);
        $this->availableCities  = $geo->getCitiesByCountry($value);
    }

    public function updatedRegion(string $value)
    {
        $this->city = '';
        $this->availableCities = app(GeoService::class)
            ->getCitiesByState($this->country, $value);
    }

    #[Computed]
    public function simulations()
    {
        if ($this->step < 3 || empty($this->selected_skills)) {
            return collect();
        }

        $service = new MatchingService();
        
        // Création d'une offre temporaire pour le calcul
        $offer = new JobOffer([
            'template' => JobTemplateEnum::tryFrom($this->template) ?? JobTemplateEnum::TECHNICIEN,
            'required_experience' => ExperienceTierEnum::tryFrom($this->min_experience) ?? ExperienceTierEnum::TIER_1,
            'required_education' => EducationLevelEnum::tryFrom($this->min_education) ?? EducationLevelEnum::BAC,
            'required_availability' => AvailabilityEnum::tryFrom($this->max_availability) ?? AvailabilityEnum::IMMEDIATE,
            'city' => $this->city,
            'budget_max' => $this->budget_max,
            'blocking_language' => $this->block_language ? LanguageProfileEnum::tryFrom($this->language) : null,
            'blocking_education' => $this->block_education ? EducationLevelEnum::tryFrom($this->min_education) : null,
            'blocking_experience' => $this->block_experience ? ExperienceTierEnum::tryFrom($this->min_experience) : null,
            'blocking_availability' => $this->block_availability ? AvailabilityEnum::tryFrom($this->max_availability) : null,
        ]);

        $requiredSkills = collect();
        foreach ($this->selected_skills as $id => $level) {
            $requiredSkills->push(new JobRequiredSkill(['skill_id' => $id, 'level_required' => $level]));
        }
        $offer->setRelation('jobRequiredSkills', $requiredSkills);

        // Profils types pour la simulation
        $profiles = [
            [
                'name' => 'Candidat Idéal',
                'data' => [
                    'language_profile' => LanguageProfileEnum::tryFrom($this->language) ?? LanguageProfileEnum::BILINGUE,
                    'education_level' => EducationLevelEnum::from($this->min_education),
                    'experience_tier' => ExperienceTierEnum::from($this->min_experience),
                    'availability' => AvailabilityEnum::from($this->max_availability),
                    'city' => $this->city,
                    'skills' => $this->selected_skills,
                    'salary_min' => $this->budget_min,
                    'salary_max' => $this->budget_max,
                ]
            ],
            [
                'name' => 'Candidat Junior',
                'data' => [
                    'language_profile' => LanguageProfileEnum::FRANCOPHONE,
                    'education_level' => EducationLevelEnum::BAC,
                    'experience_tier' => ExperienceTierEnum::TIER_0,
                    'availability' => AvailabilityEnum::IMMEDIATE,
                    'city' => $this->city,
                    'skills' => array_map(fn($l) => max(1, $l - 2), $this->selected_skills),
                    'salary_min' => $this->budget_min ? $this->budget_min * 0.8 : null,
                ]
            ],
            [
                'name' => 'Candidat Expérimenté (Hors-Ville)',
                'data' => [
                    'language_profile' => LanguageProfileEnum::BILINGUE,
                    'education_level' => EducationLevelEnum::MASTER,
                    'experience_tier' => ExperienceTierEnum::TIER_4,
                    'availability' => AvailabilityEnum::THIRTY_DAYS,
                    'city' => $this->city === 'Douala' ? 'Yaoundé' : 'Douala',
                    'skills' => array_map(fn($l) => min(5, $l + 1), $this->selected_skills),
                    'salary_min' => $this->budget_max ? $this->budget_max * 1.1 : null,
                ]
            ]
        ];

        return collect($profiles)->map(function($profile) use ($service, $offer) {
            return array_merge($profile, [
                'result' => $service->calculate($offer, $profile['data'])
            ]);
        });
    }
    public string $publish_as = 'my_company';
    public ?string $managed_recruiter_id = null;

    // Step 2: Info
    public string $title = '';
    public string $template = 'technicien';
    public string $description = '';
    public ?int $budget_min = null;
    public ?int $budget_max = null;
    public string $language = 'bilingue';

    // Step 3: Criteria
    public string $min_education = 'bac';
    public string $min_experience = '1';
    public string $max_availability = 'immediate';
    public ?string $required_permit = null;

    // Blocking Toggles
    public bool $block_education = false;
    public bool $block_experience = false;
    public bool $block_availability = false;
    public bool $block_language = false;
    public bool $block_permit = false;

    public array $selected_skills = []; // Format: [skill_id => level]
    public array $selected_assets = []; // Format: [asset_id => priority]

    public string $skill_search = '';
    public string $asset_search = '';

    public function mount(JobOffer $offer)
    {
        $this->offer = $offer;
        $this->authorize('update', $offer);

        $this->publish_as = $offer->recruiterProfile->user_id === Auth::id() ? 'my_company' : 'managed';
        if ($this->publish_as === 'managed') {
            $this->managed_recruiter_id = $offer->recruiter_profile_id;
        }

        $this->title = $offer->title;
        $this->template = $offer->template->value;
        $this->description = $offer->description;
        
        // Load Geo data
        $geo = app(GeoService::class);
        $this->availableCountries = $geo->getCountries();
        
        $this->country = $offer->country ?? 'Cameroon';
        $this->region = $offer->region;
        $this->city = $offer->city;

        $this->availableRegions = $geo->getStatesByCountry($this->country);
        if ($this->region) {
            $this->availableCities = $geo->getCitiesByState($this->country, $this->region);
        } else {
            $this->availableCities = $geo->getCitiesByCountry($this->country);
        }

        $this->budget_min = $offer->budget_min;
        $this->budget_max = $offer->budget_max;

        $this->min_education = $offer->required_education->value;
        $this->min_experience = $offer->required_experience->value;
        $this->max_availability = $offer->required_availability->value;

        $this->block_education = !empty($offer->blocking_education);
        $this->block_experience = !empty($offer->blocking_experience);
        $this->block_availability = !empty($offer->blocking_availability);
        $this->block_language = !empty($offer->blocking_language);
        $this->block_permit = !empty($offer->blocking_permit);

        if ($this->block_language) $this->language = $offer->blocking_language->value;
        if ($this->block_permit) $this->required_permit = $offer->blocking_permit->value;

        $this->selected_skills = $offer->jobRequiredSkills->pluck('level_required', 'skill_id')->toArray();
        $this->selected_assets = $offer->required_assets ?? [];
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
                 'publish_as' => 'required|in:my_company,managed',
                 'managed_recruiter_id' => 'required_if:publish_as,managed',
             ]);
        }

        if ($this->step === 2) {
            $this->validate([
                'title' => 'required|string|min:5|max:100',
                'template' => 'required|string',
                'description' => 'required|string|min:20',
                'city' => 'required|string',
                'language' => 'required|string',
            ]);
        }

        if ($this->step === 3) {
             $this->validate([
                 'min_education' => 'required',
                 'min_experience' => 'required',
                 'max_availability' => 'required',
                 'selected_skills' => 'required|array|min:1',
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
        if (!isset($this->selected_assets[$assetId])) {
            $this->selected_assets[$assetId] = 'Moyen';
        }
        $this->asset_search = '';
    }

    public function removeAsset($assetId)
    {
        unset($this->selected_assets[$assetId]);
    }

    public function updateAssetPriority($assetId, $priority)
    {
        $this->selected_assets[$assetId] = $priority;
    }

    public function save($status = null)
    {
        $this->validateSteps();

        $recruiterProfileId = $this->publish_as === 'my_company'
            ? Auth::user()->recruiterProfile->id
            : $this->managed_recruiter_id;

        $newStatus = $status ?? $this->offer->status;

        $this->offer->update([
            'recruiter_profile_id' => $recruiterProfileId,
            'title' => $this->title,
            'description' => $this->description,
            'template' => $this->template,
            'country' => $this->country,
            'city' => $this->city,
            'region' => $this->region,
            'blocking_language' => $this->block_language ? $this->language : null,
            'blocking_education' => $this->block_education ? $this->min_education : null,
            'blocking_experience' => $this->block_experience ? $this->min_experience : null,
            'blocking_availability' => $this->block_availability ? $this->max_availability : null,
            'blocking_permit' => $this->block_permit ? $this->required_permit : null,
            'required_experience' => $this->min_experience,
            'required_education' => $this->min_education,
            'required_availability' => $this->max_availability,
            'budget_min' => $this->budget_min,
            'budget_max' => $this->budget_max,
            'required_assets' => $this->selected_assets,
            'status' => $newStatus,
        ]);

        // Sync Skills
        $this->offer->jobRequiredSkills()->delete();
        foreach ($this->selected_skills as $id => $level) {
            JobRequiredSkill::create([
                'job_offer_id' => $this->offer->id,
                'skill_id' => $id,
                'level_required' => $level,
            ]);
        }

        Flux::toast(
            variant: 'success',
            heading: 'Offre mise à jour',
            text: "Les modifications ont été enregistrées avec succès.",
        );

        return redirect()->route('recruiter.offers.index');
    }

    public function with()
    {
        return [
            'managed_companies' => RecruiterProfile::where('is_managed_by', Auth::id())->get(),
            'available_skills' => $this->skill_search ? Skill::where('name', 'like', "%{$this->skill_search}%")
                ->whereNotIn('id', array_keys($this->selected_skills))
                ->limit(10)->get() : collect(),
            'available_assets' => $this->asset_search ? Asset::where('name', 'like', "%{$this->asset_search}%")
                ->whereNotIn('id', array_keys($this->selected_assets))
                ->limit(10)->get() : collect(),
             'selected_skills_models' => Skill::whereIn('id', array_keys($this->selected_skills))->get(),
             'selected_assets_models' => Asset::whereIn('id', array_keys($this->selected_assets))->get(),
        ];
    }

    public function getStepTitle() {
        return match($this->step) {
            1 => 'Contexte de publication',
            2 => 'Informations générales',
            3 => 'Critères de sélection',
            4 => 'Récapitulatif et mise à jour',
        };
    }
}; ?>

<div class="max-w-4xl mx-auto space-y-8 pb-12">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <flux:heading size="xl">Modifier l'offre</flux:heading>
            <flux:subheading>Étape {{ $step }} sur 4 : {{ $this->getStepTitle() }}</flux:subheading>
        </div>
        <div class="flex gap-2">
            @for ($i = 1; $i <= 4; $i++)
                <div @class([
                    'h-2 w-12 rounded-full transition-colors',
                    'bg-emerald-500' => $i <= $step,
                    'bg-zinc-200 dark:bg-zinc-800' => $i > $step,
                ])></div>
            @endfor
        </div>
    </div>

    <flux:card class="p-8 border-zinc-200 dark:border-zinc-800">
        @if ($step === 1)
            {{-- Étape 1 — Contexte de publication --}}
            <div class="space-y-6">
                <flux:heading size="lg">Cette offre est-elle publiée au nom de votre entreprise ?</flux:heading>

                <flux:radio.group wire:model.live="publish_as" variant="cards" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:radio value="my_company" label="Mon entreprise" description="{{ Auth::user()->recruiterProfile?->company_name ?? 'Profil non configuré' }}" />
                    <flux:radio value="managed" label="Je publie au nom d'une autre entreprise" description="Sélectionnez une entreprise que vous gérez" />
                </flux:radio.group>

                @if ($publish_as === 'managed')
                    <flux:field>
                        <flux:label>Choisir l'entreprise</flux:label>
                        <flux:select wire:model="managed_recruiter_id" placeholder="Sélectionnez une entreprise">
                            @foreach ($managed_companies as $company)
                                <flux:select.option value="{{ $company->id }}">{{ $company->company_name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                @endif
            </div>
        @elseif ($step === 2)
            {{-- Étape 2 — Informations générales --}}
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field class="md:col-span-2">
                        <flux:label>Intitulé du poste</flux:label>
                        <flux:input wire:model="title" placeholder="Ex: Développeur Laravel Senior" />
                        <flux:error name="title" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Template de poste</flux:label>
                        <flux:select wire:model="template" placeholder="Choisir un template">
                            @foreach (JobTemplateEnum::cases() as $item)
                                <flux:select.option value="{{ $item->value }}">{{ $item->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="template" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Profil linguistique requis</flux:label>
                        <flux:select wire:model="language">
                            @foreach (LanguageProfileEnum::cases() as $item)
                                <flux:select.option value="{{ $item->value }}">{{ $item->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <flux:field class="md:col-span-2">
                        <flux:label>Description du poste</flux:label>
                        <flux:textarea wire:model="description" rows="5" placeholder="Décrivez les missions, le contexte..." />
                        <flux:error name="description" />
                    </flux:field>

                    {{-- Pays --}}
                    <flux:field>
                        <flux:label>Pays</flux:label>
                        <flux:select wire:model.live="country">
                            @foreach ($availableCountries as $c)
                                <flux:select.option value="{{ $c }}">{{ $c }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    {{-- Région/State --}}
                    <flux:field>
                        <flux:label>Région</flux:label>
                        <flux:select wire:model.live="region">
                            @foreach ($availableRegions as $r)
                                <flux:select.option value="{{ $r }}">{{ $r }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    {{-- Ville --}}
                    <flux:field>
                        <flux:label>Ville</flux:label>
                        <flux:select wire:model="city">
                            @foreach ($availableCities as $c)
                                <flux:select.option value="{{ $c }}">{{ $c }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Budget minimum (FCFA)</flux:label>
                        <flux:input wire:model="budget_min" type="number" placeholder="Optionnel" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Budget maximum (FCFA)</flux:label>
                        <flux:input wire:model="budget_max" type="number" placeholder="Optionnel" />
                    </flux:field>
                </div>
            </div>
        @elseif ($step === 3)
            {{-- Étape 3 — Critères de sélection --}}
            <div class="space-y-8">
                {{-- Bloc A — Critères bloquants --}}
                <div class="space-y-4">
                    <flux:heading size="lg">Critères bloquants (éliminatoires)</flux:heading>
                    <flux:text  size="sm">Si activés, ces critères excluent automatiquement les candidats qui ne les remplissent pas.</flux:text>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Formation minimum</flux:label>
                                <flux:switch wire:model.live="block_education" />
                            </div>
                            <flux:select wire:model="min_education">
                                @foreach (EducationLevelEnum::cases() as $level)
                                    <flux:select.option value="{{ $level->value }}">{{ $level->label() }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:field>

                        <flux:field>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Expérience minimum</flux:label>
                                <flux:switch wire:model.live="block_experience" />
                            </div>
                            <flux:select wire:model="min_experience">
                                @foreach (ExperienceTierEnum::cases() as $tier)
                                    <flux:select.option value="{{ $tier->value }}">{{ $tier->label() }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:field>

                        <flux:field>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Disponibilité maximum</flux:label>
                                <flux:switch wire:model.live="block_availability" />
                            </div>
                            <flux:select wire:model="max_availability">
                                @foreach (AvailabilityEnum::cases() as $avail)
                                    <flux:select.option value="{{ $avail->value }}">{{ $avail->label() }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:field>

                        <flux:field>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Permis requis</flux:label>
                                <flux:switch wire:model.live="block_permit" />
                            </div>
                            <flux:select wire:model="required_permit" placeholder="Aucun">
                                @foreach (DrivingPermitEnum::cases() as $item)
                                    <flux:select.option value="{{ $item->value }}">{{ $item->label() }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:field>
                    </div>
                </div>

                <flux:separator />

                {{-- Bloc B — Compétences requises --}}
                <div class="space-y-4">
                    <flux:heading size="lg">Compétences requises</flux:heading>
                    <div class="relative">
                        <flux:input wire:model.live.debounce.300ms="skill_search" icon="magnifying-glass" placeholder="Rechercher une compétence..." />
                        @if ($available_skills->isNotEmpty())
                            <div class="absolute z-10 w-full mt-1 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                @foreach ($available_skills as $skill)
                                    <button wire:click="addSkill({{ $skill->id }})" class="w-full text-left px-4 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">
                                        <flux:text class="font-medium">
                                            {{ \App\Enums\SkillEnum::tryFrom(Str::lower($skill->name))?->label() ?? $skill->name }}
                                        </flux:text>
                                        <flux:text size="xs" class="block">{{ $skill->category }}</flux:text>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="space-y-4 bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl">
                        @forelse ($selected_skills_models as $skill)
                            <div class="flex items-center justify-between" wire:key="skill-{{ $skill->id }}">
                                <flux:text class="font-medium">
                                    {{ \App\Enums\SkillEnum::tryFrom(Str::lower($skill->name))?->label() ?? $skill->name }}
                                </flux:text>
                                <div class="flex items-center gap-4">
                                    <div class="flex gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button wire:click="updateSkillLevel({{ $skill->id }}, {{ $i }})" @class([
                                                'w-3 h-3 rounded-full transition-colors',
                                                'bg-emerald-500' => $i <= $selected_skills[$skill->id],
                                                'bg-zinc-300 dark:bg-zinc-700 hover:bg-emerald-300' => $i > $selected_skills[$skill->id],
                                            ]) title="Niveau {{ $i }}/5"></button>
                                        @endfor
                                    </div>
                                    <flux:button size="xs" variant="ghost" icon="x-mark" wire:click="removeSkill({{ $skill->id }})" />
                                </div>
                            </div>
                        @empty
                            <flux:text class="text-center py-4 italic">Aucune compétence sélectionnée.</flux:text>
                        @endforelse
                    </div>
                    <flux:error name="selected_skills" />
                </div>

                <flux:separator />

                {{-- Bloc C — Atouts recherchés (bonus) --}}
                <div class="space-y-4">
                    <flux:heading size="lg">Atouts recherchés (bonus)</flux:heading>
                    <div class="relative">
                        <flux:input wire:model.live.debounce.300ms="asset_search" icon="magnifying-glass" placeholder="Rechercher un atout..." />
                        @if ($available_assets->isNotEmpty())
                            <div class="absolute z-10 w-full mt-1 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                @foreach ($available_assets as $asset)
                                    <button wire:click="addAsset({{ $asset->id }})" class="w-full text-left px-4 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">
                                        <flux:text class="font-medium">{{ $asset->name }}</flux:text>
                                        <flux:text size="xs" class="block">{{ \App\Enums\AssetEnum::from($asset->category)->label() }}</flux:text>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($selected_assets_models as $asset)
                            <div class="flex items-center justify-between p-3 border border-zinc-200 dark:border-zinc-800 rounded-lg bg-zinc-50 dark:bg-zinc-900/50" wire:key="asset-{{ $asset->id }}">
                                <div class="flex flex-col">
                                    <flux:text size="sm" class="font-medium">{{ $asset->name }}</flux:text>
                                    <flux:text size="xs" class="opacity-70">{{ \App\Enums\AssetEnum::from($asset->category)->label() }}</flux:text>
                                </div>
                                <div class="flex items-center gap-2">
                                    <flux:select wire:change="updateAssetPriority({{ $asset->id }}, $event.target.value)" size="sm" class="w-24">
                                        <option value="Faible" @selected($selected_assets[$asset->id] === 'Faible')>Faible</option>
                                        <option value="Moyen" @selected($selected_assets[$asset->id] === 'Moyen')>Moyen</option>
                                        <option value="Fort" @selected($selected_assets[$asset->id] === 'Fort')>Fort</option>
                                    </flux:select>
                                    <flux:button size="xs" variant="ghost" icon="x-mark" wire:click="removeAsset({{ $asset->id }})" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($this->simulations->isNotEmpty())
                <div class="mt-12 p-6 rounded-2xl border border-emerald-500/20 bg-emerald-50/30 dark:bg-emerald-500/5 space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                            <flux:icon.chart-bar-square class="size-6" />
                        </div>
                        <div>
                            <flux:heading size="lg">Simulation de l'impact</flux:heading>
                            <flux:subheading>Voici comment différents profils de candidats scoreraient avec vos critères actuels.</flux:subheading>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($this->simulations as $sim)
                            <div class="p-4 rounded-xl border bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 space-y-3">
                                <div class="flex justify-between items-start">
                                    <flux:text class="font-bold leading-tight">{{ $sim['name'] }}</flux:text>
                                    @if(!$sim['result']['passed_blocking'])
                                        <flux:badge color="red" size="xs">Bloqué</flux:badge>
                                    @else
                                        <flux:text class="font-display font-black text-xl text-emerald-500">{{ $sim['result']['score_principal'] }}%</flux:text>
                                    @endif
                                </div>
                                
                                <div class="space-y-1">
                                    <div class="flex justify-between text-[10px] uppercase font-bold opacity-50">
                                        <span>Compétences</span>
                                        <span>{{ $sim['result']['scores_details']['skills'] ?? 0 }}%</span>
                                    </div>
                                    <div class="h-1 w-full bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 transition-all duration-500" style="width: {{ $sim['result']['scores_details']['skills'] ?? 0 }}%"></div>
                                    </div>
                                </div>

                                @if(!$sim['result']['passed_blocking'])
                                    <flux:text size="xs" color="red" class="italic">Ce candidat ne passe pas vos critères bloquants.</flux:text>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @elseif ($step === 4)
            {{-- Étape 4 — Récapitulatif et mise à jour --}}
            <div class="space-y-8">
                <div class="space-y-4">
                    <flux:heading size="lg">Récapitulatif de l'offre</flux:heading>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 text-sm">
                        <div>
                            <flux:text size="xs"  class="uppercase tracking-wider font-semibold opacity-70">Poste</flux:text>
                            <flux:heading size="md" class="mt-1">{{ $title }}</flux:heading>
                        </div>
                        <div>
                            <flux:text size="xs"  class="uppercase tracking-wider font-semibold opacity-70">Entreprise</flux:text>
                            <flux:heading size="md" class="mt-1">
                                {{ $publish_as === 'my_company' ? Auth::user()->recruiterProfile->company_name : RecruiterProfile::find($managed_recruiter_id)?->company_name }}
                            </flux:heading>
                        </div>
                        <div class="md:col-span-2">
                            <flux:text size="xs"  class="uppercase tracking-wider font-semibold opacity-70">Description</flux:text>
                            <flux:text class="mt-1 block whitespace-pre-line text-zinc-600 dark:text-zinc-400">{{ $description }}</flux:text>
                        </div>
                        <div>
                            <flux:text size="xs"  class="uppercase tracking-wider font-semibold opacity-70">Localisation</flux:text>
                            <flux:text class="mt-1">{{ $city }}, {{ $region }}</flux:text>
                        </div>
                        <div>
                            <flux:text size="xs"  class="uppercase tracking-wider font-semibold opacity-70">Budget estimé</flux:text>
                            <flux:text class="mt-1">
                                {{ $budget_min ? number_format($budget_min, 0, ',', ' ') : '---' }} - {{ $budget_max ? number_format($budget_max, 0, ',', ' ') : '---' }} FCFA
                            </flux:text>
                        </div>
                    </div>
                </div>

                <flux:separator />

                <div class="space-y-4">
                    <flux:heading size="md">Critères & Compétences</flux:heading>
                    <div class="flex flex-wrap gap-2">
                        <flux:badge icon="academic-cap">{{ EducationLevelEnum::from($min_education)->label() }}</flux:badge>
                        <flux:badge icon="briefcase">{{ ExperienceTierEnum::from($min_experience)->label() }}</flux:badge>
                        <flux:badge icon="language">{{ LanguageProfileEnum::from($language)->label() }}</flux:badge>
                        @if($block_education || $block_experience || $block_availability || $block_language || $block_permit)
                            <flux:badge color="red" variant="pill" size="sm">Critères bloquants actifs</flux:badge>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <flux:text size="xs" class="font-bold uppercase opacity-70">Compétences</flux:text>
                            @foreach ($selected_skills_models as $skill)
                                <div class="flex justify-between text-sm p-2 bg-zinc-50 dark:bg-zinc-900/30 rounded border border-zinc-100 dark:border-zinc-800" wire:key="summary-skill-{{ $skill->id }}">
                                    <flux:text>
                                        {{ \App\Enums\SkillEnum::tryFrom(Str::lower($skill->name))?->label() ?? $skill->name }}
                                    </flux:text>
                                    <flux:text class="font-bold">Niveau {{ $selected_skills[$skill->id] }}/5</flux:text>
                                </div>
                            @endforeach
                        </div>
                        <div class="space-y-2">
                             <flux:text size="xs" class="font-bold uppercase opacity-70">Atouts (Bonus)</flux:text>
                             @forelse ($selected_assets_models as $asset)
                                <div class="flex justify-between text-sm p-2 bg-zinc-50 dark:bg-zinc-900/30 rounded border border-zinc-100 dark:border-zinc-800" wire:key="summary-asset-{{ $asset->id }}">
                                    <flux:text>{{ $asset->name }}</flux:text>
                                    <flux:badge size="xs" color="emerald" variant="pill">{{ $selected_assets[$asset->id] }}</flux:badge>
                                </div>
                             @empty
                                <flux:text size="sm" class="italic opacity-50">Aucun atout bonus sélectionné.</flux:text>
                             @endforelse
                        </div>
                    </div>
                </div>

                @if($this->simulations->isNotEmpty())
                <flux:separator />
                <div class="space-y-6">
                    <div>
                        <flux:heading size="md">Simulation de l'impact</flux:heading>
                        <flux:subheading>Scoring estimé des profils types</flux:subheading>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($this->simulations as $sim)
                            <div class="p-4 rounded-xl border bg-zinc-50 dark:bg-zinc-900/30 border-zinc-200 dark:border-zinc-800 flex flex-col justify-between">
                                <div class="flex justify-between items-start mb-2">
                                    <flux:text size="sm" class="font-bold">{{ $sim['name'] }}</flux:text>
                                    @if(!$sim['result']['passed_blocking'])
                                        <flux:badge color="red" size="xs">Bloqué</flux:badge>
                                    @else
                                        <flux:text class="font-black text-emerald-500">{{ $sim['result']['score_principal'] }}%</flux:text>
                                    @endif
                                </div>
                                <div class="h-1.5 w-full bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500" style="width: {{ $sim['result']['score_principal'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        @endif
    </flux:card>

    {{-- Footer Actions --}}
    <div class="flex justify-between items-center">
        @if ($step > 1)
            <flux:button wire:click="prevStep" variant="ghost">Précédent</flux:button>
        @else
            <flux:button variant="ghost" href="{{ route('recruiter.offers.index') }}">Annuler</flux:button>
        @endif

        <div class="flex gap-4">
            @if ($step < 4)
                <flux:button variant="ghost" wire:click="save()">Enregistrer les modifications</flux:button>
                <flux:button wire:click="nextStep" variant="primary">Continuer</flux:button>
            @else
                <flux:button variant="ghost" wire:click="save()">Enregistrer</flux:button>
                <flux:button wire:click="save()" variant="primary" class="bg-emerald-500 hover:bg-emerald-600 border-none">Mettre à jour l'offre</flux:button>
            @endif
        </div>
    </div>
</div>
