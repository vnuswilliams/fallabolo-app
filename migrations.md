# MatchRH — Documentation des Migrations

> Document de référence technique — Usage interne  
> Version validée — Juin 2026

-----

## Table des matières

1. [Vue d’ensemble et ordre d’exécution](#1-vue-densemble-et-ordre-dexécution)
1. [Schéma des relations](#2-schéma-des-relations)
1. [Migration 01 — users](#3-migration-01--users)
1. [Migration 02 — Spatie Permission](#4-migration-02--spatie-permission)
1. [Migration 03 — skills](#5-migration-03--skills)
1. [Migration 04 — assets](#6-migration-04--assets)
1. [Migration 05 — candidate_profiles](#7-migration-05--candidate_profiles)
1. [Migration 06 — recruiter_profiles](#8-migration-06--recruiter_profiles)
1. [Migration 07 — candidate_skills](#9-migration-07--candidate_skills)
1. [Migration 08 — job_offers](#10-migration-08--job_offers)
1. [Migration 09 — job_required_skills](#11-migration-09--job_required_skills)
1. [Migration 10 — match_results](#12-migration-10--match_results)
1. [Migration 11 — applications](#13-migration-11--applications)
1. [Récapitulatif des enums](#14-récapitulatif-des-enums)
1. [Récapitulatif des relations Eloquent](#15-récapitulatif-des-relations-eloquent)

-----

## 1. Vue d’ensemble et ordre d’exécution

L’ordre des migrations est **impératif** — chaque table qui porte une clé étrangère (`FK`) doit être créée après la table qu’elle référence.

```
01 → users
02 → tables Spatie Permission (roles, permissions, model_has_roles…)
03 → skills
04 → assets
05 → candidate_profiles          dépend de : users
06 → recruiter_profiles          dépend de : users
07 → candidate_skills            dépend de : candidate_profiles, skills
08 → job_offers                  dépend de : recruiter_profiles
09 → job_required_skills         dépend de : job_offers, skills
10 → match_results               dépend de : job_offers, candidate_profiles
11 → applications                dépend de : match_results
```

-----

## 2. Schéma des relations

```
users (1) ────────────────── (1) candidate_profiles
                                       │
                          (1) ─────────┤────────── (N) candidate_skills ── (N→1) skills
                                       │
                          (1) ─────────┘────────── (N) match_results
                                                            │
                                                   (1) ─────┘──── (1) applications

users (1) ────────────────── (1) recruiter_profiles
                                       │
                          (1) ─────────┘────────── (N) job_offers
                                                            │
                                           (N) ────────────┤──── (N) job_required_skills ── (N→1) skills
                                                            │
                                           (N) ────────────┘──── (N) match_results


skills  (1) ──── (N) candidate_skills
skills  (1) ──── (N) job_required_skills

assets  ← référencés uniquement dans le JSON required_assets de job_offers
          et dans le JSON assets_matched de match_results
          (pas de FK directe — relation logique par asset_id)
```

### Types de relations Eloquent

|Relation                             |Type       |
|-------------------------------------|-----------|
|`User` → `CandidateProfile`          |`hasOne`   |
|`User` → `RecruiterProfile`          |`hasOne`   |
|`CandidateProfile` → `User`          |`belongsTo`|
|`RecruiterProfile` → `User`          |`belongsTo`|
|`CandidateProfile` → `CandidateSkill`|`hasMany`  |
|`CandidateSkill` → `CandidateProfile`|`belongsTo`|
|`CandidateSkill` → `Skill`           |`belongsTo`|
|`Skill` → `CandidateSkill`           |`hasMany`  |
|`RecruiterProfile` → `JobOffer`      |`hasMany`  |
|`JobOffer` → `RecruiterProfile`      |`belongsTo`|
|`JobOffer` → `JobRequiredSkill`      |`hasMany`  |
|`JobRequiredSkill` → `JobOffer`      |`belongsTo`|
|`JobRequiredSkill` → `Skill`         |`belongsTo`|
|`Skill` → `JobRequiredSkill`         |`hasMany`  |
|`JobOffer` → `MatchResult`           |`hasMany`  |
|`CandidateProfile` → `MatchResult`   |`hasMany`  |
|`MatchResult` → `JobOffer`           |`belongsTo`|
|`MatchResult` → `CandidateProfile`   |`belongsTo`|
|`MatchResult` → `Application`        |`hasOne`   |
|`Application` → `MatchResult`        |`belongsTo`|

-----

## 3. Migration 01 — `users`

**Table standard Laravel.** Aucune modification du schéma de base — le rôle est géré exclusivement par Spatie Permission.

|Colonne            |Type           |Contraintes     |Description                             |
|-------------------|---------------|----------------|----------------------------------------|
|`id`               |`id`|PK              |Identifiant auto-incrémenté             |
|`name`             |`string`       |NOT NULL        |Nom complet de l’utilisateur            |
|`email`            |`string`       |NOT NULL, UNIQUE|Adresse email — identifiant de connexion|
|`roles`            |`string`       |NOT NULL        |roles du user        |
|`email_verified_at`|`timestamp`    |nullable        |Date de vérification de l’email         |
|`password`         |`string`       |NOT NULL        |Mot de passe hashé (bcrypt)             |
|`remember_token`   |`string(100)`  |nullable        |Token de session persistante            |
|`created_at`       |`timestamp`    |nullable        |Généré par `timestamps()`               |
|`updated_at`       |`timestamp`    |nullable        |Généré par `timestamps()`               |


> ⚠️ Pas besoin de creer cette table elle est deja creer .

-----

## 4. Migration 02 — Spatie Permission

**Tables générées automatiquement** par la commande `php artisan vendor:publish` de Spatie.

|Table                  |Rôle                                               |
|-----------------------|---------------------------------------------------|
|`roles`                |Stocke les rôles : `recruteur`, `candidat`, `admin`|
|`permissions`          |Stocke les permissions granulaires si nécessaire   |
|`model_has_roles`      |Table pivot — associe un `user_id` à un `role_id`  |
|`model_has_permissions`|Table pivot — permissions directes sur un model    |
|`role_has_permissions` |Table pivot — permissions attachées à un rôle      |


> Ces tables ne sont pas à créer manuellement — Spatie s’en charge via son propre fichier de migration publié.

-----

## 5. Migration 03 — `skills`

**Bibliothèque de compétences de la plateforme.** Table de référence fixe, alimentée en amont. Les utilisateurs ne créent pas de compétences librement.

|Colonne     |Type           |Contraintes            |Description                                                              |
|------------|---------------|-----------------------|-------------------------------------------------------------------------|
|`id`        |`id`|PK                     |                                                                         |
|`name`      |`string`       |NOT NULL               |Nom de la compétence : `Laravel`, `PHP`, `Excel`, `Sage Paie`…           |
|`category`  |`string`       |NOT NULL               |Catégorie : `developpement`, `comptabilite`, `rh`, `vente`, `logistique`…|
|`is_active` |`boolean`      |NOT NULL, défaut `true`|Soft désactivation — jamais de suppression physique                      |
|`created_at`|`timestamp`    |nullable               |                                                                         |
|`updated_at`|`timestamp`    |nullable               |                                                                         |


> `is_active = false` masque la compétence de toute sélection future. Les `candidate_skills` et `job_required_skills` existants référençant cette compétence restent intacts — aucune donnée orpheline.

-----

## 6. Migration 04 — `assets`

**Bibliothèque des atouts (Couche 3).** Même logique que `skills` — table de référence fixe, non modifiable par les utilisateurs.

|Colonne     |Type           |Contraintes            |Description                                                         |
|------------|---------------|-----------------------|--------------------------------------------------------------------|
|`id`        |`id`|PK                     |                                                                    |
|`name`      |`string`       |NOT NULL               |Ex : `Expérience BTP`, `Certification PMP`, `Expérience télétravail`|
|`category`  |`enum`         |NOT NULL               |Valeurs : `sectoriel`, `certification`, `contextuel`, `langue_supp` |
|`is_active` |`boolean`      |NOT NULL, défaut `true`|Soft désactivation — jamais de suppression physique                 |
|`created_at`|`timestamp`    |nullable               |                                                                    |
|`updated_at`|`timestamp`    |nullable               |                                                                    |


> Les `asset_id` stockés dans les JSON `required_assets` et `assets_matched` référencent toujours des assets avec `is_active = true`. Un asset désactivé devient invisible à la sélection mais ses occurrences JSON historiques restent lisibles.

-----

## 7. Migration 05 — `candidate_profiles`

**Profil déclaratif du candidat.** Relation `1-1` avec `users`.

|Colonne           |Type           |Contraintes                      |Description                                                                    |
|------------------|---------------|---------------------------------|-------------------------------------------------------------------------------|
|`id`              |`uuid`|PK                               |                                                                               |
|`user_id`         |`foreignId`    |NOT NULL, UNIQUE, FK → `users.id`|Un candidat = un profil                                                        |
|`phone`           |`string`       |nullable                         |Numéro de téléphone                                                            |
|`city`            |`string`       |nullable                         |Ville de résidence                                                             |
|`region`          |`string`       |nullable                         |Région de résidence                                                            |
|`country`         |`string`       |NOT NULL, défaut `Cameroun`      |Pays de résidence                                                              |
|`language_profile`|`enum`         |NOT NULL                         |Valeurs : `francophone`, `anglophone`, `bilingue`                              |
|`availability`    |`enum`         |NOT NULL                         |Valeurs : `immediate`, `15_days`, `30_days`, `more`                            |
|`experience_tier` |`enum`         |NOT NULL                         |Valeurs : `0`, `1`, `2`, `3`, `4` — correspondance paliers algo                |
|`education_level` |`enum`         |NOT NULL                         |Valeurs : `none`, `cepc`, `bepc`, `bac`, `bts`, `licence`, `master`, `doctorat`|
|`education_field` |`string`       |nullable                         |Domaine d’études : `Informatique`, `Comptabilité`…                             |
|`salary_min`      |`integer`      |nullable                         |Prétention minimale en FCFA                                                    |
|`salary_max`      |`integer`      |nullable                         |Prétention maximale en FCFA                                                    |
|`cv_path`         |`string`       |nullable                         |Chemin vers le fichier CV uploadé (storage Laravel)                            |
|`created_at`      |`timestamp`    |nullable                         |                                                                               |
|`updated_at`      |`timestamp`    |nullable                         |                                                                               |

**Relations Eloquent :**

- `belongsTo(User::class)` — via `user_id`
- `hasMany(CandidateSkill::class)` — compétences déclarées
- `hasMany(MatchResult::class)` — résultats de matching

> Le palier `experience_tier` suit l’échelle de l’algorithme : `0` = sans expérience, `1` = 1–2 ans, `2` = 3–4 ans, `3` = 5–10 ans, `4` = plus de 10 ans.

-----

## 8. Migration 06 — `recruiter_profiles`

**Profil de l’entreprise recruteur.** Relation `1-1` avec `users`.

|Colonne         |Type           |Contraintes                      |Description             |
|----------------|---------------|---------------------------------|------------------------|
|`id`            |`uuid`|PK                               |                        |
|`user_id`       |`foreignId`    |NOT NULL, UNIQUE, FK → `users.id`|Un recruteur = un profil|
|`company_name`  |`string`       |NOT NULL                         |Nom de l’entreprise     |
|`company_sector`|`string`       |nullable                         |Secteur d’activité      |
|`phone`         |`string`       |nullable                         |Téléphone de contact    |
|`city`          |`string`       |nullable                         |Ville du siège          |
|`country`       |`string`       |NOT NULL, défaut `Cameroun`      |Pays                    |
|`created_at`    |`timestamp`    |nullable                         |                        |
|`updated_at`    |`timestamp`    |nullable                         |                        |

**Relations Eloquent :**

- `belongsTo(User::class)` — via `user_id`
- `hasMany(JobOffer::class)` — offres publiées

-----

## 9. Migration 07 — `candidate_skills`

**Table pivot enrichie** entre un profil candidat et une compétence. Enrichie car elle porte une donnée propre : le `level` déclaré.

|Colonne               |Type           |Contraintes                           |Description               |
|----------------------|---------------|--------------------------------------|--------------------------|
|`id`                  |`id`|PK                                    |                          |
|`candidate_profile_id`|`foreignId`    |NOT NULL, FK → `candidate_profiles.id`|                          |
|`skill_id`            |`foreignId`    |NOT NULL, FK → `skills.id`            |                          |
|`level`               |`tinyInteger`  |NOT NULL                              |Niveau déclaré : `1` à `5`|
|`created_at`          |`timestamp`    |nullable                              |                          |
|`updated_at`          |`timestamp`    |nullable                              |                          |

**Contrainte d’unicité :** `unique(['candidate_profile_id', 'skill_id'])` — un candidat ne peut déclarer qu’un seul niveau par compétence.

**Relations Eloquent :**

- `belongsTo(CandidateProfile::class)`
- `belongsTo(Skill::class)`

> Ce n’est pas une simple table pivot `belongsToMany` — elle porte la colonne `level`, ce qui en fait un Model Eloquent à part entière.

-----

## 10. Migration 08 — `job_offers`

**Table centrale du côté recruteur.** Porte à la fois les données descriptives, les critères bloquants, les exigences scorées, et les atouts recherchés.

|Colonne                   |Type           |Contraintes                           |Description                                                                     |
|--------------------------|---------------|--------------------------------------|--------------------------------------------------------------------------------|
|`id`                      |`uuid`|PK                                    |                                                                                |
|`recruiter_profile_id`    |`foreignId`    |NOT NULL, FK → `recruiter_profiles.id`|                                                                                |
|`title`                   |`string`       |NOT NULL                              |Intitulé du poste                                                               |
|`description`             |`text`         |NOT NULL                              |Description libre — peut préciser les détails du permis, etc.                   |
|`template`                |`enum`         |NOT NULL                              |Valeurs : `manoeuvre`, `technicien`, `agent`, `cadre`, `dirigeant`              |
|`city`                    |`string`       |NOT NULL                              |Ville du poste                                                                  |
|`region`                  |`string`       |nullable                              |Région                                                                          |
|`country`                 |`string`       |NOT NULL, défaut `Cameroun`           |Pays                                                                            |
|**— Critères bloquants —**|               |                                      |`nullable` = non bloquant. Une valeur = éliminatoire.                           |
|`blocking_language`       |`enum`         |nullable                              |Valeurs : `francophone`, `anglophone`, `bilingue`                               |
|`blocking_education`      |`enum`         |nullable                              |Valeurs : `none`, `cepc`, `bepc`, `bac`, `bts`, `licence`, `master`, `doctorat` |
|`blocking_experience`     |`enum`         |nullable                              |Valeurs : `0`, `1`, `2`, `3`, `4`                                               |
|`blocking_availability`   |`enum`         |nullable                              |Valeurs : `immediate`, `15_days`, `30_days`, `more`                             |
|`blocking_permit`         |`enum`         |nullable                              |Valeurs : `permis_A`, `permis_B`, `permis_C`, `permis_D`, `permis_ABCD`         |
|**— Exigences scorées —** |               |                                      |Utilisées pour le calcul du score principal (Couche 2)                          |
|`required_experience`     |`enum`         |NOT NULL                              |Paliers : `0`, `1`, `2`, `3`, `4`                                               |
|`required_education`      |`enum`         |NOT NULL                              |Niveaux : `none`…`doctorat`                                                     |
|`required_availability`   |`enum`         |NOT NULL                              |`immediate`, `15_days`, `30_days`, `more`                                       |
|`budget_min`              |`integer`      |nullable                              |Budget minimum en FCFA                                                          |
|`budget_max`              |`integer`      |nullable                              |Budget maximum en FCFA                                                          |
|**— Atouts recherchés —** |               |                                      |Couche 3 — informatif uniquement                                                |
|`required_assets`         |`json`         |nullable                              |Ex : `[{"asset_id": 3, "priority": "high"}, {"asset_id": 7, "priority": "low"}]`|
|**— Cycle de vie —**      |               |                                      |                                                                                |
|`status`                  |`enum`         |NOT NULL, défaut `draft`              |Valeurs : `draft`, `published`, `closed`, `archived`                            |
|`published_at`            |`timestamp`    |nullable                              |Date de première publication                                                    |
|`expires_at`              |`timestamp`    |nullable                              |Date de clôture automatique. `null` = pas de limite fixée                       |
|`created_at`              |`timestamp`    |nullable                              |                                                                                |
|`updated_at`              |`timestamp`    |nullable                              |                                                                                |
|`deleted_at`              |`timestamp`    |nullable                              |Généré par `softDeletes()`                                                      |

**Relations Eloquent :**

- `belongsTo(RecruiterProfile::class)`
- `hasMany(JobRequiredSkill::class)`
- `hasMany(MatchResult::class)`

> Le moteur de matching n’interroge que les offres avec `status = published` ET `(expires_at IS NULL OR expires_at > NOW())`. Le batch nocturne passe automatiquement en `closed` les offres dont `expires_at` est dépassé.

-----

## 11. Migration 09 — `job_required_skills`

**Compétences requises par une offre**, avec le niveau attendu. Même logique que `candidate_skills` — table enrichie, pas une simple pivot.

|Colonne         |Type           |Contraintes                   |Description                                                       |
|----------------|---------------|------------------------------|------------------------------------------------------------------|
|`id`            |`id`|PK                            |                                                                  |
|`job_offer_id`  |`foreignId`    |NOT NULL, FK → `job_offers.id`|                                                                  |
|`skill_id`      |`foreignId`    |NOT NULL, FK → `skills.id`    |                                                                  |
|`level_required`|`tinyInteger`  |NOT NULL                      |Niveau attendu : `1` à `5` — utilisé dans la formule exponentielle|
|`created_at`    |`timestamp`    |nullable                      |                                                                  |
|`updated_at`    |`timestamp`    |nullable                      |                                                                  |

**Contrainte d’unicité :** `unique(['job_offer_id', 'skill_id'])` — une compétence ne peut être exigée qu’une fois par offre.

**Relations Eloquent :**

- `belongsTo(JobOffer::class)`
- `belongsTo(Skill::class)`

-----

## 12. Migration 10 — `match_results`

**Table de cache du moteur de matching.** Stocke le résultat calculé pour chaque paire `candidat ↔ offre`. Jamais recalculé inutilement grâce au système `is_stale`.

|Colonne               |Type           |Contraintes                           |Description                                                                      |
|----------------------|---------------|--------------------------------------|---------------------------------------------------------------------------------|
|`id`                  |`id`|PK                                    |                                                                                 |
|`job_offer_id`        |`foreignId`    |NOT NULL, FK → `job_offers.id`        |                                                                                 |
|`candidate_profile_id`|`foreignId`    |NOT NULL, FK → `candidate_profiles.id`|                                                                                 |
|`passed_blocking`     |`boolean`      |NOT NULL                              |`true` = a passé tous les critères bloquants                                     |
|`score_skills`        |`decimal(5,2)` |nullable                              |Score du bloc Compétences (0.00 à 100.00)                                        |
|`score_experience`    |`decimal(5,2)` |nullable                              |Score du bloc Expérience                                                         |
|`score_education`     |`decimal(5,2)` |nullable                              |Score du bloc Formation                                                          |
|`score_availability`  |`decimal(5,2)` |nullable                              |Score du bloc Disponibilité                                                      |
|`score_location`      |`decimal(5,2)` |nullable                              |Score du bloc Localisation                                                       |
|`score_salary`        |`decimal(5,2)` |nullable                              |Score du bloc Salaire (`null` si bloc ignoré)                                    |
|`score_principal`     |`decimal(5,2)` |nullable                              |Score agrégé final (0.00 à 100.00)                                               |
|`assets_matched`      |`json`         |nullable                              |Ex : `[{"asset_id": 3, "matched": true}, {"asset_id": 7, "matched": false}]`     |
|`extra_skills`        |`json`         |nullable                              |Ex : `[4, 9]` — skill_ids présents chez le candidat mais non demandés par l’offre|
|`is_stale`            |`boolean`      |NOT NULL, défaut `false`              |`true` = score obsolète, recalcul requis                                         |
|`calculated_at`       |`timestamp`    |NOT NULL                              |Horodatage du dernier calcul                                                     |

**Contrainte d’unicité :** `unique(['job_offer_id', 'candidate_profile_id'])` — une seule entrée par paire.

**Relations Eloquent :**

- `belongsTo(JobOffer::class)`
- `belongsTo(CandidateProfile::class)`
- `hasOne(Application::class)`

> **Système is_stale :** un Observer Laravel passe `is_stale = true` sur tous les `match_results` concernés dès qu’un `CandidateProfile` ou un `JobOffer` est modifié. Le recalcul s’effectue à deux niveaux : à la demande lors de la consultation, et en batch nocturne via un Job Laravel pour maintenir la cohérence globale.

-----

## 13. Migration 11 — `applications`

**Candidature formelle** d’un candidat à une offre. Ne peut exister sans un `match_result` préalable — la candidature est toujours post-matching.

|Colonne          |Type           |Contraintes                              |Description                                                      |
|-----------------|---------------|-----------------------------------------|-----------------------------------------------------------------|
|`id`             |`id`|PK                                       |                                                                 |
|`match_result_id`|`foreignId`    |NOT NULL, UNIQUE, FK → `match_results.id`|Une candidature par résultat de matching                         |
|`status`         |`enum`         |NOT NULL, défaut `pending`               |Valeurs : `pending`, `viewed`, `shortlisted`, `rejected`, `hired`|
|`applied_at`     |`timestamp`    |NOT NULL                                 |Date de soumission de la candidature                             |
|`created_at`     |`timestamp`    |nullable                                 |                                                                 |
|`updated_at`     |`timestamp`    |nullable                                 |                                                                 |

**Relations Eloquent :**

- `belongsTo(MatchResult::class)`

> L’unicité sur `match_result_id` garantit qu’un candidat ne peut postuler qu’une seule fois à une offre donnée.

-----

## 14. Récapitulatif des enums

|Table               |Colonne                |Valeurs possibles                                                    |
|--------------------|-----------------------|---------------------------------------------------------------------|
|`candidate_profiles`|`language_profile`     |`francophone`, `anglophone`, `bilingue`                              |
|`candidate_profiles`|`availability`         |`immediate`, `15_days`, `30_days`, `more`                            |
|`candidate_profiles`|`experience_tier`      |`0`, `1`, `2`, `3`, `4`                                              |
|`candidate_profiles`|`education_level`      |`none`, `cepc`, `bepc`, `bac`, `bts`, `licence`, `master`, `doctorat`|
|`assets`            |`category`             |`sectoriel`, `certification`, `contextuel`, `langue_supp`            |
|`job_offers`        |`template`             |`manoeuvre`, `technicien`, `agent`, `cadre`, `dirigeant`             |
|`job_offers`        |`blocking_language`    |`francophone`, `anglophone`, `bilingue`                              |
|`job_offers`        |`blocking_education`   |`none`, `cepc`, `bepc`, `bac`, `bts`, `licence`, `master`, `doctorat`|
|`job_offers`        |`blocking_experience`  |`0`, `1`, `2`, `3`, `4`                                              |
|`job_offers`        |`blocking_availability`|`immediate`, `15_days`, `30_days`, `more`                            |
|`job_offers`        |`blocking_permit`      |`permis_A`, `permis_B`, `permis_C`, `permis_D`, `permis_ABCD`        |
|`job_offers`        |`required_experience`  |`0`, `1`, `2`, `3`, `4`                                              |
|`job_offers`        |`required_education`   |`none`, `cepc`, `bepc`, `bac`, `bts`, `licence`, `master`, `doctorat`|
|`job_offers`        |`required_availability`|`immediate`, `15_days`, `30_days`, `more`                            |
|`job_offers`        |`status`               |`draft`, `published`, `closed`, `archived`                           |
|`applications`      |`status`               |`pending`, `viewed`, `shortlisted`, `rejected`, `hired`              |

-----

## 15. Récapitulatif des relations Eloquent

|Model             |Relation                 |Type       |Via                   |
|------------------|-------------------------|-----------|----------------------|
|`User`            |`CandidateProfile`       |`hasOne`   |`user_id`             |
|`User`            |`RecruiterProfile`       |`hasOne`   |`user_id`             |
|`CandidateProfile`|`User`                   |`belongsTo`|`user_id`             |
|`CandidateProfile`|`CandidateSkill`         |`hasMany`  |`candidate_profile_id`|
|`CandidateProfile`|`MatchResult`            |`hasMany`  |`candidate_profile_id`|
|`RecruiterProfile`|`User`                   |`belongsTo`|`user_id`             |
|`RecruiterProfile`|`JobOffer`               |`hasMany`  |`recruiter_profile_id`|
|`CandidateSkill`  |`CandidateProfile`       |`belongsTo`|`candidate_profile_id`|
|`CandidateSkill`  |`Skill`                  |`belongsTo`|`skill_id`            |
|`Skill`           |`CandidateSkill`         |`hasMany`  |`skill_id`            |
|`Skill`           |`JobRequiredSkill`       |`hasMany`  |`skill_id`            |
|`Asset`           |*(relation logique JSON)*|—          |`asset_id` dans JSON  |
|`JobOffer`        |`RecruiterProfile`       |`belongsTo`|`recruiter_profile_id`|
|`JobOffer`        |`JobRequiredSkill`       |`hasMany`  |`job_offer_id`        |
|`JobOffer`        |`MatchResult`            |`hasMany`  |`job_offer_id`        |
|`JobRequiredSkill`|`JobOffer`               |`belongsTo`|`job_offer_id`        |
|`JobRequiredSkill`|`Skill`                  |`belongsTo`|`skill_id`            |
|`MatchResult`     |`JobOffer`               |`belongsTo`|`job_offer_id`        |
|`MatchResult`     |`CandidateProfile`       |`belongsTo`|`candidate_profile_id`|
|`MatchResult`     |`Application`            |`hasOne`   |`match_result_id`     |
|`Application`     |`MatchResult`            |`belongsTo`|`match_result_id`     |

-----

*MatchRH — Document confidentiel — Usage interne — Juin 2026*
