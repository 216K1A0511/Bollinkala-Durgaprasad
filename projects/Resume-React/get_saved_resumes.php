<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    http_response_code(403);
    exit("Unauthorized");
}
include 'includes/db.php';
$user_id = $_SESSION['user_id'];

$result = $conn->query("SELECT id, created_at FROM saved_resumes WHERE user_id = $user_id ORDER BY created_at DESC");
if($result->num_rows > 0){
    echo "<ul class='list-group'>";
    while($row = $result->fetch_assoc()){
        echo "<li class='list-group-item'><a href='view_resume.php?id=".$row['id']."'>Resume saved on ".$row['created_at']."</a></li>";
    }
    echo "</ul>";
} else {
    echo "No saved resumes.";
}
?>