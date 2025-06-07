# jwt_auth_backend.py

from flask import Flask, request, jsonify
import jwt
import datetime
from functools import wraps

app = Flask(__name__)

# Secret key to encode and decode JWT
app.config['SECRET_KEY'] = 'your_secret_key'

# Sample user database
users = {
    'admin': {'password': 'admin123', 'role': 'admin'},
    'john': {'password': 'test123', 'role': 'test_taker'}
}

def token_required(role=None):
    def decorator(f):
        @wraps(f)
        def wrapper(*args, **kwargs):
            token = request.headers.get('Authorization')
            if not token:
                return jsonify({'error': 'Token is missing'}), 401
            try:
                data = jwt.decode(token, app.config['SECRET_KEY'], algorithms=["HS256"])
                if role and data.get('role') != role:
                    return jsonify({'error': 'Access denied: insufficient permissions'}), 403
            except jwt.ExpiredSignatureError:
                return jsonify({'error': 'Token has expired'}), 401
            except jwt.InvalidTokenError:
                return jsonify({'error': 'Invalid token'}), 401
            return f(*args, **kwargs, user_data=data)
        return wrapper
    return decorator

@app.route('/login', methods=['POST'])
def login():
    auth = request.get_json()
    username = auth.get('username')
    password = auth.get('password')

    user = users.get(username)
    if user and user['password'] == password:
        token = jwt.encode({
            'user_id': username,
            'role': user['role'],
            'exp': datetime.datetime.utcnow() + datetime.timedelta(minutes=30)
        }, app.config['SECRET_KEY'], algorithm="HS256")
        return jsonify({'token': token})
    return jsonify({'error': 'Invalid credentials'}), 401

@app.route('/protected', methods=['GET'])
@token_required()
def protected(user_data):
    return jsonify({'message': f"Hello, {user_data['user_id']}! This is a protected route."})

@app.route('/admin', methods=['GET'])
@token_required(role='admin')
def admin_only(user_data):
    return jsonify({'message': f"Welcome Admin {user_data['user_id']}!"})

if __name__ == '__main__':
    app.run(debug=True)
