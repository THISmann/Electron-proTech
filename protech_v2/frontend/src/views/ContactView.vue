<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useFormsStore } from '../stores/forms'

const route = useRoute()
const formsStore = useFormsStore()

const nom = ref('')
const societe = ref('')
const email = ref('')
const telephone = ref('')
const ville = ref('')
const sujet = ref('')
const message = ref('')

const villes = ['Yaoundé', 'Douala', 'Bafoussam', 'Bamenda', 'Garoua', 'Bertoua', 'Kribi', 'Autre']
const sujets = [
  { value: 'Audit gratuit', label: 'Audit énergétique gratuit' },
  { value: 'Devis installation', label: 'Devis installation solaire' },
  { value: 'Devis maintenance', label: 'Devis maintenance' },
  { value: 'Autre', label: 'Autre' },
]

onMounted(() => {
  const audit = route.query.audit
  if (audit) sujet.value = 'Audit gratuit'
  formsStore.resetStatus()
})

async function onSubmit(e: Event) {
  e.preventDefault()
  if (!nom.value.trim() || !email.value.trim() || !sujet.value) return
  try {
    await formsStore.submitForm({
      nom: nom.value.trim(),
      societe: societe.value.trim(),
      email: email.value.trim(),
      telephone: telephone.value.trim(),
      ville: ville.value,
      sujet: sujet.value,
      message: message.value.trim(),
    })
    nom.value = ''
    societe.value = ''
    email.value = ''
    telephone.value = ''
    ville.value = ''
    sujet.value = ''
    message.value = ''
  } catch {
    // error already in store
  }
}
</script>

<template>
  <div>
    <!-- Hero contact -->
    <section
      class="relative py-24 md:py-32 bg-cover bg-center"
      style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.3)), url('/images/ept-15.png');"
    >
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-white text-4xl sm:text-5xl font-bold tracking-tight mb-4">
          Contact & demande de devis
        </h1>
        <p class="text-white/90 text-lg md:text-xl">
          Audit gratuit, devis installation ou maintenance — Réponse sous 24–48 h
        </p>
      </div>
    </section>

    <section class="py-12 md:py-16">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center max-w-2xl mx-auto mb-10 text-protech-gray-dark">
          Remplissez le formulaire ou contactez-nous par téléphone / WhatsApp. Nous vous recontactons sous 24–48 h (jours ouvrés).
        </p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
          <!-- Formulaire -->
          <div class="lg:col-span-2">
            <h2 class="text-2xl font-bold text-protech-black mb-6">Envoyez-nous un message</h2>

            <form class="space-y-4" @submit="onSubmit">
              <div>
                <label for="nom" class="block text-sm font-medium text-protech-black mb-1">Nom <span class="text-red-600">*</span></label>
                <input
                  id="nom"
                  v-model="nom"
                  type="text"
                  required
                  placeholder="Votre nom"
                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
                />
              </div>
              <div>
                <label for="societe" class="block text-sm font-medium text-protech-black mb-1">Société / Entreprise</label>
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
                <label for="telephone" class="block text-sm font-medium text-protech-black mb-1">Téléphone</label>
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
                <select
                  id="ville"
                  v-model="ville"
                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
                >
                  <option value="">— Choisir —</option>
                  <option v-for="v in villes" :key="v" :value="v">{{ v }}</option>
                </select>
              </div>
              <div>
                <label for="sujet" class="block text-sm font-medium text-protech-black mb-1">Sujet <span class="text-red-600">*</span></label>
                <select
                  id="sujet"
                  v-model="sujet"
                  required
                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
                >
                  <option value="">— Choisir —</option>
                  <option v-for="s in sujets" :key="s.value" :value="s.value">{{ s.label }}</option>
                </select>
              </div>
              <div>
                <label for="message" class="block text-sm font-medium text-protech-black mb-1">Message</label>
                <textarea
                  id="message"
                  v-model="message"
                  rows="4"
                  placeholder="Décrivez brièvement votre projet ou votre demande..."
                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
                />
              </div>

              <div v-if="formsStore.error" class="p-3 rounded-lg bg-red-50 text-red-700 text-sm">
                {{ formsStore.error }}
              </div>
              <div v-if="formsStore.success" class="p-3 rounded-lg bg-green-50 text-green-800 text-sm">
                Votre demande a bien été envoyée. Nous vous recontactons sous 24–48 h.
              </div>

              <button
                type="submit"
                :disabled="formsStore.loading"
                class="w-full md:w-auto inline-flex items-center justify-center px-8 py-3.5 rounded-xl bg-protech-gold hover:bg-protech-gold/90 text-protech-black font-bold shadow-lg disabled:opacity-60 disabled:cursor-not-allowed transition-all"
              >
                {{ formsStore.loading ? 'Envoi…' : 'Envoyer la demande' }}
              </button>
            </form>
          </div>

          <!-- Colonne infos -->
          <div class="lg:col-span-1">
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
              <h3 class="font-bold text-protech-black text-lg mb-4">Coordonnées</h3>
              <p class="text-protech-gray-dark text-sm mb-3"><strong>📞 Téléphone</strong><br />698 85 07 12 / 678 82 25 24</p>
              <p class="text-protech-gray-dark text-sm mb-3"><strong>✉️ Email</strong><br />contact@electronprotech.cm</p>
              <p class="text-protech-gray-dark text-sm"><strong>📍 Adresse</strong><br />Douala face Saker PK10</p>
            </div>
            <p class="mt-6 text-protech-gray-dark text-sm">
              <strong>Zone d'intervention :</strong> Cameroun (Yaoundé, Douala, Bafoussam, Bamenda, Garoua) — Export possible Gabon, RCA, Tchad.
            </p>
          </div>
        </div>

        <div class="mt-12 p-6 rounded-2xl bg-slate-100 text-center">
          <h2 class="text-xl font-bold text-protech-black mb-2">Besoin d'une réponse immédiate ?</h2>
          <p class="text-protech-gray-dark text-sm">
            Écrivez-nous sur <strong>WhatsApp</strong> avec le bouton flottant en bas à droite.<br />
            Message pré-rempli : « Bonjour, je souhaite un audit solaire pour mon entreprise à [ville]. »
          </p>
        </div>
      </div>
    </section>
  </div>
</template>
