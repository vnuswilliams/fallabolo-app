<?php

use Livewire\Attributes\Title;
use Livewire\Component;

use App\Models\JobOffer;
use App\Models\Skill;
use App\Services\Scoring\MatchingService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Flux\Flux;

new #[Title('Détail de l\'offre')] class extends Component {
    public JobOffer $offer;

    public function mount(JobOffer $offer)
    {
        $this->offer = $offer->load(['recruiterProfile', 'jobRequiredSkills']);
    }

    #[Computed]
    public function is_profile_complete(): bool
    {
        return Auth::user()->candidateProfile !== null;
    }

    #[Computed]
    public function matching_result(): array
    {
        if (!$this->is_profile_complete()) {
            return [
                'passed_blocking' => true,
                'score_principal' => null,
                'scores_details' => [],
                'assets_matched' => [],
            ];
        }

        $service = new MatchingService();
        $candidateData = $this->getCandidateData();

        return $service->calculate($this->offer, $candidateData);
    }

    protected function getCandidateData(): array
    {
        $profile = Auth::user()->candidateProfile;
        return [
            'language_profile' => $profile->language_profile,
            'education_level' => $profile->education_level,
            'experience_tier' => $profile->experience_tier,
            'availability' => $profile->availability,
            'city' => $profile->city,
            'skills' => $profile->candidateSkills->pluck('level', 'skill_id')->toArray(),
            'salary_min' => $profile->salary_min,
            'salary_max' => $profile->salary_max,
            'assets' => $profile->assets ?? [],
        ];
    }
}; ?>

<div class="max-w-3xl mx-auto space-y-8 pb-12">
    <flux:link :href="route('candidate.offers.index')" icon="chevron-left" variant="ghost" wire:navigate>Retour aux offres</flux:link>

    <flux:card class="p-0 overflow-hidden border-zinc-200 dark:border-zinc-800">
        {{-- Header Offre --}}
        <div class="p-8 bg-zinc-50 dark:bg-zinc-900/50 border-b border-zinc-200 dark:border-zinc-800">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center">
                        <flux:icon.building-office class="size-8 text-zinc-400" />
                    </div>
                    <div>
                        <flux:heading size="xl">{{ $offer->title }}</flux:heading>
                        <flux:text  class="flex items-center gap-2 mt-1">
                            {{ $offer->recruiterProfile->company_name }} · {{ $offer->city }} · Publiée {{ $offer->created_at->diffForHumans() }}
                        </flux:text>
                    </div>
                </div>

                <div class="flex flex-col items-center p-4 bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700">
                    <flux:text size="xs" class="uppercase tracking-widest font-bold text-zinc-500">Votre Compatibilité</flux:text>
                    @if (!$this->is_profile_complete())
                        <flux:text  class="mt-2 text-amber-500 font-bold">Profil incomplet</flux:text>
                    @else
                        @if(!$this->matching_result['passed_blocking'])
                            <flux:badge color="red" size="sm" variant="pill" class="mt-2">Critère Bloquant Non Atteint</flux:badge>
                        @else
                            <flux:heading size="xl" class="text-emerald-500">{{ $this->matching_result['score_principal'] }}%</flux:heading>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        {{-- Détails du Score pour le Candidat --}}
        @if ($this->is_profile_complete())
            <div class="p-8 space-y-8">
                <div>
                    <flux:heading size="lg" class="mb-6">Pourquoi ce score ?</flux:heading>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                        @foreach([
                            'Compétences' => 'skills',
                            'Expérience' => 'experience',
                            'Formation' => 'education',
                            'Disponibilité' => 'availability',
                            'Localisation' => 'location',
                            'Salaire' => 'salary'
                        ] as $label => $key)
                            @php $score = $this->matching_result['scores_details'][$key] ?? 0; @endphp
                            <div class="flex items-center justify-between py-2 border-b border-zinc-100 dark:border-zinc-800">
                                <flux:text>{{ $label }}</flux:text>
                                <div class="flex items-center gap-3">
                                    <flux:text @class(['font-bold', 'text-emerald-500' => $score >= 80, 'text-amber-500' => $score >= 50 && $score < 80, 'text-rose-500' => $score < 50])>
                                        {{ $score }}%
                                    </flux:text>
                                    @if($score >= 80)
                                        <flux:icon.check-circle variant="solid" class="text-emerald-500 size-5" />
                                    @elseif($score >= 50)
                                        <flux:icon.exclamation-circle variant="solid" class="text-amber-500 size-5" />
                                    @else
                                        <flux:icon.x-circle variant="solid" class="text-rose-500 size-5" />
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if(!empty($this->offer->required_assets))
                    <flux:separator />

                    {{-- Atouts --}}
                    <div>
                        <flux:heading size="lg" class="mb-4">Atouts recherchés ({{ count($this->matching_result['assets_matched']) }}/{{ count($this->offer->required_assets) }})</flux:heading>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($this->offer->required_assets as $assetId => $priority)
                                @php 
                                    $asset = \App\Models\Asset::find($assetId);
                                    $isMatched = in_array($assetId, $this->matching_result['assets_matched']);
                                @endphp
                                <div @class(['flex items-center gap-3', 'opacity-50' => !$isMatched])>
                                    @if($isMatched)
                                        <flux:icon.check class="text-emerald-500 size-4" />
                                    @else
                                        <flux:icon.x-mark class="text-zinc-400 size-4" />
                                    @endif
                                    <flux:text size="sm">{{ $asset?->name ?? 'Atout inconnu' }}</flux:text>
                                    @if($priority === 'Fort')
                                        <flux:badge size="xs" color="rose">Priorité</flux:badge>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <flux:separator />

                {{-- Description --}}
                <div class="space-y-4">
                    <flux:heading size="lg">Description du poste</flux:heading>
                    <div class="text-sm leading-relaxed whitespace-pre-line text-zinc-600 dark:text-zinc-400">
                        {{ $offer->description }}
                    </div>
                </div>
            </div>
        @else
            <div class="p-24 text-center space-y-6">
                <flux:icon.lock-closed class="size-12 mx-auto text-zinc-300" />
                <div>
                    <flux:heading size="lg">Analyse du matching verrouillée</flux:heading>
                    <flux:subheading>Complétez votre profil pour découvrir le détail de votre score avec cette offre.</flux:subheading>
                </div>
                <flux:button :href="route('candidate.onboarding')" variant="primary" class="bg-emerald-500 hover:bg-emerald-600 border-none text-zinc-950 font-bold">Démarrer l'onboarding</flux:button>
            </div>
        @endif

        {{-- Actions --}}
        <div class="p-8 bg-zinc-50 dark:bg-zinc-900/50 flex flex-wrap gap-4 border-t border-zinc-200 dark:border-zinc-800">
            @if($this->is_profile_complete())
                @if(!$this->matching_result['passed_blocking'])
                    <flux:button disabled variant="primary" class="flex-1">Critères non remplis</flux:button>
                @else
                    <flux:button variant="primary" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-zinc-950 font-bold">Postuler maintenant</flux:button>
                @endif
            @endif
            <flux:modal.trigger name="report-modal">
                <flux:button variant="ghost" icon="exclamation-triangle" class="text-amber-600">Signaler l'offre</flux:button>
            </flux:modal.trigger>
        </div>
    </flux:card>

    <livewire:report-modal type="offer" />
</div>

