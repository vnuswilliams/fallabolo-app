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
        <a href="{{ route('candidate.profile.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium flex items-center gap-1 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour au profil
        </a>
        <h1 class="text-3xl font-serif font-semibold text-gray-900">Éditer mon profil</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <form class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                    <input type="text" placeholder="Jean" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-50">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                    <input type="text" placeholder="Dupont" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-50">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ville *</label>
                    <input type="text" placeholder="Douala" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-50">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pays *</label>
                    <input type="text" placeholder="Cameroon" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-50">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Palier d'expérience *</label>
                <select class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-50">
                    <option value="">Sélectionnez</option>
                    <option value="0-2">0-2 ans</option>
                    <option value="2-5">2-5 ans</option>
                    <option value="5-10">5-10 ans</option>
                    <option value="10+">10+ ans</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Niveau de formation *</label>
                <select class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-50">
                    <option value="">Sélectionnez</option>
                    <option value="bac">Baccalauréat</option>
                    <option value="bac+2">Bac+2</option>
                    <option value="bac+3">Bac+3</option>
                    <option value="bac+5">Bac+5</option>
                    <option value="master">Master</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Disponibilité *</label>
                <select class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-50">
                    <option value="">Sélectionnez</option>
                    <option value="immediate">Immédiatement</option>
                    <option value="2weeks">2 semaines</option>
                    <option value="1month">1 mois</option>
                    <option value="2months">2 mois</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Langue *</label>
                <select class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-50">
                    <option value="">Sélectionnez</option>
                    <option value="french">Francophone</option>
                    <option value="english">Anglophone</option>
                    <option value="bilingual">Bilingue</option>
                </select>
            </div>

            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('candidate.profile.index') }}" class="flex-1 px-4 py-3 text-center rounded-xl border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit" class="flex-1 px-4 py-3 rounded-xl bg-brand-500 text-white font-medium hover:bg-brand-600 transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

