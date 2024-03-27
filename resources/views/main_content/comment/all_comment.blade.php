@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>

<?php
    $addTT = ''; $addBC = ''; $addTK = '';
    if(request()->query('trang-thai')){
        $addTT .= '&trang-thai='.request()->query('trang-thai');
    }
    if(request()->query('bao-cao')){
        $addBC .= '&bao-cao='.request()->query('bao-cao');
    }
    if(request()->query('tu-khoa')){
        $addTK .= '&tu-khoa='.request()->query('tu-khoa');
    }
?>
<!-- Content Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
            <h5 class="card-title fw-semibold">Danh sách bình luận
                <?php if($addTT != '' || $addBC != '' || $addTK != '') { ?>
                    <a href="{{URL::to('/bai-dang')}}" class="ms-2 fs-4"><i class="fas fa-sync-alt"></i></a>
                <?php } ?>
            </h5> 
            </div>
            <hr>
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
          <div class="text-notice text-notice-success alert alert-success" id="alert-success" style="display: none">
            <span></span> 
            <i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = 'none'"></i>
          </div>
          <div class="text-notice text-notice-danger alert alert-danger" id="alert-danger" style="display: none">
            <span></span> 
            <i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = 'none'"></i>
          </div>
            <div class="modal" id="detail">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" id="modal-content">
                    </div>
                </div>
            </div>

            <!-- Modal Image Start-->   
            <div class="modal" id="img-modal">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content px-3">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="btn-close ms-5" data-bs-dismiss="modal"></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body pt-0 pb-0 mx-2 d-flex justify-content-between align-items-center"></div>
                        <!-- Modal footer -->
                        <div class="modal-footer footer-slideshow">
                            <!--<img src="..." width="100px" height="100px" class="mx-2">-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Image End-->

            <div class="card">
                <div class="card-body p-4">
                    <div class="mb-3 mb-sm-0">
                        <div class="row my-2">
                            <h2 class="card-title fw-semibold text-center fs-6">DANH SÁCH BÌNH LUẬN</h2>
                            <!--Header-->
                            <div class="row">
                                <div class="col-sm-9">
                                    
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                    <form class="d-flex input-group-sm w-100 mt-2 mb-3" role="form" action="{{URL::to('/binh-luan')}}" method="GET">
                                        <?php if(request()->query('trang-thai')) echo '<input name="trang-thai" hidden value="'.request()->query('trang-thai').'">'; ?>
                                        <?php if(request()->query('bao-cao')) echo '<input name="bao-cao" hidden value="'.request()->query('bao-cao').'">'; ?>
                                        <input class="form-control me-2" type="text" name="tu-khoa" placeholder="Tìm kiếm">
                                        <button class="btn btn-outline-primary" type="submit"><i class="fa fa-search"></i></button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <!--Content-->
                            <div class="col-12">
                            <div class="table-responsive">
                                <table id="data-table" class="table bg-white rounded shadow-sm  table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Mã</th>
                                            <th scope="col" width="500">Nội dung bình luận</th>
                                            <th scope="col" width="150">
                                                <div class="dropdown dropdown-sm" style ="position: static;">
                                                    <span class="dropdown-toggle" data-bs-toggle="dropdown">Trạng thái</span>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="{{URL::to('/binh-luan/?trang-thai=dang-hien-thi')}}" class="dropdown-item">Đang hiển thị</a></li>
                                                        <li><a href="{{URL::to('/binh-luan/?trang-thai=vi-pham-tieu-chuan')}}" class="dropdown-item">Vi phạm tiêu chuẩn</a></li>
                                                        <li><a href="{{URL::to('/binh-luan/?trang-thai=da-xoa')}}" class="dropdown-item">Đã xoá</a></li>
                                                    </ul>
                                                </div>
                                            </th>
                                            <th scope="col">Ngày tạo</th>
                                            <th scope="col">
                                                <div class="dropdown dropdown-sm" style ="position: static;">
                                                    <span class="dropdown-toggle" data-bs-toggle="dropdown">Báo cáo</span>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="{{URL::to('/binh-luan/?bao-cao=nhieu-nhat')}}" class="dropdown-item">Nhiều nhất</a></li>
                                                        <li><a href="{{URL::to('/binh-luan/?bao-cao=gan-nhat')}}" class="dropdown-item">Gần nhất</a></li>
                                                    </ul>
                                                </div>
                                            </th>
                                            <th scope="col" width="70"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($binh_luan as $key => $bl)
                                        <tr data-comment-id-value="{{$bl->BL_MA}}">
                                            <td class="check-highlight">{{$bl->BL_MA}}</td>
                                            <td class="check-highlight"><span class="limited-lines">{{$bl->BL_NOIDUNG}}</span></td>
                                            <td class="trangthai">
                                                <?php 
                                                    if($bl->BL_TRANGTHAI == 'Đang hiển thị') echo '<span class="badge-sm bg-success rounded-pill fs-2"><i>Đang hiển thị</i></span>';
                                                    else if($bl->BL_TRANGTHAI == 'Đã xoá') echo '<span class="badge-sm bg-light rounded-pill fs-2"><i>Đã xoá</i></span>'; 
                                                    else echo '<span class="badge-sm bg-warning rounded-pill fs-2"><i>'.trim(strstr($bl->BL_TRANGTHAI, ':', true)).'</i></span>'; 
                                                ?>
                                            </td>
                                            <td class="check-highlight">{{date('d/m/Y', strtotime($bl->BL_THOIGIANTAO))}}</td>
                                            <td class="text-center td_sl_baocao"><?php 
                                                $count = $binhluan_baocao_noget->clone()->groupby('BL_MA')->where('BL_MA', $bl->BL_MA)->count(); 
                                                if($count != 0) echo '<b class="cursor-pointer"><span class="sl_baocao">'.$count.'</span>&ensp;<i class="fas fa-flag"></i></b>'; 
                                            ?></td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <button class="delete-button cursor-pointer show-detail" data-bs-toggle="modal" data-bs-target="#detail" data-comment-id-value="{{$bl->BL_MA}}">
                                                        <i class="fas fa-expand-alt"></i>
                                                    </button>
                                                    <a href="{{URL::to('/bai-dang/'.$bl -> BV_MA.'?binh-luan='.$bl -> BL_MA)}}" previewlistener="true"><i class="fas fa-info-circle text-primary"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page number start-->
            <div>
                <small class="text-muted inline m-t-sm m-b-sm">
                {{ "Hiển thị ". $binh_luan->firstItem() ."-". $binh_luan->lastItem() ." trong tổng số ". $binh_luan->total() ." dòng dữ liệu" }}
                </small>
            </div>
            
            <?php
                $add = '';
                if(request()->query('trang-thai')){
                    $add .= '&trang-thai='.request()->query('trang-thai');
                }
                if(request()->query('bao-cao')){
                    $add .= '&bao-cao='.request()->query('bao-cao');
                }
                if(request()->query('tu-khoa')){
                    $add .= '&tu-khoa='.request()->query('tu-khoa');
                }
            ?>
            <nav aria-label="Page navigation">
                <div class="text-center d-flex justify-content-center mt-3">
                    <ul class="pagination pagination-sm m-t-none m-b-none ">
                        {{-- Previous Page Link --}}
                        @if ($binh_luan->onFirstPage())
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-left"></i></a></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $binh_luan->previousPageUrl().$add }}"><i class="fas fa-angle-left"></i></a>
                            </li>
                        @endif
                        {{-- Pagination Elements --}}
                        @for ($key=0; $key+1<=$binh_luan->lastPage(); $key++)
                                @if ($binh_luan->currentPage() === $key + 1)
                                    <li class="page-item active">
                                        <a class="page-link" href="{{ $binh_luan->url($key + 1).$add }}">{{ $key + 1 }}</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $binh_luan->url($key + 1).$add }}">{{ $key + 1 }}</a>
                                    </li>
                                @endif
                        @endfor
                    
                        {{-- Next Page Link --}}
                        @if ($binh_luan->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $binh_luan->nextPageUrl().$add }}"><i class="fas fa-angle-right"></i></a>
                            </li>
                        @else
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-right"></i></a></li>
                        @endif
                    </ul>
                </div>
            </nav>
            <!-- Page number end-->
        </div>
    </div>
