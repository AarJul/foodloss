<?php
session_start();
require_once dirname(__FILE__) . '/function/auto_login.php';
require_once dirname(__FILE__) . '/function/db_connection.php';

// Connect to the database
$conn = connection();

// Function to check login and redirect users
function login()
{
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
                echo "User does not exist!";
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
    <link rel="stylesheet" href="./css/register.css" />
    <link rel="stylesheet" href="./css/color.css" />
    <link rel="stylesheet" href="./css/footer.css" />
    <link rel="stylesheet" href="./css/navbar.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">

    <title>Login Page</title>
</head>
<body>
<nav class="navbar navbar-inverse fixed-top">
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
        <form action="login.php" id="form-login" method="POST">
            <h1 class="form-heading">Sign In</h1>
            <div class="form-group">
                <i class="far fa-user"></i>
                <input type="email" name="email" class="form-input" placeholder="Email" required /> 
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-input" placeholder="Password" required />
                <div id="eye">
                    <i class="far fa-eye"></i>
                </div>
            </div>
            <div class="btn btn-primary">
              <button type="submit" class="btn btn-primary form-submit" type="submit" name="login">Log In</button>
            </div>
        </form>
        
    </div>
    <footer class="custom-footer ">
      <div class="container fixed-bottom">
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
<script src="js/app.js"></script>
</html>