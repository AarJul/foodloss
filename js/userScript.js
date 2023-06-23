function logout() {
  window.location.href = "logout.php";
}

function openModal() {
  var modal = document.getElementById("request-modal");
  modal.style.display = "block";
  
}

function closeModal() {
  var modal = document.getElementById("request-modal");
  modal.style.display = "none";
}

function requestItem(storeId) {
  var quantity = prompt("Nhập số lượng:");

  if (quantity !== null) {
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

    // var button = document.querySelector(".request-button[data-storeId='" + storeId + "']");
    // button.textContent = "要求済";
    // button.disabled = true;
    var requestButton = event.target;
    requestButton.textContent = "要求済";
    requestButton.disabled = true;
  }
}



// document.addEventListener("DOMContentLoaded", function () {
//   var requestButtons = document.querySelectorAll(".request-button");

//   // Gán sự kiện click cho từng nút "request"
//   requestButtons.forEach(function (button) {
//     button.addEventListener("click", function () {
//       openModal();
//       var storeId = button.getAttribute("data-storeId");
//       document.getElementById("submitRequestBtn").setAttribute("data-storeId", storeId);

//       // Gán lại sự kiện click cho nút "Yêu cầu" trong cửa sổ pop-up
//       document.getElementById("submitRequestBtn").addEventListener("click", submitRequest);
//     });
//   });


// });
function submitRequest() {
  var quantity = document.getElementById("quantityInput").value;
  var storeId = document.getElementById("submitRequestBtn").getAttribute("data-storeId");
  console.log("Quantity:", quantity);
  console.log("Store ID:", storeId);
  // Gửi yêu cầu AJAX để cập nhật số lượng
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "update_quantity.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      // Xử lý phản hồi từ máy chủ (nếu cần)
      closeModal();
    }
  };
  xhr.send("store_id=" + storeId + "&quantity=" + quantity);
}
function openPopup() {
  var modal = document.getElementById("info-Modal");
  modal.style.display = "block";
}

function closePopup() {
  var modal = document.getElementById("info-Modal");
  modal.style.display = "none";
}
