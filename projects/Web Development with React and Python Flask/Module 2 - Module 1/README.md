```markdown
# Module 1: Fundamentals of Python and Flask  

## **Python Programming Basics – Variables and Control Structures**  

### **Introduction to Python**  
Python is a versatile, high-level programming language known for its simplicity and readability. It is widely used in web development, data analysis, artificial intelligence, and more. Python emphasizes code readability with its clean syntax, making it an excellent choice for beginners and professionals alike.  

---

### **1. Understanding Variables and Data Types**  

#### **Variables**  
Variables are containers for storing data values. Python is dynamically typed, which means you don't need to declare the type of a variable explicitly. The type is inferred at runtime based on the value assigned.  

**Example:**  
```python
# Assigning values to variables
name = "John"       # String type
age = 25            # Integer type
is_test_taker = True  # Boolean type
print(name, age, is_test_taker)
```

#### **Data Types**  
Python provides several built-in data types to work with different kinds of data:  

1. **`int`**: Represents integers.  
   ```python
   age = 25
   print(type(age))  # Output: <class 'int'>
   ```

2. **`float`**: Represents floating-point numbers.  
   ```python
   pi = 3.14
   print(type(pi))  # Output: <class 'float'>
   ```

3. **`str`**: Represents strings. Strings are sequences of characters enclosed in quotes.  
   ```python
   greeting = "Hello, World!"
   print(type(greeting))  # Output: <class 'str'>
   ```

4. **`list`**: Represents ordered collections of items. Lists can hold items of different types.  
   ```python
   scores = [90, 85, 80]
   print(scores[0])  # Output: 90
   ```

5. **`dict`**: Represents key-value pairs.  
   ```python
   user = {"name": "Alice", "score": 95}
   print(user["name"])  # Output: Alice
   ```

#### **Type Conversion**  
Type conversion allows you to convert one data type to another explicitly.  

**Example:**  
```python
# Converting int to string
age = 25
age_str = str(age)
print("Age as string:", age_str)  # Output: Age as string: 25

# Converting string to float
value = "3.5"
value_float = float(value)
print("Value as float:", value_float)  # Output: Value as float: 3.5
```

---

### **2. Writing Control Structures**  
Control structures allow you to control the flow of a program. Python offers conditional statements and loops to execute code based on specific conditions.  

#### **If-Else Statements**  
Conditional statements are used to make decisions based on certain conditions.  

**Example:**  
```python
score = 85
if score >= 75:
    print("Pass")
else:
    print("Fail")
```

**Explanation:**  
- The `if` statement checks whether the condition (`score >= 75`) is true.  
- If true, the `print("Pass")` statement is executed; otherwise, `print("Fail")` is executed.  

#### **Loops**  
Loops are used to repeat a block of code multiple times. Python supports two types of loops: `for` and `while`.  

**For Loop**  
A `for` loop iterates over a sequence (like a list or range).  

**Example:**  
```python
# Printing numbers from 0 to 4
for i in range(5):
    print(i)
```

**Explanation:**  
- The `range(5)` generates numbers from 0 to 4.  
- The loop executes 5 times, printing each number.  

**While Loop**  
A `while` loop runs as long as the condition is true.  

**Example:**  
```python
count = 0
while count < 5:
    print(count)
    count += 1
```

**Explanation:**  
- The loop starts with `count = 0` and runs until `count` is no longer less than 5.  
- The `count += 1` increments the counter in each iteration.  

**Nested Loops**  
Nested loops are loops inside other loops. They are useful for working with multidimensional data.  

**Example:**  
```python
# Nested loop example
for i in range(2):  # Outer loop
    for j in range(3):  # Inner loop
        print(f"i: {i}, j: {j}")
```

**Explanation:**  
- The outer loop runs twice (`i` takes values 0 and 1).  
- For each iteration of the outer loop, the inner loop runs three times (`j` takes values 0, 1, and 2).  

---

### **Functions and File Handling in Python**  

#### **1. Defining and Invoking Functions**  
Functions are reusable blocks of code designed to perform a specific task. They allow modular programming, making the code easier to understand and maintain.  

**Creating Functions**  
Functions are defined using the `def` keyword, followed by the function name and parentheses containing optional parameters. The body of the function contains the logic, and a `return` statement specifies the value to be returned (optional).  

**Example:**  
```python
def greet(name):
    return f"Hello, {name}!"

