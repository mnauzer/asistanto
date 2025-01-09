import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vite.dev/config/
export default defineConfig({
  plugins: [vue()],
  server: {
    host: '0.0.0.0', // Počúvanie na všetkých adresách
    port: 3000,      // Nastavenie portu na 3000
  },
})
