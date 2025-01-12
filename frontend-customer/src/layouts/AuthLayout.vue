<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="max-w-md w-full p-6 bg-white rounded-lg shadow-lg">
      <!-- Logo alebo názov aplikácie -->
      <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Asistanto</h1>
        <p class="text-gray-600">Zákaznícky portál</p>
      </div>

      <!-- Hlavný obsah (login form) -->
      <RouterView />
    </div>
  </div>
</template>

<script setup lang="ts">
import { RouterView } from "vue-router"
</script>
