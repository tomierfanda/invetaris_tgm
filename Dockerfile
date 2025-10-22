# Gunakan PHP-FPM 8.2 resmi
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies sistem (termasuk untuk barcode & QRCode)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    curl \
    nginx \
    && docker-php-ext-install pdo_mysql mbstring zip gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy seluruh source code
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies PHP (tanpa auto-script biar gak error)
RUN composer install --no-dev --no-scripts --no-interaction && \
    composer dump-autoload --optimize

# Jalankan artisan command setelah autoload beres
RUN php artisan key:generate || true
RUN php artisan storage:link || true
RUN php artisan config:clear || true
RUN php artisan route:clear || true

# Buat folder storage & bootstrap/cache, lalu set permission
RUN mkdir -p storage/framework storage/logs bootstrap/cache public/storage && \
    chown -R www-data:www-data storage bootstrap/cache public/storage

# Cache config & route (setelah artisan bisa diakses)
RUN php artisan config:cache || true
RUN php artisan route:cache || true

# Expose port 9000 (Railway akan handle routing sendiri)
EXPOSE 9000

# Copy nginx config
COPY nginx.conf /etc/nginx/sites-available/default

# Copy start script
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Jalankan container dengan script
CMD ["sh", "/usr/local/bin/start.sh"]
