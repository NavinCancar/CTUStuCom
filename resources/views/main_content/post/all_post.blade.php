@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
            <h5 class="card-title fw-semibold">Danh sách bài viết</h5>
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

            <div class="modal" id="detail">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" id="modal-content">
                        <!-- Modal Header 
                        <div class="modal-header">
                            <form class="modal-title row" style="width: 95%">
                                <span class="d-flex justify-content-between align-items-center col-sm-9 mb-2">
                                    <b>Trạng thái bài viết:</b>
                                    <select name="BV_TRANGTHAI"  class="form-select w-75">
                                        <option selected value="Chưa duyệt">Chưa duyệt</option>
                                        <option value="Đã duyệt">Đã duyệt</option>
                                        <option value="Yêu cầu chỉnh sửa">Yêu cầu chỉnh sửa</option>
                                        <option value="Không qua xét duyệt">Không qua xét duyệt</option>
                                        <option value="Đã xoá">Đã xoá</option>
                                    </select>
                                </span>
                                <span style="display: none;" class="col-sm-9">
                                    <span class="d-flex justify-content-between align-items-center">
                                        <b>Chi tiết trạng thái:</b>
                                        <input type="text" name="BV_NOIDUNG_TRANGTHAI" class="form-control w-75">
                                    </span>
                                </span>
                                <button type="button" class="btn btn-primary col-sm-3 mb-2">Cập nhật</button>
                            </form>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="text-notice text-notice-danger alert alert-danger mx-4" id="modal-alert-danger-c" style="display: none">
                            <span></span>
                            <i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = 'none'"></i>
                        </div>-->
                        
                        <!-- Modal body 
                        <div class="modal-body px-4 scroll-chat">
                            <div class="mb-3 mb-sm-0">
                                <div class="pb-2">
                                    <a href="http://localhost/ctustucom/tai-khoan/1" class="text-body" previewlistener="true">
                                        <img src="https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1706195644876_user1.jpg?alt=media&amp;token=3ad0b7f8-3870-4112-b45e-cbcc07b2c5b6" alt="" width="36" height="36" class="rounded-circle">
                                        <b>Nguyễn Phương Hiếu</b> 
                                    </a>
                                    <span class="badge-sm bg-warning rounded-pill"><i>Quản trị viên</i></span>
                                    đã đăng vào 08:42 ngày 19/02/2024       
                                </div>

                                <div class="mx-2">
                                    <h5 class="card-title fw-semibold post-title">asda</h5>
                                    <span style="font-size: 0.92rem;">ewr</span>
                                </div>
                                <div id="images-container" class="m-2 mt-3 mb-3 position-relative"></div>
                                <div id="files-container" class=" m-2 mt-3"></div>
                                
                                <div class="m-2">
                                    <a href="http://localhost/ctustucom/hoc-phan/ML019" previewlistener="true"><span class="badge bg-indigo rounded-3"><i class="fa fa-folder"></i> ML019 Lịch sử Đảng Cộng sản Việt Nam</span></a>

                                    <a href="http://localhost/ctustucom/hashtag/gf" previewlistener="true"><span class="badge bg-primary rounded-3 fw-semibold">#gf</span></a>
                                    <a href="http://localhost/ctustucom/hashtag/ho_tro" previewlistener="true"><span class="badge bg-primary rounded-3 fw-semibold">#ho_tro</span></a>
                                    <a href="http://localhost/ctustucom/hashtag/hoc_bong" previewlistener="true"><span class="badge bg-primary rounded-3 fw-semibold">#hoc_bong</span></a>
                                </div>

                                <div class="d-flex mt-2 pt-2 justify-content-end">
                                    <a class="ms-3 text-muted"><i class="fas fa-eye"></i> Lượt xem: <b>8</b></a>
                                    <a class="ms-3 text-muted"><i class="fas fa-heart"></i> Thích: <b>0</b></a>
                                    <a class="ms-3 text-muted"><i class="fas fa-reply"></i> Trả lời: <b>0</b></a>
                                    <a class="ms-3 text-muted"><i class="fas fa-flag"></i> Báo cáo: <b>8</b></a>
                                </div>
                            </div>

                            <div class="mt-3 mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
                                <h5 class="card-title fw-semibold">Danh sách báo cáo</h5>

                                <span class="align-items-center">
                                    <input class="form-check-input mt-1" type="checkbox">&ensp; Tất cả
                                    
                                    <a class="btn btn-danger btn-sm ms-4" previewlistener="true">
                                        <i class="fas fa-check-square"></i> Bỏ qua báo cáo
                                    </a>
                                </span>
                            </div>
                            <hr>
                            <div class="form-check">
                                <div class="d-flex flex-row pb-3 pt-1">
                                    <div>
                                    <a href="http://localhost/ctustucom/tai-khoan/4" class="text-body" previewlistener="true">
                                        <img src="https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&amp;token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76" alt="" width="40" height="40" class="rounded-circle me-2">
                                    </a>
                                    </div>
                                    <div class="pt-1" style="width:100%">
                                        <div>
                                            <a href="http://localhost/ctustucom/tai-khoan/1" class="text-muted" previewlistener="true"><span class="fw-bold mb-0">Nguyễn Phương Hiếu</span></a>
                                            <span class="badge-sm bg-warning rounded-pill"><i>Quản trị viên</i></span>
                                            đã đăng vào 08:42 ngày 19/02/2024

                                            <input class="form-check-input float-end" type="checkbox" name="BC_DUYET" value="something">
                                        </div>
                                        <span class="text-muted">Lúc mới ra trường thường thì xin job nhỏ trước làm lấy kinh nghiệm rồi nhảy việc, sau này ai còn hỏi e làm lv hay học thay thế j nữa đâu. Tới e tốt nghiệp loại gì Nta còn ko quan tâm bằng kinh nghiệm với tiếng anh đâu nhé e</span>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                        <!-- Modal footer 
                        <div class="modal-footer"></div>-->
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <div class="mb-3 mb-sm-0">
                        <div class="row my-2">
                            <h2 class="card-title fw-semibold text-center fs-6">DANH SÁCH BÀI VIẾT</h2>
                            <!--Header-->
                            <div class="row">
                                <div class="col-sm-9">
                                    
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                    <form class="d-flex input-group-sm w-100 mt-2 mb-3">
                                    <input class="form-control me-2" type="text" placeholder="Tìm kiếm">
                                    <button class="btn btn-outline-primary" type="button"><i class="fa fa-search"></i></button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <!--Content-->
                            <div class="col-12">
                            <div class="table-responsive">
                                <table class="table bg-white rounded shadow-sm  table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Mã</th>
                                            <th scope="col" width="500">Tiêu đề bài viết</th>
                                            <th scope="col" width="150">Trạng thái</th>
                                            <th scope="col">Ngày tạo</th>
                                            <th scope="col">Báo cáo</th>
                                            <th scope="col" width="70"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bai_viet as $key => $bv)
                                        <tr data-post-id-value="{{$bv->BV_MA}}">
                                            <td>{{$bv->BV_MA}}</td>
                                            <td><span class="limited-lines">{{$bv->BV_TIEUDE}}</span></td>
                                            <td class="trangthai">
                                                <?php 
                                                    if($bv->BV_TRANGTHAI == 'Chưa duyệt') echo '<span class="badge-sm bg-danger rounded-pill fs-2"><i>Chưa duyệt</i></span>'; 
                                                    else if($bv->BV_TRANGTHAI == 'Đã duyệt') echo '<span class="badge-sm bg-success rounded-pill fs-2"><i>Đã duyệt</i></span>';
                                                    else if($bv->BV_TRANGTHAI == 'Đã xoá') echo '<span class="badge-sm bg-light rounded-pill fs-2"><i>Đã xoá</i></span>'; 
                                                    else echo '<span class="badge-sm bg-warning rounded-pill fs-2"><i>'.trim(strstr($bv->BV_TRANGTHAI, ':', true)).'</i></span>'; 
                                                ?>
                                            </td>
                                            <td>{{date('d/m/Y', strtotime($bv->BV_THOIGIANTAO))}}</td>
                                            <td class="text-center td_sl_baocao"><?php 
                                                $count = $baiviet_baocao_noget->clone()->groupby('BV_MA')->where('BV_MA', $bv->BV_MA)->count(); 
                                                if($count != 0) echo '<b class="cursor-pointer"><span class="sl_baocao">'.$count.'</span>&ensp;<i class="fas fa-flag"></i></b>'; 
                                            ?></td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <button class="delete-button cursor-pointer show-detail" data-bs-toggle="modal" data-bs-target="#detail" data-post-id-value="{{$bv->BV_MA}}">
                                                        <i class="fas fa-expand-alt"></i>
                                                    </button>
                                                    <a href="{{URL::to('/bai-dang/'.$bv -> BV_MA)}}" previewlistener="true"><i class="fas fa-info-circle text-primary"></i></a>
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
                {{ "Hiển thị ". $bai_viet->firstItem() ."-". $bai_viet->lastItem() ." trong tổng số ". $bai_viet->total() ." dòng dữ liệu" }}
                </small>
            </div>
            
            <nav aria-label="Page navigation">
                <div class="text-center d-flex justify-content-center mt-3">
                    <ul class="pagination pagination-sm m-t-none m-b-none ">
                        {{-- Previous Page Link --}}
                        @if ($bai_viet->onFirstPage())
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-left"></i></a></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $bai_viet->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
                            </li>
                        @endif
                        {{-- Pagination Elements --}}
                        @for ($key=0; $key+1<=$bai_viet->lastPage(); $key++)
                                @if ($bai_viet->currentPage() === $key + 1)
                                    <li class="page-item active">
                                        <a class="page-link" href="{{ $bai_viet->url($key + 1) }}">{{ $key + 1 }}</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $bai_viet->url($key + 1) }}">{{ $key + 1 }}</a>
                                    </li>
                                @endif
                        @endfor
                    
                        {{-- Next Page Link --}}
                        @if ($bai_viet->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $bai_viet->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
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
        
        //|-----------------------------------------------------
        //|FOCUS BÌNH LUẬN NẾU CÓ
        //|-----------------------------------------------------
        <?php 
        $BV_MA_Focus = Session::get('BV_MA_Focus');
        if($BV_MA_Focus) { 
        ?>
            var postIdValue = <?php echo $BV_MA_Focus ?>;

            var trToFocus = document.querySelector(`tr[data-post-id-value="${postIdValue}"]`);
            //console.log("focus:", trToFocus)
            if (trToFocus) {
                trToFocus.style.background = 'linear-gradient(to right, #ffffff00, #ffff0038, #ffff0038, #ffff0038, #ffffff00)';
                trToFocus.tabIndex = 0;
                trToFocus.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center', // Hoặc 'center', 'end', 'nearest'
                });
            }
        <?php 
            Session::put('BV_MA_Focus',null);
        } 
        ?>

        //|*****************************************************
        //|MỞ RỘNG CHI TIẾT BÀI VIẾT START 
        //|*****************************************************
        <?php if($userLog) { ?>

            //|-----------------------------------------------------
            //|DANH SÁCH FILE NGƯỜI DÙNG ĐÃ LƯU
            //|-----------------------------------------------------
            var fileSaved = [];
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

                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var element = $(this);
                var BV_MA = $(this).data('post-id-value');
                
                $.ajax({
                    url: '{{URL::to('/chi-tiet-bai-dang/')}}' +'/'+ BV_MA,
                    type: 'GET',
                    success: function(response) { 
                        $('#modal-content').html(response);
                        var defaultValue = $('select[name="BV_TRANGTHAI"]').val();
                        //|-----------------------------------------------------
                        //|HIỆN FILE BÀI VIẾT
                        //|-----------------------------------------------------
                        const filesContainer = document.getElementById('files-container');
                        const imagesContainer = document.getElementById('images-container');

                        (async () => {
                            const qfile = query(
                                collection(db, "FILE_DINH_KEM"), 
                                where('ND_NHAN_MA', '==', 0),
                                where('ND_GUI_MA', '==', 0),
                                where('BV_MA', '==', BV_MA),
                                where('BL_MA', '==', 0),
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
                                    '  <a target="_blank" href="'+fileLink+'" previewlistener="true">' +
                                    '    <img src="'+fileLink+'" width="100px" height="100px" alt="'+fileName+'" class="d-block mx-auto">' +
                                    '  </a>' +
                                    '  <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle file-item-btn bookmark-file" data-fdk-id-value="'+doc.id+'" style="transform: translateX(-50%);">' ;
                                    if (fileSaved.includes(doc.id)) divData += '    <i class="fas fa-vote-yea"></i>';
                                    else  divData += '    <i class="fas fa-bookmark"></i>';
                                    divData += 
                                    '  </button>' +
                                    '</span>';
                                    imagesContainer.insertAdjacentHTML('afterbegin', divData);
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
                                    filesContainer.insertAdjacentHTML('afterbegin', divData);
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
                                    url: '{{URL::to('/duyet-bao-cao-bai-dang/')}}' +'/'+ BV_MA,
                                    type: 'POST',
                                    data: {
                                        bcDuyetValues: JSON.stringify(bcDuyetValues),
                                        _token: _token 
                                    },
                                    success: function(response) {
                                        bcDuyetValues.forEach(function(value) {
                                            $('div[data-report-nd-value="' + value + '"]').addClass('d-none');
                                            
                                            var slbaocao = parseInt($('tr[data-post-id-value="' + BV_MA + '"]').find('span.sl_baocao').text());
                                            if(slbaocao-1==0) $('tr[data-post-id-value="' + BV_MA + '"]').find('td.td_sl_baocao').text('');
                                            else $('tr[data-post-id-value="' + BV_MA + '"]').find('span.sl_baocao').text(slbaocao - 1);
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
                        $('select[name="BV_TRANGTHAI"]').change(function() {
                            $('input[name="BV_NOIDUNG_TRANGTHAI"]').css('border-color', '');
                            $('input[name="BV_NOIDUNG_VIPHAM"]').css('border-color', '');

                            var selectedValue = $(this).val();
                            if(selectedValue == 'Yêu cầu chỉnh sửa'){
                                $('#edit_BV_TRANGTHAI').show();
                                $('#ban_BV_TRANGTHAI').hide();
                            }
                            else if(selectedValue == 'Vi phạm tiêu chuẩn'){
                                $('#ban_BV_TRANGTHAI').show();
                                $('#edit_BV_TRANGTHAI').hide();
                            } 
                            else{
                                $('#edit_BV_TRANGTHAI').hide();
                                $('#ban_BV_TRANGTHAI').hide();
                            } 
                        });

                        //|-----------------------------------------------------
                        //|NGĂN GÕ : TRONG CHI TIẾT TRẠNG THÁI
                        //|-----------------------------------------------------
                        $('input[name="BV_NOIDUNG_TRANGTHAI"]').on('keydown', function(e) {
                            if (e.key === ":") {
                                e.preventDefault();
                            }
                        });
                        $('input[name="BV_NOIDUNG_VIPHAM"]').on('keydown', function(e) {
                            if (e.key === ":") {
                                e.preventDefault();
                            }
                        });

                        //|*****************************************************
                        //|CẬP NHẬT TRẠNG THÁI START 
                        //|*****************************************************
                        $('#update_BV_TRANGTHAI').click(function() {
                            var form = $(this).closest('form');
                            var BV_TRANGTHAI = form.find('select[name="BV_TRANGTHAI"]').val();
                            var BV_NOIDUNG_TRANGTHAI = form.find('input[name="BV_NOIDUNG_TRANGTHAI"]').val();
                            var BV_NOIDUNG_VIPHAM = form.find('input[name="BV_NOIDUNG_VIPHAM"]').val();
                            var _token = $('meta[name="csrf-token"]').attr('content');

                            if(BV_TRANGTHAI == 'Yêu cầu chỉnh sửa' && BV_NOIDUNG_TRANGTHAI == ''){
                                form.find('input[name="BV_NOIDUNG_TRANGTHAI"]').css('border-color', '#FA896B');
                            }
                            else if(BV_TRANGTHAI == 'Vi phạm tiêu chuẩn' && BV_NOIDUNG_VIPHAM == ''){
                                form.find('input[name="BV_NOIDUNG_VIPHAM"]').css('border-color', '#FA896B');
                            }
                            else{
                                if((BV_TRANGTHAI != defaultValue && BV_TRANGTHAI != 'Đã xoá') || BV_TRANGTHAI == 'Yêu cầu chỉnh sửa' || BV_TRANGTHAI == 'Vi phạm tiêu chuẩn'){
                                    $('.modal-header form').hide();
                                    $('.modal-body').hide();
                                    $('.modal-auto-load').show();

                                    const BV_TRANGTHAI_get = BV_TRANGTHAI;

                                    if(BV_TRANGTHAI == 'Yêu cầu chỉnh sửa'){
                                        BV_TRANGTHAI = BV_TRANGTHAI + ': ' + BV_NOIDUNG_TRANGTHAI;
                                    }
                                    else if(BV_TRANGTHAI == 'Vi phạm tiêu chuẩn'){
                                        BV_TRANGTHAI = BV_TRANGTHAI + ': ' + BV_NOIDUNG_VIPHAM;
                                    }
                                    
                                    $.ajax({
                                    url: '{{URL::to('/cap-nhat-trang-thai-bai-dang/')}}' +'/'+ BV_MA,
                                    type: 'POST',
                                    data: {
                                        BV_TRANGTHAI: BV_TRANGTHAI,
                                        _token: _token 
                                    },
                                    success: function(response) {
                                        //Notification start
                                        $.ajax({
                                            url: '{{URL::to('/thong-bao-trang-thai-bai-dang/')}}' +'/'+ BV_MA,
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
                                        $('.modal-header form').html(response.output);
                                        if(response.thoiGianGui != '') $('span.thoigian').html(response.thoiGianGui);

                                        var trangThaiNew = '';
                                        if(BV_TRANGTHAI_get == 'Chưa duyệt') trangThaiNew = '<span class="badge-sm bg-danger rounded-pill fs-2"><i>Chưa duyệt</i></span>'; 
                                        else if(BV_TRANGTHAI_get == 'Đã duyệt') trangThaiNew = '<span class="badge-sm bg-success rounded-pill fs-2"><i>Đã duyệt</i></span>';
                                        else if(BV_TRANGTHAI_get == 'Đã xoá') trangThaiNew = '<span class="badge-sm bg-light rounded-pill fs-2"><i>Đã xoá</i></span>'; 
                                        else trangThaiNew = '<span class="badge-sm bg-warning rounded-pill fs-2"><i>'+BV_TRANGTHAI_get+'</i></span>'; 
                                        $('tr[data-post-id-value="' + BV_MA + '"]').find('td.trangthai').html(trangThaiNew);

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

                        //|*****************************************************
                        //|CẬP NHẬT HASHTAG START 
                        //|*****************************************************
                        $('input.tokenfield-input').removeAttr('style');
                        $('#dangbai-btn').click(function(e) {
                            e.preventDefault();

                            const selectedItems = instance.getItems();
                            var form = $('#them');
                            form.find('div.tokenfield.tokenfield-mode-tokens').css('border-color', '');

                            if(selectedItems.length==0){
                                form.find('div.tokenfield.tokenfield-mode-tokens').css('border-color', '#FA896B');
                            }
                            else{
                                // Hiển thị thông báo xác nhận
                                var confirmation = confirm("Bạn xác nhận cập nhật hashtag bài viết?");
                                
                                if (confirmation) {
                                    $('.modal-header form').hide();
                                    $('.modal-body').hide();
                                    $('.modal-auto-load').show();
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
                                    var hashtags = form.find('input[name="hashtags"]').val();
                                    var hashtagsNew = form.find('input[name="hashtagsNew"]').val();
                                    var _token = $('meta[name="csrf-token"]').attr('content');
                                    
                                    $.ajax({
                                    url: '{{URL::to('/cap-nhat-hashtag-bai-dang/')}}' +'/'+ BV_MA,
                                    type: 'POST',
                                    data: {
                                        hashtags: hashtags,
                                        hashtagsNew: hashtagsNew,
                                        _token: _token
                                    },
                                    success: function(response) {
                                        form.find('div.tokenfield.tokenfield-mode-tokens').css('border-color', '');

                                        $('span.listhashtag').html(response.output);

                                        //instance.setItems([ { name: 'an_chay' }, { name: 'b1' }, { name: 'gf' }, { name: 'sd' },  ]);
                                        let items = Array.isArray(response.hashtagGui) ? response.hashtagGui : JSON.parse(response.hashtagGui);
                                        instance.setItems(items.map(item => ({ name: item.name })));
                                        $('input.tokenfield-input').removeAttr('style');
                                        
                                        $('.modal-auto-load').hide();
                                        $('.modal-header form').show();
                                        $('.modal-body').show();
                                        $('#modal-alert-success').show();
                                        $('#modal-alert-success span').html('Cập nhật hashtag bài viết thành công');
                                    },
                                    error: function(error) {
                                        $('input.tokenfield-input').removeAttr('style');
                                        $('.modal-auto-load').hide();
                                        $('.modal-header form').show();
                                        $('.modal-body').show();
                                        $('#modal-alert-danger').show();
                                        $('#modal-alert-danger span').html('Cập nhật hashtag bài viết thất bại');
                                        console.log(error);
                                    }
                                    });
                                }
                            }
                        });
                        //|*****************************************************
                        //|CẬP NHẬT HASHTAG END 
                        //|*****************************************************
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        <?php } ?>
        //|*****************************************************
        //|MỞ RỘNG CHI TIẾT BÀI VIẾT START 
        //|*****************************************************

        //|*****************************************************
        //|LƯU FILE START
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
                            iconElement.removeClass('spinner-border text-light spinner-border-sm');
                            iconElement.addClass('fa-vote-yea');
                            //console.log('Thành công');
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

                        iconElement.removeClass('spinner-border text-light spinner-border-sm');
                            iconElement.addClass('fa-bookmark');
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
        //|LƯU FILE END
        //|*****************************************************
    </script>
@endsection