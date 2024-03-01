@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-8">
        <div class="mb-3 mb-sm-0">
          <h5 class="card-title fw-semibold">Bảng tin: <?php echo $college->KT_TEN ?></h5>
          <p class=" fw-semibold">Xem các bạn <?php echo $college->KT_TEN ?> đang bàn luận về điều gì.</p>
        </div>
      
        <hr>
        <div class="d-block">
          <a href="{{URL::to('/danh-sach-khoa-truong')}}" class="btn btn-primary me-2 mb-3">
              <i class="fas fa-stream"></i> Danh sách các khoa trường</a>
          @if ($bai_viet->total() > 0)
          <button class="btn btn-outline-primary me-2 mb-3" data-bs-toggle="collapse" data-bs-target="#loc"><i
              class="fa fa-filter"></i> Lọc bài viết</button>
          @endif
        </div>
        <!-- Lọc Start -->
        <div id="loc" class="collapse">
          <div class="card">
            <div class="card-body p-4">
              <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Lọc bài viết</h5>
                <form id="form">
                  <div class="mb-3 mt-3">
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-sm-12 ">
                        <label for="exampleDataList" class="form-label">Xếp theo:</label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="checkbox" value="" name="group_loai" checked>
                        <label class="form-check-label" for="flexCheckDefault">
                          Nổi bật
                        </label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="checkbox" value="" name="group_loai">
                        <label class="form-check-label" for="flexCheckDefault">
                          Mới nhất
                        </label>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-sm-6 ">
                        <label for="exampleDataList" class="form-label">Đính kèm:</label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="checkbox" value="" name="group_loai" checked>
                        <label class="form-check-label" for="flexCheckDefault">
                          Ảnh
                        </label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="checkbox" value="" name="group_loai" checked>
                        <label class="form-check-label" for="flexCheckDefault">
                          Pdf
                        </label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="checkbox" value="" name="group_loai" checked>
                        <label class="form-check-label" for="flexCheckDefault">
                          Word
                        </label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="checkbox" value="" name="group_loai" checked>
                        <label class="form-check-label" for="flexCheckDefault">
                          Khác
                        </label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="checkbox" value="" name="group_loai">
                        <label class="form-check-label" for="flexCheckDefault">
                          Không kèm file
                        </label>
                      </div>
                    </div>

                    <label for="exampleDataList" class="form-label">Hashtag đi kèm:</label>
                    <div class="mb-3">
                      <div class="output2"></div>
                      <input class="basic2" placeholder="Hashtag đính kèm" />
                    </div>

                    <label for="exampleDataList" class="form-label">Học phần liên quan:</label>
                    <input class="form-control" list="datalistOptions" id="exampleDataList"
                      placeholder="Tìm kiếm học phần">
                    <datalist id="datalistOptions">
                        @foreach($hoc_phan as $key => $hp)
                          <option value="{{$hp->HP_MA}}">{{ $hp->HP_TEN }}</option>
                        @endforeach
                    </datalist>
                  </div>
                  <button type="submit" class="btn btn-primary float-sm-end">Lọc</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Lọc End -->

        @if ($bai_viet->total() > 0)
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

    <div class="col-lg-4">
      <div class="mb-3 mb-sm-0">
        <h5 class="card-title fw-semibold">Nổi bật trên bảng tin khoa/trường</h5>
      </div>
      <hr>
      <div class="card">
        <div class="card-body p-4">
          <div class="mb-3 mb-sm-0">
            <h5 class="card-title fw-semibold">Bài viết</h5>
            <a href="javascript:void(0)" class="fs-4">
              Bán các giáo trình anh văn căn bản giá siêu rẻ
            </a><br>
            <a href="javascript:void(0)" class="fs-4">
              Chuẩn bị gì khi học quân sự?
            </a><br>
            <a href="javascript:void(0)" class="fs-4">
              Sơ đồ khu II
            </a><br>
            <a href="javascript:void(0)" class="fs-4">
              Chào mừng tân sinh viên
            </a><br>
            <a href="javascript:void(0)" class="fs-4">
              Lịch nghỉ lễ
            </a><br>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body p-4">
          <div class="mb-3 mb-sm-0">
            <h5 class="card-title fw-semibold">Hashtag</h5>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#ung_dung</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#lay_y_kien</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#ung_dung</span></a>
          </div>
        </div>
      </div>
      <div class="mb-3 mb-sm-0">
        <h5 class="card-title fw-semibold">Khám phá bảng tin khoa/trường khác</h5>
      </div>
      <hr>
      <div class="card">
        <div class="card-body p-4">
          <div class="mb-3 mb-sm-0">
            <h5 class="card-title fw-semibold">Khoa/trường</h5>
            <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-school"></i> Trường Kinh tế</span></a><br>
            <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-school"></i> Khoa Khoa học tự nhiên</span></a><br>
            <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-school"></i> Khoa Chính trị</span></a><br>
            <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-school"></i> Khoa Luật</span></a><br>
            <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-school"></i> Trường Bách khoa</span></a><br>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  <!--XỬ LÝ HASHTAG START-->
  <script src="{{asset('public/js/tokenfield.web.js')}}"></script>

  <script>
    //Lọc bài
      const myItems2 = [
        <?php 
        foreach($hashtag as $key => $h){
          echo "{ name: '".$h->H_HASHTAG."' }, ";
        }
        ?>
      ];
      const instance2 = new Tokenfield({
        el: document.querySelector('.basic2'),
        items: myItems2,

        form: true, // Listens to reset event
        mode: 'tokenfield', // tokenfield or list.
        addItemOnBlur: false,
        addItemsOnPaste: false,
        keepItemsOrder: true,
        setItems: [], // array of pre-selected items
        newItems: false,
        multiple: true,
        minLength: 0,
        keys: {
          17: 'ctrl',
          16: 'shift',
          91: 'meta',
          8: 'delete', // Backspace
          27: 'esc',
          37: 'left',
          38: 'up',
          39: 'right',
          40: 'down',
          46: 'delete',
          65: 'select', // A
          67: 'copy', // C
          88: 'cut', // X
          32: 'delimiter', //Space
          9: 'delimiter', // Tab
          13: 'delimiter', // Enter
          108: 'delimiter' // Numpad Enter
        },
        matchRegex: '{value}',
        matchFlags: 'i',
        matchStart: false,
        matchEnd: false,
        delimiters: [], // array of strings
        copyProperty: 'name',
        copyDelimiter: ', ',
        placeholder: null,
        inputType: 'text',
        minChars: 1,
        maxSuggest: 10,
        maxSuggestWindow: 10,
        filterSetItems: true,
        filterMatchCase: false,
        singleInput: false, // true, 'selector', or an element.
        singleInputValue: 'name',
        singleInputDelimiter: ', ',
        itemLabel: 'name',
        itemName: 'items',
        newItemName: 'items_new',
        itemValue: 'name',
        newItemValue: 'name',
        itemData: 'name',
        validateNewItem: null
      });

      /*
      const instance = new Tokenfield({
            el: document.querySelector('.basic'),
            remote: {
              type: 'GET', // GET or POST
              url: null, // Full url.
              queryParam: 'q', // query parameter
              delay: 300, // delay in ms
              timestampParam: 't',
              params: {},
              headers: {}
            },
      });*/
      // Sự kiện thay đổi trạng thái của tokenfield, hiển thị cả item lẫn
      instance2.on('change', () => {
        const selectedItems2 = instance2.getItems();
        const outputDiv2 = document.querySelector('.output2');
        outputDiv2.innerHTML = `Mục đã chọn: ${selectedItems2.map(item => item.name).join(', ')}`;
      });
  </script>
  <!--XỬ LÝ HASHTAG END-->

  <!--XỬ LÝ LOAD MORE START-->
  @if($bai_viet->total() > 0)
  <script>
      var ENDPOINT = "{{ URL::to('/khoa-truong/'.$college->KT_MA) }}"
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