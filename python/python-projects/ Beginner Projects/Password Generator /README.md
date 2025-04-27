# 🔐 Password Generator

This project is a simple yet powerful **Password Generator** built with **Flask** and **Python**.  
It allows users to customize the password length and character set, and displays the last 10 generated passwords.

---

## 🚀 Features

- Generate random passwords based on user preferences.
- Options to include:
  - Uppercase letters (A-Z)
  - Lowercase letters (a-z)
  - Digits (0-9)
  - Special characters (`!@#$%^&*()_+-=[]{}|;:,.<>?`)
  - Exclude similar-looking characters (like `l`, `1`, `I`, `0`, `O`)
- Copy generated password to clipboard with a button click.
- View history of the last 10 generated passwords.
- Clean and responsive UI with basic CSS styling.

---

## 🛠️ Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/216K1A0511/password-generator.git
   cd flask-password-generator
   ```

2. **Create a virtual environment (optional but recommended):**
   ```bash
   python -m venv venv
   source venv/bin/activate   # On Windows: venv\Scripts\activate
   ```

3. **Install the required packages:**
   ```bash
   pip install Flask
   ```

---

## ⚙️ How to Run

Simply run the Flask app:

```bash
python app.py
```

By default, the application will be available at:

```
http://127.0.0.1:5000/
```

---

## 📷 Screenshots

| Home Page | Generated Password Example |
| :---: | :---: |
| ![Home Page](screenshot_home.png) | ![Password Generated](screenshot_generated.png) |

*(You can add screenshots if you want!)*

---

## 🧩 Project Structure

```
flask-password-generator/
│
├── app.py         # Main Flask application
├── README.md      # Project README
├── requirements.txt (optional) # To list dependencies
```

---

## 📚 Requirements

- Python 3.7+
- Flask

(Install Flask with `pip install Flask`)

---

## 🎯 Future Improvements

- Add password strength meter.
- Allow saving passwords to a file.
- Add dark/light theme toggle.
- Mobile responsiveness enhancements.


