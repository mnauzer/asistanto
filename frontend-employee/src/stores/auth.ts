import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null as string | null,
  }),

  actions: {
    async login(credentials: { email: string; password: string }) {
      try {
        const response = await axios.post('/api/auth/login', credentials)
        this.token = response.data.token
        this.user = response.data.user
      } catch (error) {
        throw error
      }
    },

    logout() {
      this.user = null
      this.token = null
    }
  },

  persist: true
})
