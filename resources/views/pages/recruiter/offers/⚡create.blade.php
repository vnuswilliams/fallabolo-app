<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\RecruiterProfile;
use App\Models\Skill;
use App\Models\Asset;
use App\Models\JobOffer;
use App\Models\JobRequiredSkill;
use App\Enums\JobTemplateEnum;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\AvailabilityEnum;
use App\Enums\LanguageProfileEnum;
use App\Enums\DrivingPermitEnum;
use App\Enums\CityEnum;
use App\Enums\RegionEnum;
use App\Enums\JobStatusEnum;
use App\Enums\SkillEnum;
use App\Enums\AssetEnum;
use App\Services\Scoring\MatchingService;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Flux\Flux;

new #[Title('Créer une offre')] class extends Component {
    public int $step = 1;

    // ... (rest of properties)
    
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
    public string $city = 'Douala';
    public string $region = 'Littoral';
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

    public function save($status = 'published')
    {
        $this->validateSteps();

        $recruiterProfileId = $this->publish_as === 'my_company'
            ? Auth::user()->recruiterProfile->id
            : $this->managed_recruiter_id;

        $offer = JobOffer::create([
            'recruiter_profile_id' => $recruiterProfileId,
            'title' => $this->title,
            'description' => $this->description,
            'template' => $this->template,
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
            'status' => $status === 'published' ? JobStatusEnum::PUBLISHED : JobStatusEnum::DRAFT,
            'published_at' => $status === 'published' ? now() : null,
        ]);

        foreach ($this->selected_skills as $id => $level) {
            JobRequiredSkill::create([
                'job_offer_id' => $offer->id,
                'skill_id' => $id,
                'level_required' => $level,
            ]);
        }

        Flux::toast(
            variant: 'success',
            heading: 'Offre créée',
            text: $status === 'published' ? "L'offre a été publiée avec succès." : "L'offre a été enregistrée en brouillon.",
        );

        return redirect()->route('recruiter.dashboard');
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
            4 => 'Récapitulatif et publication',
        };
    }
}; ?>

<div class="max-w-4xl mx-auto space-y-8 pb-12">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <flux:heading size="xl">Créer une nouvelle offre</flux:heading>
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
                        <div class="mt-4">
                            <flux:button variant="ghost" icon="plus" size="sm">Créer un nouveau profil entreprise</flux:button>
                        </div>
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

                    <flux:field>
                        <flux:label>Ville</flux:label>
                        <flux:select wire:model="city">
                            @foreach (CityEnum::cases() as $item)
                                <flux:select.option value="{{ $item->value }}">{{ $item->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Région</flux:label>
                        <flux:select wire:model="region">
                            @foreach (RegionEnum::cases() as $item)
                                <flux:select.option value="{{ $item->value }}">{{ $item->label() }}</flux:select.option>
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
                        <flux:select >
                            <flux:select.option value="">Choisir une option</flux:select.option>
                    @foreach (SkillEnum::options() as $skill)
                    <flux:select.option value="{{ $skill['value'] }}">{{ $skill['label'] }}</flux:select.option>
                                    
                                @endforeach
                        </flux:select>
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
            {{-- Étape 4 — Récapitulatif et publication --}}
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
                <flux:button variant="ghost" wire:click="save('draft')">Enregistrer en brouillon</flux:button>
                <flux:button wire:click="nextStep" variant="primary">Continuer</flux:button>
            @else
                <flux:button variant="ghost" wire:click="save('draft')">Enregistrer en brouillon</flux:button>
                <flux:button wire:click="save('published')" variant="primary" class="bg-emerald-500 hover:bg-emerald-600 border-none">Publier l'offre</flux:button>
            @endif
        </div>
    </div>
</div>
