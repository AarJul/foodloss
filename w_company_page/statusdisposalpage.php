<?php
// PHP code to retrieve disposal and store data

// Database information
$servername = "localhost";
$username = "dbuser";
$password = "ecc";
$dbname = "food";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve disposal data
$stmt = $conn->prepare("SELECT * FROM disposal");
$stmt->execute();
$disposal_info = $stmt->get_result();

// Store disposal data in an array
$rows = array();
if ($disposal_info->num_rows > 0) {
    while ($row = $disposal_info->fetch_assoc()) {
        $rows[] = $row;
    }
}

$stmt->close();

// Retrieve store data
$stmt2 = $conn->prepare("SELECT * FROM store");
$stmt2->execute();
$store_info = $stmt2->get_result();

// Store store data in an associative array
$store_rows = array();
if ($store_info->num_rows > 0) {
    while ($store_row = $store_info->fetch_assoc()) {
        $store_rows[$store_row['STORE_ID']] = $store_row['STORE_NAME'];
    }
}

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
        <!-- ... (Previous code) -->
      </nav>
      <div class="text-center">
        <!-- ... (Previous code) -->
      </div>
      <div class="row">
        <div class="col-sm-2">
          <!-- ... (Previous code) -->
        </div>
        <div class="col-sm-10">
          <div id="addItem"></div>
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
              <?php foreach ($rows as $row) : ?>
                <tr>
                  <td><?php echo $row['STORE_ID']; ?></td>
                  <td><?php echo $store_rows[$row['STORE_ID']]; ?></td>
                  <td><?php echo $row['DISPOSAL_ID']; ?></td>
                  <td><?php echo $row['ITEM']; ?></td>
                  <td><?php echo $row['QTY']; ?></td>
                  <td><?php echo $row['DATE']; ?></td>
                  <td><?php echo $row['STATUS']; ?></td>
                  <td><button class="deleteButton" data-disposal-id="<?= $row['DISPOSAL_ID']; ?>">削除</button></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <br />
    <footer class="custom-footer">
      <!-- ... (Previous code) -->
    </footer>

    <script src="../js/inventory.js"></script>
    <script src="../js/deleteItemFromDisposal.js"></script>
    <script>
      // ... (Previous code)
    </script>
  </body>
</html>
