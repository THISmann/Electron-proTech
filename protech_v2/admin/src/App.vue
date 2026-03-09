<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { getForms, getBlog, createArticle, updateArticle, deleteArticle } from './api'

interface FormEntry {
  id: string
  nom: string
  societe: string
  email: string
  telephone: string
  ville: string
  sujet: string
  message: string
  createdAt: string
}

interface BlogArticle {
  id: string
  slug: string
  title: string
  excerpt: string
  body: string
  category: string
  imageUrl: string
  publishedAt: string
  updatedAt: string
}

type SidebarOption = 'dashboard' | 'forms' | 'blog'

const forms = ref<FormEntry[]>([])
const articles = ref<BlogArticle[]>([])
const loadingForms = ref(false)
const loadingBlog = ref(false)
const error = ref('')
const sidebarOpen = ref(true)

const activeOption = ref<SidebarOption>('dashboard')

const sidebarItems: { id: SidebarOption; label: string; icon: string }[] = [
  { id: 'dashboard', label: 'Tableau de bord', icon: '📊' },
  { id: 'forms', label: 'Formulaires', icon: '📋' },
  { id: 'blog', label: 'Blog', icon: '📝' },
]

const editingId = ref<string | null>(null)
const editForm = ref<Partial<BlogArticle>>({})
const showNewArticle = ref(false)
const newArticle = ref({
  title: '',
  slug: '',
  excerpt: '',
  body: '',
  category: 'Actualités',
  imageUrl: '/images/blog-02.png',
})

async function loadForms() {
  loadingForms.value = true
  error.value = ''
  try {
    forms.value = await getForms()
  } catch (e) {
    error.value = e instanceof Error ? e.message : 'Erreur'
  } finally {
    loadingForms.value = false
  }
}

async function loadBlog() {
  loadingBlog.value = true
  error.value = ''
  try {
    articles.value = await getBlog()
  } catch (e) {
    error.value = e instanceof Error ? e.message : 'Erreur'
  } finally {
    loadingBlog.value = false
  }
}

function formatDate(iso: string) {
  return new Date(iso).toLocaleString('fr-FR', { dateStyle: 'short', timeStyle: 'short' })
}

function startEdit(article: BlogArticle) {
  editingId.value = article.id
  editForm.value = { ...article }
}

function cancelEdit() {
  editingId.value = null
  editForm.value = {}
}

async function saveEdit() {
  if (!editingId.value || !editForm.value) return
  error.value = ''
  try {
    await updateArticle(editingId.value, {
      title: editForm.value.title,
      slug: editForm.value.slug,
      excerpt: editForm.value.excerpt,
      body: editForm.value.body,
      category: editForm.value.category,
      imageUrl: editForm.value.imageUrl,
    })
    await loadBlog()
    cancelEdit()
  } catch (e) {
    error.value = e instanceof Error ? e.message : 'Erreur'
  }
}

async function confirmDelete(id: string, title: string) {
  if (!confirm(`Supprimer l'article « ${title} » ?`)) return
  error.value = ''
  try {
    await deleteArticle(id)
    await loadBlog()
  } catch (e) {
    error.value = e instanceof Error ? e.message : 'Erreur'
  }
}

function openNewArticle() {
  showNewArticle.value = true
  newArticle.value = {
    title: '',
    slug: '',
    excerpt: '',
    body: '',
    category: 'Actualités',
    imageUrl: '/images/blog-02.png',
  }
}

function closeNewArticle() {
  showNewArticle.value = false
}

async function submitNewArticle() {
  if (!newArticle.value.title.trim()) return
  error.value = ''
  try {
    await createArticle({
      title: newArticle.value.title,
      slug: newArticle.value.slug || undefined,
      excerpt: newArticle.value.excerpt || undefined,
      body: newArticle.value.body || undefined,
      category: newArticle.value.category,
      imageUrl: newArticle.value.imageUrl || undefined,
    })
    await loadBlog()
    closeNewArticle()
  } catch (e) {
    error.value = e instanceof Error ? e.message : 'Erreur'
  }
}

