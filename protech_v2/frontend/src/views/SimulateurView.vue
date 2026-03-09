<script setup lang="ts">
import { ref, computed } from 'vue'

const factureMensuelle = ref<number>(5000000) // FCFA
const puissanceGen = ref<number>(0) // kW
const zone = ref<'douala' | 'yaounde' | 'autre'>('douala')

// Estimation simplifiée : facture annuelle ~ 12 * mensuel, économie solaire typique 40–60 %
const factureAnnuelle = computed(() => factureMensuelle.value * 12)
const economieEstimee = computed(() => Math.round(factureAnnuelle.value * 0.45 / 1_000_000)) // M FCFA
const paybackTypique = computed(() => (factureAnnuelle.value > 50_000_000 ? '4–5 ans' : '5–6 ans'))

const exemples = [
  { kw: '50 kWc', text: "~75 000 kWh/an : économies de l'ordre de 75 à 110 M FCFA/an vs ENEO. Payback souvent 4–6 ans." },
  { kw: '100 kWc', text: 'Économies typiques 150 à 220 M FCFA/an, payback 4–5,5 ans au Cameroun.' },
  { kw: 'Facteurs', text: 'Irradiation, tarif ENEO (~110–140 FCFA/kWh), coût au Wc (350–550 FCFA/Wc), subventions possibles.' },
]
</script>

<template>
  <div>
    <section
      class="relative py-24 md:py-32 bg-cover bg-center"
      style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.3)), url('/images/ept-13.png');"
    >
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-white text-4xl sm:text-5xl font-bold tracking-tight mb-4">Simulateur & économies</h1>
        <p class="text-white/90 text-lg md:text-xl">
          Estimez votre potentiel solaire et vos économies en quelques clics
        </p>
      </div>
    </section>

    <section class="py-12 md:py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-protech-gray-dark max-w-2xl mx-auto mb-12">
          Utilisez l'outil ci-dessous pour une première estimation. Les chiffres sont indicatifs ; un audit sur site permet d'affiner le dimensionnement et le devis.
        </p>

        <div class="grid md:grid-cols-2 gap-10 items-center mb-14">
          <div>
            <h2 class="text-2xl font-bold text-protech-black mb-4">Comment ça marche ?</h2>
            <p class="text-protech-gray-dark leading-relaxed">
              Indiquez votre <strong>facture ENEO mensuelle</strong> (FCFA), la <strong>puissance de votre groupe électrogène</strong> si vous en avez un, et votre <strong>zone</strong>. Le simulateur estime la consommation annuelle, la part couverte par le solaire, les économies annuelles et le payback typique.
            </p>
          </div>
          <div class="rounded-xl overflow-hidden aspect-video bg-slate-200">
            <img src="/images/ept-14.png" alt="Installation solaire" class="w-full h-full object-cover" />
          </div>
        </div>

        <h2 class="text-2xl font-bold text-protech-black mb-6">Exemples chiffrés 2026 (ordre de grandeur)</h2>
        <div class="grid sm:grid-cols-3 gap-6 mb-6">
          <div v-for="ex in exemples" :key="ex.kw" class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
            <div class="w-12 h-12 rounded-xl bg-protech-green-light flex items-center justify-center text-white font-bold text-sm mb-4">{{ ex.kw }}</div>
            <h3 class="font-bold text-protech-black mb-2">{{ ex.kw }}</h3>
            <p class="text-protech-gray-dark text-sm leading-relaxed">{{ ex.text }}</p>
          </div>
        </div>
        <p class="text-center text-protech-gray-dark text-sm mb-12">
          Les incitations (tax break 30–50 %, subventions entreprises) peuvent réduire encore le payback.
        </p>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 md:p-8 mb-12">
          <h2 class="text-2xl font-bold text-protech-black mb-2">Faites votre simulation</h2>
          <p class="text-protech-gray-dark mb-6">Remplissez le formulaire pour une estimation instantanée. Pour une étude détaillée, demandez un audit gratuit.</p>

          <div class="space-y-4 max-w-md">
            <div>
              <label class="block text-sm font-medium text-protech-black mb-1">Facture ENEO mensuelle (FCFA)</label>
              <input
                v-model.number="factureMensuelle"
                type="number"
                min="0"
                step="100000"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-protech-black mb-1">Puissance groupe électrogène (kW) — optionnel</label>
              <input
                v-model.number="puissanceGen"
                type="number"
                min="0"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-protech-black mb-1">Zone</label>
              <select
                v-model="zone"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-protech-green focus:border-protech-green"
              >
                <option value="douala">Douala</option>
                <option value="yaounde">Yaoundé</option>
                <option value="autre">Autre</option>
              </select>
            </div>
          </div>

          <div class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-100">
            <p class="text-protech-gray-dark text-sm"><strong>Facture annuelle estimée :</strong> {{ (factureAnnuelle / 1000000).toFixed(1) }} M FCFA</p>
            <p class="text-protech-gray-dark text-sm mt-1"><strong>Économies solaire (ordre de grandeur) :</strong> ~{{ economieEstimee }} M FCFA/an</p>
            <p class="text-protech-gray-dark text-sm mt-1"><strong>Payback typique :</strong> {{ paybackTypique }}</p>
          </div>
        </div>

        <p class="text-center">
          <router-link to="/contact?sujet=audit" class="inline-flex items-center justify-center px-8 py-3.5 rounded-xl bg-protech-gold hover:bg-protech-gold/90 text-protech-black font-bold">
            Demander un audit gratuit pour une étude détaillée
          </router-link>
        </p>
      </div>
    </section>
  </div>
</template>
