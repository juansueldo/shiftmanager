# -------------------------
# Etapa 1: Frontend (Node + Vite)
# -------------------------
FROM node:22-bullseye AS frontend

WORKDIR /app

# Copiar solo package.json y package-lock.json para instalar deps
COPY package*.json ./

# Instalar dependencias Node
RUN npm ci --include=dev

# Copiar resto de recursos
COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/

# Construir assets para producción
RUN npm run build

# -------------------------
# Etapa 2: Backend (PHP + Composer)
# -------------------------
FROM php:8.3-fpm-bullseye AS backend

# Instalar dependencias del sistema básicas
RUN apt-get update && apt-get install -y \
    git unzip curl bash nginx netcat-openbsd \
    libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev zlib1g-dev libicu-dev libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip gd mbstring bcmath intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar proyecto (pero sin public/build, que vendrá del frontend)
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ✅ Copiar assets construidos por Vite desde la etapa frontend
COPY --from=frontend /app/public/build ./public/build

# Crear symlink de storage
RUN php artisan storage:link

# Crear directorios y configurar permisos
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Limpiar configuraciones por defecto de Nginx
RUN rm -f /etc/nginx/sites-enabled/default /etc/nginx/conf.d/default.conf

# Copiar script de inicio
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Exponer puerto HTTP
EXPOSE 80

# Ejecutar script de inicio
CMD ["/start.sh"]
