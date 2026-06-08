<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Gestion des Utilisateurs')] class extends Component {
    // Hardcoded data for UI scaffolding
}; ?>

<div class="flex flex-col gap-8">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl" level="1">Utilisateurs</flux:heading>
            <flux:subheading>Gérez les candidats, recruteurs et admins de la plateforme.</flux:subheading>
        </div>
        <flux:button variant="primary" icon="plus">Nouvel utilisateur</flux:button>
    </div>

    <flux:card class="p-4 flex flex-wrap gap-4 items-center border-zinc-200 dark:border-zinc-800">
        <flux:select placeholder="Rôle" class="w-48">
            <flux:select.option value="all">Tous les rôles</flux:select.option>
            <flux:select.option value="candidate">Candidats</flux:select.option>
            <flux:select.option value="recruiter">Recruteurs</flux:select.option>
            <flux:select.option value="admin">Administrateurs</flux:select.option>
        </flux:select>
        <flux:select placeholder="État" class="w-48">
            <flux:select.option value="active">Actifs</flux:select.option>
            <flux:select.option value="suspended">Suspendus</flux:select.option>
        </flux:select>
        <flux:input placeholder="Nom, email, téléphone..." icon="magnifying-glass" class="flex-1" />
    </flux:card>

    <flux:card class="p-0 overflow-hidden border-zinc-200 dark:border-zinc-800">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Utilisateur</flux:table.column>
                <flux:table.column>Rôle</flux:table.column>
                <flux:table.column>Localisation</flux:table.column>
                <flux:table.column>Inscrit le</flux:table.column>
                <flux:table.column>Statut</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                {{-- Recruteur 1 --}}
                <flux:table.row>
                    <flux:table.cell>
                        <div class="flex items-center gap-3">
                            <flux:avatar initials="TC" class="bg-blue-500 text-white" />
                            <div class="flex flex-col">
                                <flux:text class="font-bold text-zinc-900 dark:text-white">TechCorp Douala</flux:text>
                                <flux:text size="xs" class="text-zinc-500">recruteur1@test.cm</flux:text>
                            </div>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="blue" size="sm">Recruteur</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>Douala</flux:table.cell>
                    <flux:table.cell class="text-zinc-500">01/01/2026</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="emerald" variant="pill" size="sm">Actif</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                            <flux:menu>
                                <flux:menu.item icon="pencil">Modifier</flux:menu.item>
                                <flux:menu.item icon="briefcase">Voir les offres</flux:menu.item>
                                <flux:menu.item icon="no-symbol" class="text-rose-500">Suspendre</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>

                {{-- Candidat 1 --}}
                <flux:table.row>
                    <flux:table.cell>
                        <div class="flex items-center gap-3">
                            <flux:avatar initials="JE" class="bg-emerald-500 text-white" />
                            <div class="flex flex-col">
                                <flux:text class="font-bold text-zinc-900 dark:text-white">Jean Ekotto</flux:text>
                                <flux:text size="xs" class="text-zinc-500">candidat1@test.cm</flux:text>
                            </div>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="emerald" size="sm">Candidat</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>Douala</flux:table.cell>
                    <flux:table.cell class="text-zinc-500">12/02/2026</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="emerald" variant="pill" size="sm">Actif</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                            <flux:menu>
                                <flux:menu.item icon="pencil">Modifier</flux:menu.item>
                                <flux:menu.item icon="user-circle">Voir le profil</flux:menu.item>
                                <flux:menu.item icon="no-symbol" class="text-rose-500">Suspendre</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>

                {{-- Utilisateur Suspendu --}}
                <flux:table.row>
                    <flux:table.cell>
                        <div class="flex items-center gap-3 opacity-50">
                            <flux:avatar initials="FA" class="bg-zinc-500 text-white" />
                            <div class="flex flex-col">
                                <flux:text class="font-bold text-zinc-900 dark:text-white">FakeAgency</flux:text>
                                <flux:text size="xs" class="text-zinc-500">spam@fake.cm</flux:text>
                            </div>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="blue" size="sm">Recruteur</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>Yaoundé</flux:table.cell>
                    <flux:table.cell class="text-zinc-500">15/05/2026</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="rose" variant="pill" size="sm">Suspendu</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                            <flux:menu>
                                <flux:menu.item icon="arrow-path">Lever la suspension</flux:menu.item>
                                <flux:menu.item icon="trash" class="text-rose-500">Supprimer</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
