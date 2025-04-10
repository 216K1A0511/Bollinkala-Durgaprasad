
Here’s a complete `README.md` file for your IELTS Speaking Test Platform project. This file provides an overview of the project, setup instructions, API documentation, and examples for testing with Postman.

---

## **IELTS Speaking Test Platform**

This is a Flask-based backend application for managing users, speaking tests, and listening tests. It provides CRUD (Create, Read, Update, Delete) functionality for the following entities:

- **User**: Stores user information.
- **SpeakingTest**: Stores speaking test results.
- **ListeningTest**: Stores listening test results.

---

## **Features**
- **User Management**:
  - Create, read, update, and delete users.
- **Speaking Test Management**:
  - Create, read, update, and delete speaking test results.
- **Listening Test Management**:
  - Create, read, update, and delete listening test results.

---

## **Technologies Used**
- **Flask**: A lightweight Python web framework.
- **SQLAlchemy**: An ORM for database interactions.
- **SQLite**: A lightweight database for development.

---

## **Setup Instructions**

### **1. Prerequisites**
- Python 3.8 or higher.
- Pip (Python package manager).

### **2. Install Dependencies**
Run the following command to install the required dependencies:
```bash
pip install flask flask-sqlalchemy
```

### **3. Run the Application**
1. Clone the repository or download the `app.py` file.
2. Navigate to the project directory.
3. Run the Flask application:
   ```bash
   python app.py
   ```
4. The application will start on `http://localhost:5000`.

---

## **API Documentation**

### **Base URL**
```
http://localhost:5000
```

---

### **User Endpoints**

#### **1. Create a User**
- **Method**: `POST`
- **URL**: `/users`
- **Request Body**:
  ```json
  {
      "name": "John Doe",
      "email": "john@example.com",
      "password": "secure123"
  }
  ```
- **Response**:
  ```json
  {
      "message": "User created",
      "id": 1
  }
  ```

#### **2. Get a User**
- **Method**: `GET`
- **URL**: `/users/<int:user_id>`
- **Response**:
  ```json
  {
      "name": "John Doe",
      "email": "john@example.com"
  }
  ```

#### **3. Update a User**
- **Method**: `PUT`
- **URL**: `/users/<int:user_id>`
- **Request Body**:
  ```json
  {
      "name": "John Updated",
      "email": "john.updated@example.com"
  }
  ```
- **Response**:
  ```json
  {
      "message": "User updated"
  }
  ```

#### **4. Delete a User**
- **Method**: `DELETE`
- **URL**: `/users/<int:user_id>`
- **Response**:
  ```json
  {
      "message": "User deleted"
  }
  ```

---

### **Speaking Test Endpoints**

#### **1. Create a Speaking Test**
- **Method**: `POST`
- **URL**: `/speaking-tests`
- **Request Body**:
  ```json
  {
      "user_id": 1,
      "question": "Describe your favorite book",
      "response": "My favorite book is...",
      "score": 7.5
  }
  ```
- **Response**:
  ```json
  {
      "message": "Speaking test created",
      "id": 1
  }
  ```

#### **2. Get a Speaking Test**
- **Method**: `GET`
- **URL**: `/speaking-tests/<int:test_id>`
- **Response**:
  ```json
  {
      "id": 1,
      "user_id": 1,
      "question": "Describe your favorite book",
      "response": "My favorite book is...",
      "score": 7.5
  }
  ```

#### **3. Update a Speaking Test**
- **Method**: `PUT`
- **URL**: `/speaking-tests/<int:test_id>`
- **Request Body**:
  ```json
  {
      "score": 8.0
  }
  ```
- **Response**:
  ```json
  {
      "message": "Speaking test updated"
  }
  ```

#### **4. Delete a Speaking Test**
- **Method**: `DELETE`
- **URL**: `/speaking-tests/<int:test_id>`
- **Response**:
  ```json
  {
      "message": "Speaking test deleted"
  }
  ```

---

### **Listening Test Endpoints**

#### **1. Create a Listening Test**
- **Method**: `POST`
- **URL**: `/listening-tests`
- **Request Body**:
  ```json
  {
      "user_id": 1,
      "question": "Summarize the lecture",
      "response": "The lecture discussed...",
      "score": 6.5
  }
  ```
- **Response**:
  ```json
  {
      "message": "Listening test created",
      "id": 1
  }
  ```

#### **2. Get a Listening Test**
- **Method**: `GET`
- **URL**: `/listening-tests/<int:test_id>`
- **Response**:
  ```json
  {
      "id": 1,
      "user_id": 1,
      "question": "Summarize the lecture",
      "response": "The lecture discussed...",
      "score": 6.5
  }
  ```

#### **3. Update a Listening Test**
- **Method**: `PUT`
- **URL**: `/listening-tests/<int:test_id>`
- **Request Body**:
  ```json
  {
      "score": 7.0
  }
  ```
- **Response**:
  ```json
  {
      "message": "Listening test updated"
  }
  ```

#### **4. Delete a Listening Test**
- **Method**: `DELETE`
- **URL**: `/listening-tests/<int:test_id>`
- **Response**:
  ```json
  {
      "message": "Listening test deleted"
  }
  ```

---

## **Testing with Postman**

1. **Import the Postman Collection**:
   - Download the Postman collection JSON file (provided below).
   - Open Postman and click **Import** > **Upload Files** to import the collection.

