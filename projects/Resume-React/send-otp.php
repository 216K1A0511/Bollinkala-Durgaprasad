<?php
session_start();
include 'includes/db.php'; // Database connection file
require 'vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Read JSON input from request
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['username']) || !isset($data['email'])) {
    echo "Username and email are required.";
    exit;
}

$username = trim($data['username']);
$email = trim($data['email']);

// Check if user exists in the database
$query = "SELECT * FROM users WHERE username = ? AND email = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo "Database error: " . $conn->error;
    exit;
}
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Invalid username or email.";
    exit;
}

// User exists; generate a 6-digit OTP
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
session_write_close();  // Close session to prevent conflicts

// Set up PHPMailer to send OTP
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';       
    $mail->SMTPAuth   = true;
    $mail->Username   = 'idealresumebuilder@gmail.com';  
    $mail->Password   = 'pljp hwwh orxl fpjj';  // Use an App Password, not your real password!
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('idealresumebuilder@gmail.com', 'Resume Builder');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Your OTP Code";
    $mail->Body    = "Your OTP code is: <strong>$otp</strong>";
    $mail->AltBody = "Your OTP code is: $otp";

    $mail->send();
    echo "OTP sent successfully";
} catch (Exception $e) {
    echo "Failed to send OTP. Mailer Error: " . $mail->ErrorInfo;
}
$stmt->close();
?>
