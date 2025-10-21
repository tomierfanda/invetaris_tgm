#!/bin/sh

echo "===== DB Config ====="
echo "DB_HOST:     $DB_HOST"
echo "DB_PORT:     $DB_PORT"
echo "DB_DATABASE: $DB_DATABASE"
echo "DB_USERNAME: $DB_USERNAME"
echo "DB_PASSWORD: $DB_PASSWORD"
php -r "echo 'DB_PASSWORD2: '.getenv('DB_PASSWORD').\"\n\";"
echo "====================="

echo "Waiting for DB..."

# Tunggu MySQL siap
until php -r "new PDO(
    'mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_DATABASE').';port='.getenv('DB_PORT'),
    getenv('DB_USERNAME'),
    getenv('DB_PASSWORD')
);" 2>/dev/null; do
    echo "DB not ready, retry in 3s..."
    sleep 3
done

echo "DB ready! Running migrations..."
php artisan migrate --force
php artisan db:seed

# Jalankan PHP-FPM
php-fpm &

# Jalankan Nginx di foreground
nginx -g "daemon off;"
