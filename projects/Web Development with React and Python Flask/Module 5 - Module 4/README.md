
# Module 7: Backend Advanced Features

## Asynchronous Programming in Flask

Asynchronous programming is essential for handling real-time requests, especially when dealing with long-running or resource-intensive tasks like AI queries. Flask can be extended to support asynchronous programming using tools like `asyncio` and `Quart`.

### 1. Introduction to Asynchronous Programming

#### 1.1 Overview of `asyncio`

- **What is `asyncio`?**
  - `asyncio` is Python’s built-in library for writing asynchronous programs.
  - It allows concurrent execution of tasks without blocking the main application thread.

- **Key Features:**
  - **Event Loop:** Manages the execution of asynchronous tasks.
  - **Coroutines:** Functions defined with `async` that can be paused and resumed.
  - **Tasks:** Used to schedule the execution of coroutines.

- **Why Asynchronous Programming?**
  - Improves performance by handling multiple requests simultaneously.
  - Reduces latency for I/O-bound operations, such as database queries or API calls.

#### 1.2 Differences Between Synchronous and Asynchronous Programming

1. **Synchronous Programming:**
   - Tasks are executed sequentially.
   - A long-running task blocks the execution of subsequent tasks.
   - **Example:**
     ```python
     import time

     def long_task():
         time.sleep(5)  # Simulates a delay
         return "Task Complete"

     print(long_task())  # Blocks further execution
     ```

2. **Asynchronous Programming:**
   - Tasks are executed concurrently.
   - A task that is waiting for I/O operations allows other tasks to run.
   - **Example:**
     ```python
     import asyncio

     async def long_task():
         await asyncio.sleep(5)  # Non-blocking delay
         return "Task Complete"

     asyncio.run(long_task())  # Does not block other tasks
     ```

### 2. Using `asyncio` in Flask

#### 2.1 Implementing Asynchronous Functions

Flask supports asynchronous endpoints with functions defined as `async def`.

- **Example of an Asynchronous Endpoint:**
  ```python
  from flask import Flask
  import asyncio

  app = Flask(__name__)

  @app.route("/async-task")
  async def async_task():
      await asyncio.sleep(5)  # Simulates a long-running task
      return {"message": "Task Complete"}
  ```

- **Explanation:**
  - `async def`: Defines an asynchronous route.
  - `await`: Pauses the coroutine until the awaited task completes.

#### 2.2 Handling Multiple Requests Concurrently

Concurrency allows Flask to handle multiple client requests simultaneously.

- **Example:**
  ```python
  @app.route("/concurrent-tasks")
  async def concurrent_tasks():
      task1 = asyncio.create_task(asyncio.sleep(2))
      task2 = asyncio.create_task(asyncio.sleep(3))
      await task1
      await task2
      return {"message": "Both tasks completed"}
  ```

- **Use Case:**
  - Fetching IELTS test questions while logging user activity concurrently.

#### 2.3 Real-World Scenarios for Async Routes

1. **AI Queries:**
   - Fetching AI-generated IELTS Speaking questions from an external service.
   - **Example:**
     ```python
     async def fetch_ai_questions():
         # Simulate AI query
         await asyncio.sleep(3)
         return {"question": "Describe a recent journey you enjoyed."}
     ```

2. **Database Operations:**
   - Running database queries asynchronously for faster response times.

3. **Third-Party API Calls:**
   - Making non-blocking requests to external APIs for supplementary data.

### 3. Optimizing Performance with Async Routes

#### 3.1 Combining Flask with Quart

Flask, by default, has limited support for asynchronous programming. Quart is an alternative ASGI-compatible framework that extends Flask with full async support.

- **Installing Quart:**
  ```bash
  pip install quart
  ```

- **Example with Quart:**
  ```python
  from quart import Quart

  app = Quart(__name__)

  @app.route("/async-task")
  async def async_task():
      await asyncio.sleep(5)  # Simulates a delay
      return {"message": "Task Complete"}

  if __name__ == "__main__":
      app.run()
  ```

- **Advantages:**
  - Supports full async features natively.
  - Compatible with Flask's syntax and extensions.

#### 3.2 Examples of Async Endpoints for IELTS Question Generation