# Invoking the function
print(greet("John"))  # Output: Hello, John!
```

**Explanation:**  
- The function `greet` accepts one parameter, `name`.  
- It returns a formatted string greeting the user.  
- The function is called using `greet("John")`, which prints "Hello, John!".  

**Default Arguments**  
Default arguments allow functions to be called with fewer arguments than defined. If an argument is not provided, the default value is used.  

**Example:**  
```python
def test_details(name, section="Speaking"):
    print(f"Test Taker: {name}, Section: {section}")

test_details("Alice")                # Output: Test Taker: Alice, Section: Speaking
test_details("Alice", "Listening")  # Output: Test Taker: Alice, Section: Listening
```

**Explanation:**  
- The `section` parameter has a default value of `"Speaking"`.  
- If the `section` argument is not provided, the default value is used.  
- If a value is provided, it overrides the default.  

#### **2. File Handling in Python**  
Python provides built-in functions to interact with files. File handling includes operations like reading, writing, and modifying files.  

**Reading and Writing Files**  
Files are handled using the `open` function. It supports different modes like:  
- `w`: Write mode (overwrites if the file exists).  
- `r`: Read mode (default mode).  
- `a`: Append mode (adds data to the file without overwriting).  

**Example:**  
```python
# Writing to a file
with open("test_results.txt", "w") as file:
    file.write("John: 85\n")

# Reading from a file
with open("test_results.txt", "r") as file:
    content = file.read()
    print(content)
```

**Explanation:**  
- `with open(...)` ensures the file is properly closed after the operation.  
- The `write` method writes data to the file.  
- The `read` method retrieves the content of the file.  

**Working with CSV Files**  
CSV (Comma-Separated Values) files are commonly used for data storage and exchange. Python’s `csv` module simplifies reading and writing CSV files.  

**Writing to a CSV File:**  
```python
import csv

# Writing to a CSV file
with open("test_results.csv", "w", newline="") as file:
    writer = csv.writer(file)
    writer.writerow(["Name", "Score"])  # Header
    writer.writerow(["Alice", "90"])   # Data row
```

**Explanation:**  
- `csv.writer` is used to create a CSV writer object.  
- `writer.writerow` writes a single row to the file.  
- The `newline=""` ensures no extra blank lines are added.  

**Reading from a CSV File:**  
```python
import csv

# Reading from a CSV file
with open("test_results.csv", "r") as file:
    reader = csv.reader(file)
    for row in reader:
        print(row)
```

**Explanation:**  
- `csv.reader` reads the content of the file row by row.  
- The `for` loop iterates through each row, printing its content.  

**Output:**  
```plaintext
['Name', 'Score']
['Alice', '90']
```

---

### **Introduction to Python Modules**  
Python modules are pre-written pieces of code that provide additional functionality for various tasks. The standard library includes numerous modules to perform operations like interacting with the operating system, managing JSON data, and handling CSV files.  

#### **1. Standard Libraries**  

**`os` Module: Interacting with the Operating System**  
The `os` module provides a way to interact with the operating system. It allows tasks such as navigating directories, creating folders, and managing files.  

**Key Functions of `os` Module:**  
1. `os.getcwd()`: Returns the current working directory.  
2. `os.mkdir()`: Creates a new directory.  

**Example:**  
```python
import os

# Get current working directory
current_directory = os.getcwd()
print(f"Current Directory: {current_directory}")

# Create a new folder
os.mkdir("test_folder")
print("Directory 'test_folder' created.")
```

**Explanation:**  
- `os.getcwd()` retrieves the path of the current working directory.  
- `os.mkdir("test_folder")` creates a folder named `"test_folder"` in the current directory.  

**`json` Module: Working with JSON Data**  
JSON (JavaScript Object Notation) is a lightweight data format commonly used for data exchange. Python's `json` module simplifies working with JSON data, allowing conversion between Python dictionaries and JSON strings.  

**Key Functions of `json` Module:**  
1. `json.dumps()`: Converts a Python dictionary into a JSON-formatted string.  
2. `json.loads()`: Parses a JSON-formatted string back into a Python dictionary.  

**Example:**  
```python
import json

# Python dictionary
data = {"name": "Alice", "score": 90}

# Convert dictionary to JSON string
json_data = json.dumps(data)
print(f"JSON Data: {json_data}")

