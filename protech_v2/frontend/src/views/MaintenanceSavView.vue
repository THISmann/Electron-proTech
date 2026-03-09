<script setup lang="ts">
const formules = [
  { icon: '🧹', title: 'Préventive', text: 'Nettoyage 1–2 fois/an, contrôle visuel, rapport. Tous parcs.' },
  { icon: '📡', title: 'Préventive +', text: 'Thermographie IR, analyse monitoring. Parcs > 50 kWc.' },
  { icon: '⚙️', title: 'Curative', text: 'Dépannage, pièces, mise en conformité. 24–48 h selon contrat.' },
]
const interventions = [
  'Nettoyage panneaux après saison sèche (poussière, sable).',
  'Remplacement onduleur défaillant.',
  'Vérification et serrage des connexions.',
  'Analyse thermographique et rapport avec préconisations.',
  'Mise à jour logicielle des systèmes de monitoring.',
]
</script>

<template>
  <div>
    <section
      class="relative py-24 md:py-32 bg-cover bg-center"
      style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.3)), url('/images/ept-11.png');"
    >
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-white text-4xl sm:text-5xl font-bold tracking-tight mb-4">Maintenance & SAV de parcs solaires</h1>
        <p class="text-white/90 text-lg md:text-xl">
          Nettoyage, thermographie, monitoring — Cameroun et pays limitrophes
        </p>
      </div>
    </section>

    <section class="py-12 md:py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-protech-gray-dark text-lg mb-12">
          Une installation solaire bien entretenue conserve son rendement et sa durée de vie. Nous proposons des <strong>contrats de maintenance</strong> (nettoyage, thermographie, monitoring) et des <strong>interventions curatives</strong> (dépannage, pièces détachées) pour les parcs que nous avons installés comme pour ceux réalisés par d'autres.
        </p>

        <div class="grid md:grid-cols-2 gap-10 items-center mb-14">
          <div class="rounded-xl overflow-hidden aspect-video bg-slate-200 order-2 md:order-1">
            <img src="/images/ept-12.png" alt="Équipe maintenance" class="w-full h-full object-cover" />
          </div>
          <div class="order-1 md:order-2">
            <h2 class="text-2xl font-bold text-protech-black mb-4">Pourquoi faire entretenir votre parc par des professionnels ?</h2>
            <p class="text-protech-gray-dark mb-4">
              Sans entretien, poussière, chaleur et pluies peuvent dégrader les performances de <strong>15 à 30 %</strong>.
            </p>
            <ul class="space-y-2 text-protech-gray-dark mb-4">
              <li><strong>Rendement</strong> — Nettoyage régulier pour préserver les kWh.</li>
              <li><strong>Détection précoce</strong> — Thermographie et monitoring pour repérer anomalies.</li>
              <li><strong>Sécurité</strong> — Vérification connexions, structures, câblage.</li>
              <li><strong>Garanties</strong> — Respect des préconisations fabricants.</li>
            </ul>
            <p class="text-protech-gray-dark">
              Résultat : rendement maintenu au-delà de <strong>95 %</strong>, durée de vie prolongée de <strong>20 à 30 %</strong>.
            </p>
          </div>
        </div>

        <h2 class="text-2xl font-bold text-protech-black mb-6">Nos formules de maintenance</h2>
        <div class="grid sm:grid-cols-3 gap-6 mb-14">
          <div v-for="f in formules" :key="f.title" class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
            <div class="w-12 h-12 rounded-xl bg-protech-green-light flex items-center justify-center text-xl text-white mb-4">{{ f.icon }}</div>
            <h3 class="font-bold text-protech-black mb-2">{{ f.title }}</h3>
            <p class="text-protech-gray-dark text-sm leading-relaxed">{{ f.text }}</p>
          </div>
        </div>

        <h2 class="text-2xl font-bold text-protech-black mb-4">Exemples d'interventions</h2>
        <ul class="space-y-2 text-protech-gray-dark mb-14 list-disc list-inside">
          <li v-for="item in interventions" :key="item">{{ item }}</li>
        </ul>

        <div class="rounded-2xl bg-gradient-to-br from-protech-green to-protech-green-light px-6 py-12 text-center">
          <h2 class="text-white text-2xl font-bold mb-2">Demander un devis maintenance</h2>
          <p class="text-white/90 mb-6">Installation Electron ProTech ou parc réalisé par un tiers : nous proposons un contrat adapté.</p>
          <router-link to="/contact?sujet=maintenance" class="inline-flex items-center justify-center px-8 py-3.5 rounded-xl bg-protech-gold hover:bg-protech-gold/90 text-protech-black font-bold">
            Demander un devis maintenance
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>
