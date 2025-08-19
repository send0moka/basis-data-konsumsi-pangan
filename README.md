# Basis Data Konsumsi Pangan

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![Livewire](https://img.shields.io/badge/Livewire-3.x-green.svg)
![Python](https://img.shields.io/badge/Python-3.9+-blue.svg)

Sistem informasi basis data konsumsi pangan dengan fitur prediksi Nilai Belanja Makanan (NBM) menggunakan machine learning. Aplikasi ini dibangun dengan Laravel dan Livewire untuk frontend yang modern dan responsif.

## 🌟 Fitur Utama

- **Manajemen Data Konsumsi Pangan** CRUD lengkap untuk kelompok, komoditi, dan transaksi
- **Dashboard Interaktif** Visualisasi data dengan chart dan statistik
- **Export Data** Export ke Excel untuk berbagai entitas
- **Sistem Role & Permission** Kontrol akses berbasis peran
- **Prediksi NBM** Machine learning model dengan akurasi 8.88% MAPE
- **API ML** FastAPI server untuk prediksi real-time

## 📋 Prasyarat Sistem

### Software Yang Diperlukan:
- **PHP** 8.2 atau lebih tinggi
- **Composer** (untuk dependency PHP)
- **Node.js** & **npm** (untuk asset building)
- **MySQL** atau **MariaDB**
- **Git** (untuk cloning repository)
- **Python** 3.9+ (untuk ML model)

### Web Server:
- **XAMPP** (recommended untuk Windows)
- **Laragon** 
- **WAMP/LAMP** stack
- Atau web server lainnya dengan PHP support

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/send0moka/basis-data-konsumsi-pangan.git
cd basis-data-konsumsi-pangan
```

### 2. Setup Environment

Copy file environment dan sesuaikan konfigurasi:

```bash
cp .env.example .env
```

Edit file `.env` sesuai dengan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=konsumsi_pangan
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Install Dependencies

#### Install PHP Dependencies:
```bash
composer install
```

#### Install Node.js Dependencies:
```bash
npm install
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Setup Database

Buat database MySQL terlebih dahulu:

```sql
CREATE DATABASE konsumsi_pangan;
```

#### **Pilihan A: Menggunakan Migration & Seed (Recommended)**

Jalankan migration dan seeder untuk membuat struktur database dan data sample:

```bash
php artisan migrate:fresh --seed
```

#### **Pilihan B: Import SQL File**

Jika Anda memilih menggunakan file SQL yang sudah tersedia:

```bash
# Import menggunakan MySQL command line
mysql -u root -p konsumsi_pangan < konsumsi_pangan.sql

# Atau menggunakan phpMyAdmin:
# 1. Buka phpMyAdmin
# 2. Pilih database 'konsumsi_pangan'
# 3. Klik tab 'Import'
# 4. Upload file 'konsumsi_pangan.sql'
# 5. Klik 'Go'
```

### 6. Setup Machine Learning Environment

#### **Automated Setup (Recommended)**

Gunakan script setup otomatis:

**Windows:**
```bash
setup.bat
```

**Linux/macOS:**
```bash
chmod +x setup.sh
./setup.sh
```

#### **Manual Setup**

Jika Anda ingin setup manual:

```bash
# Install Python dependencies
cd ml_models
pip install -r requirements.txt

# Generate production model
python production_model.py

# Test model
python test_setup.py
```

### 7. Build Assets

```bash
npm run build
```

Untuk development dengan hot reload:
```bash
npm run dev
```

### 8. Set Permissions (Linux/macOS)

```bash
chmod -R 775 storage bootstrap/cache
```

## 🎯 Menjalankan Aplikasi

### 1. Start Laravel Server

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

### 2. Start ML API Server

Untuk menggunakan fitur prediksi NBM, jalankan API server:

**Windows:**
```bash
start_api.bat
```

**Linux/macOS:**
```bash
./start_api.sh
```

API akan berjalan di: `http://localhost:8081`

### 3. Login ke Aplikasi

**Super Admin:**
- Email: `superadmin@example.com`
- Password: `password`

**Admin:**
- Email: `admin@example.com`
- Password: `password`

## 📁 Struktur Project

```
basis-data-konsumsi-pangan/
├── app/                    # Core aplikasi Laravel
│   ├── Http/Controllers/   # Controllers
│   ├── Livewire/          # Livewire components
│   ├── Models/            # Eloquent models
│   └── Services/          # Business logic services
├── database/              # Database files
│   ├── migrations/        # Database migrations
│   └── seeders/          # Database seeders
├── ml_models/             # Machine Learning models
│   ├── models/           # Trained models
│   ├── data/            # Training data
│   └── production_model.py # Production model
├── resources/
│   ├── views/           # Blade templates
│   ├── css/            # Stylesheets
│   └── js/             # JavaScript files
├── routes/              # Route definitions
├── public/              # Public assets
├── konsumsi_pangan.sql  # Database dump file
├── setup.bat/.sh        # Setup scripts
└── start_api.bat/.sh    # API server scripts
```

## 🧪 Testing

Jalankan test suite:

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=ExampleTest
```

## 📊 Fitur Machine Learning

### Model Specifications:
- **Algorithm**: HuberRegressor Ensemble
- **Accuracy**: 8.88% MAPE (Mean Absolute Percentage Error)
- **Input Features**: Kelompok BPS, Komoditi BPS, Tahun, Bulan
- **Output**: Prediksi Nilai Belanja Makanan (NBM)

### API Endpoints:

```
GET  /health              # Health check
POST /predict             # Single prediction
POST /predict/batch       # Batch prediction
GET  /model/info          # Model information
GET  /model/features      # Available features
POST /model/validate      # Validate input data
```

## 🔧 Troubleshooting

### Masalah Umum:

**1. Error "production model not found":**
```bash
# Jalankan setup script
setup.bat  # Windows
./setup.sh # Linux/macOS
```

**2. Error koneksi database:**
- Pastikan MySQL/MariaDB berjalan
- Periksa konfigurasi `.env`
- Pastikan database sudah dibuat

**3. Error permission (Linux/macOS):**
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

**4. Error Composer:**
```bash
composer clear-cache
composer install --no-cache
```

**5. Error NPM:**
```bash
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

**6. ML API tidak bisa diakses:**
- Pastikan Python dependencies terinstall
- Jalankan `start_api.bat` atau `start_api.sh`
- Periksa port 8081 tidak digunakan aplikasi lain

## 🛠️ Development

### Menambah Fitur Baru:

1. **Livewire Component**:
```bash
php artisan make:livewire ComponentName
```

2. **Model & Migration**:
```bash
php artisan make:model ModelName -m
```

3. **Seeder**:
```bash
php artisan make:seeder SeederName
```

### Code Style:

```bash
# Format code dengan Laravel Pint
./vendor/bin/pint
```

## 📝 API Documentation

Dokumentasi lengkap API ML tersedia di:
`http://localhost:8081/docs` (Swagger UI)

**Happy Coding! 🚀**