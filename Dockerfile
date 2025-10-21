# 1. Base image PHP + extensions
FROM php:8.2-fpm

# Install dependencies sistem + PHP extensions Laravel + phpspreadsheet
RUN apt-get update && apt-get install -y \
    zip unzip git libzip-dev libpng-dev libonig-dev libxml2-dev libjpeg-dev libfreetype6-dev \
    nginx curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Set workdir
WORKDIR /var/www/html

# Copy source code
COPY . .

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php composer.phar install --no-dev --optimize-autoloader --no-interaction

# Copy Nginx config
COPY ./docker/nginx/default.conf /etc/nginx/sites-available/default

# Expose port Railway
EXPOSE 8080

# Start PHP-FPM + Nginx
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
