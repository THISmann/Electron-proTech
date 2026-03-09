# Déploiement sur Azure VM (GitHub Actions)

Le workflow `.github/workflows/deploy-azure.yml` déploie **protech_v2** sur une VM Azure à chaque push sur `main` (si des fichiers sous `protech_v2/` ont changé) ou au déclenchement manuel.

## Prérequis sur la VM Azure

1. **Docker et Docker Compose** installés.
2. **Repo cloné** dans un répertoire (ex. `/home/azure/protech_v2` ou `/home/azure/Electron-proTech` avec le sous-dossier `protech_v2`).
3. **Accès SSH par clé** : la clé publique correspondant au secret `AZURE_VM_SSH_PRIVATE_KEY` doit être dans `~/.ssh/authorized_keys` de l’utilisateur de déploiement.

### Exemple d’installation Docker sur la VM (Ubuntu)

```bash
sudo apt-get update && sudo apt-get install -y docker.io docker-compose-plugin
sudo usermod -aG docker $USER
# puis se déconnecter/reconnecter
```

## Secrets GitHub (obligatoires)

À configurer dans **Settings → Secrets and variables → Actions** du dépôt :

| Secret | Description |
|--------|-------------|
| `AZURE_VM_HOST` | IP publique ou hostname de la VM (ex. `51.xxx.xxx.xxx` ou `protech-vm.eastus.cloudapp.azure.com`) |
| `AZURE_VM_USER` | Utilisateur SSH (ex. `azureuser`) |
| `AZURE_VM_SSH_PRIVATE_KEY` | Contenu complet de la clé privée SSH (celle dont la clé publique est sur la VM) |

## Secrets optionnels

| Secret | Défaut | Description |
|--------|--------|-------------|
| `AZURE_DEPLOY_PATH` | `/home/azure/protech_v2` | Chemin sur la VM où se trouve le projet (dossier contenant `docker-compose.yml`). Si le repo est cloné en `~/Electron-proTech`, mettre `/home/azure/Electron-proTech/protech_v2`. |
| `AZURE_VM_SSH_PORT` | `22` | Port SSH si différent de 22. |
| `AZURE_DEPLOY_BRANCH` | `main` | Branche à tirer sur la VM avec `git pull`. |

## Premier déploiement sur la VM

1. Sur la VM, cloner le repo (ou le dossier `protech_v2` seul) :

   ```bash
   # Si le dépôt contient tout (ex. Electron-proTech avec protech_v2 dedans)
   git clone https://github.com/VOTRE_ORG/Electron-proTech.git
   cd Electron-proTech/protech_v2
   ```

   Ou si vous ne clonez que protech_v2 :

   ```bash
   git clone --depth 1 -b main https://github.com/VOTRE_ORG/REPO.git protech_v2
   cd protech_v2/protech_v2   # selon la structure du repo
   ```

2. Vérifier que `docker compose up -d --build` fonctionne une fois à la main.

3. Après avoir ajouté les secrets GitHub, un **push sur `main`** ou un run **manuel** (Actions → Deploy to Azure VM → Run workflow) déclenchera le déploiement.

## Ports exposés sur la VM

Après déploiement, les conteneurs écoutent en local sur la VM. Pour les rendre accessibles depuis l’extérieur :

- **3000** : site public  
- **3001** : dashboard admin  
- **4000** : API (optionnel si tout passe par nginx)

Configurer le **groupe de sécurité réseau (NSG)** Azure pour autoriser le trafic entrant sur les ports 3000 et 3001 (et 22 pour SSH) si besoin.
