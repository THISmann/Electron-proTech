import { defineStore } from 'pinia'
import { submitForm as apiSubmitForm } from '../api'

export const useFormsStore = defineStore('forms', {
  state: () => ({ loading: false, error: null as string | null, success: false }),
  actions: {
    async submitForm(data: Parameters<typeof apiSubmitForm>[0]) {
      this.loading = true
      this.error = null
      this.success = false
      try {
        await apiSubmitForm(data)
        this.success = true
      } catch (e: unknown) {
        this.error = e instanceof Error ? e.message : 'Erreur inconnue'
        throw e
      } finally {
        this.loading = false
      }
    },
    resetStatus() {
      this.error = null
      this.success = false
    },
  },
})
