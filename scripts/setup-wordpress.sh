#!/usr/bin/env bash
# proTech Solaire – Install Elementor, Astra, et création des pages du site
# Usage : depuis la racine du projet : ./scripts/setup-wordpress.sh
# Prérequis : WordPress déjà installé (assistant 5 min fait), stack Docker up

set -e
cd "$(dirname "$0")/.."
COMPOSE="docker compose --profile tools"

echo "==> Installation du thème Astra..."
$COMPOSE run --rm wp-cli wp theme install astra --activate --allow-root 2>/dev/null || true
echo "==> Activation du thème enfant proTech..."
$COMPOSE run --rm wp-cli wp theme activate astra-child-protech --allow-root

echo "==> Installation et activation d'Elementor..."
$COMPOSE run --rm wp-cli wp plugin install elementor --activate --allow-root

echo "==> Création des pages..."
$COMPOSE run --rm wp-cli wp post create --post_type=page --post_title='Accueil' --post_name=accueil --post_status=publish --post_content='<!-- Contenu à éditer avec Elementor -->' --allow-root 2>/dev/null || true
$COMPOSE run --rm wp-cli wp post create --post_type=page --post_title='Nos réalisations' --post_name=realisations --post_status=publish --allow-root 2>/dev/null || true
$COMPOSE run --rm wp-cli wp post create --post_type=page --post_title='Installation solaire' --post_name=installation-solaire --post_status=publish --allow-root 2>/dev/null || true
$COMPOSE run --rm wp-cli wp post create --post_type=page --post_title='Maintenance & SAV' --post_name=maintenance-sav --post_status=publish --allow-root 2>/dev/null || true
$COMPOSE run --rm wp-cli wp post create --post_type=page --post_title='Simulateur économies' --post_name=simulateur --post_status=publish --post_content='[protech_calculateur_economies]' --allow-root 2>/dev/null || true
$COMPOSE run --rm wp-cli wp post create --post_type=page --post_title='Références & Témoignages' --post_name=references-temoignages --post_status=publish --allow-root 2>/dev/null || true
$COMPOSE run --rm wp-cli wp post create --post_type=page --post_title='À propos' --post_name=a-propos --post_status=publish --allow-root 2>/dev/null || true
$COMPOSE run --rm wp-cli wp post create --post_type=page --post_title='Contact & Devis' --post_name=contact --post_status=publish --allow-root 2>/dev/null || true

echo "==> Définition de la page d'accueil..."
ID_ACCUEIL=$($COMPOSE run --rm wp-cli wp post list --post_type=page --name=accueil --field=ID --format=ids --allow-root 2>/dev/null | tr -d ' ')
if [ -n "$ID_ACCUEIL" ]; then
  $COMPOSE run --rm wp-cli wp option update show_on_front page --allow-root
  $COMPOSE run --rm wp-cli wp option update page_on_front "$ID_ACCUEIL" --allow-root
  echo "    Page d'accueil : ID $ID_ACCUEIL"
fi

echo "==> Structure des permaliens (post name)..."
$COMPOSE run --rm wp-cli wp rewrite structure '/%postname%/' --allow-root
$COMPOSE run --rm wp-cli wp rewrite flush --allow-root

echo ""
echo "==> Terminé. Ouvrez http://localhost/wp-admin puis :"
echo "    - Apparence > Thèmes : Astra + Astra Child proTech sont actifs"
echo "    - Extensions : Elementor est activé"
echo "    - Pages : Accueil, Réalisations, Installation, Maintenance, Simulateur, Références, À propos, Contact"
echo "    - Éditez chaque page avec Elementor (Modifier avec Elementor)"
echo "    - Import des modèles : Elementor > Modèles > Importer (fichiers dans elementor-templates/)"
