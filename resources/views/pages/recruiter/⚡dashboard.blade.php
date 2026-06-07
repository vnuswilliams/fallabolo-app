<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\JobOffer;
use App\Models\Application;

new #[Title('Tableau de Bord Recruteur')] class extends Component {
    public int $activeOffersCount = 0;
    public int $applicationsCount = 0;
    public int $shortlistedCount = 0;

    public function mount(): void
    {
        $recruiterProfile = auth()->user()->recruiterProfile;

        if ($recruiterProfile) {
            $this->activeOffersCount = $recruiterProfile->jobOffers()
                ->where('status', \App\Enums\JobStatusEnum::PUBLISHED)
                ->count();

            // Total applications for all recruiter's offers
            $this->applicationsCount = Application::whereHas('matchResult.jobOffer', function ($query) use ($recruiterProfile) {
                $query->where('recruiter_profile_id', $recruiterProfile->id);
            })->count();

            $this->shortlistedCount = Application::whereHas('matchResult.jobOffer', function ($query) use ($recruiterProfile) {
                $query->where('recruiter_profile_id', $recruiterProfile->id);
            })->where('status', \App\Enums\ApplicationStatusEnum::SHORTLISTED)->count();
        }
    }
}; ?>

    <div class="flex flex-col gap-6">
        <div>
            <flux:heading size="xl" level="1">Tableau de Bord Recruteur</flux:heading>
            <flux:subheading>Gérez vos offres d'emploi et visualisez les candidatures sur MatchRH</flux:subheading>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Statistiques -->
            <flux:card class="flex items-center gap-4">
                <div class="bg-brand-50 dark:bg-brand-900/20 p-3 rounded-xl">
                    <flux:icon.building-office class="text-brand-600 dark:text-brand-400" />
                </div>
                <div>
                    <flux:heading size="sm" class="text-zinc-500">Offres actives</flux:heading>
                    <flux:heading size="lg">{{ $activeOffersCount }}</flux:heading>
                </div>
            </flux:card>

            <flux:card class="flex items-center gap-4">
                <div class="bg-emerald-50 dark:bg-emerald-900/20 p-3 rounded-xl">
                    <flux:icon.users class="text-emerald-600 dark:text-emerald-400" />
                </div>
                <div>
                    <flux:heading size="sm" class="text-zinc-500">Candidatures reçues</flux:heading>
                    <flux:heading size="lg">{{ $applicationsCount }}</flux:heading>
                </div>
            </flux:card>

            <flux:card class="flex items-center gap-4">
                <div class="bg-amber-50 dark:bg-amber-900/20 p-3 rounded-xl">
                    <flux:icon.check-badge class="text-amber-600 dark:text-amber-400" />
                </div>
                <div>
                    <flux:heading size="sm" class="text-zinc-500">Présélectionnés</flux:heading>
                    <flux:heading size="lg">{{ $shortlistedCount }}</flux:heading>
                </div>
            </flux:card>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Actions rapides -->
            <div class="lg:col-span-1 flex flex-col gap-4">
                <flux:heading size="lg">Actions rapides</flux:heading>
                <flux:navlist variant="outline" class="bg-white dark:bg-zinc-900 rounded-xl p-2 border border-zinc-200 dark:border-zinc-800">
                    <flux:navlist.item :href="route('recruiter.offers.create')" icon="plus" wire:navigate>
                        {{ __('Créer une offre') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('recruiter.offers.index')" icon="briefcase" wire:navigate>
                        {{ __('Mes offres') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('recruiter.profile.index')" icon="user" wire:navigate>
                        {{ __('Profil Entreprise') }}
                    </flux:navlist.item>
                </flux:navlist>
            </div>

            <!-- Offres récentes -->
            <div class="lg:col-span-2 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <flux:heading size="lg">Offres récentes</flux:heading>
                    <flux:link :href="route('recruiter.offers.index')" size="sm" wire:navigate>Voir tout</flux:link>
                </div>

                <flux:card>
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <flux:icon.document-text class="size-12 text-zinc-300 mb-4" />
                        <flux:heading>Aucune offre pour le moment</flux:heading>
                        <flux:subheading class="mb-6">Commencez par publier votre première offre d'emploi.</flux:subheading>
                        <flux:button :href="route('recruiter.offers.create')" variant="primary" wire:navigate>Créer une offre</flux:button>
                    </div>
                </flux:card>
            </div>
        </div>
    </div>
