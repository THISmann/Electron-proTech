<script setup lang="ts">
import { onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useBlogStore } from '../stores/blog'

const route = useRoute()
const blog = useBlogStore()

const slug = computed(() => route.params.slug as string)

function formatDate(iso: string) {
  return new Date(iso).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })
}

onMounted(() => {
  if (slug.value) blog.fetchPost(slug.value)
})
</script>

<template>
  <div>
    <div v-if="blog.loading" class="max-w-4xl mx-auto px-4 py-16 text-center text-protech-gray-dark">
      Chargement…
    </div>
    <div v-else-if="blog.error || !blog.current" class="max-w-4xl mx-auto px-4 py-16 text-center">
      <p class="text-red-600 mb-4">{{ blog.error || 'Article non trouvé' }}</p>
      <router-link to="/blog" class="text-protech-green font-semibold hover:underline">Retour au blog</router-link>
    </div>

    <article v-else class="pb-16">
      <header
        class="relative py-24 md:py-32 bg-cover bg-center"
        :style="blog.current.imageUrl ? { backgroundImage: `url(${blog.current.imageUrl})` } : {}"
      >
        <div class="absolute inset-0 bg-black/50" />
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <span class="inline-block text-protech-gold text-sm font-semibold uppercase tracking-wider">
            {{ blog.current.category }}
          </span>
          <h1 class="text-white text-3xl sm:text-4xl md:text-5xl font-bold mt-2 mb-4">
            {{ blog.current.title }}
          </h1>
          <time class="text-white/90 text-sm" :datetime="blog.current.publishedAt">
            {{ formatDate(blog.current.publishedAt) }}
          </time>
        </div>
      </header>

      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        <div
          class="prose prose-lg max-w-none text-protech-gray-dark prose-headings:text-protech-black prose-a:text-protech-green"
          v-html="blog.current.body"
        />
        <p class="mt-10">
          <router-link to="/blog" class="font-semibold text-protech-green hover:underline">← Retour au blog</router-link>
        </p>
      </div>
    </article>
  </div>
</template>
