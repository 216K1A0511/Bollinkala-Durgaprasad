<?php
session_start();
// Destroy session variables
$_SESSION = array();
session_destroy();
header("Location: admin_login.php");
exit();
?>
