
var requestedItems = [];

function openModal(disposalId,item,storeName) {
  var modal = document.getElementById("request-modal");
  modal.style.display = "block";

  var submitRequestBtn = document.getElementById("submitRequestBtn");
  submitRequestBtn.setAttribute("data-disposalId", disposalId);

  submitRequestBtn.setAttribute("data-item", item);
  submitRequestBtn.setAttribute("data-store", storeName);
}

function closeModal() {
  var modal = document.getElementById("request-modal");
  modal.style.display = "none";
}


function submitRequest() {
  var quantity = document.getElementById("quantityInput").value;
  // Lưu trữ số lượng đã yêu cầu vào biến toàn cục
  ////////

  // Kiểm tra và xử lý số liệu nhập vào
  if (isNaN(quantity) || quantity < 0) {
    alert("Số lượng không hợp lệ!");
    return;
  }


  //////////
  requestedStoreName = event.target.getAttribute('data-storeName');
  document.getElementById('storeName').innerText = requestedStoreName;

  // Kiểm tra giá trị quantity và tiến hành xử lý yêu cầu
  if (quantity !== null && quantity !== "") {
    var disposalId = document.getElementById("submitRequestBtn").getAttribute("data-disposalId");
    var item = document.getElementById("submitRequestBtn").getAttribute("data-item");
    var storeName = document.getElementById("submitRequestBtn").getAttribute("data-store");
    
    // Thực hiện xử lý yêu cầu với storeId và quantity
    var qtyElement = document.getElementById("qty_" + disposalId);
    var currentQty = parseInt(qtyElement.textContent);

    if (isNaN(quantity) || parseInt(quantity) < 0) {
      alert("Số lượng không hợp lệ!");
      return;
    }

    if (currentQty < parseInt(quantity)) {
      alert("Số lượng yêu cầu vượt quá số lượng hiện có!");
      return;
    }
    // Lưu thông tin vào mảng requestedItems
    var request = {

      store: storeName,
      item: item,
      quantity: quantity
    };
    requestedItems.push(request);


    var remainingQty = currentQty - parseInt(quantity);
    qtyElement.textContent = remainingQty;
    // Thay đổi nút thành "Đã yêu cầu"
    var requestButton = document.querySelector(".request-button[data-disposalId='" + disposalId + "']");
    requestButton.textContent = "要求済";
    requestButton.disabled = true;



    closeModal();
  }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function openPopup() {
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
  var modal = document.getElementById("info-Modal");
  modal.style.display = "none";
}
///////////////////////////////////////////////////////////////////////////////////////


function openConfirmationPopup() {
  // Mở pop-up xác nhận
  var confirmationModal = document.getElementById("confirmation-modal");
  confirmationModal.style.display = "block";

  // Xóa nội dung hiện tại của phần tử chứa các cửa hàng yêu cầu
  document.getElementById("requestedStores").innerHTML = "";

  // Tạo đối tượng để lưu trữ thông tin yêu cầu theo từng cửa hàng
  var storeRequests = {};

  // Lặp qua mảng requestedItems để tạo danh sách yêu cầu theo từng cửa hàng
  for (var i = 0; i < requestedItems.length; i++) {
    var item = requestedItems[i].item;
    var quantity = requestedItems[i].quantity;
    var store = requestedItems[i].store;

    // Kiểm tra xem cửa hàng đã có trong danh sách yêu cầu chưa
    if (!storeRequests[store]) {
      storeRequests[store] = [];
    }

    // Thêm thông tin yêu cầu của item và số lượng vào danh sách yêu cầu của cửa hàng
    storeRequests[store].push({
      item: item,
      quantity: quantity
    });
  }

  // Hiển thị thông tin yêu cầu theo từng cửa hàng
  var requestedStoresContainer = document.getElementById("requestedStores");
  for (var store in storeRequests) {
    if (storeRequests.hasOwnProperty(store)) {
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
      for (var j = 0; j < storeRequests[store].length; j++) {
        var storeRequest = storeRequests[store][j];

        // Tạo dòng chứa thông tin yêu cầu của mỗi item
        var row = document.createElement("tr");
        var itemCell = document.createElement("td");
        itemCell.textContent = storeRequest.item;
        var quantityCell = document.createElement("td");
        quantityCell.textContent = storeRequest.quantity;
        row.appendChild(itemCell);
        row.appendChild(quantityCell);
        table.appendChild(row);
      }

      // Tạo phần tử div để chứa bảng và tên cửa hàng
      var storeDiv = document.createElement("div");
      storeDiv.innerHTML = "<strong>Store Name: " + store + "</strong>";
      storeDiv.appendChild(table);

      // Đưa phần tử cửa hàng vào container
      requestedStoresContainer.appendChild(storeDiv);
    }
  }
}

function closeConfirmationPopup() {
  var modal = document.getElementById("confirmation-modal");
  modal.style.display = "none";
}
// ////////////////////////////////////////////

function confirmOrder() {
  // Tiến hành xử lý yêu cầu xác nhận đơn hàng
  var requestedStoreNameElement = document.getElementById("storeName");
  var requestedStoreName = requestedStoreNameElement.innerText.trim();

  // Lặp qua mảng requestedItems để tìm các yêu cầu của cửa hàng đã chọn
  var selectedStoreRequests = [];
  for (var i = 0; i < requestedItems.length; i++) {
    if (requestedItems[i].store === requestedStoreName) {
      selectedStoreRequests.push(requestedItems[i]);
    }
  }

  // Kiểm tra xem có yêu cầu nào cho cửa hàng đã chọn không
  if (selectedStoreRequests.length > 0) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add_order.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        // Xử lý phản hồi từ máy chủ (nếu cần)
        closeModal("confirmation-modal");
      }
    };
    // Gửi các yêu cầu cho cửa hàng đã chọn đến tệp PHP
    var data = JSON.stringify(selectedStoreRequests);
    xhr.send(data);
  }
}

////////////////////////////////////////////////////////////////////////////


