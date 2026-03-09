# ProTech Admin – Dashboard

Projet Vue 3 + TypeScript dédié au **tableau de bord d’administration** (formulaires, blog). Indépendant du frontend principal.

## Lancement

```bash
# Depuis protech_v2/admin
npm install
npm run dev
```

- **URL** : http://localhost:5174  
- L’API backend doit tourner sur http://localhost:4000 (proxy Vite configuré vers `/api`).

## Options du sidebar

- **Tableau de bord** : résumé (nombre de demandes, nombre d’articles).
- **Formulaires** : liste des demandes reçues (contact / audit) avec date, nom, société, email, tél, ville, sujet, message.
- **Blog** : liste des articles, création, modification, suppression.

## Build

```bash
npm run build
```

Les fichiers sont générés dans `dist/`. En production, servir cette app sur un sous-chemin (ex. `/admin`) ou un sous-domaine, en pointant `VITE_API_URL` vers l’API si nécessaire.
