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
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Crée un profil structuré sans CV obligatoire</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Voit son score de compatibilité avant de postuler</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Répond aux questions de préqualification spécifiques</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Reçoit des recommandations d'offres adaptées à son profil</span></div>
          <div class="space-y-2 pt-2">
            <div class="flex items-center gap-3 text-xs">
              <span class="w-14 shrink-0" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Laravel</span>
              <span class="text-emerald-400">★★★★★</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
              <span class="w-14 shrink-0" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">MySQL</span>
              <span class="text-emerald-400">★★★★</span><span :class="dark ? 'text-zinc-700' : 'text-zinc-200'">★</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
              <span class="w-14 shrink-0" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Git</span>
              <span class="text-emerald-400">★★★</span><span :class="dark ? 'text-zinc-700' : 'text-zinc-200'">★★</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Classement table -->
    <div class="reveal rounded-2xl border overflow-hidden" :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200'">
      <div class="flex items-center justify-between p-5 border-b" :class="dark ? 'border-zinc-800' : 'border-zinc-100'">
        <h4 class="font-display font-bold text-sm" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Classement · Développeur Laravel</h4>
        <span class="px-3 py-1 rounded-lg text-xs font-bold border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">Classement automatique ✓</span>
      </div>
      <!-- Ligne 1 -->
      <div class="flex items-center justify-between p-4 border-b transition-colors" :class="dark ? 'border-zinc-800 hover:bg-zinc-800/50' : 'border-zinc-100 hover:bg-zinc-50'">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 border" style="background:rgba(99,102,241,.15);border-color:rgba(99,102,241,.3);color:#818cf8">JD</div>
          <div>
            <p class="text-sm font-semibold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Jean Dupont</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Dev Full Stack · 5 ans</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="hidden sm:block w-20 h-1.5 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-100'">
            <div class="h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" style="width:92%"></div>
          </div>
          <span class="font-display font-bold text-sm" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">92%</span>
        </div>
      </div>
      <!-- Ligne 2 -->
      <div class="flex items-center justify-between p-4 border-b transition-colors" :class="dark ? 'border-zinc-800 hover:bg-zinc-800/50' : 'border-zinc-100 hover:bg-zinc-50'">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 border" style="background:rgba(34,197,94,.1);border-color:rgba(34,197,94,.25);color:#4ade80">MK</div>
          <div>
            <p class="text-sm font-semibold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Marie Kamga</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Dev Laravel · 4 ans</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="hidden sm:block w-20 h-1.5 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-100'">
            <div class="h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" style="width:89%"></div>
          </div>
          <span class="font-display font-bold text-sm" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">89%</span>
        </div>
      </div>
      <!-- Ligne 3 -->
      <div class="flex items-center justify-between p-4 border-b transition-colors" :class="dark ? 'border-zinc-800 hover:bg-zinc-800/50' : 'border-zinc-100 hover:bg-zinc-50'">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 border" style="background:rgba(251,191,36,.1);border-color:rgba(251,191,36,.25);color:#fbbf24">AB</div>
          <div>
            <p class="text-sm font-semibold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Alain Bello</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Dev Backend · 3 ans</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="hidden sm:block w-20 h-1.5 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-100'">
            <div class="h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" style="width:85%"></div>
          </div>
          <span class="font-display font-bold text-sm" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">85%</span>
        </div>
      </div>
      <!-- Ligne 4 -->
      <div class="flex items-center justify-between p-4 transition-colors" :class="dark ? 'hover:bg-zinc-800/50' : 'hover:bg-zinc-50'">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 border" style="background:rgba(239,68,68,.1);border-color:rgba(239,68,68,.2);color:#f87171">SN</div>
          <div>
            <p class="text-sm font-semibold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Sophie Ngo</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Dev PHP · 2 ans</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="hidden sm:block w-20 h-1.5 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-100'">
            <div class="h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" style="width:78%"></div>
          </div>
          <span class="font-display font-bold text-sm" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">78%</span>
        </div>
      </div>
    </div>
  </div>
</section>
