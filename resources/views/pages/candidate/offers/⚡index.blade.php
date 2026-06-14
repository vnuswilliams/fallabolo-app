<?php

use Livewire\Attributes\Title;
use Livewire\Component;

use App\Models\JobOffer;
use App\Models\Skill;
use App\Services\Scoring\MatchingService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Flux\Flux;

new #[Title('Offres disponibles')] class extends Component {
    public string $search = '';
    public string $city_filter = '';

    #[Computed]
    public function is_profile_complete(): bool
    {
        return Auth::user()->candidateProfile !== null;
    }

    #[Computed]
    public function offers()
    {
        $query = JobOffer::with(['recruiterProfile', 'jobRequiredSkills'])
            ->where('status', 'published')
            ->latest();

        if ($this->search) {
            $query->where('title', 'like', "%{$this->search}%");
        }

        if ($this->city_filter) {
            $query->where('city', $this->city_filter);
        }

        $offers = $query->get();

        if (!$this->is_profile_complete()) {
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

<div class="max-w-5xl mx-auto space-y-8 pb-12">
    <div>
        <flux:heading size="xl">Offres d'emploi</flux:heading>
        <flux:subheading>Découvrez les opportunités qui correspondent à votre profil.</flux:subheading>
    </div>

    {{-- Filtres --}}
    <flux:card class="p-4 flex flex-wrap gap-4 items-center border-zinc-200 dark:border-zinc-800">
        <flux:input wire:model.live.debounce.300ms="search" placeholder="Rechercher un poste..." class="flex-1" icon="magnifying-glass" />
        <flux:select wire:model.live="city_filter" placeholder="Ville" class="w-full md:w-48">
            <flux:select.option value="">Toutes les villes</flux:select.option>
            @foreach(\App\Enums\CityEnum::cases() as $city)
                <flux:select.option value="{{ $city->value }}">{{ $city->label() }}</flux:select.option>
            @endforeach
        </flux:select>
    </flux:card>

    @if(!$this->is_profile_complete())
        <div class="p-6 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="p-3 rounded-xl bg-amber-500/20 text-amber-600 dark:text-amber-400">
                    <flux:icon.exclamation-triangle class="size-6" />
                </div>
                <div>
                    <flux:heading size="md">Profil incomplet</flux:heading>
                    <flux:text >Complétez votre profil pour voir votre score de compatibilité avec ces offres.</flux:text>
                </div>
            </div>
            <flux:button :href="route('candidate.onboarding')" variant="primary" class="bg-amber-500 hover:bg-amber-600 border-none text-zinc-950 font-bold">Compléter mon profil</flux:button>
        </div>
    @endif

    <div class="space-y-4">
        @forelse ($this->offers as $item)
            @php $offer = $item['model']; @endphp
            <flux:card class="p-6 hover:border-emerald-500/50 transition-colors group">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div class="flex gap-4">
                        <div class="w-14 h-14 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0 border border-zinc-200 dark:border-zinc-700">
                            <flux:icon.building-office class="size-6 text-zinc-400" />
                        </div>
                        <div class="space-y-1">
                            <flux:heading size="md" class="group-hover:text-emerald-500 transition-colors">{{ $offer->title }}</flux:heading>
                            <flux:text  class="flex items-center gap-2">
                                {{ $offer->recruiterProfile->company_name }} · {{ $offer->city }}
                            </flux:text>
                            <flux:text size="xs" >Publiée {{ $offer->created_at->diffForHumans() }}</flux:text>
                        </div>
                    </div>

                    <div class="flex items-center gap-8 self-end sm:self-center">
                        <div class="text-right">
                            <flux:text size="xs"  class="uppercase tracking-widest font-bold">Compatibilité</flux:text>
                            @if (!$this->is_profile_complete())
                                <div class="mt-1 flex flex-col items-end">
                                    <div class="h-8 w-16 bg-zinc-200 dark:bg-zinc-800 rounded blur-sm"></div>
                                </div>
                            @else
                                @if(!$item['passed_blocking'])
                                    <flux:badge color="red" size="sm" variant="pill">Bloqué</flux:badge>
                                @else
                                    <flux:heading size="lg" class="text-emerald-500">{{ $item['score'] }}%</flux:heading>
                                @endif
                            @endif
                        </div>
                        <flux:button variant="ghost" icon-trailing="chevron-right" :href="route('candidate.offers.show', ['offer' => $offer->id])" wire:navigate>Voir l'offre</flux:button>
                    </div>
                </div>
            </flux:card>
        @empty
            <div class="text-center py-24">
                <flux:icon.briefcase class="size-12 mx-auto text-zinc-300 dark:text-zinc-700 mb-4" />
                <flux:heading size="lg">Aucune offre trouvée</flux:heading>
                <flux:subheading>Essayez de modifier vos critères de recherche.</flux:subheading>
            </div>
        @endforelse
    </div>
    <div class="flex justify-center pt-8">
      {{--   <flux:pagination /> --}}
    </div>
</div>


