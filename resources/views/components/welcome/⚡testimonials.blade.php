<?php
use Livewire\Component;

new class extends Component {
    public array $testimonials = [
        [
            'initials' => 'MK',
            'name'     => 'Marie Kamga',
            'role'     => 'Responsable RH',
            'company'  => 'TechCom Cameroun',
            'color'    => 'emerald',
            'stars'    => 5,
            'badge'    => 'Recruteur',
            'quote'    => 'En 3 ans de recrutement je n\'avais jamais reçu des candidatures aussi qualifiées dès le premier jour. Le classement automatique m\'a fait économiser deux jours de travail sur notre dernière campagne.',
        ],
        [
            'initials' => 'JN',
            'name'     => 'Jean-Paul Nkoa',
            'role'     => 'Développeur Full Stack',
            'company'  => 'Indépendant, Yaoundé',
            'color'    => 'indigo',
            'stars'    => 5,
            'badge'    => 'Candidat',
            'quote'    => 'Voir mon score avant de postuler a tout changé. Je cible uniquement les offres où je dépasse 80 %. J\'ai décroché mon poste actuel en 12 jours.',
        ],
        [
            'initials' => 'SB',
            'name'     => 'Sophie Bello',
            'role'     => 'DG',
            'company'  => 'Agence Digit+ Douala',
            'color'    => 'amber',
            'stars'    => 5,
            'badge'    => 'Recruteur',
            'quote'    => 'On avait l\'habitude de recevoir 150 CVs par poste. Avec MatchRH on en reçoit 25, toutes pertinentes. Les critères bloquants font le filtre à notre place.',
        ],
        [
            'initials' => 'AM',
            'name'     => 'Alain Mfoumou',
            'role'     => 'Comptable Senior',
            'company'  => 'Bafoussam',
            'color'    => 'sky',
            'stars'    => 5,
            'badge'    => 'Candidat',
            'quote'    => 'Sans CV obligatoire, j\'ai pu me concentrer sur ce que je sais vraiment faire. Mon profil reflète mes vraies compétences — le recruteur m\'a rappelé en 48 h.',
        ],
        [
            'initials' => 'FE',
            'name'     => 'Fatima Essomba',
            'role'     => 'Head of Talent',
            'company'  => 'FinServ Africa',
            'color'    => 'rose',
            'stars'    => 5,
            'badge'    => 'Recruteur',
            'quote'    => 'L\'algorithme est transparent — chaque score est décomposé, explicable. Nos équipes l\'ont adopté sans résistance parce qu\'elles comprennent la logique. Pas de boîte noire.',
        ],
        [
            'initials' => 'PN',
            'name'     => 'Patrick Nguema',
            'role'     => 'Ingénieur Réseaux',
            'company'  => 'Douala',
            'color'    => 'teal',
            'stars'    => 5,
            'badge'    => 'Candidat',
            'quote'    => 'J\'ai passé des mois à adapter mon CV sans résultats. Sur MatchRH j\'ai rempli mon profil une fois et les offres viennent à moi. Le système de recommandations est vraiment efficace.',
        ],
    ];

    public array $palette = [
        'emerald' => [
            'avatar_dark'  => 'bg-emerald-500/15 text-emerald-300 border-emerald-500/25',
            'avatar_light' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'badge_dark'   => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
            'badge_light'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'stars'        => 'text-emerald-400',
        ],
        'indigo'  => [
            'avatar_dark'  => 'bg-indigo-500/15 text-indigo-300 border-indigo-500/25',
            'avatar_light' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            'badge_dark'   => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
            'badge_light'  => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            'stars'        => 'text-indigo-400',
        ],
        'amber'   => [
            'avatar_dark'  => 'bg-amber-500/15 text-amber-300 border-amber-500/25',
            'avatar_light' => 'bg-amber-50 text-amber-700 border-amber-200',
            'badge_dark'   => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
            'badge_light'  => 'bg-amber-50 text-amber-700 border-amber-200',
            'stars'        => 'text-amber-400',
        ],
        'sky'     => [
            'avatar_dark'  => 'bg-sky-500/15 text-sky-300 border-sky-500/25',
            'avatar_light' => 'bg-sky-50 text-sky-700 border-sky-200',
            'badge_dark'   => 'bg-sky-500/10 text-sky-400 border-sky-500/20',
            'badge_light'  => 'bg-sky-50 text-sky-700 border-sky-200',
            'stars'        => 'text-sky-400',
        ],
        'rose'    => [
            'avatar_dark'  => 'bg-rose-500/15 text-rose-300 border-rose-500/25',
            'avatar_light' => 'bg-rose-50 text-rose-700 border-rose-200',
            'badge_dark'   => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
            'badge_light'  => 'bg-rose-50 text-rose-700 border-rose-200',
            'stars'        => 'text-rose-400',
        ],
        'teal'    => [
            'avatar_dark'  => 'bg-teal-500/15 text-teal-300 border-teal-500/25',
            'avatar_light' => 'bg-teal-50 text-teal-700 border-teal-200',
            'badge_dark'   => 'bg-teal-500/10 text-teal-400 border-teal-500/20',
            'badge_light'  => 'bg-teal-50 text-teal-700 border-teal-200',
            'stars'        => 'text-teal-400',
        ],
    ];
};
?>

