# Plan d’attaque – Site WordPress proTech Solaire (Cameroun)

## Contexte
- **Répertoire actuel** : vide → on crée la structure WordPress (thème enfant, config, snippets) prête à être déployée dans l’environnement Docker existant (Traefik v3 + wordpress:fpm + MariaDB 11 + Redis).
- **Cible** : site vitrine B2B, conversion leads (audit gratuit, devis, maintenance), SEO local Cameroun, mobile-first, PageSpeed 88–92.

---

## Ordre d’exécution (fichiers à toucher)

### Phase 1 – Fondations (à faire en premier)
| # | Fichier / dossier | Action |
|---|-------------------|--------|
| 1.1 | `docs/wp-config-checklist.md` | Checklist + extraits pour `wp-config.php` (debug, salts, Redis, constantes perf) – à intégrer dans l’install existante |
| 1.2 | `wp-content/themes/astra-child-protech/style.css` | Création thème enfant Astra : en-tête, métadonnées |
| 1.3 | `wp-content/themes/astra-child-protech/functions.php` | Support Elementor, enqueue CSS/JS, préparation CPT, hooks (sans logique métier lourde au début) |

### Phase 2 – Données & contenu
| # | Fichier / dossier | Action |
|---|-------------------|--------|
| 2.1 | `wp-content/themes/astra-child-protech/inc/cpt-realisations.php` | Custom Post Type « Réalisations » (titre, images avant/après, kWc, client, secteur, économies, payback) – natif WordPress, ACF-ready |
| 2.2 | `wp-content/themes/astra-child-protech/inc/cpt-realisations.php` | Inclus dans `functions.php` |

### Phase 3 – Templates Elementor (importables)
| # | Fichier | Action |
|---|---------|--------|
| 3.1 | `elementor-templates/hero-accueil-protech.json` | Section Hero (drone chantier, valeur, CTA audit gratuit) |
| 3.2 | `elementor-templates/realisations-carousel.json` | Section réalisations (grille/carousel, filtres secteur) |
| 3.3 | `elementor-templates/cta-audit-gratuit.json` | Bloc CTA « Audit énergétique gratuit » |
| 3.4 | `elementor-templates/formulaire-lead.json` | Formulaire lead (inline ou popup-ready) |

### Phase 4 – Fonctionnalités conversion
| # | Fichier | Action |
|---|---------|--------|
| 4.1 | `wp-content/themes/astra-child-protech/inc/calculateur-economies.php` | Shortcode + formule (facture ENEO, groupe, localisation → économies/an, payback, kWh) |
| 4.2 | `wp-content/themes/astra-child-protech/assets/js/calculateur-economies.js` | Logique front (saisie, calcul, affichage résultat) |
| 4.3 | `wp-content/themes/astra-child-protech/inc/whatsapp-float.php` | Snippet bouton WhatsApp flottant + message pré-rempli (audit, ville, type entreprise) |

### Phase 5 – Perf & SEO
| # | Fichier | Action |
|---|---------|--------|
| 5.1 | `wp-content/themes/astra-child-protech/inc/seo-schema.php` | Schema.org LocalBusiness, Article, FAQ + balises title/meta dynamiques locales |
| 5.2 | `wp-content/themes/astra-child-protech/functions.php` | Lazy loading images (natif + attributs), précharge polices (Inter/Poppins) |

### Phase 6 – Contenu
| # | Fichier | Action |
|---|---------|--------|
| 6.1 | `content-seo/accueil.md` | Texte SEO-ready page Accueil (hero, CTA, témoignages, réalisations) |
| 6.2 | `content-seo/installation-solaire.md` | Page Installation solaire (processus, types, puissances) |
| 6.3 | `content-seo/maintenance-sav.md` | Page Maintenance & SAV (contrats, avantages, exemples) |
| 6.4 | `content-seo/contact-devis.md` | Page Contact / Devis (champs, carte, WhatsApp) |

---

## Structure de dossiers cible (à placer dans le WordPress Docker)

```
Electron-proTech/
├── PLAN.md
├── docs/
│   └── wp-config-checklist.md
├── wp-content/
│   └── themes/
│       └── astra-child-protech/
│           ├── style.css
│           ├── functions.php
│           ├── inc/
│           │   ├── cpt-realisations.php
│           │   ├── calculateur-economies.php
│           │   ├── whatsapp-float.php
│           │   └── seo-schema.php
│           └── assets/
│               ├── js/
│               │   └── calculateur-economies.js
│               └── css/
│                   └── (optionnel)
├── elementor-templates/
│   ├── hero-accueil-protech.json
│   ├── realisations-carousel.json
│   ├── cta-audit-gratuit.json
│   └── formulaire-lead.json
└── content-seo/
    ├── accueil.md
    ├── installation-solaire.md
    ├── maintenance-sav.md
    └── contact-devis.md
```

---

## Règles respectées
- WordPress Coding Standards, PHP 8.3 compatible.
- Pas de recréation de `docker-compose` ; uniquement adaptation WordPress (config, thème, assets).
- Code modulaire, commenté ; CTAs et lead magnet pris en compte dans chaque bloc.
- Variantes design/wording proposées dans les contenus quand pertinent.

---

## Prochaine étape immédiate
**Phase 1** : création de `docs/wp-config-checklist.md`, puis `style.css` et `functions.php` du thème enfant. Dès que tu valides ce plan, on enchaîne fichier par fichier.
