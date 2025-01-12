<template>
  <div class="min-h-screen flex items-center justify-center">
    <div class="text-center">
      <h1 class="text-6xl font-bold text-red-600 mb-4">500</h1>
      <h2 class="text-2xl font-semibold text-gray-700 mb-4">Chyba servera</h2>
      <p class="text-gray-600 mb-8">Ospravedlňujeme sa, ale na serveri sa vyskytla chyba. Skúste to prosím neskôr.</p>
      <div class="space-x-4">
        <button
          @click="reloadPage"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors"
        >
          Obnoviť stránku
        </button>
        <router-link
          :to="{ name: 'home' }"
          class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition-colors"
        >
          Späť na domovskú stránku
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const reloadPage = () => {
  window.location.reload()
}
</script>
