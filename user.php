<?php
session_start();
require_once dirname(__FILE__) . '/function/db_connection.php';

$conn = connection();
$message = '';

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

//kiểm tra xem khóa có tồn tại hay không
$store_id = isset($_SESSION['store_id']) ? $_SESSION['store_id'] : null; 
$user_id = $_SESSION['user_id'];

// Truy vấn thông tin user dựa trên user_id
$userQuery = "SELECT USER_ID, USER_NAME FROM user WHERE USER_ID = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bindParam(1, $user_id);
$userStmt->execute();
$userResult = $userStmt->fetch(PDO::FETCH_ASSOC);

$storeQuery = "SELECT s.STORE_ID, s.STORE_NAME, d.ITEM, d.QTY, d.DATE
                FROM store s
                LEFT JOIN disposal d ON s.STORE_ID = d.STORE_ID";
$storeStmt = $conn->prepare($storeQuery);
$storeStmt->execute();
$storeResult = $storeStmt->fetchAll(PDO::FETCH_ASSOC);


if ($userResult) {
    $user_id = $userResult['USER_ID'];
    $user_name = $userResult['USER_NAME'];
} else {
    // Xử lý trường hợp không tìm thấy thông tin người dùng
    // Điều hướng hoặc hiển thị thông báo lỗi
    header("Location: error.php");
    exit();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hàng tồn kho</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
</head>

<body>
    <div class="container">
        <div class="top-right-section">
            <h2>User ID: <span id="userid">
                    <?php echo $user_id; ?>
                </span></h2>
            <h2>Tên: <span id="username">
                    <?php echo $user_name; ?>
                </span></h2>
            <button onclick="logout()">Logout</button>
            <a href="confirm.php"><button>Xác nhận đơn hàng</button></a>
        </div>
        <div class="center-section">
            <?php foreach ($storeResult as $store): ?>
                <div class="store">
                    <h2>
                        <?php echo $store['STORE_NAME']; ?>
                    </h2>
                    <table>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Date</th>
                        </tr>
                        <?php if (!empty($store['ITEM'])): ?>
                            <tr>
                                <td>
                                    <?php echo $store['ITEM']; ?>
                                </td>
                                <td>
                                    <?php echo $store['QTY']; ?>
                                </td>
                                <td>
                                    <?php echo $store['DATE']; ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No disposal data</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>

        <script src="script.js"></script>
        <script>
            function logout() {
                window.location.href = "login.php";
            }
        </script>
</body>

</html>