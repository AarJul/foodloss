<?php
//PHP部分完成

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

$stmt2 = $conn->prepare("SELECT * FROM disposal");
$stmt2->execute();
$disposal_info = $stmt2->get_result();

// 結果を配列に格納
$rows = array();
if ($disposal_info->num_rows > 0) {
    while ($row = $disposal_info->fetch_assoc()) {
        $rows[] = $row;
    }
}

// ストア名を取得
$stmt3 = $conn->prepare("SELECT STORE_ID, STORE_NAME FROM store");
$stmt3->execute();
$store_result = $stmt3->get_result();

// ストア情報を配列に格納
$store_rows = array();
if ($store_result->num_rows > 0) {
    while ($store_row = $store_result->fetch_assoc()) {
        $store_rows[$store_row['STORE_ID']] = $store_row['STORE_NAME'];
    }
}

$stmt2->close();
$stmt3->close();
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
        <h1 class="mx-auto">会社画面表示</h1>
        <h2>test</h2>
      </div>
      <div class="row">
        <div class="col-sm-2">
          <div id="dashboard">
            <h3>ダッシュボード</h3>
            <div class="btn-group-vertical">
              <button type="button" class="btn btn-lg w-100" id="dash-btn">アイテム登録</button>
              <button type="button" class="btn btn-lg w-100" id="dash-btn">機能</button>
              <button type="button" class="btn btn-lg w-100" id="dash-btn">発送問い合わせ</button>
            </div>
          </div>
        </div>
        <div class="col-sm-10">
          <div id="addItem">

          </div>
          <!-- Inventory management section -->
          <h3>Inventory Management</h3>
          <table class="table-bordered table-hover" id="inventory">
            <thead>
              <tr>
                <th onclick="sortTable(0)">
                  ストアID <span class="glyphicon glyphicon-sort"></span>
                </th>
                <th onclick="sortTable(1)">
                  ストア名 <span class="glyphicon glyphicon-sort"></span>
                </th>
                <th onclick="sortTable(2)">
                  廃棄情報 <span class="glyphicon glyphicon-sort"></span>
                </th>
                <th onclick="sortTable(3)">
                  アイテム <span class="glyphicon glyphicon-sort"></span>
                </th>
                <th onclick="sortTable(4)">
                  個数 <span class="glyphicon glyphicon-sort"></span>
                </th>
                <th onclick="sortTable(5)">
                  日付 <span class="glyphicon glyphicon-sort"></span>
                </th>
                <th onclick="sortTable(6)">
                  ステータス <span class="glyphicon glyphicon-sort"></span>
                </th>
                <th id="deleteColumn"></th>
              </tr>
            </thead>
            <tbody id="inventoryBody">
            <?php
            $previousStoreID = null;
            foreach ($rows as $row) :
                $currentStoreID = $row['STORE_ID'];
                $storeName = isset($store_rows[$currentStoreID]) ? $store_rows[$currentStoreID] : '';

                if ($currentStoreID != $previousStoreID) {
                    // Display store divider
                    echo '<tr class="store-divider"><td colspan="8">' . $storeName . '</td></tr>';
                }
            ?>
                <tr>
                    <td><?php echo $currentStoreID; ?></td>
                    <td><?php echo $storeName; ?></td>
                    <td><?php echo $row['DISPOSAL_ID']; ?></td>
                    <td><?php echo $row['ITEM']; ?></td>
                    <td><?php echo $row['QTY']; ?></td>
                    <td><?php echo $row['DATE']; ?></td>
                    <td><?php echo $row['STATUS']; ?></td>
                    <td><button class="deleteButton" data-disposal-id="<?= $row['DISPOSAL_ID']; ?>">削除</button></td>
                </tr>
            <?php
                $previousStoreID = $currentStoreID;
            endforeach;
            ?>
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
              <li>Phone: 123-456-7890</li>
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
