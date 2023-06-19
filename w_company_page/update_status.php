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

if (isset($_POST['disposalId']) && isset($_POST['status'])) {
    $disposalId = $_POST['disposalId'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE disposal SET STATUS = ? WHERE DISPOSAL_ID = ?");
    $stmt->bind_param("si", $status, $disposalId);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>
