import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axiosInstance from "./axiosConfig";
import App from './App.vue'
import router from './router'

const app = createApp(App)

// Nastavenie Axios ako globálnu inštanciu
app.config.globalProperties.$axios = axiosInstance;

app.use(createPinia())
app.use(router)

app.mount('#app')
