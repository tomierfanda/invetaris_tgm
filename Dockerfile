# Gunakan image PHP resmi
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo_mysql mbstring zip gd

# Buat folder storage dulu
RUN mkdir -p public/storage

# Copy source code
COPY . .

# Set permission
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port dan jalankan PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
