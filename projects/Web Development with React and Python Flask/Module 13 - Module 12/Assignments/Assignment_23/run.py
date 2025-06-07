import requests

BASE_URL = "http://localhost:5000"  # Update if your Flask server is running elsewhere

# Test users
admin_credentials = {"email": "admin@example.com", "password": "adminpass"}
test_taker_credentials = {"email": "user@example.com", "password": "userpass"}

def test_login_success():
    response = requests.post(f"{BASE_URL}/api/login", json=admin_credentials)
    assert response.status_code == 200
    token = response.json().get("token")
    assert token is not None
    print("✅ Login success test passed.")

def test_login_invalid_credentials():
    wrong_credentials = {"email": "fake@example.com", "password": "wrongpass"}
    response = requests.post(f"{BASE_URL}/api/login", json=wrong_credentials)
    assert response.status_code == 401
    print("✅ Invalid login test passed.")

def test_access_protected_route():
    login = requests.post(f"{BASE_URL}/api/login", json=admin_credentials)
    token = login.json().get("token")
    
    headers = {"Authorization": f"Bearer {token}"}
    response = requests.get(f"{BASE_URL}/api/admin/dashboard", headers=headers)
    assert response.status_code == 200
    print("✅ Protected route access test passed.")

def test_fetch_test_questions():
    login = requests.post(f"{BASE_URL}/api/login", json=test_taker_credentials)
    token = login.json().get("token")
    
    headers = {"Authorization": f"Bearer {token}"}
    response = requests.get(f"{BASE_URL}/api/test/questions", headers=headers)
    assert response.status_code == 200
    assert isinstance(response.json(), list)
    print("✅ Fetch questions test passed.")

def test_submit_test_response():
    login = requests.post(f"{BASE_URL}/api/login", json=test_taker_credentials)
    token = login.json().get("token")
    
    headers = {"Authorization": f"Bearer {token}"}
    data = {
        "question_id": 1,
        "response_text": "This is my answer."
    }
    response = requests.post(f"{BASE_URL}/api/test/submit", headers=headers, json=data)
    assert response.status_code == 201
    print("✅ Submit test response passed.")

if __name__ == "__main__":
    test_login_success()
    test_login_invalid_credentials()
    test_access_protected_route()
    test_fetch_test_questions()
    test_submit_test_response()
    print("\n🎯 All integration tests completed.")
