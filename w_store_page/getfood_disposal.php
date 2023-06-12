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

//* SQL Injection防止
// フォームから送信されたデータを取得
//$email = $_POST['email'];
$email = "store@example.com";
$stmt = $conn->prepare("SELECT store_id FROM store WHERE store_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$store_id = null;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $store_id = $row['store_id'];
}

$stmt->close();

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

$stmt2->close();
//*/



/* テスト用
$sql;
//フォームから送信されたデータを取得
$sql = "SELECT * FROM disposal WHERE store_id = 12345";
$result = $conn->query($sql);

// 結果を配列に格納
$rows = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}
*/

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
</html>
