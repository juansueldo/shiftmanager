# -------------------------
# Stage 1 - Build Frontend (Vite)
# -------------------------
FROM node:22 AS frontend
WORKDIR /app

# Copiamos solo lo necesario para instalar dependencias
COPY package*.json ./
RUN npm install

# Copiamos el resto del frontend
COPY resources/ ./resources
COPY public/ ./public
COPY vite.config.js ./

# Build de Vite (generará public/dist)
RUN npm run build

# -------------------------
# Stage 2 - Backend (Laravel + PHP + Composer)
# -------------------------
FROM php:8.2-fpm AS backend

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Copiar Composer desde la imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar código Laravel
COPY . .

# Copiar frontend build desde Stage 1
COPY --from=frontend /app/public/dist ./public/dist

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Limpiar caches de Laravel
RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear

CMD ["php-fpm"]
