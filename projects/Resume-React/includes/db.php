<?php
// db.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resume_builder";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
