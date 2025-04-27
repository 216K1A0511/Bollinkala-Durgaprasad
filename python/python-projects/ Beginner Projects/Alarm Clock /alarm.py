from flask import Flask, render_template_string, request
from datetime import datetime, timedelta
import threading
import time
import os
import urllib.request
import subprocess

app = Flask(__name__)

# Alarm state management
alarm_time = None
alarm_active = False
alarm_ringing = False

# Fixed path using raw string and proper path construction
alarm_sound = os.path.join(os.getcwd(), "static", "audio", "alarm_sound.mp3")

# Create directory structure
os.makedirs(os.path.dirname(alarm_sound), exist_ok=True)

# Download sample alarm sound with user-agent header
if not os.path.exists(alarm_sound):
    try:
        url = "https://assets.mixkit.co/sfx/preview/mixkit-alarm-digital-clock-beep-989.mp3"
        opener = urllib.request.build_opener()
        opener.addheaders = [('User-agent', 'Mozilla/5.0')]
        urllib.request.install_opener(opener)
        urllib.request.urlretrieve(url, alarm_sound)
        print("Downloaded sample alarm sound")
    except Exception as e:
        print(f"Error downloading sound: {e}")
        # Create empty file as fallback
        open(alarm_sound, 'a').close()

# HTML Template (must be defined before the index() function that uses it)
HTML = '''
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Alarm Clock</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        h1 {
            color: #2d3748;
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }

        .clock {
            font-size: 3rem;
            font-weight: 600;
            color: #4a5568;
            margin: 2rem 0;
            letter-spacing: 2px;
        }

        .alarm-controls {
            margin: 2rem 0;
        }

        input[type="time"] {
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            width: 100%;
            max-width: 250px;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        button {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, opacity 0.2s;
        }

        button:active {
            transform: scale(0.98);
        }

        .set-btn {
            background: #48bb78;
            color: white;
        }

        .stop-btn {
            background: #f56565;
            color: white;
        }

        .snooze-btn {
            background: #f6e05e;
            color: #2d3748;
        }

        button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .status {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 10px;
            background: #ebf8ff;
            color: #2b6cb0;
        }

        .alarm-ringing {
            animation: pulse 1s infinite;
            background-color: #fff3f3;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="container {% if alarm_ringing %}alarm-ringing{% endif %}">
        <h1>Digital Alarm Clock</h1>
        
        <div class="clock" id="live-clock">{{ current_time }}</div>
        
        <div class="alarm-controls">
            <form method="POST">
                <input type="time" 
                       id="alarm-time" 
                       name="alarm_time" 
                       step="1" 
                       value="{{ alarm_time_value }}"
                       required>
                
                <div class="button-group">
                    <button type="submit" 
                            name="action" 
                            value="set" 
                            class="set-btn"
                            {% if alarm_active %}disabled{% endif %}>
                        Set Alarm
                    </button>
                    
                    {% if alarm_active %}
                        <button type="submit" 
                                name="action" 
                                value="stop" 
                                class="stop-btn">
                            Stop
                        </button>
                        <button type="submit" 
                                name="action" 
                                value="snooze" 
                                class="snooze-btn">
                            Snooze (5m)
                        </button>
                    {% endif %}
                </div>
            </form>
        </div>

        {% if alarm_active %}
            <div class="status">
                ⏰ Alarm set for {{ alarm_time.strftime('%H:%M:%S') }}
            </div>
        {% elif message %}
            <div class="status">
                {{ message }}
            </div>
        {% endif %}
    </div>

    <script>
        // Real-time clock update
        function updateClock() {
            const options = { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                hour12: true 
            };
            document.getElementById('live-clock').textContent = 
                new Date().toLocaleTimeString('en-US', options);
        }
        setInterval(updateClock, 1000);
        updateClock();
        
        // Flash the tab title when alarm is ringing
        let originalTitle = document.title;
        function flashTitle() {
            document.title = document.title === originalTitle 
                ? "⏰ ALARM! ⏰" 
                : originalTitle;
        }
        
        // Check for alarm ringing every second
        setInterval(() => {
            fetch('/is_ringing')
                .then(response => response.json())
                .then(data => {
                    if (data.ringing) {
                        flashTitle();
                    } else {
                        document.title = originalTitle;
                    }
                });
        }, 1000);
    </script>
</body>
</html>
'''

def check_alarm():
    global alarm_ringing
    while True:
        if alarm_active and alarm_time:
            now = datetime.now()
            if now >= alarm_time and not alarm_ringing:
                alarm_ringing = True
                trigger_alarm()
        time.sleep(1)

def trigger_alarm():
    print("ALARM! WAKE UP!")
    try:
        if os.name == 'nt':
            subprocess.Popen(f'start "{alarm_sound}"', shell=True)
        else:
            subprocess.Popen(['xdg-open', alarm_sound])
    except Exception as e:
        print(f"Error playing sound: {e}")

def stop_alarm_sound():
    global alarm_ringing
    try:
        if os.name == 'nt':
            subprocess.Popen('taskkill /f /im wmplayer.exe', shell=True)
        else:
            subprocess.Popen(['pkill', 'afplay'])
    except Exception as e:
        print(f"Error stopping sound: {e}")
    alarm_ringing = False

# Start alarm thread
alarm_thread = threading.Thread(target=check_alarm, daemon=True)
alarm_thread.start()

@app.route('/', methods=['GET', 'POST'])
def index():
    global alarm_time, alarm_active, alarm_ringing
    
    message = None
    alarm_time_value = ""
    
    if request.method == 'POST':
        action = request.form.get('action')
        
        if action == 'set':
            time_str = request.form.get('alarm_time')
            if time_str:
                time_parts = time_str.split(':')
                hours = int(time_parts[0])
                minutes = int(time_parts[1])
                
                alarm_time = datetime.now().replace(
                    hour=hours, 
                    minute=minutes, 
                    second=0, 
                    microsecond=0
                )
                
                if alarm_time < datetime.now():
                    alarm_time += timedelta(days=1)
                
                alarm_active = True
                alarm_ringing = False
                alarm_time_value = f"{hours:02d}:{minutes:02d}"
                message = "Alarm set successfully!"
            else:
                message = "Please select a valid time!"
                
        elif action == 'stop':
            stop_alarm_sound()
            alarm_active = False
            alarm_ringing = False
            message = "Alarm stopped"
            
        elif action == 'snooze':
            stop_alarm_sound()
            alarm_time = datetime.now() + timedelta(minutes=5)
            alarm_active = True
            alarm_ringing = False
            alarm_time_value = alarm_time.strftime("%H:%M")
            message = f"Snoozed until {alarm_time.strftime('%H:%M:%S')}"
    
    current_time = datetime.now().strftime("%H:%M:%S")
    return render_template_string(
        HTML,
        current_time=current_time,
        alarm_time=alarm_time,
        alarm_active=alarm_active,
        alarm_ringing=alarm_ringing,
        message=message,
        alarm_time_value=alarm_time_value
    )

@app.route('/is_ringing')
def is_ringing():
    return {'ringing': alarm_ringing}

@app.route('/favicon.ico')
def favicon():
    return '', 404

if __name__ == '__main__':
    app.run(debug=True)
