FROM php:8.1-fpm

# Inštalácia potrebných balíkov
RUN apt-get update && apt-get install -y \
    libpq-dev zip unzip git curl \
    && docker-php-ext-install pdo_pgsql

# Inštalácia Composeru (oficiálna metóda)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Nastavenie pracovného adresára
WORKDIR /var/www/html

# Kopírovanie aplikácie do kontajnera
COPY . .

# Inštalácia Laravel závislostí
RUN composer install

# Prístupové práva
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Otvor port pre Laravel
EXPOSE 8000

# Spustenie Laravel aplikácie
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
