import { defineStore } from "pinia"
import api from "@/utils/api"

interface User {
  id: number
  email: string
  name: string
  // Add other user properties as needed
}

interface TokenData {
  token: string
  refreshToken: string
  expiresAt: number
}

interface AuthState {
  user: User | null
  tokenData: TokenData | null
  loading: boolean
  error: string | null
  rememberMe: boolean
  refreshTimer: number | null
}

// Constants
const TOKEN_EXPIRY_BUFFER = 60 * 1000 // 1 minute buffer for token refresh
const STORAGE_KEY = 'auth_state'
const TOKEN_CHECK_INTERVAL = 30 * 1000 // Check token every 30 seconds

export const useAuthStore = defineStore({
  id: "auth",

  state: (): AuthState => {
    const savedState = localStorage.getItem(STORAGE_KEY)
    const defaultState: AuthState = {
      user: null,
      tokenData: null,
      loading: false,
      error: null,
      rememberMe: false,
      refreshTimer: null
    }

    if (savedState) {
      try {
        const parsed = JSON.parse(savedState)
        return { ...defaultState, ...parsed }
      } catch (error) {
        console.warn('Failed to parse auth state from storage:', error)
        localStorage.removeItem(STORAGE_KEY)
      }
    }

    return defaultState
  },

  getters: {
    isAuthenticated: (state) => !!state.tokenData?.token,
    isLoading: (state) => state.loading,
    getError: (state) => state.error,
    token: (state) => state.tokenData?.token || null,
    isTokenExpired: (state) => {
      if (!state.tokenData?.expiresAt) return true
      return Date.now() >= state.tokenData.expiresAt - TOKEN_EXPIRY_BUFFER
    }
  },

  actions: {
    persistState() {
      if (this.rememberMe) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify({
          user: this.user,
          tokenData: this.tokenData,
          rememberMe: this.rememberMe
        }))
      } else {
        localStorage.removeItem(STORAGE_KEY)
      }
    },

    async login(credentials: { email: string; password: string; rememberMe?: boolean }) {
      this.loading = true
      this.error = null

      try {
        const response = await api.post("/auth/login", credentials)

        this.tokenData = {
          token: response.data.token,
          refreshToken: response.data.refreshToken,
          expiresAt: Date.now() + (response.data.expiresIn * 1000)
        }
        this.user = response.data.user
        this.rememberMe = credentials.rememberMe || false

        this.persistState()
        this.startTokenRefreshTimer()
      } catch (error: any) {
        this.error = error.response?.data?.message || 'An error occurred during login'
        throw error
      } finally {
        this.loading = false
      }
    },

    startTokenRefreshTimer() {
      // Clear existing timer if any
      if (this.refreshTimer) {
        clearInterval(this.refreshTimer)
      }

      // Start new timer
      this.refreshTimer = setInterval(async () => {
        if (this.isTokenExpired && this.tokenData?.refreshToken) {
          await this.refreshAccessToken()
        }
      }, TOKEN_CHECK_INTERVAL)
    },

    async refreshAccessToken() {
      try {
        if (!this.tokenData?.refreshToken) {
          throw new Error('No refresh token available')
        }

        const response = await api.post("/auth/refresh", {
          refreshToken: this.tokenData.refreshToken
        })

        this.tokenData = {
          token: response.data.token,
          refreshToken: response.data.refreshToken,
          expiresAt: Date.now() + (response.data.expiresIn * 1000)
        }

        this.persistState()
        return response.data.token
      } catch (error) {
        this.clearAuthState()
        throw error
      }
    },

    async logout() {
      try {
        if (this.tokenData?.token) {
          await api.post("/auth/logout")
        }
      } catch (error) {
        console.error('Logout error:', error)
      } finally {
        this.clearAuthState()
        if (this.refreshTimer) {
          clearInterval(this.refreshTimer)
        }
      }
    },

    clearAuthState() {
      this.user = null
      this.tokenData = null
      this.error = null
      this.rememberMe = false
      this.refreshTimer = null
      localStorage.removeItem(STORAGE_KEY)
    },

    clearError() {
      this.error = null
    }
  }
})
