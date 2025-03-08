from flask import Flask, request, jsonify

app = Flask(__name__)
users = []

@app.route('/register', methods=['POST'])
def register_user():
    data = request.get_json()  
    
    
    if 'name' not in data or not data['name']:
        return jsonify({"error": "Name is required."}), 400
    if 'email' not in data or not data['email']:
        return jsonify({"error": "Email is required."}), 400

    
    users.append({"name": data['name'], "email": data['email']})

    return jsonify({"message": "User registered successfully!"}), 201

@app.route('/users', methods=['GET'])
def get_users():
    return jsonify(users), 200

if __name__ == '_main_':
    app.run(debug=True)