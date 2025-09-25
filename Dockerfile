# -------------------------
# Stage 1 - Build Frontend (Vite)
# -------------------------
FROM node:22 AS frontend
WORKDIR /app

COPY package*.json ./
RUN npm ci --include=dev

COPY vite.config.js ./
COPY resources/ ./resources
COPY public/ ./public

RUN npm run build

# -------------------------
# Stage 2 - Backend (Laravel + PHP + Composer)
# -------------------------
FROM php:8.2-fpm

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git unzip libonig-dev libzip-dev zip libicu-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev curl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip bcmath intl gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer (última versión estable)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar Laravel
COPY . .

# Copiar frontend build
COPY --from=frontend /app/public/build ./public/build

# Cambiar permisos para evitar errores
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Limpiar caches
RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear

ENV PORT=10000
EXPOSE $PORT

CMD ["php-fpm", "-R", "-F"]
