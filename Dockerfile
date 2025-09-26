# -------------------------
# Stage 1 - Build Frontend (Vite)
# -------------------------
FROM node:22 AS frontend
WORKDIR /app

# Instalar dependencias de Node
COPY package*.json ./
RUN npm ci --include=dev

# Copiar archivos del frontend
COPY vite.config.js ./
COPY resources/ ./resources
COPY public/ ./public

# Compilar con Vite -> genera public/build
RUN npm run build

# -------------------------
# Stage 2 - Backend (Laravel + PHP + Composer + Nginx)
# -------------------------
FROM php:8.2-fpm

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    nginx supervisor git unzip libonig-dev libzip-dev zip libicu-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev curl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip bcmath intl gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiar Composer desde la imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar el código Laravel
COPY . .

# Copiar build del frontend desde Stage 1
COPY --from=frontend /app/public/build ./public/build

# Permisos correctos
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Limpiar caches de Laravel
RUN php artisan config:clear && php artisan route:clear && php artisan view:clear

# Configuración de Nginx
RUN rm /etc/nginx/sites-enabled/default
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

# Configuración de Supervisor
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Render expone este puerto
ENV PORT=10000
EXPOSE $PORT

# Iniciar Supervisor (que lanza Nginx + PHP-FPM)
CMD ["/usr/bin/supervisord", "-n"]
