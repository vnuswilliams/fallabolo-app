<?php

use Livewire\Attributes\Title;
use Livewire\Component;

use App\Models\JobOffer;
use App\Models\CandidateProfile;
use App\Services\Scoring\MatchingService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Flux\Flux;

new #[Title('Dashboard Candidat')] class extends Component {
    #[Computed]
    public function profile(): ?CandidateProfile
    {
        return Auth::user()->candidateProfile;
    }

    #[Computed]
    public function is_profile_complete(): bool
    {
        return $this->profile !== null && $this->completion === 100;
    }

    #[Computed]
    public function completion(): int
    {
        $profile = $this->profile;
        if (!$profile) return 0;

        $points = 0;
        if ($profile->phone) $points += 10;
        if ($profile->city) $points += 10;
        if ($profile->language_profile) $points += 10;
        if ($profile->education_level) $points += 15;
        if ($profile->experience_tier) $points += 15;
        
        $skillsCount = $profile->candidateSkills()->count();
        $points += min(30, $skillsCount * 10); // 10% per skill up to 3

        if ($profile->salary_min) $points += 10;

        return $points;
    }

    #[Computed]
    public function recommended_offers()
    {
        $offers = JobOffer::with(['recruiterProfile', 'jobRequiredSkills'])
            ->where('status', 'published')
            ->latest()
            ->limit(3)
            ->get();

        if (!$this->profile) {
            return $offers->map(fn($o) => ['model' => $o, 'score' => null]);
        }

        $service = new MatchingService();
        $candidateData = $this->getCandidateData();

        return $offers->map(function($offer) use ($service, $candidateData) {
            $result = $service->calculate($offer, $candidateData);
            return [
                'model' => $offer,
                'score' => $result['score_principal'],
                'passed_blocking' => $result['passed_blocking'],
            ];
        })->sortByDesc('score');
    }

    protected function getCandidateData(): array
    {
        $profile = $this->profile;
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

<div class="flex flex-col gap-8 pb-12">
    {{-- Header --}}
    <div>
        <flux:heading size="xl" level="1">Tableau de bord</flux:heading>
        <flux:subheading>Bienvenue sur votre espace MatchRH, {{ Auth::user()->name }} !</flux:subheading>
    </div>

    {{-- Zone 1 — Barre de complétion du profil --}}
    @if ($this->completion < 100)
        <flux:card class="bg-amber-50 dark:bg-amber-900/10 border-amber-200 dark:border-amber-900/30 p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2 flex-1">
                    <flux:heading size="md" class="text-amber-900 dark:text-amber-200 flex items-center gap-2">
                        <flux:icon.exclamation-circle class="size-5" />
                        Votre profil est complété à {{ $this->completion }}%
                    </flux:heading>
                    <flux:text class="text-amber-800/80 dark:text-amber-300/60">
                        @if(!$this->profile)
                            Démarrez l'onboarding pour créer votre profil et voir votre score de compatibilité.
                        @else
                            Ajoutez plus de compétences pour apparaître dans plus d'offres et optimiser votre matching.
                        @endif
                    </flux:text>

                    <div class="w-full bg-amber-200 dark:bg-amber-900/50 rounded-full h-2.5 mt-4">
                        <div class="bg-amber-500 h-2.5 rounded-full transition-all duration-1000" style="width: {{ $this->completion }}%"></div>
                    </div>
                </div>
                <flux:button variant="primary" :href="$this->profile ? route('candidate.profile.index') : route('candidate.onboarding')" class="bg-amber-600 hover:bg-amber-700 text-white border-none">
                    {{ $this->profile ? 'Finaliser mon profil' : 'Démarrer l\'onboarding' }}
                </flux:button>
            </div>
        </flux:card>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Zone 2 — Offres recommandées --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <flux:heading size="lg">Offres recommandées</flux:heading>
                <flux:link :href="route('candidate.offers.index')" size="sm" wire:navigate>Voir toutes les offres</flux:link>
            </div>

            <div class="space-y-4">
                @forelse ($this->recommended_offers as $item)
                    @php $offer = $item['model']; @endphp
                    <flux:card class="p-6 hover:border-emerald-500/50 transition-colors group">
                        <div class="flex justify-between items-start gap-4">
                            <div class="space-y-1">
                                <flux:heading size="md" class="group-hover:text-emerald-500 transition-colors">{{ $offer->title }}</flux:heading>
                                <flux:text  class="flex items-center gap-2">
                                    <flux:icon.building-office class="size-4" /> {{ $offer->recruiterProfile->company_name }} · {{ $offer->city }}
                                </flux:text>
                                <div class="flex gap-2 mt-4">
                                    <flux:badge size="sm" variant="outline">{{ $offer->template->label() }}</flux:badge>
                                    @if($item['passed_blocking'] === false)
                                        <flux:badge size="sm" color="red" variant="solid">Non-éligible</flux:badge>
                                    @endif
                                </div>
                            </div>

                            <div class="text-right shrink-0">
                                <flux:text size="xs"  class="uppercase tracking-widest font-bold text-zinc-500">Compatibilité</flux:text>
                                @if (!$this->profile)
                                    <div class="mt-1 flex flex-col items-end">
                                        <div class="h-8 w-16 bg-zinc-200 dark:bg-zinc-800 rounded blur-sm"></div>
                                        <flux:text size="xs" color="amber" class="mt-1">Profil requis</flux:text>
                                    </div>
                                @else
                                    @if($item['passed_blocking'] === false)
                                        <flux:text size="sm" color="red" class="font-bold mt-1">Bloqué</flux:text>
                                    @else
                                        <flux:heading size="xl" class="text-emerald-500">{{ $item['score'] }}%</flux:heading>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <flux:button size="sm" variant="ghost" icon-trailing="chevron-right" :href="route('candidate.offers.show', ['offer' => $offer->id])" wire:navigate>Voir l'offre</flux:button>
                        </div>
                    </flux:card>
                @empty
                    <flux:card class="p-12 text-center">
                        <flux:text class="italic opacity-50">Aucune offre disponible pour le moment.</flux:text>
                    </flux:card>
                @endforelse
            </div>
        </div>

        {{-- Zone 3 — Mes candidatures 
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <flux:heading size="lg">Mes candidatures</flux:heading>
            </div>

            <div class="space-y-3">
                @php 
                    $applications = Auth::user()->candidateProfile?->applications()->with('jobOffer.recruiterProfile')->latest()->limit(5)->get() ?? collect();
                @endphp

                @forelse ($applications as $app)
                    <flux:card class="p-4 space-y-4">
                        <div>
                            <flux:text size="sm" class="font-bold truncate">{{ $app->jobOffer->title }}</flux:text>
                            <flux:text size="xs" >{{ $app->jobOffer->recruiterProfile->company_name }}</flux:text>
                        </div>
                        <div class="flex items-center justify-between">
                            <flux:text size="xs" >{{ $app->created_at->format('d/m/Y') }}</flux:text>
                            <flux:badge size="sm" :color="$app->status->color()">{{ $app->status->label() }}</flux:badge>
                        </div>
                    </flux:card>
                @empty
                    <div class="p-8 text-center border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl">
                        <flux:text size="sm" class="italic opacity-50">Vous n'avez pas encore postulé.</flux:text>
                    </div>
                @endforelse
            </div>

            @if($applications->isNotEmpty())
                <flux:button variant="ghost" size="sm" class="w-full" :href="route('candidate.applications.index')" wire:navigate>Voir tout l'historique</flux:button>
            @endif
        </div>--}}
    </div>
</div>

