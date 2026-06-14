<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\CandidateProfile;
use App\Models\CandidateSkill;
use App\Models\Skill;
use App\Models\Asset;
use App\Enums\AssetEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Flux\Flux;

new #[Title('Mes Compétences & Atouts')] class extends Component {
    public array $selected_skills = []; // [skill_id => level]
    public array $selected_assets = []; // [asset_id]
    public string $skill_search = '';
    public string $asset_search = '';

    public function mount()
    {
        $profile = Auth::user()->candidateProfile;
        if ($profile) {
            $this->selected_skills = $profile->candidateSkills->pluck('level', 'skill_id')->toArray();
            $this->selected_assets = $profile->assets ?? [];
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
        $profile = Auth::user()->candidateProfile;
        if (!$profile) {
            return redirect()->route('candidate.onboarding');
        }

        // Sync assets
        $profile->update(['assets' => array_values($this->selected_assets)]);

        // Sync skills
        $profile->candidateSkills()->delete();
        foreach ($this->selected_skills as $id => $level) {
            CandidateSkill::create([
                'candidate_profile_id' => $profile->id,
                'skill_id' => $id,
                'level' => $level,
            ]);
        }

        Flux::toast(
            variant: 'success',
            heading: 'Compétences mises à jour',
            text: 'Vos compétences et atouts ont été enregistrés.',
        );

        return redirect()->route('candidate.profile.index');
    }

    public function with()
    {
        return [
            'available_skills' => $this->skill_search ? Skill::where('name', 'like', "%{$this->skill_search}%")
                ->whereNotIn('id', array_keys($this->selected_skills))
                ->limit(10)->get() : collect(),
            'available_assets' => $this->asset_search ? Asset::where('name', 'like', "%{$this->asset_search}%")
                ->whereNotIn('id', $this->selected_assets)
                ->limit(10)->get() : collect(),
             'selected_skills_models' => Skill::whereIn('id', array_keys($this->selected_skills))->get(),
             'selected_assets_models' => Asset::whereIn('id', $this->selected_assets)->get(),
        ];
    }
}; ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <flux:button :href="route('candidate.profile.index')" variant="ghost" icon="arrow-left" size="sm" class="mb-4" wire:navigate>
            Retour au profil
        </flux:button>
        <flux:heading size="xl">Mes Compétences & Atouts</flux:heading>
        <flux:subheading>Gérez vos compétences techniques et vos atouts supplémentaires pour un meilleur matching.</flux:subheading>
    </div>

    <div class="space-y-8">
        {{-- Compétences --}}
        <flux:card class="p-8">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="lg">Compétences techniques</flux:heading>
                        <flux:subheading>Celles-ci définissent votre score de compatibilité technique.</flux:subheading>
                    </div>
                </div>

                <div class="relative">
                    <flux:input wire:model.live.debounce.300ms="skill_search" icon="magnifying-glass" placeholder="Rechercher une compétence..." />
                    @if ($available_skills->isNotEmpty())
                        <div class="absolute z-10 w-full mt-1 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            @foreach ($available_skills as $skill)
                                <button wire:click="addSkill({{ $skill->id }})" class="w-full text-left px-4 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">
                                    <flux:text class="font-medium">
                                        {{ \App\Enums\SkillEnum::tryFrom(Str::lower($skill->name))?->label() ?? $skill->name }}
                                    </flux:text>
                                    <flux:text size="xs" class="block text-zinc-500">{{ $skill->category }}</flux:text>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="space-y-3">
                    @forelse ($selected_skills_models as $skill)
                        <div class="flex items-center justify-between p-4 bg-zinc-50 dark:bg-zinc-900/50 rounded-xl border border-zinc-200 dark:border-zinc-800" wire:key="skill-{{ $skill->id }}">
                            <div>
                                <flux:text class="font-medium">
                                    {{ \App\Enums\SkillEnum::tryFrom(Str::lower($skill->name))?->label() ?? $skill->name }}
                                </flux:text>
                                <flux:text size="xs" class="text-zinc-500">{{ $skill->category }}</flux:text>
                            </div>
                            <div class="flex items-center gap-6">
                                <div class="flex gap-1.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button wire:click="updateSkillLevel({{ $skill->id }}, {{ $i }})" @class([
                                            'w-8 h-8 rounded-lg font-bold flex items-center justify-center transition-all',
                                            'bg-emerald-500 text-zinc-950 scale-110 shadow-lg shadow-emerald-500/20' => $i <= $selected_skills[$skill->id],
                                            'bg-zinc-200 dark:bg-zinc-800 text-zinc-500 hover:border-emerald-500 border border-transparent' => $i > $selected_skills[$skill->id],
                                        ])>
                                            {{ $i }}
                                        </button>
                                    @endfor
                                </div>
                                <flux:button size="xs" variant="ghost" icon="x-mark" wire:click="removeSkill({{ $skill->id }})" />
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl">
                            <flux:text class="italic opacity-50">Aucune compétence ajoutée pour le moment.</flux:text>
                        </div>
                    @endforelse
                </div>
            </div>
        </flux:card>

        {{-- Atouts --}}
        <flux:card class="p-8">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Atouts & Certifications</flux:heading>
                    <flux:subheading>Ces éléments agissent comme des bonus lors du matching.</flux:subheading>
                </div>

                <div class="relative">
                    <flux:input wire:model.live.debounce.300ms="asset_search" icon="magnifying-glass" placeholder="Rechercher un atout..." />
                    @if ($available_assets->isNotEmpty())
                        <div class="absolute z-10 w-full mt-1 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            @foreach ($available_assets as $asset)
                                <button wire:click="addAsset({{ $asset->id }})" class="w-full text-left px-4 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">
                                    <flux:text class="font-medium">{{ $asset->name }}</flux:text>
                                    <flux:text size="xs" class="block text-zinc-500">{{ \App\Enums\AssetEnum::from($asset->category)->label() }}</flux:text>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="flex flex-wrap gap-3">
                    @forelse ($selected_assets_models as $asset)
                        <flux:badge color="emerald" variant="pill" size="lg" class="pl-4 pr-2 py-2 gap-3">
                            {{ $asset->name }}
                            <button wire:click="removeAsset({{ $asset->id }})" class="hover:text-emerald-700 dark:hover:text-emerald-300">
                                <flux:icon.x-mark class="size-4" />
                            </button>
                        </flux:badge>
                    @empty
                        <div class="w-full text-center py-8 opacity-50 italic text-sm">
                            Recherchez et ajoutez des atouts pour valoriser votre profil.
                        </div>
                    @endforelse
                </div>
            </div>
        </flux:card>

        <div class="flex gap-4">
            <flux:button wire:click="save" variant="primary" class="flex-1">
                Enregistrer les compétences et atouts
            </flux:button>
            <flux:button :href="route('candidate.profile.index')" variant="ghost" class="flex-1" wire:navigate>
                Annuler
            </flux:button>
        </div>
    </div>
</div>

