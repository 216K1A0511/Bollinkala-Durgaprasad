from flask import Flask, jsonify  # Import Required Modules

# Create an instance of Flask
app = Flask(__name__)

# Define the home route
@app.route('/')
def home():
    return jsonify({
        "message": "Welcome to the IELTS Speaking Test API!"
    })

# Define the info route
@app.route('/info')
def info():
    return jsonify({
        "platform": "IELTS Speaking Test API",
        "version": "1.0",
        "developer": "bollinkala durgaprasad",
        "contact": "lovelyprasad6551@gmail.com"
    })

# Main entry point
if __name__ == "__main__":
    app.run(debug=True)
