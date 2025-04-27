
# 🕰️ Digital Alarm Clock (Flask App)

This project is a **modern web-based Alarm Clock** built using **Python Flask**, **HTML/CSS**, and **JavaScript**.  
It allows you to **set**, **stop**, and **snooze** alarms directly from your browser, complete with **audio notifications**, **animated UI**, and **real-time clock updates**.

---

## 🚀 Features
- ⏰ **Set Alarm** for a specific time.
- 🛑 **Stop Alarm** after it rings.
- 😴 **Snooze Alarm** (5-minute delay).
- 🎵 **Auto-play Alarm Sound** (MP3 download included).
- 🖥️ **Real-time Digital Clock** display.
- 🌈 **Modern and responsive UI** (styled with custom CSS).
- 🔔 **Tab flashing** when alarm is ringing.
- 🌙 **Automatic fallback** if alarm sound can't download.
- 🖱️ **Single-page interaction** without needing to refresh.

---

## 📂 Project Structure
```plaintext
/your_project_folder
│
├── app.py                # Main Flask application
├── README.md              # Project README (this file)
├── /static
│    └── /audio
│         └── alarm_sound.mp3   # Downloaded alarm sound file
```

---

## ⚙️ How to Run
1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/flask-alarm-clock.git
   cd flask-alarm-clock
   ```

2. **Install Requirements**
   > (Make sure you have Python 3 installed.)
   ```bash
   pip install Flask
   ```

3. **Run the App**
   ```bash
   python app.py
   ```

4. **Open in Browser**
   ```
   http://127.0.0.1:5000/
   ```

---

## 📷 Screenshots

| Home Screen             | Alarm Set             | Alarm Ringing          |
|:------------------------:|:---------------------:|:----------------------:|
| ![home](https://via.placeholder.com/250x400?text=Home) | ![set](https://via.placeholder.com/250x400?text=Set+Alarm) | ![ringing](https://via.placeholder.com/250x400?text=Alarm+Ringing) |

*(You can replace the placeholders with actual screenshots once you run the app!)*

---

## 🔥 Technical Details
- **Backend**: Python (Flask)
- **Frontend**: HTML5, CSS3 (Poppins font), Vanilla JavaScript
- **Threading**: Background thread constantly checks for alarm triggers
- **Audio Handling**:
  - Downloads a sample MP3 sound on first run
  - Plays sound using platform-specific commands (`start`, `xdg-open`, etc.)
  - Attempts to stop the alarm sound cleanly when requested

---

## 📋 TODOs / Future Enhancements
- ✅ Add multiple alarms
- ✅ Custom alarm sounds upload
- ✅ Persistent alarms (database or localStorage)
- ✅ Mobile app version
- ✅ "Math problem" alarm deactivation challenge

---

