#!/usr/bin/env bash
# À lancer si setup-wordpress.sh a été interrompu : définit la page d'accueil et les permaliens
set -e
cd "$(dirname "$0")/.."
COMPOSE="docker compose --profile tools"

echo "==> Page d'accueil = Accueil..."
ID=$($COMPOSE run --rm wp-cli wp post list --post_type=page --name=accueil --field=ID --format=ids --allow-root 2>/dev/null | tr -d ' ')
if [ -n "$ID" ]; then
  $COMPOSE run --rm wp-cli wp option update show_on_front page --allow-root
  $COMPOSE run --rm wp-cli wp option update page_on_front "$ID" --allow-root
  echo "    OK (ID $ID)"
fi
echo "==> Permaliens..."
$COMPOSE run --rm wp-cli wp rewrite structure '/%postname%/' --allow-root
$COMPOSE run --rm wp-cli wp rewrite flush --allow-root
echo "Terminé."
