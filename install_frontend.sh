#!/bin/bash

# Funkcia pre inštaláciu Vue projektu
install_frontend() {
    local dir=$1
    local port=$2
    local name=$3

    echo "Installing $name in $dir..."

    # Vytvorenie projektu pomocou create-vue
    npm create vue@latest "$dir" -- \
        --typescript \
        --jsx \
        --router \
        --pinia \
        --vitest \
        --cypress \
        --eslint \
        --prettier \
        --vue-router  \
        --store \
        --docker \
        -y

    # Prejdenie do adresára projektu
    cd "$dir"

    # Inštalácia závislostí
    npm install

    # Inštalácia dodatočných závislostí
    npm install -D tailwindcss postcss autoprefixer
    npm install axios
    npm install @headlessui/vue @heroicons/vue
    npm install @vueuse/core
    npm install dayjs
    npm install uuid @types/uuid
    npm install vue-toastification@next
    npm install zod @vee-validate/zod @vee-validate/rules
    npm install -D @tailwindcss/forms @tailwindcss/typography @tailwindcss/aspect-ratio

    # Inicializácia Tailwind CSS
    npx tailwindcss init -p

    # Úprava vite.config.ts
    cat > vite.config.ts << EOL
import { fileURLToPath, URL } from 'node:url'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'

export default defineConfig({
  plugins: [
    vue(),
    vueJsx(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  server: {
    host: '0.0.0.0',
    port: ${port}
  }
})
EOL

    # Úprava tailwind.config.js
    cat > tailwind.config.js << EOL
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
  ],
}
EOL

    # Úprava src/assets/main.css
    cat > src/assets/main.css << EOL
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
  :root {
    --background: 0 0% 100%;
    --foreground: 222.2 84% 4.9%;
  }

  .dark {
    --background: 222.2 84% 4.9%;
    --foreground: 0 0% 100%;
  }
}

@layer base {
  body {
    @apply bg-background text-foreground;
  }
}
EOL

    # Návrat do pôvodného adresára
    cd ..

    echo "$name installation completed"
}

# Inštalácia všetkých frontendov
install_frontend "frontend-admin" 3003 "Admin Panel"
install_frontend "frontend-customer" 3001 "Customer Portal"
install_frontend "frontend-employee" 3002 "Employee Portal"

echo "All frontend installations completed"