from flask_sqlalchemy import SQLAlchemy
from werkzeug.security import generate_password_hash, check_password_hash

db = SQLAlchemy()

class User(db.Model):
    __tablename__ = 'users'
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100), nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    password_hash = db.Column(db.String(128))
    
    speaking_tests = db.relationship('SpeakingTest', backref='user', lazy=True)
    listening_tests = db.relationship('ListeningTest', backref='user', lazy=True)

    def set_password(self, password):
        self.password_hash = generate_password_hash(password)

    def check_password(self, password):
        return check_password_hash(self.password_hash, password)
    
    # CRUD Operations
def create_entity(entity):
    db.session.add(entity)
    db.session.commit()
    return entity

def get_user_by_id(user_id):
    return User.query.get(user_id)

def get_tests_by_user(user_id, test_type):
    if test_type == 'speaking':
        return SpeakingTest.query.filter_by(user_id=user_id).all()
    return ListeningTest.query.filter_by(user_id=user_id).all()

def update_entity(entity, data):
    for key, value in data.items():
        setattr(entity, key, value)
    db.session.commit()
    return entity

def delete_entity(entity):
    db.session.delete(entity)
    db.session.commit()

class SpeakingTest(db.Model):
    __tablename__ = 'speaking_tests'
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('users.id'), nullable=False)
    question = db.Column(db.Text, nullable=False)
    response = db.Column(db.Text, nullable=False)
    score = db.Column(db.Float)

class ListeningTest(db.Model):
    __tablename__ = 'listening_tests'
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('users.id'), nullable=False)
    question = db.Column(db.Text, nullable=False)
    response = db.Column(db.Text, nullable=False)
    score = db.Column(db.Float)