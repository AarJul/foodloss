<?php
session_start();
require_once dirname(__FILE__) . '/function/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    // Lấy thông tin từ yêu cầu AJAX
    $storeId = $_POST['store_id'];
    $quantity = $_POST['quantity'];

    // Cập nhật số lượng trong cơ sở dữ liệu
    $conn = connection();
    $updateQuery = "UPDATE disposal SET QTY = QTY - ? WHERE DISPOSAL_ID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bindParam(1, $quantity);
    $updateStmt->bindParam(2, $storeId);
    $updateStmt->execute();
    $conn ->commit();
    $conn = null;

}
?>
