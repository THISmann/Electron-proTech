import { Router } from 'express';
import { readBlog, writeBlog } from '../store.js';

export const blogRouter = Router();

blogRouter.get('/', (req, res) => {
  try {
    const articles = readBlog();
    const sorted = [...articles].sort(
      (a, b) => new Date(b.publishedAt || b.createdAt) - new Date(a.publishedAt || a.createdAt)
    );
    res.json(sorted);
  } catch (e) {
    res.status(500).json({ error: e.message });
  }
});

blogRouter.get('/:id', (req, res) => {
  try {
    const articles = readBlog();
    const article = articles.find((a) => a.id === req.params.id || a.slug === req.params.id);
    if (!article) return res.status(404).json({ error: 'Article non trouvé' });
    res.json(article);
  } catch (e) {
    res.status(500).json({ error: e.message });
  }
});

blogRouter.post('/', (req, res) => {
  try {
    const { title, slug, excerpt, body, category, imageUrl } = req.body;
    if (!title) return res.status(400).json({ error: 'Titre requis' });
    const articles = readBlog();
    const now = new Date().toISOString();
    const id = String(Date.now());
    const article = {
      id,
      slug: slug || title.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, ''),
      title,
      excerpt: excerpt || '',
      body: body || '',
      category: category || 'Actualités',
      imageUrl: imageUrl || '',
      publishedAt: now,
      createdAt: now,
      updatedAt: now,
    };
    articles.push(article);
    writeBlog(articles);
    res.status(201).json(article);
  } catch (e) {
    res.status(500).json({ error: e.message });
  }
});

blogRouter.put('/:id', (req, res) => {
  try {
    const articles = readBlog();
    const idx = articles.findIndex((a) => a.id === req.params.id);
    if (idx === -1) return res.status(404).json({ error: 'Article non trouvé' });
    const now = new Date().toISOString();
    articles[idx] = {
      ...articles[idx],
      ...req.body,
      id: articles[idx].id,
      updatedAt: now,
    };
    writeBlog(articles);
    res.json(articles[idx]);
  } catch (e) {
    res.status(500).json({ error: e.message });
  }
});

blogRouter.delete('/:id', (req, res) => {
  try {
    const articles = readBlog();
    const filtered = articles.filter((a) => a.id !== req.params.id);
    if (filtered.length === articles.length) return res.status(404).json({ error: 'Article non trouvé' });
    writeBlog(filtered);
    res.status(204).send();
  } catch (e) {
    res.status(500).json({ error: e.message });
  }
});
