import os
from dotenv import load_dotenv

load_dotenv()

class Config:
    GEMINI_API_KEY = os.getenv("AIzaSyAK3gTLi0up31iGqs1Z2IvEwa-RNX6lBJA")
    GEMINI_MODEL = "gemini-1.5-flash"  # Updated to latest model
    API_VERSION = "v1"
    MAX_TOKENS = 1000
    TEMPERATURE = 0.7
    SAFETY_SETTINGS = {
        "HARASSMENT": "BLOCK_NONE",
        "HATE_SPEECH": "BLOCK_NONE",
        "SEXUALLY_EXPLICIT": "BLOCK_NONE",
        "DANGEROUS_CONTENT": "BLOCK_NONE"
    }
    DATABASE_URL = "sqlite:///ielts_speaking_test.db"