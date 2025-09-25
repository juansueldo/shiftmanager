# -------------------------
# Etapa frontend
# -------------------------
FROM node:22.20.0-bullseye AS frontend

WORKDIR /app

COPY package*.json ./
COPY vite.config.js ./
RUN npm ci --include=dev

COPY resources/ ./resources/
COPY public/ ./public/

RUN npm run --silent build || (echo "Error: npm run build failed" && exit 1)

# -------------------------
# Etapa PHP-FPM + Nginx
# -------------------------
FROM php:8.2-fpm-bullseye

ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependencias y extensiones
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    git \
    unzip \
    bash \
    libicu-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libpq-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        mbstring \
        zip \
        exif \
        pcntl \
        gd \
        bcmath \
        intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar Laravel
COPY . .

# Copiar build frontend
COPY --from=frontend /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader -vvv

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Configurar PHP-FPM TCP
RUN sed -i 's|^listen = .*|listen = 127.0.0.1:9000|' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's|^user = .*|user = www-data|' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's|^group = .*|group = www-data|' /usr/local/etc/php-fpm.d/www.conf

# Copiar configuración Nginx y Supervisor
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Directorios de logs
RUN mkdir -p /var/log/nginx /var/log/php-fpm \
    && chown -R www-data:www-data /var/log/nginx /var/log/php-fpm

# Script de inicio
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Puerto dinámico para Render
EXPOSE 80

CMD ["/start.sh"]    libpq-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        mbstring \
        zip \
        exif \
        pcntl \
        gd \
        bcmath \
        intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar Laravel
COPY . .

# Copiar frontend build
COPY --from=frontend /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader -vvv

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Configurar PHP-FPM para TCP
RUN sed -i 's|^listen = .*|listen = 127.0.0.1:9000|' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's|^user = .*|user = www-data|' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's|^group = .*|group = www-data|' /usr/local/etc/php-fpm.d/www.conf

# Configuración Nginx y Supervisor
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Directorios de logs
RUN mkdir -p /var/log/nginx /var/log/php-fpm \
    && chown -R www-data:www-data /var/log/nginx /var/log/php-fpm

# Puerto expuesto (Render usa $PORT)
EXPOSE $PORT
# Start script
COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
