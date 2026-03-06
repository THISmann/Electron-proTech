# proTech Solaire – Site WordPress B2B (Cameroun)

Site vitrine orienté conversion (leads : audit gratuit, devis, maintenance) pour une entreprise camerounaise spécialisée dans l’installation et la maintenance de parcs solaires industriels et commerciaux (10–500 kWc).

---

## Ce qui a été livré

| Élément | Emplacement |
|--------|-------------|
| **Plan d’attaque** | `PLAN.md` |
| **Checklist wp-config** | `docs/wp-config-checklist.md` |
| **Thème enfant Astra** | `wp-content/themes/astra-child-protech/` |
| **CPT Réalisations** | `inc/cpt-realisations.php` |
| **Calculateur économies** | Shortcode `[protech_calculateur_economies]` + `assets/js/calculateur-economies.js` |
| **Bouton WhatsApp** | `inc/whatsapp-float.php` (configurable par filtre) |
| **SEO & Schema** | `inc/seo-schema.php` (LocalBusiness, Article, FAQ) |
| **Templates Elementor** | `elementor-templates/*.json` (Hero, Réalisations, CTA, Formulaire) |
| **Contenus SEO** | `content-seo/*.md` (Accueil, Installation, Maintenance, Contact) |

---

## Lancer le projet avec Docker

À la racine du projet :

```bash
# 1. Créer le fichier .env (déjà fait si vous avez copié .env.example en .env)
cp .env.example .env
# Éditer .env et définir MYSQL_ROOT_PASSWORD et WORDPRESS_DB_PASSWORD

# 2. Démarrer la stack
docker compose up -d
```

**Services** : Traefik (port 80, API 8080), Nginx, WordPress PHP 8.3 FPM, MariaDB 11, Redis.

**Accès** : http://localhost (installation WordPress au premier chargement).  
**Dashboard Traefik** : http://localhost:8080

En cas d’échec au premier `docker compose up -d` (timeout réseau lors du pull), relancer la commande.

---

## Déploiement dans votre WordPress (Docker)

1. **Copier le thème**  
   Copier `wp-content/themes/astra-child-protech` dans le `wp-content/themes/` de votre installation WordPress (conteneur ou volume).

2. **Activer le thème**  
   Dans **Apparence → Thèmes**, activer **Astra Child proTech Solaire**. Le thème parent **Astra** doit être installé.

3. **Plugins recommandés**  
   Installer et configurer : **Elementor** (ou Elementor Pro), **Rank Math SEO**, **WP Rocket** ou **LiteSpeed Cache**, **Redis Object Cache**, **Contact Form 7** ou **WPForms**, **UpdraftPlus**, **Wordfence**.

4. **wp-config.php**  
   Suivre `docs/wp-config-checklist.md` (debug, salts, Redis, constantes).

5. **WhatsApp**  
   Définir le numéro réel via filtre dans votre thème enfant ou un snippet :
   ```php
   add_filter( 'protech_whatsapp_number', function() { return '2376XXXXXX'; });
   add_filter( 'protech_whatsapp_message', function() {
       return 'Bonjour, je souhaite un audit solaire pour mon entreprise à [ma ville].';
   });
   ```
   Le bouton n’apparaît pas si le numéro reste `237600000000`.

6. **Importer les templates Elementor**  
   **Elementor → Templates → Importer** : importer les 4 JSON depuis `elementor-templates/`. Adapter les liens, l’image hero et l’ID du formulaire CF7 (voir `elementor-templates/README.md`).

7. **Installation Elementor + création du site (automatique)**  
   À la racine du projet :
   ```bash
   ./scripts/setup-wordpress.sh
   ```
   Ce script installe le thème **Astra**, active le thème enfant **proTech**, installe **Elementor**, crée les pages (Accueil, Nos réalisations, Installation solaire, Maintenance & SAV, Simulateur, Références, À propos, Contact) et définit la page d’accueil. Si le script est interrompu avant la fin :
   ```bash
   ./scripts/setup-wordpress-finish.sh
   ```

8. **Contenu rédigé dans les pages**  
   Le contenu B2B (SolarTech241, SEO local Cameroun) est dans `content-pages/*.html`. Pour l’injecter dans WordPress :
   ```bash
   docker compose --profile tools run --rm wp-cli wp eval-file /app/scripts/update-pages-content.php --allow-root
   ```
   Si la page « Contact » n’existe pas, la créer puis relancer la commande :
   ```bash
   docker compose --profile tools run --rm wp-cli wp post create --post_type=page --post_title='Contact & Devis' --post_name=contact --post_status=publish --allow-root
   ```

9. **Contenu (référence)**  
   Les textes de référence et SEO sont aussi dans `content-seo/*.md`.

10. **Simulateur**  
   La page « Simulateur économies » contient déjà le shortcode `[protech_calculateur_economies]`. Sur les autres pages, insérer ce shortcode dans un bloc Elementor « Shortcode » si besoin.

---

## Raccourcis techniques

- **Tarif ENEO** (calculateur) : filtre `protech_tarif_eneo_kwh` (défaut 75 FCFA/kWh).
- **Schema LocalBusiness** : filtre `protech_schema_address`, `protech_schema_local_business`.
- **FAQ Schema** : filtre `protech_schema_faq_items` (tableau de `question` / `answer`).

---

## Stack cible

- WordPress (PHP 8.3), Astra + Elementor
- Docker : Traefik v3, wordpress:fpm, MariaDB 11, Redis
- Mobile-first, PageSpeed 88–92, SEO local Cameroun

Pour toute modification du plan ou des priorités, se référer à `PLAN.md`.
