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

$sql;
//フォームから送信されたデータを取得
$email = $_POST['email'];
$sql = "SELECT * FROM disposal WHERE store_id = (SELECT store_id FROM store WHERE store_email = '$email')";

if ($stmt->execute()) {
    echo "登録できた！";
} else {
    echo "エラー: " . $stmt->error;
}

$stmt->close();

$conn->close();
?>