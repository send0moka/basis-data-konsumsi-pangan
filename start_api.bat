@echo off
echo Starting NBM Prediction API Server...
echo.

cd /d "%~dp0"

echo Activating virtual environment...
call ml_models\lstm_env\Scripts\activate.bat

echo.
echo Installing/updating dependencies...
pip install fastapi uvicorn pydantic python-multipart pandas numpy scikit-learn joblib mysql-connector-python sqlalchemy python-dotenv

echo.
echo Starting FastAPI server...
echo API will be available at:
echo   - Swagger UI: http://localhost:8081/docs
echo   - ReDoc: http://localhost:8081/redoc
echo   - Health Check: http://localhost:8081/health
echo.
echo Press Ctrl+C to stop the server
echo.

python nbm_api.py
