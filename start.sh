#!/bin/bash
set -e

# 1️⃣ Copiar .env si no existe
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# 2️⃣ Generar APP_KEY si no está definida
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY no definida, generando nueva..."
    php artisan key:generate --force
else
    echo "Usando APP_KEY definida"
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|g" /var/www/html/.env
fi

# 3️⃣ Limpiar y generar caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4️⃣ Configurar permisos
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 5️⃣ Configurar Nginx
cat > /etc/nginx/conf.d/default.conf << 'EOF'
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
        fastcgi_pass unix:/var/run/php/php-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_index index.php;
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF

# 6️⃣ Iniciar servicios
echo "Iniciando PHP-FPM y Nginx..."
php-fpm -D
nginx -g "daemon off;"
