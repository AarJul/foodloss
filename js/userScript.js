
function openModal(disposalId) {
  var modal = document.getElementById("request-modal");
  modal.style.display = "block";

  var submitRequestBtn = document.getElementById("submitRequestBtn");
  submitRequestBtn.setAttribute("data-disposalId", disposalId);
}

function closeModal() {
  var modal = document.getElementById("request-modal");
  modal.style.display = "none";
}

function submitRequest() {
  var quantityInput = document.getElementById("quantityInput");
  var quantity = quantityInput.value;

  // Kiểm tra giá trị quantity và tiến hành xử lý yêu cầu
  if (quantity !== null && quantity !== "") {
    var disposalId = document.getElementById("submitRequestBtn").getAttribute("data-disposalId");

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

    // var xhr = new XMLHttpRequest();
    // xhr.open("POST", "update_quantity.php", true);
    // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    // xhr.onreadystatechange = function () {
    //   if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
    //     // Xử lý phản hồi từ máy chủ (nếu cần)
    //     closeModal();
    //   }
    // };
    // // Gửi yêu cầu AJAX để cập nhật số lượng
    // var data = "store_id=" + encodeURIComponent(storeId) + "&quantity=" + encodeURIComponent(quantity);
    // xhr.send(data);
    var remainingQty = currentQty - parseInt(quantity);
    qtyElement.textContent = remainingQty;
    // Thay đổi nút thành "Đã yêu cầu"
    var requestButton = document.querySelector(".request-button[data-disposalId='" + disposalId + "']");
    requestButton.textContent = "要求済";
    requestButton.disabled = true;

    closeModal();
  }
}

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

function openConfirmationPopup(disposalId) {
  var modal = document.getElementById("confirmation-modal");
  modal.style.display = "block";
  var submitRequestBtn = document.getElementById("submitRequestBtn");
  submitRequestBtn.setAttribute("data-disposalId", disposalId);
  //lay so da ord
  var qtyElement = document.getElementById("qty_" + disposalId);
  var currentQty = parseInt(qtyElement.textContent);

  var requestedItemElement = document.getElementById("requestedItem");
  requestedItemElement.textContent = "商品: " + currentQty;

  var requestedQuantityElement = document.getElementById("requestedQuantity");
  requestedQuantityElement.textContent = "注文個数: " + quantity;
}


function closeConfirmationPopup() {
  var modal = document.getElementById("confirmation-modal");
  modal.style.display = "none";
}

function confirmOrder() {
  // Tiến hành xử lý yêu cầu xác nhận đơn hàng
  var quantityInput = document.getElementById("quantityInput");
  var quantity = quantityInput.value;

  // Kiểm tra giá trị quantity và tiến hành xử lý yêu cầu
  if (quantity !== null && quantity !== "") {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add_order.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        // Xử lý phản hồi từ máy chủ (nếu cần)
        closeModal("confirmation-modal");
      }
    };
    // Gửi số lượng đã yêu cầu và thông tin khác (nếu cần) đến tệp PHP
    var data = "quantity=" + encodeURIComponent(quantity);
    xhr.send(data);
  }
}

