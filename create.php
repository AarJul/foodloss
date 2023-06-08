<?php

session_start();
if (!isset($_SESSION['name']) || !$_SESSION['name']) {
    header('Location:login.php');
    exit;
}
require_once dirname(__FILE__) . '/function/db_connection.php';
require_once dirname(__FILE__) . '/function/select.php';

$message = "";

class CreateAccount
{
    // ユーザーのアカウントを作成する
    public function userCreateAccount()
    {
        if (isset($_POST['user_submit'])) {
            // 入力されたデータを処理する
            // $user_id = $_POST["user_id"];
            $user_name = $_POST["user_name"];
            $user_tel = $_POST["user_tel"];
            $user_address = $_POST["user_address"];
            $user_email = $_POST["user_email"];
            $user_password = $_POST["user_password"];
            $user_password_conf = $_POST["user_password_conf"];
        }
        create_user_account($user_name, $user_tel, $user_address, $user_email, $user_password, $user_password_conf);
    }

    public function storeCreateAccount()
    // 職員のアカウントを作成する
    {
        if (isset($_POST['store_submit'])) {
            $store_name = $_POST["store_name"];
            $store_tel = $_POST["store_tel"];
            $store_address = $_POST["store_address"];
            $store_email = $_POST["store_email"];
            $store_password = $_POST["store_password"];
            $store_password_conf = $_POST["store_password_conf"];
        }
        create_store_account($store_name, $store_tel, $store_address, $store_email, $store_password, $store_password_conf);
    }
}

$action = $_GET['action'] ?? 'defaultAction';
$CreateAccount = new CreateAccount();
if (method_exists($CreateAccount, $action)) {
    $CreateAccount->$action();
}

// ユーザーのアカウント作成
function create_user_account($user_name, $user_tel, $user_address, $user_email, $user_password, $user_password_conf)
{
    // データベースに接続
    $db = connection();

    // Password Check
    if ($user_password != $user_password_conf) {
        $message = "パスワードが一致しません";
        setcookie("error", $message, time() + 60);
        exit;
    } else {
        // データベースに同じID or eemailが存在しないことを確認する
        $stmt = $db->prepare("SELECT COUNT(*) FROM user WHERE user_email = ?");
        $stmt->execute([$user_email]);
        $count = $stmt->fetch(PDO::FETCH_COLUMN);
    }


    if ($count > 0) {
        $message = "メールアドレスが既に使用されています。別のメールアドレスを使用してください。";
        setcookie("error", $message, time() + 60);
        exit;
    } else {
        // Hash password
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

        // トランザクション開始
        $db->beginTransaction();
        $stmt = $db->prepare("INSERT INTO user (user_name, user_pass , user_tel, user_address, user_email) VALUES (?,?,?,?,?)");

        try {
            $stmt->execute([$user_name, $hashed_password, $user_tel, $user_address, $user_email]);
            $db->commit();
        } catch (PDOException $e) {
            $db->rollback();
            $message = $e->getMessage();
            setcookie("error", $message, time() + 60);
            exit;
        } finally {
            header("location: create_account.php");
            $db = null;
        }
        exit;
    }
}

