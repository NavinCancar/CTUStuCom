@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
            <h5 class="card-title fw-semibold">Danh sách bình luận</h5>
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
                    </div>
                </div>
            </div>
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
                                            <th scope="col" width="650">Nội dung bình luận</th>
                                            <th scope="col">Ngày tạo</th>
                                            <th scope="col">Báo cáo</th>
                                            <th scope="col" width="70"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($binh_luan as $key => $bl)
                                        <tr>
                                            <td>{{$bl->BL_MA}}</td>
                                            <td><span class="limited-lines">{{$bl->BL_NOIDUNG}}</span></td>
                                            <td>{{date('d/m/Y', strtotime($bl->BL_THOIGIANTAO))}}</td>
                                            <td class="text-center"><?php 
                                                $count = $binhluan_baocao_noget->clone()->groupby('BL_MA')->where('BL_MA', $bl->BL_MA)->count(); 
                                                if($count != 0) echo '<b class="cursor-pointer">'.$count.'&ensp;<i class="fas fa-flag"></i></b>'; 
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
            
            <nav aria-label="Page navigation">
                <div class="text-center d-flex justify-content-center mt-3">
                    <ul class="pagination pagination-sm m-t-none m-b-none ">
                        {{-- Previous Page Link --}}
                        @if ($binh_luan->onFirstPage())
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-left"></i></a></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $binh_luan->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
                            </li>
                        @endif
                        {{-- Pagination Elements --}}
                        @for ($key=0; $key+1<=$binh_luan->lastPage(); $key++)
                                @if ($binh_luan->currentPage() === $key + 1)
                                    <li class="page-item active">
                                        <a class="page-link" href="{{ $binh_luan->url($key + 1) }}">{{ $key + 1 }}</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $binh_luan->url($key + 1) }}">{{ $key + 1 }}</a>
                                    </li>
                                @endif
                        @endfor
                    
                        {{-- Next Page Link --}}
                        @if ($binh_luan->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $binh_luan->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
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

        //|*****************************************************
        //|MỞ RỘNG CHI TIẾT BÌNH LUẬN START 
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
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var element = $(this);
                var BL_MA = $(this).data('comment-id-value');
                
                $.ajax({
                    url: '{{URL::to('/chi-tiet-binh-luan/')}}' +'/'+ BL_MA,
                    type: 'GET',
                    success: function(response) {
                        $('#modal-content').html(response);

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
                                    url: '{{URL::to('/duyet-bao-cao-binh-luan/')}}' +'/'+ BL_MA,
                                    type: 'POST',
                                    data: {
                                        bcDuyetValues: JSON.stringify(bcDuyetValues),
                                        _token: _token 
                                    },
                                    success: function(response) {
                                        bcDuyetValues.forEach(function(value) {
                                            $('div[data-report-nd-value="' + value + '"]').addClass('d-none');
                                        });

                                        var divsWithoutDnone = $('div[data-report-nd-value]').filter(function() {
                                            return !$(this).hasClass('d-none');
                                        });

                                        // Kiểm tra số lượng div tìm được
                                        if (divsWithoutDnone.length == 0) {
                                            console.log('hide');
                                            $('#modal-baocao').hide();
                                        }
                                        else{
                                            $('#modal-baocao').show();
                                        }
                                        $('.modal-auto-load').hide();
                                        $('#modal-alert-success').show();
                                        $('#modal-alert-success span').html('Duyệt báo cáo thành công');
                                    },
                                    error: function(error) {
                                        $('#modal-baocao').show();
                                        $('.modal-auto-load').hide();
                                        $('#modal-alert-danger').show();
                                        $('#modal-alert-danger span').html('Duyệt báo cáo thất bại');
                                        console.log(error);
                                    }
                                });
                            }
                            
                        });
                        
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