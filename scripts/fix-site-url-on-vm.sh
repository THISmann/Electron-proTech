#!/usr/bin/env bash
# À exécuter sur la VM (dans ~/app) pour forcer les URLs du site et faire charger le CSS/JS.
# Usage: sudo bash scripts/fix-site-url-on-vm.sh [URL]
# Exemple: sudo bash scripts/fix-site-url-on-vm.sh "http://20.199.10.163:8080"
# Si pas d'argument: devine TEST (port 8080) ou PROD selon les containers.

set -e
cd "$(dirname "$0")/.."
APP_DIR="${APP_DIR:-$(pwd)}"
URL="${1:-}"

DOCKER="${DOCKER:-sudo docker}"
if [ -z "$URL" ]; then
  if [ -f docker-compose.test.yml ] && $DOCKER compose -f docker-compose.yml -f docker-compose.test.yml ps 2>/dev/null | grep -q Up; then
    IP=$(hostname -I 2>/dev/null | awk '{print $1}' || echo "127.0.0.1")
    URL="http://${IP}:8080"
    echo "Environnement TEST détecté → URL: $URL"
  else
    IP=$(hostname -I 2>/dev/null | awk '{print $1}' || echo "127.0.0.1")
    URL="http://${IP}"
    echo "Environnement PRODUCTION → URL: $URL"
  fi
fi

COMPOSE_BASE="$DOCKER compose -f docker-compose.yml"
if [ -f docker-compose.test.yml ] && $DOCKER compose -f docker-compose.yml -f docker-compose.test.yml ps 2>/dev/null | grep -q Up; then
  COMPOSE_BASE="$DOCKER compose -f docker-compose.yml -f docker-compose.test.yml"
elif [ -f docker-compose.production.yml ] && $DOCKER compose -f docker-compose.yml -f docker-compose.production.yml ps 2>/dev/null | grep -q Up; then
  COMPOSE_BASE="$DOCKER compose -f docker-compose.yml -f docker-compose.production.yml"
else
  COMPOSE_BASE="$DOCKER compose -f docker-compose.yml"
fi
COMPOSE="$COMPOSE_BASE --profile tools"
RUN_WP="$COMPOSE run --rm -v $(pwd)/scripts:/app/scripts -v $(pwd)/content-pages:/app/content-pages wp-cli"

URL="${URL%/}"
echo "Forçage des URLs à: $URL"

# 1) Mettre SITE_URL dans .env pour que le mu-plugin et le conteneur WordPress l'utilisent
if [ -f .env ]; then
  grep -q '^SITE_URL=' .env && sed -i "s|^SITE_URL=.*|SITE_URL=$URL|" .env || echo "SITE_URL=$URL" >> .env
else
  echo "SITE_URL=$URL" >> .env
fi

# 2) S'assurer que le mu-plugin existe (pour forcer les URLs depuis SITE_URL à chaque requête)
mkdir -p wp-content/mu-plugins
cat > wp-content/mu-plugins/protech-site-url.php << 'MUPHP'
<?php
if ( ! defined( 'ABSPATH' ) ) return;
$u = getenv( 'SITE_URL' );
if ( $u !== false && $u !== '' ) {
  $u = rtrim( $u, '/' );
  add_filter( 'pre_option_home', function() use ( $u ) { return $u; }, 1 );
  add_filter( 'pre_option_siteurl', function() use ( $u ) { return $u; }, 1 );
}
MUPHP

# 3) Recréer le conteneur WordPress pour qu'il prenne SITE_URL et le mu-plugin
$COMPOSE_BASE up -d --force-recreate wordpress 2>/dev/null || true

# 4) Forcer en base + wp-config (--user root pour pouvoir écrire wp-config.php)
$COMPOSE run --rm --user root -v "$(pwd)/scripts:/app/scripts" -v "$(pwd)/content-pages:/app/content-pages" wp-cli wp config set WP_HOME "$URL" --raw --allow-root 2>/dev/null || true
$COMPOSE run --rm --user root -v "$(pwd)/scripts:/app/scripts" -v "$(pwd)/content-pages:/app/content-pages" wp-cli wp config set WP_SITEURL "$URL" --raw --allow-root 2>/dev/null || true
$RUN_WP wp option update home "$URL" --allow-root
$RUN_WP wp option update siteurl "$URL" --allow-root
$RUN_WP wp cache flush --allow-root 2>/dev/null || true

# 5) Redémarrer WordPress pour être sûr que tout est pris en compte
$COMPOSE_BASE restart wordpress 2>/dev/null || true

echo "✅ URLs mises à jour (SITE_URL dans .env + mu-plugin + conteneur recréé). Rechargez le site (Ctrl+F5)."
