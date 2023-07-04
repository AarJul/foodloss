<?php
session_start();

if (!isset($_SESSION['store_email'])) {
    exit;
}

$email = $_SESSION['store_email'];

$servername = "localhost";
$username = "dbuser";
$password = "ecc";
$dbname = "food";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin mới từ form
$newStoreName = $_POST['newStoreName'];
$newStoreTel = $_POST['newStoreTel'];
$newStoreAddress = $_POST['newStoreAddress'];

// Câu lệnh SQL update dữ liệu
$sql = "UPDATE STORE SET STORE_NAME = ?, STORE_TEL = ?, STORE_ADDRESS = ? WHERE STORE_EMAIL = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $newStoreName, $newStoreTel, $newStoreAddress, $email);
$stmt->execute();

// Kiểm tra kết quả update
if ($stmt->affected_rows > 0) {
    $_SESSION['update_success'] = true;
    header("Location: QUAN_store_info.php"); // Điều hướng về trang gốc
    exit();
} else {
    $_SESSION['update_success'] = false;
    header("Location: QUAN_store_info.php"); // Điều hướng về trang gốc
    exit();
}


$stmt->close();
$conn->close();
?>
