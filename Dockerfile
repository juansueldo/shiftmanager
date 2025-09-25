# Dockerfile
FROM node:22.20.0-alpine AS frontend

WORKDIR /app

# Copiar archivos de dependencias de Node.js
COPY package*.json ./
COPY vite.config.js ./

# Verificar versiones y instalar dependencias
RUN node --version && npm --version
RUN npm ci --include=dev

# Copiar código fuente del frontend
COPY resources/ ./resources/
COPY public/ ./public/

# Verificar que el script build existe y ejecutar
RUN npm run --silent build || (echo "Error: npm run build failed. Checking package.json:" && cat package.json && exit 1)

# Etapa principal con PHP
FROM php:8.2-fpm-alpine

# Instalar dependencias del sistema
RUN apk add --no-cache \
    nginx \
    supervisor \
    git \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    libzip-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de dependencias de PHP
COPY composer.json composer.lock ./

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copiar código fuente de Laravel
COPY . .
COPY --from=frontend /app/public/build ./public/build

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

# Ejecutar optimizaciones de Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
