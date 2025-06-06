from flask import Flask, request, jsonify, render_template
from flask_cors import CORS
import requests
import os
from dotenv import load_dotenv

load_dotenv()

app = Flask(__name__)
CORS(app)

# Use your actual API key here
GEMINI_API_KEY = os.getenv('GEMINI_API_KEY', 'AIzaSyAK3gTLi0up31iGqs1Z2IvEwa-RNX6lBJA')

# Updated Gemini URL with correct model name
GEMINI_URL = f"https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={GEMINI_API_KEY}"

@app.route('/')
def home():
    """Display a simple homepage with instructions"""
    return """
    <h1>IELTS Speaking Test Backend</h1>
    <p>Backend is running successfully!</p>
    <p>Use POST /api/ai-questions to generate questions.</p>
    <p>Example request:</p>
    <pre>
    curl -X POST http://localhost:5000/api/ai-questions \\
      -H "Content-Type: application/json" \\
      -d '{"type": "part1", "difficulty": "medium", "topic": "technology"}'
    </pre>
    """

@app.route('/api/ai-questions', methods=['POST'])
def generate_questions():
    try:
        data = request.get_json()
        if not data:
            return jsonify({'error': 'No data provided', 'status': 'error'}), 400
            
        question_type = data.get('type', 'part1')
        difficulty = data.get('difficulty', 'medium')
        topic = data.get('topic', 'general')
        
        # Validate input
        if question_type not in ['part1', 'part2', 'part3']:
            return jsonify({'error': 'Invalid question type'}), 400
            
        if difficulty not in ['easy', 'medium', 'hard']:
            return jsonify({'error': 'Invalid difficulty level'}), 400
        
        # Generate prompt with more specific instructions
        prompt = f"""Generate exactly 5 IELTS Speaking Test {question_type} questions about {topic} with {difficulty} difficulty.
        Return only the questions as a bulleted list with each question on a new line starting with '- '.
        Example format:
        - What do you think about technology?
        - How has technology changed education?
        - Describe a technological device you find useful.
        - Do you think technology makes people lazy?
        - Will traditional books disappear because of technology?"""
        
        # Call Gemini API with proper headers
        headers = {'Content-Type': 'application/json'}
        payload = {
            "contents": [{
                "parts": [{"text": prompt}]
            }],
            "generationConfig": {
                "temperature": 0.7,
                "topP": 1,
                "maxOutputTokens": 2048
            }
        }
        
        response = requests.post(GEMINI_URL, headers=headers, json=payload)
        response.raise_for_status()
        response_data = response.json()
        
        # Process the response
        if not response_data.get('candidates'):
            return jsonify({'error': 'No questions generated', 'status': 'error'}), 500
            
        text_response = response_data['candidates'][0]['content']['parts'][0]['text']
        questions = [q.strip('- ').strip() for q in text_response.split('\n') if q.strip()]
        
        return jsonify({
            'questions': questions[:5],
            'type': question_type,
            'difficulty': difficulty,
            'topic': topic,
            'status': 'success'
        })
        
    except requests.exceptions.HTTPError as http_err:
        error_msg = f"Gemini API Error: {http_err.response.status_code} - {http_err.response.text}"
        return jsonify({'error': error_msg, 'status': 'error'}), 500
    except Exception as e:
        return jsonify({'error': str(e), 'status': 'error'}), 500

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)