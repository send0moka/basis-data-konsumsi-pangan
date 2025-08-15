#!/usr/bin/env python3
"""
Quick test for the NBM API prediction endpoint
"""

import requests
import json

def test_prediction():
    url = "http://localhost:8081/predict"
    
    # Sample data that matches the expected format
    data = {
        "data": [
            {"tahun": 2024, "bulan": 1, "kelompok": "Padi-padian", "komoditi": "Beras", "kalori_hari": 45.5},
            {"tahun": 2024, "bulan": 2, "kelompok": "Padi-padian", "komoditi": "Beras", "kalori_hari": 47.2},
            {"tahun": 2024, "bulan": 3, "kelompok": "Padi-padian", "komoditi": "Beras", "kalori_hari": 46.8},
            {"tahun": 2024, "bulan": 4, "kelompok": "Padi-padian", "komoditi": "Beras", "kalori_hari": 48.1},
            {"tahun": 2024, "bulan": 5, "kelompok": "Padi-padian", "komoditi": "Beras", "kalori_hari": 47.9},
            {"tahun": 2024, "bulan": 6, "kelompok": "Padi-padian", "komoditi": "Beras", "kalori_hari": 49.3}
        ]
    }
    
    try:
        print("🧪 Testing prediction endpoint...")
        response = requests.post(url, json=data, timeout=30)
        
        if response.status_code == 200:
            result = response.json()
            print("✅ Prediction successful!")
            print(f"   Predicted calories: {result['prediction']} kcal/day")
            print(f"   Confidence: {result['confidence_interval']['lower']:.2f} - {result['confidence_interval']['upper']:.2f}")
            print(f"   Model MAPE: {result['model_info']['mape']}")
            return True
        else:
            print(f"❌ Prediction failed with status {response.status_code}")
            print(f"   Error: {response.text}")
            return False
            
    except Exception as e:
        print(f"❌ Test failed with error: {str(e)}")
        return False

if __name__ == "__main__":
    success = test_prediction()
    print(f"\n{'✅ Test PASSED' if success else '❌ Test FAILED'}")
