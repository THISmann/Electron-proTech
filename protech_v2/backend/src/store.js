import fs from 'fs';
import path from 'path';

const DATA_DIR = process.env.DATA_DIR || './data';
const FORMS_FILE = path.join(DATA_DIR, 'forms.json');
const BLOG_FILE = path.join(DATA_DIR, 'blog.json');

function ensureDir() {
  if (!fs.existsSync(DATA_DIR)) {
    fs.mkdirSync(DATA_DIR, { recursive: true });
  }
}

function readForms() {
  ensureDir();
  if (!fs.existsSync(FORMS_FILE)) return [];
  return JSON.parse(fs.readFileSync(FORMS_FILE, 'utf8'));
}

function writeForms(forms) {
  ensureDir();
  fs.writeFileSync(FORMS_FILE, JSON.stringify(forms, null, 2));
}

function readBlog() {
  ensureDir();
  if (!fs.existsSync(BLOG_FILE)) {
    const defaultArticles = [
      {
        id: '1',
        slug: 'solaire-cameroun-2026',
        title: 'Le solaire au Cameroun en 2026 : opportunités et défis',
        excerpt: 'Le Cameroun dispose d\'un potentiel solaire parmi les plus élevés d\'Afrique centrale.',
        body: '<p>Le Cameroun dispose d\'un potentiel solaire parmi les plus élevés d\'Afrique centrale, avec une irradiation annuelle favorable à la production photovoltaïque.</p><p>En 2026, plusieurs leviers accélèrent la dynamique : les extensions de centrales, le Compact Énergétique et la Mission 300.</p>',
        category: 'Contexte',
        imageUrl: '/images/blog-02.png',
        publishedAt: '2026-02-18T00:00:00.000Z',
        createdAt: '2026-02-18T00:00:00.000Z',
        updatedAt: '2026-02-18T00:00:00.000Z',
      },
    ];
    writeBlog(defaultArticles);
    return defaultArticles;
  }
  return JSON.parse(fs.readFileSync(BLOG_FILE, 'utf8'));
}

function writeBlog(articles) {
  ensureDir();
  fs.writeFileSync(BLOG_FILE, JSON.stringify(articles, null, 2));
}

export { readForms, writeForms, readBlog, writeBlog };
