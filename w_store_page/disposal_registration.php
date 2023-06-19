<?php
session_start();
// データベースの情報
$servername = "localhost";
$username = "dbuser";
$password = "ecc";
$dbname = "food";

$conn = new mysqli($servername, $username, $password, $dbname);

// 接続のチェック
if ($conn->connect_error) {
    die("アクセス失敗: " . $conn->connect_error);
}

// フォームから送信されたデータを取得
if (isset($_SESSION['store_id'])) {
  $store_id = $_SESSION['store_id'];
} else {
  $store_id = "12345";
}

$name = isset($_POST['name']) ? $_POST['name'] : '';
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';


$message = null;

// $name、$quantity、$date がデータを含んでいる場合のみ処理を実行
if (!empty($name) && !empty($quantity) && !empty($date)) {
    // データを挿入するためのSQLクエリを準備
    $sql = "INSERT INTO disposal (store_id, item, qty, date) VALUES ('$store_id', '$name', '$quantity', '$date')";

    // クエリを実行して結果をチェック
    if ($conn->query($sql) === TRUE) {
        $message= "登録が正常に行われました！";
    } else {
        $message= "登録に失敗しました！\nもう一度試してください！";
    }
}

$conn->close();
?>

<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Page</title>
</head>

<body>
    <h1>廃棄登録</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <p style="font-style: italic; color: green;">
          <?php if ($message != null) { echo $message; } ?>
        </p>
        <label for="name">名前:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="quantity">個数:</label>
        <input type="text" id="quantity" name="quantity" required><br><br>
        <script>
          const quantityInput = document.getElementById('quantity');
        
          quantityInput.addEventListener('input', function(event) {
            const input = event.target.value;
            const pattern = /^[0-9]+$/;
        
            if (!pattern.test(input)) {
              event.target.value = input.replace(/[^0-9]/g, '');
            }
          });
        </script>
        
        <label for="date">賞味期限:</label>
        <input type="date" id="date" name="date" required><br><br>
        <button type="submit">登録</button>
    </form>
    <a href="getfood_disposal.php">戻る</a>
</body>

</html>