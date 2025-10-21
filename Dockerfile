# Gunakan image PHP-FPM yang lebih stabil dan sesuai untuk web serving
FROM php:8.2-fpm

# Install dependensi sistem dan ekstensi PHP yang dibutuhkan Laravel + phpspreadsheet
RUN apt-get update && apt-get install -y \
    zip unzip git libzip-dev libpng-dev libonig-dev libxml2-dev libjpeg-dev libfreetype6-dev \
    # Tambahkan curl karena dibutuhkan untuk mengunduh Composer
    && apt-get install -y curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Set workdir ke /app (Standar untuk project)
WORKDIR /app

# --- INSTALASI COMPOSER ---
# 1. Unduh Composer dan pindahkan ke /usr/local/bin agar tersedia secara global
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer file terlebih dahulu untuk memanfaatkan caching Docker layer
COPY composer.json composer.lock ./

# 2. Jalankan composer install
# Composer sekarang tersedia sebagai perintah global 'composer'
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy sisa file project, termasuk start.sh, ke dalam container
COPY . .

# Set izin (permissions) yang benar untuk folder storage dan cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Salin script start.sh dan berikan izin eksekusi
# Pastikan start.sh ada di root project Anda!
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Expose port (Ini hanya dokumentasi)
EXPOSE 8080

# Jalankan script start.sh sebagai CMD utama. 
CMD ["/usr/local/bin/start.sh"]
