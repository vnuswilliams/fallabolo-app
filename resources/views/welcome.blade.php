<!DOCTYPE html>
<html lang="fr" x-data="{ dark: localStorage.getItem('theme') !== 'light', mobileOpen: false }" :class="dark ? 'dark' : ''" class="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MatchRH Recrutement Intelligent</title>
<meta name="description" content="MatchRH est la plateforme de recrutement intelligente qui utilise un scoring algorithmique transparent pour connecter les talents et les entreprises sans tri manuel de CV au Cameroun.">
<meta name="keywords" content="recrutement, RH, matching, algorithme, emploi, Cameroun, sans CV, scoring, recrutement intelligent">
<meta property="og:title" content="MatchRH - Recrutement Intelligent sans CV">
<meta property="og:description" content="Connectez-vous aux meilleurs talents grâce au matching algorithmique transparent.">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="MatchRH - Recrutement Intelligent sans CV">
<meta name="twitter:description" content="La plateforme qui met fin au tri manuel des CV.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

  @fluxAppearance

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

</head>

<body class="antialiased overflow-x-hidden transition-colors duration-300"
      :class="dark ? 'bg-zinc-950 text-zinc-100' : 'bg-slate-50 text-zinc-900'"
      x-init="
        $nextTick(() => {
          const obs = new IntersectionObserver(entries => {
            entries.forEach(e => {
              if (e.isIntersecting) {
                e.target.classList.add('on');
                if (e.target.classList.contains('bar-fill')) e.target.style.width = e.target.style.getPropertyValue('--w') || e.target.getAttribute('data-w') + '%';
              }
            });
          }, { threshold:.1, rootMargin:'0px 0px -40px 0px' });
          document.querySelectorAll('.reveal,.reveal-l,.reveal-r,.bar-fill').forEach(el => obs.observe(el));
        })
      ">
<div
    x-data="{ scrolled: false, menuOpen: false }"
    x-on:scroll.window="scrolled = window.scrollY > 60"
>

    {{-- ── Overlay sombre derrière le menu mobile ── --}}
    <div
        x-show="menuOpen"
        x-transition:enter="transition duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:click="menuOpen = false"
        class="fixed inset-0 z-40 bg-black/20 backdrop-blur-sm md:hidden"
        aria-hidden="true"
    ></div>

    {{-- ── Menu mobile plein écran (slide from top) ── --}}
    <div
        x-show="menuOpen"
        x-transition:enter="transition duration-350 ease-out"
        x-transition:enter-start="-translate-y-full opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition duration-250 ease-in"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="-translate-y-full opacity-0"
        class="fixed inset-x-0 top-0 z-50 flex min-h-screen flex-col bg-white dark:bg-zinc-950 md:hidden"
    >
        {{-- Header interne du menu --}}
        <div class="flex items-center justify-between border-b border-slate-200/80 px-5 py-4 dark:border-zinc-800 " >
            <a href="#top" x-on:click="menuOpen = false" class="flex items-center gap-2.5">
                <span class="grid size-9 place-items-center rounded-lg text-white dark:bg-zinc-50 dark:text-zinc-950">
                    sqa
                </span>
                <span class="text-lg font-black text-slate-950 dark:text-zinc-400">fallabolo</span>
            </a>
            <button
                x-on:click="menuOpen = false"
                class="grid size-9 place-items-center rounded-lg border border-slate-200 bg-slate-50 text-slate-700 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400"
                aria-label="Fermer le menu"
            >
                <flux:icon.x-mark class="size-5" />
            </button>
        </div>

        {{-- Liens de navigation --}}
        <nav class="flex flex-1 flex-col px-5 py-8" aria-label="Navigation mobile">
            <ul class="space-y-1">

                @foreach ([
                    ['label' => 'Problème',   'href' => '#probleme', 'icon' => 'bug-ant'],
                    ['label' => 'Solution',     'href' => '#solution',   'icon' => 'face-smile'],
                    ['label' => 'Fonctionnalités',       'href' => '#fonctionnalites',     'icon' => 'star'],
                    ['label' => 'MCP',        'href' => '#mcp',      'icon' => 'sparkles'],
                    ['label' => 'Tarifs',       'href' => '#tarifs', 'icon' => 'credit-card'],
                ] as $link)
                    <li>
                        <a
                            href="{{ $link['href'] }}"
                            x-on:click="
                                menuOpen = false;
                                $nextTick(() => {
                                    const el = document.querySelector('{{ $link['href'] }}');
                                    if (el) el.scrollIntoView({ behavior: 'smooth' });
                                })
                            "
                            class="group flex items-center gap-4 rounded-xl px-4 py-4 text-lg font-bold text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 dark:text-zinc-400 dark:hover:bg-zinc-900 dark:hover:text-zinc-50"
                        >
                            <span class="grid size-9 place-items-center rounded-lg bg-slate-100 text-slate-500 transition group-hover:bg-slate-200 group-hover:text-slate-950 dark:bg-zinc-900 dark:text-zinc-400 dark:group-hover:bg-zinc-800 dark:group-hover:text-zinc-50">
                                <flux:icon :name="$link['icon']" class="size-5" />
                            </span>
                            {{ $link['label'] }}
                            <flux:icon.arrow-right class="ml-auto size-4 text-slate-300 transition group-hover:translate-x-1 group-hover:text-slate-500 dark:text-zinc-600" />
                        </a>
                    </li>
                @endforeach
            </ul>

            {{-- Séparateur --}}
            <div class="my-6 border-t border-slate-200 dark:border-zinc-800"></div>

            {{-- CTA principal --}}
            <a
                href="#contact"
                x-on:click="
                    menuOpen = false;
                    $nextTick(() => {
                        const el = document.querySelector('#contact');
                        if (el) el.scrollIntoView({ behavior: 'smooth' });
                    })
                "
                class="flex items-center justify-center gap-2 rounded-xl bg-slate-950 px-6 py-4 text-base font-black text-white transition hover:bg-slate-800 dark:bg-zinc-50 dark:text-zinc-950 dark:hover:bg-zinc-200"
            >

                Demander une démo gratuite
            </a>

            <p class="mt-4 text-center text-sm text-slate-400">
                ✓ Sans engagement &nbsp;·&nbsp; ✓ Réponse sous 24h
            </p>
        </nav>

        {{-- Pied du menu --}}
        <div class="border-t border-slate-200 px-5 py-5 dark:border-zinc-800">
            <p class="text-center text-sm text-slate-400">payongvenus@icloud.com</p>
        </div>
    </div>

    {{-- ── Header principal ── --}}
    <header
        class="fixed top-0 left-0 right-0 z-40 flex justify-center"
        :class="scrolled ? 'pt-3' : 'pt-0'"
    >
        <nav
            aria-label="Navigation principale"
            class="transition-all duration-300 ease-in-out w-full "
            :class="scrolled
                ? 'mx-4 max-w-5xl rounded-full  shadow-[0_8px_32px_-4px_rgba(0,0,0,0.12),0_0_0_1px_rgba(0,0,0,0.04)] backdrop-blur-md   dark:shadow-[0_8px_32px_-4px_rgba(16,185,129,0.2),0_0_24px_0_rgba(16,185,129,0.15)] px-4 py-2'
                : 'backdrop-blur px-5 py-4 lg:px-8'"
        >
            <div
                class="flex items-center justify-between transition-all duration-300"
                :class="scrolled ? 'gap-2' : 'gap-4 mx-auto max-w-7xl'"
            >

                {{-- Logo --}}
                <a href="#top" class="flex items-center gap-2.5 shrink-0">
                    <span
                        class="grid place-items-center rounded-lg bg-slate-950 text-white dark:bg-zinc-50 dark:text-zinc-950 transition-all duration-300"
                        :class="scrolled ? 'size-7' : 'size-9'"
                    >
                        sq
                    </span>
                    <span                        class="font-black tracking-normal text-slate-950 dark:text-zinc-400 transition-all duration-300"                        :class="scrolled ? 'text-base ' : 'text-lg'"                    >fallabolo</span>
                </a>

                {{-- Liens desktop --}}
                <div
                    class="hidden items-center text-slate-600 dark:text-zinc-400 md:flex transition-all duration-300"
                    :class="scrolled ? 'gap-5 text-sm font-medium' : 'gap-7 text-sm font-semibold'"
                >

                <a href="#valeur"          :class="dark ? ' text-zinc-300 hover:text-emerald-400' : 'text-zinc-600 hover:text-emerald-600'">Proposition de valeur</a>
                <a href="#probleme"        :class="dark ? ' text-zinc-300 hover:text-emerald-400' : 'text-zinc-600 hover:text-emerald-600'">Problème</a>
                <a href="#solution"        :class="dark ? ' text-zinc-300 hover:text-emerald-400' : 'text-zinc-600 hover:text-emerald-600'">Solution</a>
                <a href="#fonctionnalites" :class="dark ? ' text-zinc-300 hover:text-emerald-400' : 'text-zinc-600 hover:text-emerald-600'">Fonctionnalités</a>
                <a href="#mcp"             :class="dark ? ' text-zinc-300 hover:text-emerald-400' : 'text-zinc-600 hover:text-emerald-600'">MCP</a>
                <a href="#tarifs"          :class="dark ? ' text-zinc-300 hover:text-emerald-400' : 'text-zinc-600 hover:text-emerald-600'">Tarifs</a>
               <button @click="dark=!dark; localStorage.setItem('theme', dark ? 'dark' : 'light')"
                        class="w-9 h-9 flex items-center justify-center rounded-xl text-sm transition-all cursor-pointer"
                        :class="dark ? 'hover:border-emerald-500/50 hover:text-emerald-400 hover:bg-emerald-500/10' : ' hover:border-emerald-500/50 hover:text-emerald-600 hover:bg-emerald-50'">
                     <flux:icon.moon x-show="dark" class="size-5" />
                     <flux:icon.sun x-show="!dark" class="size-5" />
                </button>
                </div>

                {{-- CTA desktop + burger mobile --}}
                <div class="flex items-center gap-3 shrink-0">

                    {{-- CTA desktop uniquement --}}
                    <a
                        href="#contact"
                        class="hidden md:inline-flex items-center gap-2 font-semibold text-white bg-slate-950 transition-all duration-300 hover:bg-slate-800 dark:bg-zinc-50 dark:text-zinc-950 dark:hover:bg-zinc-200"
                        :class="scrolled ? 'text-sm px-4 py-1.5 rounded-full' : 'text-sm px-4 py-2 rounded-lg'"
                    >
                        Demander une démo
                    </a>

                    {{-- Burger mobile uniquement --}}
                    <flux:button
                        x-on:click="menuOpen = true"
                        class="grid size-9 place-items-center rounded-lg border border-slate-200 bg-white text-slate-700 transition hover:bg-slate-50 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400 md:hidden"
                        aria-label="Ouvrir le menu"
                    >
                        <flux:icon.bars-3 class="size-5" />
                    </flux:accentbutton>

                </div>
            </div>
        </nav>
    </header>

