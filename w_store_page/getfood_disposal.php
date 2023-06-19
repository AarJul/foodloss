<?php
//PHP部分完成
session_start();

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

<<<<<<< HEAD
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_email'])) {
  header("Location: login.php");
  exit();
}

$email = $_SESSION['user_email'];
=======


>>>>>>> 68509ca950f3c9f7a7cb0a342edee45e3c61edf6
//* SQL Injection防止
// フォームから送信されたデータを取得
$email =  $_SESSION['store_email'];
$stmt = $conn->prepare("SELECT store_id FROM store WHERE store_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$store_id = null;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $store_id = $row['store_id'];
} 
// $_SESSION['store_id'] = $store_id;
$stmt->close();

//additem
// Kiểm tra xem có dữ liệu được gửi đi không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Kiểm tra xem các trường dữ liệu có tồn tại không
  if (isset($_POST['itemInput']) && isset($_POST['quantityInput']) && isset($_POST['dateInput']) && isset($_POST['statusInput'])) {
      // Lấy giá trị từ các trường dữ liệu
      $item = $_POST['itemInput'];
      $quantity = $_POST['quantityInput'];
      $date = $_POST['dateInput'];
      $status = $_POST['statusInput'];

      // Thực hiện xử lý dữ liệu tại đây (ví dụ: lưu vào cơ sở dữ liệu)

      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      // Chuẩn bị câu truy vấn INSERT
      $stmt = $conn->prepare("INSERT INTO disposal (store_id, item, qty, date, status) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("isiss", $_SESSION['store_id'], $item, $quantity, $date, $status);
      
      if ($stmt->execute()) {
          // Nếu thêm dữ liệu thành công, bạn có thể thực hiện hành động khác tại đây
          // Ví dụ: hiển thị thông báo thành công, chuyển hướng trang, v.v.
      } else {
          // Nếu có lỗi xảy ra trong quá trình thêm dữ liệu, bạn có thể xử lý tại đây
      }
  }
}
//additem

$stmt2 = $conn->prepare("SELECT * FROM disposal WHERE store_id = ?");
$stmt2->bind_param("s", $store_id);
$stmt2->execute();
$disposal_info = $stmt2->get_result();

// 結果を配列に格納
$rows = array();
if ($disposal_info->num_rows > 0) {
    while ($row = $disposal_info->fetch_assoc()) {
        $rows[] = $row;
    }
}
var_dump($rows);

