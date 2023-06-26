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
$storeQuery = "SELECT s.STORE_ID, s.STORE_NAME,s.STORE_EMAIL, s.STORE_TEL,s.STORE_ADDRESS,d.DISPOSAL_ID, d.ITEM, d.QTY, d.DATE
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/navbar.css" />
    <link rel="stylesheet" href="css/storeInvnt.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style="height: 1000px">
    <div class="container" style="margin-top: 70px;">
        <nav class="navbar navbar-inverse navbar-fixed-top">
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
                    <a href="../w_Account_Register/Register.html"><span class="glyphicon glyphicon-user">
                            <?php echo $user_name; ?>
                        </span></a>
                </li>
                <li id="user">
                    <a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a>
                </li>
            </ul>
        </nav>


    </div>
    <div class="center-section">
        <?php
        $currentStoreID = null;
        foreach ($storeResult as $store) {
            if ($store['STORE_ID'] != $currentStoreID) {
                ?>
                <div class="container">
                    <table class="table-bordered table-hover" id="inventory">
                        <h3>
                            ストアー名:
                            <?php echo $store['STORE_NAME']; ?>

                            <!--　詳細ボタンの処理ここから　-->
                            <!-- Button -->
                            <button onclick="openPopup()">詳細</button>
                            <div class="top-right-section">
                                <a><button onclick="openConfirmationPopup()">Xác
                                        nhận đơn hàng</button></a>
                                <!-- Các phần còn lại của pop-up -->
                            </div>



                        </h3>
                        <thead>
                            <tr>
                                <th onclick="sortTable(0)">商品名 <span class="glyphicon glyphicon-sort"></span></th>
                                <th onclick="sortTable(1)">期限 <span class="glyphicon glyphicon-sort"></span></th>
                                <th onclick="sortTable(2)">個数 <span class="glyphicon glyphicon-sort"></span></th>
                            </tr>
                        </thead>
                        <tbody id="inventoryBody">
                            <!-- insert code -->
                        </tbody>
                        <?php
                        $currentStoreID = $store['STORE_ID'];

            }

            if (!empty($store['ITEM'])) {
                ?>
                        <tr>

                            <td data-item="<?php echo $store['ITEM']; ?>">
                                <?php echo $store['ITEM']; ?>
                            </td>
                            <td>
                                <?php echo $store['DATE']; ?>
                            </td>
                            <td id="qty_<?php echo $store['DISPOSAL_ID']; ?>"><?php echo $store['QTY']; ?></td>

                            <td>
                                <button class="request-button" data-disposalId="<?php echo $store['DISPOSAL_ID']; ?>"
                                    onclick="openModal(<?php echo $store['DISPOSAL_ID']; ?>)">要求</button>
                            </td>

                        </tr>
                        <?php
            } else {
                ?>
                        <tr>
                            <td colspan="4">ただ今廃棄はないです！</td>
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
    <!-- Modal Yêu Cầu-->
    <div id="request-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Yêu cầu số lượng</h2>
            <input type="text" id="quantityInput" placeholder="Nhập số lượng" onchange="updateConfirmationPopup()">
            <button id="submitRequestBtn" onclick="submitRequest()">Yêu cầu</button>
        </div>
    </div>

    <!-- Modal Info-->
    <div id="info-Modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <h2>
                <?php echo $store['STORE_NAME']; ?>
            </h2>
            <p>
                <?php echo $store['STORE_EMAIL']; ?>
            </p>
            <p>
                <?php echo $store['STORE_TEL']; ?>
            </p>
            <p>
                <?php echo $store['STORE_ADDRESS']; ?>
            </p>
        </div>
    </div>
    <!--　詳細ボタンの処理ここまで　-->
    <!-- Modal Confirm-->
    <div id="confirmation-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeConfirmationPopup()">&times;</span>
            <h3>Xác nhận đơn hàng:</h3>
            <p id="requestedItem"></p>
            <p id="requestedQuantity"></p>
            <button onclick="confirmOrder()">Xác nhận</button>
        </div>
    </div>

    <script src="js/bootstrap.js"></script>
    <script src="js/userScript.js"></script>
</body>

</html>