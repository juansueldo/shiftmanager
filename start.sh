#!/bin/bash
set -e

# Establecer puerto por defecto si no está definido
PORT=${PORT:-80}

echo "=== DEBUGGING INFO ==="
echo "PORT variable: $PORT"
echo "User: $(whoami)"
echo "Working directory: $(pwd)"

# Crear directorios de logs si no existen
mkdir -p /var/log/nginx /var/log/php-fpm
chown -R www-data:www-data /var/log/nginx /var/log/php-fpm

# Verificar archivos de configuración antes de modificar
echo "=== NGINX CONFIG BEFORE ==="
head -10 /etc/nginx/conf.d/default.conf

# Reemplazar el puerto en la configuración de Nginx
sed -i "s/listen 80/listen ${PORT}/" /etc/nginx/conf.d/default.conf
sed -i "s/listen \[::]:80/listen [::]:${PORT}/" /etc/nginx/conf.d/default.conf

echo "=== NGINX CONFIG AFTER ==="
head -10 /etc/nginx/conf.d/default.conf

# Verificar sintaxis de Nginx
echo "=== TESTING NGINX CONFIG ==="
nginx -t || {
    echo "ERROR: Nginx configuration test failed"
    cat /etc/nginx/conf.d/default.conf
    exit 1
}

# Verificar configuración de PHP-FPM
echo "=== TESTING PHP-FPM CONFIG ==="
php-fpm -t || {
    echo "ERROR: PHP-FPM configuration test failed"
    exit 1
}

# Verificar permisos de archivos críticos
echo "=== CHECKING PERMISSIONS ==="
ls -la /var/www/html/public/index.php || echo "index.php not found"
ls -ld /var/www/html/storage || echo "storage directory not found"
ls -ld /var/www/html/bootstrap/cache || echo "bootstrap/cache not found"

# Optimización Laravel (con verificación)
echo "=== LARAVEL OPTIMIZATION ==="
cd /var/www/html

if [ -f "artisan" ]; then
    php artisan config:cache || echo "Config cache failed"
    php artisan route:cache || echo "Route cache failed" 
    php artisan view:cache || echo "View cache failed"
else
    echo "WARNING: artisan not found"
fi

# Configurar permisos
echo "=== SETTING PERMISSIONS ==="
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Verificar que los servicios pueden iniciarse manualmente
echo "=== MANUAL SERVICE TEST ==="
echo "Testing PHP-FPM..."
timeout 5 php-fpm -F &
PHP_PID=$!
sleep 2
if kill -0 $PHP_PID 2>/dev/null; then
    echo "PHP-FPM started successfully"
    kill $PHP_PID
else
    echo "ERROR: PHP-FPM failed to start"
fi

echo "Testing Nginx..."
timeout 5 nginx -g "daemon off;" &
NGINX_PID=$!
sleep 2
if kill -0 $NGINX_PID 2>/dev/null; then
    echo "Nginx started successfully"
    kill $NGINX_PID
else
    echo "ERROR: Nginx failed to start"
fi

echo "=== STARTING SUPERVISOR ==="
# Iniciar Supervisor
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
