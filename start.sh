#!/bin/bash
set -e

echo "🚀 Iniciando aplicación Laravel con Vite y PHP-FPM..."

cd /var/www/html

# 1️⃣ Copiar .env si no existe
if [ ! -f .env ]; then
    echo "📋 Copiando .env.example a .env"
    cp .env.example .env
fi

# 2️⃣ Generar APP_KEY si no existe
if ! grep -q '^APP_KEY=base64:' .env; then
    echo "🔑 Generando APP_KEY..."
    php artisan key:generate --force
fi

# 3️⃣ Configurar variables de entorno
sed -i "s|^APP_ENV=.*|APP_ENV=production|g" .env
sed -i "s|^APP_DEBUG=.*|APP_DEBUG=false|g" .env
sed -i "s|^LOG_CHANNEL=.*|LOG_CHANNEL=stderr|g" .env

# 4️⃣ Asegurar permisos
chown -R www-data:www-data storage bootstrap/cache
chmod -R 777 storage bootstrap/cache

# 5️⃣ Limpiar caches
php artisan config:clear || true
php artisan route:clear || true  
php artisan view:clear || true
php artisan cache:clear || true

# 6️⃣ Generar caches nuevos
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7️⃣ Verificar y construir Vite assets si falta el manifest
if [ ! -f public/build/manifest.json ]; then
    echo "❌ Vite manifest.json no encontrado, construyendo assets..."
    npm install
    npm run build
else
    echo "✅ Vite manifest.json encontrado"
fi

# 8️⃣ Configurar Nginx
rm -f /etc/nginx/sites-enabled/default
cat > /etc/nginx/sites-available/laravel << 'EOF'
server {
    listen 80;
    server_name _;
    root /var/www/html/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_index index.php;
        fastcgi_intercept_errors on;
    }

    location ~ /\.(env|git) {
        deny all;
    }
}
EOF
ln -sf /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/

nginx -t

# 9️⃣ Iniciar PHP-FPM y Nginx
php-fpm -D
exec nginx -g "daemon off;"
