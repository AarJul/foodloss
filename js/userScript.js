// 使っていない時コンメントにして
// Check and restore the requested status after page reload
// document.addEventListener("DOMContentLoaded", function() {
//   var requestButtons = document.querySelectorAll(".request-button");
//   requestButtons.forEach(function(requestButton) {
//     var disposalId = requestButton.getAttribute("data-disposalId");
//     var isRequested = localStorage.getItem('requested_' + disposalId);

//     if (isRequested === 'true') {
//       requestButton.textContent = "要求済";
//       requestButton.disabled = true;
//     }
//   });
// });

// ＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊

// Initialize variables to store request information and update requests
var requestedItems = {};
var updatedItems = [];

// Functions to control opening and closing of modal popups
function openModal(disposalId, item, storeName) {
  // code for opening the modal
  var modal = document.getElementById("request-modal");
  modal.style.display = "block";

  var submitRequestBtn = document.getElementById("submitRequestBtn");
  submitRequestBtn.setAttribute("data-disposalId", disposalId);

  submitRequestBtn.setAttribute("data-item", item);
  submitRequestBtn.setAttribute("data-store", storeName);
}

function closeModal() {
  // code for closing the modal
  var modal = document.getElementById("request-modal");
  modal.style.display = "none";
}

// ＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊
function openPopup() {
  // code for opening the info popup
  var storeName = event.target.getAttribute('data-storeName');
  var storeEmail = event.target.getAttribute('data-storeEmail');
  var storeTel = event.target.getAttribute('data-storeTel');
  var storeAddress = event.target.getAttribute('data-storeAddress');

  // Hiển thị cửa sổ popup
  var modal = document.getElementById('info-Modal');
  modal.style.display = 'block';

  // Cung cấp dữ liệu cho các phần tử trong cửa sổ popup
  document.getElementById('storeName').innerText = storeName;
  document.getElementById('storeEmail').innerText = storeEmail;
  document.getElementById('storeTel').innerText = storeTel;
  document.getElementById('storeAddress').innerText = storeAddress;
}

function closePopup() {
   // code for closing the info popup
  var modal = document.getElementById("info-Modal");
  modal.style.display = "none";
}

// ＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊
function openConfirmationPopup() {
  // code for opening the confirmation popup
  var confirmationModal = document.getElementById("confirmation-modal");
  confirmationModal.style.display = "block";

  // Xóa nội dung hiện tại của phần tử chứa các cửa hàng yêu cầu
  var requestedStoresContainer = document.getElementById("requestedStores");
  requestedStoresContainer.innerHTML = "";

  // Kiểm tra xem đã có yêu cầu sản phẩm hay chưa
  if (Object.keys(requestedItems).length === 0) {
    var messageDiv = document.createElement("div");
    messageDiv.textContent = "まだリクエストされた数量はありません";
    requestedStoresContainer.appendChild(messageDiv);
    return;
  }

  // Hiển thị thông tin yêu cầu theo từng cửa hàng
  for (var store in requestedItems) {
    if (requestedItems.hasOwnProperty(store)) {
      // Tạo bảng để chứa thông tin cửa hàng
      var table = document.createElement("table");

      // Tạo dòng tiêu đề
      var headerRow = document.createElement("tr");
      var itemHeader = document.createElement("th");
      itemHeader.textContent = "Item";
      var quantityHeader = document.createElement("th");
      quantityHeader.textContent = "Quantity";
      headerRow.appendChild(itemHeader);
      headerRow.appendChild(quantityHeader);
      table.appendChild(headerRow);

      // Lặp qua danh sách yêu cầu của cửa hàng
      requestedItems[store].forEach(function (storeRequest) {
        // Tạo dòng chứa thông tin yêu cầu của mỗi item
        var row = document.createElement("tr");
        var itemCell = document.createElement("td");
        itemCell.textContent = storeRequest.item;
        var quantityCell = document.createElement("td");
        quantityCell.textContent = storeRequest.quantity;
        row.appendChild(itemCell);
        row.appendChild(quantityCell);
        table.appendChild(row);
      });

      // Tạo phần tử div để chứa bảng và tên cửa hàng
      var storeDiv = document.createElement("div");
      storeDiv.innerHTML = "<strong>Store Name: " + store + "</strong>";
      storeDiv.appendChild(table);

      // Đưa phần tử cửa hàng vào container
      requestedStoresContainer.appendChild(storeDiv);
    }
  }

  // Gán thuộc tính dữ liệu cho phần tử button Confirm
  var confirmButton = document.getElementById("confirmOrderBtn");
  confirmButton.setAttribute("data-item", JSON.stringify(requestedItems));
}

function closeConfirmationPopup() {
  // code for closing the confirmation popup
  var modal = document.getElementById("confirmation-modal");
  modal.style.display = "none";
}


// ＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊

