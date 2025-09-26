#!/bin/bash
set -e

# Copiar .env si no existe
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Generar APP_KEY si no existe
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY no definida, generando nueva..."
    php artisan key:generate --force
else
    echo "Usando APP_KEY definida en variable de entorno"
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|g" /var/www/html/.env
fi

# Limpiar y generar caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Asegurar permisos
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Iniciar supervisord que levanta PHP-FPM y Nginx
exec docker/supervisord -n -c /etc/supervisor/supervisord.conf
