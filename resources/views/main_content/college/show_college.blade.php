@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-8">
        <div class="mb-3 mb-sm-0">
          <h5 class="card-title fw-semibold">Bảng tin: <?php echo $college->KT_TEN ?></h5>
          <span class="px-3 fw-semibold">Xem các bạn <?php echo $college->KT_TEN ?> đang bàn luận về điều gì.</span><br>
          <i class="fs-3 px-3"><?php if($count_bai_viet) echo $count_bai_viet; else echo '0'; ?> bài viết</i><br>
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
                <form id="form-loc" role="form" action="{{URL::to('/loc-bai-viet')}}" method="POST">
                {{ csrf_field() }}
                  <div class="mb-3 mt-3">
                    <div class="row mb-3 ms-0">
                      <div class="col-lg-4 col-md-4 col-sm-12 ps-0">
                        <label class="form-label">Xếp theo</label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="radio" value="hot" name="BV_SAPXEP" checked>
                        <label class="form-check-label">
                          Nổi bật
                        </label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="radio" value="new" name="BV_SAPXEP">
                        <label class="form-check-label">
                          Mới nhất
                        </label>
                      </div>
                    </div>

                    <label class="form-label">Đính kèm</label>
                    <div class="row mb-4 ms-0">
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="checkbox" value="img" name="FDK_LOAI[]" checked>
                        <label class="form-check-label">
                          Hình ảnh
                        </label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="checkbox" value="pdf" name="FDK_LOAI[]" checked>
                        <label class="form-check-label">
                          PDF
                        </label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="checkbox" value="doc" name="FDK_LOAI[]" checked>
                        <label class="form-check-label">
                          Word
                        </label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="checkbox" value="xls" name="FDK_LOAI[]" checked>
                        <label class="form-check-label">
                          Excel
                        </label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="checkbox" value="ppt" name="FDK_LOAI[]" checked>
                        <label class="form-check-label">
                          Power point
                        </label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="checkbox" value="empty" name="FDK_LOAI[]" checked>
                        <label class="form-check-label">
                          Không kèm file
                        </label>
                      </div>
                    </div>

                    <div class="row mb-3 ms-0">
                      <div class="col-lg-4 col-md-4 col-sm-12 ps-0">
                        <label class="form-label">Từ khoá đi kèm</label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="radio" value="phrase" name="TU_KHOA_TT" checked>
                        <label class="form-check-label">
                          Tìm cả cụm
                        </label>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                        <input class="form-check-input" type="radio" value="word" name="TU_KHOA_TT">
                        <label class="form-check-label">
                          Tìm từng từ
                        </label>
                      </div>
                      <input class="form-control" type="text" name="TU_KHOA" placeholder="Từ khoá tìm kiếm">
                    </div>

                    <label class="form-label">Hashtag đi kèm</label>
                    <div class="mb-3">
                      <div class="output2"></div>
                      <input class="basic2" placeholder="Hashtag đính kèm" />
                      <input type="hidden" name="hashtags2" id="hashtagsInput2" value="">
                    </div>

                    <label class="form-label">Học phần liên quan</label>
                    <input class="form-control" list="datalistOptions" name="HP_MA" placeholder="Tìm kiếm học phần">
                    <datalist id="datalistOptions">
                      @foreach($hoc_phan as $key => $hp)
                        <option value="{{$hp->HP_MA}}">{{ $hp->HP_TEN }}</option>
                      @endforeach
                    </datalist>

                    <input type="hidden" name="KT_MA" value="<?php echo $college->KT_MA ?>">
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
            @if ($bai_viet_hot->count() > 0)
                @foreach($bai_viet_hot as $key => $bvh)
                <a href="{{URL::to('/bai-dang/'.$bvh->BV_MA)}}" class="fs-4 d-block mb-1"><i class="fas fa-angle-double-right"></i> &ensp; {{ $bvh->BV_TIEUDE }}</a>
                @endforeach
            @else
              <div class="text-cente mt-4 mb-2">Rất tiếc! Không có nội dung nổi bật để hiển thị :(</div>
            @endif
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
        <h5 class="card-title fw-semibold">Học phần nổi bật của khoa/trường</h5>
      </div>
      <hr>
      <div class="card">
        <div class="card-body p-4">
          <div class="mb-3 mb-sm-0">
            <h5 class="card-title fw-semibold">Học phần</h5>
            @if ($hoc_phan_hot->count() > 0)
                @foreach($hoc_phan_hot as $key => $hph)
                  @if($hph->HP_MA != null)
                    <?php
                      $hoc_phan_tim= $hoc_phan->where('HP_MA', $hph->HP_MA)->first();
                    ?>
                    <a href="{{URL::to('/hoc-phan/'.$hph->HP_MA)}}" class="d-block">
                      <span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-folder"></i> {{ $hoc_phan_tim->HP_MA }} {{$hoc_phan_tim->HP_TEN}}</span>
                    </a>
                  @endif
                @endforeach
            @else
              <div class="text-center mt-4 mb-2">Rất tiếc! Không có học phần nổi bật để hiển thị :(</div>
            @endif
            
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
        maxItems: 5,
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
        minChars: 0,
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

      // Sự kiện thay đổi trạng thái của tokenfield, hiển thị cả item lẫn
      instance2.on('change', () => {
        const selectedItems2 = instance2.getItems();
          var form = $('#form-loc');
          //|-----------------------------------------------------
          //|XỬ LÝ HASHTAG
          //|-----------------------------------------------------
          var hashtagItems = [];

          selectedItems2.forEach(function(hashtag) {
            if (hashtag.isNew) {} 
            else {
              hashtagItems.push(hashtag);
            }
          });
          document.getElementById('hashtagsInput2').value = JSON.stringify(hashtagItems);

          //|-----------------------------------------------------
          //|GỬI FORM
          //|-----------------------------------------------------
          var hashtags = form.find('input[name="hashtags2"]').val();
          var _token = $('meta[name="csrf-token"]').attr('content'); 
          
          $.ajax({
            url: '{{URL::to('/goi-y-hashtag')}}',
            type: 'POST',
            data: {
              hashtags: hashtags,
              _token: _token
            },
            success: function(response) {
              if(response.length > 0){
                var kqGoiY = '';
                for (var i = 0; i < response.length && i < 10; i++) {
                    var item = response[i];
                    kqGoiY += '<span class="cursor-pointer add-hashtag2 badge bg-secondary me-1 mb-1 p-1 px-2">'+ item.hashtag + "</span>";
                }

                $('.output2').html(`Gợi ý hashtag: ${kqGoiY}`);

                $('.add-hashtag2').on('click', function() {
                    var hashtag = $(this).text().trim();
                    instance2.addItems({ name: hashtag });
                });
              }
              else $('.output2').html(``);
            },
            error: function(error) {
                console.log(error);
            }
          });
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