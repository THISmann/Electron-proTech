<script setup lang="ts">
const values = [
  { icon: '👷', title: 'Équipe locale', text: 'Techniciens et ingénieurs formés aux normes, interventions à Yaoundé, Douala, Bafoussam, Bamenda, Garoua et en région.' },
  { icon: '✓', title: 'Fiabilité', text: 'Respect des délais, qualité des installations, suivi post-vente.' },
  { icon: '🤝', title: 'Proximité', text: 'Écoute du besoin, dimensionnement réaliste, pas de surdimensionnement.' },
  { icon: '🌱', title: 'Durabilité', text: 'Maintenance pour garantir rendement et durée de vie des centrales.' },
]
</script>

<template>
  <div>
    <section
      class="relative py-24 md:py-32 bg-cover bg-center"
      style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.3)), url('/images/ept-06.png');"
    >
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-white text-4xl sm:text-5xl font-bold tracking-tight mb-4">À propos d'Electron ProTech</h1>
        <p class="text-white/90 text-lg md:text-xl">
          Votre partenaire solaire industriel au Cameroun — installation, maintenance, transition énergétique
        </p>
      </div>
    </section>

    <section class="py-12 md:py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-protech-gray-dark text-lg max-w-2xl mx-auto mb-12">
          Nous sommes une entreprise camerounaise spécialisée dans l'<strong>installation</strong> et la <strong>maintenance</strong> de parcs solaires industriels et commerciaux. Nous accompagnons les industries, l'agroalimentaire, les hôtels, les institutions et les PME dans leur transition énergétique au Cameroun et en Afrique centrale.
        </p>

        <div class="grid md:grid-cols-2 gap-10 items-center mb-14">
          <div class="rounded-xl overflow-hidden aspect-video bg-slate-200">
            <img src="/images/ept-07.png" alt="Parc solaire Electron ProTech" class="w-full h-full object-cover" />
          </div>
          <div>
            <h2 class="text-2xl font-bold text-protech-black mb-4">Notre histoire</h2>
            <p class="text-protech-gray-dark leading-relaxed">
              Née de l'expérience terrain et du constat des délestages et du coût croissant de l'énergie, Electron ProTech s'est structurée pour offrir des solutions solaires fiables, du dimensionnement à la maintenance. Nous privilégions des équipes locales formées et des partenariats durables avec nos clients.
            </p>
          </div>
        </div>

        <h2 class="text-2xl font-bold text-protech-black mb-6">Nos valeurs</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-14">
          <div v-for="v in values" :key="v.title" class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
            <div class="w-12 h-12 rounded-xl bg-protech-green-light flex items-center justify-center text-xl text-white mb-4">{{ v.icon }}</div>
            <h3 class="font-bold text-protech-black mb-2">{{ v.title }}</h3>
            <p class="text-protech-gray-dark text-sm leading-relaxed">{{ v.text }}</p>
          </div>
        </div>

        <h2 class="text-2xl font-bold text-protech-black mb-4">Zone d'intervention</h2>
        <div class="grid md:grid-cols-2 gap-10 items-center mb-14">
          <div>
            <p class="text-protech-gray-dark mb-2"><strong>Cameroun</strong> — Yaoundé, Douala (prioritaires), Bafoussam, Bamenda, Garoua, Bertoua et environs.</p>
            <p class="text-protech-gray-dark"><strong>Export régional</strong> — Projets possibles au Gabon, en République centrafricaine et au Tchad selon les conditions.</p>
          </div>
          <div class="rounded-xl overflow-hidden aspect-video bg-slate-200">
            <img src="/images/ept-08.png" alt="Carte Afrique centrale" class="w-full h-full object-cover" />
          </div>
        </div>

        <h2 class="text-2xl font-bold text-protech-black mb-4">Partenaires & certifications</h2>
        <p class="text-protech-gray-dark mb-10">
          Nous travaillons avec des fournisseurs reconnus (panneaux, onduleurs, structures) et nous conformons aux bonnes pratiques du secteur. Les certifications et agréments spécifiques peuvent être communiqués sur demande.
        </p>

        <div class="rounded-2xl bg-gradient-to-br from-protech-green to-protech-green-light px-6 py-12 text-center">
          <h2 class="text-white text-2xl font-bold mb-2">Envie de travailler avec nous ?</h2>
          <p class="text-white/90 mb-6">Audit gratuit, devis ou question sur nos services :</p>
          <router-link to="/contact" class="inline-flex items-center justify-center px-8 py-3.5 rounded-xl bg-protech-gold hover:bg-protech-gold/90 text-protech-black font-bold">
            Nous contacter
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>
