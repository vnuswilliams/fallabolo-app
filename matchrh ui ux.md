# MatchRH — Spécification UI/UX Complète
### Document de référence pour l'assistant de code
> Stack : Laravel 13 · Livewire 4 · Flux UI · Tailwind CSS · Mobile First
> Juin 2026 — Usage interne

---

## Table des matières

1. [Design System & Tokens](#1-design-system--tokens)
2. [Structure globale & Layouts](#2-structure-globale--layouts)
3. [Composants partagés](#3-composants-partagés)
4. [Parcours Recruteur](#4-parcours-recruteur)
5. [Parcours Candidat](#5-parcours-candidat)
6. [Composant Score — Règle d'or](#6-composant-score--règle-dor)
7. [États & Feedbacks Livewire](#7-états--feedbacks-livewire)
8. [Conventions de nommage Blade/Livewire](#8-conventions-de-nommage-bladelivewire)

---

## 1. Design System & Tokens

### 1.1 Typographie

```html
<!-- Dans app.blade.php <head> -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
```

```js
// tailwind.config.js
fontFamily: {
  sans:   ['DM Sans', 'sans-serif'],
  serif:  ['Cormorant Garamond', 'serif'],
}
```

**Règle d'usage :**
- `font-serif` → H1, H2, H3 uniquement (titres de pages, titres de sections)
- `font-sans` → tout le reste (corps, labels, boutons, scores)
- Jamais de `font-serif` dans les formulaires ou les tableaux

**Échelle typographique (mobile first) :**

| Classe Tailwind | Usage |
|---|---|
| `text-3xl font-serif font-semibold` | Titre de page (H1) |
| `text-xl font-serif font-semibold` | Titre de section (H2) |
| `text-base font-sans font-medium` | Label de champ, titre de carte |
| `text-sm font-sans text-gray-600` | Texte secondaire, description |
| `text-xs font-sans text-gray-400` | Metadata, timestamps |

---

### 1.2 Palette de couleurs

```js
// tailwind.config.js — étendre les couleurs Tailwind
colors: {
  brand: {
    50:  '#f0f4ff',
    100: '#e0e9ff',
    500: '#4f6ef7',   // couleur principale — boutons primaires, accents
    600: '#3a56e8',   // hover état bouton primaire
    900: '#1a2a7a',   // texte sur fond brand clair
  },
}
```

**Couleurs sémantiques du score (utilisées partout dans l'app) :**

| Score | Classes Tailwind | Signification |
|---|---|---|
| ≥ 80% | `text-emerald-600 bg-emerald-50 border-emerald-200` | Excellent match |
| 60–79% | `text-amber-600 bg-amber-50 border-amber-200` | Bon match |
| 40–59% | `text-orange-500 bg-orange-50 border-orange-200` | Match partiel |
| < 40% | `text-red-500 bg-red-50 border-red-200` | Faible match |

**Ces 4 combinaisons sont les seules autorisées pour représenter un score. Ne pas inventer d'autres couleurs.**

---

### 1.3 Espacements & Rayons

```
Padding de page mobile : px-4
Padding de page tablet : sm:px-6
Padding de page desktop : lg:px-8

Rayon standard carte : rounded-2xl
Rayon bouton : rounded-xl
Rayon badge/pill : rounded-full
Rayon input : rounded-xl (via Flux UI — ne pas overrider)

Gap grille mobile : gap-4
Gap grille desktop : gap-6

Elevation carte : shadow-sm (jamais shadow-lg sauf modal)
```

---

### 1.4 Flux UI — Configuration et usage

Flux UI est le système de composants officiel. **Ne jamais recréer en Tailwind pur ce que Flux propose.**

Composants Flux à utiliser obligatoirement :
- `<flux:input>` → tous les champs texte
- `<flux:select>` → tous les selects
- `<flux:checkbox>` → cases à cocher
- `<flux:button>` → tous les boutons (variant="primary" | "ghost" | "danger")
- `<flux:badge>` → badges de statut
- `<flux:modal>` → toutes les modales
- `<flux:card>` → conteneur de carte (si disponible dans la version installée)
- `<flux:tabs>` → navigation par onglets
- `<flux:toast>` / `<flux:notification>` → feedbacks flash

**Règle Flux :** ne jamais modifier les styles internes de Flux avec `!important` ou `@apply` sauf dans un fichier `resources/css/flux-overrides.css` dédié et commenté.

---

## 2. Structure globale & Layouts

### 2.1 Layout principal — `layouts/app.blade.php`

Structure mobile-first en trois zones :

```
┌─────────────────────────────┐
│  TOPBAR (fixe, h-16)        │  ← Logo + nav contextuelle + avatar menu
├─────────────────────────────┤
│                             │
│  CONTENU PRINCIPAL          │  ← max-w-2xl (mobile/candidat) 
│  (scrollable)               │     ou max-w-5xl (dashboard recruteur)
│                             │
├─────────────────────────────┤
│  BOTTOM NAV (mobile only)   │  ← hidden sm:hidden — 4 icônes max
└─────────────────────────────┘
```

**Topbar :**
```html
<header class="fixed top-0 inset-x-0 z-50 h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 sm:px-6">
  <!-- Gauche : Logo -->
  <a href="/" class="font-serif text-xl font-semibold text-gray-900">MatchRH</a>

  <!-- Droite mobile : avatar seul -->
  <!-- Droite desktop : liens nav + avatar -->
  <div class="flex items-center gap-3">
    <!-- sm:flex hidden liens desktop -->
    <nav class="hidden sm:flex items-center gap-6 text-sm font-medium text-gray-600">
      <!-- liens selon le rôle -->
    </nav>
    <!-- Avatar Flux dropdown -->
    <flux:dropdown>
      <flux:button variant="ghost" size="sm" class="rounded-full w-9 h-9 p-0">
        <!-- initiales utilisateur -->
      </flux:button>
      <flux:menu>
        <flux:menu.item href="/profil">Mon profil</flux:menu.item>
        <flux:menu.item href="/parametres">Paramètres</flux:menu.item>
        <flux:menu.separator />
        <flux:menu.item wire:click="logout" variant="danger">Déconnexion</flux:menu.item>
      </flux:menu>
    </flux:dropdown>
  </div>
</header>
```

**Bottom navigation mobile (candidat uniquement) :**
```html
<!-- Visible uniquement < sm, position fixed bottom -->
<nav class="sm:hidden fixed bottom-0 inset-x-0 z-50 bg-white border-t border-gray-100 flex">
  <a href="/offres" class="flex-1 flex flex-col items-center justify-center gap-1 py-3 text-xs text-gray-500">
    <!-- Heroicon outline briefcase -->
    <svg .../>
    Offres
  </a>
  <a href="/candidatures" class="flex-1 ...">
    <!-- Heroicon outline document-check -->
    Mes candidatures
  </a>
  <a href="/profil" class="flex-1 ...">
    <!-- Heroicon outline user -->
    Profil
  </a>
</nav>
<!-- Padding bottom pour compenser la bottom nav -->
<div class="pb-20 sm:pb-0">{{ $slot }}</div>
```

---

### 2.2 Layout d'authentification — `layouts/auth.blade.php`

Centré verticalement, sans topbar, fond gris très léger.

```html
<body class="min-h-screen bg-gray-50 flex flex-col items-center justify-center px-4 py-12">
  <a href="/" class="mb-8 font-serif text-2xl font-semibold text-gray-900">MatchRH</a>
  <div class="w-full max-w-sm bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
    {{ $slot }}
  </div>
  <p class="mt-6 text-xs text-gray-400 text-center max-w-xs">
    En utilisant MatchRH, vous acceptez nos 
    <a href="/cgu" class="underline">CGU</a> et notre 
    <a href="/confidentialite" class="underline">politique de confidentialité</a>.
  </p>
</body>
```

---

### 2.3 Layout Wizard (création d'offre) — `layouts/wizard.blade.php`

Pas de topbar complète. Juste logo + indicateur d'étape + bouton quitter.

```html
<body class="min-h-screen bg-gray-50">
  <!-- Header wizard -->
  <header class="fixed top-0 inset-x-0 z-50 h-14 bg-white border-b border-gray-100 flex items-center px-4 sm:px-6">
    <span class="font-serif font-semibold text-gray-900 mr-auto">MatchRH</span>
    <!-- Indicateur étapes : points cliquables desktop, "2/5" texte mobile -->
    <div class="hidden sm:flex items-center gap-2">
      <!-- Généré dynamiquement par Livewire -->
    </div>
    <span class="sm:hidden text-sm text-gray-500 ml-auto">Étape {{ $currentStep }}/{{ $totalSteps }}</span>
    <button class="ml-4 text-sm text-gray-400 hover:text-gray-600">Quitter</button>
  </header>

  <!-- Contenu wizard : padding top pour le header fixe -->
  <main class="pt-14 min-h-screen">
    <div class="max-w-xl mx-auto px-4 py-8 sm:py-12">
      {{ $slot }}
    </div>
  </main>

  <!-- Footer wizard : boutons Précédent / Suivant -->
  <footer class="fixed bottom-0 inset-x-0 bg-white border-t border-gray-100 px-4 py-4 flex gap-3 sm:justify-end">
    <flux:button variant="ghost" wire:click="previousStep" class="flex-1 sm:flex-none sm:w-32">
      Précédent
    </flux:button>
    <flux:button variant="primary" wire:click="nextStep" class="flex-1 sm:flex-none sm:w-40">
      Continuer
    </flux:button>
  </footer>
  <!-- Padding bottom pour footer fixe -->
  <div class="pb-20"></div>
</body>
```

---

## 3. Composants partagés

### 3.1 Composant Score — `components/score-badge.blade.php`

Usage : `<x-score-badge :score="$result->score_principal" />`

```php
// Logique dans la classe du composant ou en attribut Blade
// $score : float 0-100
// $size : 'sm' | 'md' | 'lg' (défaut md)
```

```html
@php
  $color = match(true) {
    $score >= 80 => 'text-emerald-600 bg-emerald-50 border-emerald-200',
    $score >= 60 => 'text-amber-600 bg-amber-50 border-amber-200',
    $score >= 40 => 'text-orange-500 bg-orange-50 border-orange-200',
    default      => 'text-red-500 bg-red-50 border-red-200',
  };
  $sizes = [
    'sm' => 'text-sm px-2.5 py-1 font-medium',
    'md' => 'text-base px-3 py-1.5 font-semibold',
    'lg' => 'text-2xl px-5 py-3 font-bold',
  ];
@endphp

<span class="inline-flex items-center gap-1 rounded-full border {{ $color }} {{ $sizes[$size ?? 'md'] }}">
  {{ number_format($score, 1) }}%
</span>
```

---

### 3.2 Barre de progression de score — `components/score-bar.blade.php`

Usage sur les cartes d'offre et le détail de score.

```html
@php
  $barColor = match(true) {
    $score >= 80 => 'bg-emerald-500',
    $score >= 60 => 'bg-amber-400',
    $score >= 40 => 'bg-orange-400',
    default      => 'bg-red-400',
  };
@endphp

<div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
  <div 
    class="h-full rounded-full transition-all duration-700 {{ $barColor }}"
    style="width: {{ $score }}%"
    role="progressbar"
    aria-valuenow="{{ $score }}"
    aria-valuemin="0"
    aria-valuemax="100"
  ></div>
</div>
```

---

### 3.3 Carte d'offre — `components/job-card.blade.php`

Composant central utilisé dans la liste des offres côté candidat.

```html
<article class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5 flex flex-col gap-3 hover:border-gray-200 hover:shadow-md transition-all duration-200">
  
  <!-- En-tête : titre + score -->
  <div class="flex items-start justify-between gap-3">
    <div class="min-w-0">
      <h3 class="font-sans font-semibold text-gray-900 text-base leading-tight truncate">
        {{ $offer->title }}
      </h3>
      <p class="text-sm text-gray-500 mt-0.5">{{ $offer->recruiterProfile->company_name }}</p>
    </div>
    <!-- Score badge : visible uniquement si profil candidat complet -->
    @if($score !== null)
      <x-score-badge :score="$score" size="sm" class="shrink-0" />
    @endif
  </div>

  <!-- Barre de score -->
  @if($score !== null)
    <x-score-bar :score="$score" />
  @endif

  <!-- Meta : localisation + template + disponibilité -->
  <div class="flex flex-wrap gap-2">
    <flux:badge color="zinc" size="sm">
      <!-- icône pin -->  {{ $offer->city }}
    </flux:badge>
    <flux:badge color="zinc" size="sm">
      {{ ucfirst($offer->template) }}
    </flux:badge>
    @if($offer->budget_min)
      <flux:badge color="zinc" size="sm">
        {{ number_format($offer->budget_min / 1000) }}k – {{ number_format($offer->budget_max / 1000) }}k FCFA
      </flux:badge>
    @endif
  </div>

  <!-- Atouts détectés : résumé rapide -->
  @if($assetsMatched > 0)
    <p class="text-xs text-emerald-600 font-medium">
      ✓ {{ $assetsMatched }} atout{{ $assetsMatched > 1 ? 's' : '' }} détecté{{ $assetsMatched > 1 ? 's' : '' }} sur votre profil
    </p>
  @endif

  <!-- CTA -->
  <div class="flex gap-2 mt-1">
    <flux:button variant="ghost" size="sm" :href="route('candidate.offers.show', $offer)" class="flex-1 sm:flex-none">
      Voir le détail
    </flux:button>
    @if($score >= 40)
      <flux:button variant="primary" size="sm" wire:click="express_interest({{ $offer->id }})" class="flex-1 sm:flex-none">
        Je suis intéressé(e)
      </flux:button>
    @endif
  </div>

</article>
```

---

### 3.4 Sélecteur de niveau (1–5) — `components/level-picker.blade.php`

Utilisé partout où on saisit un niveau de compétence.

```html
<!-- Usage : <x-level-picker wire:model="skills.{{ $index }}.level" label="Niveau" /> -->

<div class="flex flex-col gap-2">
  @if($label)
    <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
  @endif
  <div class="flex gap-2" role="radiogroup" aria-label="{{ $label }}">
    @foreach([1,2,3,4,5] as $lvl)
      <button
        type="button"
        wire:click="$set('{{ $model }}', {{ $lvl }})"
        class="w-10 h-10 rounded-xl border text-sm font-semibold transition-all duration-150
          {{ $value == $lvl 
            ? 'bg-brand-500 text-white border-brand-500 shadow-sm' 
            : 'bg-white text-gray-600 border-gray-200 hover:border-brand-500 hover:text-brand-500' }}"
        aria-pressed="{{ $value == $lvl ? 'true' : 'false' }}"
      >
        {{ $lvl }}
      </button>
    @endforeach
  </div>
  <div class="flex justify-between text-xs text-gray-400">
    <span>Débutant</span>
    <span>Expert</span>
  </div>
</div>
```

---

### 3.5 Indicateur de complétude profil — `components/profile-completion.blade.php`

Affiché en haut du dashboard candidat tant que le profil est incomplet.

```html
@if($completionPercent < 100)
<div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex flex-col gap-3">
  <div class="flex items-center justify-between">
    <p class="text-sm font-semibold text-amber-800">
      Profil incomplet — votre score de matching sera limité
    </p>
    <span class="text-sm font-bold text-amber-600">{{ $completionPercent }}%</span>
  </div>
  <div class="w-full bg-amber-200 rounded-full h-1.5">
    <div class="bg-amber-500 h-full rounded-full" style="width: {{ $completionPercent }}%"></div>
  </div>
  <ul class="space-y-1">
    @foreach($missingFields as $field)
      <li class="text-xs text-amber-700 flex items-center gap-1.5">
        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shrink-0"></span>
        {{ $field['label'] }}
        @if($field['impact'] === 'high')
          <flux:badge color="orange" size="xs">Impact fort</flux:badge>
        @endif
      </li>
    @endforeach
  </ul>
  <flux:button variant="ghost" size="sm" :href="route('candidate.profile.edit')" class="self-start">
    Compléter mon profil →
  </flux:button>
</div>
@endif
```

---

## 4. Parcours Recruteur

### 4.1 Page d'inscription recruteur — `/inscription/recruteur`

**Composant Livewire :** `RecruiterRegisterForm`

**Layout :** `layouts/auth.blade.php`

**Champs dans l'ordre :**
1. Nom complet (prénom + nom dans un seul champ pour simplicité mobile)
2. Email professionnel
3. Mot de passe (avec œil pour afficher)
4. Nom de l'entreprise
5. Ville (select ou input libre — camerounais en priorité)

**UX précis :**
- Pas de sélection de rôle visible → l'URL `/inscription/recruteur` fixe le rôle automatiquement
- Validation en temps réel Livewire : feedback inline sous chaque champ dès `blur` (pas au submit)
- Le bouton "Créer mon compte" est désactivé (`disabled`) tant que les champs obligatoires sont vides. Pas de message d'erreur global, uniquement les messages inline sous les champs
- Après soumission réussie : redirection vers `/recruteur/profil/completer` avec un flash Flux toast "Bienvenue ! Complétez votre profil pour publier votre première offre."
- Lien en bas : "Vous êtes un candidat ? → Inscription candidat"

```html
<!-- Structure de la page -->
<h1 class="font-serif text-2xl font-semibold text-gray-900 mb-1">Créez votre espace recruteur</h1>
<p class="text-sm text-gray-500 mb-6">Publiez vos offres et trouvez les meilleurs profils.</p>

<form wire:submit="register" class="space-y-4">
  <flux:input wire:model.live="name" label="Nom complet" placeholder="Jean Mbarga" required />
  <flux:input wire:model.live="email" type="email" label="Email professionnel" placeholder="jean@entreprise.cm" required />
  <flux:input wire:model.live="password" type="password" label="Mot de passe" viewable required />
  <flux:input wire:model.live="company_name" label="Nom de l'entreprise" placeholder="TechCorp Douala" required />
  <flux:select wire:model.live="city" label="Ville" required>
    <flux:select.option value="">Choisir une ville</flux:select.option>
    <flux:select.option value="Douala">Douala</flux:select.option>
    <flux:select.option value="Yaoundé">Yaoundé</flux:select.option>
    <!-- ... -->
  </flux:select>

  <flux:button type="submit" variant="primary" class="w-full mt-2" wire:loading.attr="disabled">
    <span wire:loading.remove>Créer mon compte</span>
    <span wire:loading>Création en cours...</span>
  </flux:button>
</form>

<p class="mt-4 text-center text-sm text-gray-500">
  Vous êtes un candidat ? 
  <a href="/inscription/candidat" class="text-brand-500 font-medium">Inscrivez-vous ici</a>
</p>
```

---

### 4.2 Dashboard recruteur — `/recruteur/tableau-de-bord`

**Composant Livewire :** `RecruiterDashboard`

**Layout :** `layouts/app.blade.php` avec `max-w-5xl`

**Structure de la page (mobile first, de haut en bas) :**

```
1. Titre de page
2. Métriques rapides (grille 2 colonnes mobile, 4 desktop)
3. Section "Mes offres actives" avec mini-cartes
4. Bouton flottant "Nouvelle offre" (FAB mobile)
```

**Métriques rapides :**
```html
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
  <!-- Carte métrique : offres actives -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Offres actives</p>
    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeOffers }}</p>
  </div>
  <!-- Candidatures reçues (total) -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Candidatures</p>
    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalApplications }}</p>
  </div>
  <!-- Nouveaux candidats depuis hier -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Nouveaux hier</p>
    <p class="text-3xl font-bold text-emerald-600 mt-1">+{{ $newYesterday }}</p>
  </div>
  <!-- Score moyen des candidatures reçues -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Score moyen</p>
    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $avgScore }}%</p>
  </div>
</div>
```

**FAB mobile "Nouvelle offre" :**
```html
<!-- Visible uniquement mobile, position fixed -->
<a href="{{ route('recruiter.offers.create') }}"
   class="sm:hidden fixed bottom-6 right-4 z-40 bg-brand-500 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg active:scale-95 transition-transform">
  <!-- Heroicon plus lg -->
  <svg .../>
</a>
<!-- Bouton standard desktop -->
<div class="hidden sm:flex justify-end mb-6">
  <flux:button variant="primary" :href="route('recruiter.offers.create')">
    + Nouvelle offre
  </flux:button>
</div>
```

---

### 4.3 Wizard de création d'offre — `/recruteur/offres/creer`

**Composant Livewire :** `CreateJobOfferWizard` (classe unique, 5 étapes)

**Layout :** `layouts/wizard.blade.php`

**Principe Livewire :** Une seule classe Livewire gère les 5 étapes avec `$currentStep` (int 1-5). Pas de routing entre les étapes — tout reste sur la même URL. L'état est en mémoire Livewire.

#### Étape 1 — Choix du template

**UX :** Sélection en cartes visuelles, une seule sélection possible. Tap sur mobile, clic desktop.

```html
<h2 class="font-serif text-xl font-semibold text-gray-900 mb-2">Quel type de poste recrutez-vous ?</h2>
<p class="text-sm text-gray-500 mb-6">Ce choix détermine comment les candidats sont évalués. Il ne peut pas être modifié après la publication.</p>

<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4">
  @foreach($templates as $key => $template)
    <button
      type="button"
      wire:click="selectTemplate('{{ $key }}')"
      class="text-left p-4 rounded-2xl border-2 transition-all duration-150
        {{ $selectedTemplate === $key 
          ? 'border-brand-500 bg-brand-50 shadow-sm' 
          : 'border-gray-100 bg-white hover:border-gray-300' }}"
    >
      <div class="flex items-start justify-between gap-2">
        <span class="font-semibold text-gray-900 text-sm">{{ $template['label'] }}</span>
        @if($selectedTemplate === $key)
          <span class="text-brand-500 shrink-0">
            <!-- Heroicon check-circle outline -->
          </span>
        @endif
      </div>
      <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $template['description'] }}</p>
      <div class="mt-3 pt-3 border-t border-gray-100 flex items-center gap-1.5">
        <span class="text-xs text-gray-400">Compétences</span>
        <span class="text-xs font-semibold text-gray-700">{{ $template['weights']['skills'] }}%</span>
        <span class="text-gray-200 mx-1">·</span>
        <span class="text-xs text-gray-400">Expérience</span>
        <span class="text-xs font-semibold text-gray-700">{{ $template['weights']['experience'] }}%</span>
      </div>
    </button>
  @endforeach
</div>

<!-- Note pédagogique -->
<div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-xl">
  <p class="text-xs text-blue-700">
    <strong>Pourquoi ce choix est important ?</strong><br>
    Les pondérations s'adaptent au niveau du poste. Un manœuvre peut apprendre sur le tas — un cadre dirigeant, non.
  </p>
</div>
```

**Templates à afficher (données statiques depuis config/matching.php) :**

| Clé | Label | Description courte |
|---|---|---|
| `manoeuvre` | Manœuvres & Ouvriers | Priorité à la présence et disponibilité |
| `technicien` | Employés & Techniciens | Les compétences techniques priment |
| `agent` | Agents de maîtrise | Équilibre compétences / expérience |
| `cadre` | Cadres | Rigueur — expérience et compétences à égalité |
| `dirigeant` | Cadres dirigeants | Exigence maximale — l'expérience domine |

---

#### Étape 2 — Informations générales

**Champs dans l'ordre mobile-first :**

```html
<h2 class="font-serif text-xl font-semibold text-gray-900 mb-6">Décrivez votre offre</h2>

<div class="space-y-4">
  <flux:input wire:model.live="title" label="Intitulé du poste" placeholder="Ex : Développeur Laravel Senior" required />
  
  <flux:textarea wire:model.live="description" label="Description" rows="4"
    placeholder="Décrivez les missions, le contexte, les attentes..." />

  <div class="grid grid-cols-2 gap-3">
    <flux:select wire:model.live="city" label="Ville" required><!-- villes --></flux:select>
    <flux:select wire:model.live="region" label="Région"><!-- régions --></flux:select>
  </div>

  <!-- Fourchette salariale : optionnelle, affichée avec toggle -->
  <div>
    <label class="flex items-center gap-2 cursor-pointer mb-3">
      <flux:checkbox wire:model.live="hasSalary" />
      <span class="text-sm font-medium text-gray-700">Déclarer une fourchette salariale</span>
    </label>
    @if($hasSalary)
      <div class="grid grid-cols-2 gap-3 mt-2" x-transition>
        <flux:input wire:model.live="budget_min" type="number" label="Minimum (FCFA)" placeholder="300000" />
        <flux:input wire:model.live="budget_max" type="number" label="Maximum (FCFA)" placeholder="500000" />
      </div>
    @endif
  </div>
</div>
```

---

#### Étape 3 — Compétences requises

**UX : Recherche dans la bibliothèque + niveau 1–5 pour chaque compétence ajoutée**

```html
<h2 class="font-serif text-xl font-semibold text-gray-900 mb-2">Compétences requises</h2>
<p class="text-sm text-gray-500 mb-5">Ajoutez au moins 1 compétence. Définissez le niveau minimum attendu.</p>

<!-- Recherche Livewire avec debounce -->
<div class="relative mb-4">
  <flux:input 
    wire:model.live.debounce.300ms="skillSearch" 
    placeholder="Chercher une compétence (ex: Excel, Laravel...)"
    class="w-full"
  />
  <!-- Dropdown résultats de recherche -->
  @if($skillResults && strlen($skillSearch) >= 2)
    <div class="absolute top-full left-0 right-0 z-30 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
      @forelse($skillResults as $skill)
        <button
          type="button"
          wire:click="addSkill({{ $skill->id }})"
          class="w-full text-left px-4 py-3 text-sm hover:bg-gray-50 border-b border-gray-50 last:border-0"
        >
          <span class="font-medium text-gray-900">{{ $skill->name }}</span>
          <span class="text-gray-400 text-xs ml-2">{{ $skill->category }}</span>
        </button>
      @empty
        <p class="px-4 py-3 text-sm text-gray-400">Aucun résultat pour "{{ $skillSearch }}"</p>
      @endforelse
    </div>
  @endif
</div>

<!-- Compétences déjà ajoutées -->
<div class="space-y-3">
  @foreach($selectedSkills as $index => $item)
    <div class="bg-gray-50 rounded-2xl p-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-6">
      <div class="flex items-center justify-between sm:flex-1">
        <span class="font-medium text-gray-900 text-sm">{{ $item['name'] }}</span>
        <button wire:click="removeSkill({{ $index }})" class="text-gray-300 hover:text-red-400 transition-colors sm:hidden">
          <!-- Heroicon x-mark sm -->
        </button>
      </div>
      <div class="flex items-center gap-3">
        <x-level-picker wire:model="selectedSkills.{{ $index }}.level" />
        <button wire:click="removeSkill({{ $index }})" class="hidden sm:block text-gray-300 hover:text-red-400 transition-colors">
          <!-- Heroicon x-mark -->
        </button>
      </div>
    </div>
  @endforeach
</div>

@if(count($selectedSkills) === 0)
  <p class="text-center text-sm text-gray-400 py-8 border-2 border-dashed border-gray-200 rounded-2xl">
    Aucune compétence ajoutée.<br>Cherchez ci-dessus pour commencer.
  </p>
@endif
```

---

#### Étape 4 — Critères bloquants

**UX : Toggle pour chaque critère. Quand activé, afficher le sélecteur de valeur.**

```html
<h2 class="font-serif text-xl font-semibold text-gray-900 mb-2">Critères éliminatoires</h2>
<p class="text-sm text-gray-500 mb-5">
  Un candidat qui ne remplit pas un critère activé obtiendra automatiquement un score de 0. 
  Soyez prudent — un critère trop strict peut éliminer de bons profils.
</p>

<div class="space-y-3">

  <!-- Critère : Langue -->
  <div class="bg-white rounded-2xl border border-gray-100 p-4">
    <label class="flex items-center justify-between gap-3 cursor-pointer">
      <div>
        <span class="font-medium text-gray-900 text-sm">Profil linguistique</span>
        <p class="text-xs text-gray-400 mt-0.5">Langue(s) de travail obligatoire(s)</p>
      </div>
      <flux:checkbox wire:model.live="blocking.language.active" />
    </label>
    @if($blocking['language']['active'])
      <div class="mt-3 pt-3 border-t border-gray-50" x-transition>
        <flux:select wire:model.live="blocking.language.value" size="sm">
          <flux:select.option value="francophone">Francophone</flux:select.option>
          <flux:select.option value="anglophone">Anglophone</flux:select.option>
          <flux:select.option value="bilingue">Bilingue (FR + EN)</flux:select.option>
        </flux:select>
      </div>
    @endif
  </div>

  <!-- Critère : Diplôme minimum -->
  <div class="bg-white rounded-2xl border border-gray-100 p-4">
    <label class="flex items-center justify-between gap-3 cursor-pointer">
      <div>
        <span class="font-medium text-gray-900 text-sm">Diplôme minimum</span>
        <p class="text-xs text-gray-400 mt-0.5">Niveau de formation obligatoire</p>
      </div>
      <flux:checkbox wire:model.live="blocking.education.active" />
    </label>
    @if($blocking['education']['active'])
      <div class="mt-3 pt-3 border-t border-gray-50">
        <flux:select wire:model.live="blocking.education.value" size="sm">
          <flux:select.option value="bepc">BEPC</flux:select.option>
          <flux:select.option value="bac">BAC</flux:select.option>
          <flux:select.option value="bts">BTS / DUT</flux:select.option>
          <flux:select.option value="licence">Licence</flux:select.option>
          <flux:select.option value="master">Master</flux:select.option>
          <flux:select.option value="doctorat">Doctorat</flux:select.option>
        </flux:select>
      </div>
    @endif
  </div>

  <!-- Critère : Permis de conduire -->
  <div class="bg-white rounded-2xl border border-gray-100 p-4">
    <label class="flex items-center justify-between gap-3 cursor-pointer">
      <div>
        <span class="font-medium text-gray-900 text-sm">Permis de conduire</span>
        <p class="text-xs text-gray-400 mt-0.5">Catégorie obligatoire</p>
      </div>
      <flux:checkbox wire:model.live="blocking.permit.active" />
    </label>
    @if($blocking['permit']['active'])
      <div class="mt-3 pt-3 border-t border-gray-50">
        <flux:select wire:model.live="blocking.permit.value" size="sm">
          <flux:select.option value="permis_A">Permis A (moto)</flux:select.option>
          <flux:select.option value="permis_B">Permis B (voiture)</flux:select.option>
          <flux:select.option value="permis_C">Permis C (poids lourd)</flux:select.option>
          <flux:select.option value="permis_ABCD">Tous permis</flux:select.option>
        </flux:select>
      </div>
    @endif
  </div>

  <!-- Critère : Disponibilité maximale -->
  <div class="bg-white rounded-2xl border border-gray-100 p-4">
    <!-- même pattern toggle/select -->
  </div>

</div>

<!-- Note d'avertissement si 0 critère bloquant -->
@if(collect($blocking)->where('active', true)->isEmpty())
  <div class="mt-4 p-3 bg-gray-50 border border-gray-100 rounded-xl">
    <p class="text-xs text-gray-500">
      Aucun critère bloquant activé. Tous les candidats passeront l'étape de filtrage et seront classés par score.
    </p>
  </div>
@endif
```

---

#### Étape 5 — Atouts recherchés (optionnel) + Récapitulatif

Cette étape est en deux sous-sections sur la même vue :

**Sous-section A — Atouts (Couche 3)**

```html
<h2 class="font-serif text-xl font-semibold text-gray-900 mb-2">Atouts recherchés <span class="text-gray-400 font-sans text-base font-normal">(optionnel)</span></h2>
<p class="text-sm text-gray-500 mb-4">
  Ces atouts ne modifient pas le score. Ils s'affichent séparément pour vous aider à affiner votre choix entre candidats à score égal.
</p>

<!-- Recherche dans bibliothèque assets -->
<flux:input wire:model.live.debounce.300ms="assetSearch" placeholder="Ex : Expérience BTP, Certification PMP..." class="mb-3" />

<!-- Assets sélectionnés avec priorité -->
@foreach($selectedAssets as $index => $asset)
  <div class="flex items-center gap-3 bg-gray-50 rounded-xl px-4 py-3">
    <span class="flex-1 text-sm text-gray-900">{{ $asset['name'] }}</span>
    <flux:select wire:model="selectedAssets.{{ $index }}.priority" size="sm" class="w-28">
      <flux:select.option value="low">Mineur</flux:select.option>
      <flux:select.option value="medium">Réel</flux:select.option>
      <flux:select.option value="high">Important</flux:select.option>
    </flux:select>
    <button wire:click="removeAsset({{ $index }})" class="text-gray-300 hover:text-red-400"><!-- x --></button>
  </div>
@endforeach
```

**Sous-section B — Récapitulatif avant publication**

```html
<div class="mt-8 pt-6 border-t border-gray-100">
  <h3 class="font-sans font-semibold text-gray-900 mb-4">Récapitulatif de l'offre</h3>
  
  <div class="bg-gray-50 rounded-2xl p-4 space-y-3 text-sm">
    <div class="flex justify-between">
      <span class="text-gray-500">Poste</span>
      <span class="font-medium text-gray-900">{{ $title }}</span>
    </div>
    <div class="flex justify-between">
      <span class="text-gray-500">Template</span>
      <flux:badge color="violet" size="sm">{{ $templateLabel }}</flux:badge>
    </div>
    <div class="flex justify-between">
      <span class="text-gray-500">Compétences</span>
      <span class="font-medium text-gray-900">{{ count($selectedSkills) }} requise(s)</span>
    </div>
    <div class="flex justify-between">
      <span class="text-gray-500">Critères bloquants</span>
      <span class="font-medium text-gray-900">{{ $activeBlockingCount }} activé(s)</span>
    </div>
    <div class="flex justify-between">
      <span class="text-gray-500">Atouts recherchés</span>
      <span class="font-medium text-gray-900">{{ count($selectedAssets) }}</span>
    </div>
  </div>

  <!-- Message informatif sur le matching -->
  <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-xl">
    <p class="text-xs text-blue-700">
      Après publication, le score de compatibilité sera calculé automatiquement pour tous les candidats dont le profil est actif. Ce processus prend généralement moins d'une minute.
    </p>
  </div>
</div>
```

**Footer wizard à l'étape 5 — Bouton "Publier" :**
```html
<!-- Remplace le bouton "Continuer" au footer -->
<flux:button variant="primary" wire:click="publishOffer" class="flex-1 sm:flex-none sm:w-48">
  <span wire:loading.remove>Publier l'offre</span>
  <span wire:loading>Publication...</span>
</flux:button>
```

---

### 4.4 Page de détail d'offre (vue recruteur) — `/recruteur/offres/{id}`

**Composant Livewire :** `RecruiterOfferDetail`

**Structure mobile-first :**

```
1. En-tête : titre + statut badge + boutons actions (modifier, fermer)
2. Onglets Flux : "Candidatures (N)" | "Détail de l'offre" | "Statistiques"
3. [Onglet actif : Candidatures]
   → Liste des candidatures triées par score_principal DESC
```

**Liste des candidatures :**

```html
<!-- Filtre rapide -->
<div class="flex gap-2 mb-4 overflow-x-auto pb-1 -mx-4 px-4 sm:mx-0 sm:px-0 sm:flex-wrap">
  <flux:button wire:click="setFilter('all')" size="sm" :variant="$filter === 'all' ? 'primary' : 'ghost'">Toutes</flux:button>
  <flux:button wire:click="setFilter('shortlisted')" size="sm" :variant="$filter === 'shortlisted' ? 'primary' : 'ghost'">En liste courte</flux:button>
  <flux:button wire:click="setFilter('pending')" size="sm" :variant="$filter === 'pending' ? 'primary' : 'ghost'">En attente</flux:button>
</div>

<!-- Chaque candidature -->
@foreach($applications as $app)
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5 flex flex-col gap-3">
    
    <div class="flex items-start gap-3 justify-between">
      <!-- Identité candidat -->
      <div class="flex items-center gap-3 min-w-0">
        <!-- Avatar initiales -->
        <div class="w-10 h-10 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-sm font-semibold shrink-0">
          {{ substr($app->candidate->name, 0, 2) }}
        </div>
        <div class="min-w-0">
          <p class="font-semibold text-gray-900 text-sm truncate">
            {{ $app->candidate->name }}
          </p>
          <p class="text-xs text-gray-400">{{ $app->applied_at->diffForHumans() }}</p>
        </div>
      </div>
      <!-- Score -->
      <x-score-badge :score="$app->matchResult->score_principal" size="sm" />
    </div>

    <!-- Barre de score -->
    <x-score-bar :score="$app->matchResult->score_principal" />

    <!-- Détail blocs (condensé) -->
    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
      @foreach(['skills' => 'Compétences', 'experience' => 'Expérience', 'education' => 'Formation', 'availability' => 'Dispo', 'location' => 'Localisation', 'salary' => 'Salaire'] as $key => $label)
        @php $blockScore = $app->matchResult->{'score_' . $key}; @endphp
        @if($blockScore !== null)
          <div class="text-center">
            <p class="text-xs text-gray-400 truncate">{{ $label }}</p>
            <p class="text-sm font-semibold {{ $blockScore >= 80 ? 'text-emerald-600' : ($blockScore >= 60 ? 'text-amber-500' : 'text-red-400') }}">
              {{ round($blockScore) }}%
            </p>
          </div>
        @endif
      @endforeach
    </div>

    <!-- Atouts -->
    @php $matched = collect(json_decode($app->matchResult->assets_matched, true))->where('matched', true)->count(); @endphp
    @if($matched > 0)
      <p class="text-xs text-emerald-600 font-medium">✓ {{ $matched }} atout(s) détecté(s)</p>
    @endif

    <!-- Actions recruteur -->
    <div class="flex gap-2 flex-wrap">
      <flux:button size="sm" variant="ghost" wire:click="updateStatus({{ $app->id }}, 'shortlisted')">
        Sélectionner
      </flux:button>
      <flux:button size="sm" variant="ghost" wire:click="updateStatus({{ $app->id }}, 'rejected')">
        Rejeter
      </flux:button>
    </div>

  </div>
@endforeach
```

---

## 5. Parcours Candidat

### 5.1 Page d'inscription candidat — `/inscription/candidat`

Même structure que l'inscription recruteur. Champs différents :

1. Nom complet
2. Email
3. Mot de passe (viewable)
4. Profil linguistique (radio Flux ou select : Francophone / Anglophone / Bilingue)

Après inscription → redirection vers `/candidat/profil/construire` avec toast "Bienvenue ! Créez votre profil pour voir votre score sur les offres."

---

### 5.2 Construction du profil candidat — `/candidat/profil/construire`

**Composant Livewire :** `CandidateProfileBuilder`

**UX :** Ce n'est pas un wizard strict. C'est une page unique à scroll avec des sections collapsibles. Le candidat peut compléter dans n'importe quel ordre. L'indicateur de complétude en haut se met à jour en temps réel.

```
Sections (de haut en bas) :
1. Informations de base (ville, région, téléphone)
2. Expérience professionnelle (palier)
3. Formation (niveau + domaine)
4. Disponibilité
5. Compétences (recherche + niveau)
6. Prétentions salariales (optionnel)
```

**Section type avec barre de progression :**

```html
<!-- En-tête page -->
<div class="mb-6">
  <h1 class="font-serif text-2xl font-semibold text-gray-900">Créez votre profil</h1>
  <p class="text-sm text-gray-500 mt-1">Chaque section complétée améliore la précision de votre score.</p>
</div>

<!-- Indicateur de complétude (sticky) -->
<div class="sticky top-16 z-20 bg-gray-50 py-2 -mx-4 px-4 sm:mx-0 sm:px-0 mb-6">
  <x-profile-completion :completionPercent="$completionPercent" :missingFields="$missingFields" />
</div>

<!-- Section : Expérience -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6 mb-4">
  <h2 class="font-sans font-semibold text-gray-900 mb-1">Expérience professionnelle</h2>
  <p class="text-xs text-gray-400 mb-4">Choisissez votre tranche d'expérience globale</p>
  
  <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
    @foreach($experienceTiers as $key => $label)
      <button
        type="button"
        wire:click="$set('experience_tier', '{{ $key }}')"
        class="text-left px-4 py-3 rounded-xl border text-sm transition-all
          {{ $experience_tier === $key 
            ? 'border-brand-500 bg-brand-50 text-brand-800 font-medium' 
            : 'border-gray-100 bg-white text-gray-700 hover:border-gray-200' }}"
      >
        {{ $label }}
      </button>
    @endforeach
  </div>
</div>
```

**Paliers d'expérience à afficher :**

| Clé | Label |
|---|---|
| `0` | Sans expérience |
| `1` | 1 à 2 ans |
| `2` | 3 à 4 ans |
| `3` | 5 à 10 ans |
| `4` | Plus de 10 ans |

**Section : Formation**

```html
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6 mb-4">
  <h2 class="font-sans font-semibold text-gray-900 mb-1">Formation</h2>
  
  <div class="space-y-4">
    <flux:select wire:model.live="education_level" label="Niveau de diplôme" required>
      <flux:select.option value="">Choisir...</flux:select.option>
      <flux:select.option value="none">Aucun diplôme</flux:select.option>
      <flux:select.option value="cepc">CEPC</flux:select.option>
      <flux:select.option value="bepc">BEPC</flux:select.option>
      <flux:select.option value="bac">BAC</flux:select.option>
      <flux:select.option value="bts">BTS / DUT</flux:select.option>
      <flux:select.option value="licence">Licence</flux:select.option>
      <flux:select.option value="master">Master</flux:select.option>
      <flux:select.option value="doctorat">Doctorat</flux:select.option>
    </flux:select>
    
    <flux:input wire:model.live="education_field" label="Domaine d'études" 
      placeholder="Ex : Informatique, Comptabilité, Droit..." />
  </div>
</div>
```

**Bouton de sauvegarde — flottant mobile :**

```html
<!-- Mobile : bouton sticky bottom -->
<div class="fixed bottom-0 inset-x-0 bg-white border-t border-gray-100 px-4 py-4 sm:hidden">
  <flux:button variant="primary" wire:click="save" class="w-full">
    <span wire:loading.remove>Enregistrer</span>
    <span wire:loading>Enregistrement...</span>
  </flux:button>
</div>
<!-- Desktop : bouton inline en bas -->
<div class="hidden sm:flex justify-end mt-6">
  <flux:button variant="primary" wire:click="save">Enregistrer mon profil</flux:button>
</div>
```

---

### 5.3 Liste des offres — `/candidat/offres`

**Composant Livewire :** `CandidateOfferList`

**Structure :**

```html
<!-- En-tête avec compteur -->
<div class="flex items-center justify-between mb-4">
  <h1 class="font-serif text-2xl font-semibold text-gray-900">Offres disponibles</h1>
  <span class="text-sm text-gray-400">{{ $offers->total() }} offre(s)</span>
</div>

<!-- Filtres (scroll horizontal mobile) -->
<div class="flex gap-2 overflow-x-auto pb-2 -mx-4 px-4 sm:mx-0 sm:px-0 sm:flex-wrap mb-6">
  <flux:button wire:click="setSort('score')" size="sm" :variant="$sort === 'score' ? 'primary' : 'ghost'">
    Meilleur match
  </flux:button>
  <flux:button wire:click="setSort('recent')" size="sm" :variant="$sort === 'recent' ? 'primary' : 'ghost'">
    Plus récent
  </flux:button>
  <!-- Filtre ville -->
  <flux:select wire:model.live="filterCity" size="sm" class="min-w-0">
    <flux:select.option value="">Toutes les villes</flux:select.option>
    <!-- ... -->
  </flux:select>
</div>

<!-- Alerte profil incomplet si applicable -->
@if($profileIncomplete)
  <div class="mb-5 p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-3">
    <span class="text-amber-500 shrink-0 mt-0.5"><!-- Heroicon warning --></span>
    <div>
      <p class="text-sm font-medium text-amber-800">Votre profil est incomplet</p>
      <p class="text-xs text-amber-600 mt-0.5">Les scores affichés sont approximatifs. <a href="/candidat/profil/construire" class="underline font-medium">Compléter mon profil →</a></p>
    </div>
  </div>
@endif

<!-- Grille d'offres -->
<div class="space-y-4">
  @foreach($offers as $offer)
    <x-job-card :offer="$offer" :score="$offer->matchScore" :assetsMatched="$offer->matchedAssetsCount" />
  @endforeach
</div>

<!-- Pagination Flux ou Livewire -->
<div class="mt-6">{{ $offers->links() }}</div>
```

---

### 5.4 Détail d'une offre — `/candidat/offres/{id}`

**Composant Livewire :** `CandidateOfferDetail`

**UX : Le score détaillé est le moment décisif de l'expérience candidat.**

```html
<!-- En-tête offre -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-4">
  <div class="flex items-start justify-between gap-3 mb-3">
    <div>
      <h1 class="font-serif text-2xl font-semibold text-gray-900 leading-tight">{{ $offer->title }}</h1>
      <p class="text-gray-500 text-sm mt-1">{{ $offer->recruiterProfile->company_name }} · {{ $offer->city }}</p>
    </div>
    <x-score-badge :score="$score->score_principal" size="lg" />
  </div>
  <x-score-bar :score="$score->score_principal" />
</div>

<!-- Détail du score par bloc -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-4">
  <h2 class="font-sans font-semibold text-gray-900 mb-4">Détail de votre compatibilité</h2>
  
  <div class="space-y-4">
    @foreach($blockScores as $block)
      <div>
        <div class="flex items-center justify-between mb-1.5">
          <div class="flex items-center gap-2">
            <span class="text-sm font-medium text-gray-700">{{ $block['label'] }}</span>
            <span class="text-xs text-gray-400">{{ $block['weight'] }}%</span>
          </div>
          <span class="text-sm font-semibold {{ $block['score'] >= 80 ? 'text-emerald-600' : ($block['score'] >= 60 ? 'text-amber-500' : 'text-red-400') }}">
            {{ round($block['score']) }}%
          </span>
        </div>
        <x-score-bar :score="$block['score']" />
        @if($block['score'] < 60)
          <p class="text-xs text-gray-400 mt-1">{{ $block['hint'] }}</p>
        @endif
      </div>
    @endforeach
  </div>
</div>

<!-- Atouts détectés -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-4">
  <h2 class="font-sans font-semibold text-gray-900 mb-3">
    Atouts recherchés
    <span class="ml-2 text-sm font-normal text-gray-400">{{ $assetsMatched }}/{{ $assetsTotal }}</span>
  </h2>
  
  <div class="space-y-2">
    @foreach($assets as $asset)
      <div class="flex items-center gap-3">
        @if($asset['matched'])
          <span class="text-emerald-500 shrink-0">✓</span>
        @else
          <span class="text-gray-300 shrink-0">✗</span>
        @endif
        <span class="text-sm {{ $asset['matched'] ? 'text-gray-900' : 'text-gray-400' }}">
          {{ $asset['name'] }}
        </span>
        @if($asset['matched'] && $asset['priority'] === 'high')
          <flux:badge color="green" size="xs">Important</flux:badge>
        @endif
      </div>
    @endforeach
  </div>
</div>

<!-- Compétences supplémentaires -->
@if(count($extraSkills) > 0)
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-4">
    <h2 class="font-sans font-semibold text-gray-900 mb-1">
      Compétences supplémentaires
      <span class="ml-2 text-sm font-normal text-gray-400">{{ count($extraSkills) }}</span>
    </h2>
    <p class="text-xs text-gray-400 mb-3">Présentes sur votre profil mais non demandées par cette offre.</p>
    <div class="flex flex-wrap gap-2">
      @foreach($extraSkills as $skill)
        <flux:badge color="zinc" size="sm">{{ $skill }}</flux:badge>
      @endforeach
    </div>
  </div>
@endif

<!-- Description du poste -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-4">
  <h2 class="font-sans font-semibold text-gray-900 mb-3">À propos du poste</h2>
  <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $offer->description }}</p>
</div>

<!-- CTA : postuler — sticky bottom mobile -->
<div class="fixed bottom-0 inset-x-0 bg-white border-t border-gray-100 px-4 py-4 sm:hidden">
  @if(!$hasApplied)
    <flux:button variant="primary" wire:click="apply" class="w-full" wire:loading.attr="disabled">
      <span wire:loading.remove>Je suis intéressé(e)</span>
      <span wire:loading>Envoi en cours...</span>
    </flux:button>
    <p class="text-xs text-center text-gray-400 mt-2">
      Votre profil sera figé à l'envoi. Il ne sera pas mis à jour automatiquement.
    </p>
  @else
    <div class="w-full py-3 text-center text-sm text-emerald-600 font-medium bg-emerald-50 rounded-xl">
      ✓ Candidature envoyée le {{ $application->applied_at->format('d/m/Y') }}
    </div>
  @endif
</div>
<!-- Desktop : CTA inline -->
<div class="hidden sm:block mt-4">
  @if(!$hasApplied)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center justify-between gap-4">
      <p class="text-xs text-gray-400 max-w-xs">
        En cliquant "Je suis intéressé(e)", votre profil actuel sera figé pour cette offre.
      </p>
      <flux:button variant="primary" wire:click="apply" wire:loading.attr="disabled" class="shrink-0">
        Je suis intéressé(e)
      </flux:button>
    </div>
  @else
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 text-center">
      <p class="text-sm text-emerald-700 font-medium">✓ Candidature envoyée le {{ $application->applied_at->format('d/m/Y') }}</p>
    </div>
  @endif
</div>

<!-- Padding bottom pour sticky CTA mobile -->
<div class="h-28 sm:hidden"></div>
```

---

### 5.5 Mes candidatures — `/candidat/candidatures`

**Composant Livewire :** `CandidateApplicationList`

```html
<h1 class="font-serif text-2xl font-semibold text-gray-900 mb-6">Mes candidatures</h1>

@forelse($applications as $app)
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5 mb-3">
    <div class="flex items-start justify-between gap-3 mb-2">
      <div>
        <h3 class="font-semibold text-gray-900 text-sm">{{ $app->matchResult->jobOffer->title }}</h3>
        <p class="text-xs text-gray-400 mt-0.5">
          {{ $app->matchResult->jobOffer->recruiterProfile->company_name }}
          · Envoyée {{ $app->applied_at->diffForHumans() }}
        </p>
      </div>
      <x-score-badge :score="$app->matchResult->score_principal" size="sm" />
    </div>
    <!-- Statut candidature -->
    @php
      $statusColors = [
        'pending'     => 'zinc',
        'viewed'      => 'blue',
        'shortlisted' => 'green',
        'rejected'    => 'red',
        'hired'       => 'purple',
      ];
      $statusLabels = [
        'pending'     => 'En attente',
        'viewed'      => 'Vue',
        'shortlisted' => 'En liste courte',
        'rejected'    => 'Non retenu(e)',
        'hired'       => 'Embauche',
      ];
    @endphp
    <flux:badge :color="$statusColors[$app->status]" size="sm">
      {{ $statusLabels[$app->status] }}
    </flux:badge>
  </div>
@empty
  <div class="text-center py-16 text-gray-400">
    <p class="text-sm">Vous n'avez pas encore postulé à une offre.</p>
    <flux:button variant="ghost" :href="route('candidate.offers.index')" class="mt-3">
      Parcourir les offres →
    </flux:button>
  </div>
@endforelse
```

---

## 6. Composant Score — Règle d'or

Le score est l'élément différenciateur de MatchRH. Ces règles s'appliquent partout sans exception.

**Règle 1 — Jamais de score brut sans couleur.**
Un chiffre "68.3" sans contexte visuel ne signifie rien. Toujours utiliser `x-score-badge` ou la couleur sémantique.

**Règle 2 — Toujours arrondir à 1 décimale maximum.**
`round($score, 1)` en PHP. Jamais "68.571428".

**Règle 3 — Hiérarchie visuelle.**
Score global → grand et proéminent. Scores par bloc → plus petits, en dessous. Jamais l'inverse.

**Règle 4 — Hint d'amélioration si bloc < 60%.**
Pour chaque bloc avec un score faible, afficher une ligne d'explication discrète :

```php
// Dans le composant Livewire
$hints = [
  'skills'       => 'Votre niveau sur certaines compétences est inférieur au requis.',
  'experience'   => 'L\'expérience requise est supérieure à votre palier déclaré.',
  'education'    => 'Le niveau de formation requis est supérieur au vôtre.',
  'availability' => 'Votre disponibilité est au-delà du délai souhaité.',
  'location'     => 'Vous n\'êtes pas dans la même ville que le poste.',
  'salary'       => 'Vos prétentions dépassent légèrement le budget prévu.',
];
```

**Règle 5 — Le score à 0 (critère bloquant) s'affiche différemment.**

```html
@if(!$score->passed_blocking)
  <div class="bg-red-50 border border-red-200 rounded-xl p-3 text-sm text-red-700">
    <strong>Profil non éligible</strong> — Un critère obligatoire de cette offre ne correspond pas à votre profil. 
    Vous pouvez tout de même consulter le détail de l'offre.
  </div>
@endif
```

---

## 7. États & Feedbacks Livewire

### 7.1 États de chargement

Chaque action Livewire doit avoir un état de chargement visible. Utiliser `wire:loading` systématiquement.

```html
<!-- Bouton avec spinner -->
<flux:button wire:click="save" wire:loading.attr="disabled">
  <svg wire:loading class="animate-spin h-4 w-4 mr-2" .../>
  <span wire:loading.remove>Enregistrer</span>
  <span wire:loading>Enregistrement...</span>
</flux:button>

<!-- Skeleton loader pour les listes -->
<div wire:loading class="space-y-3">
  @for($i = 0; $i < 3; $i++)
    <div class="bg-white rounded-2xl border border-gray-100 p-5 animate-pulse">
      <div class="h-4 bg-gray-200 rounded w-3/4 mb-3"></div>
      <div class="h-3 bg-gray-100 rounded w-1/2"></div>
    </div>
  @endfor
</div>
<div wire:loading.remove>
  <!-- contenu réel -->
</div>
```

### 7.2 Notifications flash

Toujours via `flux:toast` (ou l'équivalent Flux) déclenché depuis le composant Livewire.

```php
// Dans le composant Livewire
$this->dispatch('notify', message: 'Offre publiée avec succès !', type: 'success');
$this->dispatch('notify', message: 'Une erreur est survenue.', type: 'error');
```

```html
<!-- Dans app.blade.php, écouter l'event -->
<div
  x-data="{ show: false, message: '', type: 'success' }"
  @notify.window="message = $event.detail.message; type = $event.detail.type; show = true; setTimeout(() => show = false, 4000)"
  x-show="show"
  x-transition
  class="fixed top-20 right-4 z-50 max-w-sm"
>
  <flux:toast :type="type">{{ message }}</flux:toast>
</div>
```

### 7.3 Confirmations destructives

Pour les actions irréversibles (fermer une offre, rejeter une candidature) : utiliser `flux:modal` de confirmation plutôt qu'un `confirm()` JavaScript natif.

```html
<flux:modal name="confirm-close-offer" class="max-w-sm">
  <div class="p-5">
    <h3 class="font-semibold text-gray-900 mb-2">Fermer cette offre ?</h3>
    <p class="text-sm text-gray-500 mb-5">
      L'offre ne sera plus visible par les candidats. Les candidatures existantes sont conservées.
    </p>
    <div class="flex gap-3">
      <flux:button variant="ghost" x-on:click="$flux.modal('confirm-close-offer').close()" class="flex-1">
        Annuler
      </flux:button>
      <flux:button variant="danger" wire:click="closeOffer" class="flex-1">
        Fermer l'offre
      </flux:button>
    </div>
  </div>
</flux:modal>
```

### 7.4 Validation en temps réel

```php
// Dans tous les composants Livewire avec formulaires
public function updated($field): void
{
    $this->validateOnly($field);
}
```

Les erreurs s'affichent via Flux automatiquement si `flux:input` est utilisé avec `wire:model`.

---

## 8. Conventions de nommage Blade/Livewire

### Composants Livewire (classes PHP)

| Composant | Classe | Route |
|---|---|---|
| Inscription recruteur | `RecruiterRegisterForm` | `/inscription/recruteur` |
| Inscription candidat | `CandidateRegisterForm` | `/inscription/candidat` |
| Dashboard recruteur | `RecruiterDashboard` | `/recruteur/tableau-de-bord` |
| Wizard création offre | `CreateJobOfferWizard` | `/recruteur/offres/creer` |
| Détail offre recruteur | `RecruiterOfferDetail` | `/recruteur/offres/{id}` |
| Constructeur profil candidat | `CandidateProfileBuilder` | `/candidat/profil/construire` |
| Liste offres candidat | `CandidateOfferList` | `/candidat/offres` |
| Détail offre candidat | `CandidateOfferDetail` | `/candidat/offres/{id}` |
| Liste candidatures candidat | `CandidateApplicationList` | `/candidat/candidatures` |

### Composants Blade (réutilisables)

| Composant | Fichier | Usage |
|---|---|---|
| Badge de score | `components/score-badge.blade.php` | `<x-score-badge :score="$s" />` |
| Barre de score | `components/score-bar.blade.php` | `<x-score-bar :score="$s" />` |
| Carte d'offre | `components/job-card.blade.php` | `<x-job-card :offer="$o" />` |
| Sélecteur de niveau | `components/level-picker.blade.php` | `<x-level-picker wire:model="..." />` |
| Complétude profil | `components/profile-completion.blade.php` | `<x-profile-completion ... />` |

### Organisation des vues

```
resources/views/
├── layouts/
│   ├── app.blade.php
│   ├── auth.blade.php
│   └── wizard.blade.php
├── components/
│   ├── score-badge.blade.php
│   ├── score-bar.blade.php
│   ├── job-card.blade.php
│   ├── level-picker.blade.php
│   └── profile-completion.blade.php
└── livewire/
    ├── recruiter/
    │   ├── register-form.blade.php
    │   ├── dashboard.blade.php
    │   ├── create-job-offer-wizard.blade.php
    │   └── offer-detail.blade.php
    └── candidate/
        ├── register-form.blade.php
        ├── profile-builder.blade.php
        ├── offer-list.blade.php
        ├── offer-detail.blade.php
        └── application-list.blade.php
```

---

*MatchRH — Spécification UI/UX — Document confidentiel — Juin 2026*
