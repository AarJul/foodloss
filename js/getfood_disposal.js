document.addEventListener('click', function(event) {
    if (event.target && event.target.nodeName == 'BUTTON' && event.target.id == 'deleteButton') {
        var row = event.target.parentNode.parentNode;
        var disposalId = row.getElementsByTagName('td')[0].textContent;
        
        // Gửi yêu cầu AJAX đến tệp PHP để thực thi câu lệnh SQL
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'js/deletedisposal.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Xóa dòng khỏi bảng chỉ khi câu lệnh SQL thành công
                    row.parentNode.removeChild(row);
                } else {
                    // Xử lý lỗi khi câu lệnh SQL thất bại
                    console.log('Lỗi SQL: ' + xhr.responseText);
                }
            }
        };
        
        // Truyền disposalId như một tham số trong yêu cầu POST
        var params = 'disposalId=' + encodeURIComponent(disposalId);
        
        // Gửi yêu cầu AJAX
        xhr.send(params);
    }
});
