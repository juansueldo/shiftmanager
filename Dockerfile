# -------------------------
# Stage 1 - Build Frontend (Vite)
# -------------------------
FROM node:22 AS frontend
WORKDIR /app

# Copiamos solo lo necesario para instalar dependencias
COPY package*.json ./
RUN npm ci --include=dev

# Copiamos el resto del frontend
COPY resources/ ./resources
COPY public/ ./public
COPY vite.config.js ./

# Build de Vite (generará public/dist)
RUN npm run build

# -------------------------
# Stage 2 - Backend (Laravel + PHP + Composer + Nginx)
# -------------------------
FROM php:8.2-fpm AS backend

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    nginx supervisor git curl unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Copiar Composer desde la imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar Laravel
COPY . .

# Copiar frontend build
COPY --from=frontend /app/public/dist ./public/dist

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Limpiar caches de Laravel
RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear

# Configurar Nginx
RUN rm /etc/nginx/sites-enabled/default
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

# Supervisord para correr PHP-FPM + Nginx
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-n"]
