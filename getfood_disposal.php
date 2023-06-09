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

$sql;
//フォームから送信されたデータを取得
//$email = $_POST['email'];
//$sql = "SELECT * FROM disposal WHERE store_id = (SELECT store_id FROM store WHERE store_email = '$email')";
$sql = "SELECT * FROM disposal WHERE store_id = 12345";
$result = $conn->query($sql);

// 結果を配列に格納
$rows = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>廃棄状況</title>
</head>
<body>
    <h1>廃棄状況</h1>

    <?php if (!empty($rows)) : ?>
        <table>
            <tr>
                <th>Disposal ID</th>
                <!-- <th>Store ID</th> -->
                <th>Item</th>
                <th>Qty</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?php echo $row['DISPOSAL_ID']; ?></td>
                    <!-- <td><?php //echo $row['STORE_ID']; ?></td> -->
                    <td><?php echo $row['ITEM']; ?></td>
                    <td><?php echo $row['QTY']; ?></td>
                    <td><?php echo $row['DATE']; ?></td>
                    <td><?php echo $row['STATUS']; ?></td>
                    <td><button>削除</button></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>廃棄がなさそうですね！</p>
    <?php endif; ?>
</body>
</html>
