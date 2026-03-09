<script setup lang="ts">
const currentYear = new Date().getFullYear()
</script>

<template>
  <footer class="bg-protech-black text-white py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        <div>
          <h3 class="font-bold text-lg text-white mb-3">Electron ProTech</h3>
          <p class="text-slate-400 text-sm leading-relaxed">
            Distribution et installation photovoltaïque au Cameroun. Solaire, sécurité, électricité, automatisme.
          </p>
        </div>
        <div>
          <h3 class="font-bold text-lg text-white mb-3">Liens</h3>
          <ul class="space-y-2">
            <li><router-link to="/" class="text-slate-400 hover:text-protech-gold text-sm transition-colors">Accueil</router-link></li>
            <li><router-link to="/a-propos" class="text-slate-400 hover:text-protech-gold text-sm transition-colors">À propos</router-link></li>
            <li><router-link to="/realisations" class="text-slate-400 hover:text-protech-gold text-sm transition-colors">Réalisations</router-link></li>
            <li><router-link to="/simulateur" class="text-slate-400 hover:text-protech-gold text-sm transition-colors">Simulateur</router-link></li>
            <li><router-link to="/references" class="text-slate-400 hover:text-protech-gold text-sm transition-colors">Références</router-link></li>
            <li><router-link to="/maintenance-sav" class="text-slate-400 hover:text-protech-gold text-sm transition-colors">Maintenance SAV</router-link></li>
            <li><router-link to="/blog" class="text-slate-400 hover:text-protech-gold text-sm transition-colors">Blog</router-link></li>
            <li><router-link to="/contact" class="text-slate-400 hover:text-protech-gold text-sm transition-colors">Contact</router-link></li>
          </ul>
        </div>
        <div>
          <h3 class="font-bold text-lg text-white mb-3">Contact</h3>
          <p class="text-slate-400 text-sm">Siège : Douala face Saker PK10</p>
          <p class="text-slate-400 text-sm mt-1">698 85 07 12 / 678 82 25 24</p>
        </div>
      </div>
      <div class="border-t border-white/10 pt-8 text-center text-slate-500 text-sm">
        © {{ currentYear }} Electron ProTech. Tous droits réservés.
      </div>
    </div>
  </footer>
</template>
