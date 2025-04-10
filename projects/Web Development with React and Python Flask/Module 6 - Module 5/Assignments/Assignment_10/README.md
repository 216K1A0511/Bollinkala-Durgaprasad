
# Web-development-Module-5-ASSIGNMENT-10
# IELTS Speaking Test API

## Overview
This project implements a RESTful API for managing IELTS Speaking Test records. The API allows users to create, retrieve, update, and delete speaking test records using Flask and SQLAlchemy.

## Features
- Add a new speaking test record.
- Retrieve a specific test record by ID.
- Retrieve all speaking test records.
- Update an existing test record.
- Delete a test record by ID.
- Validation and error handling.

## Technologies Used
- Python
- Flask
- Flask SQLAlchemy
- SQLite (or any configured database)
- Postman (for testing)

## API Endpoints

### Base URL
```
/api/speaking-tests
```

### Endpoints
| Method | Endpoint | Description |
|--------|---------|-------------|
| POST | `/api/speaking-tests` | Add a new speaking test record |
| GET | `/api/speaking-tests/<int:test_id>` | Retrieve a specific test record by ID |
| GET | `/api/speaking-tests` | Retrieve all speaking test records |
| PUT | `/api/speaking-tests/<int:test_id>` | Update an existing test record |
| DELETE | `/api/speaking-tests/<int:test_id>` | Delete a test record by ID |

## Installation
1. Clone the repository:
   ```sh
   git clone https://github.com/your-repo/ielts-speaking-test-api.git
   cd ielts-speaking-test-api
   ```
2. Create a virtual environment:
   ```sh
   python -m venv venv
   source venv/bin/activate  # On Windows use: venv\Scripts\activate
   ```
3. Install dependencies:
   ```sh
   pip install -r requirements.txt
   ```
4. Set up the database:
   ```sh
   flask db init
   flask db migrate -m "Initial migration."
   flask db upgrade
   ```
5. Run the application:
   ```sh
   flask run
   ```

## Usage
Test the API endpoints using Postman or any API testing tool. Ensure the server is running before sending requests.

## Error Handling
- Invalid test IDs return a `404 Not Found` error.
- Missing or incorrect data returns a `400 Bad Request` error.
- Internal server errors return a `500 Internal Server Error` message.

## Testing
- Use Postman or CURL to test API endpoints.
- Validate request payloads and responses.

## Submission Requirements
- `speaking_tests.py` file containing the API endpoints.
- Postman screenshots as evidence of successful testing.
- This `README.md` file explaining the project setup and usage.



