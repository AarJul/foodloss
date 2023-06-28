<?php
session_start();

// Clear session variables
unset($_SESSION['user_id']);
unset($_SESSION['store_id']);
unset($_SESSION['remember_email']);
unset($_SESSION['remember_password']);
unset($_SESSION['auto_login_expiration']);
unset($_SESSION['logout']);

// Redirect to the login page
header("Location: ../login.php");
exit();
?>
