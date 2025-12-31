# Aplikasi Pokemon Diskominfo

## Installation Requirement :

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

### Docker Image
requirement docker image yang dibutuhkan :
```bash
minio/minio:RELEASE.2025-09-07T16-13-09Z-cpuv1
mysql:latest
```

- minio : sebagai storage object
- mysql : sebagai penyimpanan data berelasi

## Get Data Logic
```bash
1. Consume data dari API Pokemon
2. Menyimpan description URL dari API Pokemon
3. Consume meta data pokemon
```