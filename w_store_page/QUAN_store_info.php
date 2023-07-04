<?php
session_start();

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['store_email'])) {
    exit;
}

$servername = "localhost";
$username = "dbuser";
$password = "ecc";
$dbname = "food";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$email = $_SESSION['store_email'];
$stmt = $conn->prepare("SELECT * FROM store WHERE store_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Store Information</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../css/store_info.css" />
  <script>
    
  </script>
</head>
<body>
  <p id="updateMessage" data-success="<?php echo isset($_SESSION['update_success']) && $_SESSION['update_success'] ? 'true' : 'false'; ?>">
      <?php
      if (isset($_SESSION['update_success'])) {
        if ($_SESSION['update_success']) {
          echo "Cập nhật dữ liệu thành công";
        } else {
          echo "Cập nhật dữ liệu thất bại";
        }

        unset($_SESSION['update_success']); // Xóa session để không hiển thị lại thông báo sau khi refresh trang
      }
      ?>
  </p>
  <h1>Store Information</h1>

  <!-- Các thông tin cửa hàng được in ra từ kết quả truy vấn -->
  <div id="storeInfo">
    <?php while ($row = $result->fetch_assoc()): ?>
      <h3>Store ID: <?php echo $row['STORE_ID']; ?></h3>
      <p>Store Name: <?php echo $row['STORE_NAME']; ?></p>
      <p>Store Email: <?php echo $row['STORE_EMAIL']; ?></p>
      <p>Store Tel: <?php echo $row['STORE_TEL']; ?></p>
      <p>Store Address: <?php echo $row['STORE_ADDRESS']; ?></p>
      <hr>
    <?php endwhile; ?>
  </div>

  <!-- Box nhập thông tin mới -->
  <form id="editForm" style="display: none;">
    <div class="form-group">
      <label for="newStoreName">New Store Name:</label>
      <input type="text" id="newStoreName" name="newStoreName" placeholder="New Store Name">
    </div>
    <div class="form-group">
      <label for="newStoreTel">New Store Tel:</label>
      <input type="text" id="newStoreTel" name="newStoreTel" placeholder="New Store Tel">
    </div>
    <div class="form-group">    
      <label for="newStoreAddress">New Store Address:</label>
      <input type="text" id="newStoreAddress" name="newStoreAddress" placeholder="New Store Address">
    </div>
  </form>

  <!-- Các nút điều hướng -->
  <div class="button-container">
    <button id="editButton" onclick="showEditForm()">変更</button>
    <button id="saveButton" style="display: none;" onclick="saveChanges()">保存</button>
    <button onclick="backButtonClicked()">戻る</button>
  </div>
  <script src="../js/store_info.js"></script>
</body>
</html>
