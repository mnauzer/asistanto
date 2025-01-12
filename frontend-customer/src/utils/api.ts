import axios from "axios"
import type { AxiosError, AxiosInstance, AxiosRequestHeaders, InternalAxiosRequestConfig } from "axios"
import { useAuthStore } from "@/stores/auth"
import { ref } from "vue"

// Cache configuration
interface CacheEntry {
  data: any
  timestamp: number
}

interface CacheConfig {
  ttl: number // Time to live in milliseconds
  methods: string[] // HTTP methods to cache
}

interface CustomAxiosRequestConfig extends Omit<InternalAxiosRequestConfig, 'headers'> {
  _retry?: boolean
  _cache?: boolean | CacheConfig
  _cancelToken?: string
  _retryCount?: number
  headers: AxiosRequestHeaders
}

interface RequestOptions {
  cache?: boolean | CacheConfig
  cancelToken?: string
  headers?: AxiosRequestHeaders
}

interface CachedError {
  __cached: boolean
  data: any
}

function isCachedError(error: any): error is CachedError {
  return error && typeof error === 'object' && '__cached' in error
}

class ApiService {
  private instance: AxiosInstance
  private isRefreshing = false
  private failedQueue: Array<{
    resolve: (value?: unknown) => void
    reject: (error?: unknown) => void
  }> = []
  private cache: Map<string, CacheEntry> = new Map()
  private cancelTokens: Map<string, AbortController> = new Map()
  private defaultCacheConfig: CacheConfig = {
    ttl: 5 * 60 * 1000, // 5 minutes
    methods: ['GET']
  }

  // Reactive state for monitoring requests
  public loading = ref(false)
  public activeRequests = ref(0)

  constructor() {
    this.instance = axios.create({
      baseURL: "/api",
      timeout: 10000,
      headers: {
        "Content-Type": "application/json"
      }
    })

    // Start request monitoring
    this.instance.interceptors.request.use(
      (config) => {
        this.activeRequests.value++
        this.loading.value = true
        return config
      },
      (error) => {
        this.activeRequests.value--
        if (this.activeRequests.value === 0) {
          this.loading.value = false
        }
        return Promise.reject(error)
      }
    )

    this.instance.interceptors.response.use(
      (response) => {
        this.activeRequests.value--
        if (this.activeRequests.value === 0) {
          this.loading.value = false
        }
        return response
      },
      (error) => {
        this.activeRequests.value--
        if (this.activeRequests.value === 0) {
          this.loading.value = false
        }
        return Promise.reject(error)
      }
    )

    this.setupInterceptors()
  }

  private getCacheKey(config: CustomAxiosRequestConfig): string {
    return `${config.method}-${config.url}-${JSON.stringify(config.params)}-${JSON.stringify(config.data)}`
  }

  private shouldCache(config: CustomAxiosRequestConfig): boolean {
    if (!config._cache) return false
    const cacheConfig = typeof config._cache === 'boolean' ? this.defaultCacheConfig : config._cache
    return cacheConfig.methods.includes(config.method?.toUpperCase() || '')
  }

