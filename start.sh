#!/bin/bash
set -e

# Establecer puerto por defecto si no está definido
PORT=${PORT:-80}

# Reemplazar el puerto en la configuración de Nginx
sed -i "s/listen.*80/listen ${PORT}/" /etc/nginx/conf.d/default.conf
sed -i "s/listen.*\[::.*80/listen [::]:${PORT}/" /etc/nginx/conf.d/default.conf

# Verificar que el cambio se realizó
echo "Puerto configurado: $PORT"
grep "listen" /etc/nginx/conf.d/default.conf

# Optimización Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Configurar permisos
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Iniciar Supervisor
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
