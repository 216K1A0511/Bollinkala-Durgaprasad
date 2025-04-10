
# Flask Backend Advanced Features - Module 7

This module covers advanced backend features including asynchronous programming, Azure OpenAI integration, and middleware/logging implementation in Flask applications.

## Table of Contents

1. [Asynchronous Programming in Flask](#asynchronous-programming-in-flask)
2. [Azure OpenAI Integration](#azure-openai-integration)
3. [Middleware and Logging](#middleware-and-logging)

## Asynchronous Programming in Flask

### Key Concepts

- **asyncio**: Python's built-in library for asynchronous programming
- **Event Loop**: Manages execution of asynchronous tasks
- **Coroutines**: Functions defined with `async` that can be paused/resumed
- **Tasks**: Scheduled execution of coroutines

### Implementing Async Endpoints

```python
from flask import Flask
import asyncio

app = Flask(__name__)

@app.route("/async-task")
async def async_task():
    await asyncio.sleep(5)  # Simulate long-running task
    return {"message": "Task Complete"}

# Handling multiple requests concurrently
@app.route("/concurrent-tasks")
async def concurrent_tasks():
    task1 = asyncio.create_task(asyncio.sleep(2))
    task2 = asyncio.create_task(asyncio.sleep(3))
    await task1
    await task2
    return {"message": "Both tasks completed"}
```

### Using Quart for Full Async Support

```python
from quart import Quart
import asyncio

app = Quart(__name__)

@app.route("/generate-question")
async def generate_question():
    question = await fetch_ai_question()  # Async function
    return {"question": question}

async def fetch_ai_question():
    await asyncio.sleep(2)  # Simulate AI API delay
    return "Describe a favorite book you've read recently."

if __name__ == "__main__":
    app.run()
```

## Azure OpenAI Integration

### Setup and Configuration

```python
import openai
from dotenv import load_dotenv
import os

# Load environment variables
load_dotenv()

# Configure Azure OpenAI
openai.api_type = "azure"
openai.api_key = os.getenv("OPENAI_API_KEY")
openai.api_base = os.getenv("OPENAI_API_BASE")
openai.api_version = "2023-05-15"
```

### Generating IELTS Questions

```python
from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route("/generate-question", methods=["POST"])
def generate_question():
    try:
        topic = request.json.get("topic", "general")
        response = openai.Completion.create(
            engine="text-davinci-003",
            prompt=f"Generate an IELTS Speaking Part 2 question about {topic}.",
            max_tokens=50
        )
        question = response.choices[0].text.strip()
        return jsonify({
            "status": "success",
            "data": {"question": question}
        })
    except Exception as e:
        return jsonify({
            "status": "error",
            "message": str(e)
        }), 500
```

### Sample Request/Response

**Request:**
```json
{
  "topic": "a memorable trip"
}
```

**Response:**
```json
{
  "status": "success",
  "data": {
    "question": "Describe a memorable trip you took recently. Include details about the place, activities, and why it was memorable."
  }
}
```

## Middleware and Logging

### Request Validation Middleware

```python
@app.before_request
def validate_request():
    if request.method == "POST":
        if not request.is_json:
            return jsonify({"error": "Request must be JSON"}), 400
        if not request.json:
            return jsonify({"error": "Request body cannot be empty"}), 400
```

### Authentication Middleware

```python
from functools import wraps

def require_auth(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        token = request.headers.get("Authorization")
        if not token or not validate_token(token):
            return jsonify({"error": "Unauthorized"}), 401
        return f(*args, **kwargs)
    return decorated_function

@app.route("/protected")
@require_auth
def protected_route():
    return jsonify({"message": "Access granted"})
```

### Logging Configuration

```python
import logging
from logging.handlers import RotatingFileHandler
from datetime import datetime
import json

# Basic logging setup
logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s - %(levelname)s - %(message)s"
)

# Advanced logging with rotation
handler = RotatingFileHandler(
    "app.log",
    maxBytes=1000000,  # 1MB
    backupCount=5
)
handler.setFormatter(logging.Formatter(
    "%(asctime)s - %(levelname)s - %(message)s"
))
logging.getLogger().addHandler(handler)

# Request logging middleware
@app.after_request
def log_request(response):
    log_data = {
        "timestamp": str(datetime.now()),
        "method": request.method,
        "path": request.path,
        "status": response.status_code,
        "ip": request.remote_addr
    }
    logging.info(json.dumps(log_data))
    return response
```

### Error Handling

```python
@app.errorhandler(404)
def not_found(error):
    logging.warning(f"404 Error: {request.path}")
    return jsonify({"error": "Resource not found"}), 404

@app.errorhandler(500)
def internal_error(error):
    logging.error(f"500 Error: {str(error)}")
    return jsonify({"error": "Internal server error"}), 500
```

## Best Practices

1. **Asynchronous Programming**:
   - Use Quart for full async support when needed
   - Avoid mixing sync and async code
   - Test with concurrent requests

2. **Azure OpenAI**:
   - Store API keys in environment variables
   - Implement rate limiting
   - Craft precise prompts for best results
   - Log all AI requests

3. **Middleware**:
   - Keep middleware focused and modular
   - Validate all incoming requests
   - Implement proper authentication

4. **Logging**:
   - Use structured logging (JSON format)
   - Implement log rotation
   - Include relevant metadata
   - Avoid logging sensitive information
   - Set up monitoring for critical errors

## Example Project Structure

```
ielts_backend/
├── app.py                  # Main application
├── config.py               # Configuration settings
├── middleware/             # Custom middleware
│   ├── auth.py             # Authentication middleware
│   └── validation.py       # Request validation
├── services/               # Business logic
│   ├── ai_service.py       # OpenAI integration
│   └── database.py         # Database operations
├── utils/                  # Utilities
│   ├── logging.py          # Logging configuration
│   └── async_helpers.py    # Async utilities
├── requirements.txt        # Dependencies
└── .env                    # Environment variables
```

## Installation

```bash
# Install dependencies
pip install flask quart openai python-dotenv

# For logging and monitoring
pip install sentry-sdk
```