<section id="avis" class="py-24 overflow-hidden transition-colors duration-300"
         :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">

    {{-- ── En-tête (centré, max-w pour lisibilité) ── --}}
    <div class="max-w-5xl mx-auto px-5 mb-12 text-center reveal">
        <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
             :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
            Témoignages
        </div>
        <h2 class="font-display font-bold leading-tight mb-3"
            style="font-size:clamp(1.8rem,4.5vw,3rem)"
            :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
            Ils ont arrêté de trier des CVs.<br>
            <span class="grad-text">Ils recrutent mieux.</span>
        </h2>
        <p class="text-base max-w-md mx-auto"
           :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            Candidats et recruteurs partagent leur expérience MatchRH.
        </p>
    </div>

    {{-- ── Carrousel pleine largeur ── --}}
    <div
        x-data="testimonialCarousel({{ count($testimonials) }})"
        x-init="init()"
        class="relative w-full"
    >
        {{-- Masques de fondu — pleine hauteur, pleine largeur de fenêtre --}}
        <div class="pointer-events-none absolute inset-y-0 left-0 w-20 z-10"
             :style="dark
                 ? 'background:linear-gradient(to right,#09090b 0%,transparent 100%)'
                 : 'background:linear-gradient(to right,#f8fafc 0%,transparent 100%)'">
        </div>
        <div class="pointer-events-none absolute inset-y-0 right-0 w-20 z-10"
             :style="dark
                 ? 'background:linear-gradient(to left,#09090b 0%,transparent 100%)'
                 : 'background:linear-gradient(to left,#f8fafc 0%,transparent 100%)'">
        </div>

        {{-- Piste de défilement — déborde volontairement hors du viewport --}}
        <div
            id="testimonial-track"
            class="flex gap-5 pb-2"
            style="will-change:transform; touch-action:pan-y;"
            @mouseenter="pause()"
            @mouseleave="play()"
            @touchstart.passive="onTouchStart($event)"
            @touchmove.passive="onTouchMove($event)"
            @touchend="onTouchEnd($event)"
        >
            {{-- Les cards réelles --}}
            @foreach ($testimonials as $t)
                @php $c = $palette[$t['color']]; @endphp
                <div class="testimonial-card flex-shrink-0 w-[300px] sm:w-[340px] rounded-2xl border p-6 flex flex-col gap-4 transition-colors duration-200 cursor-default"
                     :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200'">

                    {{-- Avatar + nom + badge --}}
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="grid size-10 shrink-0 place-items-center rounded-xl border font-bold text-sm font-display"
                                 :class="dark ? '{{ $c['avatar_dark'] }}' : '{{ $c['avatar_light'] }}'">
                                {{ $t['initials'] }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-display font-bold text-sm leading-tight truncate"
                                   :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
                                    {{ $t['name'] }}
                                </p>
                                <p class="text-xs mt-0.5 truncate"
                                   :class="dark ? 'text-zinc-500' : 'text-zinc-400'">
                                    {{ $t['role'] }} · {{ $t['company'] }}
                                </p>
                            </div>
                        </div>
                        <span class="shrink-0 px-2.5 py-1 rounded-lg border text-xs font-semibold"
                              :class="dark ? '{{ $c['badge_dark'] }}' : '{{ $c['badge_light'] }}'">
                            {{ $t['badge'] }}
                        </span>
                    </div>

                    {{-- Étoiles --}}
                    <div class="flex gap-0.5 {{ $c['stars'] }}">
                        @for ($s = 0; $s < $t['stars']; $s++)
                            <flux:icon.star class="size-4" />
                        @endfor
                    </div>

                    {{-- Citation --}}
                    <blockquote class="text-sm leading-relaxed flex-1"
                                :class="dark ? 'text-zinc-300' : 'text-zinc-600'">
                        "{{ $t['quote'] }}"
                    </blockquote>
                </div>
            @endforeach
            {{-- Les clones Before/After sont injectés dynamiquement par le JS --}}
        </div>

        {{-- ── Contrôles : dots + flèches + play/pause ── --}}
        <div class="max-w-5xl mx-auto px-5 mt-7 flex items-center justify-between gap-4">

            {{-- Dots (un par card réelle) --}}
            <div class="flex items-center gap-2">
                @foreach ($testimonials as $i => $t)
                    <button
                        @click="goTo({{ $i }})"
                        :class="current === {{ $i }}
                            ? (dark ? 'bg-emerald-400 w-5' : 'bg-emerald-500 w-5')
                            : (dark ? 'bg-zinc-700 w-2 hover:bg-zinc-500' : 'bg-zinc-300 w-2 hover:bg-zinc-400')"
                        class="h-2 rounded-full transition-all duration-300 focus-visible:outline-none"
                        :aria-label="'Aller au témoignage ' + ({{ $i }} + 1)"
                        :aria-current="current === {{ $i }} ? 'true' : 'false'"
                    ></button>
                @endforeach
            </div>

            {{-- Flèches + Play/Pause --}}
            <div class="flex items-center gap-2">

                <button
                    @click="prev()"
                    class="grid size-9 place-items-center rounded-xl border transition-all"
                    :class="dark
                        ? 'border-zinc-800 bg-zinc-900 text-zinc-400 hover:border-zinc-600 hover:text-zinc-100'
                        : 'border-zinc-200 bg-white text-zinc-500 hover:border-zinc-400 hover:text-zinc-800'"
                    aria-label="Témoignage précédent"
                >
                    <flux:icon.arrow-left class="size-4" />
                </button>

                <button
                    @click="togglePlay()"
                    class="grid size-9 place-items-center rounded-xl border transition-all"
                    :class="dark
                        ? 'border-zinc-800 bg-zinc-900 text-zinc-400 hover:border-zinc-600 hover:text-zinc-100'
                        : 'border-zinc-200 bg-white text-zinc-500 hover:border-zinc-400 hover:text-zinc-800'"
                    :aria-label="playing ? 'Mettre en pause' : 'Reprendre le défilement'"
                >
                    <template x-if="playing">
                        <flux:icon.pause class="size-4" />
                    </template>
                    <template x-if="!playing">
                        <flux:icon.play class="size-4" />
                    </template>
                </button>

                <button
                    @click="next()"
                    class="grid size-9 place-items-center rounded-xl border transition-all"
                    :class="dark
                        ? 'border-zinc-800 bg-zinc-900 text-zinc-400 hover:border-zinc-600 hover:text-zinc-100'
                        : 'border-zinc-200 bg-white text-zinc-500 hover:border-zinc-400 hover:text-zinc-800'"
                    aria-label="Témoignage suivant"
                >
                    <flux:icon.arrow-right class="size-4" />
                </button>

            </div>
        </div>
    </div>

</section>
