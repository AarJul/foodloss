var editMode = false;

    function showEditForm() {
      // Hiển thị box nhập thông tin mới
      document.getElementById("editForm").style.display = "block";
      document.getElementById("storeInfo").style.display = "none";
      
      // Hiển thị nút "保存"
      document.getElementById("saveButton").style.display = "inline-block";
      
      // Ẩn nút "変更"
      document.getElementById("editButton").style.display = "none";
      
      editMode = true;
    }
    
    function saveChanges() {
      // // Xử lý lưu thay đổi ở đây
      
      // // Ẩn box nhập thông tin mới
      // document.getElementById("editForm").style.display = "none";
      // document.getElementById("editButton").style.display = "none";
      
      // // Ẩn nút "保存"
      // document.getElementById("saveButton").style.display = "none";
      
      // editMode = false;


      // Lấy thông tin mới từ các trường nhập
      var newStoreName = document.getElementById("newStoreName").value;
      var newStoreEmail = document.getElementById("newStoreEmail").value;
      var newStoreTel = document.getElementById("newStoreTel").value;
      var newStoreAddress = document.getElementById("newStoreAddress").value;

      // Gửi thông tin mới đến trang xử lý (save_changes.php)
      var form = document.getElementById("editForm");
      form.action = "store_infomation_update.php";
      form.method = "POST";
      form.submit();
    }
    
    function backButtonClicked() {
      if (editMode) {
        // Ẩn box nhập thông tin mới
        document.getElementById("editForm").style.display = "none";
        document.getElementById("storeInfo").style.display = "block";
        
        // Hiển thị nút "変更"
        document.getElementById("editButton").style.display = "inline-block";
        
        // Ẩn nút "保存"
        document.getElementById("saveButton").style.display = "none";
        
        editMode = false;
      } else {
        history.back();
      }
    }