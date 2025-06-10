<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    http_response_code(403);
    exit("Unauthorized");
}
include 'includes/db.php';

if (!isset($_POST['resume_id'])) {
    exit("No resume ID specified.");
}
$resume_id = intval($_POST['resume_id']);
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM saved_resumes WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $resume_id, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Success";
} else {
    http_response_code(500);
    echo "Failed to delete resume.";
}
$stmt->close();
?>
