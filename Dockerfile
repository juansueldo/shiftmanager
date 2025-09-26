# -------------------------
# Etapa de frontend (Node)
# -------------------------
FROM node:22-bullseye AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci --include=dev

COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/

RUN npm run build

# -------------------------
# Etapa PHP + Nginx
# -------------------------
FROM php:8.3-fpm-bullseye

# Instalar dependencias PHP
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

WORKDIR /var/www/html

# Copiar archivos Laravel
COPY . .

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Copiar assets construidos por Vite
COPY --from=frontend /app/public/build ./public/build

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Puerto expuesto
EXPOSE 80

# Comando para iniciar PHP-FPM
CMD ["php-fpm"]
