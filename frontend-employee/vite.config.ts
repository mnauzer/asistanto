import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueJsx(),
    vueDevTools(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    },
  },
<<<<<<< HEAD
=======
  server: {
    host: '0.0.0.0',
    port: 3002,
    proxy: {
      '/api': {
        target: 'http://asistanto-nginx:80',
        changeOrigin: true,
        secure: false
      },
    },
  }
>>>>>>> 984bbfa1953aeda682a3c18ba9e7fdf0eb78c22c
})
