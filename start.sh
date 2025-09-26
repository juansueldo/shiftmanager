#!/bin/bash
set -e

echo "🚀 Iniciando aplicación Laravel con debugging..."

# 1️⃣ Copiar .env si no existe
if [ ! -f /var/www/html/.env ]; then
    echo "📋 Copiando .env.example a .env"
    cp /var/www/html/.env.example /var/www/html/.env
fi

# 2️⃣ Generar APP_KEY solo si no está definida en variable de entorno
if [ -z "$APP_KEY" ]; then
    echo "🔑 APP_KEY no definida, generando nueva..."
    php artisan key:generate --force
else
    echo "🔑 Usando APP_KEY definida en variable de entorno"
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|g" /var/www/html/.env
fi

# 3️⃣ Configurar variables de entorno para producción
echo "⚙️ Configurando variables de entorno..."
sed -i "s|^APP_ENV=.*|APP_ENV=production|g" /var/www/html/.env
sed -i "s|^APP_DEBUG=.*|APP_DEBUG=true|g" /var/www/html/.env
sed -i "s|^LOG_CHANNEL=.*|LOG_CHANNEL=stderr|g" /var/www/html/.env

# Configurar base de datos si las variables están disponibles
if [ ! -z "$DATABASE_URL" ]; then
    echo "🗄️ Configurando DATABASE_URL desde variable de entorno"
    sed -i "s|^DATABASE_URL=.*|DATABASE_URL=${DATABASE_URL}|g" /var/www/html/.env
fi

if [ ! -z "$DB_CONNECTION" ]; then
    echo "🗄️ Configurando DB_CONNECTION: $DB_CONNECTION"
    sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=${DB_CONNECTION}|g" /var/www/html/.env
fi

if [ ! -z "$DB_HOST" ]; then
    sed -i "s|^DB_HOST=.*|DB_HOST=${DB_HOST}|g" /var/www/html/.env
fi

if [ ! -z "$DB_PORT" ]; then
    sed -i "s|^DB_PORT=.*|DB_PORT=${DB_PORT}|g" /var/www/html/.env
fi

if [ ! -z "$DB_DATABASE" ]; then
    sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE}|g" /var/www/html/.env
fi

if [ ! -z "$DB_USERNAME" ]; then
    sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME}|g" /var/www/html/.env
fi

if [ ! -z "$DB_PASSWORD" ]; then
    sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|g" /var/www/html/.env
fi

# 4️⃣ Verificar estructura de archivos
echo "📁 Verificando estructura de archivos..."
echo "Directorio público: $(ls -la /var/www/html/public/ | head -5)"
echo "Archivo index.php existe: $(test -f /var/www/html/public/index.php && echo 'SÍ' || echo 'NO')"
echo "Directorio vendor existe: $(test -d /var/www/html/vendor && echo 'SÍ' || echo 'NO')"

# 5️⃣ Asegurar permisos ANTES de generar caches
echo "🔒 Configurando permisos..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

mkdir -p storage/framework/sessions
chmod -R 777 storage/framework/sessions

# 6️⃣ Limpiar caches existentes
echo "🗑️ Limpiando caches existentes..."
php artisan config:clear || true
php artisan route:clear || true  
php artisan view:clear || true
php artisan cache:clear || true


# 7️⃣ Generar caches nuevos
echo "🗂️ Generando caches de Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8️⃣ Verificar configuración de Laravel
echo "🔍 Verificando configuración de Laravel..."
php artisan --version
echo "APP_KEY presente: $(grep -c 'APP_KEY=base64:' /var/www/html/.env || echo '0')"

# 9️⃣ FORZAR eliminación de configuraciones por defecto de Nginx
echo "🌐 Configurando Nginx..."
rm -f /etc/nginx/sites-enabled/default
rm -f /etc/nginx/sites-available/default
rm -f /etc/nginx/conf.d/default.conf
rm -f /var/www/html/index.nginx-debian.html

# 🔟 Crear configuración de Nginx con mejor manejo de errores
cat > /etc/nginx/sites-available/laravel << 'EOF'
server {
    listen 80;
    server_name _;
    
    root /var/www/html/public;
    index index.php index.html;
    
    # Logs para debugging
    access_log /var/log/nginx/access.log;
    error_log /var/log/nginx/error.log debug;

    # Configuración principal
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Configuración PHP con mejor error handling
    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_index index.php;
        fastcgi_read_timeout 300;
        fastcgi_send_timeout 300;
        fastcgi_connect_timeout 300;
        fastcgi_intercept_errors on;
    }

    # Denegar acceso a archivos sensibles
    location ~ /\.ht {
        deny all;
    }
    
    location ~ /\.(env|git) {
        deny all;
    }
}
EOF

# 1️⃣1️⃣ Activar el sitio
ln -sf /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/

# 1️⃣2️⃣ Verificar configuración de Nginx
echo "✅ Verificando configuración de Nginx..."
nginx -t

# 1️⃣3️⃣ Test básico de PHP
echo "🐘 Testeando PHP..."
php -v
echo "<?php phpinfo(); ?>" > /tmp/test.php
php /tmp/test.php | head -5
rm /tmp/test.php

# 1️⃣4️⃣ Test de Laravel
echo "🚀 Testeando Laravel..."
cd /var/www/html
php artisan route:list | head -5 || echo "No hay rutas definidas"

# 1️⃣5️⃣ Mostrar información final
echo "📊 Estado final:"
echo "   - Usuario actual: $(whoami)"
echo "   - Permisos storage: $(ls -ld /var/www/html/storage)"
echo "   - Permisos bootstrap/cache: $(ls -ld /var/www/html/bootstrap/cache)"

echo "📜 Últimas líneas de logs de Laravel:"
tail -n 50 storage/logs/laravel.log || echo "No hay logs todavía"

echo "🎯 Iniciando servicios..."

# 1️⃣6️⃣ Iniciar PHP-FPM
echo "🐘 Iniciando PHP-FPM..."
php-fpm -D

# Esperar un poco para que PHP-FPM esté listo
sleep 2

# 1️⃣7️⃣ Test de conectividad PHP-FPM
echo "🔗 Testeando conectividad PHP-FPM..."
if nc -z 127.0.0.1 9000; then
    echo "✅ PHP-FPM está escuchando en puerto 9000"
else
    echo "❌ PHP-FPM no está disponible en puerto 9000"
    exit 1
fi

# 1️⃣8️⃣ Iniciar Nginx
echo "🌐 Iniciando Nginx..."
exec nginx -g "daemon off;"
