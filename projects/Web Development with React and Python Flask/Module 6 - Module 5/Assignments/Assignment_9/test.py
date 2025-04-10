from app import app
from models import db
import crud

with app.app_context():
    # Create a new user
    user = crud.create_user("John Doe", "john@example.com", "securepassword")
    print(f"User created: {user.id}, {user.name}")

    # Create a speaking test
    test = crud.create_speaking_test(user.id, "Describe your hometown.", "My hometown is...", 7)
    print(f"Test created: {test.id}, Score: {test.score}")

    # Fetch speaking tests
    tests = crud.get_speaking_tests(user.id)
    print(f"User {user.id} has {len(tests)} speaking tests.")

    # Update test score
    updated_test = crud.update_speaking_test(test.id, 8)
    if updated_test:
        print(f"Test {test.id} updated score: {updated_test.score}")

    # Delete test
    if crud.delete_speaking_test(test.id):
        print(f"Test {test.id} deleted successfully.")
