<?php
// データベースの情報
$servername = "localhost";
$username = "dbuser";
$password = "ecc";
$dbname = "food";

$conn = new mysqli($servername, $username, $password, $dbname);

// 接続のチェック 
if ($conn->connect_error) {
    die("アクセス失敗: " . $conn->connect_error);
}

$stmt1 = $conn->prepare("SELECT * FROM store");
$stmt1->execute();
$store_info = $stmt1->get_result();

// Storeデータを配列に格納
$store_rows = array();
while ($store_row = $store_info->fetch_assoc()) {
    $store_rows[$store_row['STORE_ID']] = $store_row['STORE_NAME'];
}

$stmt2 = $conn->prepare("SELECT * FROM disposal");
$stmt2->execute();
$disposal_info = $stmt2->get_result();

// Storeごとのデータを配列に格納
$store_data = array();
while ($disposal_row = $disposal_info->fetch_assoc()) {
    $store_id = $disposal_row['STORE_ID'];
    if (!isset($store_data[$store_id])) {
        $store_data[$store_id] = array();
    }
    $store_data[$store_id][] = $disposal_row;
}

// ステータスの更新処理
if (isset($_POST['statusChange'])) {
    $disposalId = $_POST['disposalId'];
    $status = $_POST['status'];

    $stmt3 = $conn->prepare("UPDATE disposal SET STATUS = ? WHERE DISPOSAL_ID = ?");
    $stmt3->bind_param("si", $status, $disposalId);
    $stmt3->execute();
    $stmt3->close();

    // Redirect to the main page after updating the status
    header("Location: statusdisposalpage.php");
    exit(); // Make sure to exit after the redirect
}

$stmt2->close();
$stmt1->close();
$conn->close();
?>