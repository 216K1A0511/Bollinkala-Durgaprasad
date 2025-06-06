
# Web-Development-Module-7-Assignment13

## Objective
Integrate Azure OpenAI into the IELTS Speaking Test platform to dynamically generate speaking test questions using Flask as the backend. This README documents the implementation, configuration, and testing of the `/api/ai-questions` endpoint.

---

## Features
- Real-time question generation using Azure OpenAI
- Configurable input parameters: question type, difficulty, topic
- Robust error handling
- Secure environment configuration

---

## Project Structure
```
ielts-speaking-backend/
├── app.py                # Flask backend with /api/ai-questions endpoint
├── config.py             # Configuration for Azure OpenAI API
├── .env                  # Environment variables (not tracked in Git)
├── requirements.txt      # Python dependencies
└── README.md             # Documentation
```

---

## Configuration

### 1. Environment Variables
Create a `.env` file in the root of your project with the following:
```
AZURE_OPENAI_API_KEY=your_azure_openai_api_key_here
AZURE_OPENAI_ENDPOINT=https://your-resource-name.openai.azure.com/
AZURE_OPENAI_DEPLOYMENT=your-deployment-name
```

> **Note:** Never expose your API keys in source code or version control.

### 2. config.py
```python
import os
from dotenv import load_dotenv

load_dotenv()

AZURE_OPENAI_API_KEY = os.getenv("AZURE_OPENAI_API_KEY")
AZURE_OPENAI_ENDPOINT = os.getenv("AZURE_OPENAI_ENDPOINT")
AZURE_OPENAI_DEPLOYMENT = os.getenv("AZURE_OPENAI_DEPLOYMENT")
```

---

## /api/ai-questions Endpoint

### URL:
```
POST /api/ai-questions
```

### Request Body:
```json
{
  "type": "part1",
  "difficulty": "medium",
  "topic": "technology"
}
```

### Response:
```json
{
  "questions": [
    "What kind of technology do you use every day?",
    "How has technology changed the way people communicate?",
    "Do you think children should be taught to use technology in school?",
    "Describe a gadget you find very useful.",
    "Do you think people rely too much on technology?"
  ],
  "status": "success"
}
```

---

## Testing

### ✅ Successful Call:
- Input:
```json
{
  "type": "part2",
  "difficulty": "hard",
  "topic": "education"
}
```
- Output:
```json
{
  "questions": ["Describe a memorable teacher you had...", ...],
  "status": "success"
}
```

### ❌ Invalid Type:
- Input:
```json
{
  "type": "invalid",
  "difficulty": "medium"
}
```
- Output:
```json
{
  "error": "Invalid question type",
  "status": "error"
}
```

### ❌ API Failure (e.g. bad key):
- Output:
```json
{
  "error": "API request failed: 401 Unauthorized",
  "status": "error"
}
```

---

## Dependencies
```
flask
flask-cors
requests
python-dotenv
```
Install with:
```
pip install -r requirements.txt
```

---

## Notes
- Endpoint is designed to be easily extended (e.g., add categories, language levels)
- Modular configuration allows for switching between OpenAI providers

---



