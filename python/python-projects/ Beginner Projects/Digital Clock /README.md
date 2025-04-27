# 🕒 Digital Clock Web App

This project is a **real-time digital clock** built using **Flask** and **JavaScript**.  
It displays the current time and date, lets users **change the timezone**, **toggle 24-hour/12-hour formats**, **show/hide seconds**, **show/hide the date**, and **switch between dark and light themes**.

## 🚀 Features

- ⏰ Real-time time updates (every second)
- 🌎 Change timezone (e.g., UTC, New York, London, Tokyo, Sydney)
- 🌓 Toggle between 24-hour and 12-hour formats
- 🎯 Show or hide seconds
- 📅 Show or hide the current date
- 🎨 Switch between **Dark Mode** and **Light Mode**
- 📜 Responsive and stylish design

## 🛠 Technologies Used

- **Backend**: Flask (Python)
- **Frontend**: HTML, CSS, JavaScript (fetch API)
- **Other Libraries**: `pytz` for timezone management

## 🧠 How It Works

- A `DigitalClock` Python class manages the time updates.
- The time updates every second using a **background thread** (`threading.Timer`).
- Frontend fetches the latest time from the `/get_time` endpoint every second.
- Users can interact with the clock via buttons and dropdowns, which trigger small API requests (`/toggle_time_format`, `/toggle_seconds`, etc.).

## 📂 Project Structure

```
- app.py    # Flask application with clock logic and routes
- README.md # Documentation
```

_No external HTML or JS files — everything is embedded directly for simplicity._

## 📦 Installation

1. **Clone** this repository:
   ```bash
   git clone https://github.com/216K1A0511/digital.git
   cd digital-clock-flask
   ```

2. **Install required packages**:
   ```bash
   pip install flask pytz
   ```

3. **Run the Flask app**:
   ```bash
   python app.py
   ```

4. **Visit in your browser**:
   ```
   http://127.0.0.1:5000/
   ```

---

## 📜 API Endpoints

| Route                  | Method | Description                             |
|-------------------------|--------|-----------------------------------------|
| `/`                     | GET    | Loads the clock interface               |
| `/get_time`             | GET    | Fetches current time and date (JSON)    |
| `/set_timezone?timezone=<timezone>` | GET | Sets the timezone                    |
| `/toggle_time_format`   | GET    | Toggles between 24h and 12h formats     |
| `/toggle_seconds`       | GET    | Shows or hides seconds                 |
| `/toggle_date`          | GET    | Shows or hides the date                |

---

## ✨ Screenshots

| Dark Theme | Light Theme |
|:----------:|:-----------:|
| ![Dark Theme](https://via.placeholder.com/300x200?text=Dark+Theme) | ![Light Theme](https://via.placeholder.com/300x200?text=Light+Theme) |

_(replace with real screenshots if needed)_

---

## ⚙️ Customization Ideas

- Add more timezone options.
- Save user settings in `localStorage`.
- Add sound effects on time ticks.
- Deploy it online using **Heroku**, **Vercel**, or **Render**.

---
