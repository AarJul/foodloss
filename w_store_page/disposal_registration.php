<?php
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
$store_id = $_POST['store_id'];
$name = isset($_POST['name']) ? $_POST['name'] : '';
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';

// $name、$quantity、$date がデータを含んでいる場合のみ処理を実行
if (!empty($name) && !empty($quantity) && !empty($date)) {
    // データを挿入するためのSQLクエリを準備
    $sql = "INSERT INTO disposal (store_ID, item, qty, date) VALUES ('$store_id', '$name', '$quantity', '$date')";

    // クエリを実行して結果をチェック
    if ($conn->query($sql) === TRUE) {
        echo "データがテーブルに正常に挿入されました。";
    } else {
        echo "エラー: " . $sql . "<br>" . $conn->error;
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
 <!-- Các phần còn lại của trang disposal_registration.html -->
    <!-- <form method="post" action="disposal_registration.php"> -->
    <p id="store-id"><?php echo $store_id; ?></p>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="quantity">Quantity:</label>
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
        
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>

        <!-- <input type="button" value="Submit" onclick="submitForm()"> -->
        <button onclick="showPopup()">登録</button>

        <!-- Popup -->
        <div id="popup" class="popup">
          <div class="popup-content">
            <p>Bạn muốn tiếp tục hay quay lại?</p>
            <div class="button-container">
              <button onclick="continueAction()">続ける</button>
              <button onclick="goBackAction()">戻る</button>
            </div>
          </div>
        </div>
        
        <!-- CSS -->
        <style>
          .popup {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
          }
        
          .popup-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            text-align: center;
          }
        
          .button-container {
            margin-top: 20px;
          }
        </style>
        
        <!-- JavaScript -->
        <script>
          console.log(<?php echo json_encode($store_id); ?>);
          function showPopup() {
            var nameInput = document.getElementById("name");
            var quantityInput = document.getElementById("quantity");
            var dateInput = document.getElementById("date");
            
            if (nameInput.value !== "" && quantityInput.value !== "" && dateInput.value !== "") {
              var popup = document.getElementById("popup");
              popup.style.display = "block";
            } else {
              alert("Vui lòng nhập đầy đủ thông tin.");
            }
          }
        
          function continueAction() {
                    var storeIdElement = document.getElementById("store-id");
          var storeId = storeIdElement.dataset.storeId;
          var nameInput = document.getElementById("name");
          var quantityInput = document.getElementById("quantity");
          var dateInput = document.getElementById("date");

          var data = {
            store_id: storeId, // Sử dụng biến storeId đã được định nghĩa
            name: nameInput.value,
            quantity: quantityInput.value,
            date: dateInput.value
          };

          fetch("disposal_registration.php", {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
              "Content-Type": "application/json"
            }
          })
          .then(function(response) {
            if (response.ok) {
              return response.text();
            } else {
              throw new Error("Đã xảy ra lỗi khi gửi dữ liệu.");
            }
          })
          .then(function(data) {
            // Hiển thị thông báo từ PHP trong cửa sổ popup
            var popupContent = document.querySelector(".popup-content");
            popupContent.innerHTML = "<p>" + data + "</p>";
          })
          .catch(function(error) {
            alert("Đã xảy ra lỗi khi gửi dữ liệu: " + error);
          });
        }

        function goBackAction() {
          window.location.href = "trang_web_khac.html"; // Thay đổi đường dẫn "trang_web_khac.html" thành trang web muốn chuyển hướng đến
        }

        
          function closePopup() {
            var popup = document.getElementById("popup");
            popup.style.display = "none";
          }
        </script>
        
    <!-- </form> -->
</body>

</html>