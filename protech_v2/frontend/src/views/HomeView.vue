<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

const slides = [
  {
    tag: 'Aidez à construire un avenir plus durable',
    title: "Nous sommes un acteur de la distribution et de l'installation photovoltaïque au Cameroun",
    text: "Venez découvrir les avantages de nos solutions solaires sur mesure pour l'industrie et le tertiaire.",
    primary: 'En savoir plus',
    primaryTo: '/',
    secondary: 'Demander un audit',
    secondaryTo: '/contact?audit=1',
    img: '/images/ept-01.png',
  },
  {
    tag: 'Solutions entreprises',
    title: 'Installation & maintenance',
    text: 'PV et stockage. ROI 4 à 6 ans, suivi technique sur site.',
    primary: 'En savoir plus',
    primaryTo: '/contact?audit=1',
    img: '/images/ept-02.png',
  },
  {
    tag: 'Étude sur mesure',
    title: 'Audit énergétique',
    text: 'Dimensionnement, économies prévisionnelles, plan de financement.',
    primary: 'Demander un audit',
    primaryTo: '/contact?audit=1',
    img: '/images/ept-03.png',
  },
  {
    tag: 'Projets réalisés',
    title: 'Nos réalisations',
    text: 'Scieries, hôtels, agroalimentaire, cliniques — Cameroun.',
    primary: 'Voir les réalisations',
    primaryTo: '/realisations',
    img: '/images/ept-04.png',
  },
  {
    tag: 'Expertise locale',
    title: 'Énergie solaire Cameroun',
    text: 'Équipes formées. Réduction délestages et facture.',
    primary: 'Nous contacter',
    primaryTo: '/contact',
    img: '/images/ept-05.png',
  },
]

const currentSlide = ref(0)
let timer: ReturnType<typeof setInterval> | null = null

function goTo(i: number) {
  currentSlide.value = i
}

function startAutoPlay() {
  timer = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % slides.length
  }, 5000)
}

function stopAutoPlay() {
  if (timer) clearInterval(timer)
}

onMounted(() => startAutoPlay())
onUnmounted(() => stopAutoPlay())

const services = [
  {
    title: 'Système solaire',
    desc: "Vente, installation et maintenance des équipements d'énergie solaire. Étude et installation des forages solaires.",
    to: '/contact?sujet=solaire',
    icon: 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z',
  },
  {
    title: 'Système de sécurité',
    desc: "Installation des caméras de surveillance, contrôleurs d'accès et systèmes domotiques.",
    to: '/contact?sujet=securite',
    icon: 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
  },
  {
    title: 'Système embarqué',
    desc: 'Conception et vente des logiciels et cartes électroniques. Formation en électronique.',
    to: '/contact?sujet=embarque',
    icon: 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z',
  },
  {
    title: 'Électricité générale',
    desc: "Étude et mise en œuvre des schémas électriques. Électricité bâtiment et industrielle.",
    to: '/contact?sujet=electricite',
    icon: 'M13 10V3L4 14h7v7l9-11h-7z',
  },
  {
    title: 'Automatique',
    desc: 'Réalisation des portes et portails automatiques. Cartes de contrôle et de commande.',
    to: '/contact?sujet=automatique',
    icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
  },
]
</script>

