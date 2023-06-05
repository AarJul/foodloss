<?php
// データベースの情報　
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

$conn = new mysqli($servername, $username, $password, $dbname);

//接続のチェック
if ($conn->connect_error) {
    die("アクセス失敗: " . $conn->connect_error);
}

//フォームから送信されたデータを取得
$name = $_POST['name'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['address'];

//SQL文を作成
$sql = "INSERT INTO USER (USER_NAME, USER_TEL, USER_EMAIL, USER_PASSWORD, USER_ADDRESS) 
        VALUES ('$name', '$telephone', '$email', '$password', '$address')";

//トランザクション開始
if ($conn->query($sql) === TRUE) {
    echo "登録成功";
} else {
    echo "エラー: " . $sql . "<br>" . $conn->error;
}

//トランザクション終了
$conn->close();
?>