# Convert JSON string back to dictionary
parsed_data = json.loads(json_data)
print(f"Parsed Data: {parsed_data}")
```

**Output:**  
```plaintext
JSON Data: {"name": "Alice", "score": 90}
Parsed Data: {'name': 'Alice', 'score': 90}
```

**Explanation:**  
- `json.dumps(data)` serializes the Python dictionary into a JSON string.  
- `json.loads(json_data)` deserializes the JSON string back into a Python dictionary.  

**Applications:**  
- Reading and writing configuration files.  
- Communicating with APIs that use JSON for data exchange.  

**`csv` Module: Handling CSV File Operations**  
CSV (Comma-Separated Values) is a format used for storing tabular data. The `csv` module provides functions to read and write CSV files efficiently.  

**Key Functions of `csv` Module:**  
1. `csv.writer()`: Writes data into a CSV file.  
2. `csv.reader()`: Reads data from a CSV file.  

**Example – Writing to a CSV File:**  
```python
import csv

# Writing to a CSV file
with open("test_results.csv", "w", newline="") as file:
    writer = csv.writer(file)
    writer.writerow(["Name", "Score"])  # Write header
    writer.writerow(["Alice", 90])     # Write data row
```

**Example – Reading from a CSV File:**  
```python
import csv

# Reading from a CSV file
with open("test_results.csv", "r") as file:
    reader = csv.reader(file)
    for row in reader:
        print(row)
```

**Output:**  
```plaintext
['Name', 'Score']
['Alice', '90']
```

**Explanation:**  
- `csv.writer()` creates a writer object to add rows to the CSV file.  
- `csv.reader()` creates a reader object to iterate through the rows of the CSV file.  

**Applications:**  
- Storing and retrieving structured data.  
- Importing/exporting data between systems or tools.  

---

### **Flask Framework Basics – Setting Up and Routing**  

#### **1. Setting up a Flask Application**  
Flask is a lightweight and flexible web framework for Python. It is widely used for building web applications and APIs due to its simplicity and ease of use. Below are the steps to set up a Flask application:  

**Creating a Virtual Environment**  
A virtual environment isolates your Python project dependencies from the global environment, ensuring that your application has its own independent package versions.  

**Commands:**  
- For Linux/Mac:  
  ```bash
  python -m venv venv
  source venv/bin/activate
  ```
- For Windows:  
  ```bash
  python -m venv venv
  venv\Scripts\activate
  ```

**Explanation:**  
- `python -m venv venv`: Creates a virtual environment named `venv`.  
- `source venv/bin/activate` or `venv\Scripts\activate`: Activates the virtual environment. After activation, your terminal or command prompt will show `(venv)` as a prefix, indicating the environment is active.  

**Why Use a Virtual Environment?**  
- It prevents conflicts between dependencies of different projects.  
- Ensures your Flask application runs with the required package versions.  

**Installing Flask**  
Once the virtual environment is activated, install Flask using `pip`, the Python package manager.  

**Command:**  
```bash
pip install flask
```

**Explanation:**  
- This command installs Flask into the activated virtual environment.  
- Flask and its dependencies will be added to the `venv` directory and not to the global Python environment.  

**Verification:**  
- You can verify the installation by running:  
  ```bash
  pip show flask
  ```
  This displays details about the installed Flask package, including its version.  

**Basic Flask Application**  
After setting up the environment and installing Flask, you can create a simple Flask application.  

**Code:**  
```python
from flask import Flask  # Importing the Flask class

# Initializing the Flask application
app = Flask(__name__)

# Defining a route for the home page
@app.route("/")
def home():
    return "Welcome to the IELTS Speaking Test Platform!"

# Running the application
if __name__ == "__main__":
    app.run(debug=True)
```

**Explanation:**  
1. **Importing Flask**:  
   - `from flask import Flask`: Imports the Flask class, which is used to create the application instance.  
2. **Creating an Application Instance**:  
   - `app = Flask(__name__)`: Initializes the Flask application. The `__name__` parameter tells Flask where to look for resources like templates and static files.  
3. **Defining a Route**:  
   - `@app.route("/")`: A route decorator that maps the URL `/` to the `home` function. When a user visits the root URL (`http://127.0.0.1:5000/`), the `home` function is executed.  
   - `def home()::` The view function that returns a response to the client. In this case, it returns the string `"Welcome to the IELTS Speaking Test Platform!"`.  
4. **Running the Application**:  
   - `if __name__ == "__main__"::` Ensures the app runs only when the script is executed directly (not when imported as a module).  
   - `app.run(debug=True)`: Starts the Flask development server. The `debug=True` flag enables debug mode, which provides automatic reloading of the server when code changes and detailed error messages.  

**How to Run:**  
1. Save the code to a file, e.g., `app.py`.  
2. Run the file in the terminal or command prompt:  
   ```bash
   python app.py
   ```
3. Open a browser and navigate to `http://127.0.0.1:5000/`. You will see the message `"Welcome to the IELTS Speaking Test Platform!"`.  

