from flask import Flask, render_template_string, request
import random
import string

app = Flask(__name__)

class PasswordGenerator:
    def __init__(self):
        self.history = []
        
    def generate(self, length=12, uppercase=True, lowercase=True, 
                digits=True, special_chars=True, exclude_similar=True):
        characters = ''
        
        if uppercase:
            characters += string.ascii_uppercase
        if lowercase:
            characters += string.ascii_lowercase
        if digits:
            characters += string.digits
        if special_chars:
            characters += '!@#$%^&*()_+-=[]{}|;:,.<>?'
        if exclude_similar:
            characters = characters.replace('l', '').replace('1', '').replace('I', '')
            characters = characters.replace('O', '').replace('0', '')
        
        if not characters:
            return "Select at least one character type"
        
        password = ''.join(random.choice(characters) for _ in range(length))
        
        # Add to history (limit to last 10)
        self.history.insert(0, password)
        if len(self.history) > 10:
            self.history.pop()
            
        return password

pw_gen = PasswordGenerator()

@app.route('/', methods=['GET', 'POST'])
def index():
    password = ''
    if request.method == 'POST':
        length = int(request.form.get('length', 12))
        uppercase = 'uppercase' in request.form
        lowercase = 'lowercase' in request.form
        digits = 'digits' in request.form
        special_chars = 'special_chars' in request.form
        exclude_similar = 'exclude_similar' in request.form
        
        password = pw_gen.generate(
            length=length,
            uppercase=uppercase,
            lowercase=lowercase,
            digits=digits,
            special_chars=special_chars,
            exclude_similar=exclude_similar
        )
    
    return render_template_string('''
<!DOCTYPE html>
<html>
<head>
    <title>Password Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
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
            color: #333;
            text-align: center;
        }
        .password-display {
            font-size: 1.5rem;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
            margin: 20px 0;
            word-break: break-all;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="number"] {
            width: 60px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 15px 0;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
        }
        button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background: #45a049;
        }
        .history {
            margin-top: 30px;
        }
        .history h2 {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .history-item {
            padding: 8px;
            border-bottom: 1px solid #f0f0f0;
            font-family: monospace;
        }
        .copy-btn {
            background: #2196F3;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Password Generator</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="length">Password Length:</label>
                <input type="number" id="length" name="length" min="4" max="50" value="{{ request.form.get('length', 12) }}">
            </div>
            
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" id="uppercase" name="uppercase" 
                           {{ 'checked' if request.form.get('uppercase') != 'off' else '' }}>
                    <label for="uppercase">Uppercase (A-Z)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="lowercase" name="lowercase" 
                           {{ 'checked' if request.form.get('lowercase') != 'off' else '' }}>
                    <label for="lowercase">Lowercase (a-z)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="digits" name="digits" 
                           {{ 'checked' if request.form.get('digits') != 'off' else '' }}>
                    <label for="digits">Digits (0-9)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="special_chars" name="special_chars" 
                           {{ 'checked' if request.form.get('special_chars') != 'off' else '' }}>
                    <label for="special_chars">Special Characters</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="exclude_similar" name="exclude_similar" 
                           {{ 'checked' if request.form.get('exclude_similar') != 'off' else '' }}>
                    <label for="exclude_similar">Exclude Similar Characters (l,1,I,0,O)</label>
                </div>
            </div>
            
            <button type="submit">Generate Password</button>
        </form>
        
        {% if password %}
        <div class="password-display" id="password-display">
            {{ password }}
            <button class="copy-btn" onclick="copyToClipboard()">Copy</button>
        </div>
        {% endif %}
        
        {% if pw_gen.history %}
        <div class="history">
            <h2>Generated Passwords</h2>
            {% for pw in pw_gen.history %}
                <div class="history-item">{{ pw }}</div>
            {% endfor %}
        </div>
        {% endif %}
    </div>

    <script>
        function copyToClipboard() {
            const password = document.getElementById('password-display').textContent.trim();
            navigator.clipboard.writeText(password).then(() => {
                alert('Password copied to clipboard!');
            });
        }
    </script>
</body>
</html>
    ''', password=password, pw_gen=pw_gen)

if __name__ == '__main__':
    app.run(debug=True)
