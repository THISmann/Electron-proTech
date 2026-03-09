<script setup lang="ts">
import { ref, computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const menuOpen = ref(false)

const navLinks = [
  { path: '/', label: 'Accueil' },
  { path: '/a-propos', label: 'À propos' },
  { path: '/realisations', label: 'Réalisations' },
  { path: '/simulateur', label: 'Simulateur' },
  { path: '/references', label: 'Références' },
  { path: '/maintenance-sav', label: 'Maintenance SAV' },
  { path: '/blog', label: 'Blog' },
  { path: '/contact', label: 'Contact' },
]

const isActive = (path: string) => {
  if (path === '/') return route.path === '/'
  return route.path.startsWith(path)
}
</script>

<template>
  <header class="bg-protech-black text-white sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-14 md:h-16">
        <router-link to="/" class="ept-nav-logo flex items-center gap-2 text-white font-bold text-lg hover:text-protech-gold transition-colors">
          <span>Electron ProTech</span>
        </router-link>

        <!-- Desktop nav -->
        <nav class="hidden md:flex items-center gap-1">
          <router-link
            v-for="link in navLinks"
            :key="link.path"
            :to="link.path"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors"
            :class="isActive(link.path) ? 'text-protech-green' : 'text-white hover:text-protech-gold'"
          >
            {{ link.label }}
          </router-link>
        </nav>

        <div class="flex items-center gap-3">
          <router-link
            to="/contact?audit=1"
            class="hidden md:inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-protech-gold text-protech-black font-bold text-sm hover:bg-protech-gold/90 transition-all focus:outline-none focus:ring-2 focus:ring-protech-gold focus:ring-offset-2 focus:ring-offset-protech-black"
          >
            Demander un audit
          </router-link>

          <button
            type="button"
            class="md:hidden p-2 rounded-lg text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-protech-gold"
            aria-label="Menu"
            @click="menuOpen = !menuOpen"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path v-if="!menuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile menu -->
      <div
        v-show="menuOpen"
        class="md:hidden absolute top-full left-0 right-0 bg-protech-black border-t border-white/10 py-4 px-4"
      >
        <nav class="flex flex-col gap-1">
          <router-link
            v-for="link in navLinks"
            :key="link.path"
            :to="link.path"
            class="px-4 py-3 rounded-lg font-medium"
            :class="isActive(link.path) ? 'text-protech-green' : 'text-white'"
            @click="menuOpen = false"
          >
            {{ link.label }}
          </router-link>
          <router-link
            to="/contact?audit=1"
            class="mt-2 inline-flex items-center justify-center px-4 py-3 rounded-xl bg-protech-gold text-protech-black font-bold"
            @click="menuOpen = false"
          >
            Demander un audit
          </router-link>
        </nav>
      </div>
    </div>
  </header>
</template>
