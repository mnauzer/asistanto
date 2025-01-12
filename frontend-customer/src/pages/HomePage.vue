<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-semibold text-gray-900">
        Dashboard
      </h1>
      <div class="flex items-center space-x-4">
        <span class="text-gray-500">{{ currentDate }}</span>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <!-- Karta dochádzky -->
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <ClockIcon class="h-6 w-6 text-gray-400" aria-hidden="true" />
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">
                  Dnešná dochádzka
                </dt>
                <dd class="flex items-center">
                  <div class="text-lg font-medium text-gray-900">
                    {{ isCheckedIn ? "Príchod:" : "Neprihlásený" }}
                  </div>
                  <div v-if="isCheckedIn" class="ml-2 text-sm text-gray-500">
                    {{ checkInTime }}
                  </div>
                </dd>
              </dl>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
          <div class="text-sm">
            <router-link
              to="/dochadzka"
              class="font-medium text-primary-600 hover:text-primary-900"
            >
              Zobraziť všetko
            </router-link>
          </div>
        </div>
      </div>

      <!-- Ďalšie karty... -->
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue"
import { ClockIcon } from "@heroicons/vue/24/outline"
import dayjs from "dayjs"
import "dayjs/locale/sk"

dayjs.locale("sk")

const currentDate = ref(dayjs().format("dddd, D. MMMM YYYY"))
const isCheckedIn = ref(false)
const checkInTime = ref("")

// TODO: Implementovať načítanie reálnych dát
onMounted(() => {
  // Demo data
  isCheckedIn.value = true
  checkInTime.value = "7:30"
})
</script>
