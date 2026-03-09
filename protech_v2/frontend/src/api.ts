const baseURL = import.meta.env.VITE_API_URL || ''

export async function getBlog() {
  const r = await fetch(`${baseURL}/api/blog`)
  if (!r.ok) throw new Error('Erreur chargement blog')
  return r.json()
}

export async function getBlogPost(id: string) {
  const r = await fetch(`${baseURL}/api/blog/${id}`)
  if (!r.ok) throw new Error('Article non trouvé')
  return r.json()
}

export async function submitForm(data: {
  nom: string
  societe?: string
  email: string
  telephone?: string
  ville?: string
  sujet: string
  message?: string
}) {
  const r = await fetch(`${baseURL}/api/forms`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
  })
  if (!r.ok) {
    const err = await r.json().catch(() => ({}))
    throw new Error((err as { error?: string }).error || 'Erreur envoi formulaire')
  }
  return r.json()
}
