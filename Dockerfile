# Gunakan PHP-FPM 8.2 resmi
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libcurl4-openssl-dev curl \
    && docker-php-ext-install pdo_mysql mbstring zip gd \
    && apt-get clean

# Copy seluruh source code
COPY . .

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Buat folder storage & bootstrap/cache, lalu set permission
RUN mkdir -p storage/framework storage/logs bootstrap/cache public/storage
RUN chown -R www-data:www-data storage bootstrap/cache public/storage

# Buat symbolic link storage (Laravel)
RUN php artisan storage:link || true

# Cache config & route
RUN php artisan config:cache
RUN php artisan route:cache

# Expose port 9000 (Railway handle port sendiri)
EXPOSE 9000

# Jalankan PHP-FPM & auto migrate
CMD ["sh", "-c", "php artisan migrate --force && php-fpm"]
