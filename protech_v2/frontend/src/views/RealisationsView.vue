<script setup lang="ts">
const introImg = '/images/ept-01.png'
const projects = [
  { title: 'Scierie, Est-Cameroun — 120 kWc', desc: 'Toiture hangar. Facture −48 %, payback 4,5 ans. Maintenance trimestrielle incluse.', img: '/images/ept-01.png' },
  { title: 'Hôtel, Douala — 80 kWc', desc: 'Toiture + ombrière. Autonomie partielle, payback 4,2 ans. Monitoring 24/7.', img: '/images/ept-02.png' },
  { title: 'Unité agroalimentaire, Yaoundé — 150 kWc', desc: 'Centrale au sol. Couverture ~60 % des besoins, ~55 M FCFA/an économisés.', img: '/images/ept-03.png' },
  { title: 'Clinique, Bafoussam — 45 kWc hybride', desc: 'Stockage pour continuité (froid, bloc). Payback 5–6 ans.', img: '/images/ept-04.png' },
  { title: 'Minoterie, Douala — 200 kWc', desc: 'Toiture industrielle. Facture ENEO −52 %. Projet 2025.', img: '/images/ept-05.png' },
  { title: 'Super marché, Yaoundé — 65 kWc', desc: 'Toiture + ombrière. Image « magasin vert », payback 4,8 ans.', img: '/images/ept-06.png' },
  { title: 'Brasserie, Douala — 180 kWc', desc: 'Toiture + sol. Consommation jour/nuit lissée. Facture −55 %, payback 4 ans.', img: '/images/ept-07.png' },
  { title: 'Siège social, Yaoundé — 95 kWc', desc: 'Toiture + ombrière parking. Autoconsommation bureaux et climatisation.', img: '/images/ept-08.png' },
  { title: 'Plantation cacao, Kribi — 60 kWc', desc: 'Site isolé avec stockage. Séchage et transformation sur place.', img: '/images/ept-09.png' },
  { title: 'École privée, Yaoundé — 35 kWc', desc: 'Toiture bâtiment principal. Climatisation et éclairage, facture −40 %. Projet 2025.', img: '/images/ept-10.png' },
]
</script>

<template>
  <div>
    <section
      class="relative py-24 md:py-32 bg-cover bg-center"
      style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.3)), url('/images/ept-01.png');"
    >
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-white text-4xl sm:text-5xl font-bold tracking-tight mb-4">Nos réalisations</h1>
        <p class="text-white/90 text-lg md:text-xl">
          Parcs solaires industriels et commerciaux au Cameroun — industrie, agro, hôtels, institutions
        </p>
      </div>
    </section>

    <section class="py-12 md:py-16">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-protech-gray-dark max-w-2xl mx-auto mb-12">
          Chaque projet est dimensionné pour maximiser les économies d'énergie et le retour sur investissement. Découvrez une sélection d'installations solaires réalisées pour nos clients.
        </p>

        <div class="grid md:grid-cols-2 gap-10 items-center mb-14">
          <div class="rounded-xl overflow-hidden aspect-video bg-slate-200">
            <img :src="introImg" alt="Installation solaire industrielle" class="w-full h-full object-cover" />
          </div>
          <div>
            <h2 class="text-2xl font-bold text-protech-black mb-4">Des projets concrets, des résultats mesurables</h2>
            <p class="text-protech-gray-dark leading-relaxed">
              De la scierie à la minoterie, en passant par l'hôtellerie et la santé, nos installations couvrent 10 à 200 kWc et plus. Factures en baisse, payback typique 4 à 6 ans, maintenance incluse ou en contrat.
            </p>
          </div>
        </div>

        <h2 class="text-2xl font-bold text-protech-black mb-8">Installations réalisées</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-14">
          <article v-for="p in projects" :key="p.title" class="rounded-xl bg-white shadow-md border border-slate-100 overflow-hidden hover:shadow-lg transition-shadow">
            <div class="aspect-[16/10] bg-slate-200 overflow-hidden">
              <img :src="p.img" :alt="p.title" class="w-full h-full object-cover" loading="lazy" />
            </div>
            <div class="p-4">
              <h3 class="font-bold text-protech-black mb-2">{{ p.title }}</h3>
              <p class="text-protech-gray-dark text-sm leading-relaxed">{{ p.desc }}</p>
            </div>
          </article>
        </div>

        <div class="rounded-2xl bg-gradient-to-br from-protech-green to-protech-green-light px-6 py-12 text-center">
          <h2 class="text-white text-2xl font-bold mb-2">Un projet similaire ?</h2>
          <p class="text-white/90 mb-6">Demandez un audit gratuit pour une étude et un devis sur mesure.</p>
          <router-link to="/contact?sujet=devis" class="inline-flex items-center justify-center px-8 py-3.5 rounded-xl bg-protech-gold hover:bg-protech-gold/90 text-protech-black font-bold">
            Demander un audit gratuit
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>
