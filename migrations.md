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
1. [Migration 12 — passkeys](#14-migration-12--passkeys)
1. [Migration 13 — reports](#15-migration-13--reports)
1. [Migration 14 — testimonials](#16-migration-14--testimonials)
1. [Migration 15 — faqs](#17-migration-15--faqs)
1. [Récapitulatif des enums](#18-récapitulatif-des-enums)
1. [Récapitulatif des relations Eloquent](#19-récapitulatif-des-relations-eloquent)

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
12 → passkeys                    dépend de : users
13 → reports                     dépend de : users (reporter, reviewer), polymorphique
14 → testimonials                dépend de : users
15 → faqs                        dépend de : users
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

users (1) ─── (N) passkeys
users (1) ─── (N) testimonials
users (1) ─── (N) faqs
users (1) ─── (N) reports (en tant que reporter ou reviewer)

reports (N) ─── (1) reportable (Morph: JobOffer ou CandidateProfile)

skills  (1) ──── (N) candidate_skills
skills  (1) ──── (N) job_required_skills

assets  ← référencés uniquement dans le JSON required_assets de job_offers
          et dans le JSON assets_matched de match_results
          (pas de FK directe — relation logique par asset_id)
```

-----

## 3. Migration 01 — `users`

**Table standard Laravel enrichie.**

|Colonne            |Type           |Contraintes     |Description                             |
|-------------------|---------------|----------------|----------------------------------------|
|`id`               |`id`           |PK              |Identifiant auto-incrémenté             |
|`name`             |`string`       |NOT NULL        |Nom complet de l’utilisateur            |
|`email`            |`string`       |NOT NULL, UNIQUE|Adresse email — identifiant de connexion|
|`role`             |`string`       |NOT NULL        |Rôle principal (Enum: recruiter, candidate, admin)|
|`agree`            |`boolean`      |défaut `false`  |Acceptation des CGU                     |
|`agreed_at`        |`timestamp`    |nullable        |Date d'acceptation des CGU              |
|`updates`          |`boolean`      |nullable        |Souhaite recevoir des mises à jour      |
|`email_verified_at`|`timestamp`    |nullable        |Date de vérification de l’email         |
|`password`         |`string`       |NOT NULL        |Mot de passe hashé (bcrypt)             |
|`two_factor_secret`|`text`         |nullable        |Secret 2FA                              |
|`two_factor_recovery_codes`|`text` |nullable        |Codes de récupération 2FA               |
|`two_factor_confirmed_at`|`timestamp`|nullable      |Date de confirmation 2FA                |
|`remember_token`   |`string(100)`  |nullable        |Token de session persistante            |
|`created_at`       |`timestamp`    |nullable        |Généré par `timestamps()`               |
|`updated_at`       |`timestamp`    |nullable        |Généré par `timestamps()`               |

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

-----

## 5. Migration 03 — `skills`

**Bibliothèque de compétences de la plateforme.**

|Colonne     |Type           |Contraintes            |Description                                                              |
|------------|---------------|-----------------------|-------------------------------------------------------------------------|
|`id`        |`id`           |PK                     |                                                                         |
|`name`      |`string`       |NOT NULL               |Nom de la compétence : `Laravel`, `PHP`, `Excel`, `Sage Paie`…           |
|`category`  |`string`       |NOT NULL               |Catégorie : `developpement`, `comptabilite`, `rh`, `vente`, `logistique`…|
|`is_active` |`boolean`      |NOT NULL, défaut `true`|Soft désactivation — jamais de suppression physique                      |
|`created_at`|`timestamp`    |nullable               |                                                                         |
|`updated_at`|`timestamp`    |nullable               |                                                                         |

-----

## 6. Migration 04 — `assets`

**Bibliothèque des atouts (Couche 3).**

|Colonne     |Type           |Contraintes            |Description                                                         |
|------------|---------------|-----------------------|--------------------------------------------------------------------|
|`id`        |`id`           |PK                     |                                                                    |
|`name`      |`string`       |NOT NULL               |Ex : `Expérience BTP`, `Certification PMP`, `Expérience télétravail`|
|`category`  |`enum`         |NOT NULL               |Valeurs : `sectoriel`, `certification`, `contextuel`, `langue_supp` |
|`is_active` |`boolean`      |NOT NULL, défaut `true`|Soft désactivation — jamais de suppression physique                 |
|`created_at`|`timestamp`    |nullable               |                                                                    |
|`updated_at`|`timestamp`    |nullable               |                                                                    |

-----

## 7. Migration 05 — `candidate_profiles`

**Profil déclaratif du candidat.** Relation `1-1` avec `users`.

|Colonne           |Type           |Contraintes                      |Description                                                                    |
|------------------|---------------|---------------------------------|-------------------------------------------------------------------------------|
|`id`              |`uuid`         |PK                               |                                                                               |
|`user_id`         |`foreignId`    |NOT NULL, UNIQUE, FK → `users.id`|Un candidat = un profil                                                        |
|`phone`           |`string`       |nullable                         |Numéro de téléphone                                                            |
|`city`            |`string`       |nullable                         |Ville de résidence                                                             |
|`region`          |`string`       |nullable                         |Région de résidence                                                            |
|`country`         |`string`       |NOT NULL, défaut `Cameroun`      |Pays de résidence                                                              |
|`language_profile`|`string` (enum)|NOT NULL                         |Valeurs : `francophone`, `anglophone`, `bilingue`                              |
|`availability`    |`string` (enum)|NOT NULL                         |Valeurs : `immediate`, `15_days`, `30_days`, `more`                            |
|`experience_tier` |`string` (enum)|NOT NULL                         |Valeurs : `0`, `1`, `2`, `3`, `4`                                              |
|`education_level` |`string` (enum)|NOT NULL                         |Valeurs : `none`, `cepc`, `bepc`, `bac`, `bts`, `licence`, `master`, `doctorat`|
|`education_field` |`string`       |nullable                         |Domaine d’études                                                               |
|`salary_min`      |`integer`      |nullable                         |Prétention minimale en FCFA                                                    |
|`salary_max`      |`integer`      |nullable                         |Prétention maximale en FCFA                                                    |
|`cv_path`         |`string`       |nullable                         |Chemin vers le fichier CV uploadé                                              |
|`is_suspended`    |`boolean`      |défaut `false`                  |Si le profil est suspendu                                                      |
|`suspended_at`    |`timestamp`    |nullable                         |Date de suspension                                                             |
|`created_at`      |`timestamp`    |nullable                         |                                                                               |
|`updated_at`      |`timestamp`    |nullable                         |                                                                               |

-----

## 8. Migration 06 — `recruiter_profiles`

**Profil de l’entreprise recruteur.** Relation `1-1` avec `users`.

|Colonne         |Type           |Contraintes                      |Description             |
|----------------|---------------|---------------------------------|------------------------|
|`id`            |`uuid`         |PK                               |                        |
|`user_id`       |`foreignId`    |NOT NULL, UNIQUE, FK → `users.id`|Un recruteur = un profil|
|`company_name`  |`string`       |NOT NULL                         |Nom de l’entreprise     |
|`company_sector`|`string`       |nullable                         |Secteur d’activité      |
|`phone`         |`string`       |nullable                         |Téléphone de contact    |
|`city`          |`string`       |nullable                         |Ville du siège          |
|`country`       |`string`       |NOT NULL, défaut `Cameroun`      |Pays                    |
|`is_managed_by` |`foreignId`    |nullable, FK → `users.id`        |Gestionnaire du compte  |
|`is_suspended`  |`boolean`      |défaut `false`                  |Si le profil est suspendu|
|`suspended_at`  |`timestamp`    |nullable                         |Date de suspension      |
|`created_at`    |`timestamp`    |nullable                         |                        |
|`updated_at`    |`timestamp`    |nullable                         |                        |

-----

## 9. Migration 07 — `candidate_skills`

**Table pivot enrichie** entre un profil candidat et une compétence.

|Colonne               |Type           |Contraintes                           |Description               |
|----------------------|---------------|--------------------------------------|--------------------------|
|`id`                  |`id`           |PK                                    |                          |
|`candidate_profile_id`|`foreignUuid`  |NOT NULL, FK → `candidate_profiles.id`|                          |
|`skill_id`            |`foreignId`    |NOT NULL, FK → `skills.id`            |                          |
|`level`               |`tinyInteger`  |NOT NULL                              |Niveau déclaré : `1` à `5`|
|`created_at`          |`timestamp`    |nullable                              |                          |
|`updated_at`          |`timestamp`    |nullable                              |                          |

-----

## 10. Migration 08 — `job_offers`

**Table centrale du côté recruteur.**

|Colonne                   |Type           |Contraintes                           |Description                                                                     |
|--------------------------|---------------|--------------------------------------|--------------------------------------------------------------------------------|
|`id`                      |`uuid`         |PK                                    |                                                                                |
|`recruiter_profile_id`    |`foreignUuid`  |NOT NULL, FK → `recruiter_profiles.id`|                                                                                |
|`title`                   |`string`       |NOT NULL                              |Intitulé du poste                                                               |
|`description`             |`text`         |NOT NULL                              |Description libre                                                               |
|`template`                |`string` (enum)|NOT NULL                              |Valeurs : `manoeuvre`, `technicien`, `agent`, `cadre`, `dirigeant`              |
|`city`                    |`string`       |NOT NULL                              |Ville du poste                                                                  |
|`region`                  |`string`       |nullable                              |Région                                                                          |
|`country`                 |`string`       |NOT NULL, défaut `Cameroun`           |Pays                                                                            |
|**— Critères bloquants —**|               |                                      |                                                                                |
|`blocking_language`       |`string` (enum)|nullable                              |Valeurs : `francophone`, `anglophone`, `bilingue`                               |
|`blocking_education`      |`string` (enum)|nullable                              |Valeurs : `none`…`doctorat`                                                     |
|`blocking_experience`     |`string` (enum)|nullable                              |Valeurs : `0`, `1`, `2`, `3`, `4`                                               |
|`blocking_availability`   |`string` (enum)|nullable                              |Valeurs : `immediate`, `15_days`, `30_days`, `more`                             |
|`blocking_permit`         |`string` (enum)|nullable                              |Valeurs : `permis_A`, `permis_B`, `permis_C`, `permis_D`, `permis_ABCD`         |
|**— Exigences scorées —** |               |                                      |                                                                                |
|`required_experience`     |`string` (enum)|NOT NULL                              |Paliers : `0`, `1`, `2`, `3`, `4`                                               |
|`required_education`      |`string` (enum)|NOT NULL                              |Niveaux : `none`…`doctorat`                                                     |
|`required_availability`   |`string` (enum)|NOT NULL                              |`immediate`, `15_days`, `30_days`, `more`                                       |
|`budget_min`              |`integer`      |nullable                              |Budget minimum en FCFA                                                          |
|`budget_max`              |`integer`      |nullable                              |Budget maximum en FCFA                                                          |
|**— Atouts recherchés —** |               |                                      |                                                                                |
|`required_assets`         |`json`         |nullable                              |Ex : `[{"asset_id": 3, "priority": "high"}]`                                    |
|**— Cycle de vie —**      |               |                                      |                                                                                |
|`status`                  |`string` (enum)|NOT NULL, défaut `draft`              |Valeurs : `draft`, `published`, `closed`, `archived`                            |
|`published_at`            |`timestamp`    |nullable                              |Date de première publication                                                    |
|`expires_at`              |`timestamp`    |nullable                              |Date de clôture automatique                                                     |
|`created_at`              |`timestamp`    |nullable                              |                                                                                |
|`updated_at`              |`timestamp`    |nullable                              |                                                                                |
|`deleted_at`              |`timestamp`    |nullable                              |Soft Delete                                                                     |

-----

## 11. Migration 09 — `job_required_skills`

**Compétences requises par une offre.**

|Colonne         |Type           |Contraintes                   |Description                                                       |
|----------------|---------------|------------------------------|------------------------------------------------------------------|
|`id`            |`id`           |PK                            |                                                                  |
|`job_offer_id`  |`foreignUuid`  |NOT NULL, FK → `job_offers.id`|                                                                  |
|`skill_id`      |`foreignId`    |NOT NULL, FK → `skills.id`    |                                                                  |
|`level_required`|`tinyInteger`  |NOT NULL                      |Niveau attendu : `1` à `5`                                        |
|`created_at`    |`timestamp`    |nullable                      |                                                                  |
|`updated_at`    |`timestamp`    |nullable                      |                                                                  |

-----

## 12. Migration 10 — `match_results`

**Table de cache du moteur de matching.**

|Colonne               |Type           |Contraintes                           |Description                                                                      |
|----------------------|---------------|--------------------------------------|---------------------------------------------------------------------------------|
|`id`                  |`id`           |PK                                    |                                                                                 |
|`job_offer_id`        |`foreignUuid`  |NOT NULL, FK → `job_offers.id`        |                                                                                 |
|`candidate_profile_id`|`foreignUuid`  |NOT NULL, FK → `candidate_profiles.id`|                                                                                 |
|`passed_blocking`     |`boolean`      |NOT NULL, index                       |`true` = a passé tous les critères bloquants                                     |
|`score_skills`        |`decimal(5,2)` |nullable                              |Score Compétences                                                                |
|`score_experience`    |`decimal(5,2)` |nullable                              |Score Expérience                                                                 |
|`score_education`     |`decimal(5,2)` |nullable                              |Score Formation                                                                  |
|`score_availability`  |`decimal(5,2)` |nullable                              |Score Disponibilité                                                              |
|`score_location`      |`decimal(5,2)` |nullable                              |Score Localisation                                                               |
|`score_salary`        |`decimal(5,2)` |nullable                              |Score Salaire                                                                    |
|`score_principal`     |`decimal(5,2)` |nullable, index                       |Score agrégé final                                                               |
|`assets_matched`      |`json`         |nullable                              |                                                                                 |
|`extra_skills`        |`json`         |nullable                              |                                                                                 |
|`is_stale`            |`boolean`      |NOT NULL, défaut `false`, index       |`true` = recalcul requis                                                         |
|`calculated_at`       |`timestamp`    |NOT NULL                              |Horodatage du dernier calcul                                                     |

-----

## 13. Migration 11 — `applications`

**Candidature formelle.**

|Colonne          |Type           |Contraintes                              |Description                                                      |
|-----------------|---------------|-----------------------------------------|-----------------------------------------------------------------|
|`id`             |`id`           |PK                                       |                                                                 |
|`match_result_id`|`foreignId`    |NOT NULL, UNIQUE, FK → `match_results.id`|Une candidature par résultat de matching                         |
|`status`         |`string` (enum)|NOT NULL, défaut `pending`, index        |Valeurs : `pending`, `viewed`, `shortlisted`, `rejected`, `hired`|
|`applied_at`     |`timestamp`    |NOT NULL                                 |Date de soumission                                               |
|`created_at`     |`timestamp`    |nullable                                 |                                                                 |
|`updated_at`     |`timestamp`    |nullable                                 |                                                                 |

-----

## 14. Migration 12 — `passkeys`

**Gestion des clés de sécurité (WebAuthn).**

|Colonne         |Type           |Contraintes                      |Description             |
|----------------|---------------|---------------------------------|------------------------|
|`id`            |`id`           |PK                               |                        |
|`user_id`       |`foreignId`    |NOT NULL, FK → `users.id`        |Propriétaire de la clé  |
|`name`          |`string`       |NOT NULL                         |Nom donné à la clé      |
|`credential_id` |`string`       |NOT NULL, UNIQUE                 |ID technique WebAuthn   |
|`credential`    |`json`         |NOT NULL                         |Données de la clé       |
|`last_used_at`  |`timestamp`    |nullable                         |Dernière utilisation    |
|`created_at`    |`timestamp`    |nullable                         |                        |
|`updated_at`    |`timestamp`    |nullable                         |                        |

-----

## 15. Migration 13 — `reports`

**Signalements de contenus (Polymorphique).**

|Colonne         |Type           |Contraintes                      |Description                       |
|----------------|---------------|---------------------------------|----------------------------------|
|`id`            |`id`           |PK                               |                                  |
|`reporter_id`   |`foreignId`    |NOT NULL, FK → `users.id`        |Celui qui signale                 |
|`reportable_id` |`unsignedBigInt`|NOT NULL                         |ID du contenu (JobOffer/Candidate)|
|`reportable_type`|`string`      |NOT NULL                         |Type du contenu                   |
|`reason`        |`string` (enum)|NOT NULL                         |Raison du signalement             |
|`comment`       |`text`         |nullable                         |Commentaire libre                 |
|`status`        |`string` (enum)|NOT NULL, défaut `pending`       |Statut du signalement             |
|`reviewed_by`   |`foreignId`    |nullable, FK → `users.id`        |Administrateur ayant examiné      |
|`reviewed_at`   |`timestamp`    |nullable                         |Date de l'examen                  |
|`created_at`    |`timestamp`    |nullable                         |                                  |
|`updated_at`    |`timestamp`    |nullable                         |                                  |

-----

## 16. Migration 14 — `testimonials`

**Témoignages utilisateurs.**

|Colonne         |Type           |Contraintes                      |Description             |
|----------------|---------------|---------------------------------|------------------------|
|`id`            |`id`           |PK                               |                        |
|`user_id`       |`foreignId`    |nullable, FK → `users.id`        |Auteur du témoignage    |
|`content`       |`text`         |NOT NULL                         |Contenu du message      |
|`rating`        |`integer`      |défaut `5`                       |Note (1 à 5)            |
|`status`        |`string` (enum)|NOT NULL, défaut `pending`       |Statut de validation    |
|`author_name`   |`string`       |nullable                         |Nom de l'auteur (si hors plateforme)|
|`author_role`   |`string`       |nullable                         |Rôle de l'auteur        |
|`author_company`|`string`       |nullable                         |Entreprise de l'auteur  |
|`author_color`  |`string`       |nullable                         |Couleur de l'avatar     |
|`author_badge`  |`string`       |nullable                         |Badge affiché           |
|`created_at`    |`timestamp`    |nullable                         |                        |
|`updated_at`    |`timestamp`    |nullable                         |                        |

-----

## 17. Migration 15 — `faqs`

**Questions posées par les utilisateurs.**

|Colonne         |Type           |Contraintes                      |Description             |
|----------------|---------------|---------------------------------|------------------------|
|`id`            |`id`           |PK                               |                        |
|`user_id`       |`foreignId`    |nullable, FK → `users.id`        |Auteur si connecté      |
|`email`         |`string`       |NOT NULL                         |Email de contact        |
|`question`      |`string(200)`  |NOT NULL                         |La question posée       |
|`answer`        |`string(500)`  |nullable                         |La réponse apportée     |
|`status`        |`string` (enum)|NOT NULL, défaut `pending`       |Statut du traitement    |
|`reviewed_by`   |`foreignId`    |nullable, FK → `users.id`        |Admin ayant répondu     |
|`reviewed_at`   |`timestamp`    |nullable                         |Date de réponse         |
|`created_at`    |`timestamp`    |nullable                         |                        |
|`updated_at`    |`timestamp`    |nullable                         |                        |

-----

## 18. Récapitulatif des enums

|Table               |Colonne                |Valeurs possibles                                                    |
|--------------------|-----------------------|---------------------------------------------------------------------|
|`users`             |`role`                 |`recruiter`, `candidate`, `admin`                                    |
|`candidate_profiles`|`language_profile`     |`francophone`, `anglophone`, `bilingue`                              |
|`candidate_profiles`|`availability`         |`immediate`, `15_days`, `30_days`, `more`                            |
|`candidate_profiles`|`experience_tier`      |`0`, `1`, `2`, `3`, `4`                                              |
|`candidate_profiles`|`education_level`      |`none`, `cepc`, `bepc`, `bac`, `bts`, `licence`, `master`, `doctorat`|
|`assets`            |`category`             |`sectoriel`, `certification`, `contextuel`, `langue_supp`            |
|`job_offers`        |`template`             |`manoeuvre`, `technicien`, `agent`, `cadre`, `dirigeant`             |
|`job_offers`        |`blocking_language`    |`francophone`, `anglophone`, `bilingue`                              |
|`job_offers`        |`blocking_education`   |`none`…`doctorat`                                                     |
|`job_offers`        |`blocking_experience`  |`0`, `1`, `2`, `3`, `4`                                              |
|`job_offers`        |`blocking_availability`|`immediate`, `15_days`, `30_days`, `more`                             |
|`job_offers`        |`blocking_permit`      |`permis_A`, `permis_B`, `permis_C`, `permis_D`, `permis_ABCD`        |
|`job_offers`        |`required_experience`  |`0`, `1`, `2`, `3`, `4`                                              |
|`job_offers`        |`required_education`   |`none`…`doctorat`                                                     |
|`job_offers`        |`required_availability`|`immediate`, `15_days`, `30_days`, `more`                            |
|`job_offers`        |`status`               |`draft`, `published`, `closed`, `archived`                           |
|`applications`      |`status`               |`pending`, `viewed`, `shortlisted`, `rejected`, `hired`              |
|`reports`           |`reason`               |`fake_offer`, `misleading`, `discriminatory`, `suspicious_contact`, `duplicate`, `false_info`, `inappropriate`, `identity_theft`, `spam`|
|`reports`           |`status`               |`pending`, `reviewed`, `dismissed`, `confirmed`                      |
|`testimonials`      |`status`               |`pending`, `approved`, `rejected`                                    |
|`faqs`              |`status`               |`pending`, `reviewed`, `dismissed`, `confirmed`                      |

-----

## 19. Récapitulatif des relations Eloquent

|Model             |Relation                 |Type       |Via                   |
|------------------|-------------------------|-----------|----------------------|
|`User`            |`CandidateProfile`       |`hasOne`   |`user_id`             |
|`User`            |`RecruiterProfile`       |`hasOne`   |`user_id`             |
|`User`            |`Passkeys`               |`hasMany`  |`user_id`             |
|`User`            |`Testimonials`           |`hasMany`  |`user_id`             |
|`CandidateProfile`|`User`                   |`belongsTo`|`user_id`             |
|`CandidateProfile`|`CandidateSkill`         |`hasMany`  |`candidate_profile_id`|
|`CandidateProfile`|`MatchResult`            |`hasMany`  |`candidate_profile_id`|
|`CandidateProfile`|`Reports`                |`morphMany`|`reportable`          |
|`RecruiterProfile`|`User`                   |`belongsTo`|`user_id`             |
|`RecruiterProfile`|`JobOffer`               |`hasMany`  |`recruiter_profile_id`|
|`RecruiterProfile`|`Manager`                |`belongsTo`|`is_managed_by` (User)|
|`CandidateSkill`  |`CandidateProfile`       |`belongsTo`|`candidate_profile_id`|
|`CandidateSkill`  |`Skill`                  |`belongsTo`|`skill_id`            |
|`Skill`           |`CandidateSkill`         |`hasMany`  |`skill_id`            |
|`Skill`           |`JobRequiredSkill`       |`hasMany`  |`skill_id`            |
|`JobOffer`        |`RecruiterProfile`       |`belongsTo`|`recruiter_profile_id`|
|`JobOffer`        |`JobRequiredSkill`       |`hasMany`  |`job_offer_id`        |
|`JobOffer`        |`MatchResult`            |`hasMany`  |`job_offer_id`        |
|`JobOffer`        |`Reports`                |`morphMany`|`reportable`          |
|`JobRequiredSkill`|`JobOffer`               |`belongsTo`|`job_offer_id`        |
|`JobRequiredSkill`|`Skill`                  |`belongsTo`|`skill_id`            |
|`MatchResult`     |`JobOffer`               |`belongsTo`|`job_offer_id`        |
|`MatchResult`     |`CandidateProfile`       |`belongsTo`|`candidate_profile_id`|
|`MatchResult`     |`Application`            |`hasOne`   |`match_result_id`     |
|`Application`     |`MatchResult`            |`belongsTo`|`match_result_id`     |
|`Report`          |`Reporter`               |`belongsTo`|`reporter_id` (User)  |
|`Report`          |`Reviewer`               |`belongsTo`|`reviewed_by` (User)  |
|`Report`          |`Reportable`             |`morphTo`  |                      |
|`Testimonial`     |`User`                   |`belongsTo`|`user_id`             |
|`Faq`             |`User`                   |`belongsTo`|`user_id`             |
|`Faq`             |`Reviewer`               |`belongsTo`|`reviewed_by` (User)  |

-----

*MatchRH — Document confidentiel — Usage interne — Juin 2026*
