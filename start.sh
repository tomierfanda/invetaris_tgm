#!/bin/sh

echo "Waiting for DB..."
until php -r "new PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_DATABASE'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);" 2>/dev/null; do
  sleep 3
done
echo "DB ready!"

php artisan migrate --force

echo "Starting PHP-FPM..."
# Start PHP-FPM
php-fpm &

# Start Nginx
nginx -g "daemon off;"