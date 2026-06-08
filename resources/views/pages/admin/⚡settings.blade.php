<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Paramètres Plateforme')] class extends Component {
    // Hardcoded data for UI scaffolding
}; ?>

<div class="flex flex-col gap-8 max-w-4xl">
    <div>
        <flux:heading size="xl" level="1">Paramètres</flux:heading>
        <flux:subheading>Configurez les réglages globaux de MatchRH.</flux:subheading>
    </div>

    <div class="space-y-6">
        {{-- Maintenance & Accès --}}
        <flux:card class="p-6 space-y-6 border-zinc-200 dark:border-zinc-800">
            <flux:heading size="lg">Maintenance & Accès</flux:heading>
            
            <flux:field>
                <div class="flex items-center justify-between">
                    <div>
                        <flux:label>Mode Maintenance</flux:label>
                        <flux:text size="xs">Désactive l'accès public à la plateforme.</flux:text>
                    </div>
                    <flux:switch />
                </div>
            </flux:field>

            <flux:field>
                <div class="flex items-center justify-between">
                    <div>
                        <flux:label>Inscriptions ouvertes</flux:label>
                        <flux:text size="xs">Permet aux nouveaux utilisateurs de créer un compte.</flux:text>
                    </div>
                    <flux:switch checked />
                </div>
            </flux:field>
        </flux:card>

        {{-- Algorithme & Matching --}}
        <flux:card class="p-6 space-y-6 border-zinc-200 dark:border-zinc-800">
            <flux:heading size="lg">Algorithme & Matching</flux:heading>
            
            <flux:field>
                <flux:label>Seuil de visibilité du score (%)</flux:label>
                <flux:text size="xs" class="mb-2">Score minimum pour qu'un candidat soit recommandé.</flux:text>
                <flux:input type="number" value="60" class="w-32" />
            </flux:field>

            <flux:field>
                <div class="flex items-center justify-between">
                    <div>
                        <flux:label>Poids des "Atouts" dans le score global</flux:label>
                        <flux:text size="xs">Influence des bonus sectoriels/certifications.</flux:text>
                    </div>
                    <flux:select class="w-48">
                        <flux:select.option value="low">Faible (10%)</flux:select.option>
                        <flux:select.option value="medium" selected>Moyen (20%)</flux:select.option>
                        <flux:select.option value="high">Fort (30%)</flux:select.option>
                    </flux:select>
                </div>
            </flux:field>
        </flux:card>

        {{-- Signalement & Modération --}}
        <flux:card class="p-6 space-y-6 border-zinc-200 dark:border-zinc-800">
            <flux:heading size="lg">Signalement & Modération</flux:heading>
            
            <flux:field>
                <flux:label>Seuil de suspension automatique (Signalements)</flux:label>
                <flux:text size="xs" class="mb-2">Nombre total de signalements avant suspension du profil.</flux:text>
                <flux:input type="number" value="10" class="w-32" />
            </flux:field>

            <flux:field>
                <flux:label>Nombre d'utilisateurs distincts requis</flux:label>
                <flux:text size="xs" class="mb-2">Les signalements doivent provenir de X personnes différentes.</flux:text>
                <flux:input type="number" value="5" class="w-32" />
            </flux:field>
        </flux:card>

        <div class="flex justify-end gap-4">
            <flux:button variant="ghost">Réinitialiser</flux:button>
            <flux:button variant="primary">Enregistrer les modifications</flux:button>
        </div>
    </div>
</div>
