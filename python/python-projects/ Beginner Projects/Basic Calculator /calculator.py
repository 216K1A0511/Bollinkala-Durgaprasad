from flask import Flask, render_template_string, request, session
import json
from datetime import datetime

app = Flask(__name__)
app.secret_key = 'your_secret_key_here'

class Calculator:
    def __init__(self):
        self.display = "0"
        self.memory = 0
        self.history = []
        self.waiting_operand = None
        self.waiting_operation = None
    
    def input_digit(self, digit):
        if self.display == "0":
            self.display = digit
        else:
            self.display += digit
    
    def input_decimal(self):
        if "." not in self.display:
            self.display += "."
    
    def set_operation(self, op):
        self.waiting_operand = float(self.display)
        self.waiting_operation = op
        self.display = "0"
    
    def calculate(self):
        if self.waiting_operation and self.waiting_operand is not None:
            current = float(self.display)
            operation = self.waiting_operation
            result = None
            
            if operation == '+':
                result = self.waiting_operand + current
            elif operation == '-':
                result = self.waiting_operand - current
            elif operation == '*':
                result = self.waiting_operand * current
            elif operation == '/':
                result = self.waiting_operand / current if current != 0 else "Error"
            
            if result != "Error":
                self.add_history(f"{self.waiting_operand} {operation} {current} = {result}")
                self.display = str(result)
            else:
                self.add_history("Error: Division by zero")
                self.display = "Error"
            
            self.waiting_operation = None
            self.waiting_operand = None
    
    def clear(self):
        self.display = "0"
        self.waiting_operand = None
        self.waiting_operation = None
        self.add_history("Cleared")
    
    def memory_add(self):
        try:
            self.memory += float(self.display)
            self.add_history(f"M+ {self.display} = {self.memory}")
        except:
            self.add_history("Memory error")
    
    def memory_subtract(self):
        try:
            self.memory -= float(self.display)
            self.add_history(f"M- {self.display} = {self.memory}")
        except:
            self.add_history("Memory error")
    
    def memory_recall(self):
        self.display = str(self.memory)
        self.add_history(f"MR: {self.memory}")
    
    def add_history(self, event):
        self.history.insert(0, {
            'timestamp': datetime.now().strftime("%H:%M:%S"),
            'event': event
        })
        if len(self.history) > 10:
            self.history.pop()

calculator = Calculator()

@app.route('/')
def index():
    return render_template_string('''
<!DOCTYPE html>
<html>
<head>
    <title>Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
        }
        .calculator {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 20px;
        }
        .display {
            grid-column: span 4;
            height: 50px;
            font-size: 2em;
            text-align: right;
            padding: 5px;
            background: #f0f0f0;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }
        button {
            height: 50px;
            font-size: 1.2em;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }
        button.operator {
            background: #f0f0f0;
        }
        button.equals {
            background: #4CAF50;
            color: white;
        }
        button.clear {
            background: #f44336;
            color: white;
        }
        button.memory {
            background: #2196F3;
            color: white;
        }
        .history {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .history-entry {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="display" id="display">{{ calculator.display }}</div>
    
    <div class="calculator">
        <button onclick="inputDigit('7')">7</button>
        <button onclick="inputDigit('8')">8</button>
        <button onclick="inputDigit('9')">9</button>
        <button class="operator" onclick="setOperation('/')">/</button>
        
        <button onclick="inputDigit('4')">4</button>
        <button onclick="inputDigit('5')">5</button>
        <button onclick="inputDigit('6')">6</button>
        <button class="operator" onclick="setOperation('*')">×</button>
        
        <button onclick="inputDigit('1')">1</button>
        <button onclick="inputDigit('2')">2</button>
        <button onclick="inputDigit('3')">3</button>
        <button class="operator" onclick="setOperation('-')">-</button>
        
        <button onclick="inputDigit('0')">0</button>
        <button onclick="inputDecimal()">.</button>
        <button class="equals" onclick="calculate()">=</button>
        <button class="operator" onclick="setOperation('+')">+</button>
        
        <button class="clear" onclick="clearCalc()">C</button>
        <button class="memory" onclick="memoryAdd()">M+</button>
        <button class="memory" onclick="memorySubtract()">M-</button>
        <button class="memory" onclick="memoryRecall()">MR</button>
    </div>
    
    <div class="history" id="history">
        <h3>History</h3>
        {% for entry in calculator.history %}
            <div class="history-entry">[{{ entry.timestamp }}] {{ entry.event }}</div>
        {% endfor %}
    </div>

    <script>
        function updateDisplay() {
            fetch('/get_state')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('display').textContent = data.display;
                    const historyDiv = document.getElementById('history');
                    historyDiv.innerHTML = '<h3>History</h3>' + 
                        data.history.map(entry => 
                            `<div class="history-entry">[${entry.timestamp}] ${entry.event}</div>`
                        ).join('');
                });
        }
        
        function inputDigit(digit) {
            fetch('/input_digit?digit=' + digit)
                .then(updateDisplay);
        }
        
        function inputDecimal() {
            fetch('/input_decimal')
                .then(updateDisplay);
        }
        
        function setOperation(op) {
            fetch('/set_operation?op=' + op)
                .then(updateDisplay);
        }
        
        function calculate() {
            fetch('/calculate')
                .then(updateDisplay);
        }
        
        function clearCalc() {
            fetch('/clear')
                .then(updateDisplay);
        }
        
        function memoryAdd() {
            fetch('/memory_add')
                .then(updateDisplay);
        }
        
        function memorySubtract() {
            fetch('/memory_subtract')
                .then(updateDisplay);
        }
        
        function memoryRecall() {
            fetch('/memory_recall')
                .then(updateDisplay);
        }
    </script>
</body>
</html>
    ''', calculator=calculator)

@app.route('/input_digit')
def input_digit():
    digit = request.args.get('digit')
    calculator.input_digit(digit)
    return 'OK'

@app.route('/input_decimal')
def input_decimal():
    calculator.input_decimal()
    return 'OK'

@app.route('/set_operation')
def set_operation():
    op = request.args.get('op')
    calculator.set_operation(op)
    return 'OK'

@app.route('/calculate')
def perform_calculation():
    calculator.calculate()
    return 'OK'

@app.route('/clear')
def clear_calculator():
    calculator.clear()
    return 'OK'

@app.route('/memory_add')
def memory_add():
    calculator.memory_add()
    return 'OK'

@app.route('/memory_subtract')
def memory_subtract():
    calculator.memory_subtract()
    return 'OK'

@app.route('/memory_recall')
def memory_recall():
    calculator.memory_recall()
    return 'OK'

@app.route('/get_state')
def get_state():
    return {
        'display': calculator.display,
        'history': calculator.history
    }

if __name__ == '__main__':
    app.run(debug=True)
