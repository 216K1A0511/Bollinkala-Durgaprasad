# Assignment 20: Add Role-Based Access Control (RBAC)

**Module: Security and Role Management**
**IELTS Speaking Test Platform**

---

## 🎯 Objective

Implement **role-based access control (RBAC)** at both the **backend (API)** and **frontend (React UI)** to ensure that users only access features relevant to their roles:

* **Admins** can manage tests, users, and view reports.
* **Test Takers** can take tests, view results, and access personal data.

---

## 🛠 Features Implemented

### ✅ Backend (Flask)

* Role embedded in JWT payload.
* Middleware that verifies role access per endpoint.
* Graceful error responses for unauthorized access.

### ✅ Frontend (React)

* Role-specific dashboards (`AdminDashboard`, `TestTakerDashboard`).
* Dynamic navigation menus.
* Protected routes based on user role.

---

## 📦 JWT Payload Structure

```json
{
  "user_id": 101,
  "role": "admin", // or "test_taker"
  "exp": 1700000000
}
```

---

## 🔐 Backend Implementation

### 1. Middleware for Role Enforcement

```python
from flask import request, jsonify
import jwt

SECRET_KEY = "your_secret_key"

def role_required(required_role):
    def decorator(f):
        def wrapper(*args, **kwargs):
            token = request.headers.get('Authorization')
            if not token:
                return jsonify({"error": "Token is missing"}), 401
            try:
                data = jwt.decode(token, SECRET_KEY, algorithms=["HS256"])
                if data['role'] != required_role:
                    return jsonify({"error": "Unauthorized role"}), 403
            except jwt.ExpiredSignatureError:
                return jsonify({"error": "Token expired"}), 401
            except jwt.InvalidTokenError:
                return jsonify({"error": "Invalid token"}), 401
            return f(*args, **kwargs)
        return wrapper
    return decorator
```

### 2. Sample Protected Endpoint

```python
@app.route('/admin/manage-tests')
@role_required('admin')
def manage_tests():
    return jsonify({"message": "Admin can manage tests"})
```

---

## 🖥️ Frontend (React) Implementation

### 1. Dynamic Dashboard Rendering

```tsx
const Dashboard: React.FC<{ role: string }> = ({ role }) => {
  return (
    <div>
      {role === 'admin' ? <AdminDashboard /> : <TestTakerDashboard />}
    </div>
  );
};
```

### 2. Navigation Menu by Role

```tsx
const Navigation: React.FC<{ role: string }> = ({ role }) => (
  <nav>
    {role === 'admin' && <a href="/admin-dashboard">Admin Dashboard</a>}
    {role === 'test_taker' && <a href="/test-taker-dashboard">Test Taker Dashboard</a>}
  </nav>
);
```

### 3. Route Protection Example

```tsx
import { Navigate } from 'react-router-dom';

const ProtectedRoute = ({ role, allowedRole, children }) => {
  return role === allowedRole ? children : <Navigate to="/unauthorized" />;
};
```

---

## 🚨 Error Handling

### API-Level

* Returns `401` for missing/invalid/expired tokens.
* Returns `403` for unauthorized role.

### Frontend

* Displays user-friendly alert: *"Access Denied. You are not authorized to view this page."*
* Redirects unauthorized users to `/unauthorized`.

---

## 🔍 Testing Instructions

### 1. API Tests

* ✅ Login as admin and test `/admin/*` routes (should pass).
* ❌ Login as test taker and access admin routes (should return 403).
* ❌ Send request with expired/invalid token (should return 401).

### 2. Frontend Tests

* ✅ Login as admin → See admin UI only.
* ✅ Login as test taker → See test taker UI only.
* ❌ Directly navigate to `/admin-dashboard` as test taker (should redirect/block).
* ❌ Login with no role in token → Redirect to login with error.

### 3. Edge Cases

* Missing role in token → Denied access.
* Expired token → Error: "Token expired".
* Tampered token → Error: "Invalid token".

---

## ✅ Deliverables

| File/Folder                     | Description                        |
| ------------------------------- | ---------------------------------- |
| `auth_middleware.py`            | Role-based middleware              |
| `routes/admin.py`               | Protected admin APIs               |
| `routes/test_taker.py`          | Protected test taker APIs          |
| `src/components/Dashboard.tsx`  | Role-based rendering in React      |
| `src/components/Navigation.tsx` | Dynamic role-based navigation      |
| `src/pages/Unauthorized.tsx`    | Error page for unauthorized access |
| `testcases.http`                | Manual API test cases with roles   |

---

## 📈 Evaluation Checklist

| Criteria                 | Weight | Status |
| ------------------------ | ------ | ------ |
| Role-Based API Access    | 40%    | ✅      |
| Frontend Role Management | 30%    | ✅      |
| Error Handling           | 20%    | ✅      |
| Submission Completeness  | 10%    | ✅      |

---

## 🧠 Best Practices

* Use `HttpOnly` cookies or `sessionStorage` for storing JWTs securely.
* Always validate role in **both backend** and **frontend**.
* Avoid hardcoding roles — consider storing them in DB with user profiles.
