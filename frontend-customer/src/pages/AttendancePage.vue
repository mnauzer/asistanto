<template>
  <div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900">
          Dochádzka
        </h1>
        <p class="mt-2 text-sm text-gray-700">
          Prehľad dochádzky a evidencia príchodov/odchodov
        </p>
      </div>
      <div class="mt-4 sm:mt-0">
        <button
          @click="handleAttendanceAction"
          class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white"
          :class="[
            isCheckedIn
              ? `bg-red-600 hover:bg-red-700`
              : `bg-green-600 hover:bg-green-700`
          ]"
        >
          <ClockIcon class="mr-2 h-5 w-5" aria-hidden="true" />
          {{ isCheckedIn ? "Odchod" : "Príchod" }}
        </button>
      </div>
    </div>

    <!-- Tabuľka dochádzky -->
    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Dátum
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Príchod
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Odchod
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Celkový čas
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="record in attendanceRecords" :key="record.date">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ record.date }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ record.checkIn }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ record.checkOut }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ record.totalTime }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue"
import { ClockIcon } from "@heroicons/vue/24/outline"
import { useToast } from "vue-toastification"
import api from "@/utils/api"
import dayjs from "dayjs"

const toast = useToast()

const isCheckedIn = ref(false)
const attendanceRecords = ref([
  {
    date: "12.1.2025",
    checkIn: "7:30",
    checkOut: "16:00",
    totalTime: "8:30"
  },
  // Ďalšie demo záznamy...
])

const handleAttendanceAction = async () => {
  try {
    if (isCheckedIn.value) {
      await api.post("/attendance/check-out")
      toast.success("Odchod bol zaznamenaný")
    } else {
      await api.post("/attendance/check-in")
      toast.success("Príchod bol zaznamenaný")
    }
    isCheckedIn.value = !isCheckedIn.value
    // TODO: Aktualizovať záznamy
  } catch (error) {
    toast.error("Nastala chyba pri zaznamenávaní dochádzky")
  }
}

// TODO: Implementovať načítanie reálnych dát
onMounted(async () => {
  try {
    // const response = await api.get("/attendance")
    // attendanceRecords.value = response.data
  } catch (error) {
    toast.error("Nepodarilo sa načítať záznamy dochádzky")
  }
})
</script>
