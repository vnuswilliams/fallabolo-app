<?php

use Livewire\Component;
use Livewire\Attributes\Title;

use App\Models\Application;
use App\Models\CandidateProfile;
new #[Title('Offres d\'emploi')] class extends Component {
    public int $applicationsCount = 0;
    public int $skillsCount = 0;
    public int $profileCompletion = 0;

  public function mount()
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

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <flux:heading class="text-3xl font-serif font-semibold">Offres d'Emploi</flux:heading>
        <p class="mt-2">Découvrez les opportunités qui vous correspondent</p>
    </div>

    <!-- Filtres -->
    <div class="sticky mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
            <flux:input type="text" placeholder="Chercher..." />
            <flux:select >
                <option value="">Tous les templates</option>
                <option value="manoeuvre">Manœuvre</option>
                <option value="technicien">Technicien</option>
                <option value="agent_maitrise">Agent de maîtrise</option>
                <option value="cadre">Cadre</option>
                <option value="dirigeant">Dirigeant</option>
            </flux:select>
            <flux:select >
                <option value="">Trier par</option>
                <option value="score">Meilleur score</option>
                <option value="recent">Plus récentes</option>
                <option value="salary">Salaire</option>
            </flux:select>
            <flux:button variant="primary">
                Filtrer
            </flux:button>
        </div>
    </div>
  <flux:card variant="outline" class="mb-5 bg-linear-to-r from-brand-50 to-brand-100 dark:from-brand-900/10 dark:to-brand-800/10 border-brand-200 dark:border-brand-800">
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
    <!-- Liste des offres -->
        <flux:card variant="outline" class="bg-linear-to-r from-brand-50 to-brand-100 dark:from-brand-900/10 dark:to-brand-800/10 border-brand-200 dark:border-brand-800">

        <!-- État vide -->
        <div class=" rounded-2xl   p-12">
            <div class="text-center">
                <svg class="w-16 h-16  mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <h3 class="text-lg font-semibold mb-2">Aucune offre disponible pour le moment</h3>
            </div>
        </div>
        </flux:card>
</div>
