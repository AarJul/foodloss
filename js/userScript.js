
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
  ////////////
  // Tạo một chuỗi để lưu trữ thông tin số lượng đã yêu cầu
  var storeName = "";
  var quantityString = "Số lượng đã yêu cầu :";

 
  // Lặp qua mảng requestedItems để tạo chuỗi thông tin
  for (var i = 0; i < requestedItems.length; i++) {
    var item = requestedItems[i].item;
    var quantity = requestedItems[i].quantity;
    var store = requestedItems[i].store;
    quantityString += "<br>" + item + ": " + quantity;
    storeName = store;


  }
  // Hiển thị chuỗi thông tin số lượng đã yêu cầu
  document.getElementById("requestedStoreName").innerHTML = "Tên cửa hàng:" + storeName;
  document.getElementById("requestedQuantity").innerHTML = quantityString;
  ////////

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
////////////////////////////////////////////////////////////////////////////


