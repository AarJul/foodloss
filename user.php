<?php

session_start();

require_once dirname(__FILE__) . '/function/db_connection.php';

<<<<<<< HEAD
=======




>>>>>>> 1719bb15a091f2764c7dcea6bf73c93a5626c0d7
$conn = connection();

$message = '';




// Kiểm tra xem người dùng đã đăng nhập hay chưa

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");

    exit();

}

$store_id = isset($_SESSION['store_id']) ? $_SESSION['store_id'] : null;

<<<<<<< HEAD
=======




>>>>>>> 1719bb15a091f2764c7dcea6bf73c93a5626c0d7
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

<<<<<<< HEAD
=======




>>>>>>> 1719bb15a091f2764c7dcea6bf73c93a5626c0d7
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
<<<<<<< HEAD
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/footer.css"/>
    <link rel="stylesheet" href="css/navbar.css"/>
    <link rel="stylesheet" href="css/storeInvnt.css"/>
=======

</head>
>>>>>>> 1719bb15a091f2764c7dcea6bf73c93a5626c0d7

</head>




<body>

    <div class="container">
<<<<<<< HEAD
    <nav class="navbar navbar-inverse fixed-top">
            <div class="navbar-header">
                <a class="navbar-brand" href="./w_aboutUs/about.html">OpenSeaS</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">ホーム</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">ストア用<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">ストアフロント</a></li>
                        <li><a href="./w_disposal_page/registerDisposal.html">廃棄登録</a></li>
                        <li><a href="./w_store_page/storeInfo.html">ストア情報</a></li>
                    </ul>
                </li>
                <li><a href="./w_disposal_page/deliveryDisposal">廃棄情報</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="../w_Account_Register/Register.html"><span class="glyphicon glyphicon-user"><?php echo $user_name; ?></span>
                        </a>
                </li>
                <li id="user">
                    <a href="../login.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a>
                </li>
            </ul>
        </nav>
        <div class="top-right-section">
=======

        <div class="top-right-section">

            <h2>User ID: <span id="userid">

                    <?php echo $user_id; ?>

                </span></h2>

            <h2>Tên: <span id="username">

                    <?php echo $user_name; ?>

                </span></h2>

            <button onclick="logout()">Logout</button>

>>>>>>> 1719bb15a091f2764c7dcea6bf73c93a5626c0d7
            <a href="confirm.php"><button>Xác nhận đơn hàng</button></a>

        </div>

        <div class="center-section">

            <?php

            $currentStoreID = null;

            foreach ($storeResult as $store) {

                if ($store['STORE_ID'] != $currentStoreID) {

                    // Hiển thị thông tin store chỉ khi store_id thay đổi

                    ?>

                    <div class="container">

                        <table class="table-bordered table-hover" id="inventory">

                            <h3>

                                ストアー名:

                                <?php echo $store['STORE_NAME']; ?>

                                <button onclick="viewDetails()">Chi tiết</button>

                            </h3>

                            <thead>

                                <tr>
<<<<<<< HEAD
                                    <th onclick="sortTable(0)">商品名 <span class="glyphicon glyphicon-sort"></span></th>
                                    <th onclick="sortTable(1)">期限 <span class="glyphicon glyphicon-sort"></span></th>
                                    <th onclick="sortTable(2)">個数 <span class="glyphicon glyphicon-sort"></span></th>
=======

                                    <th onclick="sortTable(0)">商品名 <span class="glyphicon glyphicon-sort"></span></th>

                                    <th onclick="sortTable(1)">期限 <span class="glyphicon glyphicon-sort"></span></th>

                                    <th onclick="sortTable(2)">個数 <span class="glyphicon glyphicon-sort"></span></th>

>>>>>>> 1719bb15a091f2764c7dcea6bf73c93a5626c0d7
                                </tr>

                            </thead>

                            <tbody id="inventoryBody">

                                <!-- insert code -->

                            </tbody>

                            <?php

                            $currentStoreID = $store['STORE_ID'];

                }

                if (!empty($store['ITEM'])) {

                    // Hiển thị thông tin disposal của store hiện tại

                    ?>

                            <tr>
<<<<<<< HEAD
                                <td><?php echo $store['ITEM']; ?></td>
                                <td><?php echo $store['DATE']; ?></td>
                                <td id="qty_<?php echo $store['STORE_ID']; ?>"><?php echo $store['QTY']; ?></td>
                                <td><button class="request-button" data-storeId="<?php echo $store['STORE_ID']; ?>">要求</button></td>
=======

                                <td><?php echo $store['ITEM']; ?></td>

                                <td><?php echo $store['QTY']; ?></td>

                                <td><?php echo $store['DATE']; ?></td>

                                <td><button>要求</button></td>

>>>>>>> 1719bb15a091f2764c7dcea6bf73c93a5626c0d7
                            </tr>

                            <?php

                } else {

                    // Hiển thị thông báo khi không có disposal data

                    ?>

                            <tr>
<<<<<<< HEAD
                                <td colspan="4">No disposal data</td>
=======

                                <td colspan="3">No disposal data</td>

>>>>>>> 1719bb15a091f2764c7dcea6bf73c93a5626c0d7
                            </tr>

                            <?php

                }

            }

            ?>

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

                            <li>Phone: 123-356-7890</li>

                            <li>Email: info@example.com</li>

                        </ul>

                    </div>

                </div>

            </div>

        </footer>

    </div>
<<<<<<< HEAD
    <!-- Modal -->
    <div id="modal-container" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Yêu cầu số lượng</h2>
            <input type="text" id="quantityInput" placeholder="Nhập số lượng">
            <button id="submitRequestBtn" onclick="submitRequest()">Yêu cầu</button>
        </div>
    </div>


    <script src="js/bootstrap.js"></script>
    <script src="js/userScript.js"></script>
=======

    <script src="script.js"></script>

    <script>

        function logout() {

            window.location.href = "login.php";

        }

    </script>

>>>>>>> 1719bb15a091f2764c7dcea6bf73c93a5626c0d7
</body>




</html>