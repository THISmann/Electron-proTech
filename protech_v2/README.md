# Electron ProTech v2

Reproduction du site Electron ProTech avec **Vue 3**, **TypeScript**, **Tailwind CSS**, **Pinia** et un **backend Node** pour les formulaires et le blog.

## Stack

- **Frontend** : Vue 3, Vite, TypeScript, Vue Router, Pinia, Tailwind CSS
- **Backend** : Node.js, Express, stockage JSON (formulaires + articles blog)
- **Admin** : Vue 3, TypeScript, Tailwind (dashboard formulaires + blog)
- **Docker** : Docker Compose (frontend + admin + backend)

## Développement local

```bash
# Backend
cd backend && npm install && npm run dev

# Frontend (autre terminal)
cd frontend && npm install && npm run dev

@@etu
```

- Frontend : http://localhost:5173
- API : http://localhost:4000

## Production (Docker + Traefik)

```bash
docker compose up -d --build
```

- Site : http://localhost/
- Admin (dashboard) : http://localhost/admin
- API : http://localhost/api
- Traefik dashboard : http://localhost:8080

## Production VM (EC2 + Domain)

Use `docker-compose.prod.yml` for HTTPS production behind Traefik.

1. Copy env file and set real values:

```bash
cp .env.prod.example .env.prod
```

2. Ensure DNS points to your EC2 public IP (`13.63.210.68`):
- `dev.electronprotech.com` -> A record -> `13.63.210.68`

3. Start production stack:

```bash
docker compose --env-file .env.prod -f docker-compose.prod.yml up -d --build
```

4. Verify:
- Site: `https://dev.electronprotech.com/`
- Admin: `https://dev.electronprotech.com/admin`
- API: `https://dev.electronprotech.com/api/health`

Notes:
- Ports `80` and `443` must be open in EC2 Security Group.
- TLS certificates are issued automatically via Let's Encrypt.

## API Backend

- `GET /api/forms` – liste des soumissions de formulaires
- `POST /api/forms` – soumettre un formulaire (contact / audit)
- `GET /api/blog` – liste des articles
- `GET /api/blog/:id` – détail d’un article
- `POST /api/blog` – créer un article (admin)
- `PUT /api/blog/:id` – modifier un article
- `DELETE /api/blog/:id` – supprimer un article
