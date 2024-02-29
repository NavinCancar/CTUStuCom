$(document).ready(function() {
    //****************************
    /* GỌI POPOVER STYLE*/
    /* Call: $('#ex').CallPopover('text content');*/
    //****************************
    $.fn.CallPopover = function(content) {
        // Lặp qua tất cả các phần tử trong jQuery object
        return this.each(function() {
            var popover = null;
            // Bắt sự kiện click vào phần tử để hiển thị popover
            $(this).click(function(event) {
                // Kiểm tra xem popover đã được tạo hay chưa
                if (!popover) {
                    // Tạo popover với nội dung được truyền vào
                    popover = new bootstrap.Popover(this, {
                        placement: 'bottom',
                        title: '',
                        content: content
                    });
    
                    popover.show();
    
                    // Bắt sự kiện click trên document để đóng popover khi click bất kỳ chỗ nào trên màn hình
                    $(document).on('click', function(e) {
                        // Kiểm tra xem phần tử được click có nằm trong popover không
                        if (popover && !popover._element.contains(e.target)) {
                            // Đóng popover
                            popover.hide();
                        }
                    });
                }
    
                // Ngăn chặn sự lan truyền của sự kiện click ra bên ngoài popover
                event.stopPropagation();
            });
        });
    };
})