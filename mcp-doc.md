# Intégration MCP MatchRH

Ce document explique comment utiliser le serveur MCP (Model Context Protocol) de MatchRH pour interagir avec la plateforme via des assistants IA.

## Serveur MCP MatchRH

Le serveur MCP MatchRH permet de consulter les offres d'emploi, de lister les recruteurs et de créer de nouvelles offres directement depuis vos outils IA préférés (Claude, ChatGPT, Cursor, etc.).

### Configuration

Pour connecter votre assistant IA au serveur MCP MatchRH, ajoutez la configuration suivante à votre fichier de configuration MCP (par exemple `claude_desktop_config.json` ou la configuration de Cursor) :

```json
{
  "mcpServers": {
    "matchrh": {
      "command": "php",
      "args": [
        "/chemin/vers/votre/projet/artisan",
        "mcp:start",
        "matchrh"
      ]
    }
  }
}
```

### Outils Disponibles

Le serveur expose les outils suivants :

#### 1. `list_job_offers`
Liste toutes les offres d'emploi publiées sur MatchRH.
- **Paramètres** : Aucun.
- **Retour** : Une liste d'offres avec ID, titre, entreprise, ville, description et salaire.

#### 2. `list_recruiters`
Liste tous les profils recruteurs. Utile pour trouver le `recruiter_profile_id` nécessaire à la création d'une offre.
- **Paramètres** : Aucun.
- **Retour** : Une liste de recruteurs avec ID, nom de l'entreprise et ville.

#### 3. `get_job_offer_details`
Récupère les détails complets d'une offre spécifique (compétences requises, localisation précise, etc.).
- **Paramètres** :
    - `id` (string) : L'ID de l'offre.
- **Retour** : Les détails complets de l'offre.

#### 4. `create_job_offer`
Crée une nouvelle offre d'emploi sur la plateforme.
- **Paramètres** :
    - `recruiter_profile_id` (string) : L'UUID du profil recruteur.
    - `title` (string) : Le titre de l'offre.
    - `description` (string) : Description détaillée du poste.
    - `city` (string) : Ville du poste.
    - `template` (string) : Template de poste (ex: `technicien`, `commercial`, `manager`).
    - `min_education` (string) : Niveau d'études minimum (ex: `bac`, `bts`, `licence`, `master`, `doctorat`).
    - `min_experience` (string) : Années d'expérience minimum (ex: `0`, `1`, `3`, `5`, `10`).
    - `max_availability` (string) : Disponibilité maximum (ex: `immediate`, `15_days`, `30_days`, `more`).

### Valeurs Valides pour les Paramètres

Pour assurer le bon fonctionnement des outils, utilisez les valeurs suivantes pour les paramètres énumérés :

- **`template`** : `manoeuvre`, `technicien`, `agent`, `cadre`, `dirigeant`.
- **`min_education`** : `none`, `cepc`, `bepc`, `bac`, `bts`, `licence`, `master`, `doctorat`.
- **`min_experience`** : `0` (Sans exp), `1` (1-2 ans), `2` (3-4 ans), `3` (5-10 ans), `4` (+10 ans).
- **`max_availability`** : `immediate`, `15_days`, `30_days`, `more`.

### Développement

Les fichiers liés à l'intégration MCP se trouvent dans :
- `app/Mcp/Servers/MatchRhServer.php` : Définition du serveur.
- `app/Mcp/Tools/` : Implémentation des outils.
- `app/Providers/McpServiceProvider.php` : Enregistrement du serveur dans Laravel.

## Debugging

Vous pouvez tester le serveur en utilisant l'inspecteur MCP de Laravel :
```bash
php artisan mcp:inspector
```
Ou en démarrant manuellement le serveur via stdio :
```bash
php artisan mcp:start matchrh
```
