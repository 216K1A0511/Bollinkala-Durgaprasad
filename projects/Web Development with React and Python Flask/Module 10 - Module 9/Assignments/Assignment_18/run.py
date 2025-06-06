# modal_component.py

from flask import Flask, render_template_string, request, jsonify

app = Flask(__name__)

# Template with a modal component and buttons to trigger it
HTML_TEMPLATE = """
<!DOCTYPE html>
<html>
<head>
    <title>IELTS Speaking Test Dashboard</title>
    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            max-width: 80%;
            animation: fadeIn 0.3s ease-in-out;
        }
        .modal-close {
            float: right;
            cursor: pointer;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: scale(0.9);}
            to {opacity: 1; transform: scale(1);}
        }
    </style>
</head>
<body>
    <h1>Test Dashboard</h1>
    <button onclick="openModal('These are the test instructions.')">View Instructions</button>
    <button onclick="openModal('You scored 8.5 on the test!')">View Results</button>

    <div id="modal" class="modal-overlay" tabindex="-1" onclick="closeModal(event)">
        <div class="modal-content" role="dialog" aria-modal="true">
            <span class="modal-close" onclick="closeModal(event)">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>

    <script>
        function openModal(content) {
            document.getElementById('modal-body').innerText = content;
            document.getElementById('modal').style.display = 'flex';
            document.getElementById('modal').focus();
        }

        function closeModal(event) {
            if (event.target.id === 'modal' || event.target.classList.contains('modal-close')) {
                document.getElementById('modal').style.display = 'none';
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.getElementById('modal').style.display = 'none';
            }
        });
    </script>
</body>
</html>
"""

@app.route('/')
def index():
    return render_template_string(HTML_TEMPLATE)

if __name__ == '__main__':
    app.run(debug=True)
