# Checklist wp-config.php – Environnement Docker (Traefik + WordPress FPM + MariaDB + Redis)

À intégrer dans votre `wp-config.php` existant (généralement monté ou généré dans le conteneur WordPress). Ne pas recréer tout le fichier : adapter selon votre installation.

---

## 1. Debug (production)

```php
// Désactiver l'affichage des erreurs en production
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );
```

En staging uniquement, vous pouvez mettre `WP_DEBUG` à `true` et `WP_DEBUG_LOG` à `true` (fichier `wp-content/debug.log`).

---

## 2. Clés et sels (obligatoire)

Générer de nouvelles clés : https://api.wordpress.org/secret-key/1.1/salt/

```php
define( 'AUTH_KEY',         'mettez-votre-clé-ici' );
define( 'SECURE_AUTH_KEY',  'mettez-votre-clé-ici' );
define( 'LOGGED_IN_KEY',    'mettez-votre-clé-ici' );
define( 'NONCE_KEY',        'mettez-votre-clé-ici' );
define( 'AUTH_SALT',        'mettez-votre-clé-ici' );
define( 'SECURE_AUTH_SALT', 'mettez-votre-clé-ici' );
define( 'LOGGED_IN_SALT',   'mettez-votre-clé-ici' );
define( 'NONCE_SALT',       'mettez-votre-clé-ici' );
```

---

## 3. Redis Object Cache (si Redis est présent dans le Docker)

À placer **avant** le `require_once( ABSPATH . 'wp-settings.php' );` :

```php
// Redis: utiliser si la constante d'environnement est définie (ex: docker)
if ( defined( 'WP_REDIS_HOST' ) && WP_REDIS_HOST ) {
    define( 'WP_CACHE', true );
    // Optionnel : préfixe pour multi-sites ou environnements
    // define( 'WP_REDIS_PREFIX', 'protech_' );
}
```

Dans votre stack Docker, passer par exemple :
- `WP_REDIS_HOST=redis` (nom du service)
- `WP_REDIS_PORT=6379` (si différent du défaut)

Le plugin **Redis Object Cache** doit être installé et activé ; il lira ces constantes.

---

## 4. Limites et performance (recommandé)

```php
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );
```

---

## 5. URL du site (si géré par env)

Si vous définissez l’URL en variables d’environnement (Traefik / domaine) :

```php
if ( defined( 'WP_HOME' ) && defined( 'WP_SITEURL' ) ) {
    // Déjà définis par env
} else {
    define( 'WP_HOME', 'https://votre-domaine.com' );
    define( 'WP_SITEURL', WP_HOME . '/wp' ); // si WordPress en sous-dossier
}
```

Adapter selon votre schéma (WP en racine ou sous-dossier).

---

## 6. Sécurité (bonnes pratiques 2026)

```php
// Désactiver l’édition de fichiers depuis l’admin
define( 'DISALLOW_FILE_EDIT', true );

// Forcer SSL en admin (si vous avez HTTPS derrière Traefik)
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
    $_SERVER['HTTPS'] = 'on';
}
```

---

## 7. Base de données (généralement fourni par env dans Docker)

WordPress lit par défaut `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_HOST`, `DB_CHARSET`, `DB_COLLATE`.  
S’ils sont injectés par Docker, inutile de les redéfinir. Sinon :

```php
define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'wordpress' );
define( 'DB_PASSWORD', 'votre_mot_de_passe' );
define( 'DB_HOST', 'mariadb:3306' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', 'utf8mb4_unicode_ci' );
```

---

## Résumé des fichiers à toucher

- **Un seul fichier** : `wp-config.php` à la racine de WordPress (dans l’image ou le volume monté).
- Ne pas modifier le `docker-compose` : ce checklist sert à **adapter** le WordPress à l’environnement existant.

Une fois ces points vérifiés, passez à l’activation du thème enfant et aux templates Elementor.
