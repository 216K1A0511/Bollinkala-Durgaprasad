from flask import Blueprint, request, jsonify, abort
from models import db, SpeakingTest

speaking_tests = Blueprint('speaking_tests', __name__)

# Validation function to check required fields
def validate_speaking_test_data(data):
    if 'user_id' not in data or 'question' not in data or 'response' not in data or 'score' not in data:
        abort(400, description="Missing required fields")

# POST /api/speaking-tests
@speaking_tests.route('/api/speaking-tests', methods=['POST'])
def add_speaking_test():
    data = request.get_json()
    validate_speaking_test_data(data)
    
    new_test = SpeakingTest(user_id=data['user_id'], question=data['question'], response=data['response'], score=data['score'])
    db.session.add(new_test)
    db.session.commit()
    
    return jsonify({"message": "Speaking test added", "test": new_test.id}), 201

# GET /api/speaking-tests/<int:test_id>
@speaking_tests.route('/api/speaking-tests/<int:test_id>', methods=['GET'])
def get_speaking_test(test_id):
    test = SpeakingTest.query.get_or_404(test_id)
    return jsonify(test.to_dict())

# GET /api/speaking-tests
@speaking_tests.route('/api/speaking-tests', methods=['GET'])
def get_all_speaking_tests():
    tests = SpeakingTest.query.all()
    return jsonify([test.to_dict() for test in tests])

# PUT /api/speaking-tests/<int:test_id>
@speaking_tests.route('/api/speaking-tests/<int:test_id>', methods=['PUT'])
def update_speaking_test(test_id):
    test = SpeakingTest.query.get_or_404(test_id)
    data = request.get_json()
    validate_speaking_test_data(data)
    
    test.user_id = data['user_id']
    test.question = data['question']
    test.response = data['response']
    test.score = data['score']
    db.session.commit()
    
    return jsonify({"message": "Speaking test updated", "test": test.to_dict()})

# DELETE /api/speaking-tests/<int:test_id>
@speaking_tests.route('/api/speaking-tests/<int:test_id>', methods=['DELETE'])
def delete_speaking_test(test_id):
    test = SpeakingTest.query.get_or_404(test_id)
    db.session.delete(test)
    db.session.commit()
    
    return jsonify({"message": "Speaking test deleted"})