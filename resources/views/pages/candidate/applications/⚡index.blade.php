<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\CandidateProfile;
use Illuminate\Support\Facades\Auth;

new #[Title('Mon Profil')] class extends Component {
    public function candidateProfile()
    {
        return Auth::user()->candidateProfile;
    }
}; ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-serif font-semibold text-gray-900">Mes Candidatures</h1>
        <p class="text-gray-600 mt-2">Suivi de vos candidatures et statuts</p>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
        <div class="flex gap-3 items-center">
            <select class="flex-1 px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-brand-500 text-sm">
                <option value="">Tous les statuts</option>
                <option value="pending">En attente</option>
                <option value="viewed">Consultée</option>
                <option value="shortlisted">Présélectionnée</option>
                <option value="rejected">Rejetée</option>
            </select>
            <input type="text" placeholder="Chercher..." class="flex-1 px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-brand-500 text-sm">
        </div>
    </div>

    <!-- Liste des candidatures -->
    <div class="space-y-3">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-500">Aucune candidature pour le moment</p>
                <a href="{{ route('candidate.offers.index') }}" class="text-sm text-brand-600 hover:text-brand-700 font-medium mt-2">
                    Parcourir les offres →
                </a>
            </div>
        </div>
    </div>
</div>

