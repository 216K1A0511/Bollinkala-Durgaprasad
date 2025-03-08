#_assignment 2_#
# User Registration and Retrieval API using Flask

This project provides a basic API to handle user registration and retrieval using Flask. User data is stored in memory for this assignment, setting the groundwork for more advanced database operations.

## Table of Contents
- [Prerequisites](#prerequisites)
- [Setup Instructions](#setup-instructions)
  - [Installing Flask](#installing-flask)
  - [Running the Application](#running-the-application)
- [API Endpoints](#api-endpoints)
  - [Register a User](#register-a-user)
  - [Retrieve a User](#retrieve-a-user)
- [Testing the Application](#testing-the-application)

## Prerequisites
- Python 3.x
- Virtual Environment (recommended)

## Setup Instructions

### Installing Flask

1. **Clone the Repository**
   
   Clone the project repository to your local machine.

2. **Create and Activate a Virtual Environment**
   
   - On Windows:
     ```sh
     python -m venv venv
     venv\Scripts\activate
     ```
   
   - On macOS/Linux:
     ```sh
     python3 -m venv venv
     source venv/bin/activate
     ```

3. **Install Flask**
   
   With the virtual environment activated, install Flask using pip:
   ```sh
   pip install flask
   ```

### Running the Application

1. **Create the Application File**
   
   In the project directory, create a file named `app.py`.

2. **Write the Application Code**
   
   Initialize Flask and define the routes for registration and retrieval.

3. **Run the Flask Development Server**
   
   Navigate to the project directory and start the server:
   ```sh
   flask run
   ```

## API Endpoints

### Register a User
- **URL:** `/register`
- **Method:** `POST`
- **Description:** Registers a new user by accepting user details in the request body.
- **Request Body:**
  ```json
  {
    "username": "example_username",
    "name": "John Doe",
    "email": "john.doe@example.com"
  }
  ```
- **Response:**
  - **Success:**
    ```json
    {
      "message": "User registered successfully."
    }
    ```
  - **Failure (Username already exists):**
    ```json
    {
      "error": "Username already exists."
    }
    ```

### Retrieve a User
- **URL:** `/users/<username>`
- **Method:** `GET`
- **Description:** Retrieves details of an existing user by username.
- **Response:**
  - **Success:**
    ```json
    {
      "username": "example_username",
      "name": "John Doe",
      "email": "john.doe@example.com"
    }
    ```
  - **Failure (User not found):**
    ```json
    {
      "error": "User not found."
    }
    ```

## Testing the Application

### Run the Flask Development Server
Start the development server from the project directory:
```sh
flask run
```

### Test Registration Endpoint
Use an API testing tool like Postman to send a `POST` request to `/register` with user details.

### Test Retrieval Endpoint
Use an API testing tool like Postman to send a `GET` request to `/users/<username>` with an existing username.