</div>

{{-- Spacer fixed header --}}
<div class="h-16.25"></div>



<!-- ===== HERO ===== -->
<section class="relative pt-32 pb-24 px-5 text-center overflow-hidden">
  <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[700px] h-[500px] pointer-events-none"
       style="background:radial-gradient(ellipse,rgba(52,211,153,.13) 0%,transparent 70%)"></div>
  <div class="absolute inset-0 hero-grid pointer-events-none"></div>
  <div class="relative max-w-5xl mx-auto">

    <div class="reveal inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-sm font-medium mb-6"
         :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
      <span class="px-2 py-0.5 rounded-full text-xs font-bold font-display bg-emerald-400 text-zinc-900">NOUVEAU</span>
      Matching algorithmique  · transparent · sans CV obligatoire
    </div>

    <h1 class="reveal d1 font-display font-extrabold leading-[1.06] tracking-tight mb-5" style="font-size:clamp(2.4rem,7vw,4.8rem)">
      Le bon profil.<br>
      <span class="grad-text">La bonne offre. Enfin.</span>
    </h1>

    <p class="reveal d2 text-lg font-light max-w-xl mx-auto mb-5 leading-relaxed"
       :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
      Vous recrutez sans vous noyer dans les CVs.<br>
     Vous postulez sans disparaître dans le silence.
    </p>

    <p class="reveal d2 text-sm max-w-lg mx-auto mb-10 leading-relaxed italic"
       :class="dark ? 'text-zinc-600' : 'text-zinc-500'">
      MatchRH juge vos compétences réelles pas la mise en page de votre PDF, pas votre patience face à 200 dossiers.
    </p>

    <div class="reveal d3 flex flex-wrap gap-3 justify-center mb-16">
        <flux:button icon:trailing="chevron-right" href="#valeur" class="px-7 py-3.5 rounded-xl font-medium border transition-all hover:-translate-y-0.5"
                x-bind:class="dark ? 'border-zinc-700 text-zinc-300 hover:border-zinc-500 hover:bg-zinc-800/50' : 'border-zinc-200 text-zinc-600 hover:border-zinc-400 hover:bg-zinc-50'">
          En savoir plus
        </flux:button>
      <flux:button href="{{ route('register') }}" variant="primary" color="emerald" class="px-7 py-3.5 rounded-xl font-display font-bold text-zinc-900 bg-emerald-400 hover:bg-emerald-500 transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/25">
        Créer un compte gratuit
      </flux:button>
    </div>

    <!-- Stats -->
    <div class="reveal d4 grid grid-cols-2 sm:grid-cols-4 gap-4 pt-10 border-t"
         :class="dark ? 'border-zinc-800' : 'border-zinc-200'">
      <div class="text-center">
        <div class="font-display font-extrabold text-3xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">−87%</div>
        <div class="text-sm mt-1" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Temps de tri pour le recruteur</div>
      </div>
      <div class="text-center">
        <div class="font-display font-extrabold text-3xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Score visible</div>
        <div class="text-sm mt-1" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Avant même de postuler</div>
      </div>
      <div class="text-center">
        <div class="font-display font-extrabold text-3xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">0 CV, 0 LM</div>
        <div class="text-sm mt-1" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Requis pour le candidat</div>
      </div>
      <div class="text-center">
        <div class="font-display font-extrabold text-3xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">100%</div>
        <div class="text-sm mt-1" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Transparent chaque score expliqué</div>
      </div>
    </div>
  </div>
</section>


