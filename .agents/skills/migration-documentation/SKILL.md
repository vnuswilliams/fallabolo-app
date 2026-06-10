---
name: migration-documentation
description: "Mandatory skill for documenting database changes. Every time a model or migration is created, modified, or deleted, you MUST update @migrations.md to maintain an accurate technical reference of the database schema, relationships, and enums."
---

# Migration Documentation

This skill ensures that the `@migrations.md` file remains the source of truth for the database architecture of MatchRH.

## Core Mandates

1. **Documentation Before/After Action:** Whenever you perform a task that involves creating, modifying, or deleting a Laravel Model or Migration, you MUST update `@migrations.md` in the same turn or immediately after.
2. **Schema Accuracy:** Ensure that table structures, column types, constraints (PK, FK, UNIQUE, NULLABLE), and defaults in `@migrations.md` exactly match the code.
3. **Relationship Mapping:** Keep the "Schéma des relations" and "Récapitulatif des relations Eloquent" sections updated when adding or changing relationships between models.
4. **Enum Tracking:** Update the "Récapitulatif des enums" section when adding or modifying enum columns or their possible values.
5. **Execution Order:** Maintain the "Vue d’ensemble et ordre d’exécution" section to reflect the correct dependency chain for migrations.

## Update Procedure

- **New Table:** Add a new section for the migration, update the overview, relation schema, and summaries.
- **Table Modification:** Surgical edit of the corresponding table section in `@migrations.md`.
- **Relationship Change:** Update the relationship tables and diagrams.
- **Enum Change:** Update the enum summary table.

## Consistency Check

Always verify that:
- The `id` types (UUID vs BigInt) are correctly documented.
- Foreign keys are explicitly listed.
- Eloquent relation types (`hasOne`, `belongsTo`, `hasMany`, etc.) match the model implementations.
