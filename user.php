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

// Kiểm tra xem khóa có tồn tại hay không
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="stylesheet" href="css/reset.css"/>
    <link rel="stylesheet" href="css/login.css"/>
    <link rel="stylesheet" href="css/footer.css"/>
    <link rel="stylesheet" href="css/navbar.css"/>
    <link rel="stylesheet" type="text/css" href="./css/user.css">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <title>Quản lý hàng tồn kho</title>
</head>
<body>
<div class="container-fluid">
    <nav class="navbar navbar-inverse navbar-fixed-top">

        <div class="navbar-header">
            <a class="navbar-brand" href="#">OpenSeaS</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Page 1-1</a></li>
                    <li><a href="#">Page 1-2</a></li>
                    <li><a href="#">Page 1-3</a></li>
                </ul>
            </li>
            <li><a href="#">Page 2</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="../w_Account_Register/Register.html"><span class="glyphicon glyphicon-user"></span>
                    新規登録</a>
            </li>
            <li>
                <a href="login.html"><span class="glyphicon glyphicon-log-in"></span> ログイン</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <div class="top-right-section">
            <h2>User ID: <span id="userid"><?php echo $user_id; ?></span></h2>
            <h2>Tên: <span id="username"><?php echo $user_name; ?></span></h2>
            <button onclick="logout()">Logout</button>
            <a href="confirm.php">
                <button>Xác nhận đơn hàng</button>
            </a>
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
