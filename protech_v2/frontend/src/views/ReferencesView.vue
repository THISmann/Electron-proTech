<script setup lang="ts">
const testimonials = [
  { quote: "« Après notre installation de 120 kWc, la facture a chuté d'environ 48 %. L'équipe a tenu les délais et nous a formés à la surveillance. »", cite: 'Responsable technique, scierie, Est-Cameroun', img: '/images/ept-12.png' },
  { quote: "« Nous avons fait confiance à Electron ProTech pour notre hôtel à Douala. Moins de coupures, meilleur confort clients, suivi maintenance réactif. »", cite: 'Directeur, établissement hôtelier, Douala', img: '/images/ept-04.png' },
  { quote: "« La maintenance trimestrielle et le monitoring nous rassurent. En cas d'alerte, l'équipe intervient rapidement. »", cite: 'Responsable énergie, agro-industrie, Yaoundé', img: '/images/ept-06.png' },
  { quote: "« Centrale de 200 kWc livrée dans les temps. Nous avons réduit notre facture ENEO de plus de 50 %. »", cite: 'Direction, minoterie, Douala', img: '/images/ept-03.png' },
]
const sectors = [
  { icon: '🏭', title: 'Industrie', text: 'Scieries, minoteries, brasseries, agroalimentaire' },
  { icon: '🌾', title: 'Agro-industrie', text: 'Plantations, transformation' },
  { icon: '🏨', title: 'Hôtels & lodges', text: 'Climatisation, continuité' },
  { icon: '🏥', title: 'Santé', text: 'Cliniques, hôpitaux' },
  { icon: '🛒', title: 'Commerce', text: 'Supermarchés' },
  { icon: '🏛️', title: 'Institutions & PME', text: 'Bureaux, sites' },
]
</script>

<template>
  <div>
    <section
      class="relative py-24 md:py-32 bg-cover bg-center"
      style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.3)), url('/images/ept-05.png');"
    >
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-white text-4xl sm:text-5xl font-bold tracking-tight mb-4">Références & témoignages</h1>
        <p class="text-white/90 text-lg md:text-xl">
          Ce que disent nos clients — industrie, agro, hôtellerie, institutions
        </p>
      </div>
    </section>

    <section class="py-12 md:py-16">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-protech-gray-dark max-w-2xl mx-auto mb-12">
          Nos clients témoignent de leur expérience avec Electron ProTech : installation, maintenance et accompagnement au quotidien.
        </p>

        <h2 class="text-2xl font-bold text-protech-black mb-8">Témoignages clients</h2>
        <div class="grid md:grid-cols-2 gap-6 mb-14">
          <article v-for="t in testimonials" :key="t.cite" class="flex gap-4 p-6 rounded-2xl bg-white border border-slate-100 shadow-md">
            <div class="flex-shrink-0 w-16 h-16 rounded-full overflow-hidden bg-slate-200">
              <img :src="t.img" alt="" class="w-full h-full object-cover" />
            </div>
            <div>
              <blockquote class="text-protech-gray-dark leading-relaxed mb-3">{{ t.quote }}</blockquote>
              <cite class="not-italic text-sm font-semibold text-protech-green">— {{ t.cite }}</cite>
            </div>
          </article>
        </div>

        <h2 class="text-2xl font-bold text-protech-black mb-8">Secteurs accompagnés</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-14">
          <div v-for="s in sectors" :key="s.title" class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
            <div class="w-12 h-12 rounded-xl bg-protech-green-light flex items-center justify-center text-xl text-white mb-4">{{ s.icon }}</div>
            <h3 class="font-bold text-protech-black mb-2">{{ s.title }}</h3>
            <p class="text-protech-gray-dark text-sm">{{ s.text }}</p>
          </div>
        </div>

        <div class="rounded-2xl bg-gradient-to-br from-protech-green to-protech-green-light px-6 py-12 text-center">
          <h2 class="text-white text-2xl font-bold mb-2">Rejoignez nos références</h2>
          <p class="text-white/90 mb-6">Demandez un audit gratuit pour votre projet.</p>
          <router-link to="/contact?sujet=audit" class="inline-flex items-center justify-center px-8 py-3.5 rounded-xl bg-protech-gold hover:bg-protech-gold/90 text-protech-black font-bold mr-2">
            Demander un audit gratuit
          </router-link>
          <router-link to="/realisations" class="inline-flex items-center justify-center px-8 py-3.5 rounded-xl border-2 border-white text-white font-bold hover:bg-white/10">
            Voir nos réalisations
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>
