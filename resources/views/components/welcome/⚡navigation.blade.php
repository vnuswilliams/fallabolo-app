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
            <p class="text-center text-sm text-slate-400">contact@fallabolo.com</p>
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
                        class="w-9 h-9 flex items-center justify-center rounded-xl  text-sm transition-all cursor-pointer"
                        :class="dark ? 'hover:border-emerald-500/50 hover:text-emerald-400 hover:bg-emerald-500/10' : ' hover:border-emerald-500/50 hover:text-emerald-600 hover:bg-emerald-50'">
                     <span x-text="dark ? '🌙' : '☀️'"></span>
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
