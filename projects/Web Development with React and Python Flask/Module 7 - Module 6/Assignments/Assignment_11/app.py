from flask import Flask, jsonify
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

# Sample IELTS speaking test questions
speaking_tests = [
    {
        "id": 1,
        "part": "Part 1",
        "questions": [
            "Where is your hometown?",
            "What do you like most about it?"
        ]
    },
    {
        "id": 2,
        "part": "Part 2",
        "questions": [
            "Describe a book you recently read",
            "Explain why you chose it"
        ]
    }
]

@app.route('/')
def home():
    return jsonify({
        "message": "IELTS Speaking Test API"
    })

@app.route('/api/speaking-tests', methods=['GET'])
def get_all_questions():
    return jsonify(speaking_tests)

@app.route('/api/speaking-tests/<int:part>', methods=['GET'])
def get_questions_by_part(part):
    filtered = [q for q in speaking_tests if q['part'] == f"Part {part}"]
    return jsonify(filtered)

if __name__ == '__main__':
    app.run(port=5000, debug=True)