# 🚀 NBM Food Consumption Prediction System

Sistem prediksi konsumsi pangan berbasis Machine Learning untuk data NBM (Neraca Bahan Makanan) Indonesia.

## 📋 Prerequisites

- **PHP 8.2+** dengan Laravel 12
- **Python 3.9+** 
- **MySQL/MariaDB**
- **Composer**
- **Node.js & NPM**

## ⚡ Quick Setup

### 1. Clone & Install Dependencies

```bash
# Clone repository
git clone https://github.com/send0moka/basis-data-konsumsi-pangan.git
cd basis-data-konsumsi-pangan

# Install PHP dependencies
composer install

# Install Node.js dependencies  
npm install

# Copy environment file
cp .env.example .env
```

### 2. Database Setup

```bash
# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=basis_data_konsumsi_pangan
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed
```

### 3. Python ML Model Setup

**Windows:**
```cmd
# Run setup script
setup.bat
```

**Linux/macOS:**
```bash
# Make script executable
chmod +x setup.sh

# Run setup script
./setup.sh
```

**Manual Setup:**
```bash
# Install Python dependencies
pip install -r requirements.txt

# Create production model (if not exists)
python ml_models/production_model.py
```

## 🚀 Running the Application

### Start Python API Server

**Windows:**
```cmd
start_api.bat
```

**Linux/macOS:**
```bash
python nbm_api.py
```

### Start Laravel Server

```bash
# Start Laravel development server
php artisan serve

# Or use Vite for frontend development
npm run dev
```

### Access the Application

- **Main Application:** http://localhost:8000
- **Prediction Interface:** http://localhost:8000/prediksi
- **API Documentation:** http://localhost:8081/docs
- **API Health Check:** http://localhost:8081/health

## 🎯 Model Performance

- **MAPE:** 8.88% (Target: <10% ✅)
- **Accuracy:** 91.12%
- **MAE:** 3.24 kcal/day
- **R²:** 0.826

## 🔧 Troubleshooting

### Model Not Found Error

If you get "nbm_production not found" error:

1. **Run setup script:**
   ```bash
   # Windows
   setup.bat
   
   # Linux/macOS  
   ./setup.sh
   ```

2. **Or manually create model:**
   ```bash
   python ml_models/production_model.py
   ```

### Database Connection Error

1. Ensure MySQL/MariaDB is running
2. Check database credentials in `.env`
3. Create database if not exists:
   ```sql
   CREATE DATABASE basis_data_konsumsi_pangan;
   ```

### Python Dependencies Error

```bash
# Install missing dependencies
pip install -r requirements.txt

# Or install specific packages
pip install fastapi uvicorn pandas numpy scikit-learn joblib mysql-connector-python pymysql
```

### Port Already in Use

- **API Port 8081:** Change port in `nbm_api.py`
- **Laravel Port 8000:** Use `php artisan serve --port=8001`

## 📁 Project Structure

```
├── app/                    # Laravel application
├── ml_models/             # Machine learning models
│   ├── models/            # Trained model files
│   │   └── nbm_production/ # Production model
│   └── production_model.py # Model training script
├── resources/             # Views and assets
├── database/              # Migrations and seeders
├── nbm_api.py            # FastAPI server
├── requirements.txt       # Python dependencies
├── setup.bat             # Windows setup script
├── setup.sh              # Linux/macOS setup script
└── start_api.bat         # Windows API starter
```

## 🎓 How to Use

1. **Login** to the application
2. **Navigate** to Prediksi Konsumsi NBM menu
3. **Input** 6 months of historical food consumption data
4. **Submit** prediction request
5. **View** results with confidence intervals

## 📊 API Endpoints

- `GET /health` - Health check
- `GET /model/stats` - Model statistics
- `POST /predict` - Single prediction
- `POST /predict/batch` - Batch predictions

## 🤝 Contributing

1. Fork the repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## 📄 License

This project is licensed under the MIT License.

## 📞 Support

For issues and questions:
- Create GitHub Issue
- Check troubleshooting section
- Review API documentation at `/docs`

---

**Made with ❤️ for Indonesian Food Security Analysis**