1. **Async Endpoint for Generating Questions:**
   - Uses `asyncio` to fetch AI-generated questions without blocking other requests.
   - **Example:**
     ```python
     from flask import Flask
     import asyncio

     app = Flask(__name__)

     async def fetch_question():
         await asyncio.sleep(2)  # Simulating AI API delay
         return {"question": "Describe a favorite book you’ve read recently."}

     @app.route("/generate-question")
     async def generate_question():
         question = await fetch_question()
         return question
     ```

2. **Handling Multiple Requests Simultaneously:**
   - Supports real-time interaction by managing multiple user requests concurrently.
   - **Example:**
     ```python
     @app.route("/simulate-users")
     async def simulate_users():
         user1 = asyncio.create_task(fetch_question())
         user2 = asyncio.create_task(fetch_question())
         await user1
         await user2
         return {"message": "Questions generated for multiple users"}
     ```

### Best Practices for Asynchronous Programming in Flask

1. **Use Async-Safe Libraries:**
   - Ensure libraries and extensions are compatible with async programming.

2. **Avoid Mixing Sync and Async:**
   - Mixing synchronous and asynchronous operations can lead to performance bottlenecks.

3. **Test Concurrent Requests:**
   - Simulate multiple client requests to ensure the application scales well.

4. **Optimize Database Queries:**
   - Use async-compatible libraries like SQLAlchemy Async for non-blocking database operations.

---

## Azure OpenAI Integration

Azure OpenAI integration adds AI capabilities to the IELTS Speaking Test platform by generating dynamic test questions. This section provides a step-by-step guide to setting up Azure OpenAI with Flask, securely managing API keys, and designing endpoints for AI-generated questions.

### 1. Connecting Flask with Azure OpenAI

#### 1.1 Setting Up the Azure OpenAI Service

1. **Sign Up for Azure OpenAI:**
   - Create an Azure account and subscribe to the Azure OpenAI service.
   - Set up a resource in the Azure portal to access the OpenAI models (e.g., `text-davinci-003` or `gpt-4`).

2. **Retrieve API Key and Endpoint:**
   - Go to the resource page and copy the API key and Endpoint URL.

3. **Install Required Libraries:**
   - Install the OpenAI Python library to interact with the Azure OpenAI API:
     ```bash
     pip install openai
     ```

4. **Initialize the OpenAI Library:**
   - Configure the OpenAI library in your Flask app using the API key and endpoint:
     ```python
     import openai

     openai.api_type = "azure"
     openai.api_key = "your_api_key"
     openai.api_base = "https://your-resource-name.openai.azure.com/"
     openai.api_version = "2023-05-15"
     ```

#### 1.2 Creating Endpoints to Fetch AI-Generated Questions

1. **Define a Flask Endpoint:**
   - Create an API route to handle requests for AI-generated IELTS questions.
     ```python
     from flask import Flask, jsonify

     app = Flask(__name__)

     @app.route("/generate-question", methods=["GET"])
     def generate_question():
         response = openai.Completion.create(
             engine="text-davinci-003",
             prompt="Generate an IELTS Speaking Part 2 question.",
             max_tokens=50
         )
         question = response.choices[0].text.strip()
         return jsonify({"question": question})
     ```

2. **Sample Prompt for AI:**
   - Customize the prompt to generate relevant IELTS questions:
     ```css
     "Generate an IELTS Speaking Part 2 question. The topic should be related to describing a memorable journey."
     ```

### 2. Securely Handling API Keys

Managing API keys securely is critical to prevent unauthorized access and protect sensitive information.

#### 2.1 Using Environment Variables

1. **Why Environment Variables?:**
   - Store sensitive data like API keys in environment variables instead of hardcoding them in the codebase.

2. **Setting Up `.env` Files:**
   - Create a `.env` file in the project root directory:
     ```makefile
     OPENAI_API_KEY=your_api_key
     OPENAI_API_BASE=https://your-resource-name.openai.azure.com/
     ```