$stmt2->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Home</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../css/footer.css" />
    <link rel="stylesheet" href="../css/navbar.css" />
    <link rel="stylesheet" href="../css/storeInvnt.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  </head>

  <body>
    <div class="container-fluid">
      <nav class="navbar navbar-inverse fixed-top">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">OpenSeaS</a>
        </div>
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Home</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"
              >Page 1 <span class="caret"></span
            ></a>
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
            <a href="Register.html"
              ><span class="glyphicon glyphicon-user"></span> 新規登録</a
            >
          </li>
          <li id="user">
            <a href="login.html"
              ><span class="glyphicon glyphicon-log-in"></span> ログイン</a
            >
          </li>
        </ul>
      </nav>
      <div class="text-center">
        <h1 class="mx-auto">ストア画面表示</h1>
        <h2><?php echo $email; ?></h2>
        <h2><?php echo $store_id; ?></h2>
      </div>
      <div class="row">
        <div class="col-sm-2">
          <div id="dashboard">
            <h3>ダッシュボード</h3>
            <div class="btn-group-vertical custom-btn-group">
              <button type="button" class="btn btn-lg w-100 dash-btn" id="addBtn">
                アイテム登録
              </button>
              <button type="button" class="btn btn-lg w-100 dash-btn" id="">
                廃棄物を選択
              </button>
              <button type="button" class="btn btn-lg w-100 dash-btn" id="">
                発送問い合わせ
              </button>
            </div>
          </div>
        </div>
        <div class="col-sm-10">
          <div id="addItem">
            <div class="row">
              <h3>アイテム追加フォーム</h3>
            </div>
            <div class="row">
            <form id="itemForm" class="text-left" method="post" action="getfood_disposal.php">
              <div class="col-sm-5">
                  <div class="form-group">
                      <label for="itemInput">アイテム</label>
                      <input type="text" class="form-control" id="itemInput" name="itemInput" required />
                  </div>
                  <div class="form-group">
                      <label for="quantityInput">個数</label>
                      <input type="number" class="form-control" id="quantityInput" name="quantityInput" required />
                  </div>
              </div>
              <div class="col-sm-5">
                  <div class="form-group">
                      <label for="dateInput">日付</label>
                      <input type="date" class="form-control" id="dateInput" name="dateInput" required />
                  </div>
                  <div class="form-group">
                      <label for="statusInput">ステータス</label>
                      <input type="text" class="form-control" id="statusInput" name="statusInput" required />
                  </div>
                  <button type="submit" class="btn btn-success">追加</button>
              </div>
          </form>
            </div>
          </div>
          <!-- Inventory management section -->
          <h3>Inventory Management</h3>
          <br>
          <table class="table-bordered table-hover" id="inventory">
            <thead>
              <tr>
                <th onclick="sortTable(0)">
                  ストアID <span class="glyphicon glyphicon-sort"></span>
                </th>
                <th onclick="sortTable(1)">
                  廃棄情報 <span class="glyphicon glyphicon-sort"></span>
                </th>
                <th onclick="sortTable(2)">
                  アイテム <span class="glyphicon glyphicon-sort"></span>
                </th>
                <th onclick="sortTable(3)">
                  個数 <span class="glyphicon glyphicon-sort"></span>
                </th>
                <th onclick="sortTable(4)">
                  日付 <span class="glyphicon glyphicon-sort"></span>
                </th>
                <th onclick="sortTable(5)">
                  ステータス <span class="glyphicon glyphicon-sort"></span>
                </th>
                <th id="deleteColumn"></th>
              </tr>
            </thead>
            <tbody id="inventoryBody">
              <!-- Table rows will be generated dynamically -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <br />
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

    <script src="../js/inventory.js"></script>
    <script src ="../js/deleteItemFromDisposal.js"></script>
    <script>
      function userCheck() {
        let = document.getElementById("user");
        if (user == loggedIn) {
          element.innerHTML =
            '<a href="#" onclick="logout();"><span class="glyphicon glyphicon-log-out"></span> ログアウト</a>';
        }
      }
      function logout() {
        // Perform logout operation
        // You can make an AJAX request to a logout endpoint on the server-side
        // Or clear any session/cookie/local storage data

        // Redirect the user to the login page
        window.location.href = "login.html";
      }
    </script>
  </body>
</html>

<!-- <!DOCTYPE html>
<html>
<head>
    <title>廃棄状況</title>
</head>
<body>

    <form id="redirect-form" method="post" action="disposal_registration.php">
    <input type="hidden" name="email" value="<?php echo $email; ?>">
    <button type="submit">廃棄登録</button>
    </form>
    <p><?php echo $store_id; ?></p>
    <h1>廃棄状況</h1>
    <?php if (!empty($rows)) : ?>
        <table>
            <tr>
                <th>Store ID</th>
                <th>Disposal ID</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?php echo $row['STORE_ID']; ?></td>
                    <td><?php echo $row['DISPOSAL_ID']; ?></td>
                    <td><?php echo $row['ITEM']; ?></td>
                    <td><?php echo $row['QTY']; ?></td>
                    <td><?php echo $row['DATE']; ?></td>
                    <td><?php echo $row['STATUS']; ?></td>
                    <td><button class="deleteButton" data-disposal-id="<?= $row['DISPOSAL_ID']; ?>">削除</button></td>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>廃棄がなさそうですね！</p>
    <?php endif; ?>
    <script src ="../js/deleteItemFromDisposal.js"></script>
</body>
</html> -->
