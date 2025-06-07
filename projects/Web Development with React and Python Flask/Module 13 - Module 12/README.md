# 🚀 Module 12: Deployment Basics

**IELTS Speaking Test Platform – Production Deployment Guide**

---

## 🎯 Objective

This module guides you through deploying the **Flask backend** and **React frontend** of the IELTS Speaking Test platform. It ensures your application runs in a stable, secure, and scalable production environment accessible to real users.

---

## 📦 1. Backend Deployment (Flask)

---

### 🔧 1.1 Configuring Flask for Deployment

#### 1.1.1 Preparing Flask App for Production

✅ **Switch to Production Mode**

* Disable Flask debugger
* Set environment to `production`
* Use Gunicorn as the WSGI server

**Sample `wsgi.py`:**

```python
from app import app

if __name__ == "__main__":
    app.run()
```

**Install Gunicorn:**

```bash
pip install gunicorn
```

---

#### 1.1.2 Setting Up Environment Variables

✅ **Why?** Securely store credentials and keys

**Step 1: Create a `.env` file**

```env
FLASK_APP=wsgi.py
FLASK_ENV=production
SECRET_KEY=your_secret_key
DATABASE_URL=mysql+pymysql://user:password@host/db_name
```

**Step 2: Install dotenv loader**

```bash
pip install python-dotenv
```

**Step 3: Load variables in `config.py`**

```python
from dotenv import load_dotenv
import os

load_dotenv()

SECRET_KEY = os.getenv("SECRET_KEY")
DATABASE_URL = os.getenv("DATABASE_URL")
```

---

### ☁️ 1.2 Deploying on AWS Elastic Beanstalk

#### ✅ Steps to Deploy:

1. **Install EB CLI:**

   ```bash
   pip install awsebcli
   ```

2. **Initialize App:**

   ```bash
   eb init
   ```

3. **Create Deployment Files:**

   * `requirements.txt`
   * `.ebextensions/` for environment config

4. **Deploy to AWS:**

   ```bash
   eb create flask-env
   eb open
   ```

---

### 🌐 1.3 Deploying on Heroku

#### ✅ Steps to Deploy:

1. **Install Heroku CLI:**

   ```bash
   brew tap heroku/brew && brew install heroku
   ```

2. **Create a `Procfile`:**

   ```
   web: gunicorn wsgi:app
   ```

3. **Deploy:**

   ```bash
   heroku login
   heroku create your-app-name
   git push heroku main
   ```

4. **Set Env Variables:**

   ```bash
   heroku config:set SECRET_KEY=your_secret_key
   ```

---

## 🎨 2. Frontend Deployment (React)

---

### ⚙️ 2.1 Preparing the React App

✅ **Build the React App**

```bash
npm run build
```

➡️ Output located in the `build/` directory

---

### 🌍 2.2 Hosting on Vercel

#### ✅ Steps to Deploy:

1. **Set Up Vercel**

   * Sign in to [https://vercel.com](https://vercel.com)
   * Link GitHub repo

2. **Deploy**

   * Choose project and select `build` as output folder

3. **Set Environment Variables**

   * Add API base URL or other secrets in project settings

4. **Get Public Link**

   * Vercel provides a live deployment URL

---

## ✅ Best Practices for Deployment

---

### 🔍 1. Testing Before Deployment

```bash
FLASK_ENV=production flask run
```

Test in a simulated production environment

---

### 🔐 2. Secure the Application

* Enforce HTTPS
* Regularly update dependencies
* Use `.env` for sensitive info

---

### 📊 3. Monitoring and Logging

* **AWS**: Use CloudWatch
* **Heroku**: Use `heroku logs --tail`
* Set alerts for crashes or slowdowns

---

### ⚡ 4. Optimize Performance

* React: Minify assets via build
* Use CDNs for static file delivery
* Enable caching headers

---

## 📁 Deliverables

| Item                        | Description                                   |
| --------------------------- | --------------------------------------------- |
| `wsgi.py`                   | WSGI entry point for Flask                    |
| `.env`                      | Environment variable file (excluded from Git) |
| `Procfile`                  | For Heroku deployment                         |
| `build/`                    | Production-ready React frontend               |
| `requirements.txt`          | Python dependencies                           |
| `.ebextensions/` (optional) | AWS EB environment config                     |

---

## 📈 Deployment Overview Diagram

```txt
[Local Dev] → [GitHub] → [AWS EB (Flask API)]  
                     ↘  
                    [Vercel (React Frontend)]  
```

---

> 📌 **Tip:** Test both local and deployed versions regularly and monitor logs after deployment to catch runtime issues early.


