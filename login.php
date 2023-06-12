<?php
session_start();
//require_once dirname(__FILE__) . '/function/auto_login.php';
require_once dirname(__FILE__) . '/function/db_connection.php';

// Connect to the database
$conn = connection();
$message = '';

// Function to check login and redirect users
function login()
{

  // Check if the "Remember Me" checkbox is checked
  if (isset($_POST['pass_save'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Store the email and password in the session
    $_SESSION['remember_email'] = $email;
    $_SESSION['remember_password'] = $password;
  } else {
    // If the checkbox is not checked, unset the session variables
    unset($_SESSION['remember_email']);
    unset($_SESSION['remember_password']);
    unset($_SESSION['auto_login_expiration']);
    unset($_SESSION['logout']);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!empty($email) && !empty($password)) {
      $conn = connection();

      // Query the store table
      $storeQuery = "SELECT * FROM store WHERE STORE_EMAIL = :email";
      $storeStmt = $conn->prepare($storeQuery);
      $storeStmt->bindParam(':email', $email);
      $storeStmt->execute();
      $storeResult = $storeStmt->fetch(PDO::FETCH_ASSOC);

      // Query the user table
      $userQuery = "SELECT * FROM user WHERE USER_EMAIL = :email";
      $userStmt = $conn->prepare($userQuery);
      $userStmt->bindParam(':email', $email);
      $userStmt->execute();
      $userResult = $userStmt->fetch(PDO::FETCH_ASSOC);

      if ($storeResult) {
        // User with email exists in the store table
        // Check the password
        if (count($storeResult) > 0 && password_verify($password, $storeResult['STORE_PASSWORD'])) {
          // Successful login with store account
          // Save information to session or perform other actions
          $_SESSION['user_id'] = $storeResult['STORE_ID'];
          header("Location: store.php");
          exit();
        } else {
          echo "Incorrect password!";
        }
      } elseif ($userResult) {
        // User with email exists in the user table
        // Check the password
        if (count($userResult) > 0 && password_verify($password, $userResult['USER_PASSWORD'])) {
          // Successful login with user account
          // Save information to session or perform other actions
          $_SESSION['user_id'] = $userResult['USER_ID'];
          header("Location: user.php");
          exit();
        } else {
          echo "Incorrect password!";
        }
      } else {
        $message = 'User does not exist!';
      }

      $conn = null;
    } else {
      echo "Please enter email and password!";
    }
  }
}

// Call the login function
login();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" href="css/reset.css">-->
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">

  <title>Login Page</title>
</head>

<body>
  <?php require 'partials/header.php' ?>
  <?php if (!empty($message)): ?>
    <p>
      <?= $message ?>
    </p>
  <?php endif; ?>

  <h1>Login</h1>
  <span>or <a href="register.html">SignUp</a></span>

  <form action="login.php" method="POST">
    <input name="email" type="text" placeholder="Enter your email">
    <input name="password" type="password" placeholder="Enter your Password">
    <div class="relative mb-5 mx-auto md:w-3/4">
      <input type="checkbox" name="pass_save" value="true">
      <label for="pass_save">Remember Me</label>
    </div>
    <input type="submit" value="Submit">
  </form>
</body>

</html>