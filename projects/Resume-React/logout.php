<?php
session_start();
session_destroy();
header("Location: login1.php"); // Redirect to login page after logout
exit();
?>
