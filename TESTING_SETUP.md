# Setup Testing Environment

Jika Anda mengalami error terkait SQLite saat menjalankan test, ikuti langkah-langkah berikut:

## 1. Install SQLite Extension

### Windows:
- SQLite biasanya sudah include di PHP Windows
- Jika tidak, download PHP yang sudah include SQLite

### Linux/Ubuntu:
```bash
sudo apt-get install php-sqlite3
```

### macOS:
```bash
brew install sqlite
```

## 2. Pastikan File Database Testing Ada

Buat file database testing kosong:
```bash
touch database/testing.sqlite
```

## 3. Untuk .env.testing (Opsional)

Jika ingin menggunakan konfigurasi testing terpisah:
```bash
cp .env.testing.example .env.testing
```

## 4. Jalankan Test

```bash
# Jalankan semua test
php artisan test

# Atau dengan PHPUnit langsung
./vendor/bin/phpunit
```

## 5. Troubleshooting

### Error: "could not find driver"
- Pastikan extension SQLite terinstall di PHP
- Check dengan: `php -m | grep sqlite`

### Error: "database locked"
- Tutup semua koneksi database
- Restart development server

### Error: "no such table"
- Jalankan migration untuk testing:
```bash
php artisan migrate --env=testing
```

## 6. Reset Database Testing

Jika database testing bermasalah:
```bash
rm database/testing.sqlite
touch database/testing.sqlite
php artisan migrate --env=testing
```
