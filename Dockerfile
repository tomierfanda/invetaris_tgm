# Gunakan image PHP-FPM yang lebih stabil dan sesuai untuk web serving
# FPM (FastCGI Process Manager) adalah standar untuk aplikasi web PHP
FROM php:8.2-fpm

# Install dependensi sistem dan ekstensi PHP yang dibutuhkan Laravel + phpspreadsheet
RUN apt-get update && apt-get install -y \
    zip unzip git libzip-dev libpng-dev libonig-dev libxml2-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    # Install ekstensi utama
    && docker-php-ext-install pdo pdo_mysql zip gd \
    # Bersihkan cache
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Set workdir ke /app (Standar untuk project)
WORKDIR /app

# Copy composer file terlebih dahulu untuk memanfaatkan caching Docker layer
COPY composer.json composer.lock ./

# Install composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader --no-interaction

# Copy sisa file project, termasuk start.sh, ke dalam container
COPY . .

# Set izin (permissions) yang benar untuk folder storage dan cache
# KRUSIAL: Memberikan akses tulis kepada user web server (www-data)
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Salin script start.sh dan berikan izin eksekusi
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Expose port (Ini hanya dokumentasi)
EXPOSE 8080

# Jalankan script start.sh sebagai CMD utama. 
# Script ini akan menjalankan migrasi, storage:link, lalu memulai server dengan $PORT.
CMD ["/usr/local/bin/start.sh"]
