<?php

use Livewire\Component;

new #[Title('Tableau de Bord Candidat')] class extends Component {

}; ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <flux:link href="{{ route('recruiter.offers.index') }}" class="flex items-center gap-1 mb-4" wire:navigate>
            <flux:icon.chevron-left />
            Retour aux offres
        </flux:link>
        <h1 class="text-3xl font-serif font-semibold">Créer une nouvelle offre</h1>
        <p class=" mt-2">Suivez les étapes pour configurer votre offre d'emploi</p>
    </div>

    <div class="rounded-2xl p-8">
        <!-- Indicateur d'étapes -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm ">
                    <span class="font-semibold">Étape 1</span> de 6
                </div>
                <div class="w-1/2 bg-gray-100 rounded-full h-2">
                    <div class="bg-brand-500 h-2 rounded-full transition-all duration-300" style="width: 16.66%"></div>
                </div>
            </div>
        </div>

        <!-- Formulaire -->
        <form class="space-y-6">
            <!-- Étape 1: Informations générales -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Informations générales</h2>

                <div class="space-y-4">
                    <div>
                        <flux:input label="Titre du poste  *" type="text" placeholder="Ex: Développeur Laravel Senior" class="w-full"/>
                    </div>

                    <div>
                        <flux:textarea rows="5" label="Description du poste *" placeholder="Décrivez le rôle, les responsabilités..." class="w-full"></flux:textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                        <flux:input label="Localisation *" type="text" placeholder="Ex: Développeur Laravel Senior" class="w-full"/>
                        </div>

                        <div>
                            <flux:select label="Template de poste *" class="w-full">
                                <option value="">Sélectionnez un template</option>
                                <option value="manoeuvre">Manœuvre</option>
                                <option value="technicien">Technicien</option>
                                <option value="agent_maitrise">Agent de maîtrise</option>
                                <option value="cadre">Cadre</option>
                                <option value="dirigeant">Dirigeant</option>
                            </flux:select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <flux:input type="number" placeholder="0" class="w-full" label="Salaire minimum (FCFA)"/>
                        </div>

                        <div>
                            <flux:input type="number" placeholder="0" class="w-full" label="Salaire maximum (FCFA)"/>
                        </div>
                    </div>

                    <div>
                                                   <flux:select label="Langue requise *" class="w-full">

                            <option value="">Sélectionnez</option>
                            <option value="french">Francophone</option>
                            <option value="english">Anglophone</option>
                            <option value="bilingual">Bilingue</option>
                                                   </flux:select>

                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex justify-between items-center gap-3 pt-6 border-t border-gray-100">
                <flux:link href="{{ route('recruiter.offers.index') }}" wire:navigate>
                    Annuler
                </flux:link>

                <flux:button type="button" class="transition">
                    Continuer
                </flux:button>
            </div>
        </form>
    </div>
</div>