<!-- ===== PROPOSITION DE VALEUR ===== -->
<section id="valeur" class="py-24 px-5 border-y transition-colors duration-300"
         :class="dark ? 'bg-zinc-900/50 border-zinc-800' : 'bg-white border-zinc-200'">
  <div class="max-w-5xl mx-auto">

    <div class="reveal text-center mb-14">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        La vérité que personne ne dit
      </div>
      <h2 class="font-display font-bold leading-tight mb-4" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Deux réalités.<br>
        <span class="grad-text">Un problème commun.</span>
      </h2>
      <p class="text-base max-w-lg mx-auto" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
        Le recrutement classique fait perdre du temps aux deux parties. MatchRH rend le jeu équitable.
      </p>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-10">
      <!-- Candidat -->
      <div class="reveal-l rounded-2xl border p-8 relative overflow-hidden"
           :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-zinc-50 border-zinc-200'">
        <div class="absolute top-4 right-4 text-xs font-bold px-3 py-1 rounded-full border"
             :class="dark ? 'bg-emerald-500/15 text-emerald-400 border-emerald-500/20' : 'bg-emerald-50 text-emerald-600 border-emerald-200'">
          Candidat
        </div>
        <h3 class="font-display font-bold text-lg mb-4" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Ce que vous vivez en cherchant un emploi</h3>
        <ul class="space-y-3">
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-red-400 shrink-0">✗</span>
            Vous postulez et n'avez jamais de retour même pour un refus
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-red-400 shrink-0">✗</span>
            Vous êtes éliminé sans savoir pourquoi ni sur quels critères
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-red-400 shrink-0">✗</span>
            Vous passez des heures sur un CV que personne ne lit en entier
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-red-400 shrink-0">✗</span>
            Vous ne savez jamais si vous êtes vraiment qualifié pour une offre
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-red-400 shrink-0">✗</span>
            Vous adaptez votre mise en page plutôt que de mettre en avant vos compétences
          </li>
        </ul>
      </div>

      <!-- Recruteur -->
      <div class="reveal-r rounded-2xl border p-8 relative overflow-hidden"
           :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-zinc-50 border-zinc-200'">
        <div class="absolute top-4 right-4 text-xs font-bold px-3 py-1 rounded-full border"
             :class="dark ? 'bg-indigo-500/15 text-indigo-400 border-indigo-500/20' : 'bg-indigo-50 text-indigo-600 border-indigo-200'">
          Recruteur
        </div>
        <h3 class="font-display font-bold text-lg mb-4" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Ce que vous vivez en recrutant</h3>
        <ul class="space-y-3">
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-amber-400 shrink-0">!</span>
            Vous recevez 200+ candidatures en 48h pour un seul poste
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-amber-400 shrink-0">!</span>
            Vous scannez chaque CV en 6 secondes titre, entreprise, c'est tout
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-amber-400 shrink-0">!</span>
            Vous ignorez les lettres de motivation dans 90% des cas
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-amber-400 shrink-0">!</span>
            Vous éliminez en masse par manque de temps, sans critères clairs
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-amber-400 shrink-0">!</span>
            Les données de chaque candidat sont dans des PDFs impossibles à comparer
          </li>
        </ul>
      </div>
    </div>

    <!-- Conclusion MatchRH -->
    <div class="reveal rounded-2xl border p-8 md:p-12 text-center relative overflow-hidden"
         :class="dark ? 'bg-emerald-950/40 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
      <div class="absolute inset-0 pointer-events-none"
           style="background:radial-gradient(ellipse 60% 80% at 50% 100%,rgba(52,211,153,.07),transparent)"></div>
      <div class="relative">
        <div class="text-xl text-center mb-4">
        <flux:icon.scale class="size-10  mx-auto"/>

        </div>
        <h3 class="font-display font-bold text-2xl mb-3" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
          MatchRH rend le jeu équitable
        </h3>
        <p class="text-base max-w-lg mx-auto mb-6" :class="dark ? 'text-zinc-400' : 'text-zinc-600'">
          Vos compétences réelles sont évaluées sur des critères objectifs pas sur la beauté d'un PDF. Vous recevez uniquement des profils qui correspondent pas des candidatures espoir.
        </p>
        <div class="flex flex-wrap gap-3 justify-center">
          <span class="px-4 py-2 rounded-lg text-sm font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-100 border-emerald-300 text-emerald-700'">Compétences notées </span>
          <span class="px-4 py-2 rounded-lg text-sm font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-100 border-emerald-300 text-emerald-700'">Score visible avant candidature</span>
          <span class="px-4 py-2 rounded-lg text-sm font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-100 border-emerald-300 text-emerald-700'">Critères bloquants transparents</span>
          <span class="px-4 py-2 rounded-lg text-sm font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-100 border-emerald-300 text-emerald-700'">Zéro biais de présentation</span>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===== PROBLÈMES ===== -->
<section id="probleme" class="py-24 px-5 transition-colors duration-300"
         :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">
  <div class="max-w-5xl mx-auto">
    <div class="reveal mb-12">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Problème
      </div>
      <h2 class="font-display font-bold leading-tight mb-3" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Le recrutement classique est cassé <span class="grad-text">des deux côtés</span>
      </h2>
      <p class="text-base max-w-md" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
        Même frustration, deux perspectives. MatchRH y met fin simultanément.
      </p>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
      <!-- Côté Recruteur -->
      <div class="reveal-l space-y-4">
        <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest"
             :class="dark ? 'bg-indigo-500/10 border-indigo-500/20 text-indigo-400' : 'bg-indigo-50 border-indigo-200 text-indigo-700'">
          Pour le recruteur
        </div>
        <div class="space-y-4">
          <div class="flex gap-2 items-center p-4 rounded-2xl border transition-colors" :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-700' : 'bg-white border-zinc-200 hover:border-zinc-300'">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-4 border" :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
              <flux:icon.envelope class="size-6 text-red-500" />
            </div>
            <div>
                            <h3 class="font-display font-bold text-lg mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Candidatures massives non pertinentes</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Chaque offre attire des dizaines de profils inadaptés, noyant les bons candidats dans la masse.</p>
            </div>
          </div>
          <div class="flex gap-2 items-center p-4  rounded-2xl border transition-colors" :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-700' : 'bg-white border-zinc-200 hover:border-zinc-300'">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-4 border" :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
              <flux:icon.clock class="size-6 text-red-500" />
            </div>
            <div>

              <h3 class="font-display font-bold text-lg mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Tri manuel chronophage</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">6 secondes par CV en moyenne. La qualité de décision est sacrifiée pour la vitesse.</p>
            </div>
          </div>
          <div class="flex gap-2 items-center p-4 rounded-2xl border transition-colors" :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-700' : 'bg-white border-zinc-200 hover:border-zinc-300'">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-4 border" :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
              <flux:icon.folder-open class="size-6 text-red-500" />
            </div>
            <div>

              <h3 class="font-display font-bold text-lg mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Données non comparables</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Compétences diversifiées dans des PDFs impossible de comparer objectivement les profils.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Côté Candidat -->
      <div class="reveal-r space-y-4">
        <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest"
             :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
          Pour le candidat
        </div>
        <div class="space-y-4">
          <div class="flex gap-2 items-center p-4  rounded-2xl border transition-colors" :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-700' : 'bg-white border-zinc-200 hover:border-zinc-300'">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-4 border" :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
              <flux:icon.megaphone class="size-6 text-red-500" />
            </div>
            <div>

              <h3 class="font-display font-bold text-lg mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Postuler dans le vide</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Des dizaines de candidatures envoyées, aucun retour même pas un refus. Le silence est la norme.</p>
            </div>
          </div>
          <div class="flex gap-2 items-center p-4  rounded-2xl border transition-colors" :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-700' : 'bg-white border-zinc-200 hover:border-zinc-300'">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-4 border" :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
              <flux:icon.question-mark-circle class="size-6 text-red-500" />
            </div>
            <div>

              <h3 class="font-display font-bold text-lg mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Être éliminé sans explication</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Vous ne savez jamais pourquoi vous n'avez pas été retenu. Impossible de progresser sans feedback.</p>
            </div>
          </div>
          <div class="flex gap-2 items-center p-4  rounded-2xl border transition-colors" :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-700' : 'bg-white border-zinc-200 hover:border-zinc-300'">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-4 border" :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
              <flux:icon.user-group class="size-6 text-red-500" />
            </div>
            <div>

              <h3 class="font-display font-bold text-lg mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Être jugé sur la forme, pas le fond</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Le meilleur CV designer gagne. Pas le meilleur profil. Vos vraies compétences restent invisibles.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===== SOLUTION / PROCESSUS ===== -->