**Debug Mode Note:**  
- When `debug=True`, the server automatically restarts whenever you make changes to the code. This feature is helpful during development but should not be used in a production environment for security reasons.  

---

### **Flask Routing and JSON Responses**  
Flask routing enables you to define URLs (routes) that correspond to specific functions (views). These routes determine how the application responds to client requests. Additionally, Flask provides built-in support for returning JSON responses, which is essential for building APIs.  

#### **1. Understanding Flask Routing**  
Routing is the process of mapping URLs to specific functions in a Flask application. Each route corresponds to a specific view function that handles the logic for that URL.  

**Defining Routes**  
Routes are defined using the `@app.route()` decorator. You can define static routes (e.g., `/home`) or dynamic routes with parameters (e.g., `/test/<string:test_type>`).  

**Example:**  
```python
@app.route("/test/<string:test_type>")
def test_route(test_type):
    return f"This is the {test_type} test."
```

**Explanation:**  
- `@app.route("/test/<string:test_type>")`: The `<string:test_type>` part indicates a dynamic segment in the URL. The value of `test_type` will be passed as an argument to the `test_route` function.  
- `def test_route(test_type)::` The view function receives the dynamic part of the URL as an argument.  
- `return f"This is the {test_type} test."`: Returns a response using the dynamic value.  

**Usage:**  
1. Run the application and navigate to URLs like `http://127.0.0.1:5000/test/Speaking` or `http://127.0.0.1:5000/test/Listening`.  
2. The response will be dynamically generated based on the `test_type` value, such as:  
   - `"This is the Speaking test."`  
   - `"This is the Listening test."`  

**Using HTTP Methods**  
By default, Flask routes only handle `GET` requests. To handle other HTTP methods (e.g., `POST`, `PUT`), you must specify them using the `methods` argument in the `@app.route()` decorator.  

**Example:**  
```python
from flask import request

@app.route("/submit", methods=["POST"])
def submit():
    data = request.form["name"]
    return f"Submission received from {data}."
```

**Explanation:**  
- `@app.route("/submit", methods=["POST"])`: This route handles `POST` requests sent to the `/submit` URL.  
- `request.form`: Retrieves data sent in the `POST` request body (e.g., form data).  
- `data = request.form["name"]`: Extracts the value associated with the key `"name"` from the submitted form data.  
- `return f"Submission received from {data}."`: Returns a response confirming the data received.  

**Usage:**  
1. Use an HTML form or a tool like Postman to send a `POST` request to `/submit`.  
2. Include form data with a `name` field in the request body.  
3. The response will confirm the received data, e.g., `"Submission received from Alice."`.  

#### **2. Returning JSON Responses**  
JSON (JavaScript Object Notation) is a common data format for exchanging data between a server and a client. Flask simplifies the process of returning JSON responses using the `jsonify` function.  

**Using Flask's `jsonify`**  
The `jsonify` function converts Python objects (e.g., dictionaries, lists) into JSON-formatted responses. It also sets the correct `Content-Type` header (`application/json`).  

**Example:**  
```python
from flask import jsonify

@app.route("/api/test-details")
def test_details():
    data = {"name": "Alice", "section": "Speaking", "score": 85}
    return jsonify(data)
```

**Explanation:**  
- `data = {"name": "Alice", "section": "Speaking", "score": 85}`: A Python dictionary representing the response data.  
- `return jsonify(data)`: Converts the dictionary into a JSON response.  

**Output (when accessed via a browser or API client):**  
```json
{
    "name": "Alice",
    "section": "Speaking",
    "score": 85
}
```

**Usage:**  
1. Run the application and navigate to `http://127.0.0.1:5000/api/test-details`.  
2. The browser or API client will display the JSON response.  

---

### **Additional Notes on Routing and JSON**  

1. **Dynamic Routing with Multiple Parameters:**  
   Flask allows you to define multiple dynamic segments in a route.  
   ```python
   @app.route("/test/<string:test_type>/<int:score>")
   def test_details(test_type, score):
       return f"Test: {test_type}, Score: {score}"
   ```
   **Example URL:** `http://127.0.0.1:5000/test/Speaking/85`  

2. **Returning JSON with Status Codes:**  
   You can specify a status code along with the JSON response.  
   ```python
   @app.route("/api/test-status")
   def test_status():
       return jsonify({"status": "success"}), 200  # 200 is the HTTP status code for success
   ```

3. **Error Handling with JSON Responses:**  
   Use JSON responses to handle errors consistently.  
   ```python
   @app.route("/api/error")
   def error():
       return jsonify({"error": "Something went wrong"}), 400  # 400 indicates a client error
   ```

---
