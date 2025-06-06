
1. Setup Flask Application
   Initialize a Flask app.

Structure your project with a main app.py file.

2. Configure Structured Logging
   Use Python’s logging module.

Set log file name, format (timestamp, level, message), and level (INFO or ERROR).

Ensure logs include metadata: request path, status codes, and error details.

3. Implement Request Validation Middleware
   Use @app.before_request to check incoming request data.

Validate:

Content-Type is application/json.

Required fields (e.g., question) are present.

Return a 400 error if validation fails.

Log validation errors.

4. Define API Endpoint
   Create a POST route /api/speaking-test.

Process the question field from the JSON body.

Log successful API calls.

5. Implement Error Handling Middleware
   Use @app.errorhandler for:

400 Bad Request

404 Not Found

500 Internal Server Error

Exception for unhandled errors

Return user-friendly JSON messages.

Log error details using logger.error() or logger.exception().

6. Testing
   Simulate valid and invalid requests using tools like Postman or curl.

Check that:

Valid requests succeed and are logged.

Invalid requests are rejected and logged with appropriate errors.

All logs are written to app.log.

7. Prepare Submission
   Include:

app.py with all code.

app.log file with sample logs.

Screenshots or test results.
