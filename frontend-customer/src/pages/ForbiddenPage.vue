<template>
  <div class="min-h-screen flex items-center justify-center">
    <div class="text-center">
      <h1 class="text-6xl font-bold text-red-600 mb-4">403</h1>
      <h2 class="text-2xl font-semibold text-gray-700 mb-4">Prístup zamietnutý</h2>
      <p class="text-gray-600 mb-8">Nemáte oprávnenie na prístup k tejto stránke.</p>
      <router-link
        :to="{ name: 'home' }"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors"
      >
        Späť na domovskú stránku
      </router-link>
    </div>
  </div>
</template>

<script setup lang="ts">
// 403 Forbidden page component
</script>
