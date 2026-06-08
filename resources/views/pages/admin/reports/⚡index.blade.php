<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Modération — Signalements')] class extends Component {
    // Hardcoded data for UI scaffolding
}; ?>

<div class="flex flex-col gap-8">
    <div>
        <flux:heading size="xl" level="1">Modération</flux:heading>
        <flux:subheading>Gérez les signalements et assurez l'intégrité de la plateforme.</flux:subheading>
    </div>

    <flux:card class="p-4 flex flex-wrap gap-4 items-center border-zinc-200 dark:border-zinc-800">
        <div class="flex-1 flex gap-4">
            <flux:select placeholder="Type de signalement" class="w-48">
                <flux:select.option value="all">Tous les types</flux:select.option>
                <flux:select.option value="offer">Offres d'emploi</flux:select.option>
                <flux:select.option value="candidate">Profils candidats</flux:select.option>
            </flux:select>
            <flux:select placeholder="Statut" class="w-48">
                <flux:select.option value="pending">En attente (14)</flux:select.option>
                <flux:select.option value="reviewed">Traités</flux:select.option>
                <flux:select.option value="dismissed">Rejetés</flux:select.option>
            </flux:select>
        </div>
        <flux:input placeholder="Rechercher..." icon="magnifying-glass" class="w-64" />
    </flux:card>

    <flux:card class="p-0 overflow-hidden border-zinc-200 dark:border-zinc-800">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Élément signalé</flux:table.column>
                <flux:table.column>Reporter</flux:table.column>
                <flux:table.column>Raison & Commentaire</flux:table.column>
                <flux:table.column>Signalements</flux:table.column>
                <flux:table.column>Statut</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                {{-- Signalement 1 --}}
                <flux:table.row>
                    <flux:table.cell>
                        <div class="flex flex-col">
                            <flux:text class="font-bold text-zinc-900 dark:text-white">Offre: Comptable Senior</flux:text>
                            <flux:text size="xs" class="text-zinc-500">ID: OFF-782 · Par: FinGroup Yaoundé</flux:text>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:text size="sm">Jean Ekotto</flux:text>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="flex flex-col gap-1">
                            <flux:badge color="amber" size="sm" inset="top bottom">Fake offer</flux:badge>
                            <flux:text size="xs" class="italic">"L'entreprise n'existe pas à cette adresse."</flux:text>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge variant="pill" size="sm">3 signalements</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="amber" variant="solid" size="sm">En attente</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                            <flux:menu>
                                <flux:menu.item icon="eye">Voir l'élément</flux:menu.item>
                                <flux:menu.item icon="check" class="text-emerald-500">Marquer comme traité</flux:menu.item>
                                <flux:menu.item icon="no-symbol" class="text-rose-500">Suspendre le profil</flux:menu.item>
                                <flux:menu.separator />
                                <flux:menu.item icon="x-mark" class="text-zinc-500">Rejeter le signalement</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>

                {{-- Signalement 2 --}}
                <flux:table.row>
                    <flux:table.cell>
                        <div class="flex flex-col">
                            <flux:text class="font-bold text-zinc-900 dark:text-white">Candidat: Paul Essomba</flux:text>
                            <flux:text size="xs" class="text-zinc-500">ID: CAN-239 · Yaoundé</flux:text>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:text size="sm">TechCorp Douala</flux:text>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="flex flex-col gap-1">
                            <flux:badge color="amber" size="sm" inset="top bottom">Inappropriate</flux:badge>
                            <flux:text size="xs" class="italic">"Propos injurieux lors de l'entretien."</flux:text>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge variant="pill" size="sm">1 signalement</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="amber" variant="solid" size="sm">En attente</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                            <flux:menu>
                                <flux:menu.item icon="eye">Voir le profil</flux:menu.item>
                                <flux:menu.item icon="check">Marquer comme traité</flux:menu.item>
                                <flux:menu.item icon="no-symbol" class="text-rose-500">Suspendre le candidat</flux:menu.item>
                                <flux:menu.separator />
                                <flux:menu.item icon="x-mark">Rejeter le signalement</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>

                {{-- Signalement 3 --}}
                <flux:table.row>
                    <flux:table.cell>
                        <div class="flex flex-col">
                            <flux:text class="font-bold text-zinc-900 dark:text-white">Offre: Agent de Sécurité</flux:text>
                            <flux:text size="xs" class="text-zinc-500">ID: OFF-912 · Par: Alpha Security</flux:text>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:text size="sm">Marie Mballa</flux:text>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="flex flex-col gap-1">
                            <flux:badge color="amber" size="sm" inset="top bottom">Discriminatory</flux:badge>
                            <flux:text size="xs" class="italic">"L'offre demande explicitement un homme."</flux:text>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge variant="pill" size="sm">12 signalements</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="rose" variant="solid" size="sm">Suspendu auto</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                            <flux:menu>
                                <flux:menu.item icon="eye">Voir l'offre</flux:menu.item>
                                <flux:menu.item icon="arrow-path">Lever la suspension</flux:menu.item>
                                <flux:menu.item icon="trash" class="text-rose-500">Supprimer définitivement</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            </flux:table.rows>
        </flux:table>
    </flux:card>

    {{-- Rappel des règles de suspension automatique --}}
    <div class="bg-zinc-100 dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800">
        <flux:heading size="sm" class="mb-4 flex items-center gap-2">
            <flux:icon.information-circle class="size-4 text-zinc-500" />
            Rappel des règles de suspension automatique
        </flux:heading>
        <flux:text size="xs" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2">
            <span>• Seuil de déclenchement: <strong>10 signalements</strong> cumulés.</span>
            <span>• Condition d'unicité: Proviennent d'au moins <strong>5 utilisateurs distincts</strong>.</span>
            <span>• Effet Recruteur: Toutes les offres sont masquées, compte bloqué.</span>
            <span>• Effet Candidat: Profil retiré du matching, compte bloqué.</span>
        </flux:text>
    </div>
</div>