<section id="solution" class="py-24 px-5 border-y transition-colors duration-300"
         :class="dark ? 'bg-zinc-900/40 border-zinc-800' : 'bg-white border-zinc-200'">
  <div class="max-w-5xl mx-auto">

    <div class="reveal text-center mb-10">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Notre solution
      </div>
      <h2 class="font-display font-bold leading-tight mb-4" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Matching en 4 étapes,<br><span class="grad-text">score transparent</span>
      </h2>
      <p class="text-lg max-w-lg mx-auto" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
        Un algorithme déterministe. Pas de boîte noire chaque score est expliqué, visible et compréhensible par tous.
      </p>
    </div>

    <!-- Steps -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 rounded-2xl overflow-hidden border mb-16"
         :class="dark ? 'border-zinc-800 bg-zinc-800' : 'border-zinc-200 bg-zinc-200'" style="gap:1px">
      <div class="p-6 reveal d1 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800' : 'bg-white hover:bg-zinc-50'">
        <div class="font-display font-extrabold text-4xl mb-4 grad-text leading-none">01</div>
        <h3 class="font-display font-bold text-base mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Critères bloquants</h3>
        <p class="text-sm leading-relaxed mb-4" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Éliminatoires. Si un critère obligatoire n'est pas rempli, le score tombe à 0 automatiquement.</p>
        <div class="space-y-2 pt-4 border-t border-zinc-800">
          <p class="text-xs leading-tight"><strong :class="dark ? 'text-zinc-300' : 'text-zinc-700'">Recruteur :</strong> <span :class="dark ? 'text-zinc-500' : 'text-zinc-400'">vous définissez vos non-négociables une seule fois</span></p>
          <p class="text-xs leading-tight"><strong :class="dark ? 'text-zinc-300' : 'text-zinc-700'">Candidat :</strong> <span :class="dark ? 'text-zinc-500' : 'text-zinc-400'">vous savez immédiatement si vous êtes éligible</span></p>
        </div>
      </div>
      <div class="p-6 reveal d2 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800' : 'bg-white hover:bg-zinc-50'">
        <div class="font-display font-extrabold text-4xl mb-4 grad-text leading-none">02</div>
        <h3 class="font-display font-bold text-base mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Score principal pondéré</h3>
        <p class="text-sm leading-relaxed mb-4" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">6 dimensions clés combinées en un score sur 100 selon le niveau du poste.</p>
        <div class="space-y-2 pt-4 border-t border-zinc-800">
          <p class="text-xs leading-tight"><strong :class="dark ? 'text-zinc-300' : 'text-zinc-700'">Recruteur :</strong> <span :class="dark ? 'text-zinc-500' : 'text-zinc-400'">un classement objectif, non manipulable</span></p>
          <p class="text-xs leading-tight"><strong :class="dark ? 'text-zinc-300' : 'text-zinc-700'">Candidat :</strong> <span :class="dark ? 'text-zinc-500' : 'text-zinc-400'">votre vrai niveau enfin reconnu et mesuré</span></p>
        </div>
      </div>
      <div class="p-6 reveal d3 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800' : 'bg-white hover:bg-zinc-50'">
        <div class="font-display font-extrabold text-4xl mb-4 grad-text leading-none">03</div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Atouts détectés</h3>
        <p class="text-sm leading-relaxed mb-4" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Certifications, expériences sectorielles, langues supplémentaires valorisés séparément.</p>
        <div class="space-y-2 pt-4 border-t border-zinc-800">
          <p class="text-xs leading-tight"><strong :class="dark ? 'text-zinc-300' : 'text-zinc-700'">Recruteur :</strong> <span :class="dark ? 'text-zinc-500' : 'text-zinc-400'">départagez facilement les profils à score égal</span></p>
          <p class="text-xs leading-tight"><strong :class="dark ? 'text-zinc-300' : 'text-zinc-700'">Candidat :</strong> <span :class="dark ? 'text-zinc-500' : 'text-zinc-400'">vos atouts sont visibles, pas enfouis dans un PDF</span></p>
        </div>
      </div>
      <div class="p-6 reveal d4 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800' : 'bg-white hover:bg-zinc-50'">
        <div class="font-display font-extrabold text-4xl mb-4 grad-text leading-none">04</div>
        <h3 class="font-display font-bold text-base mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Score final en %</h3>
        <p class="text-sm leading-relaxed mb-4" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Un chiffre clair, visible avant même de postuler. Tout le monde joue cartes sur table.</p>
        <div class="space-y-2 pt-4 border-t border-zinc-800">
          <p class="text-xs leading-tight"><strong :class="dark ? 'text-zinc-300' : 'text-zinc-700'">Recruteur :</strong> <span :class="dark ? 'text-zinc-500' : 'text-zinc-400'">votre pipeline arrive déjà trié du meilleur au moins bon</span></p>
          <p class="text-xs leading-tight"><strong :class="dark ? 'text-zinc-300' : 'text-zinc-700'">Candidat :</strong> <span :class="dark ? 'text-zinc-500' : 'text-zinc-400'">vous postulez uniquement là où vous avez une vraie chance</span></p>
        </div>
      </div>
    </div>

    <!-- Weights + Score preview -->
    <div class="grid md:grid-cols-2 gap-8">

      <!-- Barres de pondération -->
      <div class="reveal-l self-center">
        <p class="text-xs font-bold font-display uppercase tracking-widest mb-5"
           :class="dark ? 'text-emerald-400' : 'text-emerald-700'">Pondérations fixes & transparentes</p>
        <div class="space-y-4">
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Compétences</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" data-w="50" style="--w:50%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">50%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Expérience</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" data-w="20" style="--w:20%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">20%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Formation</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" data-w="10" style="--w:10%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">10%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Langues</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" data-w="10" style="--w:10%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">10%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Disponibilité</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" data-w="5" style="--w:5%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">5%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Localisation</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" data-w="5" style="--w:5%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">5%</div>
          </div>
        </div>
        <p class="mt-4 text-[10px]" :class="dark ? 'text-zinc-600' : 'text-zinc-500'">* Les pondérations varient selon le template de poste choisi (Manœuvre → Cadre dirigeant).</p>
      </div>

      <!-- Score preview -->
      <div class="reveal-r rounded-2xl border p-6" :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-zinc-50 border-zinc-200'">
        <div class="flex items-center justify-between mb-5">
          <h4 class="font-display font-bold text-xs" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Vue candidat Compatibilité estimée</h4>
          <span class="font-display font-extrabold text-4xl grad-text">84%</span>
        </div>
        <div class="space-y-3 mb-5">
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Compétences</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Excellent</span>
          </div>
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Expérience</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Compatible</span>
          </div>
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Langues</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Compatible</span>
          </div>
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Disponibilité</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Immédiate</span>
          </div>
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Localisation</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Compatible</span>
          </div>
        </div>
        <div class="pt-4 border-t" :class="dark ? 'border-zinc-800' : 'border-zinc-200'">
          <p class="text-[10px] mb-2" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Atouts détectés sur votre profil</p>
          <div class="flex flex-wrap gap-2">
            <span class="px-3 py-1 rounded-lg text-[10px] font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">✓ Expérience BTP</span>
            <span class="px-3 py-1 rounded-lg text-[10px] font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">✓ Certification Sage Paie</span>
          </div>
        </div>
        <p class="mt-4 text-[10px] italic" :class="dark ? 'text-zinc-600' : 'text-zinc-500'">Pour la première fois, vous savez exactement où vous en êtes.</p>
      </div>
    </div>
  </div>
