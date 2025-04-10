from models import db, User, SpeakingTest, ListeningTest

# Create User
def create_user(name, email, password):
    user = User(name=name, email=email, password=password)
    db.session.add(user)
    db.session.commit()
    return user

# Get User by ID
def get_user(user_id):
    return User.query.get(user_id)

# Create Speaking Test
def create_speaking_test(user_id, question, response, score):
    test = SpeakingTest(user_id=user_id, question=question, response=response, score=score)
    db.session.add(test)
    db.session.commit()
    return test

# Get Speaking Tests by User
def get_speaking_tests(user_id):
    return SpeakingTest.query.filter_by(user_id=user_id).all()

# Update Speaking Test Score
def update_speaking_test(test_id, new_score):
    test = SpeakingTest.query.get(test_id)
    if test:
        test.score = new_score
        db.session.commit()
        return test
    return None

# Delete Speaking Test
def delete_speaking_test(test_id):
    test = SpeakingTest.query.get(test_id)
    if test:
        db.session.delete(test)
        db.session.commit()
        return True
    return False
