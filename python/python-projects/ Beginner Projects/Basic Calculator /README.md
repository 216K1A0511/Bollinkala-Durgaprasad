

# 🧮 Web Calculator

A simple, stylish **web-based calculator** built using **Python Flask**!  
This calculator supports **basic operations**, **decimal inputs**, **memory functions** (`M+`, `M-`, `MR`), and **keeps a history** of your recent calculations.

---

## 🚀 Features
- Addition, Subtraction, Multiplication, Division
- Decimal point support
- Memory Add (`M+`), Memory Subtract (`M-`), Memory Recall (`MR`)
- Calculation history (latest 10 operations)
- Simple, clean, responsive UI
- Clear (`C`) button
- Error handling (e.g., division by zero)
- State management via Flask routes and JSON API

---

## 🛠️ Built With
- **Python 3**
- **Flask** (Web Framework)
- **HTML5/CSS3/JavaScript** (Frontend)

---

## 📦 Installation

1. **Clone this repository:**

```bash
git clone https://github.com/216K1A0511/calculator.git
cd calculator
```

2. **Create a virtual environment (optional but recommended):**

```bash
python -m venv venv
source venv/bin/activate   # On Windows use: venv\Scripts\activate
```

3. **Install required packages:**

```bash
pip install flask
```

---

## ▶️ Running the App

Run the following command:

```bash
python app.py
```

The application will start locally at:

```
http://127.0.0.1:5000/
```

Open your browser and start calculating!

---

## 🖥️ Usage

- Click the **number buttons** and **operator buttons** to build your calculation.
- Press `=` to get the result.
- Use `M+`, `M-`, `MR` for memory operations.
- Press `C` to clear the display.
- Scroll down to see the **recent calculation history**.

---



## 📂 Project Structure
```
├── app.py             # Main Flask Application
├── README.md          # Project Documentation
```
_All HTML/CSS/JS is rendered dynamically using `render_template_string`._

---

## 🔥 Future Enhancements
- Add percentage (%) and square root (√) functions
- Add keyboard input support
- Deploy the app online (e.g., using Render, Vercel, or Heroku)

