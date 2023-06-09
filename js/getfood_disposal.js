
// Lắng nghe sự kiện khi nhấp vào nút "削除"
document.addEventListener('click', function(event) {
    // Kiểm tra xem phần tử được nhấp vào có phải là nút "削除" không
    if (event.target && event.target.nodeName == 'BUTTON' && event.target.id == 'deleteButton') {
        // Lấy phần tử tr (dòng) chứa nút "削除"
        var row = event.target.parentNode.parentNode;
        
        // Lấy giá trị của cột DISPOSAL_ID trong phần tử td đầu tiên của dòng
        var disposalId = row.getElementsByTagName('td')[0].textContent;
        
        // Gửi yêu cầu xóa dữ liệu dựa trên disposalId
        // Thực hiện các xử lý xóa tại đây
        
        // Xóa dòng khỏi bảng
        row.parentNode.removeChild(row);
    }
});

