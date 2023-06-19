<?php
session_start();
require_once dirname(__FILE__) . '/function/db_connection.php';

$conn = connection();
$message = '';

<<<<<<< HEAD
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
=======
>>>>>>> d65e6fb51f886b9602b5b615cdc024715a258f44
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hàng tồn kho</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./css/user.css">
    <link rel="stylesheet" href="./css/footer.css" />
    <link rel="stylesheet" href="./css/navbar.css" />
    <link rel="stylesheet" href="./css/storeInvnt.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-inverse fixed-top">
        <div class="container-fluid">
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
                    <a href="Register.html"><span class="glyphicon glyphicon-user"></span> 新規登録</a>
                </li>
                <li>
                    <a href="login.html"><span class="glyphicon glyphicon-log-in"></span> ログイン</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
<<<<<<< HEAD
        <div class="top-right-section">
            <h2>User ID: <span id="userid">
                    <?php echo $user_id; ?>
                </span></h2>
            <h2>Tên: <span id="username">
                    <?php echo $user_name; ?>
                </span></h2>
            <button onclick="logout()">Logout</button>
            <a href="confirm.php"><button>Xác nhận đơn hàng</button></a>
=======
        <div class="left-section">
            <h2>User ID: <span id="userid"></span></h2>
            <h2>Tên: <span id="username"></span></h2>
        </div>
        <div class="top-right-section">
            <a href="confirm.php" class="confirm-button">注文済物を確認</a>
>>>>>>> d65e6fb51f886b9602b5b615cdc024715a258f44
        </div>
        <div class="center-section">
            <h1>Store Name</h1>
            <button onclick="viewDetails()">Chi tiết</button>
        </div>
        <div class="bottom-section">
<<<<<<< HEAD
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
=======
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-light">
                        <th scope="col" class="name">名前</th>
                        <th scope="col" class="deadline">期限</th>
                        <th scope="col" class="quantity">個数</th>
                        <th scope="col" class="requirement">要求</th>
                    </tr>
                </thead>
                <tbody>
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
>>>>>>> d65e6fb51f886b9602b5b615cdc024715a258f44
            </table>
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
                    <li>Phone: 123-456-7890</li>
                    <li>Email: info@example.com</li>
                </ul>
            </div>
        </div>
    </div>
</footer>

    <script src="script.js"></script>
</body>
<<<<<<< HEAD

</html>
=======
</html>
>>>>>>> d65e6fb51f886b9602b5b615cdc024715a258f44
