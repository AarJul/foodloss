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
$store_id = isset($_SESSION['store_id']) ? $_SESSION['store_id'] : null;


// Truy vấn thông tin user dựa trên user_id
$user_id = $_SESSION['user_id'];
$userQuery = "SELECT USER_ID, USER_NAME FROM user WHERE USER_ID = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bindParam(1, $user_id);
$userStmt->execute();
$userResult = $userStmt->fetch(PDO::FETCH_ASSOC);
 
// Truy vấn thông tin store và disposal
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
            <h1>Store Name</h1>
            <button onclick="viewDetails()">Chi tiết</button>
        </div>
        <br>

        <div class="container">
            <div class="bottom-section">
                <table class="table-bordered table-hover" id="inventory">
                    <thead>
                    <tr>
                        <th onclick="sortTable(0)">
                            名前 <span class="glyphicon glyphicon-sort"></span>
                        </th>
                        <th onclick="sortTable(1)">
                            期限 <span class="glyphicon glyphicon-sort"></span>
                        </th>
                        <th onclick="sortTable(2)">
                            個数 <span class="glyphicon glyphicon-sort"></span>
                        </th>
                        <th onclick="sortTable(3)">
                            個数 <span class="glyphicon glyphicon-sort"></span>
                        </th>
                        <th onclick="sortTable(4)">
                            要求 <span class="glyphicon glyphicon-sort"></span>
                        </th>
                    </tr>
                    </thead>

                    <tbody id="inventoryBody">
                    <!-- insert code -->
                    </tbody>

                </table>
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
            </div>
        </div>
    </div>

    <footer class="custom-footer">
        <div class="container fixed-bottom">
            <div class="row">
                <div class="col-md-6">
                    <h5>About Us</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
                <div class="col-md-6">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li>Phone: 123-356-7890</li>
                        <li>Email: info@example.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
    <script>
        function logout() {
            window.location.href = "login.php";
        }
    </script>
</body>
</html>