<template>
  <nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <div class="flex-shrink-0 flex items-center">
            <img class="h-8 w-auto" src="@/assets/logo.png" alt="Logo" />
          </div>
          <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <router-link
              to="/"
              class="inline-flex items-center px-1 pt-1 border-b-2"
              :class="[
                $route.path === `/`
                  ? `border-primary-500 text-gray-900`
                  : `border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700`
              ]"
            >
              Dashboard
            </router-link>
            <router-link
              to="/dochadzka"
              class="inline-flex items-center px-1 pt-1 border-b-2"
              :class="[
                $route.path === `/dochadzka`
                  ? `border-primary-500 text-gray-900`
                  : `border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700`
              ]"
            >
              Dochádzka
            </router-link>
          </div>
        </div>
        <div class="flex items-center">
          <button
            @click="logout"
            class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
          >
            Odhlásiť sa
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { useAuthStore } from "@/stores/auth"
import { useRouter } from "vue-router"

const router = useRouter()
const authStore = useAuthStore()

const logout = async () => {
  authStore.logout()
  router.push("/login")
}
</script>
