<?php
//未完成

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
$storeID = $_POST['storeId'];
$disposalId = $_POST['disposalId'];
$iteml = $_POST['item'];
$qty = $_POST['qty'];
$date = $_POST['date'];

?>