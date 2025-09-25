#!/bin/bash
set -e

sed -i "s/listen 80;/listen ${PORT};/" /etc/nginx/conf.d/default.conf
# Optimización Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Configurar permisos
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Iniciar Supervisor
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
