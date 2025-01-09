FROM node:18 AS build-stage

# Nastavenie pracovného adresára
WORKDIR /app

# Kopírovanie závislostí
COPY package.json yarn.lock* package-lock.json* pnpm-lock.yaml* ./

# Inštalácia závislostí
RUN npm install --legacy-peer-deps

# Kopírovanie aplikácie
COPY . .

# Build aplikácie
RUN npm run build

# Produkčné prostredie s Nginx
FROM nginx:alpine AS production-stage
COPY --from=build-stage /app/dist /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
