const baseURL = import.meta.env.VITE_API_URL || ''

export async function getForms() {
  const r = await fetch(`${baseURL}/api/forms`)
  if (!r.ok) throw new Error('Erreur chargement formulaires')
  return r.json()
}

export async function getBlog() {
  const r = await fetch(`${baseURL}/api/blog`)
  if (!r.ok) throw new Error('Erreur chargement blog')
  return r.json()
}

export async function createArticle(data: {
  title: string
  slug?: string
  excerpt?: string
  body?: string
  category?: string
  imageUrl?: string
}) {
  const r = await fetch(`${baseURL}/api/blog`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
  })
  if (!r.ok) throw new Error((await r.json().catch(() => ({})) as { error?: string }).error || 'Erreur')
  return r.json()
}

export async function updateArticle(
  id: string,
  data: Partial<{ title: string; slug: string; excerpt: string; body: string; category: string; imageUrl: string }>
) {
  const r = await fetch(`${baseURL}/api/blog/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
  })
  if (!r.ok) throw new Error((await r.json().catch(() => ({})) as { error?: string }).error || 'Erreur')
  return r.json()
}

export async function deleteArticle(id: string) {
  const r = await fetch(`${baseURL}/api/blog/${id}`, { method: 'DELETE' })
  if (!r.ok) throw new Error('Erreur suppression')
}
