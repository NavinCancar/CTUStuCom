@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
        <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
              <h5 class="card-title fw-semibold">Kho lưu trữ bình luận</h5>
        </div>
        <hr>
        <div>
          @if ($binh_luan->total() > 0)
            <!--  Bình luận  -->
            <div id="comment_container">
              @include('main_component.comment_loadmore')
            </div>

            <div class="text-center">
                <button class="btn btn-primary load-more-data"><i class="fa fa-refresh"></i> Xem thêm</button>
            </div>
            <!-- Data Loader -->
            <div class="auto-load text-center" style="display: none;">
                <div class="spinner-border text-primary"></div>
            </div>
          @else
            <div class="text-center">Rất tiếc! Không có nội dung để hiển thị :(</div>
          @endif
        </div>
    </div>
  </div>
</div>

<!--XỬ LÝ LOAD MORE START-->
@if($binh_luan->total() > 0)
    <script>
        var ENDPOINT = "{{ URL::to('/kho-binh-luan') }}"
        var page = 1;
        var maxPage = <?php echo  $binh_luan->lastPage(); ?>;

        if(page >= maxPage){
            $('.auto-load').html("Rất tiếc! Không còn bình luận để hiển thị :(");
            $('.auto-load').show();
            $('.load-more-data').hide();
        }

        //Load thêm bài: 2 cách
        //Cách 1: Nhấn nút
        $(".load-more-data").click(function(){
            page++;
            infinteLoadMore(page);
        });

        //Cách 2: Lướt tới cuối tự động load
        $(window).scroll(function() {
        // Kiểm tra xem đã đến cuối trang hay chưa
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            //console.log('Đã đến cuối trang');
            page++;
            infinteLoadMore(page);
        }
        });

        /*------------------------------------------
        --------------------------------------------
        call infinteLoadMore()
        --------------------------------------------
        --------------------------------------------*/
        function infinteLoadMore(page) {
            //console.log(ENDPOINT + "?page=" + page);
            $.ajax({
                url: ENDPOINT + "?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                    $('.load-more-data').hide();
                }
            })
                .done(function (response) {
                    if (response.html == '') {
                        $('.auto-load').html("Rất tiếc! Không còn bình luận để hiển thị :(");
                        $('.load-more-data').hide();
                        return;
                    }
                    $('.auto-load').hide();
                    $('.load-more-data').show();
                    $("#comment_container").append(response.html);
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }
    </script>
@endif
<!--XỬ LÝ LOAD MORE END-->

    <script>
        $(document).ready(function() {
            //|*****************************************************
            //|LIKE BÌNH LUẬN START //
            //|*****************************************************
            <?php if($userLog) { ?>
            $(document).on('click', '.like-comment', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var $element = $(this);
                var number = $element.find('b').text();
                var BL_MA = $(this).data('comment-id-value');
                //var _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{URL::to('/thich-binh-luan/')}}' +'/'+ BL_MA,
                    type: 'GET',
                    success: function(response) {
                    $element.removeClass('text-muted like-comment');
                    $element.addClass('text-danger unlike-comment');

                    number = parseInt(number) + 1;
                    $element.find('b').text(number);
                    //console.log(number);

                    //Notification start
                    $.ajax({
                        url: '{{URL::to('/thong-bao-thich-binh-luan/')}}' +'/'+ BL_MA,
                        type: 'GET',
                        success: function(response2) {
                            //console.log('ok');
                        },
                        error: function(error2) {
                            console.log(error);
                        }
                    });
                    //Notification end
                    },
                    error: function(error) {
                    console.log(error);
                    }
                });
                    
            });
            $(document).on('click', '.unlike-comment', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var $element = $(this);
                var number = $element.find('b').text();
                var BL_MA = $(this).data('comment-id-value');
                //var _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{URL::to('/huy-thich-binh-luan/')}}' +'/'+ BL_MA,
                    type: 'GET',
                    success: function(response) {
                    $element.removeClass('text-danger unlike-comment');
                    $element.addClass('text-muted like-comment');

                    number = parseInt(number) - 1;
                    $element.find('b').text(number);
                    //console.log(number);
                    },
                    error: function(error) {
                    console.log(error);
                    }
                });
                    
            });
            <?php } ?>
            //|*****************************************************
            //|LIKE BÌNH LUẬN END
            //|*****************************************************
            //|*****************************************************
            //|LƯU BÌNH LUẬN START
            //|*****************************************************
            <?php if($userLog) { ?>
                $(document).on('click', '.bookmark-comment', function() {
                    // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                    var $element = $(this);
                    var BL_MA = $(this).data('comment-id-value');
                    //var _token = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                    url: '{{URL::to('/luu-binh-luan/')}}' +'/'+ BL_MA,
                    type: 'GET',
                    success: function(response) {
                        $element.removeClass('bookmark-comment');
                        $element.addClass('unbookmark-comment');

                        $element.empty();
                        $element.html(`<i class="fas fa-vote-yea"></i> Đã lưu`);
                        //console.log(number);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                    });
                        
                });
                $(document).on('click', '.unbookmark-comment', function() {
                    // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                    var $element = $(this);
                    var BL_MA = $(this).data('comment-id-value');
                    //var _token = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                    url: '{{URL::to('/huy-luu-binh-luan/')}}' +'/'+ BL_MA,
                    type: 'GET',
                    success: function(response) {
                        $element.removeClass('unbookmark-comment');
                        $element.addClass('bookmark-comment');

                        $element.empty();
                        $element.html(`<i class="fas fa-bookmark"></i> Lưu`);
                        //console.log(number);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                    });
                        
                });
            <?php } ?>
            //|*****************************************************
            //|LƯU BÌNH LUẬN END
            //|*****************************************************
        })
    </script>
  
@endsection