</section>


<!-- ===== FONCTIONNALITÉS ===== -->
<section id="fonctionnalites" class="py-24 px-5 transition-colors duration-300"
         :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">
  <div class="max-w-5xl mx-auto">

    <div class="reveal text-center mb-14">
      <div class="inline-block px-3 py-1 rounded-full border text-sm font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Fonctionnalités
      </div>
      <h2 class="font-display font-bold leading-tight" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Tout ce dont vous avez besoin,<br>rien de superflu
      </h2>
    </div>

    <div class="feat-grid grid sm:grid-cols-2 gap-8">

      <!-- Colonne Recruteur -->
      <div class="reveal-l space-y-6">
        <div class="flex items-center gap-3 pb-4 border-b border-zinc-800">
          <div class="w-10 h-10 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-sm">
            <flux:icon.building-office class="size-5 text-indigo-400" />
          </div>
          <span class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest"
               :class="dark ? 'bg-indigo-500/10 border-indigo-500/20 text-indigo-400' : 'bg-indigo-50 border-indigo-200 text-indigo-700'">
            Je recrute
          </span>
        </div>

        <div class="space-y-4">
          <div class="flex gap-4 p-5 rounded-xl border border-transparent  transition-colors">
            <flux:icon.no-symbol class="size-6 text-zinc-400 shrink-0" />
            <div>
              <h3 class="font-display font-bold text-base mb-1" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Critères bloquants configurables</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Définissez vos exigences non-négociables. Tout profil non-conforme est filtré automatiquement.</p>
            </div>
          </div>
          <div class="flex gap-4 p-5 rounded-xl border border-transparent  transition-colors">
            <flux:icon.chart-bar class="size-6 text-zinc-400 shrink-0" />
            <div>
              <h3 class="font-display font-bold text-base mb-1" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Classement automatique</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Les candidats arrivent déjà classés du plus compatible au moins compatible. Zéro tri manuel.</p>
            </div>
          </div>
          <div class="flex gap-4 p-5 rounded-xl border border-transparent  transition-colors">
            <flux:icon.bell class="size-6 text-zinc-400 shrink-0" />
            <div>
              <h3 class="font-display font-bold text-base mb-1" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Alertes & résumés périodiques</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Notifié à chaque candidature qualifiée. Résumé quotidien avec top profils et score moyen.</p>
            </div>
          </div>
          <div class="flex gap-4 p-5 rounded-xl border border-transparent  transition-colors">
            <flux:icon.star class="size-6 text-zinc-400 shrink-0" />
            <div>
              <h3 class="font-display font-bold text-base mb-1" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Système de bonus flexible</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Valorisez les atouts différenciants certifications, secteur, langues rares comme signal de départage.</p>
            </div>
          </div>
        </div>
      </div>

          <!-- Colonne Candidat -->
      <div class="reveal-l space-y-6">
        <div class="flex items-center gap-3 pb-4 border-b border-zinc-800">
          <div class="w-10 h-10 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-sm">
            <flux:icon.users class="size-5 text-indigo-400" />
          </div>
          <span class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest"
               :class="dark ? 'bg-indigo-500/10 border-indigo-500/20 text-indigo-400' : 'bg-indigo-50 border-indigo-200 text-indigo-700'">
               Je cherche un emploi
          </span>
        </div>

        <div class="space-y-4">
        <div class="flex gap-4 p-4 rounded-xl border border-transparent  transition-colors">
           <flux:icon.eye class="size-6 text-zinc-400 shrink-0" />
            <div>
              <h3 class="font-display font-bold text-base mb-1" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Score visible avant de postuler</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Voyez votre compatibilité avec chaque offre avant d'envoyer quoi que ce soit. Postulez en connaissance de cause.</p>
            </div>
          </div>
          <div class="flex gap-4 p-4 rounded-xl border border-transparent  transition-colors">
             <flux:icon.document class="size-6 text-zinc-400 shrink-0" />
            <div>
              <h3 class="font-display font-bold text-base mb-1" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Profil structuré, sans CV obligatoire</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Renseignez vos compétences une seule fois. Votre profil parle pour vous, mieux qu'un PDF.</p>
            </div>
          </div>
          <div class="flex gap-4 p-4 rounded-xl border border-transparent  transition-colors">
            <flux:icon.arrows-pointing-in class="size-6 text-zinc-400 shrink-0" />
            <div>
              <h3 class="font-display font-bold text-base mb-1" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Offres recommandées selon votre profil</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Le système suggère les offres où vous avez les meilleures chances pas les plus visibles.</p>
            </div>
          </div>
          <div class="flex gap-4 p-4 rounded-xl border border-transparent  transition-colors">
            <flux:icon.light-bulb class="size-6 text-zinc-400 shrink-0" />
            <div>
              <h3 class="font-display font-bold text-base mb-1" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Comprendre pourquoi vous n'êtes pas retenu</h3>
              <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Le détail de chaque score vous indique exactement ce qui vous a pénalisé. Progressez à chaque postulation.</p>
            </div>
          </div>
        </div>
      </div>
          
    </div>
</section>


