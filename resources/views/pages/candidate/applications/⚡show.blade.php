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
        <a href="{{ route('candidate.applications.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium flex items-center gap-1 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux candidatures
        </a>
        <h1 class="text-3xl font-serif font-semibold text-gray-900">Détail de la candidature</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <div class="flex items-start justify-between mb-6 pb-6 border-b border-gray-200">
            <div>
                <h2 class="text-2xl font-serif font-semibold text-gray-900">Titre de l'offre</h2>
                <p class="text-gray-600 mt-1">Entreprise · Douala, Cameroon</p>
            </div>
            <span class="inline-flex items-center gap-1 px-4 py-2 rounded-full bg-amber-50 text-amber-700 text-sm font-medium border border-amber-200">
                En attente
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-sm text-gray-600 mb-1">Date de candidature</p>
                <p class="font-medium text-gray-900">12 juin 2026</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 mb-1">Votre score de compatibilité</p>
                <div class="flex items-center gap-3">
                    <span class="text-xl font-bold text-amber-600">75%</span>
                    <div class="w-20 bg-gray-100 rounded h-2">
                        <div class="bg-amber-500 h-2 rounded" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 rounded-xl bg-blue-50 border border-blue-200 mb-6">
            <p class="text-sm text-blue-800">
                <span class="font-medium">Votre candidature est en attente d'examen.</span> L'entreprise examinera votre profil et vous contactera si elle souhaite avancer.
            </p>
        </div>

        <div class="border-t border-gray-200 pt-6">
            <h3 class="font-semibold text-gray-900 mb-4">Messages de l'entreprise</h3>
            <p class="text-gray-500 text-sm">Aucun message pour le moment</p>
        </div>

        <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
            <button class="flex-1 px-4 py-3 text-center rounded-xl border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition">
                Retirer ma candidature
            </button>
            <button class="flex-1 px-4 py-3 text-center rounded-xl bg-brand-500 text-white font-medium hover:bg-brand-600 transition">
                Consulter l'offre
            </button>
        </div>
    </div>
</div>

