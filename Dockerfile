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
FROM php:8.3-fpm-bullseye

# Instalar dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev zlib1g-dev libicu-dev curl bash nginx netcat-openbsd \
    libxml2-dev libcurl4-openssl-dev pkg-config libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd mbstring bcmath intl \
        xml curl dom fileinfo json tokenizer ctype \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar archivos de configuración primero
COPY composer.json composer.lock ./
COPY artisan ./

# Instalar dependencias PHP sin optimizaciones primero
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction

# Copiar resto del proyecto
COPY . .

# Copiar assets construidos por Vite desde la etapa frontend
COPY --from=frontend /app/public/build ./public/build

# Finalizar instalación de Composer con optimizaciones
RUN composer dump-autoload --optimize --no-interaction

# Crear directorios necesarios y configurar permisos
RUN mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Limpiar configuraciones por defecto de Nginx
RUN rm -f /etc/nginx/sites-enabled/default /etc/nginx/conf.d/default.conf

# Copiar script de inicio
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Exponer puerto HTTP
EXPOSE 80

# Ejecutar script de inicio
CMD ["/start.sh"]
