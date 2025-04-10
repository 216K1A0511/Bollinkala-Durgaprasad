
# Flask Backend Basics - Module 5

This module covers the fundamentals of building a Flask backend, including project structure, database integration with SQLAlchemy, RESTful API design, and middleware/error handling.

## Table of Contents

1. [Flask Project Structure](#flask-project-structure)
2. [Configuring SQLAlchemy ORM](#configuring-sqlalchemy-orm)
3. [Defining Models and CRUD Operations](#defining-models-and-crud-operations)
4. [RESTful API Design](#restful-api-design)
5. [Middleware and Error Handling](#middleware-and-error-handling)

## Flask Project Structure

### Recommended Structure

```
project/
├── app.py                # Main application entry point
├── models.py             # Database models
├── config.py            # Configuration settings
├── routes/              # Directory for route files
│   ├── __init__.py      # Initializes blueprints
│   ├── user_routes.py   # User-related endpoints
│   ├── test_routes.py   # Test-related endpoints
├── static/              # Static files (CSS, JS, images)
├── templates/           # HTML template files
├── requirements.txt     # Python dependencies
```

### Using Blueprints

```python
# routes/user_routes.py
from flask import Blueprint, jsonify

user_routes = Blueprint('user_routes', __name__)

@user_routes.route('/users', methods=['GET'])
def get_users():
    return jsonify({"message": "User list"})

# app.py
from flask import Flask
from routes.user_routes import user_routes

app = Flask(__name__)
app.register_blueprint(user_routes, url_prefix='/api')
```

## Configuring SQLAlchemy ORM

### Setup

```python
# config.py
class Config:
    SQLALCHEMY_DATABASE_URI = "mysql+pymysql://root:password@localhost:3306/ielts_app"
    SQLALCHEMY_TRACK_MODIFICATIONS = False
    SECRET_KEY = "your-secret-key"

# app.py
from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from config import Config

app = Flask(__name__)
app.config.from_object(Config)
db = SQLAlchemy(app)
```

### Database Migrations

```bash
pip install flask-migrate
flask db init
flask db migrate -m "Initial migration"
flask db upgrade
```

## Defining Models and CRUD Operations

### Sample Models

```python
# models.py
from app import db

class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100), nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    tests = db.relationship("SpeakingTest", backref="user", lazy=True)

class SpeakingTest(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey("user.id"), nullable=False)
    question = db.Column(db.String(255), nullable=False)
    score = db.Column(db.Integer)
```

### CRUD Examples

```python
# Create
new_user = User(name="Alice", email="alice@example.com")
db.session.add(new_user)
db.session.commit()

# Read
users = User.query.all()
user = User.query.get(1)

# Update
user = User.query.get(1)
user.name = "Alice Updated"
db.session.commit()

# Delete
user = User.query.get(1)
db.session.delete(user)
db.session.commit()
```

## RESTful API Design

### Best Practices

1. Use intuitive, resource-based URLs:
   - GET /api/users
   - POST /api/users
   - GET /api/users/{id}
   - PUT /api/users/{id}
   - DELETE /api/users/{id}

2. Return appropriate HTTP status codes
3. Validate request payloads
4. Provide consistent JSON responses

### Example Endpoint

```python
from flask import request, jsonify
from marshmallow import Schema, fields, ValidationError

class UserSchema(Schema):
    name = fields.String(required=True)
    email = fields.Email(required=True)

user_schema = UserSchema()

@app.route("/api/users", methods=["POST"])
def create_user():
    data = request.get_json()
    try:
        validated_data = user_schema.load(data)
        # Process data...
        return jsonify({"status": "success", "data": validated_data}), 201
    except ValidationError as err:
        return jsonify({"status": "error", "errors": err.messages}), 400
```

## Middleware and Error Handling

### Authentication Middleware

```python
from functools import wraps

def require_auth(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        token = request.headers.get("Authorization")
        if not token or token != "valid_token":
            return jsonify({"error": "Unauthorized"}), 401
        return func(*args, **kwargs)
    return wrapper

@app.route("/protected")
@require_auth
def protected_route():
    return jsonify({"message": "Access granted"})
```

### Error Handling

```python
import logging
logging.basicConfig(filename="app.log", level=logging.ERROR)

@app.errorhandler(404)
def not_found(error):
    return jsonify({"error": "Resource not found"}), 404

@app.errorhandler(Exception)
def handle_exception(error):
    app.logger.error(f"Error: {str(error)}")
    return jsonify({"error": "An unexpected error occurred"}), 500
```

## Installation

1. Set up a virtual environment:
```bash
python -m venv venv
source venv/bin/activate  # Linux/Mac
venv\Scripts\activate     # Windows
```

2. Install dependencies:
```bash
pip install flask flask-sqlalchemy pymysql flask-migrate marshmallow
```

## Running the Application

```bash
python app.py
```

## Best Practices

1. Keep your project modular with blueprints
2. Use environment variables for sensitive configuration
3. Validate all incoming data
4. Implement proper error handling and logging
5. Follow RESTful principles for API design
6. Use migrations for database schema changes
7. Write tests for your routes and models