// 職員のアカウント作成
function create_store_account($store_name, $store_tel, $store_address, $store_email, $store_password, $store_password_conf)
{
    // データベースに接続
    $db = connection();
    // Password Check
    if ($store_password != $store_password_conf) {
        $message = "パスワードが一致しません";
        setcookie("error", $message, time() + 60);
        exit;
    } else {
        // データベースに同じID or eemailが存在しないことを確認する
        $stmt = $db->prepare("SELECT COUNT(*) FROM store WHERE store_email = ?");
        $stmt->execute([$store_email]);
        $count = $stmt->fetch(PDO::FETCH_COLUMN);
    }

    if ($count > 0) {
        $message = "メールアドレスが既に使用されています。別のメールアドレスを使用してください。";
        setcookie("error", $message, time() + 60);
        exit;
    } else {
        // Hash password
        $hashed_password = password_hash($store_password, PASSWORD_DEFAULT);

        // トランザクション開始
        $db->beginTransaction();
        $stmt = $db->prepare("INSERT INTO store (store_name, store_pass , store_tel, store_address, store_email) VALUES (?,?,?,?,?)");
        try {
            $stmt->execute([$store_name, $hashed_password, $store_tel, $store_address, $store_email]);
            $db->commit();
        } catch (PDOException $e) {
            $db->rollback();
            $error = $e->getMessage();
            setcookie("error", $error, time() + 60);
            return false;
        } finally {
            $db = null;
            header("location: create_account.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>新規登録画面</title>
    <link rel="stylesheet" href="css/register.css" />
    <link rel="stylesheet" href="css/color.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/navbar.css" />

    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  </head>

  <body>
    <div class="container-fluid">
      <nav class="navbar navbar-inverse fixed-top">
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
          <li id="user">
            <a href="login.html"
              ><span class="glyphicon glyphicon-log-in"></span> ログイン</a
            >
          </li>
        </ul>
      </nav>

      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3 mt-5">
            <form id="registration-form" method="post" action="Register.php">
              <div class="form-group form-group-lg">
                <label for="user_id">名前</label>
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  name="name"
                  placeholder="名前を入力"
                  required
                />
              </div>
              <div class="form-group form-group-lg">
                <label for="Phone">電話番号</label>
                <input
                  type="tel"
                  class="form-control"
                  id="telephone"
                  name="telephone"
                  placeholder="電話番号を入力"
                  required
                />
              </div>
              <div class="form-group form-group-lg">
                <label for="email-input">メール</label>
                <input
                  type="email"
                  class="form-control"
                  id="email-input"
                  name="email"
                  placeholder="メールアドレスを入力"
                  required
                />
              </div>
              <div class="form-group form-group-lg">
                <label for="password-input">パスワード</label>
                <input
                  type="password"
                  class="form-control"
                  id="password-input"
                  name="password"
                  placeholder="パスワードを入力"
                  required
                />
              </div>
              <div class="form-group form-group-lg">
                <label for="address-input">住所</label>
                <input
                  type="text"
                  class="form-control"
                  id="address-input"
                  name="address"
                  placeholder="住所を入力"
                  required
                />
              </div>
              <div class="form-group form-group-lg">
                <label for="user-type">ユーザータイプ</label>
                <div class="dropdown">
                  <button
                    class="btn btn-default dropdown-toggle btn-lg"
                    type="button"
                    data-toggle="dropdown"
                    id="ddown"
                  >
                    --選択-- <span class="caret"></span>
                  </button>

                  <ul class="dropdown-menu">
                    <li>
                      <a href="#" onclick="selectOption('user', 'ユーザー側 ')"
                        >ユーザー側</a
                      >
                    </li>
                    <li>
                      <a href="#" onclick="selectOption('store', 'ストア側 ')"
                        >ストア側</a
                      >
                    </li>
                  </ul>
                </div>
                <input
                  type="text"
                  id="store-code"
                  class="form-control"
                  placeholder="ストアコード"
                />
              </div>

              <!-- Hidden input field to store the selected option -->
              <input type="hidden" id="selectedOption" name="selectedOption" />

              <div id="response"></div>

              <!-- fixing -->
              <input
                type="submit"
                class="btn btn-success btn-lg"
                value="登録"
              />
              <a
                href="../Login/login.html"
                class="btn btn-info btn-lg"
                role="button"
                >戻る</a
              >
            </form>
          </div>
        </div>
      </div>
    </div>
    <footer class="custom-footer">
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

    <script>
      function selectOption(option, selectedText) {
        document.getElementById("selectedOption").value = option;
        document.getElementById("ddown").innerHTML =
          selectedText + '<span class="caret"></span>';
        let storeCodeInput = document.getElementById("store-code");
        if (option === "store") {
          storeCodeInput.style.display = "block"; // Show the input field
        } else {
          storeCodeInput.style.display = "none"; // Hide the input field
        }
      }
      window.onload = function () {
        var storeCodeInput = document.getElementById("store-code");
        storeCodeInput.style.display = "none";
      };
    </script>
  </body>
</html>