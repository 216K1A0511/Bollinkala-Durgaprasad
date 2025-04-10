from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from werkzeug.security import generate_password_hash, check_password_hash

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///ielts.db'  # SQLite database
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)

# User Model
class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100), nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    password_hash = db.Column(db.String(128))

    def set_password(self, password):
        self.password_hash = generate_password_hash(password)

    def check_password(self, password):
        return check_password_hash(self.password_hash, password)

# SpeakingTest Model
class SpeakingTest(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'), nullable=False)
    question = db.Column(db.Text, nullable=False)
    response = db.Column(db.Text, nullable=False)
    score = db.Column(db.Float)

# ListeningTest Model
class ListeningTest(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'), nullable=False)
    question = db.Column(db.Text, nullable=False)
    response = db.Column(db.Text, nullable=False)
    score = db.Column(db.Float)

# Helper Functions
def create_entity(entity):
    db.session.add(entity)
    db.session.commit()
    return entity

def delete_entity(entity):
    db.session.delete(entity)
    db.session.commit()

def update_entity(entity, data):
    for key, value in data.items():
        if hasattr(entity, key):
            setattr(entity, key, value)
    db.session.commit()
    return entity

def get_user_by_id(user_id):
    return User.query.get(user_id)

# Routes
@app.route('/')
def home():
    return "IELTS Speaking Test Platform"

# User Routes
@app.route('/users', methods=['POST'])
def create_user():
    data = request.json
    if not data or 'name' not in data or 'email' not in data or 'password' not in data:
        return jsonify({'message': 'Missing required fields'}), 400
    
    user = User(name=data['name'], email=data['email'])
    user.set_password(data['password'])
    create_entity(user)
    return jsonify({'message': 'User created', 'id': user.id}), 201

@app.route('/users/<int:user_id>', methods=['GET'])
def get_user(user_id):
    user = get_user_by_id(user_id)
    if not user:
        return jsonify({'message': 'User not found'}), 404
    return jsonify({'name': user.name, 'email': user.email})

@app.route('/users/<int:user_id>', methods=['PUT'])
def update_user(user_id):
    user = get_user_by_id(user_id)
    if not user:
        return jsonify({'message': 'User not found'}), 404
    
    data = request.json
    if 'name' in data:
        user.name = data['name']
    if 'email' in data:
        user.email = data['email']
    if 'password' in data:
        user.set_password(data['password'])
    
    db.session.commit()
    return jsonify({'message': 'User updated'})

@app.route('/users/<int:user_id>', methods=['DELETE'])
def delete_user(user_id):
    user = get_user_by_id(user_id)
    if not user:
        return jsonify({'message': 'User not found'}), 404
    delete_entity(user)
    return jsonify({'message': 'User deleted'})

# Speaking Test Routes
@app.route('/speaking-tests', methods=['POST'])
def create_speaking_test():
    data = request.json
    if not data or 'user_id' not in data or 'question' not in data or 'response' not in data:
        return jsonify({'message': 'Missing required fields'}), 400
    
    test = SpeakingTest(
        user_id=data['user_id'],
        question=data['question'],
        response=data['response'],
        score=data.get('score')
    )
    create_entity(test)
    return jsonify({'message': 'Speaking test created', 'id': test.id}), 201

@app.route('/speaking-tests/<int:test_id>', methods=['GET'])
def get_speaking_test(test_id):
    test = SpeakingTest.query.get(test_id)
    if not test:
        return jsonify({'message': 'Speaking test not found'}), 404
    return jsonify({
        'id': test.id,
        'user_id': test.user_id,
        'question': test.question,
        'response': test.response,
        'score': test.score
    })

@app.route('/speaking-tests/<int:test_id>', methods=['PUT'])
def update_speaking_test(test_id):
    test = SpeakingTest.query.get(test_id)
    if not test:
        return jsonify({'message': 'Speaking test not found'}), 404
    
    data = request.json
    update_data = {
        'question': data.get('question', test.question),
        'response': data.get('response', test.response),
        'score': data.get('score', test.score)
    }
    update_entity(test, update_data)
    return jsonify({'message': 'Speaking test updated'})

@app.route('/speaking-tests/<int:test_id>', methods=['DELETE'])
def delete_speaking_test(test_id):
    test = SpeakingTest.query.get(test_id)
    if not test:
        return jsonify({'message': 'Speaking test not found'}), 404
    delete_entity(test)
    return jsonify({'message': 'Speaking test deleted'})

# Listening Test Routes
@app.route('/listening-tests', methods=['POST'])
def create_listening_test():
    data = request.json
    if not data or 'user_id' not in data or 'question' not in data or 'response' not in data:
        return jsonify({'message': 'Missing required fields'}), 400
    
    test = ListeningTest(
        user_id=data['user_id'],
        question=data['question'],
        response=data['response'],
        score=data.get('score')
    )
    create_entity(test)
    return jsonify({'message': 'Listening test created', 'id': test.id}), 201

@app.route('/listening-tests/<int:test_id>', methods=['GET'])
def get_listening_test(test_id):
    test = ListeningTest.query.get(test_id)
    if not test:
        return jsonify({'message': 'Listening test not found'}), 404
    return jsonify({
        'id': test.id,
        'user_id': test.user_id,
        'question': test.question,
        'response': test.response,
        'score': test.score
    })

@app.route('/listening-tests/<int:test_id>', methods=['PUT'])
def update_listening_test(test_id):
    test = ListeningTest.query.get(test_id)
    if not test:
        return jsonify({'message': 'Listening test not found'}), 404
    
    data = request.json
    update_data = {
        'question': data.get('question', test.question),
        'response': data.get('response', test.response),
        'score': data.get('score', test.score)
    }
    update_entity(test, update_data)
    return jsonify({'message': 'Listening test updated'})

@app.route('/listening-tests/<int:test_id>', methods=['DELETE'])
def delete_listening_test(test_id):
    test = ListeningTest.query.get(test_id)
    if not test:
        return jsonify({'message': 'Listening test not found'}), 404
    delete_entity(test)
    return jsonify({'message': 'Listening test deleted'})

# Initialize Database
if __name__ == '__main__':
    with app.app_context():
        db.create_all()  # Create database tables
    app.run(debug=True)  # Run the Flask app in debug mode