<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Application;
use App\Models\CandidateProfile;

new #[Title('Tableau de Bord Candidat')] class extends Component {
    public int $applicationsCount = 0;
    public int $skillsCount = 0;
    public int $profileCompletion = 0;

    public function mount(): void
    {
        $candidateProfile = auth()->user()->candidateProfile;

        if ($candidateProfile) {
            $this->applicationsCount = Application::whereHas('matchResult', function ($query) use ($candidateProfile) {
                $query->where('candidate_profile_id', $candidateProfile->id);
            })->count();

            $this->skillsCount = $candidateProfile->candidateSkills()->count();

            // Basic calculation for profile completion
            $fields = [
                $candidateProfile->phone,
                $candidateProfile->city,
                $candidateProfile->education_level,
                $candidateProfile->experience_tier,
                $candidateProfile->language_profile,
                $candidateProfile->cv_path
            ];
            $filled = count(array_filter($fields));
            $this->profileCompletion = ($filled / count($fields)) * 100;
        }
    }
}; ?>

    <div class="flex flex-col gap-6">
        <div>
            <flux:heading size="xl" level="1">Tableau de Bord Candidat</flux:heading>
            <flux:subheading>Bienvenue sur MatchRH, trouvez les meilleures opportunités au mérite.</flux:subheading>
        </div>

        <flux:card variant="outline" class="bg-linear-to-r from-brand-50 to-brand-100 dark:from-brand-900/10 dark:to-brand-800/10 border-brand-200 dark:border-brand-800">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <flux:heading size="lg" class="text-brand-900 dark:text-brand-100">Complétez votre profil</flux:heading>
                    <flux:subheading class="text-brand-700 dark:text-brand-300">Essentiel pour calculer votre compatibilité avec les offres.</flux:subheading>
                </div>
                <div class="text-right">
                    <flux:heading size="xl" class="text-brand-600 dark:text-brand-400">{{ round($profileCompletion) }}%</flux:heading>
                    <flux:subheading class="text-brand-700 dark:text-brand-300">Complété</flux:subheading>
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-full h-2 overflow-hidden mb-4">
                <div class="bg-brand-500 h-full rounded-full transition-all duration-500" style="width: {{ $profileCompletion }}%"></div>
            </div>
            <flux:button variant="primary" :href="route('candidate.profile.edit')" icon="chevron-right" icon-trailing wire:navigate>
                Compléter mon profil
            </flux:button>
        </flux:card>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Actions rapides -->
            <flux:card class="flex flex-col gap-4">
                <flux:heading size="lg">Actions rapides</flux:heading>
                <flux:navlist variant="outline" class="bg-white dark:bg-zinc-900 rounded-xl p-2 border border-zinc-200 dark:border-zinc-800">
                    <flux:navlist.item :href="route('candidate.offers.index')" icon="magnifying-glass" wire:navigate>
                        Parcourir les offres
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('candidate.applications.index')" icon="document-text" wire:navigate>
                        Mes candidatures
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('candidate.profile.index')" icon="user" wire:navigate>
                        Voir mon profil
                    </flux:navlist.item>
                </flux:navlist>
            </flux:card>

            <!-- Statistiques -->
            <div class="grid grid-cols-1 gap-6">
                <flux:card class="flex items-center gap-4">
                    <div class="bg-brand-50 dark:bg-brand-900/20 p-3 rounded-xl">
                        <flux:icon.document-text class="text-brand-600 dark:text-brand-400" />
                    </div>
                    <div>
                        <flux:heading size="sm" class="text-zinc-500">Candidatures</flux:heading>
                        <flux:heading size="lg">{{ $applicationsCount }}</flux:heading>
                    </div>
                </flux:card>

                <flux:card class="flex items-center gap-4">
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 p-3 rounded-xl">
                        <flux:icon.bolt class="text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <div>
                        <flux:heading size="sm" class="text-zinc-500">Compétences</flux:heading>
                        <flux:heading size="lg">{{ $skillsCount }}</flux:heading>
                    </div>
                </flux:card>
            </div>
        </div>
    </div>
