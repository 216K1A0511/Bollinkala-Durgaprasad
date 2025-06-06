from flask import Blueprint, request, jsonify
import google.generativeai as genai
import logging
from config import Config

ai_questions_bp = Blueprint('ai_questions', __name__, url_prefix='/api')

# Configure Gemini AI
genai.configure(api_key=Config.GEMINI_API_KEY)
model = genai.GenerativeModel(Config.GEMINI_MODEL)

@ai_questions_bp.route('/ai-questions', methods=['POST'])
def generate_ai_question():
    try:
        # Validate input
        data = request.get_json()
        if not data:
            return jsonify({"error": "Request body must be JSON"}), 400
        
        question_type = data.get('type', 'Part 2')
        difficulty = data.get('difficulty', 'medium')
        topic = data.get('topic', 'general')
        
        # Generate prompt based on parameters
        prompt = f"""
        Generate an IELTS Speaking {question_type} question.
        Difficulty level: {difficulty}
        Topic area: {topic}
        
        The question should:
        - Be appropriate for English language testing
        - Encourage a detailed response (1-2 minutes)
        - Be clear and unambiguous
        - Follow official IELTS question formats
        
        Return ONLY the question text, no additional commentary or formatting.
        """
        
        # Call Gemini AI API
        response = model.generate_content(
            prompt,
            generation_config={
                "temperature": Config.TEMPERATURE,
                "max_output_tokens": Config.MAX_TOKENS,
            }
        )
        
        # Process and return response
        question = response.text.strip()
        
        logging.info(f"Generated question: {question}")
        
        return jsonify({
            "status": "success",
            "data": {
                "question": question,
                "type": question_type,
                "difficulty": difficulty,
                "topic": topic
            }
        })
        
    except Exception as e:
        logging.error(f"Error generating question: {str(e)}")
        return jsonify({
            "status": "error",
            "message": "Failed to generate question",
            "details": str(e)
        }), 500