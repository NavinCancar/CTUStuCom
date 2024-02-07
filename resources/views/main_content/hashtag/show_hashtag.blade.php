@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
              <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold">#<?php echo $hashtag_get->H_HASHTAG ?></h5>
                    <?php if($userLog) { ?>
                    @if(!$isFollowHashtag)
                    <a class="btn btn-primary follow-hashtag" data-hashtag-value="<?php echo $hashtag_get->H_HASHTAG ?>">
                        <i class="fas fa-plus"></i> &nbsp;Theo dõi hashtag
                    </a>
                    @else
                    <a class="btn btn-outline-primary unfollow-hashtag" data-hashtag-value="<?php echo $hashtag_get->H_HASHTAG ?>">
                        <i class="fas fa-check"></i> &nbsp;Theo dõi hashtag
                    </a>
                    @endif
                    <?php } ?>
              </div>
            
              <hr>
              <div class="mb-3 mb-sm-0 pb-3">
                  <span>Hashtag thường đi kèm:</span>
                  <a href="./tag.php"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#ung_dung</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#lay_y_kien</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
              </div>
      
              <div id="post_container">
                @include('main_component.post_loadmore')
              </div>

              <div class="text-center">
                  <button class="btn btn-primary load-more-data"><i class="fa fa-refresh"></i> Xem thêm</button>
              </div>
              <!-- Data Loader -->
              <div class="auto-load text-center" style="display: none;">
                  <div class="spinner-border text-primary"></div>
              </div>
          </div>
        </div>
      </div>

  <!--XỬ LÝ LOAD MORE START-->
  <script>
      var ENDPOINT = "{{ URL::to('/hashtag/'.$hashtag_get->H_HASHTAG) }}"
      var page = 1;

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
                      $('.auto-load').html("Rất tiếc! Không còn bài viết để hiển thị :(");
                      $('.load-more-data').hide();
                      return;
                  }
                  $('.auto-load').hide();
                  $('.load-more-data').show();
                  $("#post_container").append(response.html);
              })
              .fail(function (jqXHR, ajaxOptions, thrownError) {
                  console.log('Server error occured');
              });
      }
  </script>
  <!--XỬ LÝ LOAD MORE END-->

  <!-- MAIN START -->
    <script>
        $(document).ready(function() {
            //|*****************************************************
          //|LIKE HASHTAG START 
          //|*****************************************************
          <?php if($userLog) { ?>
            $(document).on('click', '.follow-hashtag', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var element = $(this);
                var H_HASHTAG = $(this).data('hashtag-value');
                var iconElement = $(this).find('i');

                iconElement.removeClass('fa-plus');
                iconElement.removeClass('fa-check');
                iconElement.removeClass('fa-exclamation-circle');
                element.removeClass('btn-danger');
                element.removeClass('btn-primary');

                element.addClass('btn-outline-primary');
                iconElement.addClass('spinner-border text-primary spinner-border-sm');

                $.ajax({
                  url: '{{URL::to('/theo-doi-hashtag/')}}' +'/'+ H_HASHTAG,
                  type: 'GET',
                  success: function(response) {
                    element.removeClass('btn-outline-primary follow-hashtag');
                    element.addClass('btn-outline-primary unfollow-hashtag');

                    iconElement.removeClass('spinner-border text-primary spinner-border-sm');
                    iconElement.addClass('fa-check');
                    //console.log(number);
                  },
                  error: function(error) {
                    element.removeClass('btn-outline-primary');
                    element.addClass('btn-danger');

                    iconElement.removeClass('spinner-border text-primary spinner-border-sm');
                    iconElement.addClass('fa-exclamation-circle');
                    console.log(error);
                  }
                });
                    
            });
            $(document).on('click', '.unfollow-hashtag', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var element = $(this);
                var H_HASHTAG = $(this).data('hashtag-value');
                var iconElement = $(this).find('i');

                iconElement.removeClass('fa-plus');
                iconElement.removeClass('fa-check');
                iconElement.removeClass('fa-exclamation-circle');
                element.removeClass('btn-danger');
                element.removeClass('btn-primary');

                element.addClass('btn-outline-primary');
                iconElement.addClass('spinner-border text-primary spinner-border-sm');

                $.ajax({
                  url: '{{URL::to('/huy-theo-doi-hashtag/')}}' +'/'+ H_HASHTAG,
                  type: 'GET',
                  success: function(response) {
                    element.removeClass('btn-outline-primary unfollow-hashtag');
                    element.addClass('btn-primary follow-hashtag');

                    iconElement.removeClass('spinner-border text-primary spinner-border-sm');
                    iconElement.addClass('fa-plus');
                    //console.log(number);
                  },
                  error: function(error) {
                    element.removeClass('btn-outline-primary');
                    element.addClass('btn-danger');

                    iconElement.removeClass('spinner-border text-primary spinner-border-sm');
                    iconElement.addClass('fa-exclamation-circle');
                    console.log(error);
                  }
                });
                    
            });
          <?php } ?>
          //|*****************************************************
          //|LIKE HASHTAG END
          //|*****************************************************
        })
    </script>
  <!-- MAIN END -->
@endsection