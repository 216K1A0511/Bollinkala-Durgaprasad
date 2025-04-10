from flask import Flask
from config import Config
from models import db
from speaking_tests import speaking_tests

app = Flask(__name__)
app.config.from_object(Config)
db.init_app(app)

app.register_blueprint(speaking_tests)

# Home route
@app.route('/')
def home():
    return "IELTS Speaking Test Platform"

if __name__ == '__main__':
    with app.app_context():
        db.create_all()
    app.run(debug=True)


