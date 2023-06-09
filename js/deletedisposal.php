<?php
// Lấy disposalId từ yêu cầu POST
$disposalId = $_POST['disposalId'];

//Thông tin kết nối tới CSDL
$servername = "localhost";
$username = "dbuser";
$password = "ecc";
$dbname = "food";

// Thực hiện kết nối CSDL
$db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);

// Chuẩn bị câu lệnh SQL để xóa dữ liệu
$sql = 'DELETE FROM disposal WHERE DISPOSAL_ID = :disposalId';
$stmt = $db->prepare($sql);
$stmt->bindParam(':disposalId', $disposalId);

// Thực thi câu lệnh SQL
if ($stmt->execute()) {
    // Trả về mã trạng thái 200 (OK) nếu xóa thành công
    http_response_code(200);
} else {
    // Trả về mã trạng thái 500 (Internal Server Error) nếu xóa thất bại
    http_response_code(500);
    echo 'Lỗi SQL: ' . $stmt->errorInfo()[2];
}
?>
