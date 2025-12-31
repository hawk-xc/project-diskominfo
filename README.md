# Aplikasi Pokemon Diskominfo

installasi :

1. melakukan migrasi
```bash
composer install
php artisan migrate
```

2. membuat user dashboard filament
```bash
php artisan make:filament-user
```

3. mengambil data dari REST API pokemon
```bash
php artisan app:get-pokemon-data
```

4. menyalin dan mengisi .env.example lalu menambahkan requirement yang diperlukan

requirement docker image :
```bash
minio/minio:RELEASE.2025-09-07T16-13-09Z-cpuv1
mysql:latest
```