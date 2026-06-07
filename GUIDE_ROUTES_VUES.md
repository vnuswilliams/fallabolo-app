# 🚀 GUIDE RAPIDE - Routes et Vues par Rôle

## 📌 Vue d'ensemble

Vous avez maintenant une **structure complète de routes et de vues** basées sur les deux rôles utilisateurs de MatchRH:
- **RECRUTEUR**: Gestion des offres et candidatures
- **CANDIDAT**: Parcours des offres et candidatures

**Aucune logique métier n'a été implémentée** - seules les vues et routes existent.

---

## 🗂️ Localisation des fichiers

### Routes
```
routes/
├── web.php              ← INCLUT les deux
├── recruiter.php        ← 12 routes recruteur
└── candidate.php        ← 12 routes candidat
```

### Vues
```
resources/views/
├── pages/recruiter/           ← 7 vues
│   ├── dashboard.blade.php
│   ├── profile.blade.php
│   ├── settings.blade.php
│   └── offers/
│       ├── index.blade.php
│       ├── create.blade.php
│       ├── edit.blade.php
│       └── applications.blade.php
│
└── pages/candidate/           ← 9 vues
    ├── dashboard.blade.php
    ├── settings.blade.php
    ├── offers/
    │   ├── index.blade.php
    │   └── show.blade.php
    ├── applications/
    │   ├── index.blade.php
    │   └── show.blade.php
    └── profile/
        ├── index.blade.php
        ├── edit.blade.php
        └── skills.blade.php
```

---

## 🔐 Authentification des Rôles

Actuellement, les routes utilisent:
```php
Route::middleware(['auth', 'verified', 'role:recruiter'])->prefix('recruiter')->name('recruiter.')->group(...);
Route::middleware(['auth', 'verified', 'role:candidate'])->prefix('candidate')->name('candidate.')->group(...);
```

---

## 📦 Ce qui est inclus

### ✅ Vues
- HTML complet avec Tailwind CSS
- Formulaires et inputs formatés
- Design system respecté (palettes de couleurs, typographie, espacement)
- États de chargement et erreurs
- Responsive mobile-first

### ✅ Routes
- Routes RESTful
- Noms de routes pour utiliser `route()` dans les vues
- Groupes par rôle et préfixes

### ✅ Contrôleurs
- Méthodes génériques (`index`, `show`, `create`, `edit`, `store`, `update`, `destroy`)
- Retour de vues
- Commentaires TODO pour la logique métier

### ❌ Ce qui MANQUE (à implémenter)
- Logique métier 
- Validations (LivewireForm)
- Calcul de scoring
- Persistence de données
- Tests

---

## 🔗 Liens Utiles

### Vues par Rôle

**RECRUTEUR - `/recruiter`**
- Dashboard: `/recruiter`
- Offres: `/recruiter/offers`
- Créer offre: `/recruiter/offers/create`
- Éditer offre: `/recruiter/offers/{id}/edit`
- Candidatures: `/recruiter/offers/{id}/applications`
- Profil: `/recruiter/profile`
- Settings: `/recruiter/settings`

**CANDIDAT - `/candidate`**
- Dashboard: `/candidate`
- Offres: `/candidate/offers`
- Détail offre: `/candidate/offers/{id}`
- Candidatures: `/candidate/applications`
- Mon profil: `/candidate/profile`
- Compétences: `/candidate/profile/skills`
- Settings: `/candidate/settings`

---

## 💡 Conseils d'Utilisation

1. **Commencer par le recruteur** - Généralement plus simple (CRUD basique)
2. **Utiliser les factories** - Pour créer les données de test
3. **Implémenter les tests en parallèle** - TDD est recommandé
4. **Créer les Policies d'abord** - Avant la logique métier
5. **Vérifier les rôles à chaque étape** - S'assurer que l'authentification fonctionne

---

## 🎨 Design Notes

Toutes les vues utilisent:
- **Tailwind CSS v4** avec config personnalisée
- **Flux UI** pour les composants standards
- **Palette brand**: Bleu principal (#4f6ef7) et variations
- **Palette sémantique**: Emerald (✅), Amber (⚠️), Red (❌)
- **Typographie**: Cormorant Garamond (titres), DM Sans (corps)
- **Espacement**: Mobile-first avec breakpoints sm, md, lg
- **Radius**: 2xl pour cartes, xl pour inputs, full pour badges

---

