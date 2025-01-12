<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Hlavný obsah -->
    <main>
      <RouterView />
    </main>
  </div>
</template>

<script setup lang="ts">
import { RouterView } from "vue-router"
</script>
