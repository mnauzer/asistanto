import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueDevTools(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    },
  },
  server: {
    host: '0.0.0.0',
    port: 3003, // toto je dôležité, keďže v Dockeri mapuješ na port 3003
    proxy: {
      '/api': {
        target: 'http://asistanto-nginx:80', // použijeme názov nginx kontajnera v sieti
        changeOrigin: true,
        secure: false
      },
    },
  },
})
