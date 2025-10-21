#!/bin/bash

# 1. Jalankan Migrasi Database
php artisan migrate --force

# 2. Link Storage (jika perlu)
php artisan storage:link

# 3. Jalankan server (Bind ke PORT Railway)
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
