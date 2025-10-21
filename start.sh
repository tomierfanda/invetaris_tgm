#!/bin/bash

# Script ini akan dijalankan saat container dimulai (sebelum server menyala).

echo "Membersihkan dan mengkonfigurasi cache Laravel..."
# Hapus semua cache untuk memastikan konfigurasi baru dari .env terload
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Buat cache konfigurasi, route, dan view yang baru. 
# Ini penting untuk performa di production.
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Catatan: Baris 'php artisan config:set app.proxies "*"' dihapus
# karena sering tidak efektif di php artisan serve.
# Asumsi: APP_URL sudah diset dengan benar di environment variables Railway.

echo "Menjalankan database migrations..."
# --force diperlukan karena APP_ENV=production
php artisan migrate --force

echo "Membuat symlink storage..."
# Membuat symlink storage agar file publik bisa diakses
php artisan storage:link

echo "Memulai Laravel server di host 0.0.0.0 dan PORT Railway (${PORT:-8080})..."
# Menggunakan 'exec' untuk menggantikan proses bash dengan proses server utama
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
