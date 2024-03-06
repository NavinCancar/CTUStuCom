@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
    <div class="container-fluid">
      <div class="row" style="display: none;">
        <div class="col-lg-12">
          <div class="mb-3 mb-sm-0 d-flex">
            <h5 class="card-title fw-semibold">Kết quả lọc bài viết<?php if($data_filter['KT_MA']) echo ': '.$data_filter['KT_TEN'].'';?></h5>
            <!--<div id="data_filter" data-bv-sapxep="{{ $data_filter['BV_SAPXEP'] }}" data-hashtags="{{ $data_filter['hashtags'] }}" 
            data-fdk-loai="{{ json_encode($data_filter['FDK_LOAI']) }}" data-tu-khoa-tt="{{ $data_filter['TU_KHOA_TT'] }}" 
            data-tu-khoa="{{ $data_filter['TU_KHOA'] }}" data-hp-ma="{{ $data_filter['HP_MA'] }}" data-kt-ma="{{ $data_filter['KT_MA'] }}"></div>-->

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
            <button class="btn btn-outline-primary me-2 mb-3" data-bs-toggle="collapse" data-bs-target="#loc"><i
                class="fa fa-filter"></i> Lọc bài viết</button>
          </div>

          <div class="text-notice text-notice-success alert alert-success" id="alert-success" style="display: none">
            <span></span> 
            <i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = 'none'"></i>
          </div>
          <div class="text-notice text-notice-danger alert alert-danger" id="alert-danger" style="display: none">
            <span></span> 
            <i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = 'none'"></i>
          </div>

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
                          <label class="form-label">Xếp theo:</label>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                          <input class="form-check-input" type="radio" value="hot" name="BV_SAPXEP" <?php if($data_filter['BV_SAPXEP'] == "hot") echo "checked" ?>>
                          <label class="form-check-label">
                            Nổi bật
                          </label>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                          <input class="form-check-input" type="radio" value="new" name="BV_SAPXEP" <?php if($data_filter['BV_SAPXEP'] == "new") echo "checked" ?>>
                          <label class="form-check-label">
                            Mới nhất
                          </label>
                        </div>
                      </div>

                      <?php $FDK_LOAI = $data_filter['FDK_LOAI']; ?>
                      <label class="form-label">Đính kèm:</label>
                      <div class="row mb-4 ms-0">
                        <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                          <input class="form-check-input" type="checkbox" value="img" name="FDK_LOAI[]" <?php if (is_array($FDK_LOAI) && in_array('img', $FDK_LOAI)) echo 'checked'; ?>>
                          <label class="form-check-label">
                            Hình ảnh
                          </label>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                          <input class="form-check-input" type="checkbox" value="pdf" name="FDK_LOAI[]" <?php if (is_array($FDK_LOAI) && in_array('pdf', $FDK_LOAI)) echo 'checked'; ?>>
                          <label class="form-check-label">
                            PDF
                          </label>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                          <input class="form-check-input" type="checkbox" value="doc" name="FDK_LOAI[]" <?php if (is_array($FDK_LOAI) && in_array('doc', $FDK_LOAI)) echo 'checked'; ?>>
                          <label class="form-check-label">
                            Word
                          </label>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                          <input class="form-check-input" type="checkbox" value="xls" name="FDK_LOAI[]" <?php if (is_array($FDK_LOAI) && in_array('xls', $FDK_LOAI)) echo 'checked'; ?>>
                          <label class="form-check-label">
                            Excel
                          </label>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                          <input class="form-check-input" type="checkbox" value="ppt" name="FDK_LOAI[]" <?php if (is_array($FDK_LOAI) && in_array('ppt', $FDK_LOAI)) echo 'checked'; ?>>
                          <label class="form-check-label">
                            Power point
                          </label>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                          <input class="form-check-input" type="checkbox" value="" id="remove-all-FDK_LOAI" <?php if ($FDK_LOAI == null) echo 'checked'; ?>>
                          <label class="form-check-label">
                            Không kèm file
                          </label>
                        </div>
                      </div>

                      <div class="row mb-3 ms-0">
                        <div class="col-lg-4 col-md-4 col-sm-12 ps-0">
                          <label class="form-label">Từ khoá đi kèm:</label>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                          <input class="form-check-input" type="radio" value="phrase" name="TU_KHOA_TT" <?php if($data_filter['TU_KHOA_TT'] == "phrase") echo "checked" ?>>
                          <label class="form-check-label">
                            Tìm cả cụm
                          </label>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                          <input class="form-check-input" type="radio" value="word" name="TU_KHOA_TT" <?php if($data_filter['TU_KHOA_TT'] == "word") echo "checked" ?>>
                          <label class="form-check-label">
                            Tìm từng từ
                          </label>
                        </div>
                        <input class="form-control" type="text" name="TU_KHOA" placeholder="Từ khoá tìm kiếm" value="<?php echo $data_filter['TU_KHOA'] ?>">
                      </div>

                      <label class="form-label">Hashtag đi kèm:</label>
                      <div class="mb-3">
                        <div class="output2"></div>
                        <input class="basic2" placeholder="Hashtag đính kèm" />
                        <input type="hidden" name="hashtags2" id="hashtagsInput2" value="">
                      </div>

                      <label class="form-label">Học phần liên quan:</label>
                      <input class="form-control" list="datalistOptions" name="HP_MA" placeholder="Tìm kiếm học phần" <?php if($data_filter['HP_MA']) echo 'value="'.$data_filter['HP_MA'].'"'; ?>>
                      <datalist id="datalistOptions">
                        @foreach($hoc_phan as $key => $hp)
                          <option value="{{$hp->HP_MA}}">{{ $hp->HP_TEN }}</option>
                        @endforeach
                      </datalist>

                      <input type="hidden" name="KT_MA" <?php if($data_filter['KT_MA']) echo 'value="'.$data_filter['KT_MA'].'"'; else echo 'value=""'?>>
                    </div>
                    <button type="submit" class="btn btn-primary float-sm-end">Lọc</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Lọc End -->

          @if ($bai_viet->count() > 0)
            <!--  Bài viết  -->
            <div id="post_container">
              @include('main_component.post_loadmore')
            </div>

            <div class="text-center">Rất tiếc! Không còn bài viết để hiển thị :(</div>
          @else
            <div class="text-center">Rất tiếc! Không có nội dung để hiển thị :(</div>
          @endif
        </div>
      </div>
    </div>

    <div class="auto-load text-center">
        <div class="spinner-border text-primary"></div>
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
        setItems: <?php if(!empty($data_filter['hashtags'])) echo $data_filter['hashtags']; else echo '[]' ?>, // array of pre-selected items
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
      
      // Sự kiện thay đổi trạng thái của tokenfield, hiển thị cả item lẫn
      instance2.on('change', () => {
        suggestHashtag2();
      });

      <?php if(!empty($data_filter['hashtags'])) echo "suggestHashtag2();"; ?>

      function suggestHashtag2(){
        const selectedItems2 = instance2.getItems();
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
        var form = $('#form-loc');
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
      }
  </script>
  <!--XỬ LÝ HASHTAG END-->

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

    $(document).ready(function() {
      //|*****************************************************
      //|FILTER 6: FILE ĐÍNH KÈM START
      //|*****************************************************
      //BIẾN FILTER 6: FILE ĐÍNH KÈM
      var bv_img = [];
      var bv_pdf = [];
      var bv_doc = [];
      var bv_xls = [];
      var bv_ppt = [];
      var bv_with_file =[];
      var filterType = <?php echo json_encode($data_filter['FDK_LOAI']) ?>;

      (async () => {
        const qfile = query(
            collection(db, "FILE_DINH_KEM"), 
            where('ND_NHAN_MA', '==', 0),
            where('ND_GUI_MA', '==', 0),
            where('BV_MA', '!=', 0),
            where('BL_MA', '==', 0),
            where('TN_THOIGIANGUI', '==', null)
        );

        const querySnapshotfile = await getDocs(qfile);

        querySnapshotfile.forEach((doc) => {
            const fileName = doc.data().FDK_TEN;
            const fileLink = doc.data().FDK_DUONGDAN;
            const fileExtension = fileName.split('.').pop().toLowerCase();

            if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                if (bv_img.indexOf(doc.data().BV_MA) === -1) {
                    bv_img.push(doc.data().BV_MA);
                }
            }
            else if (['pdf'].includes(fileExtension)) {
                if (bv_pdf.indexOf(doc.data().BV_MA) === -1) {
                    bv_pdf.push(doc.data().BV_MA);
                }
            }
            else if (['docx', 'doc'].includes(fileExtension)) {
                if (bv_doc.indexOf(doc.data().BV_MA) === -1) {
                    bv_doc.push(doc.data().BV_MA);
                }
            }
            else if (['xlsx', 'xls'].includes(fileExtension)) {
                if (bv_xls.indexOf(doc.data().BV_MA) === -1) {
                    bv_xls.push(doc.data().BV_MA);
                }
            }
            else if (['ppt', 'pptx'].includes(fileExtension)) {
                if (bv_ppt.indexOf(doc.data().BV_MA) === -1) {
                    bv_ppt.push(doc.data().BV_MA);
                }
            }
        });

        if (filterType == null) {
            bv_with_file.push(...bv_img);
            bv_with_file.push(...bv_pdf);
            bv_with_file.push(...bv_doc);
            bv_with_file.push(...bv_xls);
            bv_with_file.push(...bv_ppt);

            $('.card.card-post').each(function() {
              var BV_MA = $(this).data('post-id-value');
              //console.log(BV_MA);
              if (bv_with_file.includes(BV_MA)) {
                $(this).remove();
              }
            });
        }
        else{
            //var filterType = ["img","pdf","doc","xls","ppt"]; or null
            if (filterType.includes("img")) bv_with_file.push(...bv_img);
            if (filterType.includes("pdf")) bv_with_file.push(...bv_pdf);
            if (filterType.includes("doc")) bv_with_file.push(...bv_doc);
            if (filterType.includes("xls")) bv_with_file.push(...bv_xls);
            if (filterType.includes("ppt")) bv_with_file.push(...bv_ppt);
            
            $('.card.card-post').each(function() {
              var BV_MA = $(this).data('post-id-value');
              //console.log(BV_MA);
              if (!bv_with_file.includes(BV_MA)) {
                $(this).remove();
              }
            });
        }

        $('.row').show();
        $('.auto-load').hide();
      })().catch((error) => {
          console.error("Error in script: ", error);
      });

      //|*****************************************************
      //|FILTER 6: FILE ĐÍNH KÈM END
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
      //|*****************************************************
      //|LỌC BÀI VIẾT START
      //|*****************************************************

      //|-----------------------------------------------------
      //|CHECKBOX
      //|-----------------------------------------------------
      $('#remove-all-FDK_LOAI').change(function() {
          var isChecked = $(this).prop('checked');
          if (isChecked) $('input[name="FDK_LOAI[]"]').prop('checked', false);

          var anyChecked = $('input[name="FDK_LOAI[]"]:checked').length > 0;
          if (!anyChecked) {
            $(this).prop('checked', true);
          }
      });
      $('input[name="FDK_LOAI[]"]').change(function() {
          var anyChecked = $('input[name="FDK_LOAI[]"]:checked').length > 0;
          if (anyChecked) $('#remove-all-FDK_LOAI').prop('checked', false);
      });


      //|-----------------------------------------------------
      //|HIGHLIGHT
      //|-----------------------------------------------------
      <?php if($data_filter['TU_KHOA'] != "") { ?>
        $('.post-title').each(function() {
          <?php if($data_filter['TU_KHOA_TT'] == "phrase") { ?>

            var txtToHighlight = $(this).text();
            var txtToHighlight = txtToHighlight.replace(new RegExp("<?php echo $data_filter['TU_KHOA'] ?>", "gi"), '<span class="mark">$&</span>');
            $(this).html(txtToHighlight);

          <?php } ?>


          <?php 
            if($data_filter['TU_KHOA_TT'] == "word") { 
              $words = explode(' ', $data_filter['TU_KHOA']); ?>
              var txtToHighlight = $(this).text();
              <?php foreach ($words as $word) { ?>
          
              var txtToHighlight = txtToHighlight.replace(new RegExp("<?php echo $word ?>", "gi"), '<span class="mark">$&</span>');
              
            <?php } ?>
            $(this).html(txtToHighlight);
          <?php } ?>
        });

        $('.limited-lines').each(function() {
          <?php if($data_filter['TU_KHOA_TT'] == "phrase") { ?>

            var txtToHighlight = $(this).text();
            var txtToHighlight = txtToHighlight.replace(new RegExp("<?php echo $data_filter['TU_KHOA'] ?>", "gi"), '<span class="mark">$&</span>');
            $(this).html(txtToHighlight);

          <?php } ?>

          
          <?php 
            if($data_filter['TU_KHOA_TT'] == "word") { 
              $words = explode(' ', $data_filter['TU_KHOA']); ?>
              var txtToHighlight = $(this).text();
              <?php foreach ($words as $word) { ?>
          
              var txtToHighlight = txtToHighlight.replace(new RegExp("<?php echo $word ?>", "gi"), '<span class="mark">$&</span>');
              
            <?php } ?>
            $(this).html(txtToHighlight);
          <?php } ?>
        });
      <?php } ?>

      //|*****************************************************
      //|LỌC BÀI VIẾT END
      //|*****************************************************
    });
  </script>
  <!--MAIN END-->
@endsection