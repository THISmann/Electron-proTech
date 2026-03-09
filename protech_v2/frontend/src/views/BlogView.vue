<script setup lang="ts">
import { onMounted, computed } from 'vue'
import { useBlogStore } from '../stores/blog'
import type { BlogArticle } from '../stores/blog'

const blog = useBlogStore()

const featured = computed<BlogArticle | null>(() => blog.list[0] ?? null)
const rest = computed<BlogArticle[]>(() => blog.list.slice(1))

function formatDate(iso: string) {
  return new Date(iso).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })
}

onMounted(() => blog.fetchList())
</script>

<template>
  <div>
    <!-- Hero blog -->
    <section
      class="relative py-24 md:py-32 bg-cover bg-center"
      style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.3)), url('/images/blog-01.png');"
    >
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-white text-4xl sm:text-5xl font-bold tracking-tight mb-4">Blog</h1>
        <p class="text-white/90 text-lg md:text-xl">
          Actualités solaire, conseils et tendances — Cameroun & Afrique centrale
        </p>
      </div>
    </section>

    <section class="py-12 md:py-16">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-protech-gray-dark max-w-2xl mx-auto mb-12">
          Retrouvez nos articles sur l'énergie solaire, les installations, la maintenance et le contexte énergétique au Cameroun.
        </p>

        <div v-if="blog.loading" class="text-center py-12 text-protech-gray-dark">Chargement…</div>
        <div v-else-if="blog.error" class="text-center py-12 text-red-600">{{ blog.error }}</div>

        <template v-else>
          <!-- Article mis en avant -->
          <article
            v-if="featured"
            class="flex flex-col md:flex-row gap-8 mb-14 p-6 rounded-2xl bg-white shadow-lg border border-slate-100"
          >
            <div class="md:w-2/5 rounded-xl overflow-hidden flex-shrink-0">
              <img
                v-if="featured.imageUrl"
                :src="featured.imageUrl"
                :alt="featured.title"
                class="w-full h-56 md:h-full object-cover"
              />
              <div v-else class="w-full h-56 md:min-h-[280px] bg-slate-200 rounded-xl" />
              <span class="inline-block mt-3 text-xs font-semibold uppercase tracking-wider text-protech-green">
                {{ featured.category }}
              </span>
            </div>
            <div class="md:w-3/5 flex flex-col justify-center">
              <time class="text-sm text-protech-gray-dark" :datetime="featured.publishedAt">
                {{ formatDate(featured.publishedAt) }}
              </time>
              <h2 class="text-2xl md:text-3xl font-bold text-protech-black mt-2 mb-4">{{ featured.title }}</h2>
              <p class="text-protech-gray-dark leading-relaxed line-clamp-4">{{ featured.excerpt }}</p>
              <router-link
                :to="'/blog/' + featured.slug"
                class="mt-4 inline-flex items-center font-semibold text-protech-green hover:text-protech-green-light"
              >
                Lire la suite →
              </router-link>
            </div>
          </article>

          <!-- Grille d'articles -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <article
              v-for="article in rest"
              :key="article.id"
              class="rounded-xl bg-white shadow-md border border-slate-100 overflow-hidden hover:shadow-lg transition-shadow"
            >
              <div class="aspect-[16/10] bg-slate-200 overflow-hidden">
                <img
                  v-if="article.imageUrl"
                  :src="article.imageUrl"
                  :alt="article.title"
                  class="w-full h-full object-cover"
                />
              </div>
              <div class="p-4">
                <time class="text-xs text-protech-gray-dark" :datetime="article.publishedAt">
                  {{ formatDate(article.publishedAt) }}
                </time>
                <h3 class="font-bold text-protech-black mt-1 mb-2 line-clamp-2">{{ article.title }}</h3>
                <p class="text-sm text-protech-gray-dark line-clamp-2">{{ article.excerpt }}</p>
                <router-link
                  :to="'/blog/' + article.slug"
                  class="mt-3 inline-flex items-center text-sm font-semibold text-protech-green hover:underline"
                >
                  Lire l'article →
                </router-link>
              </div>
            </article>
          </div>
        </template>
      </div>
    </section>
  </div>
</template>
