 <?php
// データベースの情報　
$servername = "localhost";
$username = "dbuser";
$password = "ecc";
$dbname = "food";

$conn = new mysqli($servername, $username, $password, $dbname);

//接続のチェック
if ($conn->connect_error) {
    die("アクセス失敗: " . $conn->connect_error);
}

$sql;
//フォームから送信されたデータを取得
$name = $_POST['name'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$address = $_POST['address'];
$selectedOption = $_POST['selectedOption'];

if ($selectedOption == 'store') {
    $stmt = $conn->prepare("INSERT INTO Store (STORE_NAME, STORE_TEL, STORE_EMAIL, STORE_PASSWORD, STORE_ADDRESS) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $telephone, $email, $hashedPassword, $address);
}else{
    $stmt = $conn->prepare("INSERT INTO User (USER_NAME, USER_TEL, USER_EMAIL, USER_PASSWORD, USER_ADDRESS) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $telephone, $email, $hashedPassword, $address);
}
  
if ($stmt->execute()) {
    $conn->commit();
    $message = "登録できました！";   
} else {
   $message = "登録失敗した" . $stmt->error;
}

$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>新規登録画面</title>
    <link rel="stylesheet" type="text/css" href="" />
</head>

<body>
<form id="registration-form" method="post" action="#">
    <h1><?=$message?></h1>
    
    <br>
        <a href="../login.html" class="btn btn-danger btn-lg" role="button">戻る</a>

</body>

</html>



