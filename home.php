<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/reset.css">-->
    <link rel="stylesheet" href="css/home.css">
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
          <a href="login.php"
            ><span class="glyphicon glyphicon-log-in"></span> ログイン</a
          >
        </li>
      </ul>
    </div>
  </nav>

    <!-- <div id="wrapper">
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
        
    </div> -->
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
<script src="js/app.js"></script>
</html>