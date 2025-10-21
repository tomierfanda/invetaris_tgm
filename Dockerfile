Gunakan base image PHP FPM dengan Alpine (lebih ringan)

FROM php:8.2-fpm-alpine

=========================================================

1. Instalasi Dependensi Sistem dan PHP Extensions

=========================================================

Instal dependensi sistem yang dibutuhkan oleh PHP extensions

dan Composer.

RUN apk update && apk add --no-cache 

git 

# Dependensi untuk ext-zip (PENTING untuk phpspreadsheet/Excel)
libzip-dev 

# Dependensi untuk ext-gd (untuk manipulasi gambar)
libpng-dev 

libjpeg-turbo-dev 

freetype-dev 

# Dependensi untuk ext-pdo_mysql
mysql-client 

&& rm -rf /var/cache/apk/*

Instalasi PHP extensions

RUN docker-php-ext-install pdo pdo_mysql bcmath opcache 

# Instal 'zip' yang jadi biang keladinya di buildpack otomatis
&& docker-php-ext-install zip 

# Konfigurasi dan instal 'gd'
&& docker-php-ext-configure gd --with-freetype --with-jpeg 

&& docker-php-ext-install gd

=========================================================

2. Instalasi Composer dan Aplikasi

=========================================================

Instal Composer secara global

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

Atur direktori kerja

WORKDIR /app

Salin semua kode aplikasi ke dalam container

COPY . /app

Instal dependensi PHP (sekarang ext-zip sudah ada, jadi ini akan sukses)

Gunakan --no-dev untuk lingkungan produksi

RUN composer install --no-dev --optimize-autoloader --no-scripts

Atur permissions (penting untuk folder storage)

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache 

&& chmod -R 775 /app/storage /app/bootstrap/cache

=========================================================

3. Konfigurasi Web Server dan Start Command

=========================================================

Salin Nginx config (asumsi kamu menggunakan Nginx/Caddy di front)

Jika Railway menggunakan Buildpack otomatis (FrankenPHP), kamu mungkin tidak perlu ini.

Namun, Artisan Serve adalah cara termudah.

Gunakan Artisan Serve sebagai Start Command

EXPOSE 8000

Perintah utama saat container dijalankan (Runtime)

1. Jalankan storage:link (untuk mengatasi symlink error)

2. Jalankan Artisan Serve

CMD sh -c "php artisan storage:link && php artisan key:generate && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"