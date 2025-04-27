from flask import Flask, render_template_string, request
from datetime import datetime
import pytz
import threading

app = Flask(__name__)

class DigitalClock:
    def __init__(self):
        self.timezone = 'UTC'
        self.format_24h = True
        self.show_seconds = True
        self.show_date = True
        self.current_time = datetime.now(pytz.timezone(self.timezone))
        self.update_time()
        
    def update_time(self):
        self.current_time = datetime.now(pytz.timezone(self.timezone))
        threading.Timer(1.0, self.update_time).start()
    
    def get_formatted_time(self):
        if self.format_24h:
            format_str = '%H:%M' + (':%S' if self.show_seconds else '')
        else:
            format_str = '%I:%M' + (':%S' if self.show_seconds else '') + ' %p'
        return self.current_time.strftime(format_str)
    
    def get_formatted_date(self):
        return self.current_time.strftime('%A, %B %d, %Y')

# Initialize the clock instance
clock = DigitalClock()

@app.route('/')
def index():
    return render_template_string('''
<!DOCTYPE html>
<html>
<head>
    <title>Digital Clock</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background: #121212;
            color: #ffffff;
            transition: all 0.3s;
        }
        .clock-container {
            text-align: center;
        }
        .time {
            font-size: 5rem;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 0;
        }
        .date {
            font-size: 1.5rem;
            opacity: 0.8;
            margin-top: 10px;
        }
        .controls {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }
        button, select {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background: #333;
            color: white;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background: #444;
        }
        .format-btn {
            background: #4CAF50;
        }
        .format-btn.active {
            background: #2E7D32;
        }
        .theme-btn {
            background: #2196F3;
        }
        .theme-dark {
            background: #121212;
            color: #ffffff;
        }
        .theme-light {
            background: #f5f5f5;
            color: #333333;
        }
    </style>
</head>
<body class="theme-dark">
    <div class="clock-container">
        <div class="time" id="time-display">{{ time }}</div>
        {% if clock.show_date %}
        <div class="date" id="date-display">{{ date }}</div>
        {% endif %}
    </div>
    
    <div class="controls">
        <select id="timezone-select" onchange="changeTimezone(this.value)">
            <option value="UTC">UTC</option>
            <option value="America/New_York">New York</option>
            <option value="Europe/London">London</option>
            <option value="Asia/Tokyo">Tokyo</option>
            <option value="Australia/Sydney">Sydney</option>
        </select>
        
        <button id="24h-btn" class="format-btn {{ 'active' if clock.format_24h }}" 
                onclick="toggleTimeFormat()">24-hour</button>
        <button id="seconds-btn" class="format-btn {{ 'active' if clock.show_seconds }}" 
                onclick="toggleSeconds()">Seconds</button>
        <button id="date-btn" class="format-btn {{ 'active' if clock.show_date }}" 
                onclick="toggleDate()">Date</button>
        <button class="theme-btn" onclick="toggleTheme()">Toggle Theme</button>
    </div>

    <script>
        document.getElementById('timezone-select').value = "{{ clock.timezone }}";
        
        function updateClock() {
            fetch('/get_time')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('time-display').textContent = data.time;
                    const dateDisplay = document.getElementById('date-display');
                    if (data.date) {
                        if (!dateDisplay) {
                            const timeDisplay = document.getElementById('time-display');
                            const newDateDisplay = document.createElement('div');
                            newDateDisplay.className = 'date';
                            newDateDisplay.id = 'date-display';
                            timeDisplay.insertAdjacentElement('afterend', newDateDisplay);
                        }
                        document.getElementById('date-display').textContent = data.date;
                    } else if (dateDisplay) {
                        dateDisplay.remove();
                    }
                });
            setTimeout(updateClock, 1000);
        }
        
        function changeTimezone(timezone) {
            fetch('/set_timezone?timezone=' + timezone).then(updateClock);
        }
        
        function toggleTimeFormat() {
            fetch('/toggle_time_format').then(() => {
                document.getElementById('24h-btn').classList.toggle('active');
                updateClock();
            });
        }
        
        function toggleSeconds() {
            fetch('/toggle_seconds').then(() => {
                document.getElementById('seconds-btn').classList.toggle('active');
                updateClock();
            });
        }
        
        function toggleDate() {
            fetch('/toggle_date').then(() => {
                document.getElementById('date-btn').classList.toggle('active');
                updateClock();
            });
        }
        
        function toggleTheme() {
            document.body.classList.toggle('theme-dark');
            document.body.classList.toggle('theme-light');
        }
        
        updateClock();
    </script>
</body>
</html>
    ''', clock=clock, 
       time=clock.get_formatted_time(), 
       date=clock.get_formatted_date())

@app.route('/get_time')
def get_time():
    return {
        'time': clock.get_formatted_time(),
        'date': clock.get_formatted_date() if clock.show_date else None
    }

@app.route('/set_timezone')
def set_timezone():
    timezone = request.args.get('timezone', 'UTC')
    if timezone in pytz.all_timezones:
        clock.timezone = timezone
    return 'OK'

@app.route('/toggle_time_format')
def toggle_time_format():
    clock.format_24h = not clock.format_24h
    return 'OK'

@app.route('/toggle_seconds')
def toggle_seconds():
    clock.show_seconds = not clock.show_seconds
    return 'OK'

@app.route('/toggle_date')
def toggle_date():
    clock.show_date = not clock.show_date
    return 'OK'

if __name__ == '__main__':
    app.run(debug=True)
