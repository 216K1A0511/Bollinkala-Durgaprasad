<?php
session_start();
include 'includes/db.php';

// Read JSON input from request
$data = json_decode(file_get_contents("php://input"), true);

// Check if required data is provided
if (!isset($data['otp']) || !isset($data['username']) || !isset($data['email'])) {
    echo "Missing data.";
    exit;
}

$enteredOTP = trim($data['otp']);
$username = trim($data['username']);
$email = trim($data['email']);

// Check if OTP exists in session and matches the entered OTP
if (isset($_SESSION['otp']) && $enteredOTP == $_SESSION['otp']) {
    // Query the users table to get the user's ID based on username and email
    $sql = "SELECT id FROM users WHERE username = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Database error: " . $conn->error;
        exit;
    }
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_logged_in'] = true;
        // Clear OTP from session as it's no longer needed
        unset($_SESSION['otp']);
        echo "OTP verified successfully";
    } else {
        echo "User not found";
    }
    $stmt->close();
} else {
    echo "Invalid OTP, please try again.";
}
?>
