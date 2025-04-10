from flask_sqlalchemy import SQLAlchemy
from datetime import datetime

db = SQLAlchemy()

# Define models without relationships initially

class User(db.Model):
    __tablename__ = 'users'
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100), nullable=False)
    email = db.Column(db.String(100), unique=True, nullable=False)
    password = db.Column(db.String(100), nullable=False)

class SpeakingTest(db.Model):
    __tablename__ = 'speaking_tests'
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('users.id'), nullable=False)
    question = db.Column(db.String(200), nullable=False)
    response = db.Column(db.Text, nullable=False)
    score = db.Column(db.Float)
    timestamp = db.Column(db.DateTime, default=datetime.utcnow)
    
    def to_dict(self):
        return {
            'id': self.id,
            'user_id': self.user_id,
            'question': self.question,
            'response': self.response,
            'score': self.score,
            'timestamp': self.timestamp.isoformat()
        }

class ListeningTest(db.Model):
    __tablename__ = 'listening_tests'
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('users.id'), nullable=False)
    question = db.Column(db.String(200), nullable=False)
    response = db.Column(db.Text, nullable=False)
    score = db.Column(db.Float)
    timestamp = db.Column(db.DateTime, default=datetime.utcnow)

# Setup relationships after all models are defined

User.speaking_tests = db.relationship('SpeakingTest', backref='user', lazy=True)
User.listening_tests = db.relationship('ListeningTest', backref='user', lazy=True)