<?php
// データベースの情報
$servername = "localhost";
$username = "dbuser";
$password = "ecc";
$dbname = "food";

$conn = new mysqli($servername, $username, $password, $dbname);

//接続のチェック 
if ($conn->connect_error) {
    die("アクセス失敗: " . $conn->connect_error);
}

$stmt1 = $conn->prepare("SELECT * FROM user ");
$stmt1->execute();
$user_info = $stmt1->get_result();

// Userデータを配列に格納
$user_rows = array();
while ($user_row = $user_info->fetch_assoc()) {
    $user_rows[$user_row['USER_ID']] = $user_row['USER_NAME'];
}

$stmt2 = $conn->prepare("SELECT * FROM orders");
$stmt2->execute();
$disposal_info = $stmt2->get_result();

// Userごとのデータを配列に格納
$user_data = array();
while ($disposal_row = $disposal_info->fetch_assoc()) {
    $user_id = $disposal_row['USER_ID'];
    if (!isset($user_data[$user_id])) {
        $user_data[$user_id] = array();
    }
    $user_data[$user_id][] = $disposal_row;
}

// ステータスの更新処理
if (isset($_POST['statusChange'])) {
    $disposalId = $_POST['disposalId'];
    $status = $_POST['status'];

    $stmt3 = $conn->prepare("UPDATE orders SET STATUS = ? WHERE DISPOSAL_ID = ?");
    $stmt3->bind_param("si", $status, $disposalId);
    $stmt3->execute();
    $stmt3->close();
}

$stmt2->close();
$stmt1->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>OpenSeaS管理システム</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/footer.css" />
    <link rel="stylesheet" href="../css/navbar.css" />
    <link rel="stylesheet" href="../css/storeInvnt.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style="height: 1000px">

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="./w_aboutUs/about.html">OpenSeaS</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="../w_Landing_Page/landing.html">ホーム</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">ストア用<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../w_Store_Inventory/StoreInvnt.html">ストアフロント</a></li>
                        <li><a href="../w_disposal_page/registerDisposal.html">廃棄登録</a></li>
                        <li><a href="./w_disposal_page/disposalStatus.html">廃棄ステータス</a></li>
                    </ul>
                </li>
                <li><a href="#">メッセージ</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li id="user">
                    <a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> ログアウト</a>
                </li>
            </ul>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="#">ホーム</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">ストア用<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">ストアフロント</a></li>
                    <li><a href="./w_disposal_page/registerDisposal.html">廃棄登録</a></li>
                    <li><a href="./w_disposal_page/disposalStatus.html">廃棄ステータス</a></li>
                </ul>
            </li>
            <li><a href="#">メッセージ</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li id="user">
                <a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> ログアウト</a>
            </li>
        </ul>
    </nav>
    

    <div class="container" style="margin-top: 70px;">
        <div class="row content">
            <div class="col-sm-2 sidenav"></div>
            <div class="col-sm-8 text-center">
                <h1>Order Information</h1>
                <hr>

                <!-- Inventory management section -->
                <?php foreach ($user_data as $user_id => $disposal_rows) : ?>
                    <?php
                        // Get the user name from the $user_rows array
                        $user_name = $user_rows[$user_id];
                        // Generate the user information page URL with the user ID as a query parameter
                        $user_info_url = "userinformation.php?id=" . $user_id;
                    ?>
                    <h3>
                        User ID: <?php echo $user_id; ?>
                        &nbsp;<a href="<?php echo $user_info_url; ?>"><?php echo $user_name; ?></a>
                    </h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>注文ID</th>
                                    <th>商品名</th>
                                    <th>数量</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($disposal_rows as $disposal_row) : ?>
                                    <tr>
                                        <td><?php echo $disposal_row['ORDER_ID']; ?></td>
                                        <td><?php echo $disposal_row['ITEM']; ?></td>
                                        <td><?php echo $disposal_row['QTY']; ?></td>
                                        <td><?php echo $disposal_row['DATE']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-sm-2 sidenav"></div>
        </div>
        <div class="row content">
            <div class="col-sm-12 text-center">
                <button onclick="location.href='statusdisposalpage.php'" type="button" class="btn btn-primary">
                    戻る
                </button>
            </div>
        </div>
    </div>

    <footer class="container-fluid text-center">
        <p>OpenSeaS &copy; 2023</p>
    </footer>
</body>

</html>
