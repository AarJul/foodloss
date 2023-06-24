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

    var remainingQty = currentQty - parseInt(quantity);
    qtyElement.textContent = remainingQty;

    // Thay đổi nút thành "Đã yêu cầu"
    var requestButton = document.querySelector(".request-button[data-storeId='" + storeId + "']");
    requestButton.textContent = "要求済";
    requestButton.disabled = true;

    closeModal(); // Đóng cửa sổ pop-up sau khi xử lý yêu cầu
  }
}

// function submitRequest() {
//   var quantity = document.getElementById("quantityInput").value;
//   var storeId = document.getElementById("submitRequestBtn").getAttribute("data-storeId");
//   console.log("data-storeId: " + storeId);
//   console.log("Quantity:", quantity);
//   console.log("Store ID:", storeId);
//   // Gửi yêu cầu AJAX để cập nhật số lượng
//   var xhr = new XMLHttpRequest();
//   xhr.open("POST", "update_quantity.php", true);
//   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//   xhr.onreadystatechange = function () {
//     if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
//       // Xử lý phản hồi từ máy chủ (nếu cần)
//       closeModal();
//     }
//   };
//   xhr.send("store_id=" + storeId + "&quantity=" + quantity);
// }

//pop-up info
function openPopup() {
  var modal = document.getElementById("info-Modal");
  modal.style.display = "block";
}

function closePopup() {
  var modal = document.getElementById("info-Modal");
  modal.style.display = "none";
}