</div>

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
        //|-----------------------------------------------------
        //|FOCUS BÌNH LUẬN NẾU CÓ
        //|-----------------------------------------------------
        <?php 
        $BL_MA_Focus = Session::get('BL_MA_Focus');
        if($BL_MA_Focus) { 
        ?>
            var commentIdValue = <?php echo $BL_MA_Focus ?>;

            var trToFocus = document.querySelector(`tr[data-comment-id-value="${commentIdValue}"]`);
            //console.log("focus:", trToFocus)
            if (trToFocus) {
                trToFocus.style.background = 'linear-gradient(to right, #ffffff00, #ffff0038, #ffff0038, #ffff0038, #ffffff00)';
                trToFocus.tabIndex = 0;
                trToFocus.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center', // Hoặc 'center', 'end', 'nearest'
                });
            }
            else{
                //|-----------------------------------------------------
                //|KIỂM TRA NẾU CÓ CHUYỂN PAGE
                //|-----------------------------------------------------
                const currentURL = window.location.href;
                if (currentURL.includes('?binh-luan=')) {
                    async function processURLs(urls) {
                        for (let i = 0; i < urls.length; i++) {
                            var newURL = urls[i];
                            const response = await fetch(newURL); //để tải nội dung của newURL
                            const htmlString = await response.text(); //chuyển response qua text
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(htmlString, 'text/html'); //chuyển text qua html
                            var trToFocus = doc.querySelector(`tr[data-comment-id-value="${commentIdValue}"]`);
                            if (trToFocus) {
                                trToFocus.style.background = 'linear-gradient(to right, #ffffff00, #ffff0038, #ffff0038, #ffff0038, #ffffff00)';
                                trToFocus.tabIndex = 0;
                                trToFocus.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center',
                                });
                                window.location.href = newURL;
                                break;
                            }
                        }
                    }

                    // Sử dụng hàm
                    const urls = [];
                    for (let i = 2; i <= <?php echo $binh_luan->lastPage(); ?>; i++) {
                        urls.push(currentURL + `&page=${i}`);
                    }

                    processURLs(urls);
                }
            }
        <?php 
            Session::put('BL_MA_Focus',null);
        } 
        ?>

        //|*****************************************************
        //|MỞ RỘNG CHI TIẾT BÌNH LUẬN START 
        //|*****************************************************
        <?php if($userLog) { ?>

            //|-----------------------------------------------------
            //|DANH SÁCH FILE NGƯỜI DÙNG ĐÃ LƯU
            //|-----------------------------------------------------
            var fileSaved = [];
            var imgListModal = [];
            
            (async () => {
                const qbookmarkfileSaved = query(
                collection(db, "DANH_DAU_FILE"), 
                where('ND_MA', '==', <?php if($userLog) echo $userLog->ND_MA; ?>)
                );
                
                const querySnapshotbookmarkfileSaved = await getDocs(qbookmarkfileSaved);
                
                querySnapshotbookmarkfileSaved.forEach((doc) => {
                    fileSaved.push(doc.data().FDK_MA);
                });
            })().catch((error) => {
                console.error("Error in script: ", error);
            });

            $(document).on('click', '.show-detail', function(e) {
                e.preventDefault();
                $('#modal-content').html('');
                imgListModal = [];

                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var element = $(this);
                var BL_MA = $(this).data('comment-id-value');
                
                $.ajax({
                    url: '{{URL::to('/chi-tiet-binh-luan/')}}' +'/'+ BL_MA,
                    type: 'GET',
                    success: function(response) {
                        $('#modal-content').html(response);
                        var defaultValue = $('select[name="BL_TRANGTHAI"]').val();
                        highLight();
                        //|-----------------------------------------------------
                        //|HIỆN FILE BÌNH LUẬN
                        //|-----------------------------------------------------
                        const filesContainer = document.getElementById('files-container');
                        const imagesContainer = document.getElementById('images-container');

                        (async () => {
                            const qfile = query(
                                collection(db, "FILE_DINH_KEM"), 
                                where('ND_NHAN_MA', '==', 0),
                                where('ND_GUI_MA', '==', 0),
                                where('BL_MA', '==', BL_MA),
                                where('BV_MA', '==', 0),
                                where('TN_THOIGIANGUI', '==', null)
                            );

                            const querySnapshotfile = await getDocs(qfile);
                            querySnapshotfile.forEach((doc) => {
                                const fileName = doc.data().FDK_TEN;
                                const fileLink = doc.data().FDK_DUONGDAN;
                                const fileExtension = fileName.split('.').pop().toLowerCase();

                                if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                                    // Image
                                    var divData =
                                    '<span class="rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block file-item">' +
                                    '  <a class="modal-img" data-img-id-value="'+doc.id+'" previewlistener="true">' +
                                    '    <img src="'+fileLink+'" width="100px" height="100px" alt="'+fileName+'" class="d-block mx-auto">' +
                                    '  </a>' +
                                    '  <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle file-item-btn bookmark-file" data-fdk-id-value="'+doc.id+'" style="transform: translateX(-50%);">' ;
                                    if (fileSaved.includes(doc.id)) divData += '    <i class="fas fa-vote-yea"></i>';
                                    else  divData += '    <i class="fas fa-bookmark"></i>';
                                    divData += 
                                    '  </button>' +
                                    '</span>';
                                    imagesContainer.insertAdjacentHTML('beforeend', divData);

                                    imgListModal.push({ docid: doc.id, fileName: fileName, fileLink: fileLink });
                                }
                                else{
                                    var divData =
                                        '<span class="badge bg-secondary rounded-3 fw-semiboldms-0 p-1 px-3 me-2 mb-2 text-white file-item">' +    
                                        ' <a target="_blank" class="text-white" href="'+fileLink+'">';

                                    if (['pdf'].includes(fileExtension)){
                                        divData += '    <i class="fas fa-file-pdf fs-5 me-2"></i> ';
                                    }
                                    else if (['docx', 'doc'].includes(fileExtension)) {
                                        divData += '    <i class="fas fa-file-word fs-5 me-2"></i> ';
                                    }
                                    else if (['xlsx', 'xls'].includes(fileExtension)) {
                                        divData += '    <i class="fas fa-file-excel fs-5 me-2"></i> ';
                                    }
                                    else if (['ppt', 'pptx'].includes(fileExtension)) {
                                        divData += '    <i class="fas fa-file-powerpoint fs-5 me-2"></i> ';
                                    }
                                    else {
                                        divData += '    <i class="fas fa-file fs-5 me-2"></i> ';
                                    }

                                    divData += fileName +
                                        ' </a>' +
                                        '  <button class="btn btn-secondary btn-sm file-item-btn bookmark-file" data-fdk-id-value="'+doc.id+'">' ;
                                    if (fileSaved.includes(doc.id)) divData += '    <i class="fas fa-vote-yea background-indigo"></i>';
                                    else  divData += '    <i class="fas fa-bookmark"></i>';
                                    divData += 
                                        '  </button>' +
                                        '</span>';
                                    filesContainer.insertAdjacentHTML('beforeend', divData);
                                } 
                            });
                        })().catch((error) => {
                            console.error("Error in script: ", error);
                        });

                        //|-----------------------------------------------------
                        //|CHECKBOX
                        //|-----------------------------------------------------
                        $('#check-all-BC_DUYET').change(function() {
                            var isChecked = $(this).prop('checked');
                            $('input[name="BC_DUYET"]').prop('checked', isChecked);
                        });
                        $('input[name="BC_DUYET"]').change(function() {
                            var allChecked = true;
                            $('input[name="BC_DUYET"]').each(function() {
                                if (!$(this).prop('checked')) {
                                    allChecked = false;
                                }
                            });
                            $('#check-all-BC_DUYET').prop('checked', allChecked);
                        });

                        $('#check-BC_DUYET').click(function() {
                            var anyChecked = $('input[name="BC_DUYET"]:checked').length > 0;
                            if(anyChecked){
                                $('#modal-baocao').hide();
                                $('.modal-auto-load').show();

                                var bcDuyetValues = [];
                                $('input[name="BC_DUYET"]:checked').each(function() {
                                    bcDuyetValues.push($(this).val());
                                });
                                console.log(bcDuyetValues);
                                var _token = $('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                    url: '{{URL::to('/duyet-bao-cao-binh-luan/')}}' +'/'+ BL_MA,
                                    type: 'POST',
                                    data: {
                                        bcDuyetValues: JSON.stringify(bcDuyetValues),
                                        _token: _token 
                                    },
                                    success: function(response) {
                                        bcDuyetValues.forEach(function(value) {
                                            $('div[data-report-nd-value="' + value + '"]').addClass('d-none');

                                            var slbaocao = parseInt($('tr[data-comment-id-value="' + BL_MA + '"]').find('span.sl_baocao').text());
                                            if(slbaocao-1==0) $('tr[data-comment-id-value="' + BL_MA + '"]').find('td.td_sl_baocao').text('');
                                            else $('tr[data-comment-id-value="' + BL_MA + '"]').find('span.sl_baocao').text(slbaocao - 1);
                                        });

                                        var divsWithoutDnone = $('div[data-report-nd-value]').filter(function() {
                                            return !$(this).hasClass('d-none');
                                        });

                                        // Kiểm tra số lượng div tìm được
                                        if (divsWithoutDnone.length == 0) {
                                            $('#modal-baocao').hide();
                                        }
                                        else{
                                            $('#modal-baocao').show();
                                        }
                                        $('.modal-auto-load').hide();
                                        $('#modal-alert-success').show();
                                        $('#modal-alert-success span').html('Bỏ qua báo cáo thành công');
                                    },
                                    error: function(error) {
                                        $('#modal-baocao').show();
                                        $('.modal-auto-load').hide();
                                        $('#modal-alert-danger').show();
                                        $('#modal-alert-danger span').html('Bỏ qua báo cáo thất bại');
                                        console.log(error);
                                    }
                                });
                            }
                            
                        });
                        
                        //|-----------------------------------------------------
                        //|SELECT
                        //|-----------------------------------------------------
                        $('select[name="BL_TRANGTHAI"]').change(function() {
                            $('input[name="BL_NOIDUNG_VIPHAM"]').css('border-color', '');
                            $('select[name="BL_TRANGTHAI"]').closest('form').find('.temp-notice').remove();

                            var selectedValue = $(this).val();
                            if(selectedValue == 'Vi phạm tiêu chuẩn'){
                                $('#ban_BL_TRANGTHAI').show();
                            } 
                            else{
                                $('#ban_BL_TRANGTHAI').hide();
                            } 
                        });

                        //|-----------------------------------------------------
                        //|NGĂN GÕ : TRONG CHI TIẾT TRẠNG THÁI
                        //|-----------------------------------------------------
                        $('input[name="BL_NOIDUNG_VIPHAM"]').on('keydown', function(e) {
                            if (e.key === ":") {
                                e.preventDefault();
                            }
                        });

                        //|*****************************************************
                        //|CẬP NHẬT TRẠNG THÁI START 
                        //|*****************************************************
                        $('#update_BL_TRANGTHAI').click(function() {
                            var form = $(this).closest('form');
                            form.find('.temp-notice').remove();
                            $('input[name="BL_NOIDUNG_VIPHAM"]').css('border-color', '');

                            var BL_TRANGTHAI = form.find('select[name="BL_TRANGTHAI"]').val();
                            var BL_NOIDUNG_VIPHAM = form.find('input[name="BL_NOIDUNG_VIPHAM"]').val();
                            var _token = $('meta[name="csrf-token"]').attr('content');

                            if(BL_TRANGTHAI == 'Vi phạm tiêu chuẩn' && BL_NOIDUNG_VIPHAM == ''){
                                form.find('input[name="BL_NOIDUNG_VIPHAM"]').css('border-color', '#FA896B');
                                form.append('<b class="text-danger px-0 fs-2 temp-notice" style="margin-left: 12rem;">Trường này không thể rỗng</b>');
                            }
                            else{
                                if((BL_TRANGTHAI != defaultValue && BL_TRANGTHAI != 'Đã xoá') || BL_TRANGTHAI == 'Vi phạm tiêu chuẩn'){
                                    $('.modal-header form').hide();
                                    $('.modal-body').hide();
                                    $('.modal-auto-load').show();

                                    const BL_TRANGTHAI_get = BL_TRANGTHAI;

                                    if(BL_TRANGTHAI == 'Vi phạm tiêu chuẩn'){
                                        BL_TRANGTHAI = BL_TRANGTHAI + ': ' + BL_NOIDUNG_VIPHAM;
                                    }
                                    
                                    $.ajax({
                                    url: '{{URL::to('/cap-nhat-trang-thai-binh-luan/')}}' +'/'+ BL_MA,
                                    type: 'POST',
                                    data: {
                                        BL_TRANGTHAI: BL_TRANGTHAI,
                                        _token: _token 
                                    },
                                    success: function(response) {
                                        //Notification start
                                        $.ajax({
                                            url: '{{URL::to('/thong-bao-trang-thai-binh-luan/')}}' +'/'+ BL_MA,
                                            type: 'GET',
                                            success: function(response2) {
                                                //console.log('ok');
                                            },
                                            error: function(error2) {
                                                console.log(error);
                                            }
                                        });
                                        //Notification end

                                        form[0].reset();
                                        $('.modal-header form').html(response);

                                        var trangThaiNew = '';
                                        if(BL_TRANGTHAI_get == 'Đang hiển thị') trangThaiNew = '<span class="badge-sm bg-success rounded-pill fs-2"><i>Đang hiển thị</i></span>';
                                        else if(BL_TRANGTHAI_get == 'Đã xoá') trangThaiNew = '<span class="badge-sm bg-light rounded-pill fs-2"><i>Đã xoá</i></span>'; 
                                        else trangThaiNew = '<span class="badge-sm bg-warning rounded-pill fs-2"><i>'+BL_TRANGTHAI_get+'</i></span>'; 
                                        $('tr[data-comment-id-value="' + BL_MA + '"]').find('td.trangthai').html(trangThaiNew);

                                        $('.modal-auto-load').hide();
                                        $('.modal-header form').show();
                                        $('.modal-body').show();
                                        $('#modal-alert-success').show();
                                        $('#modal-alert-success span').html('Cập nhật trạng thái bài viết thành công');
                                    },
                                    error: function(error) {
                                        $('.modal-auto-load').hide();
                                        $('.modal-header form').show();
                                        $('.modal-body').show();
                                        $('#modal-alert-danger').show();
                                        $('#modal-alert-danger span').html('Cập nhật trạng thái bài viết thất bại');
                                        console.log(error);
                                    }
                                    });
                                }
                            }
                            
                        });
                        //|*****************************************************
                        //|CẬP NHẬT TRẠNG THÁI END 
                        //|*****************************************************
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        <?php } ?>
        //|*****************************************************
        //|MỞ RỘNG CHI TIẾT BÌNH LUẬN START 
        //|*****************************************************

        //|*****************************************************
        //|MODAL ẢNH START
        //|*****************************************************

        $(document).on('click', '.modal-img', function() {
            ShowImgModal($(this).data('img-id-value'));
        });

        $(document).on('click', '.imgOther', function() {
            ShowImgModal($(this).data('img-id-value'));
        });

        $(document).on('click', '.footer-slideshow img', function() {
            ShowImgModal($(this).data('img-id-value'));
        });

        function ShowImgModal(idImg){
            $('#img-modal').find('.modal-header').find('.btn').remove();
            $('#img-modal').find('.modal-header').find('div').remove();
            //$('#img-modal').find('.modal-footer').html('');
            $('#img-modal').find('.modal-body').html('');

            //|-----------------------------------------------------
            //|HIỆN ẢNH
            //|-----------------------------------------------------
            //imgListModal.push({ docid: doc.id, fileName: fileName, fileLink: fileLink, type: type, url: url });

            var index = imgListModal.findIndex(function(item) {
                return item.docid === idImg;
            });

            if (index !== -1) {//Có trong mảng
                //LẤY BUTTON
                var btnImg = 
                    '<button class="btn btn-secondary btn-sm start-100 bookmark-file mx-2 fs-4" data-fdk-id-value="'+imgListModal[index].docid+'">';
                if (fileSaved.includes(imgListModal[index].docid)) btnImg += '    <i class="fas fa-vote-yea mx-2 fs-4"></i></button>';
                else  btnImg += '    <i class="fas fa-bookmark mx-2 fs-4"></i></button>';
                btnImg +=
                '<div style="margin-left: auto;"><p class="fw-bold mb-0">'+imgListModal[index].fileName+'</p><p class="small text-muted float-end mb-0"><i> </i><i></i></div>';
                
                //LẤY ẢNH
                var bodyElement = '';
                //Nút Previous: Kiểm tra phần tử đầu
                if (index === 0) bodyElement += '<button type="button" disabled class="btn btn-link btn-lg pe-4" style="font-size: 2.25rem"><i class="fas fa-chevron-left"></i></button>'
                else bodyElement += '<button type="button" class="btn btn-link btn-lg pe-4 imgOther" data-img-id-value="'+imgListModal[index-1].docid+'" style="font-size: 2.25rem"><i class="fas fa-chevron-left"></i></button>'
                
                //Main content
                bodyElement += 
                '<a class="" data-img-id-value="'+imgListModal[index].docid+'" previewlistener="true" target="_blank" href="'+imgListModal[index].fileLink+'">'+   
                '    <img src="'+imgListModal[index].fileLink+'" alt="'+imgListModal[index].fileName+'" class="d-block mx-auto" style="width: 100%; height: auto; max-height: 340px;">'+    
                '</a>';

                //Nút Next: Kiểm tra phần tử cuối
                if (index === imgListModal.length - 1) bodyElement += '<button type="button" disabled class="btn btn-link btn-lg ps-4" style="font-size: 2.25rem"><i class="fas fa-chevron-right"></i></button>';
                else bodyElement += '<button type="button" class="btn btn-link btn-lg ps-4 imgOther" data-img-id-value="'+imgListModal[index+1].docid+'" style="font-size: 2.25rem"><i class="fas fa-chevron-right"></i></button>';

                $('#img-modal').find('.modal-header').prepend(btnImg);
                $('#img-modal').find('.modal-body').html(bodyElement);
            }

            $('.footer-slideshow').html('');
            for (var index = 0; index < imgListModal.length; index++) {
                $('<img src="'+imgListModal[index].fileLink+'"  data-img-id-value="'+imgListModal[index].docid+'" width="100px" height="100px" alt="'+imgListModal[index].fileName+'" class="mx-2 cursor-pointer">').appendTo('.footer-slideshow');
            }
            $('.footer-slideshow').find('img[data-img-id-value="'+idImg+'"]').addClass('img-selected-border');


            $('#img-modal').modal('show');
        }
        //|*****************************************************
        //|MODAL ẢNH END
        //|*****************************************************

        //|*****************************************************
        //|LƯU FILE START + WITH UPDATE
        //|*****************************************************
        <?php if($userLog) { ?>
            $(document).on('click', '.bookmark-file', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var FDK_MA = $(this).data('fdk-id-value');
                var _token = $('meta[name="csrf-token"]').attr('content');
                const iconElement = $(this).find('i');
                iconElement.removeClass('fa fa-bookmark');
                iconElement.removeClass('fa fa-vote-yea');
                iconElement.removeClass('fa-exclamation-circle text-danger');
                iconElement.addClass('spinner-border text-light spinner-border-sm');

                (async () => {
                    const qbookmarkfile = query(
                    collection(db, "DANH_DAU_FILE"), 
                    where('FDK_MA', '==', FDK_MA),
                    where('ND_MA', '==', <?php echo $userLog->ND_MA; ?>)
                    );
                    
                    const querySnapshotbookmarkfile = await getDocs(qbookmarkfile);
                    
                    if (querySnapshotbookmarkfile.empty) {
                        //Lưu file
                        $.ajax({
                        url: '{{URL::to('/danh-dau-file')}}',
                        type: 'POST',
                        data: {
                            FDK_MA: FDK_MA,
                            _token: _token // Include the CSRF token in the data
                        },
                        success: function(response) {
                            //iconElement.removeClass('spinner-border text-light spinner-border-sm');
                            //iconElement.addClass('fa-vote-yea');
                            //console.log('Thành công');
                            fileSaved.push(FDK_MA);
                            var fdkElement = $('button[data-fdk-id-value="'+ FDK_MA +'"]').find('i');
                            fdkElement.removeClass('fa fa-bookmark');
                            fdkElement.removeClass('fa fa-vote-yea');
                            fdkElement.removeClass('fa-exclamation-circle text-danger');
                            fdkElement.removeClass('spinner-border text-light spinner-border-sm');
                            fdkElement.addClass('fa-vote-yea');
                        },
                        error: function(error) {
                            iconElement.removeClass('spinner-border text-light spinner-border-sm');
                            iconElement.addClass('fa-exclamation-circle text-danger');
                            console.log(error);
                        }
                        });
                    }
                    else{
                        //Xoá file
                        querySnapshotbookmarkfile.forEach((doc2) => {
                            (async () => {
                                await deleteDoc(doc(db, "DANH_DAU_FILE", doc2.id));

                                //iconElement.removeClass('spinner-border text-light spinner-border-sm');
                                //iconElement.addClass('fa-bookmark');
                                
                                var index = fileSaved.indexOf(FDK_MA);
                                if (index !== -1) {
                                    fileSaved.splice(index, 1);
                                }
                                
                                var fdkElement = $('button[data-fdk-id-value="'+ FDK_MA +'"]').find('i');
                                fdkElement.removeClass('fa fa-bookmark');
                                fdkElement.removeClass('fa fa-vote-yea');
                                fdkElement.removeClass('fa-exclamation-circle text-danger');
                                fdkElement.removeClass('spinner-border text-light spinner-border-sm');
                                fdkElement.addClass('fa-bookmark');
                            })().catch((error) => {
                                iconElement.removeClass('spinner-border text-light spinner-border-sm');
                                iconElement.addClass('fa-exclamation-circle text-danger');
                                console.error("Error in delete script: ", error);
                            });
                        });
                    }
                })().catch((error) => {
                    console.error("Error in script: ", error);
                });
                // Thực hiện các xử lý khác với tham số đã truyền
                //console.log("Additional Parameter: " + FDK_MA);
            });
        <?php } ?>
        //|*****************************************************
        //|LƯU FILE END + WITH UPDATE
        //|*****************************************************
        //|-----------------------------------------------------
        //|HIGHLIGHT
        //|-----------------------------------------------------
        highLight();
        function highLight(){
            <?php 
                $keywords = request()->query('tu-khoa'); 
                if($keywords) { 
            ?>
                $('.check-highlight').each(function() {
                <?php $words = explode(' ', $keywords); ?>
                    var txtToHighlight = $(this).text();
                    <?php foreach ($words as $word) { ?>
                
                        var txtToHighlight = txtToHighlight.replace(new RegExp("<?php echo $word ?>", "gi"), '<span class="mark">$&</span>');
                        
                    <?php } ?>
                $(this).html(txtToHighlight);
                });
            <?php } ?>
        }
        
        })
    </script>
@endsection