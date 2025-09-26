#!/bin/bash
set -e

# 1️⃣ Copiar .env si no existe
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# 2️⃣ Generar APP_KEY solo si no está definida en variable de entorno
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY no definida, generando nueva..."
    php artisan key:generate --force
else
    echo "Usando APP_KEY definida en variable de entorno"
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|g" /var/www/html/.env
fi

# 3️⃣ Limpiar y generar caches de Laravel
php artisan config:cache
php artisan route:cache  
php artisan view:cache

# 4️⃣ Asegurar permisos
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 5️⃣ FORZAR eliminación de configuraciones por defecto
rm -f /etc/nginx/sites-enabled/default
rm -f /etc/nginx/sites-available/default
rm -f /etc/nginx/conf.d/default.conf
rm -f /var/www/html/index.nginx-debian.html

# 6️⃣ Crear configuración de Nginx con TCP en lugar de socket
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
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF

# 7️⃣ Activar el sitio
ln -sf /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/

# 8️⃣ Verificar configuración
nginx -t

echo "Configuración de Nginx aplicada correctamente."
echo "Directorio público: $(ls -la /var/www/html/public/)"

# 9️⃣ Iniciar servicios
echo "Iniciando PHP-FPM..."
php-fpm -D

echo "Iniciando Nginx..."
exec nginx -g "daemon off;"