2. **Run the Flask Application**:
   - Start the Flask app using `python app.py`.

3. **Test the Endpoints**:
   - Use the imported Postman collection to test all CRUD operations.

---

## **Postman Collection JSON**
```json
{
    "info": {
        "name": "IELTS Test Platform",
        "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
    },
    "item": [
        {
            "name": "Users",
            "item": [
                {
                    "name": "Create User",
                    "request": {
                        "method": "POST",
                        "header": [],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"name\": \"John Doe\",\n    \"email\": \"john@example.com\",\n    \"password\": \"secure123\"\n}"
                        },
                        "url": {
                            "raw": "http://localhost:5000/users",
                            "protocol": "http",
                            "host": ["localhost"],
                            "port": "5000",
                            "path": ["users"]
                        }
                    }
                },
                {
                    "name": "Get User",
                    "request": {
                        "method": "GET",
                        "header": [],
                        "url": {
                            "raw": "http://localhost:5000/users/1",
                            "protocol": "http",
                            "host": ["localhost"],
                            "port": "5000",
                            "path": ["users", "1"]
                        }
                    }
                },
                {
                    "name": "Update User",
                    "request": {
                        "method": "PUT",
                        "header": [],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"name\": \"John Updated\",\n    \"email\": \"john.updated@example.com\"\n}"
                        },
                        "url": {
                            "raw": "http://localhost:5000/users/1",
                            "protocol": "http",
                            "host": ["localhost"],
                            "port": "5000",
                            "path": ["users", "1"]
                        }
                    }
                },
                {
                    "name": "Delete User",
                    "request": {
                        "method": "DELETE",
                        "header": [],
                        "url": {
                            "raw": "http://localhost:5000/users/1",
                            "protocol": "http",
                            "host": ["localhost"],
                            "port": "5000",
                            "path": ["users", "1"]
                        }
                    }
                }
            ]
        },
        {
            "name": "Speaking Tests",
            "item": [
                {
                    "name": "Create Speaking Test",
                    "request": {
                        "method": "POST",
                        "header": [],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"user_id\": 1,\n    \"question\": \"Describe your favorite book\",\n    \"response\": \"My favorite book is...\",\n    \"score\": 7.5\n}"
                        },
                        "url": {
                            "raw": "http://localhost:5000/speaking-tests",
                            "protocol": "http",
                            "host": ["localhost"],
                            "port": "5000",
                            "path": ["speaking-tests"]
                        }
                    }
                },
                {
                    "name": "Get Speaking Test",
                    "request": {
                        "method": "GET",
                        "header": [],
                        "url": {
                            "raw": "http://localhost:5000/speaking-tests/1",
                            "protocol": "http",
                            "host": ["localhost"],
                            "port": "5000",
                            "path": ["speaking-tests", "1"]
                        }
                    }
                },
                {
                    "name": "Update Speaking Test",
                    "request": {
                        "method": "PUT",
                        "header": [],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"score\": 8.0\n}"
                        },
                        "url": {
                            "raw": "http://localhost:5000/speaking-tests/1",
                            "protocol": "http",
                            "host": ["localhost"],
                            "port": "5000",
                            "path": ["speaking-tests", "1"]
                        }
                    }
                },
                {
                    "name": "Delete Speaking Test",
                    "request": {
                        "method": "DELETE",
                        "header": [],
                        "url": {
                            "raw": "http://localhost:5000/speaking-tests/1",
                            "protocol": "http",
                            "host": ["localhost"],
                            "port": "5000",
                            "path": ["speaking-tests", "1"]
                        }
                    }
                }
            ]
        },
        {
            "name": "Listening Tests",
            "item": [
                {
                    "name": "Create Listening Test",
                    "request": {
                        "method": "POST",
                        "header": [],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"user_id\": 1,\n    \"question\": \"Summarize the lecture\",\n    \"response\": \"The lecture discussed...\",\n    \"score\": 6.5\n}"
                        },
                        "url": {
                            "raw": "http://localhost:5000/listening-tests",
                            "protocol": "http",
                            "host": ["localhost"],
                            "port": "5000",
                            "path": ["listening-tests"]
                        }
                    }
                },
                {
                    "name": "Get Listening Test",
                    "request": {
                        "method": "GET",
                        "header": [],
                        "url": {
                            "raw": "http://localhost:5000/listening-tests/1",
                            "protocol": "http",
                            "host": ["localhost"],
                            "port": "5000",
                            "path": ["listening-tests", "1"]
                        }
                    }
                },
                {
                    "name": "Update Listening Test",
                    "request": {
                        "method": "PUT",
                        "header": [],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"score\": 7.0\n}"
                        },
                        "url": {
                            "raw": "http://localhost:5000/listening-tests/1",
                            "protocol": "http",
                            "host": ["localhost"],
                            "port": "5000",
                            "path": ["listening-tests", "1"]
                        }
                    }
                },
                {
                    "name": "Delete Listening Test",
                    "request": {
                        "method": "DELETE",
                        "header": [],
                        "url": {
                            "raw": "http://localhost:5000/listening-tests/1",
                            "protocol": "http",
                            "host": ["localhost"],
                            "port": "5000",
                            "path": ["listening-tests", "1"]
                        }
                    }
                }
            ]
        }
    ]
}
```

---

