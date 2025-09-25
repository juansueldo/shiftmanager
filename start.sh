#!/bin/bash
set -e

# Optimización y permisos Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache

# Iniciar Supervisor en primer plano
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
