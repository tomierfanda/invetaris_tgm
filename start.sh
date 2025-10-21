#!/bin/sh
echo "===== DB Config ====="
echo "DB_HOST:     $DB_HOST"
echo "DB_PORT:     $DB_PORT"
echo "DB_DATABASE: $DB_DATABASE"
echo "DB_USERNAME: $DB_USERNAME"
echo "DB_PASSWORD: $DB_PASSWORD"
echo "====================="

echo "Waiting for DB..."

# Tunggu MySQL siap
until php -r "new PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_DATABASE'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);" 2>/dev/null; do
  echo "DB not ready, retry in 3s..."
  sleep 3
done

echo "DB ready! Running migrations..."
php artisan migrate --force
php artisan db:seed

# Jalankan PHP-FPM
php-fpm &

# Jalankan Nginx
nginx -g "daemon off;"
