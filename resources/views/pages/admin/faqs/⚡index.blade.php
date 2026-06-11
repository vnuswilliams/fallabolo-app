<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Faq;
use App\Enums\ReportStatusEnum;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;

new #[Title('Gestion de la FAQ')] class extends Component {
    public $editingFaqId = null;
    public $email = '';
    public $question = '';
    public $answer = '';

    public function faqs()
    {
        return Faq::latest()->get();
    }

    public function create()
    {
        $this->editingFaqId = null;
        $this->email = Auth::user()->email;
        $this->question = '';
        $this->answer = '';

        $this->dispatch('modal-show', name: 'edit-faq-modal');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $this->editingFaqId = $id;
        $this->email = $faq->email;
        $this->question = $faq->question;
        $this->answer = $faq->answer ?? '';

        $this->dispatch('modal-show', name: 'edit-faq-modal');
    }

    public function save()
    {
        $isEditing = (bool) $this->editingFaqId;

        $data = [
            'email' => $this->email,
            'question' => $this->question,
            'answer' => $this->answer,
            'status' => $this->answer ? ReportStatusEnum::CONFIRMED : ReportStatusEnum::PENDING,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ];

        if ($isEditing) {
            Faq::findOrFail($this->editingFaqId)->update($data);
        } else {
            Faq::create($data);
        }

        $this->editingFaqId = null;
        $this->dispatch('modal-close', name: 'edit-faq-modal');

        Flux::toast(
            variant: 'success',
            heading: $isEditing ? 'FAQ mise à jour' : 'Question ajoutée',
            text: "L'opération a été effectuée avec succès.",
        );
    }

    public function runSeeder()
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'FaqSeeder']);
            Flux::toast(variant: 'success', text: "La base de données a été seedée avec succès.");
        } catch (\Exception $e) {
            Flux::toast(variant: 'danger', text: "Erreur lors du seeding : " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        Faq::findOrFail($id)->delete();

        Flux::toast(
            variant: 'success',
            heading: 'Question supprimée',
            text: "La question a été retirée de la base de données.",
        );
    }

    public function updateStatus($id, $status)
    {
        Faq::findOrFail($id)->update(['status' => $status]);

        Flux::toast(
            variant: 'success',
            heading: 'Statut mis à jour',
            text: "Le statut de la question a été modifié.",
        );
    }
}; ?>

<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl" level="1">Gestion de la FAQ</flux:heading>
            <flux:subheading>Répondez aux questions posées et gérez le contenu de la FAQ.</flux:subheading>
        </div>

        <div class="flex gap-2">
            <flux:button icon="beaker" variant="ghost" wire:click="runSeeder" wire:confirm="Voulez-vous vraiment ajouter les données de test ?">
                Seeder la base
            </flux:button>
            <flux:button icon="plus" variant="primary" wire:click="create">
                Ajouter une question
            </flux:button>
        </div>
    </div>

    <flux:card class="p-0 overflow-hidden">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Email / Utilisateur</flux:table.column>
                <flux:table.column>Question</flux:table.column>
                <flux:table.column>Réponse</flux:table.column>
                <flux:table.column>Statut</flux:table.column>
                <flux:table.column>Date</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->faqs() as $faq)
                    <flux:table.row :key="$faq->id">
                        <flux:table.cell>
                            <div class="flex flex-col">
                                <flux:text class="font-bold">{{ $faq->email }}</flux:text>
                                @if($faq->user_id)
                                    <flux:text size="xs">Utilisateur ID: {{ $faq->user_id }}</flux:text>
                                @endif
                            </div>
                        </flux:table.cell>
                        <flux:table.cell class="max-w-xs truncate">
                            {{ $faq->question }}
                        </flux:table.cell>
                        <flux:table.cell class="max-w-xs truncate">
                            {{ $faq->answer ?? '---' }}
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :color="$faq->status === \App\Enums\ReportStatusEnum::CONFIRMED ? 'emerald' : ($faq->status === \App\Enums\ReportStatusEnum::PENDING ? 'amber' : 'zinc')" variant="pill" size="sm">
                                {{ \App\Enums\ReportStatusEnum::from($faq->status)->label() }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell class="text-zinc-500">
                            {{ $faq->created_at->format('d/m/Y H:i') }}
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                                <flux:menu>
                                    <flux:menu.item icon="pencil-square" wire:click="edit({{ $faq->id }})">Répondre / Modifier</flux:menu.item>
                                    @if($faq->status !== \App\Enums\ReportStatusEnum::CONFIRMED)
                                        <flux:menu.item icon="check" wire:click="updateStatus({{ $faq->id }}, 'confirmed')">Confirmer (Sans réponse)</flux:menu.item>
                                    @endif
                                    <flux:menu.separator />
                                    <flux:menu.item icon="trash" variant="danger" wire:click="delete({{ $faq->id }})">Supprimer</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6" class="text-center py-8 text-zinc-500">
                            Aucune question posée pour le moment.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal name="edit-faq-modal" class="min-w-[600px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $editingFaqId ? 'Traiter la question' : 'Nouvelle question' }}</flux:heading>
                <flux:text>Vous pouvez reformuler la question originale si nécessaire et apporter une réponse enrichie.</flux:text>
            </div>

            <form wire:submit="save" class="space-y-4">
                <flux:field>
                    <flux:label>Email de contact</flux:label>
                    <flux:input wire:model="email" type="email" />
                </flux:field>

                <flux:field>
                    <flux:label>Question</flux:label>
                    <flux:textarea wire:model="question" />
                </flux:field>

                <flux:field>
                    <flux:label>Réponse</flux:label>
                    <flux:textarea wire:model="answer" rows="5" />
                </flux:field>

                <div class="flex gap-3 justify-end">
                    <flux:modal.close>
                        <flux:button variant="ghost">Annuler</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Enregistrer</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
