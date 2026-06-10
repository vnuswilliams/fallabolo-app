<section id="mcp" class="py-24 px-5 border-y transition-colors duration-300"
         :class="dark ? 'bg-zinc-900/40 border-zinc-800' : 'bg-white border-zinc-200'">
  <div class="max-w-5xl mx-auto">
    <div class="reveal rounded-2xl border overflow-hidden relative"
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
                <span class="text-lg shrink-0">
                      <flux:icon.sparkles class="size-8"/>

                </span>
                <div>
                  <p class="text-sm font-semibold" :class="dark ? 'text-zinc-200' : 'text-zinc-800'">Commandes en langage naturel</p>
                  <p class="text-xs mt-0.5" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">"Trouve les 3 meilleurs profils Laravel disponibles sous 30 jours"</p>
                </div>
              </div>
              <div class="flex items-start gap-3 p-4 rounded-xl border"
                   :class="dark ? 'bg-zinc-900/80 border-zinc-800' : 'bg-white border-zinc-200'">
                <span class="text-lg shrink-0">
                      <flux:icon.chart-bar class="size-8"/>

                </span>
                <div>
                  <p class="text-sm font-semibold" :class="dark ? 'text-zinc-200' : 'text-zinc-800'">Scores & recommandations</p>
                  <p class="text-xs mt-0.5" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Classements disponibles directement depuis votre assistant IA</p>
                </div>
              </div>
              <div class="flex items-start gap-3 p-4 rounded-xl border"
                   :class="dark ? 'bg-zinc-900/80 border-zinc-800' : 'bg-white border-zinc-200'">
                <span class="text-lg shrink-0">

                    <flux:icon.document class="size-8"/>

                </span>
                <div>
                  <p class="text-sm font-semibold" :class="dark ? 'text-zinc-200' : 'text-zinc-800'">Création d'offres via l'IA</p>
                  <p class="text-xs mt-0.5" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Publiez une offre structurée en décrivant le poste à votre IA</p>
                </div>
              </div>
              <div class="flex items-start gap-3 p-4 rounded-xl border"
                   :class="dark ? 'bg-zinc-900/80 border-zinc-800' : 'bg-white border-zinc-200'">
                   <span class="text-lg shrink-0">
                       <flux:icon.star class="size-8"/>

                </span>
                <div>
                  <p class="text-sm font-semibold" :class="dark ? 'text-zinc-200' : 'text-zinc-800'">Alertes contextuelles</p>
                  <p class="text-xs mt-0.5" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Notifications dans votre outil habituel, sans changer d'application</p>
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

          <!-- Code block -->
        <div class="shrink-0 flex  self-center">
  <div class="rounded-xl overflow-hidden bg-zinc-900 border border-zinc-800 shadow-2xl font-mono text-xs text-zinc-300">

    <div class="flex items-center gap-2 px-4 py-3 bg-zinc-900/50 border-b border-zinc-800 select-none">
      <div class="flex gap-1.5">
        <span class="w-3 h-3 rounded-full bg-red-500/80 block"></span>
        <span class="w-3 h-3 rounded-full bg-amber-500/80 block"></span>
        <span class="w-3 h-3 rounded-full bg-emerald-500/80 block"></span>
      </div>
      <span class="ml-2 text-zinc-500 text-[11px]">matchrh-mcp.ts</span>
    </div>

    <div class="p-5 overflow-x-auto space-y-1">
      <div class="text-zinc-500">// Connexion MCP MatchRH</div>
      <div><span class="text-emerald-400">import</span> { MatchRH } <span class="text-emerald-400">from</span> <span class="text-amber-300">'matchrh-mcp'</span></div>
      <div class="h-2"></div>
      <div class="text-zinc-500">// Demander les top candidats</div>
      <div><span class="text-emerald-400">const</span> results = <span class="text-emerald-400">await</span> MatchRH.getTopCandidates({</div>
      <div class="pl-4">offreId: <span class="text-amber-300">'dev-laravel-001'</span>,</div>
      <div class="pl-4">limit: <span class="text-blue-400">5</span></div>
      <div>})</div>
      <div class="text-zinc-500">// [{ name: 'Jean', score: 92% },</div>
      <div class="text-zinc-500">//  { name: 'Marie', score: 89% }]</div>
    </div>

  </div>
</div>

        </div>
      </div>
    </div>
  </div>
</section>
