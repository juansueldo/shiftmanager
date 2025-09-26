# -------------------------
# Etapa 1: Frontend (Node + Vite)
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
# Etapa 2: Backend + Nginx
# -------------------------
FROM php:8.3-fpm-bullseye

# Instalar dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev zlib1g-dev libicu-dev curl bash nginx supervisor \
    && docker-php-ext-install pdo pdo_mysql zip gd mbstring bcmath intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Copiar assets de Vite
COPY --from=frontend /app/public/build ./public/build

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --verbose

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copiar script de inicio
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Configuración Nginx
COPY docker/default.conf /etc/nginx/conf.d/default.conf

# Exponer puerto 80
EXPOSE 80

CMD ["/start.sh"]
