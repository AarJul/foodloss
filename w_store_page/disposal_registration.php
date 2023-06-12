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
$iteml = $_POST['item'];
$qty = $_POST['qty'];
$date = $_POST['date'];

// Chuẩn bị truy vấn SQL để chèn dữ liệu vào bảng
$sql = "INSERT INTO disposal (storeID, item, qty, date) VALUES ('$storeID', '$item', '$qty', '$date')";

// Thực thi truy vấn và kiểm tra kết quả
if ($conn->query($sql) === TRUE) {
    echo "Dữ liệu đã được chèn thành công vào bảng.";
} else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
}

?>