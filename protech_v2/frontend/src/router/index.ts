import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', name: 'Home', component: () => import('../views/HomeView.vue'), meta: { title: 'Accueil' } },
    { path: '/a-propos', name: 'APropos', component: () => import('../views/AProposView.vue'), meta: { title: 'À propos' } },
    { path: '/realisations', name: 'Realisations', component: () => import('../views/RealisationsView.vue'), meta: { title: 'Réalisations' } },
    { path: '/simulateur', name: 'Simulateur', component: () => import('../views/SimulateurView.vue'), meta: { title: 'Simulateur' } },
    { path: '/references', name: 'References', component: () => import('../views/ReferencesView.vue'), meta: { title: 'Références' } },
    { path: '/maintenance-sav', name: 'MaintenanceSav', component: () => import('../views/MaintenanceSavView.vue'), meta: { title: 'Maintenance SAV' } },
    { path: '/blog', name: 'Blog', component: () => import('../views/BlogView.vue'), meta: { title: 'Blog' } },
    { path: '/blog/:slug', name: 'BlogPost', component: () => import('../views/BlogPostView.vue'), meta: { title: 'Article' } },
    { path: '/contact', name: 'Contact', component: () => import('../views/ContactView.vue'), meta: { title: 'Contact' } },
  ],
})

router.afterEach((to) => {
  const title = (to.meta.title as string) || 'Electron ProTech'
  document.title = title === 'Accueil' ? 'Electron ProTech – Solutions énergétiques' : `${title} – Electron ProTech`
})

export default router
