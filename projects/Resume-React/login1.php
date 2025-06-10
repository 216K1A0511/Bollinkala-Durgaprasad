<?php
// login.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ideal Institute of Technology Login</title>
  <style>
    /* Global Styles */
    body {
      font-family: sans-serif;
      background: linear-gradient(to bottom, #1e3c72, #dfe4ea);
      margin: 0;
    }
    /* Navbar Styles */
    header {
      position: fixed;
      top: 0;
      width: 100%;
      padding: 20px 40px;
      box-sizing: border-box;
      z-index: 1000;
    }
    nav {
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }
    nav a {
      color: white;
      text-decoration: none;
      font-size: 1.2em;
      font-weight: bold;
      transition: all 0.3s ease-in-out;
    }
    nav a:hover {
      animation: bounce 0.5s;
    }
    @keyframes bounce {
      0% { transform: scale(1) translateY(0); }
      40% { transform: scale(1.1) translateY(-10px); }
      60% { transform: scale(1.1) translateY(-5px); }
      100% { transform: scale(1) translateY(0); }
    }
    /* Main Content Area */
    .main-content {
      display: flex;
      justify-content: center;
      align-items: center;
      height: calc(100vh - 80px); /* Subtract header height */
      margin-top: 80px;
    }
    /* Page Layout */
    .container {
      display: flex;
      gap: 0px;
    }
    /* Left-side informative block */
    .empty-container {
      background-color: transparent;
      padding: 40px;
      border-radius: 8px 0 0 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 350px;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    .empty-container h2 {
      color: #111111;
      font-size: 2em;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-bottom: 15px;
    }
    .empty-container p {
      font-size: 1.2em;
      color: #2c3e50;
      font-style: italic;
      font-weight: 500;
      background: rgba(255, 255, 255, 0.2);
      padding: 10px;
      border-radius: 5px;
    }
    /* Right-side login container */
    .login-container {
      background-color: #f5f4ef;
      padding: 40px;
      border-radius: 0 8px 8px 0;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 350px;
    }
    .logo {
      text-align: center;
    }
    .logo img {
      background-color: #003366;
    }
    .input-group {
      margin-bottom: 20px;
    }
    .input-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    .input-group input {
      width: calc(100% - 22px);
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .btn {
      width: 100%;
      background-color: #145a32;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 1em;
      margin-bottom: 10px;
    }
    .btn:hover {
      background-color: #117a65;
    }
    .alert {
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 4px;
      color: #fff;
    }
    .alert.error {
      background: #dc3545;
    }
    .alert.success {
      background: #28a745;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <header>
    <nav>
      <a href="admin_login.php">Admin</a>
    </nav>
  </header>
  
  <!-- Main Content -->
  <div class="main-content">
    <div class="container">
      <div class="empty-container">
        <h2>Build Your Future Today</h2>
        <p>"Your resume is your first impression—make it strong and impactful!"</p>
      </div>
      <div class="login-container">
        <div class="logo">
          <img src="imgs/collegelogo.png" alt="Ideal Institute of Technology Logo" style="width: 300px; height: 70px;">
        </div>
        <h2 style="text-align:center; margin: 40px;">Login to your account</h2>
        
        <!-- Area to display messages from server responses -->
        <div id="messageArea"></div>
        
        <form id="loginForm">
          <div class="input-group" id="userFields">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
          </div>
          <div class="input-group" id="emailFields">
            <label for="email">Email Id:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email id" required>
          </div>
          <div class="input-group" id="otpContainer" style="display: none;">
            <label for="otp">Enter OTP:</label>
            <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
          </div>
          <button type="button" class="btn" id="getCode">Get OTP</button>
          <button type="submit" class="btn" id="loginButton" style="display: none;">Log In</button>
        </form>
      </div>
    </div>
  </div>
  
  <script>
    // Function to display messages
    function displayMessage(message, type = 'success') {
      const messageArea = document.getElementById('messageArea');
      messageArea.innerHTML = '<div class="alert ' + (type === 'error' ? 'error' : 'success') + '">' + message + '</div>';
    }
    
    // When "Get OTP" is clicked, send username and email to send-otp.php
    document.getElementById('getCode').addEventListener('click', function() {
      const username = document.getElementById('username').value;
      const email = document.getElementById('email').value;
      
      if (!username || !email) {
        displayMessage("Please enter both username and email.", "error");
        return;
      }
      
      // Send POST request with JSON data to send-otp.php
      fetch('send-otp.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username: username, email: email })
      })
      .then(response => response.text())
      .then(data => {
         displayMessage(data);
         // If OTP was sent successfully, hide the username/email fields and Get OTP button; show OTP input and Log In button
         if (data.toLowerCase().includes("otp sent")) {
            document.getElementById('userFields').style.display = 'none';
            document.getElementById('emailFields').style.display = 'none';
            document.getElementById('getCode').style.display = 'none';
            document.getElementById('otpContainer').style.display = 'block';
            document.getElementById('loginButton').style.display = 'block';
         }
      })
      .catch(error => {
         console.error('Error:', error);
         displayMessage('An error occurred while sending OTP.', 'error');
      });
    });
    
    // When the form is submitted (click on "Log In"), send OTP to verify-otp.php
    document.getElementById('loginForm').addEventListener('submit', function(event) {
      event.preventDefault();
      const username = document.getElementById('username').value;
      const email = document.getElementById('email').value;
      const otp = document.getElementById('otp').value;
      
      // Send POST request with JSON data to verify-otp.php
      fetch('verify-otp.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username: username, email: email, otp: otp })
      })
      .then(response => response.text())
      .then(data => {
         if (data.trim() === "OTP verified successfully") {
           window.location.href = 'home.php';
         } else {
           displayMessage(data, "error");
         }
      })
      .catch(error => {
         console.error('Error:', error);
         displayMessage('An error occurred while verifying OTP.', 'error');
      });
    });
  </script>
</body>
</html>
