#!/bin/bash

# Funkcia na vytvorenie súboru s obsahom
create_file() {
    local file_path="$1"
    local content="$2"
    mkdir -p "$(dirname "$file_path")"
    echo "$content" > "$file_path"
}

# Prompt na názov projektu
read -p "Zadaj názov projektu (napr. frontend-employee): " PROJECT_NAME

# Vytvorenie projektu pomocou create-vue
echo "Vytváram Vue.js projekt..."
npm create vue@latest $PROJECT_NAME -- \
    --typescript \
    --jsx \
    --router \
    --pinia \
    --vitest \
    --cypress \
    --eslint \
    --prettier

# Presun do priečinka projektu
cd $PROJECT_NAME

# Inštalácia závislostí
echo "Inštalujem závislosti..."
npm install

# Inštalácia dodatočných knižníc
echo "Inštalujem dodatočné knižnice..."
npm install @headlessui/vue @heroicons/vue @vee-validate/rules @vee-validate/zod
npm install @vueuse/core axios dayjs uuid zod vue-toastification@next
npm install -D @tailwindcss/aspect-ratio @tailwindcss/forms @tailwindcss/typography
npm install -D tailwindcss postcss autoprefixer

# Inicializácia Tailwind CSS
npx tailwindcss init -p

# Vytvorenie štruktúry priečinkov
echo "Vytváram štruktúru priečinkov..."
mkdir -p src/{assets,components,composables,layouts,pages,router,stores,types,utils}


# Inštalácia a build
echo "Spúšťam inštaláciu a build..."
npm install
## npm run build

echo "Projekt bol úspešne vytvorený!"
echo "Pre spustenie vývojového servera použi: npm run dev"