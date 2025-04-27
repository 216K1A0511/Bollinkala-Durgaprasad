# Typing Speed Test App

This is a simple **Typing Speed Test** web application built using **Flask** for the backend and **HTML/CSS/JavaScript** for the frontend.  
It measures **Words Per Minute (WPM)**, **Characters Per Minute (CPM)**, and **Accuracy** while displaying previous test history.

---

## Features

- Random typing texts.
- Real-time input highlighting (correct/incorrect).
- Timer display while typing.
- WPM, CPM, and Accuracy calculation.
- Saves and displays history of previous tests during the session.
- Restart test functionality.

---

## Setup Instructions

### 1. Clone the repository

```bash
git clone https://github.com/216K1A0511/typing-speed-test.git
cd typing-speed-test
```

*(Or simply create a Python file and paste the code you shared.)*

---

### 2. Install the dependencies

```bash
pip install Flask
```

---

### 3. Run the application

```bash
python app.py
```

It will start the server on `http://127.0.0.1:5000/`.

---



> **Note:** The project uses **inline HTML, CSS, and JavaScript** inside the Flask route.

---

## API Endpoints

| Method | Endpoint      | Description                           |
|:------:|:--------------:|:-------------------------------------:|
| GET    | `/`            | Renders the main typing test page.    |
| GET    | `/start_test`  | Starts a new typing test with random text. |
| POST   | `/end_test`    | Ends the current test and calculates the results. |

---

## Screenshots

- **Landing page with Start button**
- **Typing area with real-time highlighting**
- **Results after completing typing**
- **History of previous typing sessions**

*(Add screenshots if needed.)*

---

## Requirements

- Python 3.x
- Flask

---

## To-Do (Enhancements)

- Persistent history saving (using a database or local storage).
- Leaderboard with top scores.
- User login and profile system.
- Dark mode theme.
- Mobile responsiveness improvements.

---

## Credits

Created by [DP].
