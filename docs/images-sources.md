# Images et illustrations – sources libres de droits

Les images utilisées sur le site sont des **photos Electron ProTech** (installations, équipe technique, chantiers). Elles sont stockées dans `wp-content/themes/astra-child-protech/assets/images/` (ept-01.png à ept-17.png).

## Pages concernées

- **Accueil** : hero (parc solaire), réalisations (centrale solaire), équipe (travail en équipe).
- **Réalisations** : grille de 6 cartes avec visuels solaire / industrie.
- **Installation solaire** : hero + bloc processus avec image.
- **Maintenance & SAV** : hero industriel + bloc « pourquoi nous » avec équipe.

## URLs utilisées (Unsplash)

- `photo-1508514177221-188b1cf16e9d` — Parc solaire
- `photo-1559302504-64aae0ca2a3d` — Toiture solaire
- `photo-1473341304170-971dccb5ac1e` — Centrale solaire
- `photo-1532601224476-15c79f2f7a51` — Panneaux solaires
- `photo-1522071820081-009f0129c71c` — Équipe au travail
- `photo-1581091226825-a6a2a5aee158` — Industrie / technique
- `photo-1497435334941-9c4d065d4f75` — Énergie / soleil

Format d’URL : `https://images.unsplash.com/photo-{id}?w=800&q=80` (largeur et qualité ajustables).

## Remplacer par vos propres visuels

Dans **Pages** (éditeur) ou dans les fichiers `content-pages/*.html`, remplacez les `src` des balises `<img>` et l’attribut `style="background-image: url(...)"` des blocs `.ept-hero` par les URLs de vos médias (bibliothèque WordPress ou CDN). Puis relancez le script de mise à jour du contenu si vous éditez les HTML :

```bash
docker compose --profile tools run --rm wp-cli wp eval-file /app/scripts/update-pages-content.php --allow-root
```

## Autres banques d’images libres

- **Pexels** : https://www.pexels.com
- **Pixabay** : https://pixabay.com
- **Undraw** (illustrations SVG) : https://undraw.co
