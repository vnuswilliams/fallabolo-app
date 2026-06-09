<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Testimonial;
use App\Enums\TestimonialStatusEnum;
use Flux\Flux;

new #[Title('Gestion des Avis')] class extends Component {
    public function testimonials()
    {
        return Testimonial::with('user')->latest()->get();
    }

    public function updateStatus($id, $status)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['status' => $status]);

        Flux::toast(
            variant: 'success',
            heading: 'Statut mis à jour',
            text: "L'avis est désormais " . TestimonialStatusEnum::from($status)->label(),
        );
    }

    public function delete($id)
    {
        Testimonial::findOrFail($id)->delete();

        Flux::toast(
            variant: 'success',
            heading: 'Avis supprimé',
            text: "L'avis a été retiré de la plateforme.",
        );
    }
}; ?>

<div class="space-y-8">
    <div>
        <flux:heading size="xl" level="1">Témoignages & Avis</flux:heading>
        <flux:subheading>Gérez les avis laissés par les recruteurs et les candidats.</flux:subheading>
    </div>

    <flux:card class="p-0 overflow-hidden">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Utilisateur</flux:table.column>
                <flux:table.column>Note</flux:table.column>
                <flux:table.column>Message</flux:table.column>
                <flux:table.column>Date</flux:table.column>
                <flux:table.column>Statut</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->testimonials() as $testimonial)
                    <flux:table.row :key="$testimonial->id">
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <flux:avatar :name="$testimonial->user->name" size="sm" />
                                <div class="flex flex-col">
                                    <flux:text class="font-bold">{{ $testimonial->user->name }}</flux:text>
                                    <flux:text size="xs">{{ $testimonial->user->role->label() }}</flux:text>
                                </div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <flux:icon.star class="size-3 {{ $i <= $testimonial->rating ? 'text-amber-400 fill-amber-400' : 'text-zinc-300' }}" />
                                @endfor
                            </div>
                        </flux:table.cell>
                        <flux:table.cell class="max-w-xs truncate">
                            {{ $testimonial->content }}
                        </flux:table.cell>
                        <flux:table.cell class="text-zinc-500">
                            {{ $testimonial->created_at->format('d/m/Y') }}
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :color="$testimonial->status->color()" variant="pill" size="sm">
                                {{ $testimonial->status->label() }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                                <flux:menu>
                                    @if($testimonial->status !== TestimonialStatusEnum::APPROVED)
                                        <flux:menu.item icon="check" wire:click="updateStatus({{ $testimonial->id }}, 'approved')">Approuver</flux:menu.item>
                                    @endif
                                    @if($testimonial->status !== TestimonialStatusEnum::REJECTED)
                                        <flux:menu.item icon="x-mark" wire:click="updateStatus({{ $testimonial->id }}, 'rejected')">Rejeter</flux:menu.item>
                                    @endif
                                    @if($testimonial->status !== TestimonialStatusEnum::PENDING)
                                        <flux:menu.item icon="clock" wire:click="updateStatus({{ $testimonial->id }}, 'pending')">Mettre en attente</flux:menu.item>
                                    @endif
                                    <flux:menu.separator />
                                    <flux:menu.item icon="trash" variant="danger" wire:click="delete({{ $testimonial->id }})">Supprimer</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6" class="text-center py-8 text-zinc-500">
                            Aucun avis pour le moment.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