3. **Integrating with `python-dotenv`:**
   - Install the `python-dotenv` library:
     ```bash
     pip install python-dotenv
     ```
   - Load the environment variables in your Flask app:
     ```python
     from dotenv import load_dotenv
     import os

     load_dotenv()
     openai.api_key = os.getenv("OPENAI_API_KEY")
     openai.api_base = os.getenv("OPENAI_API_BASE")
     ```

#### 2.2 Benefits of Using Environment Variables

- Prevent accidental exposure of API keys in public repositories.
- Simplify deployment by separating code from sensitive configuration.

### 3. Generating IELTS Questions

#### 3.1 Designing API Endpoints for AI-Generated Questions

1. **Flask Endpoint:**
   - Create a route to generate questions dynamically based on user input:
     ```python
     from flask import Flask, request, jsonify

     @app.route("/generate-question", methods=["POST"])
     def generate_question():
         topic = request.json.get("topic", "general")
         response = openai.Completion.create(
             engine="text-davinci-003",
             prompt=f"Generate an IELTS Speaking Part 2 question about {topic}.",
             max_tokens=50
         )
         question = response.choices[0].text.strip()
         return jsonify({"question": question})
     ```

2. **Request Body:**
   - The frontend sends a JSON payload specifying the topic:
     ```json
     {
       "topic": "a memorable trip"
     }
     ```

3. **Response:**
   - The backend returns a formatted response:
     ```json
     {
       "question": "Describe a memorable trip you took recently. Include details about the place, activities, and why it was memorable."
     }
     ```

#### 3.2 Formatting Responses for Project Compatibility

1. **Standardized Response Format:**
   - Ensure consistent response structures:
     ```json
     {
       "status": "success",
       "data": {
         "question": "Describe a memorable trip you took recently."
       }
     }
     ```

2. **Error Handling:**
   - Return meaningful error messages for failed requests:
     ```python
     @app.errorhandler(Exception)
     def handle_error(error):
         return jsonify({"status": "error", "message": str(error)}), 500
     ```

3. **Logging AI Requests:**
   - Log API requests and responses for debugging and analytics:
     ```python
     import logging

     logging.basicConfig(filename="ai_requests.log", level=logging.INFO)

     @app.route("/generate-question", methods=["POST"])
     def generate_question():
         try:
             topic = request.json.get("topic", "general")
             response = openai.Completion.create(
                 engine="text-davinci-003",
                 prompt=f"Generate an IELTS Speaking Part 2 question about {topic}.",
                 max_tokens=50
             )
             question = response.choices[0].text.strip()
             logging.info(f"Generated question: {question}")
             return jsonify({"question": question})
         except Exception as e:
             logging.error(f"Error generating question: {str(e)}")
             return jsonify({"error": "Failed to generate question"}), 500
     ```

### Best Practices for Azure OpenAI Integration

1. **Secure Keys:**
   - Always use environment variables to manage API keys.

2. **Optimize Prompts:**
   - Craft precise prompts to generate high-quality and relevant questions.

3. **Monitor API Usage:**
   - Track request volumes and response times to ensure efficient usage of the Azure OpenAI service.

4. **Handle Rate Limits:**
   - Implement retry mechanisms for API calls to handle rate limits.

5. **Provide Clear Feedback:**
   - Ensure the frontend displays meaningful error messages if the API request fails.

---

## Middleware and Logging

Middleware and logging are vital components of a robust backend system. Middleware ensures data consistency and security by validating requests and managing authentication, while logging enables monitoring and debugging by recording application behavior.

### 1. Adding Middleware

Middleware processes requests and responses at a central point, making it easier to enforce application-wide policies like validation and authentication.

#### 1.1 Middleware for Validating Request Payloads

Middleware validates incoming requests to ensure data consistency and avoid processing invalid payloads.

- **Implementation Example:**
  ```python
  from flask import Flask, request, jsonify

  app = Flask(__name__)

  @app.before_request
  def validate_request():
      if request.method == "POST" and not request.is_json:
          return jsonify({"error": "Invalid payload: Expected JSON format"}), 400
  ```

- **Explanation:**
  - `@app.before_request`: Hook that executes before any route.
  - Checks if the request method is POST and the payload is in JSON format.

#### 1.2 Authentication Middleware for Secured Routes

Authentication middleware ensures only authorized users can access protected resources.

