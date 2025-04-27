from flask import Flask, render_template_string, request
import random
from datetime import datetime
import time

app = Flask(__name__)

class DiceRoller:
    def __init__(self):
        self.history = []
        
    def roll(self, num_dice=1, sides=6):
        results = [random.randint(1, sides) for _ in range(num_dice)]
        total = sum(results)
        
        roll_entry = {
            'timestamp': datetime.now().strftime("%H:%M:%S"),
            'dice': f"{num_dice}d{sides}",
            'results': results,
            'total': total
        }
        
        self.history.insert(0, roll_entry)
        if len(self.history) > 10:
            self.history.pop()
            
        return roll_entry

dice_roller = DiceRoller()

@app.route('/')
def index():
    return render_template_string('''
<!DOCTYPE html>
<html>
<head>
    <title>Dice Roller</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .dice-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
            min-height: 100px;
        }
        .dice {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .controls {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 1rem;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #45a049;
        }
        select, input {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .history {
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .history-entry {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .rolling {
            animation: shake 0.5s;
        }
        @keyframes shake {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(-10deg); }
            50% { transform: rotate(10deg); }
            75% { transform: rotate(-5deg); }
            100% { transform: rotate(0deg); }
        }
    </style>
</head>
<body>
    <h1>Dice Roller</h1>
    
    <div class="controls">
        <select id="dice-type">
            <option value="1d4">1d4</option>
            <option value="1d6" selected>1d6</option>
            <option value="1d8">1d8</option>
            <option value="1d10">1d10</option>
            <option value="1d12">1d12</option>
            <option value="1d20">1d20</option>
            <option value="2d6">2d6</option>
            <option value="3d6">3d6</option>
            <option value="custom">Custom</option>
        </select>
        
        <div id="custom-dice" style="display: none;">
            <input type="number" id="num-dice" min="1" max="10" value="1" style="width: 50px;">
            <span>d</span>
            <input type="number" id="num-sides" min="2" max="100" value="6" style="width: 50px;">
        </div>
        
        <button onclick="rollDice()">Roll Dice</button>
    </div>
    
    <div class="dice-container" id="dice-container">
        <!-- Dice will appear here -->
    </div>
    
    <div class="history" id="history">
        <h2>History</h2>
        {% for roll in dice_roller.history %}
            <div class="history-entry">
                [{{ roll.timestamp }}] {{ roll.dice }}: 
                {{ roll.results|join(', ') }} (Total: {{ roll.total }})
            </div>
        {% endfor %}
    </div>

    <script>
        const diceTypeSelect = document.getElementById('dice-type');
        const customDiceDiv = document.getElementById('custom-dice');
        
        diceTypeSelect.addEventListener('change', function() {
            customDiceDiv.style.display = this.value === 'custom' ? 'block' : 'none';
        });
        
        function rollDice() {
            const diceType = diceTypeSelect.value;
            let numDice = 1;
            let numSides = 6;
            
            if (diceType === 'custom') {
                numDice = parseInt(document.getElementById('num-dice').value);
                numSides = parseInt(document.getElementById('num-sides').value);
            } else {
                const parts = diceType.split('d');
                numDice = parseInt(parts[0]);
                numSides = parseInt(parts[1]);
            }
            
            // Show rolling animation
            const container = document.getElementById('dice-container');
            container.innerHTML = '';
            
            for (let i = 0; i < numDice; i++) {
                const dice = document.createElement('div');
                dice.className = 'dice rolling';
                dice.textContent = '?';
                container.appendChild(dice);
            }
            
            // Make API call
            fetch(`/roll?num_dice=${numDice}&sides=${numSides}`)
                .then(response => response.json())
                .then(data => {
                    updateDiceDisplay(data.results);
                    updateHistory(data);
                });
        }
        
        function updateDiceDisplay(results) {
            const container = document.getElementById('dice-container');
            container.innerHTML = '';
            
            results.forEach(result => {
                const dice = document.createElement('div');
                dice.className = 'dice';
                dice.textContent = result;
                container.appendChild(dice);
            });
        }
        
        function updateHistory(rollData) {
            const historyDiv = document.getElementById('history');
            const entry = document.createElement('div');
            entry.className = 'history-entry';
            entry.innerHTML = `[${rollData.timestamp}] ${rollData.dice}: 
                ${rollData.results.join(', ')} (Total: ${rollData.total})`;
            
            historyDiv.insertBefore(entry, historyDiv.children[1]);
            
            // Remove oldest entry if we have more than 10
            if (historyDiv.children.length > 11) {
                historyDiv.removeChild(historyDiv.lastChild);
            }
        }
    </script>
</body>
</html>
    ''', dice_roller=dice_roller)

@app.route('/roll')
def roll_dice():
    num_dice = int(request.args.get('num_dice', 1))
    sides = int(request.args.get('sides', 6))
    
    # Add small delay to simulate rolling
    time.sleep(0.5)
    
    roll_result = dice_roller.roll(num_dice, sides)
    return roll_result

if __name__ == '__main__':
    app.run(debug=True)
