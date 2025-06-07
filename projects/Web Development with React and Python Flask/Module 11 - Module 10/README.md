# 📦 Module 10: Security and Authentication

This module implements secure backend authentication and robust frontend authorization for the **IELTS Speaking Test Platform**. It includes password hashing using `werkzeug.security`, JSON Web Token (JWT) handling for user sessions, and role-based access control (RBAC) on both backend and frontend.

---

## 🔐 Backend Security

### 1. Password Hashing with `werkzeug.security`

#### 📌 Why Use Hashing?

* Protects user credentials if the database is compromised.
* Converts plain text into an irreversible format.
* Thwarts rainbow table and dictionary attacks with salted hashes.

#### ✅ Hashing & Verifying Passwords

```python
from werkzeug.security import generate_password_hash, check_password_hash

# Hashing
hashed_password = generate_password_hash("securepassword123")

# Verifying
is_valid = check_password_hash(hashed_password, "securepassword123")
```

### 2. Token-Based Authentication using JWT

#### 🧾 What is JWT?

* A compact, URL-safe token used to transmit user data securely.
* Contains: Header, Payload (user\_id, role), and Signature.

#### ⚙️ Setup with PyJWT

```bash
pip install PyJWT
```

##### 🔑 Generate JWT

```python
import jwt, datetime

SECRET_KEY = "your_secret_key"

def generate_token(user_id):
    payload = {
        "user_id": user_id,
        "role": "admin",  # example role
        "exp": datetime.datetime.utcnow() + datetime.timedelta(hours=1)
    }
    return jwt.encode(payload, SECRET_KEY, algorithm="HS256")
```

##### 🔍 Verify JWT

```python
def verify_token(token):
    try:
        return jwt.decode(token, SECRET_KEY, algorithms=["HS256"])
    except jwt.ExpiredSignatureError:
        return "Token has expired"
    except jwt.InvalidTokenError:
        return "Invalid token"
```

---

## 🛡️ Securing API Endpoints

```python
from flask import request, jsonify

@app.route("/api/protected-route", methods=["GET"])
def protected_route():
    auth_header = request.headers.get("Authorization")
    if not auth_header:
        return jsonify({"error": "Authorization header missing"}), 401

    token = auth_header.split(" ")[1]
    payload = verify_token(token)
    if isinstance(payload, str):
        return jsonify({"error": payload}), 401

    return jsonify({"message": "Welcome to the protected route!"})
```

---

## 🔓 Frontend Authorization (React)

### 1. Protecting Routes

```tsx
// ProtectedRoute.tsx
import { Navigate, Outlet } from "react-router-dom";

const ProtectedRoute: React.FC = () => {
  const token = localStorage.getItem("token");
  return token ? <Outlet /> : <Navigate to="/login" />;
};
```

### 2. Role-Based Access Control (RBAC)

#### 🔍 Parse and Use JWT

```tsx
const parseJwt = (token: string) => {
  const base64Url = token.split(".")[1];
  const base64 = base64Url.replace(/-/g, "+").replace(/_/g, "/");
  const jsonPayload = decodeURIComponent(
    atob(base64)
      .split("")
      .map(c => "%" + ("00" + c.charCodeAt(0).toString(16)).slice(-2))
      .join("")
  );
  return JSON.parse(jsonPayload);
};
```

#### 🔐 Role-Protected Routes

```tsx
const RoleProtectedRoute: React.FC<{ allowedRoles: string[] }> = ({ allowedRoles }) => {
  const token = localStorage.getItem("token");
  const role = token ? parseJwt(token).role : null;
  return allowedRoles.includes(role) ? <Outlet /> : <Navigate to="/unauthorized" />;
};
```

```tsx
<Routes>
  <Route path="/admin" element={<RoleProtectedRoute allowedRoles={["admin"]} />}>
    <Route index element={<AdminDashboard />} />
  </Route>
  <Route path="/test-taker" element={<RoleProtectedRoute allowedRoles={["test_taker"]} />}>
    <Route index element={<TestTakerDashboard />} />
  </Route>
</Routes>
```

---

## 🧠 Best Practices

### Backend

* Always hash passwords before storing.
* Use secure, random `SECRET_KEY` for JWT.
* Set short token expiry and handle refresh securely.

### Frontend

* Avoid exposing tokens in the console.
* Use `sessionStorage` for better security or HttpOnly cookies for sensitive data.
* Implement granular roles and restrict features accordingly.

---

## 📁 Deliverables

* Flask backend with:

  * Secure password storage
  * JWT authentication
  * Role-based route protection
* React frontend with:

  * Protected routes
  * Role-based UI and routing
* Token validation and secure storage mechanisms

---

## ✅ Summary

This module ensures the IELTS Speaking Test Platform is **secure, scalable, and role-aware**, using industry best practices for authentication and authorization.

---

