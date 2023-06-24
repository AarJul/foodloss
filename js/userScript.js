function logout() {
  window.location.href = "logout.php";
}

function openModal(storeId) {
  var modal = document.getElementById("request-modal");
  modal.style.display = "block";

  var submitRequestBtn = document.getElementById("submitRequestBtn");
  submitRequestBtn.setAttribute("data-storeId", storeId);
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
    var storeId = document.getElementById("submitRequestBtn").getAttribute("data-storeId");

    // Thực hiện xử lý yêu cầu với storeId và quantity
    var qtyElement = document.getElementById("qty_" + storeId);
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
    var requestButton = document.querySelector(".request-button[data-storeId='" + storeId + "']");
    requestButton.textContent = "Đã yêu cầu";
    requestButton.disabled = true;

    closeModal();
  }
}

function openPopup() {
  var modal = document.getElementById("info-Modal");
  modal.style.display = "block";
}

function closePopup() {
  var modal = document.getElementById("info-Modal");
  modal.style.display = "none";
}

function openConfirmationPopup(itemName, quantity) {
        var modal = document.getElementById("confirmation-modal");
        modal.style.display = "block";

        var requestedItemElement = document.getElementById("requestedItem");
        requestedItemElement.textContent = "Sản phẩm: " + itemName;

        var requestedQuantityElement = document.getElementById("requestedQuantity");
        requestedQuantityElement.textContent = "Số lượng đã lấy: " + quantity;
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


