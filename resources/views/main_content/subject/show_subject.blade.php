@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
        <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
          <span>
            <h5 class="card-title fw-semibold">Học phần: <?php echo $subject_get->HP_MA .' '. $subject_get->HP_TEN ?></h5>
            <i class="fs-3 px-3"><?php if($count_bai_viet) echo $count_bai_viet; else echo '0'; ?> bài viết</i>
          </span>
        </div>
      
        <hr>
        @if ($bai_viet->total() > 0)
          <div class="mb-3 mb-sm-0 pb-3">
              <span>Hashtag thường đi kèm:</span>
              @foreach($hashtag_hot as $key => $hottag)
              <a href="{{URL::to('/hashtag/'.$hottag->H_HASHTAG)}}"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#{{$hottag->H_HASHTAG}}</span></a>
              @endforeach
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
        @else
          <div class="text-center">Rất tiếc! Không có nội dung để hiển thị :(</div>
        @endif
    </div>
  </div>
</div>

  <!--XỬ LÝ LOAD MORE START-->
  @if($bai_viet->total() > 0)
  <script>
      var ENDPOINT = "{{ URL::to('/hoc-phan/'.$subject_get->HP_MA) }}"
      var page = 1;
      var maxPage = <?php echo  $bai_viet->lastPage(); ?>;

      if(page >= maxPage){
          $('.auto-load').html("Rất tiếc! Không còn bài viết để hiển thị :(");
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
  @endif
  <!--XỬ LÝ LOAD MORE END-->

  <!-- MAIN START -->
    <script>
        $(document).ready(function() {
          //|*****************************************************
          //|LIKE BÀI VIẾT START
          //|*****************************************************
          <?php if($userLog) { ?>
            $(document).on('click', '.like-post', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var $element = $(this);
                var number = $element.find('b').text();
                var BV_MA = $(this).data('post-id-value');
                //var _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                  url: '{{URL::to('/thich-bai-dang/')}}' +'/'+ BV_MA,
                  type: 'GET',
                  success: function(response) {
                    $element.removeClass('text-muted like-post');
                    $element.addClass('text-danger unlike-post');

                    number = parseInt(number) + 1;
                    $element.find('b').text(number);
                    //console.log(number);

                    //Notification start
                    $.ajax({
                        url: '{{URL::to('/thong-bao-thich-bai-dang/')}}' +'/'+ BV_MA,
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
            $(document).on('click', '.unlike-post', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var $element = $(this);
                var number = $element.find('b').text();
                var BV_MA = $(this).data('post-id-value');
                var BV_ND_MA = $(this).data('post-id-user-value');
                //var _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                  url: '{{URL::to('/huy-thich-bai-dang/')}}' +'/'+ BV_MA,
                  type: 'GET',
                  success: function(response) {
                    $element.removeClass('text-danger unlike-post');
                    $element.addClass('text-muted like-post');

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
          //|LIKE BÀI VIẾT END
          //|*****************************************************
        })
    </script>
  <!-- MAIN END -->
@endsection