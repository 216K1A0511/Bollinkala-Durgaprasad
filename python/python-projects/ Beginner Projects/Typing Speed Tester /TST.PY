from flask import Flask, render_template_string, request, jsonify
import time
from datetime import datetime

app = Flask(__name__)

class TypingTest:
    def __init__(self):
        self.sample_texts = [
            "The quick brown fox jumps over the lazy dog.",
            "Python is an interpreted, high-level, general-purpose programming language.",
            "Flask is a micro web framework written in Python.",
            "To be or not to be, that is the question.",
            "The greatest glory in living lies not in never falling, but in rising every time we fall."
        ]
        self.test_start_time = None
        self.test_end_time = None
        self.current_text = ""
        self.test_history = []

    def start_test(self):
        self.test_start_time = time.time()
        self.current_text = random.choice(self.sample_texts)
        return self.current_text

    def end_test(self, user_input):
        self.test_end_time = time.time()
        time_taken = self.test_end_time - self.test_start_time
        words = len(self.current_text.split())
        chars = len(self.current_text)
        
        # Calculate metrics
        wpm = (words / time_taken) * 60 if time_taken > 0 else 0
        cpm = (chars / time_taken) * 60 if time_taken > 0 else 0
        accuracy = self.calculate_accuracy(self.current_text, user_input)
        
        # Store results
        result = {
            'date': datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
            'wpm': round(wpm, 1),
            'cpm': round(cpm, 1),
            'accuracy': round(accuracy, 1),
            'text': self.current_text
        }
        self.test_history.append(result)
        
        return result

    def calculate_accuracy(self, original, typed):
        correct = 0
        min_length = min(len(original), len(typed))
        
        for i in range(min_length):
            if original[i] == typed[i]:
                correct += 1
                
        return (correct / len(original)) * 100 if original else 0

typing_test = TypingTest()

@app.route('/')
def index():
    return render_template_string('''
<!DOCTYPE html>
<html>
<head>
    <title>Typing Speed Test</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .test-area {
            margin: 20px 0;
        }
        .sample-text {
            font-size: 1.2rem;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 4px;
            margin-bottom: 15px;
            line-height: 1.6;
        }
        .user-input {
            width: 100%;
            height: 100px;
            padding: 10px;
            font-size: 1rem;
            border: 2px solid #ddd;
            border-radius: 4px;
            resize: none;
        }
        .timer {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
        }
        button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            display: block;
            margin: 0 auto;
        }
        button:hover {
            background: #45a049;
        }
        .results {
            margin-top: 30px;
            display: none;
        }
        .result-item {
            margin: 10px 0;
            padding: 10px;
            background: #e9f7ef;
            border-radius: 4px;
        }
        .history {
            margin-top: 30px;
        }
        .history-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .highlight {
            background: #ffeb3b;
        }
        .correct {
            color: #4CAF50;
        }
        .incorrect {
            color: #f44336;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Typing Speed Test</h1>
        
        <div class="test-area">
            <div class="timer" id="timer">00:00</div>
            
            <div class="sample-text" id="sample-text"></div>
            
            <textarea class="user-input" id="user-input" 
                      placeholder="Start typing here..." 
                      oninput="checkInput()" 
                      disabled></textarea>
            
            <button id="start-btn" onclick="startTest()">Start Test</button>
            <button id="restart-btn" onclick="restartTest()" style="display: none; background: #2196F3;">Restart</button>
        </div>
        
        <div class="results" id="results">
            <h2>Your Results</h2>
            <div class="result-item">Words per minute: <span id="wpm">0</span></div>
            <div class="result-item">Characters per minute: <span id="cpm">0</span></div>
            <div class="result-item">Accuracy: <span id="accuracy">0</span>%</div>
        </div>
        
        <div class="history" id="history">
            <h2>Previous Tests</h2>
            {% for test in typing_test.test_history %}
                <div class="history-item">
                    [{{ test.date }}] WPM: {{ test.wpm }} | CPM: {{ test.cpm }} | Accuracy: {{ test.accuracy }}%
                    <div style="font-size: 0.9rem; color: #666;">{{ test.text }}</div>
                </div>
            {% endfor %}
        </div>
    </div>

    <script>
        let startTime;
        let timerInterval;
        let currentText = "";
        
        function startTest() {
            fetch('/start_test')
                .then(response => response.json())
                .then(data => {
                    currentText = data.text;
                    document.getElementById('sample-text').innerHTML = highlightText(currentText, "");
                    document.getElementById('user-input').value = "";
                    document.getElementById('user-input').disabled = false;
                    document.getElementById('user-input').focus();
                    document.getElementById('start-btn').style.display = 'none';
                    document.getElementById('restart-btn').style.display = 'block';
                    document.getElementById('results').style.display = 'none';
                    
                    // Start timer
                    startTime = new Date();
                    timerInterval = setInterval(updateTimer, 1000);
                });
        }
        
        function restartTest() {
            clearInterval(timerInterval);
            document.getElementById('timer').textContent = "00:00";
            startTest();
        }
        
        function updateTimer() {
            const now = new Date();
            const elapsed = new Date(now - startTime);
            const minutes = elapsed.getMinutes().toString().padStart(2, '0');
            const seconds = elapsed.getSeconds().toString().padStart(2, '0');
            document.getElementById('timer').textContent = `${minutes}:${seconds}`;
        }
        
        function checkInput() {
            const userInput = document.getElementById('user-input').value;
            document.getElementById('sample-text').innerHTML = highlightText(currentText, userInput);
            
            // Check if test is complete
            if (userInput.length === currentText.length) {
                endTest();
            }
        }
        
        function highlightText(original, typed) {
            let highlighted = "";
            for (let i = 0; i < original.length; i++) {
                if (i < typed.length) {
                    const charClass = original[i] === typed[i] ? "correct" : "incorrect";
                    highlighted += `<span class="${charClass}">${original[i]}</span>`;
                } else if (i === typed.length) {
                    highlighted += `<span class="highlight">${original[i]}</span>`;
                } else {
                    highlighted += original[i];
                }
            }
            return highlighted;
        }
        
        function endTest() {
            clearInterval(timerInterval);
            document.getElementById('user-input').disabled = true;
            
            const userInput = document.getElementById('user-input').value;
            fetch('/end_test', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({text: userInput})
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('wpm').textContent = data.wpm;
                document.getElementById('cpm').textContent = data.cpm;
                document.getElementById('accuracy').textContent = data.accuracy;
                document.getElementById('results').style.display = 'block';
                
                // Update history
                const historyDiv = document.getElementById('history');
                const newEntry = document.createElement('div');
                newEntry.className = 'history-item';
                newEntry.innerHTML = `
                    [${data.date}] WPM: ${data.wpm} | CPM: ${data.cpm} | Accuracy: ${data.accuracy}%
                    <div style="font-size: 0.9rem; color: #666;">${data.text}</div>
                `;
                historyDiv.insertBefore(newEntry, historyDiv.children[1]);
            });
        }
    </script>
</body>
</html>
    ''', typing_test=typing_test)

@app.route('/start_test')
def start_test():
    sample_text = typing_test.start_test()
    return jsonify({'text': sample_text})

@app.route('/end_test', methods=['POST'])
def end_test():
    user_input = request.json.get('text', '')
    result = typing_test.end_test(user_input)
    return jsonify(result)

if __name__ == '__main__':
    import random  # Make sure to add this at the top of your file
    app.run(debug=True)
