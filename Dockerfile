# Gunakan image PHP bawaan yang sudah stabil
FROM php:8.2-cli

# Install dependensi sistem dan ekstensi PHP yang dibutuhkan Laravel + phpspreadsheet
RUN apt-get update && apt-get install -y \
    zip unzip git libzip-dev libpng-dev libonig-dev libxml2-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Set workdir ke /app
WORKDIR /app

# Copy semua file project ke dalam container
COPY . .

# Install composer dan dependencies
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php composer.phar install --no-dev --optimize-autoloader --no-interaction

# Expose port (bisa override lewat .env)
EXPOSE 8080

# Jalankan Laravel server pakai port dari ENV atau default 8080
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${APP_PORT:-8080}"]
