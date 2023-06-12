<?php

//完成

// POSTリクエストからdisposalIdを取得する
$disposalId = $_POST['disposalId'];

// データベースへの接続情報
$servername = "localhost";
$username = "dbuser";
$password = "ecc";
$dbname = "food";

// データベースに接続する
$db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);

// データを削除するためのSQL文を準備する
$sql = 'DELETE FROM disposal WHERE DISPOSAL_ID = :disposalId';
$stmt = $db->prepare($sql);
$stmt->bindParam(':disposalId', $disposalId);

// SQL文を実行する
if ($stmt->execute()) {
    // Commit thay đổi vào cơ sở dữ liệu
    $db->commit();
    // Trả về mã trạng thái 200 (OK)
    http_response_code(200);
} else {
    // Lệnh SQL thất bại, rollback các thay đổi (nếu có)
    $db->rollback();
    // Trả về mã trạng thái 500 (Internal Server Error) và hiển thị thông báo lỗi
    http_response_code(500);
    echo 'SQL Error: ' . $stmt->errorInfo()[2];
}
?>
