<?php
// データベースの情報　
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

$conn = new mysqli($servername, $username, $password, $dbname);

//接続のチェック
if ($conn->connect_error) {
    die("アクセス失敗: " . $conn->connect_error);
}

//同じIDがすでに登録されたかどうかをチェックするメソッド
function isDuplicateID($conn, $id) {
    $sql = "SELECT COUNT(*) as count FROM your_table WHERE ID = '$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}

//６桁のIDを乱数で割り当てる
$id = mt_rand(100000, 999999);

//重複がなくなるまでランダムな数値を確認して再生成する
while (isDuplicateID($conn, $randomNumber)) {
    $id = mt_rand(100000, 999999);
}

//フォームから送信されたデータを取得
$name = $_POST['name'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['address'];

//SQL文を作成
$sql = "INSERT INTO USER (name, telephone, email, password, address) 
        VALUES ('$id','$name', '$telephone', '$email', '$password', '$address')";

//トランザクション開始
if ($conn->query($sql) === TRUE) {
    echo "登録成功";
} else {
    echo "エラー: " . $sql . "<br>" . $conn->error;
}

//トランザクション終了
$conn->close();
?>



