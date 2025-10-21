#!/bin/sh

echo "Starting PHP-FPM..."
# Start PHP-FPM
php-fpm &

# Start Nginx
nginx -g "daemon off;"