<!-- ===== MCP INTEGRATION ===== -->
<section id="mcp" class="py-24 px-5 border-y transition-colors duration-300"
         :class="dark ? 'bg-zinc-900/40 border-zinc-800' : 'bg-white border-zinc-200'">
  <div class="max-w-5xl mx-auto">
    <div class="reveal rounded-2xl overflow-hidden relative"
         :class="dark ? 'border-emerald-500/20' : 'border-emerald-300/60'">
      <div class="absolute inset-0 mcp-shimmer pointer-events-none"></div>
      <div class="relative p-8 md:p-12">
        <div class="flex flex-col lg:flex-row gap-10 items-start">

          <!-- Texte -->
          <div class="flex-1 self-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-5"
                 :class="dark ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400' : 'bg-emerald-50 border-emerald-300 text-emerald-700'">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse-slow"></span>
              Prochainement · MCP Integration
            </div>
            <h2 class="font-display font-bold leading-tight mb-4" style="font-size:clamp(1.5rem,3.5vw,2.25rem)"
                :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
              MatchRH dans votre<br>
              <span class="grad-text">IA préférée</span>
            </h2>
            <p class="text-base leading-relaxed mb-6" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
              Bientôt, recruteurs et candidats pourront interagir avec MatchRH directement depuis leurs outils IA (Claude, ChatGPT, Cursor, Copilot…) via le protocole <strong :class="dark ? 'text-zinc-200 font-semibold' : 'text-zinc-700 font-semibold'">MCP (Model Context Protocol)</strong>. Publiez des offres, consultez vos scores et recevez des recommandations sans quitter votre environnement de travail.
            </p>

            <div class="grid sm:grid-cols-2 gap-3 mb-8">
              <div class="flex items-start gap-3 p-4 rounded-xl border"
                   :class="dark ? 'bg-zinc-900/80 border-zinc-800' : 'bg-white border-zinc-200'">
                <flux:icon.building-office class="size-5 mt-1 text-emerald-400 shrink-0" />
                <div>
                  <p class="text-sm font-bold" :class="dark ? 'text-zinc-200' : 'text-zinc-800'">Pour le recruteur</p>
                  <p class="text-xs mt-0.5" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">"Trouve les 3 meilleurs profils comptables disponibles à Douala sous 30 jours"</p>
                </div>
              </div>
              <div class="flex items-start gap-3 p-4 rounded-xl border"
                   :class="dark ? 'bg-zinc-900/80 border-zinc-800' : 'bg-white border-zinc-200'">
                <flux:icon.user class="size-5 mt-1 text-emerald-400 shrink-0" />
                <div>
                  <p class="text-sm font-bold" :class="dark ? 'text-zinc-200' : 'text-zinc-800'">Pour le candidat</p>
                  <p class="text-xs mt-0.5" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">"Quelles offres correspondent à mon profil en ce moment à Yaoundé ?"</p>
                </div>
              </div>
              <div class="flex items-start gap-3 p-4 rounded-xl border"
                   :class="dark ? 'bg-zinc-900/80 border-zinc-800' : 'bg-white border-zinc-200'">
                <flux:icon.pencil-square class="size-5 mt-1 text-emerald-400 shrink-0" />
                <div>
                  <p class="text-sm font-bold" :class="dark ? 'text-zinc-200' : 'text-zinc-800'">Création d'offres via l'IA</p>
                  <p class="text-xs mt-0.5" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Publiez une offre structurée en décrivant simplement le poste à votre assistant IA</p>
                </div>
              </div>
              <div class="flex items-start gap-3 p-4 rounded-xl border"
                   :class="dark ? 'bg-zinc-900/80 border-zinc-800' : 'bg-white border-zinc-200'">
                   <flux:icon.chart-bar-square class="size-5 mt-1 text-emerald-400 shrink-0" />
                <div>
                  <p class="text-sm font-bold" :class="dark ? 'text-zinc-200' : 'text-zinc-800'">Scores & recommandations</p>
                  <p class="text-xs mt-0.5" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Classements et analyses disponibles directement depuis votre outil habituel</p>
                </div>
              </div>
            </div>

            <div class="flex flex-wrap gap-3 items-center">
              <button class="px-5 py-2.5 rounded-xl font-display font-bold text-sm bg-emerald-400 text-zinc-900 hover:bg-emerald-500 transition-all">
                M'avertir à la sortie
              </button>
              <a href="#" class="text-sm underline underline-offset-4 decoration-dashed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
                En savoir plus sur MCP  <flux:icon.chevron-right class="size-4 inline-block ml-1"/>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===== UTILISATEURS ===== -->
<section id="utilisateurs" class="py-24 px-5 transition-colors duration-300"
         :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">
  <div class="max-w-5xl mx-auto">

    <div class="reveal text-center mb-14">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Utilisateurs
      </div>
      <h2 class="font-display font-bold leading-tight" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Deux profils, une même plateforme
      </h2>
    </div>

    <div class="grid md:grid-cols-2 gap-5 mb-8">
      <!-- Recruteur -->
      <div class="reveal-l rounded-2xl border overflow-hidden" :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200'">
        <div class="flex items-center gap-3 p-5 border-b" :class="dark ? 'border-zinc-800' : 'border-zinc-100'">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl border" :class="dark ? 'bg-indigo-500/10 border-indigo-500/20' : 'bg-indigo-50 border-indigo-200'">        <flux:icon.building-office class="size-8"/></div>
          <div>
            <p class="font-display font-bold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Recruteur</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Entreprises & DRH</p>
          </div>
        </div>
        <div class="p-5 space-y-3">
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Publie des offres structurées avec critères bloquants & bonus</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Reçoit uniquement des candidatures qualifiées, classées automatiquement</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Définit les critères éliminatoires (permis, expérience minimum…)</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Accède au résumé structuré de chaque candidat avec son score</span></div>
          <div class="flex flex-wrap gap-2 pt-2">
            <span class="px-3 py-1 rounded-lg text-xs font-medium border" :class="dark ? 'bg-zinc-800 border-zinc-700 text-zinc-300' : 'bg-zinc-100 border-zinc-200 text-zinc-600'">Classement auto</span>
            <span class="px-3 py-1 rounded-lg text-xs font-medium border" :class="dark ? 'bg-zinc-800 border-zinc-700 text-zinc-300' : 'bg-zinc-100 border-zinc-200 text-zinc-600'">Critères bloquants</span>
            <span class="px-3 py-1 rounded-lg text-xs font-medium border" :class="dark ? 'bg-zinc-800 border-zinc-700 text-zinc-300' : 'bg-zinc-100 border-zinc-200 text-zinc-600'">Points bonus</span>
            <span class="px-3 py-1 rounded-lg text-xs font-medium border" :class="dark ? 'bg-zinc-800 border-zinc-700 text-zinc-300' : 'bg-zinc-100 border-zinc-200 text-zinc-600'">Notifs temps réel</span>
          </div>
        </div>
      </div>

      <!-- Candidat -->
      <div class="reveal-r rounded-2xl border overflow-hidden" :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200'">
        <div class="flex items-center gap-3 p-5 border-b" :class="dark ? 'border-zinc-800' : 'border-zinc-100'">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">        <flux:icon.users class="size-8"/></div>
          <div>
            <p class="font-display font-bold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Candidat</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Chercheurs d'emploi</p>
          </div>
        </div>
        <div class="p-5 space-y-3">
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Crée un profil structuré sans CV obligatoire rempli une seule fois</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Voit son score de compatibilité avant même de postuler</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Comprend exactement pourquoi il est éliminé ou retenu</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Reçoit des recommandations d'offres adaptées à son profil réel</span></div>
          <div class="space-y-2 pt-2">
            <div class="flex items-center gap-3 text-xs">
              <span class="w-20 shrink-0" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Comptabilité</span>
              <span class="text-emerald-400">★★★★★</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
              <span class="w-20 shrink-0" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Excel avancé</span>
              <span class="text-emerald-400">★★★★</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
              <span class="w-20 shrink-0" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Sage Paie</span>
              <span class="text-emerald-400">★★★</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Classement table -->
    <div class="reveal rounded-2xl border overflow-hidden" :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200'">
      <div class="flex items-center justify-between p-5 border-b" :class="dark ? 'border-zinc-800' : 'border-zinc-100'">
        <h4 class="font-display font-bold text-sm" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Classement automatique · Responsable Comptable Douala</h4>
        <span class="px-3 py-1 rounded-lg text-xs font-bold border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">Classement auto ✓</span>
      </div>
      <!-- Ligne 1 -->
      <div class="flex items-center justify-between p-4 border-b transition-colors" :class="dark ? 'border-zinc-800 hover:bg-zinc-800/50' : 'border-zinc-100 hover:bg-zinc-50'">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 border" style="background:rgba(99,102,241,.12);border-color:rgba(99,102,241,.3);color:#818cf8">SK</div>
          <div>
            <p class="text-sm font-semibold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Sylvie Kamga</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Comptable Senior · 7 ans · Douala</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="hidden sm:block w-20 h-1.5 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-100'">
            <div class="h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" style="width:94%"></div>
          </div>
          <span class="font-display font-bold text-sm" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">94%</span>
        </div>
      </div>
      <!-- Ligne 2 -->
      <div class="flex items-center justify-between p-4 border-b transition-colors" :class="dark ? 'border-zinc-800 hover:bg-zinc-800/50' : 'border-zinc-100 hover:bg-zinc-50'">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 border" style="background:rgba(34,197,94,.1);border-color:rgba(34,197,94,.25);color:#4ade80">PM</div>
          <div>
            <p class="text-sm font-semibold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Patrick Mbarga</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Chef Comptable · 5 ans · Yaoundé</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="hidden sm:block w-20 h-1.5 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-100'">
            <div class="h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" style="width:88%"></div>
          </div>
          <span class="font-display font-bold text-sm" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">88%</span>
        </div>
      </div>
      <!-- Ligne 3 -->
      <div class="flex items-center justify-between p-4 border-b transition-colors" :class="dark ? 'border-zinc-800 hover:bg-zinc-800/50' : 'border-zinc-100 hover:bg-zinc-50'">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 border" style="background:rgba(251,191,36,.1);border-color:rgba(251,191,36,.25);color:#fbbf24">AN</div>
          <div>
            <p class="text-sm font-semibold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Arlette Nguema</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Contrôleur de gestion · 4 ans · Douala</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="hidden sm:block w-20 h-1.5 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-100'">
            <div class="h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" style="width:83%"></div>
          </div>
          <span class="font-display font-bold text-sm" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">83%</span>
        </div>
      </div>
      <!-- Ligne 4 -->
      <div class="flex items-center justify-between p-4 transition-colors" :class="dark ? 'hover:bg-zinc-800/50' : 'hover:bg-zinc-50'">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 border" style="background:rgba(239,68,68,.1);border-color:rgba(239,68,68,.2);color:#f87171">JF</div>
          <div>
            <p class="text-sm font-semibold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Jean Fomba</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Assistant Comptable · 2 ans · Bafoussam</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="hidden sm:block w-20 h-1.5 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-100'">
            <div class="h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" style="width:76%"></div>
          </div>
          <span class="font-display font-bold text-sm" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">76%</span>
        </div>
      </div>
    </div>
    </div>
  </div>
