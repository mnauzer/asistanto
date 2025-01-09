# Použitie Node.js ako základného obrazu
FROM node:16

# Nastavenie pracovného adresára
WORKDIR /app

# Kopírovanie balíkových konfigurácií
COPY package*.json ./

# Inštalácia závislostí
RUN npm install

# Kopírovanie zdrojového kódu
COPY . .

# Exponovanie portu
EXPOSE 3002

# Spustenie vývojového servera s počúvaním na všetkých IP adresách
CMD ["npm", "run", "dev", "--", "--host"]
