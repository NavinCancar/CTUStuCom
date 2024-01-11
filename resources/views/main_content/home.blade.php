@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-8">
            <div class="mb-3 mb-sm-0 d-flex">
              <h5 class="card-title fw-semibold">Bảng tin</h5>
            </div>
            <hr>
            <div class="d-block">
              @if($userLog)
              <button class="btn btn-primary me-2 mb-3" data-bs-toggle="collapse" data-bs-target="#thembaiviet"><i
                  class="fas fa-plus"></i> Thêm bài viết</button>
              @endif
              <button class="btn btn-outline-primary me-2 mb-3" data-bs-toggle="collapse" data-bs-target="#loc"><i
                  class="fa fa-filter"></i> Lọc bài viết</button>
            </div>

            @if($userLog)
            <!-- Thêm bài viết Start -->
            <div id="thembaiviet" class="collapse">
              <div class="card">
                <div class="card-body p-4">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Thêm bài viết mới</h5>
                    <form id="form" action="{{URL::to('/bai-dang')}}" method="post">
                      {{ csrf_field() }}
                      <div class="mb-3 mt-3">
                        <label class="form-label">Tiêu đề <span class="text-danger">(*)</span>:</label>
                        <input type="text" class="form-control mb-3" placeholder="Nhập tiêu đề" id="title" name="BV_TIEUDE" required="">
                        <label class="form-label">Nội dung <span class="text-danger">(*)</span>:</label>
                        <textarea class="form-control mb-3" rows="5" id="comment" name="BV_NOIDUNG"
                          placeholder="Nhập nội dung" id="desc" required=""></textarea>
                        <div class="mb-3">
                          <label for="hashtag_input" class="form-label">Hashtag đính kèm <span class="text-danger">(tối đa 5 hashtag *)</span>:</label>
                          <div class="output"></div>
                          <input class="basic" placeholder="Hashtag đính kèm"/>
                        </div>
                        <div class="mb-3">
                          <label for="formFileMultiple" class="form-label">Các file đính kèm (nếu có):</label>
                          <input class="form-control" type="file" id="formFileMultiple" multiple name="FILE">
                        </div>
                        <label for="exampleDataList" class="form-label">Học phần liên quan (nếu có):</label>
                        <input class="form-control" list="datalistOptions" id="exampleDataList"
                          placeholder="Tìm kiếm học phần" name="HP_MA">
                        <datalist id="datalistOptions">
                        @foreach($hoc_phan as $key => $hp)
                          <option value="{{$hp->HP_MA}}">{{ $hp->HP_TEN }}</option>
                        @endforeach
                        </datalist>
                      </div>
                      <button type="submit" class="btn btn-primary float-sm-end">Đăng bài</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endif
            <!-- Thêm bài viết End -->
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
                          <input class="basic2" placeholder="e.g. HTML, JavaScript, CSS" />
                        </div>

                        <label for="exampleDataList" class="form-label">Học phần liên quan:</label>
                        <input class="form-control" list="datalistOptions" id="exampleDataList"
                          placeholder="Tìm kiếm học phần">
                        <datalist id="datalistOptions">
                          <option value="CT204">
                          <option value="ML101">
                          <option value="CT212">
                        </datalist>
                      </div>
                      <button type="submit" class="btn btn-primary float-sm-end">Lọc</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Lọc End -->

            <!--  Bài viết  -->
            <div id="post_container">
              @include('main_component.post_loadmore')
            </div>

            <div class="text-center">
                <button class="btn btn-primary load-more-data"><i class="fa fa-refresh"></i> Xem thêm</button>
            </div>
            <!-- Data Loader -->
            <div class="auto-load text-center" style="display: none;">
                <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                    <path fill="#000"
                          d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                        <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                                          from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                    </path>
                </svg>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Nổi bật</h5>
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
                  <a href="./tag.php"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
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
            <div class="card">
              <div class="card-body p-4">
                <div class="mb-3 mb-sm-0">
                  <h5 class="card-title fw-semibold">Học phần</h5>
                  <a href="hoc-phan.php"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-folder"></i> CT101 Kỹ
                    năng đại học</span></a><br>
                  <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-folder"></i> CT101 Nền
                    tảng công nghệ thông tin</span></a><br>
                  <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-folder"></i> CT101 Triết
                    Mác Lênin</span></a><br>
                  <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-folder"></i> CT101 Lịch
                    sử Đảng</span></a><br>
                  <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-folder"></i> CT101 Chủ
                    nghĩa xã hội khoa học</span></a><br>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



  <!--Xử lý hashtag Start-->
  <script src="{{asset('public/js/tokenfield.web.js')}}"></script>
  
  <script>
    //Thêm bài
    const myItems = [
      <?php 
        foreach($hashtag as $key => $h){
          echo "{ name: '".$h->H_HASHTAG."' }, ";
        }
      ?>
    ];
    const instance = new Tokenfield({
      el: document.querySelector('.basic'),
      items: myItems,

      form: true, // Listens to reset event
      mode: 'tokenfield', // tokenfield or list.
      addItemOnBlur: false,
      addItemsOnPaste: false,
      keepItemsOrder: true,
      setItems: [], // array of pre-selected items
      newItems: true,
      multiple: true,
      maxItems: 5,
      minLength: 1,
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

    //******** UPDATE FUTURE: Gợi ý hashtag chọn: Sự kiện thay đổi trạng thái của tokenfield, hiển thị cả item lẫn
    /*instance.on('change', () => {
      const selectedItems = instance.getItems();
      const outputDiv = document.querySelector('.output');
      outputDiv.innerHTML = `Mục đã chọn: ${selectedItems.map(item => item.name).join(', ')}`;
    });*/
  </script>

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
  <!--Xử lý hashtag End-->

  <!--Xử lý load more Start-->
  <script>
      var ENDPOINT = "{{ URL::to('/') }}"
      var page = 1;

      $(".load-more-data").click(function(){
          page++;
          infinteLoadMore(page);
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
              }
          })
              .done(function (response) {
                  if (response.html == '') {
                      $('.auto-load').html("Rất tiếc! Không còn bài viết để hiển thị :(");
                      $('.load-more-data').hide();
                      return;
                  }
                  $('.auto-load').hide();
                  $("#post_container").append(response.html);
              })
              .fail(function (jqXHR, ajaxOptions, thrownError) {
                  console.log('Server error occured');
              });
      }
  </script>
  <!--Xử lý load more End-->
@endsection