</section>


<!-- ===== TARIFS ===== -->
<section id="tarifs" class="py-24 px-5 border-y transition-colors duration-300"
         :class="dark ? 'bg-zinc-900/40 border-zinc-800' : 'bg-white border-zinc-200'">
  <div class="max-w-5xl mx-auto">

    <div class="reveal text-center mb-6">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Tarifs
      </div>
      <h2 class="font-display font-bold leading-tight mb-3" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        100% Gratuit.<br>
        <span class="grad-text">Et c'est notre force.</span>
      </h2>
      <p class="text-base max-w-lg mx-auto" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
         La gratuité totale est notre avantage concurrentiel elle nous permet d'atteindre la masse critique des deux côtés plus vite que n'importe quel concurrent.
      </p>
    </div>
    <!-- Plans -->
    <div class="grid sm:grid-cols-2 gap-5 mt-10">

      <!-- Candidat -->
      <div class="price-card reveal d1 rounded-2xl border overflow-hidden flex flex-col"
           :class="dark ? 'border-zinc-800 bg-zinc-900' : 'border-zinc-200 bg-white'">
        <div class="p-6 flex flex-col flex-1">
          <p class="font-display font-bold text-sm mb-1" :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Candidat</p>
          <div class="flex items-baseline gap-1 mb-1">
            <span class="font-display font-extrabold text-4xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Gratuit</span>
          </div>
          <p class="text-xs mb-6" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Pour tous les chercheurs d'emploi</p>
          <div class="space-y-3 flex-1 mb-6">
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Profil structuré complet</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Score de compatibilité visible</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Candidatures illimitées</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Recommandations d'offres</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Notifications en temps réel</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">CV optionnel </span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Pas de LM </span></div>
         <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400 text-xs">🔜</span><span :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Intégration MCP (à venir)</span></div>
          </div>
          <flux:button  href="{{ route('register') }}" class="w-full py-3 rounded-xl font-display font-bold text-sm border transition-all"
                  x-bind:class="dark ? 'border-zinc-700 text-zinc-300 hover:border-zinc-500 hover:bg-zinc-800' : 'border-zinc-200 text-zinc-600 hover:border-zinc-400 hover:bg-zinc-50'">
            Créer mon profil
          </flux:button>
        </div>
      </div>

      <!-- Recruteur PMEshrink-0Featured -->
      <div class="price-card reveal d2 rounded-2xl border overflow-hidden flex flex-col"
           :class="dark ? 'border-emerald-500/40 bg-emerald-950/40' : 'border-emerald-300 bg-emerald-50/60'">
        <div class="p-6 flex flex-col flex-1">
          <p class="font-display font-bold text-sm mb-1" :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Recruteur PME</p>
          <div class="flex items-baseline gap-1 mb-1">
            <span class="font-display font-extrabold text-4xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Gratuit</span>
          </div>
          <p class="text-xs mb-6" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">La solution complète sans limite</p>
          <div class="space-y-3 flex-1 mb-6">
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Offres d'emploi illimitées</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Critères bloquants & bonus</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Classement automatique des candidats</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Notifications & résumés périodiques</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Tableau de bord recruteur</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Support prioritaire</span></div>
         <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400 text-xs">🔜</span><span :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Intégration MCP (à venir)</span></div>

        </div>
          <flux:button variant="primary" color="emerald" href="{{ route('register') }}" class="w-full py-3 rounded-xl font-display font-bold text-sm bg-emerald-400 text-zinc-900 hover:bg-emerald-500 transition-all">
            Commencer à recruter
          </flux:button>
        </div>
      </div>

    </div>

    <!-- Trust indicators -->
    <div class="reveal mt-12 flex flex-wrap justify-center gap-x-8 gap-y-4">
      <div class="flex items-center gap-2 text-sm font-bold" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">
        <flux:icon.check-circle class="size-4 text-emerald-400" /> Aucune carte bancaire requise
      </div>
      <div class="flex items-center gap-2 text-sm font-bold" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">
        <flux:icon.check-circle class="size-4 text-emerald-400" /> Aucune limite cachée
      </div>
      <div class="flex items-center gap-2 text-sm font-bold" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">
        <flux:icon.shield-check class="size-4 text-emerald-400" /> Données protégées · Loi camerounaise 2024
      </div>
      <div class="flex items-center gap-2 text-sm font-bold" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">
        <flux:icon.sparkles class="size-4 text-emerald-400" /> Gratuit pour les fonctionnalités de base
      </div>
    </div>
  </div>
</section>
<livewire:welcome.testimonials />

<!-- ===== CONTACT ===== -->
<section id="contact" class="py-24 px-5 transition-colors duration-300"
         :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">
  <div class="max-w-3xl mx-auto">
    <div class="reveal text-center mb-14">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Contactez-nous
      </div>
      <h2 class="font-display font-bold leading-tight mb-4" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Une question ?<br><span class="grad-text">Parlons-en.</span>
      </h2>
      <p class="text-base max-w-md mx-auto" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
        Que vous soyez recruteur ou candidat, notre équipe est là pour vous accompagner.
      </p>
    </div>

    <div class="reveal">
        <livewire:contact-form />
    </div>
  </div>
</section>

   {{-- ═══════════════════════════════════════════════════
                     FAQ Réponses enrichies
                ═══════════════════════════════════════════════════ --}}
<livewire:welcome.faq />

