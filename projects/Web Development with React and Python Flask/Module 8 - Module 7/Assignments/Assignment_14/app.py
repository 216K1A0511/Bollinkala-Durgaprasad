import logging
from flask import Flask, request, jsonify
from werkzeug.exceptions import HTTPException

app = Flask(__name__)

# ---------------------------
# Logger Configuration
# ---------------------------
logging.basicConfig(
    filename='app.log',
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s'
)
logger = logging.getLogger(__name__)

# ---------------------------
# Request Validation Middleware
# ---------------------------
@app.before_request
def validate_request():
    if request.path == "/api/speaking-test" and request.method == "POST":
        if not request.is_json:
            logger.warning("Invalid content type")
            return jsonify({"error": "Request must be JSON"}), 400

        data = request.get_json()
        if 'question' not in data:
            logger.warning("Missing 'question' field")
            return jsonify({"error": "Missing required field: question"}), 400

# ---------------------------
# Routes
# ---------------------------
@app.route('/api/speaking-test', methods=['POST'])
def speaking_test():
    data = request.get_json()
    question = data['question']
    response = f"Simulated response to: {question}"
    logger.info(f"Processed question: {question}")
    return jsonify({"response": response}), 200

# ---------------------------
# Error Handling Middleware
# ---------------------------
@app.errorhandler(400)
def bad_request(e):
    logger.error(f"400 Error: {str(e)}")
    return jsonify({"error": "Bad Request"}), 400

@app.errorhandler(404)
def not_found(e):
    logger.error(f"404 Error: {str(e)}")
    return jsonify({"error": "Not Found"}), 404

@app.errorhandler(500)
def internal_server_error(e):
    logger.error(f"500 Error: {str(e)}")
    return jsonify({"error": "Internal Server Error"}), 500

@app.errorhandler(Exception)
def unhandled_exception(e):
    code = 500
    if isinstance(e, HTTPException):
        code = e.code
    logger.exception("Unhandled Exception")
    return jsonify({"error": "An unexpected error occurred"}), code

# ---------------------------
# Run App
# ---------------------------
if __name__ == '__main__':
    app.run(debug=True)
