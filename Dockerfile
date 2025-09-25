# syntax=docker/dockerfile:1

# -------------------------
# Etapa frontend
# -------------------------
FROM node:22.20.0-bullseye AS frontend

WORKDIR /app

# Copiar archivos de dependencias de Node.js
COPY package*.json ./
COPY vite.config.js ./

# Instalar dependencias
RUN npm ci --include=dev

# Copiar código fuente del frontend
COPY resources/ ./resources/
COPY public/ ./public/

# Build del frontend
RUN npm run --silent build || (echo "Error: npm run build failed" && cat package.json && exit 1)

# -------------------------
# Etapa PHP-FPM
# -------------------------
FROM php:8.2-fpm-bullseye

# Permitir Composer como root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependencias del sistema y extensiones PHP
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    git \
    unzip \
    bash \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd bcmath intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# -------------------------
# Copiar código completo de Laravel
# -------------------------
COPY . .

# Copiar build del frontend
COPY --from=frontend /app/public/build ./public/build

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader -vvv

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Copiar configuración de Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/conf.d/default.conf

# Copiar configuración de Supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Crear directorio para logs de Nginx
RUN mkdir -p /var/log/nginx

EXPOSE 80

# Optimización de Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Comando principal
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
