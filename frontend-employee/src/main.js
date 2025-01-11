import { createApp } from 'vue';
import App from './App.vue';
import axiosInstance from './axiosConfig'; // Importuj konfiguráciu Axiosu
import router from './router'; // Ak používaš Vue Router

const app = createApp(App);

// Nastav Axios ako globálnu vlastnosť
app.config.globalProperties.$axios = axiosInstance;

// Použi router, ak ho máš
app.use(router);

app.mount('#app');
