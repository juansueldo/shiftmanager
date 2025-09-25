#!/bin/bash
set -e

# Esperar a que la base de datos esté lista (opcional, útil si DB está en otro contenedor)
# max 30 segundos
echo "Esperando a que la base de datos esté disponible..."
for i in {1..30}; do
    if php artisan migrate:status > /dev/null 2>&1; then
        break
    fi
    echo "Esperando... $i"
    sleep 1
done

# Optimización Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migrations y seeders
php artisan migrate --force
php artisan db:seed --force

# Configurar permisos
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache

# Iniciar Supervisor
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