<!-- ===== CTA ===== -->
<section class="py-24 px-5 transition-colors duration-300" :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">
  <div class="max-w-5xl mx-auto">
    <div class="reveal relative rounded-3xl border overflow-hidden p-10 md:p-16 text-center"
         :class="dark ? 'bg-emerald-950/40 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
      <div class="absolute inset-0 pointer-events-none"
           style="background:radial-gradient(ellipse 60% 80% at 50% 100%,rgba(52,211,153,.09),transparent)"></div>
      <div class="relative">
        <h2 class="font-display font-extrabold leading-tight mb-4" style="font-size:clamp(1.8rem,5vw,3.2rem)"
            :class="dark ? 'text-zinc-100' : 'text-zinc-800'">
          Prêt à jouer<br>
          <span class="grad-text">à armes égales ?</span>
        </h2>
        <p class="text-base max-w-md mx-auto mb-8" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
          Recruteurs recevez moins de candidatures, mais toutes pertinentes.<br>
          Candidats postulez uniquement là où vous avez une vraie chance.
        </p>
        <div class="flex flex-wrap gap-3 justify-center">
          <flux:button variant="primary"  icon:trailing="chevron-right" color="emerald" href="{{ route('register') }}" class="px-8 py-3.5 rounded-xl font-display font-bold bg-emerald-400 text-zinc-900 hover:bg-emerald-500 transition-all hover:-translate-y-0.5 hover:shadow-xl hover:shadow-emerald-500/20">
            Je veux recruter mieux
          </flux:button>
          <flux:button icon:trailing="chevron-right" href="{{ route('register') }}" class="px-8 py-3.5 rounded-xl font-medium border transition-all hover:-translate-y-0.5"
                  x-bind:class="dark ? 'border-zinc-700 text-zinc-300 hover:border-zinc-500 hover:bg-zinc-800/50' : 'border-zinc-300 text-zinc-600 hover:border-zinc-400 hover:bg-white'">
            Je cherche un emploi
          </flux:button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== FOOTER ===== -->
 <footer   :class="dark ? 'bg-zinc-900/50 border-zinc-800' : 'bg-white border-zinc-200'">
                <div class="mx-auto max-w-7xl px-5 lg:px-8">

                    {{-- ── Colonnes de liens ── --}}
                    <div class="grid grid-cols-2 gap-8 py-12 sm:grid-cols-2 lg:grid-cols-4">

                        {{-- Produit --}}
                        <div>
                            <p class="text-sm font-black  :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Produit</p>
                            <ul class="mt-4 space-y-3">
                                @foreach ([
                                    ['label' => 'Tarifs',        'href' => '#tarifs'],
                                    ['label' => 'Solution',      'href' => '#solution'],
                                    ['label' => 'Fonctionnalités','href' => '#fonctionnalites'],
                                    ['label' => 'FAQ',           'href' => '#faq'],
                                ] as $link)
                                    <li>
                                        <a href="{{ $link['href'] }}" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">
                                            {{ $link['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>


                        {{-- Légal --}}
                        <div>
                            <p class="text-sm font-black  :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Légal</p>
                            <ul class="mt-4 space-y-3">
                                @foreach ([
                                    ['label' => 'CGU',               'slug' => 'cgu'],
                                    ['label' => 'CGV',               'slug' => 'cgv'],
                                    ['label' => 'Politique de confidentialité','slug' => 'confidentialite'],
                                    ['label' => 'Politique de cookies','slug' => 'cookies'],
                                ] as $link)
                                    <li>
                                        <a href="{{ route('legal.show', $link['slug']) }}" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">
                                            {{ $link['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Contact --}}
                        <div>
                            <p class="text-sm font-black  :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Contact</p>
                            <ul class="mt-4 space-y-3">
                                <li>
                                    <a href="#contact" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">
                                        Demander une démo
                                    </a>
                                </li>
                                <li>
                                    <a href="mailto:payongvenus@icloud.com" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">
                                        payongvenus@icloud.com
                                    </a>
                                </li>
                                <li>
                                    <a href="#newsletter" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">
                                        Newsletter RH
                                    </a>
                                </li>
                            </ul>
                        </div>


                        {{-- Ressources --}}
                        <div>
                            <p class="text-sm font-black  :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Ressources</p>
                            <ul class="mt-4 space-y-3">
                                @foreach ([
                                    ['label' => 'FAQ',            'href' => '#faq'],
                                    ['label' => 'Témoignages',    'href' => '#avis'],
                                ] as $link)
                                    <li>
                                        <a href="{{ $link['href'] }}" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">
                                            {{ $link['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- ── Barre inférieure : logo + copyright + réseaux ── --}}
                    <div class="border-t border-slate-100 py-6 dark:border-zinc-800">

                        {{-- Ligne logo + statut --}}
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                            {{-- Logo --}}
                            <a href="#top" class="flex items-center gap-3">
                                <span class="grid size-8 place-items-center rounded-lg bg-slate-950 text-white dark:bg-zinc-50 dark:text-zinc-950">
                                    sq
                                </span>
                                <span class="text-base font-black  :class="dark ? 'text-zinc-100' : 'text-zinc-900'"" >fallabolo</span>
                            </a>

                            {{-- Statut opérationnel --}}
                            <div class="">
                            <div class="flex items-center gap-2">
                                <span class="size-2 rounded-full bg-emerald-500"></span>
                                <span class="text-sm font-semibold text-slate-500 dark:text-zinc-400">Tous les services sont opérationnels</span>
                            </div>
                            </div>

                        </div>

                        {{-- Ligne copyright + réseaux sociaux --}}
                        <div class="mt-5 flex flex-col gap-4 border-t border-slate-200/70 pt-5 dark:border-zinc-800 sm:flex-row sm:items-center sm:justify-between">

                            <p class="text-sm text-slate-400 dark:text-zinc-500">
                                © {{ date('Y') }} fallabolo. Tous droits réservés. Conçu pour les PME camerounaises.
                            </p>

                            {{-- Icônes réseaux sociaux --}}
                            <div class="flex items-center gap-4">
                                {{-- LinkedIn --}}
                                <a href="https://www.linkedin.com/company/fallabolo" aria-label="fallabolo sur LinkedIn" class="text-slate-400 transition hover:text-slate-950 dark:hover:text-zinc-50">
                                    <svg class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M19 3A2 2 0 0 1 21 5V19A2 2 0 0 1 19 21H5A2 2 0 0 1 3 19V5A2 2 0 0 1 5 3H19M18.5 18.5V13.2A3.26 3.26 0 0 0 15.24 9.94C14.39 9.94 13.4 10.46 12.92 11.24V10.13H10.13V18.5H12.92V13.57A1.46 1.46 0 0 1 14.38 12.11A1.46 1.46 0 0 1 15.84 13.57V18.5H18.5M6.88 8.56A1.68 1.68 0 0 0 8.56 6.88A1.68 1.68 0 0 0 6.88 5.2A1.68 1.68 0 0 0 5.2 6.88A1.68 1.68 0 0 0 6.88 8.56M8.27 18.5V10.13H5.5V18.5H8.27Z"/>
                                    </svg>
                                </a>
                                {{-- X / Twitter--}}
                                <a href="https://youtube.com/@fallabolo?si=1l9db4ZVM2HCUPxT" aria-label="fallabolo sur X" class="text-slate-400 transition hover:text-slate-950 dark:hover:text-zinc-50">
                                <svg class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                                </a>
                                {{-- WhatsApp --}}
                                <a href="https://wa.me/237659005679" aria-label="fallabolo sur WhatsApp" class="text-slate-400 transition hover:text-slate-950 dark:hover:text-zinc-50">
                                    <svg class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </footer>

 @fluxScripts
        @persist('toast')
            <flux:toast.group position="top center">
                <flux:toast />
            </flux:toast.group>
        @endpersist


</body>
</html>

