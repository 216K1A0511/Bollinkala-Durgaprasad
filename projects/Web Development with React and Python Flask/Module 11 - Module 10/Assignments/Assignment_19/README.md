# Module 10: Security and Authentication

**IELTS Speaking Test Platform**

## Overview

This module focuses on securing the backend of the IELTS Speaking Test platform using best practices in **user authentication**, **password hashing**, and **JWT-based authorization**. It also includes the implementation details and deliverables for **Assignment 19: Implement JWT Authentication**.

---

## 🔐 Backend Security

### 1. Password Hashing with `werkzeug.security`

#### 1.1 Why Secure Passwords?

* Plaintext passwords are insecure and prone to leaks.
* Hashing transforms a password into a one-way, fixed-length string.
* Salting the hash defends against rainbow table and dictionary attacks.

#### 1.2 Using `werkzeug.security`

* **Hash a password**:

  ```python
  from werkzeug.security import generate_password_hash
  hashed = generate_password_hash("your_password")
  ```
* **Verify a password**:

  ```python
  from werkzeug.security import check_password_hash
  is_valid = check_password_hash(hashed, "your_password")
  ```

---

## 🔑 JWT Authentication

### 2.1 What is a JWT?

* Compact, URL-safe token with:

  * **Header**: Algorithm/type.
  * **Payload**: Data like user ID/roles.
  * **Signature**: Token integrity verification.

### 2.2 Generate & Verify JWTs (with `PyJWT`)

* **Install PyJWT**:

  ```
  pip install PyJWT
  ```

* **Generate Token**:

  ```python
  import jwt, datetime
  SECRET_KEY = "your_secret_key"

  def generate_token(user_id, role):
      payload = {
          "user_id": user_id,
          "role": role,
          "exp": datetime.datetime.utcnow() + datetime.timedelta(hours=1)
      }
      return jwt.encode(payload, SECRET_KEY, algorithm="HS256")
  ```

* **Verify Token Middleware**:

  ```python
  from flask import request, jsonify
  def token_required(f):
      def wrapper(*args, **kwargs):
          token = request.headers.get('Authorization')
          if not token:
              return jsonify({"error": "Token is missing"}), 401
          try:
              data = jwt.decode(token, SECRET_KEY, algorithms=["HS256"])
          except jwt.ExpiredSignatureError:
              return jsonify({"error": "Token has expired"}), 401
          except jwt.InvalidTokenError:
              return jsonify({"error": "Invalid token"}), 401
          return f(*args, **kwargs, user_data=data)
      return wrapper
  ```

---

## 🧑‍💼 Role-Based Access Control (RBAC)

### 3.1 Role Handling in JWT

Example payload:

```json
{
  "user_id": 123,
  "role": "admin",
  "exp": 1700000000
}
```

### 3.2 Restrict Access by Role

Within routes:

```python
@token_required
def admin_only_route(user_data):
    if user_data["role"] != "admin":
        return jsonify({"error": "Access denied"}), 403
    return jsonify({"message": "Welcome, Admin!"})
```

---

## 🔄 Token Management

### 4.1 Expiration & Refresh

* Tokens expire after a set time (e.g., 1 hour).
* You can create a `/refresh-token` endpoint to issue new tokens.

---

## 🧪 Error Handling & Testing

### 5.1 Handle Errors Gracefully

* Missing Token → `401 Unauthorized`
* Expired Token → `401 Token Expired`
* Invalid Token → `401 Invalid Token`
* Unauthorized Role → `403 Forbidden`

---

## Assignment 19: Implement JWT Authentication

### 🎯 Objective

Secure backend APIs with JWT-based authentication for test takers and admins.

### 📌 Requirements

* ✅ `/login` endpoint for user authentication and token generation.
* ✅ Middleware for token validation.
* ✅ RBAC using `role` from JWT.
* ✅ Token expiration + refresh mechanism.
* ✅ Error responses for invalid/missing tokens.

### 📁 Deliverables

1. `/login` API implementation.
2. Token middleware (`token_required`).
3. Role-based route control.
4. Sample API calls demonstrating:

   * Valid access
   * Invalid token
   * Role restrictions

### 🔍 Testing Checklist

* [x] Successful login returns token
* [x] Protected route access with valid token
* [x] Access denied with missing/expired/invalid token
* [x] Role-restricted access works

---

## 🧠 Best Practices

### Backend

* ✅ Use strong secret keys.
* ✅ Hash all passwords before storing.
* ✅ Short token expiration (1 hour recommended).

### Frontend

* ✅ Store JWTs in `sessionStorage` or `HttpOnly` cookies.
* ✅ Use `Authorization: Bearer <token>` header.
* ✅ Decode JWT to manage UI/route access by role.

---

## 📂 Token Example

```json
{
  "user_id": 456,
  "role": "test_taker",
  "exp": 1700000000
}
```

---