- **Implementation Example:**
  ```python
  @app.before_request
  def authenticate():
      token = request.headers.get("Authorization")
      if not token or token != "valid_token":
          return jsonify({"error": "Unauthorized access"}), 401
  ```

- **Advanced Example with Role-Based Access:**
  ```python
  from functools import wraps

  def role_based_access(required_role):
      def decorator(func):
          @wraps(func)
          def wrapper(*args, **kwargs):
              token = request.headers.get("Authorization")
              user_role = validate_token_and_get_role(token)
              if user_role != required_role:
                  return jsonify({"error": "Forbidden: Insufficient permissions"}), 403
              return func(*args, **kwargs)
          return wrapper
      return decorator

  @app.route("/admin", methods=["GET"])
  @role_based_access("admin")
  def admin_dashboard():
      return jsonify({"message": "Welcome, Admin!"})
  ```

### 2. Configuring Logging

Logging tracks application activities, errors, and usage statistics, which are crucial for debugging and monitoring.

#### 2.1 Setting Up Basic Logging

Using Python’s `logging` Module:

1. **Configure logging in the main application file:**
   ```python
   import logging

   logging.basicConfig(
       filename="app.log",
       level=logging.INFO,
       format="%(asctime)s - %(levelname)s - %(message)s",
   )
   ```

2. **Log messages at various levels:**
   ```python
   logging.info("Application started")
   logging.warning("Potential issue detected")
   logging.error("An error occurred")
   ```

#### 2.2 Logging API Usage

Log every incoming request with details such as endpoint, method, and status code.

- **Example:**
  ```python
  @app.after_request
  def log_request(response):
      logging.info(
          f"Endpoint: {request.path}, Method: {request.method}, Status: {response.status_code}"
      )
      return response
  ```

### 3. Advanced Logging Features

Advanced logging features provide detailed and actionable insights into application behavior.

#### 3.1 Adding Metadata to Logs

Include metadata like timestamps, request IDs, and user details for better traceability.

- **Example:**
  ```python
  import uuid

  @app.before_request
  def add_request_id():
      request.request_id = str(uuid.uuid4())

  @app.after_request
  def log_request_with_metadata(response):
      logging.info(
          f"Request ID: {getattr(request, 'request_id', None)}, "
          f"Endpoint: {request.path}, Method: {request.method}, "
          f"Status: {response.status_code}, User-Agent: {request.headers.get('User-Agent')}"
      )
      return response
  ```

#### 3.2 Setting Up Log Rotation

Prevent logs from growing indefinitely by rotating them periodically.

- **Example with `RotatingFileHandler`:**
  ```python
  from logging.handlers import RotatingFileHandler

  handler = RotatingFileHandler("app.log", maxBytes=10000, backupCount=5)
  logging.basicConfig(handlers=[handler], level=logging.INFO, format="%(asctime)s - %(message)s")
  ```

#### 3.3 Integrating External Monitoring Tools

1. **Sentry:**
   - Monitor errors and performance metrics.
   - Install and configure Sentry:
     ```bash
     pip install sentry-sdk
     ```
     ```python
     import sentry_sdk
     from sentry_sdk.integrations.flask import FlaskIntegration

     sentry_sdk.init(dsn="your_sentry_dsn", integrations=[FlaskIntegration()])
     ```

2. **Logstash:**
   - Stream logs to a centralized location for analysis.
   - Use JSON format for logs:
     ```python
     import json
     from datetime import datetime

     log_entry = json.dumps({
         "timestamp": str(datetime.now()),
         "level": "INFO",
         "message": "API called",
         "endpoint": request.path,
     })
     logging.info(log_entry)
     ```

### Best Practices for Middleware and Logging

1. **Modular Middleware:**
   - Keep middleware logic in a separate file for maintainability.

2. **Consistent Log Formatting:**
   - Use a uniform format for all logs, including metadata like timestamps and status codes.

3. **Secure Logs:**
   - Avoid logging sensitive data like passwords or API keys.

4. **Monitor Logs Regularly:**
   - Set up alerts for critical log entries (e.g., repeated 500 errors).

5. **Test Middleware Thoroughly:**
   - Validate middleware functionality across all routes and edge cases.

