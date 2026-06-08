<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Toutes les Offres')] class extends Component {
    // Hardcoded data for UI scaffolding
}; ?>

<div class="flex flex-col gap-8">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl" level="1">Offres d'emploi</flux:heading>
            <flux:subheading>Supervision de toutes les opportunités publiées sur la plateforme.</flux:subheading>
        </div>
    </div>

    <flux:card class="p-4 flex flex-wrap gap-4 items-center border-zinc-200 dark:border-zinc-800">
        <flux:select placeholder="Entreprise" class="w-48">
            <flux:select.option value="all">Toutes les entreprises</flux:select.option>
            <flux:select.option value="1">TechCorp</flux:select.option>
            <flux:select.option value="2">FinGroup</flux:select.option>
        </flux:select>
        <flux:select placeholder="Ville" class="w-48">
            <flux:select.option value="Douala">Douala</flux:select.option>
            <flux:select.option value="Yaoundé">Yaoundé</flux:select.option>
        </flux:select>
        <flux:select placeholder="Statut" class="w-48">
            <flux:select.option value="published">Publiées</flux:select.option>
            <flux:select.option value="closed">Clôturées</flux:select.option>
            <flux:select.option value="draft">Brouillons</flux:select.option>
        </flux:select>
        <flux:input placeholder="Titre du poste..." icon="magnifying-glass" class="flex-1" />
    </flux:card>

    <flux:card class="p-0 overflow-hidden border-zinc-200 dark:border-zinc-800">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Poste & Entreprise</flux:table.column>
                <flux:table.column>Localisation</flux:table.column>
                <flux:table.column>Candidats</flux:table.column>
                <flux:table.column>Date de pub.</flux:table.column>
                <flux:table.column>Statut</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                {{-- Offre 1 --}}
                <flux:table.row>
                    <flux:table.cell>
                        <div class="flex flex-col">
                            <flux:text class="font-bold text-zinc-900 dark:text-white">Développeur Laravel Senior</flux:text>
                            <flux:text size="xs" class="text-zinc-500">TechCorp Douala</flux:text>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>Douala, Littoral</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge variant="pill" size="sm">12</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell class="text-zinc-500">02/06/2026</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="emerald" variant="pill" size="sm">Publiée</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                            <flux:menu>
                                <flux:menu.item icon="eye">Voir l'offre</flux:menu.item>
                                <flux:menu.item icon="pencil">Modifier</flux:menu.item>
                                <flux:menu.item icon="archive">Clôturer</flux:menu.item>
                                <flux:menu.separator />
                                <flux:menu.item icon="trash" class="text-rose-500">Supprimer</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>

                {{-- Offre 2 --}}
                <flux:table.row>
                    <flux:table.cell>
                        <div class="flex flex-col">
                            <flux:text class="font-bold text-zinc-900 dark:text-white">Comptable Senior</flux:text>
                            <flux:text size="xs" class="text-zinc-500">FinGroup Yaoundé</flux:text>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>Yaoundé, Centre</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge variant="pill" size="sm">5</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell class="text-zinc-500">28/05/2026</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="emerald" variant="pill" size="sm">Publiée</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                            <flux:menu>
                                <flux:menu.item icon="eye">Voir l'offre</flux:menu.item>
                                <flux:menu.item icon="pencil">Modifier</flux:menu.item>
                                <flux:menu.item icon="archive">Clôturer</flux:menu.item>
                                <flux:menu.separator />
                                <flux:menu.item icon="trash" class="text-rose-500">Supprimer</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