onMounted(() => {
  loadForms()
  loadBlog()
})
</script>

<template>
  <div class="flex min-h-screen bg-slate-100">
    <!-- Sidebar -->
    <aside
      class="fixed md:static inset-y-0 left-0 z-40 w-64 bg-protech-black text-white flex flex-col transition-transform duration-200 ease-out"
      :class="{ '-translate-x-full md:translate-x-0': !sidebarOpen }"
    >
      <div class="p-4 border-b border-white/10 flex items-center justify-between">
        <span class="font-bold text-protech-gold">ProTech Admin</span>
        <button
          type="button"
          class="md:hidden p-2 rounded-lg hover:bg-white/10"
          aria-label="Fermer le menu"
          @click="sidebarOpen = false"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>
      <nav class="flex-1 py-4">
        <button
          v-for="item in sidebarItems"
          :key="item.id"
          type="button"
          class="w-full flex items-center gap-3 px-4 py-3 text-left transition-colors"
          :class="activeOption === item.id ? 'bg-protech-green text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white'"
          @click="activeOption = item.id; sidebarOpen = false"
        >
          <span class="text-xl" aria-hidden="true">{{ item.icon }}</span>
          <span>{{ item.label }}</span>
          <span v-if="item.id === 'forms'" class="ml-auto text-xs bg-white/20 px-2 py-0.5 rounded-full">{{ forms.length }}</span>
          <span v-if="item.id === 'blog'" class="ml-auto text-xs bg-white/20 px-2 py-0.5 rounded-full">{{ articles.length }}</span>
        </button>
      </nav>
      <div class="p-4 border-t border-white/10">
        <a
          href="/"
          target="_blank"
          rel="noopener"
          class="flex items-center gap-2 text-sm text-slate-400 hover:text-protech-gold"
        >
          <span>← Retour au site</span>
        </a>
      </div>
    </aside>

    <!-- Overlay mobile -->
    <div
      v-if="sidebarOpen"
      class="fixed inset-0 z-30 bg-black/50 md:hidden"
      aria-hidden="true"
      @click="sidebarOpen = false"
    />

    <!-- Main content -->
    <div class="flex-1 flex flex-col min-w-0">
      <header class="sticky top-0 z-20 bg-white/95 backdrop-blur border-b border-slate-200 px-4 py-3 flex items-center gap-4">
        <button
          type="button"
          class="md:hidden p-2 rounded-lg hover:bg-slate-100"
          aria-label="Ouvrir le menu"
          @click="sidebarOpen = true"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
        </button>
        <h1 class="text-lg font-bold text-protech-black">
          {{ sidebarItems.find((i) => i.id === activeOption)?.label ?? 'Administration' }}
        </h1>
      </header>

      <main class="flex-1 p-4 md:p-6 overflow-auto">
        <div v-if="error" class="mb-6 p-4 rounded-xl bg-red-100 text-red-800">{{ error }}</div>

        <!-- Tableau de bord -->
        <section v-show="activeOption === 'dashboard'" class="space-y-6">
          <div class="grid sm:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl shadow border border-slate-200 p-6">
              <h2 class="text-protech-green font-semibold mb-1">Demandes reçues</h2>
              <p class="text-3xl font-bold text-protech-black">{{ forms.length }}</p>
              <p class="text-sm text-slate-500 mt-1">Formulaires contact / audit</p>
              <button type="button" class="mt-3 text-sm text-protech-green hover:underline" @click="activeOption = 'forms'">Voir les demandes →</button>
            </div>
            <div class="bg-white rounded-xl shadow border border-slate-200 p-6">
              <h2 class="text-protech-green font-semibold mb-1">Articles du blog</h2>
              <p class="text-3xl font-bold text-protech-black">{{ articles.length }}</p>
              <p class="text-sm text-slate-500 mt-1">Publications</p>
              <button type="button" class="mt-3 text-sm text-protech-green hover:underline" @click="activeOption = 'blog'">Gérer le blog →</button>
            </div>
          </div>
        </section>

        <!-- Formulaires -->
        <section v-show="activeOption === 'forms'" class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-lg font-bold text-protech-black">Demandes reçues (contact / audit)</h2>
            <button type="button" class="text-sm px-3 py-1.5 rounded-lg bg-protech-green text-white hover:bg-protech-green-light" @click="loadForms">Actualiser</button>
          </div>
          <div v-if="loadingForms" class="p-12 text-center text-slate-500">Chargement…</div>
          <div v-else-if="forms.length === 0" class="p-12 text-center text-slate-500">Aucune demande pour le moment.</div>
          <div v-else class="overflow-x-auto">
            <table class="w-full text-left text-sm">
              <thead class="bg-slate-50 text-slate-600">
                <tr>
                  <th class="px-4 py-3 font-semibold">Date</th>
                  <th class="px-4 py-3 font-semibold">Nom</th>
                  <th class="px-4 py-3 font-semibold">Société</th>
                  <th class="px-4 py-3 font-semibold">Email</th>
                  <th class="px-4 py-3 font-semibold">Tél</th>
                  <th class="px-4 py-3 font-semibold">Ville</th>
                  <th class="px-4 py-3 font-semibold">Sujet</th>
                  <th class="px-4 py-3 font-semibold">Message</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="f in forms" :key="f.id" class="border-t border-slate-100 hover:bg-slate-50/50">
                  <td class="px-4 py-3 whitespace-nowrap">{{ formatDate(f.createdAt) }}</td>
                  <td class="px-4 py-3">{{ f.nom }}</td>
                  <td class="px-4 py-3">{{ f.societe }}</td>
                  <td class="px-4 py-3"><a :href="'mailto:' + f.email" class="text-protech-green hover:underline">{{ f.email }}</a></td>
                  <td class="px-4 py-3">{{ f.telephone }}</td>
                  <td class="px-4 py-3">{{ f.ville }}</td>
                  <td class="px-4 py-3">{{ f.sujet }}</td>
                  <td class="px-4 py-3 max-w-xs truncate" :title="f.message">{{ f.message }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <!-- Blog -->
        <section v-show="activeOption === 'blog'" class="space-y-6">
          <div class="flex justify-end">
            <button type="button" class="px-4 py-2 rounded-xl bg-protech-gold text-protech-black font-bold hover:bg-protech-gold/90" @click="openNewArticle">+ Nouvel article</button>
          </div>
          <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
              <h2 class="text-lg font-bold text-protech-black">Articles du blog</h2>
              <button type="button" class="text-sm px-3 py-1.5 rounded-lg bg-protech-green text-white hover:bg-protech-green-light" @click="loadBlog">Actualiser</button>
            </div>
            <div v-if="loadingBlog" class="p-12 text-center text-slate-500">Chargement…</div>
            <div v-else-if="articles.length === 0" class="p-12 text-center text-slate-500">Aucun article.</div>
            <ul v-else class="divide-y divide-slate-100">
              <li v-for="article in articles" :key="article.id" class="p-6">
                <div v-if="editingId === article.id" class="space-y-4">
                  <input v-model="editForm.title" type="text" placeholder="Titre" class="w-full px-4 py-2 rounded-lg border border-slate-200" />
                  <input v-model="editForm.slug" type="text" placeholder="Slug (URL)" class="w-full px-4 py-2 rounded-lg border border-slate-200" />
                  <input v-model="editForm.category" type="text" placeholder="Catégorie" class="w-full px-4 py-2 rounded-lg border border-slate-200" />
                  <input v-model="editForm.imageUrl" type="text" placeholder="Image URL" class="w-full px-4 py-2 rounded-lg border border-slate-200" />
                  <textarea v-model="editForm.excerpt" placeholder="Résumé" rows="2" class="w-full px-4 py-2 rounded-lg border border-slate-200" />
                  <textarea v-model="editForm.body" placeholder="Contenu (HTML possible)" rows="6" class="w-full px-4 py-2 rounded-lg border border-slate-200 font-mono text-sm" />
                  <div class="flex gap-2">
                    <button type="button" class="px-4 py-2 rounded-lg bg-protech-green text-white hover:bg-protech-green-light" @click="saveEdit">Enregistrer</button>
                    <button type="button" class="px-4 py-2 rounded-lg border border-slate-300" @click="cancelEdit">Annuler</button>
                  </div>
                </div>
                <div v-else class="flex items-start justify-between gap-4">
                  <div class="min-w-0 flex-1">
                    <h3 class="font-bold text-protech-black">{{ article.title }}</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ article.category }} · {{ formatDate(article.publishedAt) }}</p>
                    <p class="text-sm text-slate-600 mt-1 line-clamp-2">{{ article.excerpt }}</p>
                  </div>
                  <div class="flex-shrink-0 flex gap-2">
                    <button type="button" class="px-3 py-1.5 rounded-lg border border-slate-300 text-sm hover:bg-slate-50" @click="startEdit(article)">Modifier</button>
                    <button type="button" class="px-3 py-1.5 rounded-lg border border-red-200 text-red-700 text-sm hover:bg-red-50" @click="confirmDelete(article.id, article.title)">Supprimer</button>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </section>
      </main>
    </div>

    <!-- Modal nouvel article -->
    <div v-if="showNewArticle" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @click.self="closeNewArticle">
      <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
          <h2 class="text-lg font-bold">Nouvel article</h2>
          <button type="button" class="p-2 rounded-lg hover:bg-slate-100" @click="closeNewArticle">✕</button>
        </div>
        <div class="p-6 space-y-4">
          <div>
            <label class="block text-sm font-medium text-protech-black mb-1">Titre *</label>
            <input v-model="newArticle.title" type="text" class="w-full px-4 py-2 rounded-lg border border-slate-200" placeholder="Titre de l'article" />
          </div>
          <div>
            <label class="block text-sm font-medium text-protech-black mb-1">Slug (optionnel)</label>
            <input v-model="newArticle.slug" type="text" class="w-full px-4 py-2 rounded-lg border border-slate-200" placeholder="url-de-l-article" />
          </div>
          <div>
            <label class="block text-sm font-medium text-protech-black mb-1">Catégorie</label>
            <input v-model="newArticle.category" type="text" class="w-full px-4 py-2 rounded-lg border border-slate-200" />
          </div>
          <div>
            <label class="block text-sm font-medium text-protech-black mb-1">Image (URL)</label>
            <input v-model="newArticle.imageUrl" type="text" class="w-full px-4 py-2 rounded-lg border border-slate-200" placeholder="/images/blog-02.png" />
          </div>
          <div>
            <label class="block text-sm font-medium text-protech-black mb-1">Résumé</label>
            <textarea v-model="newArticle.excerpt" rows="2" class="w-full px-4 py-2 rounded-lg border border-slate-200" placeholder="Court résumé" />
          </div>
          <div>
            <label class="block text-sm font-medium text-protech-black mb-1">Contenu (HTML accepté)</label>
            <textarea v-model="newArticle.body" rows="8" class="w-full px-4 py-2 rounded-lg border border-slate-200 font-mono text-sm" placeholder="<p>Paragraphe...</p>" />
          </div>
          <div class="flex gap-2 pt-2">
            <button type="button" class="px-4 py-2 rounded-lg bg-protech-gold text-protech-black font-bold hover:bg-protech-gold/90" @click="submitNewArticle">Créer l'article</button>
            <button type="button" class="px-4 py-2 rounded-lg border border-slate-300" @click="closeNewArticle">Annuler</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
