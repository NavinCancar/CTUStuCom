@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-8">
            <div class="mb-3 mb-sm-0 d-flex">
              <h5 class="card-title fw-semibold">Bảng tin</h5>
            </div>
            <?php
              $alert = Session::get('alert');
              if ($alert && is_array($alert)) {
                  echo '<div class="text-notice text-notice-' . $alert['type'] . ' alert alert-' . $alert['type'] . '">';
                  echo $alert['content'];
                  echo '<i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = \'none\'"></i>';
                  echo '</div>';
                  Session::put('alert', null);
              }
              Session::put('alert',null);
            ?>
            <hr>
            <div class="d-block">
              @if($userLog)
              <button class="btn btn-primary me-2 mb-3" data-bs-toggle="collapse" data-bs-target="#thembaiviet"><i
                  class="fas fa-plus"></i> Thêm bài viết</button>
              @endif
              @if ($bai_viet->total() > 0)
              <button class="btn btn-outline-primary me-2 mb-3" data-bs-toggle="collapse" data-bs-target="#loc"><i
                  class="fa fa-filter"></i> Lọc bài viết</button>
              @endif
            </div>

            <div class="text-notice text-notice-success alert alert-success" id="alert-success" style="display: none">
              <span></span> 
              <i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = 'none'"></i>
            </div>
            <div class="text-notice text-notice-danger alert alert-danger" id="alert-danger" style="display: none">
              <span></span> 
              <i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = 'none'"></i>
            </div>

            @if($userLog)
            <!-- Thêm bài viết Start -->
            <div id="thembaiviet" class="collapse">
              <div class="card">
                <div class="card-body p-4">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Thêm bài viết mới</h5>
                    <form id="them" action="{{URL::to('/bai-dang')}}" method="post" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="mb-3 mt-3">
                        <div class="mb-3">
                          <label class="form-label">Tiêu đề <span class="text-danger">(*)</span></label>
                          <input type="text" class="form-control" placeholder="Nhập tiêu đề" id="title"  maxlength="150" name="BV_TIEUDE">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Nội dung <span class="text-danger">(*)</span></label>
                          <textarea class="form-control" rows="5" id="comment" name="BV_NOIDUNG"
                            placeholder="Nhập nội dung" id="desc"></textarea>
                        </div>
                        <div class="mb-3">
                          <label for="hashtag_input" class="form-label">Hashtag đính kèm <span class="text-danger">(tối đa 5 hashtag *)</span></label>
                          <div class="output"></div>
                          <input class="basic" name="BV_HASHTAG" placeholder="Hashtag đính kèm"/>

                          <input type="hidden" name="hashtags" id="hashtagsInput" value="">
                          <input type="hidden" name="hashtagsNew" id="hashtagsNewInput" value="">
                        </div>

                        <div class="mb-3">
                          <label for="formFileMultiple" class="form-label">Các file đính kèm (nếu có)</label>

                          <label for="file-input" class="ms-3 text-muted" style="cursor: pointer;">
                            <span class="btn btn-link" style="text-decoration: none;"><i class="fas fa-paperclip"></i> Thêm file</span>
                          </label>
                          <!-- Input type file ẩn -->
                          <input name="TN_FDK[]" type="file" id="file-input" style="display: none" multiple accept=".jpg, .jpeg, .png, .doc, .docx, .pdf, .xls, .xlsx, .ppt, .pptx"/>
                          <input type="hidden" name="linkFile" id="linkFileInput" value="">
                          <!-- Files Container -->
                          <div id="selected-files-container" class=" m-2"></div>
                          <!-- Images Container -->
                          <div  id="selected-images-container" class="m-2 mb-3 position-relative"></div>
                        </div>

                        <label for="exampleDataList" class="form-label">Học phần liên quan (nếu có)</label>
                        <input class="form-control" list="datalistOptions" id="exampleDataList"
                          placeholder="Tìm kiếm học phần" name="HP_MA">
                        <datalist id="datalistOptions">
                        @foreach($hoc_phan as $key => $hp)
                          <option value="{{$hp->HP_MA}}">{{ $hp->HP_TEN }}</option>
                        @endforeach
                        </datalist>
                        
                      </div>
                      <button type="button" class="btn btn-primary float-sm-end" id="dangbai-btn">Đăng bài</button>
                      <div class="text-center" style="display: none;" id="spinner">
                          <div class="spinner-border text-primary"></div>
                      </div>
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

                        <input type="hidden" name="KT_MA" value="">
                      </div>
                      <button type="submit" class="btn btn-primary float-sm-end">Lọc</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Lọc End -->

            @if ($bai_viet->total() > 0)
              <!--  Bài viết  -->
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
              <h5 class="card-title fw-semibold">Nổi bật</h5>
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
                    <div class="text-center mt-4 mb-2">Rất tiếc! Không có nội dung nổi bật để hiển thị :(</div>
                  @endif
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-body p-4">
                <div class="mb-3 mb-sm-0">
                  <h5 class="card-title fw-semibold">Hashtag</h5>
                  @if ($hashtag_hot->count() > 0)
                      @foreach($hashtag_hot as $key => $hh)
                      <a href="{{URL::to('/hashtag/'.$hh->H_HASHTAG)}}"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#{{$hh->H_HASHTAG}}</span></a>
                      @endforeach
                  @else
                    <div class="text-center mt-4 mb-2">Rất tiếc! Không có hashtag nổi bật để hiển thị :(</div>
                  @endif
                </div>
              </div>
            </div>
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
  @if($userLog)
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
      const inputElement = document.querySelector('.basic');
      const outputDiv = document.querySelector('.output');
      //outputDiv.innerHTML = `Mục đã chọn: ${selectedItems.map(item => item.name).join(', ')}`;
      outputDiv.innerHTML = '';
      selectedItems.forEach(function(item) {
        if (item.isNew) {
            outputDiv.innerHTML += `New: ${item.name}<br>`;
        } else {
            outputDiv.innerHTML += `Select: ${item.name}<br>`;
        }
      });

      //if(selectedItems!=null){
      //  inputElement.removeAttribute('required');
      //}
    });*/
    
    instance.on('change', () => {
      const selectedItems = instance.getItems();
        var form = $('#them');
        //|-----------------------------------------------------
        //|XỬ LÝ HASHTAG
        //|-----------------------------------------------------
        var hashtagItems = [];

        selectedItems.forEach(function(hashtag) {
          if (hashtag.isNew) {} 
          else {
            hashtagItems.push(hashtag);
          }
        });
        document.getElementById('hashtagsInput').value = JSON.stringify(hashtagItems);

        //|-----------------------------------------------------
        //|GỬI FORM
        //|-----------------------------------------------------
        var hashtags = form.find('input[name="hashtags"]').val();
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
                  kqGoiY += '<span class="cursor-pointer add-hashtag badge bg-secondary me-1 mb-1 p-1 px-2">'+ item.hashtag + "</span>";
              }

              $('.output').html(`Gợi ý hashtag: ${kqGoiY}`);

              $('.add-hashtag').on('click', function() {
                  var hashtag = $(this).text().trim();
                  instance.addItems({ name: hashtag });
              });
            }
            else $('.output').html(``);
          },
          error: function(error) {
              console.log(error);
          }
        });
    });
  </script>
  @endif
  
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
              /*Kiểm tra kết quả select
              console.log(response); */

              /*
                var html = '<ul>';
                response.forEach(function(item) {
                    html += '<li>' + item.SLBV_DINHKEM  + '</li>';
                });
                html += '</ul>';
                $('.output2').html(html);

                var html = '';
                $.each(response, function(index, item) {
                    html += "Tag: " + item.hashtag + ", Number: " + item.number + "<br>";
                });
              */

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
      var ENDPOINT = "{{ URL::to('/') }}"
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

  <!-- MAIN START-->
  <script type="module">
    //|-----------------------------------------------------
    //|KHAI BÁO FIRESTORE
    //|-----------------------------------------------------
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getFirestore, setDoc, addDoc, doc, collection, serverTimestamp, getDocs, query, where, orderBy, limit, or, onSnapshot, updateDoc, deleteDoc } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";
    import { getStorage, ref, uploadBytes, listAll, getDownloadURL, deleteObject  } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-storage.js";

    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyCM8jj3tql4LSIaPvjI6D9_BTLYnaspwks",
        authDomain: "ctu-student-community.firebaseapp.com",
        databaseURL: "https://ctu-student-community-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "ctu-student-community",
        storageBucket: "ctu-student-community.appspot.com",
        messagingSenderId: "977339665171",
        appId: "1:977339665171:web:9c200c8bc8907bd9ff28e6"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);
    const storage = getStorage(app);
    //-----------------------------------------------------------------------------------
    //***********************************************************************************
    //***********************************************************************************

    //BIẾN CHO UPLOAD ẢNH
    const fileInput = document.getElementById('file-input');
    const selectedFilesContainer = document.getElementById('selected-files-container');
    const selectedImagesContainer = document.getElementById('selected-images-container');
    var dontUse = [];

    $(document).ready(function() {
      $('#dangbai-btn').click(function(e) {
          e.preventDefault();

          const selectedItems = instance.getItems();
          var form = $(this).closest('form');
          var BV_TIEUDE = form.find('input[name="BV_TIEUDE"]').val();
          var BV_NOIDUNG = form.find('textarea[name="BV_NOIDUNG"]').val();

          form.find('.temp-notice').remove();
          form.find('input[name="BV_TIEUDE"]').css('border-color', '');
          form.find('textarea[name="BV_NOIDUNG"]').css('border-color', '');
          form.find('div.tokenfield.tokenfield-mode-tokens').css('border-color', '');

          if(BV_TIEUDE == ""){
            form.find('input[name="BV_TIEUDE"]').css('border-color', '#FA896B').after('<b class="text-danger px-0 fs-2 temp-notice">Trường này không thể rỗng</b>');
          }
          else if(BV_NOIDUNG == ""){
            form.find('textarea[name="BV_NOIDUNG"]').css('border-color', '#FA896B').after('<b class="text-danger px-0 fs-2 temp-notice">Trường này không thể rỗng</b>');
          }
          else if(selectedItems.length==0){
            form.find('div.tokenfield.tokenfield-mode-tokens').css('border-color', '#FA896B').after('<b class="text-danger px-0 fs-2 temp-notice">Trường này không thể rỗng</b>');
          }
          else{
            //|-----------------------------------------------------
            //|XỬ LÝ LINK FILE
            //|-----------------------------------------------------
            //Cho nút gửi xoay
            document.getElementById('dangbai-btn').style.display = 'none';
            document.getElementById('spinner').style.display = 'block';

            var urlFile = [];
            var TN_FDK = fileInput.files;

            if(TN_FDK.length > 0 && TN_FDK.length > dontUse.length){//Gửi có file
                (async () => {

                    for (var i = 0; i < TN_FDK.length; i++) {
                        //console.log("Selected File " + (i) + ": " + TN_FDK[i].name);
                        if (dontUse.indexOf(i) !== -1) {
                            // console.log(i + " đã tồn tại trong mảng dontUse.");
                            //Không xử lý
                        } else {
                            //console.log(i + " không tồn tại trong mảng dontUse.");
                            const file = TN_FDK[i];
                            
                            //STORAGE---------------------------------------
                            const name = `${Date.now()}_${file.name}`;
                            const folder = 'files';
                            const fullPath = `${folder}/${name}`;

                            //const storageRef = ref(storage, name); //Đường dẫn trực tiếp
                            const storageRef = ref(storage, fullPath);
                            //console.log('file: ',file);

                            await uploadBytes(storageRef, file);
                            const downloadURL = await getDownloadURL(storageRef); //Link file để add vào csdl
                            //console.log('Uploaded file:', downloadURL);
                            urlFile.push({name: name, link: downloadURL});
                        }
                    }
                    document.getElementById('linkFileInput').value = JSON.stringify(urlFile);
                    
                    selectedFilesContainer.innerHTML = '';
                    selectedImagesContainer.innerHTML = '';
                    $("input[name^='TN_FDK']").val("");
                    
                    TagAndForm ()
                })().catch((error) => {
                    console.error('Error uploading file:', error);
                });
                //console.log("Xoá: ", dontUse);
            }
            else{ //Gửi không có file
              TagAndForm ()
            }
  
            function TagAndForm (){
              //|-----------------------------------------------------
              //|XỬ LÝ HASHTAG
              //|-----------------------------------------------------
              var hashtagItems = [];
              var hashtagItemsNew = [];

              selectedItems.forEach(function(hashtag) {
                if (hashtag.isNew) {
                  hashtagItemsNew.push(hashtag);
                } else {
                  hashtagItems.push(hashtag);
                }
              });
              document.getElementById('hashtagsInput').value = JSON.stringify(hashtagItems);
              document.getElementById('hashtagsNewInput').value = JSON.stringify(hashtagItemsNew);

              //|-----------------------------------------------------
              //|GỬI FORM
              //|-----------------------------------------------------
              var HP_MA = form.find('input[name="HP_MA"]').val();
              var linkFile = form.find('input[name="linkFile"]').val();
              var hashtags = form.find('input[name="hashtags"]').val();
              var hashtagsNew = form.find('input[name="hashtagsNew"]').val();
              var _token = $('meta[name="csrf-token"]').attr('content'); 
              /*console.log("BV_TIEUDE:", BV_TIEUDE);
              console.log("BV_NOIDUNG:", BV_NOIDUNG);
              console.log("HP_MA:", HP_MA);
              console.log("linkFile:", linkFile);
              console.log("hashtags:", hashtags);
              console.log("hashtagsNew:", hashtagsNew);*/
              
              $.ajax({
                url: '{{URL::to('/bai-dang')}}',
                type: 'POST',
                data: {
                  BV_TIEUDE: BV_TIEUDE,
                  BV_NOIDUNG: BV_NOIDUNG,
                  HP_MA: HP_MA,
                  linkFile: linkFile,
                  hashtags: hashtags,
                  hashtagsNew: hashtagsNew,
                  _token: _token // Include the CSRF token in the data
                },
                success: function(response) {
                    $('#them')[0].reset();
                    document.getElementById('dangbai-btn').style.display = 'block';
                    document.getElementById('spinner').style.display = 'none';
                    form.find('input[name="BV_TIEUDE"]').css('border-color', '');
                    form.find('textarea[name="BV_NOIDUNG"]').css('border-color', '');
                    form.find('div.tokenfield.tokenfield-mode-tokens').css('border-color', '');
                    form.find('.temp-notice').remove();
                    document.getElementById('thembaiviet').classList.remove("show");

                    $('#alert-success span').html('Thêm bài viết thành công và đang chờ xét duyệt');
                    $('html, body').animate({
                        scrollTop: $('#alert-success').offset().top
                    });
                    document.getElementById('alert-success').style.display = 'block';
                    //console.log('Thành công');
                },
                error: function(error) {
                    // Handle errors here
                    $('#alert-danger span').html('Thêm bài viết thất bại');
                    $('html, body').animate({
                        scrollTop: $('#alert-danger').offset().top
                    });
                    document.getElementById('alert-danger').style.display = 'block';
                    console.log(error);
                }
              });

            }


          }
      });
      
      //|*****************************************************
      //|UPLOAD FILE START
      //|*****************************************************
      $('#file-input').on('click', function() {
          $("input[name^='TN_FDK']").val("");
          dontUse = [];
      });
      $('#file-input').on('change', function() {

          selectedFilesContainer.innerHTML = '';
          selectedImagesContainer.innerHTML = '';

          if (fileInput.files.length > 0) {
              for (let i = 0; i < fileInput.files.length; i++) {
                  const file = fileInput.files[i];
                  const fileType = file.type;
                  console.log(file);
                  // Kiểm tra loại file
                  if (fileType.startsWith('image/')) {
                      // Image
                      const imageUrl = URL.createObjectURL(file);
                      var divData = 
                          '<span data-value="'+i+'" class="rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block file-item">' +
                          '    <img src="'+imageUrl+'" width="100px" height="100px" alt="Banner Image" class="d-block mx-auto">' +
                          '    <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle file-item-btn" style="transform: translateX(-50%);"><i class="fas fa-times"></i></button>' +
                          '</span>';
                      selectedImagesContainer.insertAdjacentHTML('beforeend', divData);
                  } else{
                      var divData = 
                          '<span data-value="'+i+'" class="badge bg-secondary rounded-3 fw-semiboldms-0 p-1 px-3 me-2 mb-2 text-white file-item">';
                      if (fileType.startsWith('application/pdf')) {// PDF
                          divData += '    <i class="fas fa-file-pdf fs-5 me-2"></i> ';
                      }
                      else if (fileType.startsWith('application/msword') || fileType.startsWith('application/vnd.openxmlformats-officedocument.wordprocessingml.document')) { //Word
                          divData += '    <i class="fas fa-file-word fs-5 me-2"></i> ';
                      }
                      else if (fileType.startsWith('application/vnd.ms-excel') || fileType.startsWith('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')) {// Excel
                          divData += '    <i class="fas fa-file-excel fs-5 me-2"></i> ';
                      }
                      else if (fileType.startsWith('application/vnd.ms-powerpoint') || fileType.startsWith('application/vnd.openxmlformats-officedocument.presentationml.presentation')) {// Powerpoint
                          divData += '    <i class="fas fa-file-powerpoint fs-5 me-2"></i> ';
                      }
                      else{
                          divData += '    <i class="fas fa-file fs-5 me-2"></i> ';
                      }
                          divData += file.name + 
                          '    <button class="btn btn-secondary btn-sm file-item-btn"><i class="fas fa-times"></i></button>' +
                          '</span>';
                      selectedFilesContainer.insertAdjacentHTML('beforeend', divData);
                  }
              }
          }

          $('.file-item-btn').on('click', function() {
              const fileItem = $(this).closest('.file-item');
              const dataValue = fileItem.data('value');

              fileItem.remove();
              dontUse.push(dataValue);

              // Gán giá trị của mảng vào một input ẩn trong form $dontUseArray = json_decode($request->input('dontUse'));
              // document.getElementById('dontUseInput').value = JSON.stringify(dontUse);
              console.log("Xoá " + dataValue + ": " + dontUse);
          });
      });
      //|*****************************************************
      //|UPLOAD FILE END
      //|*****************************************************  

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
      //|*****************************************************
      //|LƯU BÀI VIẾT START
      //|*****************************************************
      <?php if($userLog) { ?>
        $(document).on('click', '.bookmark-post', function() {
            // Truy cập giá trị của tham số từ thuộc tính dữ liệu
            var $element = $(this);
            var BV_MA = $(this).data('post-id-value');
            //var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
              url: '{{URL::to('/luu-bai-dang/')}}' +'/'+ BV_MA,
              type: 'GET',
              success: function(response) {
                $element.removeClass('bookmark-post');
                $element.addClass('unbookmark-post');

                $element.empty();
                $element.html(`<i class="fas fa-vote-yea"></i> Đã lưu`);
                //console.log(number);
              },
              error: function(error) {
                console.log(error);
              }
            });
                
        });
        $(document).on('click', '.unbookmark-post', function() {
            // Truy cập giá trị của tham số từ thuộc tính dữ liệu
            var $element = $(this);
            var BV_MA = $(this).data('post-id-value');
            //var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
              url: '{{URL::to('/huy-luu-bai-dang/')}}' +'/'+ BV_MA,
              type: 'GET',
              success: function(response) {
                $element.removeClass('unbookmark-post');
                $element.addClass('bookmark-post');

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
      //|LƯU BÀI VIẾT END
      //|*****************************************************
    });
  </script>
  <!--MAIN END-->
@endsection