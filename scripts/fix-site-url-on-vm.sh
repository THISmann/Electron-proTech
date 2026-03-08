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

COMPOSE="$DOCKER compose -f docker-compose.yml"
if [ -f docker-compose.test.yml ] && $DOCKER compose -f docker-compose.yml -f docker-compose.test.yml ps 2>/dev/null | grep -q Up; then
  COMPOSE="$DOCKER compose -f docker-compose.yml -f docker-compose.test.yml"
elif [ -f docker-compose.production.yml ] && $DOCKER compose -f docker-compose.yml -f docker-compose.production.yml ps 2>/dev/null | grep -q Up; then
  COMPOSE="$DOCKER compose -f docker-compose.yml -f docker-compose.production.yml"
else
  COMPOSE="$DOCKER compose -f docker-compose.yml"
fi
COMPOSE="$COMPOSE --profile tools"
RUN_WP="$COMPOSE run --rm -v $(pwd)/scripts:/app/scripts -v $(pwd)/content-pages:/app/content-pages wp-cli"

echo "Forçage des URLs à: $URL"
$RUN_WP wp config set WP_HOME "$URL" --raw --allow-root 2>/dev/null || true
$RUN_WP wp config set WP_SITEURL "$URL" --raw --allow-root 2>/dev/null || true
$RUN_WP wp option update home "$URL" --allow-root
$RUN_WP wp option update siteurl "$URL" --allow-root
$RUN_WP wp cache flush --allow-root 2>/dev/null || true
echo "✅ URLs mises à jour. Rechargez le site (Ctrl+F5)."
