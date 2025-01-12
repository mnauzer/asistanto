import { fileURLToPath, URL } from "node:url"
import { defineConfig } from "vite"
import vue from "@vitejs/plugin-vue"
import vueJsx from "@vitejs/plugin-vue-jsx"

export default defineConfig({
  plugins: [
    vue(),
    vueJsx(),
    VueDevTools() // Add Vue DevTools for better development experience
  ],
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", import.meta.url))
    }
  },
  server: {
    host: "0.0.0.0",
    port: 3001,
    proxy: {
      "/api": {
        target: "http://asistanto-nginx:80",
        changeOrigin: true,
        secure: false
      }
    }
  },
  build: {
    sourcemap: true,
    chunkSizeWarningLimit: 1000,
    rollupOptions: {
      output: {
        manualChunks: {
          'vendor': ['vue', 'vue-router', 'pinia'],
          'ui': ['@headlessui/vue', '@heroicons/vue']
        }
      }
    },
    target: 'esnext' // Modern browsers for better optimization
  },
  optimizeDeps: {
    include: ['vue', 'vue-router', 'pinia'] // Pre-bundle commonly used dependencies
  }
})
