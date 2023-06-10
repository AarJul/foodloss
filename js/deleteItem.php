<?php
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
    // 削除が成功した場合はステータスコード200 (OK)を返す
    http_response_code(200);
} else {
    // 削除が失敗した場合はステータスコード500 (Internal Server Error)を返し、エラーメッセージを出力する
    http_response_code(500);
    echo 'SQLエラー: ' . $stmt->errorInfo()[2];
}
?>