// Function to handle user request for a product
function submitRequest(disposalId, item, storeName) {
  var quantity = document.getElementById("quantityInput").value;

  if (isNaN(quantity) || quantity < 0) {
    alert("Số lượng không hợp lệ!");
    return;
  }

  requestedStoreName = event.target.getAttribute('data-storeName');
  document.getElementById('storeName').innerText = requestedStoreName;

  // Check the quantity value and proceed with the request
  if (quantity !== null && quantity !== "") {
    var disposalId = document.getElementById("submitRequestBtn").getAttribute("data-disposalId");
    var item = document.getElementById("submitRequestBtn").getAttribute("data-item");
    var storeName = document.getElementById("submitRequestBtn").getAttribute("data-store");

    // Perform request processing with storeId and quantity
    var qtyElement = document.getElementById("qty_" + disposalId);
    var currentQty = parseInt(qtyElement.textContent);

    if (isNaN(quantity) || parseInt(quantity) < 0) {
      alert("数量が無効です！");
      return;
    }

    if (currentQty < parseInt(quantity)) {
      alert("要求された数量が在庫数を超えています！");
      return;
    }
    // Nếu cửa hàng chưa tồn tại trong requestedItems, tạo một mảng mới để lưu trữ thông tin yêu cầu
    if (!requestedItems[storeName]) {
      requestedItems[storeName] = [];
    }
    // Lưu thông tin vào mảng requestedItems
    requestedItems[storeName].push({

      store: storeName,
      item: item,
      quantity: quantity
    });

    var remainingQty = currentQty - parseInt(quantity);
    qtyElement.textContent = remainingQty;
    var update = {
      disposalId: disposalId,
      store: storeName,
      item: item,
      updtQuantity: remainingQty
    };
    updatedItems.push(update);

    // Thay đổi nút thành "Đã yêu cầu"
    var requestButton = document.querySelector(".request-button[data-disposalId='" + disposalId + "']");
    requestButton.textContent = "要求済";
    requestButton.disabled = true;

    localStorage.setItem('requested_' + disposalId, 'true');

    closeModal();
  }
}

// ＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊

function confirmOrder() {
  try {
    var requestedItemsJson = document.getElementById("confirmOrderBtn").getAttribute("data-item");
    var requestedItems = JSON.parse(requestedItemsJson);

    // Kiểm tra nếu requestedItems là mảng 2 chiều và có ít nhất một yêu cầu
    if (Object.keys(requestedItems).length > 0) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "./add_order.php", true);
      xhr.setRequestHeader("Content-Type", "application/json");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          handleConfirmation();
        }
      };

      // Duyệt qua các cửa hàng và lấy thông tin yêu cầu sản phẩm của từng cửa hàng
      var orderData = [];
      for (var store in requestedItems) {
        if (requestedItems.hasOwnProperty(store)) {
          var storeRequests = requestedItems[store];
          storeRequests.forEach(function (itemRequest) {
            var orderItem = {
              store_name: store,
              item: itemRequest.item,
              qty: itemRequest.quantity
            };
            orderData.push(orderItem);
          });
        }
      }

      var data = JSON.stringify(orderData);
      xhr.send(data);
    }

    if (updatedItems.length > 0) {
      var xhrUpdated = new XMLHttpRequest();
      xhrUpdated.open("POST", "./updateDisposal.php", true);
      xhrUpdated.setRequestHeader("Content-Type", "application/json");
      xhrUpdated.onreadystatechange = function () {
        if (xhrUpdated.readyState === XMLHttpRequest.DONE && xhrUpdated.status === 200) {
          // Xử lý phản hồi từ máy chủ (nếu cần)
          handleConfirmation();
        }
      };
      var updatedData = JSON.stringify(updatedItems);
      xhrUpdated.send(updatedData);
    }

    function handleConfirmation() {
      closeConfirmationPopup("confirmation-modal");
      alert(" order successful!");
    }
  } catch (error) {
    console.error('Error in confirmOrder:', error);
  }
}

// // Biến lưu trạng thái hiện tại của việc sắp xếp cho mỗi cột
// var sortStates = [0, 0, 0, 0]; // Khởi tạo tất cả các cột đều không sắp xếp

// // Hàm sắp xếp dữ liệu theo cột được chọn
// function sortTable(columnIndex) {
//   var table, rows, switching, i, x, y, shouldSwitch;
//   table = document.getElementById("inventory");
//   switching = true;

//   while (switching) {
//     switching = false;
//     rows = table.getElementsByTagName("tr");

//     for (i = 1; i < (rows.length - 1); i++) {
//       shouldSwitch = false;
//       x = rows[i].getElementsByTagName("td")[columnIndex];
//       y = rows[i + 1].getElementsByTagName("td")[columnIndex];

//       // Kiểm tra cột được chọn để thực hiện việc sắp xếp tương ứng
//       if (columnIndex === 0) { // Cột "商品名" (Tên sản phẩm)
//         if (sortStates[columnIndex] === 0) {
//           shouldSwitch = x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase();
//         } else {
//           shouldSwitch = x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase();
//         }
//       } else if (columnIndex === 1) { // Cột "賞味期限" (Ngày hết hạn)
//         if (sortStates[columnIndex] === 0) {
//           shouldSwitch = Date.parse(x.innerHTML) > Date.parse(y.innerHTML);
//         } else {
//           shouldSwitch = Date.parse(x.innerHTML) < Date.parse(y.innerHTML);
//         }
//       } else if (columnIndex === 2) { // Cột "数量" (Số lượng)
//         if (sortStates[columnIndex] === 0) {
//           shouldSwitch = parseInt(x.innerHTML) > parseInt(y.innerHTML);
//         } else {
//           shouldSwitch = parseInt(x.innerHTML) < parseInt(y.innerHTML);
//         }
//       }

//       if (shouldSwitch) {
//         rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
//         switching = true;
//         break;
//       }
//     }

//     // Cập nhật trạng thái của cột sau khi đã sắp xếp
//     sortStates = sortStates.map((state, index) => (index === columnIndex ? (1 - state) : 0));
//   }
// }



