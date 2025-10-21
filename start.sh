#!/bin/sh

# Tunggu database siap
echo "Waiting for DB..."
until php -r "new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DATABASE, '$DB_USERNAME', '$DB_PASSWORD');" 2>/dev/null; do
  sleep 3
done
echo "DB ready!"

# Jalankan migrate
php artisan migrate --force

# Jalankan PHP-FPM
php-fpm