<template>
  <div>
    <!-- Hero carousel -->
    <section class="relative overflow-hidden w-full" aria-label="Carrousel ProTech">
      <div
        class="flex h-[100vh] min-h-[500px] transition-transform duration-500 ease-out"
        :style="{ width: slides.length * 100 + '%', transform: `translateX(-${currentSlide * (100 / slides.length)}%)` }"
      >
        <div
          v-for="(slide, i) in slides"
          :key="i"
          class="flex-shrink-0 relative"
          :style="{ width: 100 / slides.length + '%' }"
        >
          <img
            :src="slide.img"
            :alt="slide.title"
            class="absolute inset-0 w-full h-full object-cover"
            loading="eager"
          />
          <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent" />
          <div class="absolute inset-0 flex flex-col justify-center z-10">
            <div class="w-full max-w-7xl mx-auto px-6 sm:px-8 md:px-12 lg:px-16 xl:px-20">
              <div class="max-w-2xl">
                <p class="text-protech-gold text-xs sm:text-sm font-semibold uppercase tracking-[0.2em] mb-3">
                  {{ slide.tag }}
                </p>
                <h1 class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-[1.1] tracking-tight mb-4 drop-shadow-2xl">
                  {{ slide.title }}
                </h1>
                <p class="text-white/90 text-base md:text-lg leading-relaxed mb-8 max-w-xl">
                  {{ slide.text }}
                </p>
                <div class="flex flex-wrap gap-3 sm:gap-4">
                  <router-link
                    :to="slide.primaryTo"
                    class="inline-flex items-center justify-center px-6 py-3.5 rounded-xl bg-protech-gold hover:bg-protech-gold/90 text-protech-black font-bold text-sm sm:text-base shadow-lg hover:shadow-xl transition-all duration-200"
                  >
                    {{ slide.primary }}
                  </router-link>
                  <router-link
                    v-if="slide.secondary"
                    :to="slide.secondaryTo"
                    class="inline-flex items-center justify-center px-6 py-3.5 rounded-xl border-2 border-white text-white font-bold text-sm sm:text-base hover:bg-white/10 transition-all duration-200"
                  >
                    {{ slide.secondary }}
                  </router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="absolute bottom-8 left-0 right-0 flex gap-2.5 justify-center z-20" aria-hidden="true">
        <button
          v-for="(_, i) in slides"
          :key="i"
          type="button"
          class="w-3 h-3 rounded-full transition-all duration-200 cursor-pointer"
          :class="currentSlide === i ? 'bg-protech-gold ring-2 ring-white ring-offset-2 ring-offset-transparent' : 'bg-white/40 hover:bg-white/60 hover:scale-110'"
          :aria-label="'Slide ' + (i + 1)"
          @click="goTo(i)"
        />
      </div>
    </section>

    <!-- Partenaires -->
    <section class="py-16 md:py-24 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-sm font-semibold uppercase tracking-[0.2em] text-protech-green mb-2">
          Partenaires de confiance
        </p>
        <h2 class="text-center text-2xl sm:text-3xl md:text-4xl font-bold text-protech-black tracking-tight max-w-2xl mx-auto mb-4">
          Produits de qualité · Les plus grandes marques
        </h2>
        <p class="text-center text-protech-gray-dark text-base md:text-lg max-w-xl mx-auto mb-10 leading-relaxed">
          Nous distribuons des modules et onduleurs de fabricants reconnus (Tier 1) pour vos projets solaires.
        </p>
        <div class="flex flex-wrap justify-center gap-3">
          <span class="px-4 py-2.5 rounded-xl bg-slate-100 text-protech-gray-dark text-sm font-medium">Panneaux haute performance</span>
          <span class="px-4 py-2.5 rounded-xl bg-slate-100 text-protech-gray-dark text-sm font-medium">Onduleurs on-grid & hybrides</span>
          <span class="px-4 py-2.5 rounded-xl bg-slate-100 text-protech-gray-dark text-sm font-medium">Stockage batterie</span>
          <span class="px-4 py-2.5 rounded-xl bg-slate-100 text-protech-gray-dark text-sm font-medium">Structures & montage</span>
          <span class="px-4 py-2.5 rounded-xl bg-slate-100 text-protech-gray-dark text-sm font-medium">Monitoring</span>
        </div>
      </div>
    </section>

    <!-- Nos services -->
    <section class="py-12 md:py-20 bg-gradient-to-b from-emerald-50/70 via-white to-slate-50/50">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 md:mb-14">
          <p class="text-xs sm:text-sm font-semibold uppercase tracking-[0.2em] text-protech-green mb-2">
            Un partenaire pour chaque entreprise
          </p>
          <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-protech-black tracking-tight max-w-2xl mx-auto mb-3 leading-snug">
            Nos services
          </h2>
          <p class="text-protech-gray-dark text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
            Solaire, sécurité, électricité, automatisme et systèmes embarqués — Douala & Cameroun.
          </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 sm:gap-5 lg:gap-6">
          <router-link
            v-for="s in services"
            :key="s.title"
            :to="s.to"
            class="group relative block p-5 sm:p-6 rounded-xl bg-white shadow-md border border-slate-100 hover:shadow-lg hover:border-protech-green/30 hover:-translate-y-0.5 transition-all duration-200 overflow-hidden"
          >
            <div class="absolute top-0 right-0 w-24 h-24 bg-protech-green/5 rounded-bl-full transition-transform group-hover:scale-110" />
            <div class="relative w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-gradient-to-br from-protech-green to-protech-green-light flex items-center justify-center mb-4 text-white shadow-md flex-shrink-0">
              <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="s.icon" />
              </svg>
            </div>
            <h3 class="relative text-base sm:text-lg font-bold text-protech-black mb-2">{{ s.title }}</h3>
            <p class="relative text-protech-gray-dark text-[13px] sm:text-sm leading-relaxed line-clamp-3">{{ s.desc }}</p>
          </router-link>
        </div>
        <p class="text-center text-protech-gray-dark text-xs sm:text-sm mt-8">
          Contact : 698 85 07 12 / 678 82 25 24 — Siège : Douala face Saker PK10
        </p>
      </div>
    </section>

    <!-- Chiffres clés -->
    <section class="py-14 md:py-20 bg-protech-black">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12 text-center">
          <div>
            <p class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight">+50</p>
            <p class="mt-1 text-sm md:text-base text-slate-300">Projets réalisés</p>
          </div>
          <div>
            <p class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight">5 MWc</p>
            <p class="mt-1 text-sm md:text-base text-slate-300">Puissance installée</p>
          </div>
          <div>
            <p class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight">10+</p>
            <p class="mt-1 text-sm md:text-base text-slate-300">Années d'expérience</p>
          </div>
          <div>
            <p class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight">3</p>
            <p class="mt-1 text-sm md:text-base text-slate-300">Régions couvertes</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA final -->
    <section class="py-8 md:py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl bg-gradient-to-br from-protech-green to-protech-green-light px-6 py-12 md:py-16 text-center shadow-xl">
          <p class="text-white/90 text-sm font-semibold uppercase tracking-[0.2em] mb-2">Rejoignez-nous</p>
          <h2 class="text-white text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight mb-4">
            Prêt à réduire votre facture et votre empreinte carbone ?
          </h2>
          <p class="text-white/90 text-base md:text-lg max-w-xl mx-auto mb-8">
            Demandez un audit énergétique gratuit pour votre site. Sans engagement. Réponse sous 24–48 h.
          </p>
          <router-link
            to="/contact?audit=1"
            class="inline-flex items-center justify-center px-8 py-4 rounded-xl bg-protech-gold hover:bg-protech-gold/90 text-protech-black font-bold shadow-lg hover:shadow-xl transition-all duration-200"
          >
            Demander un audit énergétique gratuit
          </router-link>
          <p class="mt-6 text-white/80 text-sm">
            Besoin d'une réponse rapide ? Écrivez-nous sur <strong>WhatsApp</strong> (bouton en bas à droite).
          </p>
        </div>
      </div>
    </section>
  </div>
</template>
