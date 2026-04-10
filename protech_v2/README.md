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

## API Backend

- `GET /api/forms` – liste des soumissions de formulaires
- `POST /api/forms` – soumettre un formulaire (contact / audit)
- `GET /api/blog` – liste des articles
- `GET /api/blog/:id` – détail d’un article
- `POST /api/blog` – créer un article (admin)
- `PUT /api/blog/:id` – modifier un article
- `DELETE /api/blog/:id` – supprimer un article
