<?php
session_start();
require_once dirname(__FILE__) . '/../function/auto_login.php';
require_once dirname(__FILE__) . '/../function/db_connection.php';

// Connect to the database
$db = connection();

// Function to handle user login
function user_login($Email, $password)
{
  $db = connection();

  // Check login credentials in the store table
  $store_query = "SELECT * FROM store WHERE STORE_EMAIL = :Email";
  $store_stmt = $db->prepare($store_query);
  $store_stmt->bindParam(':Email', $Email);
  $store_stmt->execute();

  // Check login with store information
  if ($store_stmt->rowCount() > 0) {
    $store = $store_stmt->fetch();

    // Verify password
    if (password_verify($password, $store['STORE_PASSWORD'])) {
      // Successful login with store account
      // Save information to session or perform other actions
      // Redirect to the store page
      header("Location: store.php");
      exit;
    } else {
      echo "Incorrect password!";
      return;
    }
  }

  // Check login credentials in the user table
  $user_query = "SELECT * FROM user WHERE USER_EMAIL = :Email";
  $user_stmt = $db->prepare($user_query);
  $user_stmt->bindParam(':Email', $Email);
  $user_stmt->execute();

  // Check login with user information
  if ($user_stmt->rowCount() > 0) {
    $user = $user_stmt->fetch();

    // Verify password
    if (password_verify($password, $user['USER_PASSWORD'])) {
      // Successful login with user account
      // Save information to session or perform other actions
      // Redirect to the user page
      header("Location: user.php");
      exit;
    } else {
      echo "Incorrect password!";
      return;
    }
  }

  echo "Email or phone number does not exist!";
}

// Perform login if data is submitted from the form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['Email'];
  $password = $_POST['password'];

  user_login($username, $password);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">

    <title>Login Page</title>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">OpenSeaS</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            >Page 1 <span class="caret"></span
          ></a>
          <ul class="dropdown-menu">
            <li><a href="#">Page 1-1</a></li>
            <li><a href="#">Page 1-2</a></li>
            <li><a href="#">Page 1-3</a></li>
          </ul>
        </li>
        <li><a href="#">Page 2</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="Register.html"
            ><span class="glyphicon glyphicon-user"></span> 新規登録</a
          >
        </li>
        <li>
          <a href="login.html"
            ><span class="glyphicon glyphicon-log-in"></span> ログイン</a
          >
        </li>
      </ul>
    </div>
  </nav>

    <div id="wrapper">
        <form action="" id="form-login">
            <h1 class="form-heading">Sign In</h1>
            <div class="form-group">
                <i class="far fa-user"></i>
                <input type="text" name="Email" id="Email" class="form-input" placeholder="Email" required /> 
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" class="form-input" placeholder="Password" required />
                <div id="eye">
                    <i class="far fa-eye"></i>
                </div>
            </div>
            <div class="btn btn-primary">
              <button type="submit" class="btn btn-primary form-submit" type="submit" name="login">Log In</button>
            </div>
            <!-- <input type="submit" value="Log In" class="form-submit"> -->
            <div class="forgot-password">
                <a href="#">Forgot password?</a>
            </div>
            <div class="register-link">
            Don't have an account? <a href="#">Register here</a>
            </div>
        </form>
        
    </div>
    <footer class="custom-footer ">
      <div class="container-fixed-bottom">
        <div class="row">
          <div class="col-md-6">
            <h5>About Us</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          </div>
          <div class="col-md-6">
            <h5>Contact</h5>
            <ul class="list-unstyled">
              <li>Phone: 123-456-7890</li>
              <li>Email: info@example.com</li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="../js/app.js"></script>
</html>