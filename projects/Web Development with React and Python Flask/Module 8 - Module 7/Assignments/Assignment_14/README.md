Here's the **merged and organized `README.md`** for **Assignment 14: Implement Logging and Error Handling**, incorporating the **detailed implementation steps** with the **original requirements and structure**:

---

# Assignment 14: Implement Logging and Error Handling

## 🎯 Objective

Enhance the backend of the **IELTS Speaking Test Platform** by adding structured logging and middleware for request validation and error handling. These improvements will help monitor API usage, identify errors, and debug efficiently.

---

## 📘 Scenario

To ensure efficient backend operations and effective error tracking in production, this assignment involves:

* Validating incoming API requests.
* Logging structured metadata.
* Implementing graceful error responses.

---

## ✅ Implementation Steps

### 1. Setup Flask Application

* Initialize a Flask app.
* Create a file named `app.py` as the main entry point.
* Use a standard project structure:

  ```
  project/
  ├── app.py
  ├── app.log
  └── README.md
  ```

### 2. Configure Structured Logging

* Use Python’s built-in `logging` module.
* Set log file name (`app.log`), format, and logging level (e.g., `INFO`, `ERROR`).
* Log format should include:

  * Timestamp
  * Log level
  * Request method and path
  * Status code
  * Error details (if any)

```python
import logging

logging.basicConfig(
    filename='app.log',
    level=logging.INFO,
    format='[%(asctime)s] %(levelname)s: %(message)s',
    datefmt='%Y-%m-%d %H:%M:%S'
)
logger = logging.getLogger(__name__)
```

### 3. Implement Request Validation Middleware

* Use `@app.before_request` to validate requests before they reach the endpoint.
* Check:

  * `Content-Type` is `application/json`
  * Required field: `"question"`
* Return `400 Bad Request` if validation fails.
* Log validation errors.

```python
from flask import request, jsonify

@app.before_request
def validate_request():
    if request.method == "POST" and request.path == "/api/speaking-test":
        if not request.is_json:
            logger.warning(f"Invalid Content-Type at {request.path}")
            return jsonify({"error": "Content-Type must be application/json"}), 400
        data = request.get_json()
        if "question" not in data:
            logger.warning(f"Missing 'question' field at {request.path}")
            return jsonify({"error": "Missing required field: question"}), 400
```

### 4. Define API Endpoint

* Create a POST route: `/api/speaking-test`
* Process and log valid submissions.

```python
@app.route("/api/speaking-test", methods=["POST"])
def speaking_test():
    data = request.get_json()
    question = data["question"]
    logger.info(f"Received question: {question} at {request.path}")
    return jsonify({"message": "Question received successfully"}), 200
```

### 5. Implement Error Handling Middleware

* Use `@app.errorhandler` decorators for:

  * 400 Bad Request
  * 404 Not Found
  * 500 Internal Server Error
  * Generic `Exception`
* Log all error details using `logger.error()` or `logger.exception()`.

```python
@app.errorhandler(400)
def bad_request(e):
    logger.error(f"400 Error at {request.path} - {e}")
    return jsonify({"error": "Bad Request"}), 400

@app.errorhandler(404)
def not_found(e):
    logger.error(f"404 Error at {request.path} - {e}")
    return jsonify({"error": "Not Found"}), 404

@app.errorhandler(500)
def server_error(e):
    logger.exception(f"500 Error at {request.path} - {e}")
    return jsonify({"error": "Internal Server Error"}), 500

@app.errorhandler(Exception)
def unhandled_exception(e):
    logger.exception(f"Unhandled Exception at {request.path} - {e}")
    return jsonify({"error": "An unexpected error occurred"}), 500
```

### 6. Testing

* Use **Postman** or **curl** to simulate:

  * ✅ Valid POST requests (with `"question"`).
  * ❌ Invalid POST requests (missing JSON or required fields).
* Verify that:

  * Valid requests return `200 OK` and are logged.
  * Invalid requests return errors and logs are generated.
  * `app.log` contains all entries.

---

## 📁 Deliverables

* ✅ `app.py` with Flask app, logging, middleware, and routes.
* 📝 `app.log` file with sample log entries.
* 📸 Screenshots or test results from Postman/curl showing:

  * Success and error responses.
* ✅ Summary of test cases and expected vs. actual results.

---

## 📊 Evaluation Criteria

| Criterion                  | Weight |
| -------------------------- | ------ |
| ✅ Request Validation       | 40%    |
| 🧾 Structured Logging      | 30%    |
| ⚠️ Error Handling          | 20%    |
| 📦 Submission Completeness | 10%    |

---

## ⚙️ Notes & Best Practices

* Do **not** log sensitive user information.
* Use `logger.exception()` to capture tracebacks automatically for unhandled errors.
* Logging format should support future integration with monitoring tools like ELK Stack or Sentry.
* Maintain separation of concerns between middleware, routes, and logging.

---

Let me know if you'd like the actual `app.py` code prewritten for you!
