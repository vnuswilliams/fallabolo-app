<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\RecruiterProfile;
use App\Models\Skill;
use App\Models\Asset;
use App\Enums\JobTemplateEnum;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\AvailabilityEnum;
use App\Enums\LanguageProfileEnum;
use App\Enums\DrivingPermitEnum;
use Illuminate\Support\Facades\Auth;

new #[Title('Créer une offre')] class extends Component {
    public int $step = 1;

    // Step 1: Context
    public string $publish_as = 'my_company';
    public ?string $managed_recruiter_id = null;

    // Step 2: Info
    public string $title = '';
    public string $template = '';
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
    public array $required_permits = [];

    public array $selected_skills = []; // Format: ['skill_id' => level]
    public array $selected_assets = []; // Format: ['asset_id' => priority]

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
        // UI Scaffolding - Simulate success
        return redirect()->route('recruiter.dashboard');
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

                <flux:radio.group wire:model="publish_as" variant="cards" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:radio value="my_company" label="Mon entreprise" description="TechCorp Douala" />
                    <flux:radio value="managed" label="Je publie au nom d'une autre entreprise" description="Sélectionnez une entreprise que vous gérez" />
                </flux:radio.group>

                @if ($publish_as === 'managed')
                    <flux:field>
                        <flux:label>Choisir l'entreprise</flux:label>
                        <flux:select wire:model="managed_recruiter_id" placeholder="Sélectionnez une entreprise">
                            <flux:select.option value="1">SmallBiz Managed 1</flux:select.option>
                            <flux:select.option value="2">SmallBiz Managed 2</flux:select.option>
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
                    </flux:field>

                    <flux:field>
                        <flux:label>Template de poste</flux:label>
                        <flux:select wire:model="template" placeholder="Choisir un template">
                            <flux:select.option value="manoeuvre">Manœuvres & Ouvriers</flux:select.option>
                            <flux:select.option value="technicien">Employés & Techniciens</flux:select.option>
                            <flux:select.option value="maitrise">Agents de maîtrise</flux:select.option>
                            <flux:select.option value="cadre">Cadre</flux:select.option>
                            <flux:select.option value="dirigeant">Cadres dirigeants & Dirigeants</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Profil linguistique requis</flux:label>
                        <flux:select wire:model="language">
                            <flux:select.option value="francophone">Francophone</flux:select.option>
                            <flux:select.option value="anglophone">Anglophone</flux:select.option>
                            <flux:select.option value="bilingue">Bilingue</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field class="md:col-span-2">
                        <flux:label>Description du poste</flux:label>
                        <flux:textarea wire:model="description" rows="5" placeholder="Décrivez les missions, le contexte..." />
                    </flux:field>

                    <flux:field>
                        <flux:label>Ville</flux:label>
                        <flux:select wire:model="city">
                            <flux:select.option value="Douala">Douala</flux:select.option>
                            <flux:select.option value="Yaoundé">Yaoundé</flux:select.option>
                            <flux:select.option value="Autre">Autre</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Région</flux:label>
                        <flux:select wire:model="region">
                            <flux:select.option value="Littoral">Littoral</flux:select.option>
                            <flux:select.option value="Centre">Centre</flux:select.option>
                            <flux:select.option value="Ouest">Ouest</flux:select.option>
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
                                <flux:label>Niveau de formation minimum</flux:label>
                                <flux:switch />
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
                                <flux:switch />
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
                                <flux:switch />
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
                                <flux:switch />
                            </div>
                            <div class="flex gap-2">
                                @foreach (['A', 'B', 'C', 'D'] as $permit)
                                    <flux:button size="sm" variant="outline">{{ $permit }}</flux:button>
                                @endforeach
                            </div>
                        </flux:field>
                    </div>
                </div>

                <flux:separator />

                {{-- Bloc B — Compétences requises --}}
                <div class="space-y-4">
                    <flux:heading size="lg">Compétences requises</flux:heading>
                    <div class="flex gap-2">
                        <flux:input placeholder="Rechercher une compétence..." class="flex-1" />
                        <flux:button icon="plus">Ajouter</flux:button>
                    </div>

                    <div class="space-y-4 bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl">
                        @foreach ([
                            ['name' => 'Laravel', 'level' => 5],
                            ['name' => 'PHP', 'level' => 4],
                            ['name' => 'MySQL', 'level' => 3],
                            ['name' => 'Git', 'level' => 2],
                        ] as $skill)
                            <div class="flex items-center justify-between">
                                <flux:text class="font-medium">{{ $skill['name'] }}</flux:text>
                                <div class="flex items-center gap-4">
                                    <div class="flex gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <div @class([
                                                'w-2 h-2 rounded-full',
                                                'bg-emerald-500' => $i <= $skill['level'],
                                                'bg-zinc-300 dark:bg-zinc-700' => $i > $skill['level'],
                                            ])></div>
                                        @endfor
                                    </div>
                                    <flux:button size="xs" variant="ghost" icon="x-mark" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <flux:separator />

                {{-- Bloc C — Atouts recherchés (bonus) --}}
                <div class="space-y-4">
                    <flux:heading size="lg">Atouts recherchés (bonus)</flux:heading>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ([
                            ['name' => 'Expérience Télécoms', 'priority' => 'Fort'],
                            ['name' => 'Certification AWS', 'priority' => 'Moyen'],
                            ['name' => 'Expérience télétravail', 'priority' => 'Moyen'],
                        ] as $asset)
                            <div class="flex items-center justify-between p-3 border border-zinc-200 dark:border-zinc-800 rounded-lg">
                                <flux:text size="sm">{{ $asset['name'] }}</flux:text>
                                <div class="flex items-center gap-2">
                                    <flux:badge size="sm">{{ $asset['priority'] }}</flux:badge>
                                    <flux:button size="xs" variant="ghost" icon="x-mark" />
                                </div>
                            </div>
                        @endforeach
                        <flux:button variant="outline" icon="plus" class="justify-start">Ajouter un atout</flux:button>
                    </div>
                </div>
            </div>
        @elseif ($step === 4)
            {{-- Étape 4 — Récapitulatif et publication --}}
            <div class="space-y-8">
                <div class="space-y-4">
                    <flux:heading size="lg">Récapitulatif de l'offre</flux:heading>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                        <div>
                            <flux:text size="sm"  class="uppercase tracking-wider font-semibold">Poste</flux:text>
                            <flux:heading size="md" class="mt-1">Développeur Laravel Senior</flux:heading>
                        </div>
                        <div>
                            <flux:text size="sm"  class="uppercase tracking-wider font-semibold">Entreprise</flux:text>
                            <flux:heading size="md" class="mt-1">TechCorp Douala</flux:heading>
                        </div>
                        <div class="md:col-span-2">
                            <flux:text size="sm"  class="uppercase tracking-wider font-semibold">Description</flux:text>
                            <flux:text class="mt-1">Nous recherchons un expert Laravel pour renforcer notre équipe...</flux:text>
                        </div>
                        <div>
                            <flux:text size="sm"  class="uppercase tracking-wider font-semibold">Localisation</flux:text>
                            <flux:text class="mt-1">Douala, Littoral</flux:text>
                        </div>
                        <div>
                            <flux:text size="sm"  class="uppercase tracking-wider font-semibold">Budget</flux:text>
                            <flux:text class="mt-1">400,000 - 800,000 FCFA</flux:text>
                        </div>
                    </div>
                </div>

                <flux:separator />

                <div class="space-y-4">
                    <flux:heading size="md">Critères & Compétences</flux:heading>
                    <div class="flex flex-wrap gap-2">
                        <flux:badge icon="academic-cap">Master</flux:badge>
                        <flux:badge icon="briefcase">5-10 ans</flux:badge>
                        <flux:badge icon="language">Bilingue</flux:badge>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <flux:text>Laravel</flux:text>
                            <flux:text class="font-bold">Niveau 5/5</flux:text>
                        </div>
                        <div class="flex justify-between text-sm">
                            <flux:text>PHP</flux:text>
                            <flux:text class="font-bold">Niveau 4/5</flux:text>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </flux:card>

    {{-- Footer Actions --}}
    <div class="flex justify-between items-center">
        @if ($step > 1)
            <flux:button wire:click="prevStep" variant="ghost">Précédent</flux:button>
        @else
            <div></div>
        @endif

        <div class="flex gap-4">
            @if ($step < 4)
                <flux:button variant="ghost">Enregistrer en brouillon</flux:button>
                <flux:button wire:click="nextStep" variant="primary">Continuer</flux:button>
            @else
                <flux:button variant="ghost">Enregistrer en brouillon</flux:button>
                <flux:button wire:click="save" variant="primary" class="bg-emerald-500 hover:bg-emerald-600">Publier l'offre</flux:button>
            @endif
        </div>
    </div>
</div>
