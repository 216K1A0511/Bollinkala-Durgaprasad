// When "Get OTP" is clicked, send username and email to send-otp.php
document.getElementById('getCode').addEventListener('click', function() {
  const username = document.getElementById('username').value;
  const email = document.getElementById('email').value;

  if (!username || !email) {
    displayMessage("Please enter both username and email.", "error");
    return;
  }

  // Send POST request with JSON data to send-otp.php
  fetch('send-otp.php', { // Make sure path is correct
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ username: username, email: email })
  })
  .then(response => response.text())
  .then(data => {
     displayMessage(data);
     if (data.trim() === "OTP sent successfully") {
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

// When the form is submitted, send OTP to verify-otp.php
document.getElementById('loginForm').addEventListener('submit', function(event) {
  event.preventDefault();
  const username = document.getElementById('username').value;
  const email = document.getElementById('email').value;
  const otp = document.getElementById('otp').value;

  fetch('verify-otp.php', { // Make sure path is correct
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ username: username, email: email, otp: otp })
  })
  .then(response => response.text())
  .then(data => {
     if (data.trim() === "OTP verified successfully") {
       window.location.href = 'index.php';  // Redirect to the correct home page
     } else {
       displayMessage(data, "error");
     }
  })
  .catch(error => {
     console.error('Error:', error);
     displayMessage('An error occurred while verifying OTP.', 'error');
  });
});
