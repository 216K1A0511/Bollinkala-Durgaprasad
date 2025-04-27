# 🎲 Dice Roller - Flask Web App

A simple and interactive dice roller built using **Flask** (Python backend) and **HTML/CSS/JavaScript** (frontend).  
Users can choose different types of dice (e.g., 1d6, 2d6, 1d20) or create custom dice combinations and roll them with animated effects!

---

## 🚀 How It Works

### Backend (Python + Flask)
- **Flask** server handles two main routes:
  - `/` → Serves the **HTML page** with embedded JavaScript.
  - `/roll` → API endpoint that **returns dice roll results** as JSON.
- **DiceRoller Class**:
  - Handles rolling logic.
  - Stores the **last 10 rolls** in a history list (with timestamp, dice type, roll results, and total).
  - Supports rolling multiple dice with a custom number of sides.

```python
class DiceRoller:
    def roll(self, num_dice=1, sides=6):
        results = [random.randint(1, sides) for _ in range(num_dice)]
        total = sum(results)
        ...
```

---

### Frontend (HTML + CSS + JavaScript)
- **Dynamic Dice Display**: Animates rolling dice, then shows the final results.
- **Controls**:
  - Dropdown to select dice type (e.g., 1d4, 2d6, 1d20).
  - Custom option to input number of dice and sides manually.
- **History Panel**:
  - Displays the last 10 rolls with their results and total.
- **Animations**:
  - Dice "shake" effect while rolling.

```javascript
function rollDice() {
    // Fetch roll results from /roll API and update display
}
```

---

## 📂 Project Structure

```
├── app.py         # Main Flask server
└── (HTML embedded inside app.py)
```

---

## 🛠️ How to Run Locally

1. Make sure you have **Python** installed (3.x recommended).

2. Install Flask:
   ```bash
   pip install flask
   ```

3. Run the app:
   ```bash
   python app.py
   ```

4. Open your browser and visit:  
   `http://127.0.0.1:5000/`

---

## ✨ Features

- 🎲 Roll different standard dice (d4, d6, d8, d10, d12, d20).
- 🎲 Roll multiple dice at once.
- ✍️ Create custom dice (up to 10 dice, max 100 sides).
- 🕑 Track roll history (last 10 rolls).
- 💫 Rolling animation for better user experience.
- 🎨 Clean and responsive UI with simple styling.

---

## 🔥 Example Screenshots

*(Optional section: you can add screenshots if you want)*

---

## 📜 Notes

- The server simulates a slight delay (`0.5s`) to make the rolling feel more natural.
- History is **not persistent** across server restarts.

---

## 📧 Contact

If you have any questions, feel free to reach out!

---
