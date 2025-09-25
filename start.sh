#!/bin/bash
set -e

# Establecer puerto por defecto si no está definido
PORT=${PORT:-80}

echo "=== CONFIGURANDO PUERTO $PORT ==="

# Crear configuración de Nginx con el puerto correcto
cat > /etc/nginx/conf.d/default.conf << EOF
server {
    listen 0.0.0.0:${PORT} default_server;
    listen [::]:${PORT} default_server ipv6only=on;

    server_name _;
    root /var/www/html/public;
    index index.php index.html index.htm;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { 
        access_log off; 
        log_not_found off; 
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    location = /robots.txt { 
        access_log off; 
        log_not_found off; 
        expires 1d;
    }

    location /build/ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        try_files \$uri =404;

        location ~* \.map\$ {
            expires 1d;
            add_header Cache-Control "no-cache";
        }
    }

    location ~ \.php\$ {
        try_files \$uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)\$;

        # Conexión a PHP-FPM por socket
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        fastcgi_param PATH_INFO \$fastcgi_path_info;
        include fastcgi_params;
        fastcgi_read_timeout 300;
        fastcgi_buffer_size 128k;
        fastcgi_buffers 4 256k;
        fastcgi_busy_buffers_size 256k;
    }

    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot|webp|avif)\$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
        try_files \$uri =404;
    }

    location ^~ /storage/ {
        expires 1M;
        add_header Cache-Control "public";
        try_files \$uri =404;
    }

    location ~ /\. {
        deny all;
        access_log off;
        log_not_found off;
    }

    location ~ /(?:composer\.(json|lock)|package\.(json|lock)|\.env|\.git) {
        deny all;
        access_log off;
        log_not_found off;
    }

    location /health {
        access_log off;
        return 200 "healthy\n";
        add_header Content-Type text/plain;
    }

    error_page 404 /index.php;
    error_page 500 502 503 504 /50x.html;

    location = /50x.html {
        root /var/www/html/public;
    }
}
EOF

echo "=== VERIFICANDO CONFIGURACIÓN ==="
cat /etc/nginx/conf.d/default.conf | head -5

# Verificar sintaxis de Nginx
nginx -t || {
    echo "ERROR: Nginx configuration test failed"
    exit 1
}

echo "=== CONFIGURANDO LARAVEL ==="
cd /var/www/html

# Configurar permisos
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Optimización Laravel
if [ -f "artisan" ]; then
    php artisan config:cache || echo "Config cache failed"
    php artisan route:cache || echo "Route cache failed" 
    php artisan view:cache || echo "View cache failed"
fi

echo "=== INICIANDO SERVICIOS EN PUERTO $PORT ==="
# Iniciar Supervisor
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
