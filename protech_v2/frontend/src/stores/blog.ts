import { defineStore } from 'pinia'
import { getBlog, getBlogPost } from '../api'

export interface BlogArticle {
  id: string
  slug: string
  title: string
  excerpt: string
  body: string
  category: string
  imageUrl: string
  publishedAt: string
  createdAt: string
  updatedAt: string
}

export const useBlogStore = defineStore('blog', {
  state: () => ({
    list: [] as BlogArticle[],
    current: null as BlogArticle | null,
    loading: false,
    error: null as string | null,
  }),
  actions: {
    async fetchList() {
      this.loading = true
      this.error = null
      try {
        this.list = await getBlog()
      } catch (e: unknown) {
        this.error = e instanceof Error ? e.message : 'Erreur chargement blog'
      } finally {
        this.loading = false
      }
    },
    async fetchPost(id: string) {
      this.loading = true
      this.error = null
      this.current = null
      try {
        this.current = await getBlogPost(id)
      } catch (e: unknown) {
        this.error = e instanceof Error ? e.message : 'Article non trouvé'
      } finally {
        this.loading = false
      }
    },
  },
})
