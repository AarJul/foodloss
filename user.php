<?php
session_start();
// Kết nối với cơ sở dữ liệu và thực hiện truy vấn
require_once dirname(__FILE__) . '/function/db_connection.php';

$conn = connection();
$message = '';
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
            <h2>User ID: <span id="userid"></span></h2>
            <h2>Tên: <span id="username"></span></h2>
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
                <?php
                // Kết nối với cơ sở dữ liệu và truy vấn dữ liệu
                // Lặp qua kết quả và hiển thị trong bảng
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['Ten'] . "</td>";
                    echo "<td>" . $row['ThoiHan'] . "</td>";
                    echo "<td>" . $row['SoLuong'] . "</td>";
                    echo "<td>" . $row['YeuCau'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>