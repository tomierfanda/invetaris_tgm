#!/bin/bash

# Script ini akan dijalankan saat container dimulai (sebelum server menyala).

echo "Membersihkan dan mengkonfigurasi cache Laravel..."
# Hapus cache konfigurasi lama dan buat ulang
php artisan config:clear
php artisan config:cache

echo "Menetapkan Trusted Proxies..."
# Baris ini SANGAT PENTING untuk deployment di platform cloud (seperti Railway)
# yang menggunakan reverse proxy. Kita menetapkan *proxy* apa pun (melalui *)
# sebagai terpercaya untuk menghindari error Invalid URI/Host.
php artisan config:set app.proxies '*' --force

echo "Menjalankan database migrations..."
# --force diperlukan karena APP_ENV=production, untuk mengonfirmasi migrasi di lingkungan non-interaktif
php artisan migrate --force

echo "Membuat symlink storage..."
# Membuat symlink storage agar file publik bisa diakses
php artisan storage:link

echo "Memulai Laravel server di host 0.0.0.0 dan PORT Railway (${PORT:-8080})..."
# Menggunakan 'exec' untuk menggantikan proses bash dengan proses server utama
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
