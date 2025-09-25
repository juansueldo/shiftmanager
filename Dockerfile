# -------------------------
# Stage 1 - Build Frontend (Vite)
# -------------------------
FROM node:22 AS frontend
WORKDIR /app

# Copiar solo package.json y package-lock.json para instalar dependencias
COPY package*.json ./
RUN npm ci --include=dev

# Copiar archivos necesarios para el build de Vite
COPY vite.config.js ./
COPY resources/ ./resources
COPY public/ ./public

# Generar los assets del frontend (por defecto Laravel 12 + Vite -> public/build)
RUN npm run build

# -------------------------
# Stage 2 - Backend (Laravel + PHP + Composer)
# -------------------------
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Copiar Composer desde la imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar el código de Laravel
COPY . .

# Copiar frontend build correctamente (public/build)
COPY --from=frontend /app/public/build ./public/build

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Limpiar caches de Laravel
RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear

# Puerto que Render espera
ENV PORT=10000
EXPOSE $PORT

# Ejecutar PHP-FPM
CMD ["php-fpm", "-R", "-F"]
