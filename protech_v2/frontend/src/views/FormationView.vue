<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useFormsStore } from '../stores/forms'

const formsStore = useFormsStore()

const nom = ref('')
const societe = ref('')
const email = ref('')
const telephone = ref('')
const ville = ref('')
const format = ref('')
const message = ref('')

const formats = [
  'Initiation solaire (debutant)',
  'Dimensionnement et installation PV',
  'Maintenance des systemes solaires',
  'Formation sur mesure entreprise',
]

onMounted(() => {
  formsStore.resetStatus()
})

async function onSubmit(e: Event) {
  e.preventDefault()
  if (!nom.value.trim() || !email.value.trim() || !format.value) return
  try {
    await formsStore.submitForm({
      nom: nom.value.trim(),
      societe: societe.value.trim(),
      email: email.value.trim(),
      telephone: telephone.value.trim(),
      ville: ville.value.trim(),
      sujet: 'Inscription formation solaire',
      message: `Format: ${format.value}\n${message.value.trim()}`.trim(),
    })
    nom.value = ''
    societe.value = ''
    email.value = ''
    telephone.value = ''
    ville.value = ''
    format.value = ''
    message.value = ''
  } catch {
    // handled in store
  }
}
</script>

<template>
  <div>
    <section
      class="relative py-24 md:py-32 bg-cover bg-center"
      style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.55), rgba(0,0,0,0.35)), url('/images/ept-15.png');"
    >
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-white text-4xl sm:text-5xl font-bold tracking-tight mb-4">
          Formation en energie solaire
        </h1>
        <p class="text-white/90 text-lg md:text-xl">
          Electron ProTech dispense des formations pratiques pour techniciens, entreprises et porteurs de projets.
        </p>
      </div>
    </section>

    <section class="py-12 md:py-16">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
          <div class="lg:col-span-1 space-y-6">
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
              <h2 class="text-xl font-bold text-protech-black mb-3">Pourquoi suivre nos formations ?</h2>
              <ul class="space-y-2 text-protech-gray-dark text-sm list-disc pl-4">
                <li>Approche terrain et etudes de cas reels</li>
                <li>Contenus adaptes au contexte local</li>
                <li>Formateurs issus de projets en exploitation</li>
                <li>Attestation de participation en fin de parcours</li>
              </ul>
            </div>
            <div class="p-6 rounded-2xl bg-protech-black text-white">
              <h3 class="font-bold mb-2">Public cible</h3>
              <p class="text-sm text-slate-300">
                Techniciens, electriciens, etudiants, responsables techniques, entreprises et institutions.
              </p>
            </div>
          </div>

          <div class="lg:col-span-2">
            <h2 class="text-2xl font-bold text-protech-black mb-6">Inscription a une formation</h2>
            <form class="space-y-4" @submit="onSubmit">
              <div>
                <label for="nom" class="block text-sm font-medium text-protech-black mb-1">Nom <span class="text-red-600">*</span></label>
                <input
                  id="nom"
                  v-model="nom"
                  type="text"
                  required
                  placeholder="Votre nom complet"
                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
                />
              </div>
              <div>
                <label for="societe" class="block text-sm font-medium text-protech-black mb-1">Entreprise / Organisation</label>
                <input
                  id="societe"
                  v-model="societe"
                  type="text"
                  placeholder="Nom de l'entreprise"
                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
                />
              </div>
              <div>
                <label for="email" class="block text-sm font-medium text-protech-black mb-1">Email <span class="text-red-600">*</span></label>
                <input
                  id="email"
                  v-model="email"
                  type="email"
                  required
                  placeholder="email@exemple.com"
                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
                />
              </div>
              <div>
                <label for="telephone" class="block text-sm font-medium text-protech-black mb-1">Telephone</label>
                <input
                  id="telephone"
                  v-model="telephone"
                  type="tel"
                  placeholder="+237 6XX XXX XXX"
                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
                />
              </div>
              <div>
                <label for="ville" class="block text-sm font-medium text-protech-black mb-1">Ville</label>
                <input
                  id="ville"
                  v-model="ville"
                  type="text"
                  placeholder="Douala, Yaounde..."
                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
                />
              </div>
              <div>
                <label for="format" class="block text-sm font-medium text-protech-black mb-1">Type de formation <span class="text-red-600">*</span></label>
                <select
                  id="format"
                  v-model="format"
                  required
                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
                >
                  <option value="">-- Choisir --</option>
                  <option v-for="item in formats" :key="item" :value="item">{{ item }}</option>
                </select>
              </div>
              <div>
                <label for="message" class="block text-sm font-medium text-protech-black mb-1">Informations complementaires</label>
                <textarea
                  id="message"
                  v-model="message"
                  rows="4"
                  placeholder="Votre niveau, disponibilites, objectifs..."
                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
                />
              </div>

              <div v-if="formsStore.error" class="p-3 rounded-lg bg-red-50 text-red-700 text-sm">
                {{ formsStore.error }}
              </div>
              <div v-if="formsStore.success" class="p-3 rounded-lg bg-green-50 text-green-800 text-sm">
                Votre inscription a bien ete envoyee. Notre equipe vous contactera rapidement.
              </div>

              <button
                type="submit"
                :disabled="formsStore.loading"
                class="w-full md:w-auto inline-flex items-center justify-center px-8 py-3.5 rounded-xl bg-protech-gold hover:bg-protech-gold/90 text-protech-black font-bold shadow-lg disabled:opacity-60 disabled:cursor-not-allowed transition-all"
              >
                {{ formsStore.loading ? 'Envoi...' : "S'inscrire a la formation" }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
