<?php
session_start();
$_SESSION = array(); // Clear session variables
session_destroy();   // Destroy the session data
header("Location: Login.php"); // Redirect to login
exit;
?>