  private setupInterceptors() {
    // Request interceptor
    this.instance.interceptors.request.use(
      (config: CustomAxiosRequestConfig) => {
        const authStore = useAuthStore()

        // Add auth token
        if (authStore.token) {
          config.headers.Authorization = `Bearer ${authStore.token}`
        }

        // Handle request cancellation
        if (config._cancelToken) {
          const existingController = this.cancelTokens.get(config._cancelToken)
          if (existingController) {
            existingController.abort()
          }
          const controller = new AbortController()
          this.cancelTokens.set(config._cancelToken, controller)
          config.signal = controller.signal
        }

        // Check cache
        if (this.shouldCache(config)) {
          const cacheKey = this.getCacheKey(config)
          const cachedResponse = this.cache.get(cacheKey)

          if (cachedResponse && Date.now() - cachedResponse.timestamp < this.defaultCacheConfig.ttl) {
            return Promise.reject({
              __cached: true,
              data: cachedResponse.data
            })
          }
        }

        return config
      },
      (error) => {
        return Promise.reject(error)
      }
    )

    // Response interceptor
    this.instance.interceptors.response.use(
      (response) => {
        // Cache successful GET responses
        const config = response.config as CustomAxiosRequestConfig
        if (this.shouldCache(config)) {
          const cacheKey = this.getCacheKey(config)
          this.cache.set(cacheKey, {
            data: response.data,
            timestamp: Date.now()
          })
        }

        return response
      },
      async (error: AxiosError) => {
        const originalRequest = error.config as CustomAxiosRequestConfig
        if (!originalRequest) {
          return Promise.reject(error)
        }

        // Handle 401 Unauthorized error
        if (error.response?.status === 401 && !originalRequest._retry) {
          if (this.isRefreshing) {
            return new Promise((resolve, reject) => {
              this.failedQueue.push({ resolve, reject })
            })
              .then((token) => {
                if (originalRequest.headers) {
                  originalRequest.headers.Authorization = `Bearer ${token}`
                }
                return this.instance(originalRequest)
              })
              .catch((err) => {
                return Promise.reject(err)
              })
          }

          originalRequest._retry = true
          this.isRefreshing = true

          const authStore = useAuthStore()
          return authStore
            .refreshAccessToken()
            .then((token) => {
              this.processQueue(null, token)
              if (originalRequest.headers) {
                originalRequest.headers.Authorization = `Bearer ${token}`
              }
              return this.instance(originalRequest)
            })
            .catch((err) => {
              this.processQueue(err, null)
              return Promise.reject(err)
            })
            .finally(() => {
              this.isRefreshing = false
            })
        }

        // Return cached response if available
        if (isCachedError(error)) {
          return Promise.resolve({ data: error.data })
        }

        // Handle rate limiting with exponential backoff
        if (error.response?.status === 429) {
          const retryAfter = error.response.headers["retry-after"]
          const retryCount = (originalRequest._retryCount || 0) + 1
          const delayMs = (parseInt(retryAfter as string) || 60) * 1000 * Math.pow(2, retryCount - 1)

          if (retryCount <= 3) { // Maximum 3 retry attempts
            const newRequest = {
              ...originalRequest,
              _retryCount: retryCount
            }
            await new Promise((resolve) => setTimeout(resolve, delayMs))
            return this.instance(newRequest)
          }
        }

        return Promise.reject(this.handleError(error))
      }
    )
  }

  private processQueue(error: any, token: string | null = null) {
    this.failedQueue.forEach((promise) => {
      if (error) {
        promise.reject(error)
      } else {
        promise.resolve(token)
      }
    })
    this.failedQueue = []
  }

  private handleError(error: AxiosError) {
    if (error.response) {
      // Server responded with error
      const status = error.response.status
      const data = error.response.data as any

      switch (status) {
        case 400:
          error.message = data.message || "Bad Request"
          break
        case 403:
          error.message = "Access Forbidden"
          break
        case 404:
          error.message = "Resource Not Found"
          break
        case 500:
          error.message = "Internal Server Error"
          break
        default:
          error.message = data.message || "An unexpected error occurred"
      }
    } else if (error.request) {
      // Request made but no response
      error.message = "No response from server"
    }
    return error
  }

  // Public methods with caching and cancellation support
  public get<T = any>(url: string, options: RequestOptions = {}) {
    const config = {
      ...options,
      headers: options.headers || {},
      _cache: options.cache ?? true,
      _cancelToken: options.cancelToken
    } as CustomAxiosRequestConfig
    return this.instance.get<T>(url, config)
  }

  public post<T = any>(url: string, data = {}, options: RequestOptions = {}) {
    const config = {
      ...options,
      headers: options.headers || {},
      _cache: options.cache,
      _cancelToken: options.cancelToken
    } as CustomAxiosRequestConfig
    return this.instance.post<T>(url, data, config)
  }

  public put<T = any>(url: string, data = {}, options: RequestOptions = {}) {
    const config = {
      ...options,
      headers: options.headers || {},
      _cache: options.cache,
      _cancelToken: options.cancelToken
    } as CustomAxiosRequestConfig
    return this.instance.put<T>(url, data, config)
  }

  public delete<T = any>(url: string, options: RequestOptions = {}) {
    const config = {
      ...options,
      headers: options.headers || {},
      _cache: options.cache,
      _cancelToken: options.cancelToken
    } as CustomAxiosRequestConfig
    return this.instance.delete<T>(url, config)
  }

  // Cache management
  public clearCache() {
    this.cache.clear()
  }

  public removeCacheEntry(url: string, method = 'GET') {
    const cacheKey = this.getCacheKey({
      method,
      url,
      params: {},
      data: {}
    } as CustomAxiosRequestConfig)
    this.cache.delete(cacheKey)
  }

  // Cancel requests
  public cancelRequest(token: string) {
    const controller = this.cancelTokens.get(token)
    if (controller) {
      controller.abort()
      this.cancelTokens.delete(token)
    }
  }

  public cancelAllRequests() {
    this.cancelTokens.forEach(controller => controller.abort())
    this.cancelTokens.clear()
  }
}

export default new ApiService()
