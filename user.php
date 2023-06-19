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

$user_id = $_SESSION['user_id'];

// Truy vấn thông tin user dựa trên user_id
$userQuery = "SELECT USER_ID, USER_NAME FROM user WHERE USER_ID = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bindParam(1, $user_id);
$userStmt->execute();
$userResult = $userStmt->fetch(PDO::FETCH_ASSOC);

if ($userResult) {
    $user_id = $userResult['USER_ID'];
    $user_name = $userResult['USER_NAME'];
} else {
    // Xử lý trường hợp không tìm thấy thông tin người dùng
    // Điều hướng hoặc hiển thị thông báo lỗi
    header("Location: error.php");
    exit();
}

mysqli_close($conn);
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
            <h1>Store Name</h1>
            <button onclick="viewDetails()">Chi tiết</button>
        </div>
        <div class="bottom-section">
            <table>
                <tr>
                    <th>Tên</th>
                    <th>Thời Hạn</th>
                    <th>Số Lượng</th>
                    <th>Yêu Cầu</th>
                </tr>
                <!-- <?php
                // Hiển thị thông tin hàng hóa của người dùng
                // while ($row = mysqli_fetch_assoc($result)) {
                //     echo "<tr>";
                //     echo "<td>" . $row['Ten'] . "</td>";
                //     echo "<td>" . $row['ThoiHan'] . "</td>";
                //     echo "<td>" . $row['SoLuong'] . "</td>";
                //     echo "<td>" . $row['YeuCau'] . "</td>";
                //     echo "</tr>";
                // }
                ?> -->
            </table>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>
