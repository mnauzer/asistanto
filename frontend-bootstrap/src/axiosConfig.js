import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'http://localhost:8080/api', // Uprav podľa potreby
  timeout: 10000, // Nastav časový limit podľa potreby
  headers: {
    'Content-Type': 'application/json',
    // Pridaj ďalšie hlavičky podľa potreby
  },
});

// Môžeš pridať interceptory pre spracovanie požiadaviek a odpovedí
axiosInstance.interceptors.request.use(
  (config) => {
    // Môžeš pridať logiku pred odoslaním požiadavky
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

axiosInstance.interceptors.response.use(
  (response) => {
    // Môžeš spracovať odpoveď pred jej vrátením
    return response;
  },
  (error) => {
    // Môžeš spracovať chyby odpovede
    return Promise.reject(error);
  }
);

export default axiosInstance;
