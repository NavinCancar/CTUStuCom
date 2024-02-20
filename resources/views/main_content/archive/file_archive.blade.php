@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
        <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
              <h5 class="card-title fw-semibold">Kho lưu trữ file</h5>
        </div>
        <hr>
        
        <div class="justify-content-between">
            <div class="d-flex flex-row">
                <button class="btn btn-primary ms-2 follow w-100" data-bs-toggle="collapse" data-bs-target="#demoimages">Kho lưu trữ file ảnh</button>
                <button class="btn btn-success ms-2 follow w-100" data-bs-toggle="collapse" data-bs-target="#demodocuments">Kho lưu trữ file tài liệu</button>
            </div>
        </div>
        

        <!-- Kho lưu trữ Start-->
        <div id="allfile">
            <div id="demoimages" class="collapse">
                <div class="card">
                    <div class="card-body p-3">
                        <h4>Ảnh</h4>

                        <div class="p-3 d-flex justify-content-between" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="jpg" checked>
                                <label class="form-check-label">jpeg / jpg</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="png" checked>
                                <label class="form-check-label">png</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="gif" checked>
                                <label class="form-check-label">gif</label>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-0 row" id="list-images">
                        </ul>
                    </div>
                </div>
            </div>
            <div id="demodocuments" class="collapse">
                <div class="card">
                    <div class="card-body p-3">
                        <h4>File</h4>
                        <div class="p-3 d-flex justify-content-between" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="pdf" checked>
                                <label class="form-check-label">PDF</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="doc" checked>
                                <label class="form-check-label">Word</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="xls" checked>
                                <label class="form-check-label">Excel</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="ppt" checked>
                                <label class="form-check-label">Power point</label>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-0 row" id="list-documents">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kho lưu trữ End-->     

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
        var fileSaved = [];

        $(document).ready(function() {
            //|-----------------------------------------------------
            //|DANH SÁCH FILE NGƯỜI DÙNG ĐÃ LƯU
            //|-----------------------------------------------------
            <?php if($userLog) { ?>

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

            <?php } ?>

            //|*****************************************************
            //|KHO LƯU TRỮ START
            //|*****************************************************

            const qklt = query(
                collection(db, "FILE_DINH_KEM"), 
                orderBy("FDK_TEN", "desc")
            );

            <?php if($userLog) { ?>

            (async () => {
                fileSaved = []
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

            <?php } ?>
            (async () => {

                const querySnapshotklt = await getDocs(qklt);

                var listimages = document.getElementById('list-images');
                var listdocuments = document.getElementById('list-documents');
                
                listimages.innerHTML = '';
                listdocuments.innerHTML = '';

                querySnapshotklt.forEach((doc) => {
                    const fileName = doc.data().FDK_TEN;
                    const fileLink = doc.data().FDK_DUONGDAN;
                    const fileExtension = fileName.split('.').pop().toLowerCase();
                    
                    var url = '{{ URL::to('/') }}';
                    if (doc.data().ND_NHAN_MA != 0 && doc.data().ND_GUI_MA != 0 && doc.data().ND_NHAN_MA == {{$userLog->ND_MA}}) {
                        url += '/tin-nhan/' + doc.data().ND_GUI_MA;
                    }
                    if (doc.data().ND_NHAN_MA != 0 && doc.data().ND_GUI_MA != 0 && doc.data().ND_GUI_MA == {{$userLog->ND_MA}}) {
                        url += '/tin-nhan/' + doc.data().ND_NHAN_MA;
                    }
                    if (doc.data().BV_MA != 0) {
                        url += '/bai-dang/' + doc.data().BV_MA;
                    }
                    if (doc.data().BL_MA != 0) {
                        url += '/bai-dang-binh-luan=' + doc.data().BL_MA;
                    }

                    //console.log(url);
                    if(fileSaved.includes(doc.id)){
                        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                            var type = '';
                            if (['jpg', 'jpeg'].includes(fileExtension)){
                                type = 'jpg';
                            }
                            else if (['png'].includes(fileExtension)) {
                                type = 'png';
                            }
                            else if (['gif'].includes(fileExtension)) {
                                type = 'gif';
                            }

                            var divData = 
                                '<li data-type-value="'+type+'"' +
                                '<span class="col-md-3 col-sm-4 rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block mb-3">' +
                                '    <a target="_blank" href="'+fileLink+'" previewlistener="true">' +
                                '        <img src="'+fileLink+'"  width="100px" height="100px" alt="'+fileName+'" class="d-block mx-auto">' +
                                '    </a>' +
                                '    <a href="' + url + '" class="btn btn-indigo btn-sm position-absolute start-85 translate-middle" style="transform: translateX(-50%);">' +
                                '    <i class="fas fa-info-circle"></i>' +
                                '    </a>' +
                                '    <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle bookmark-file" data-fdk-id-value="'+doc.id+'" style="transform: translateX(-50%);">' +
                                '    <i class="fas fa-vote-yea"></i>' +
                                '    </button>' +
                                '</span></li>';
                            listimages.insertAdjacentHTML('beforeend', divData);
                        }
                        else if (!['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)){
                            var type = '';
                            if (['pdf'].includes(fileExtension)){
                                type = 'pdf';
                            }
                            else if (['docx', 'doc'].includes(fileExtension)) {
                                type = 'doc';
                            }
                            else if (['xlsx', 'xls'].includes(fileExtension)) {
                                type = 'xls';
                            }
                            else if (['ppt', 'pptx'].includes(fileExtension)) {
                                type = 'ppt';
                            }

                            var divData =
                                '<li data-type-value="'+type+'" class="p-2 border-bottom d-flex justify-content-between">' +
                                '    <a href="'+fileLink+'" target="_blank" class="d-flex justify-content-between w-75">' +
                                '        <div class="d-flex flex-row" style="max-width:100%">' +
                                '            <div>';

                            if (['pdf'].includes(fileExtension)){
                                divData += '    <i class="fas fa-file-pdf me-2 document-icon"></i> ';
                            }
                            else if (['docx', 'doc'].includes(fileExtension)) {
                                divData += '    <i class="fas fa-file-word me-2 document-icon"></i> ';
                            }
                            else if (['xlsx', 'xls'].includes(fileExtension)) {
                                divData += '    <i class="fas fa-file-excel me-2 document-icon"></i> ';
                            }
                            else if (['ppt', 'pptx'].includes(fileExtension)) {
                                divData += '    <i class="fas fa-file-powerpoint me-2 document-icon"></i> ';
                            }
                            else {
                                divData += '    <i class="fas fa-file me-2 document-icon"></i> ';
                            }

                            divData +=
                                '            </div>' +
                                '            <div class="pt-1">' +
                                '                <p class="fw-bold mb-0">'+fileName+'</p>' +
                                '                   </i></p>' +
                                '            </div>' +
                                '        </div>' +
                                '    </a>' +
                                '    <a href="' + url + '" class="btn btn-indigo btn-sm" style="height: 28px !important;">' +
                                '    <i class="fas fa-info-circle"></i>' +
                                '    </a>' +
                                '    <button class="btn btn-secondary btn-sm bookmark-file" data-fdk-id-value="'+doc.id+'" style="height: 28px !important;">'+
                                '    <i class="fas fa-vote-yea"></i>' +
                                '    </button>' +
                                '</li>';

                            listdocuments.insertAdjacentHTML('beforeend', divData);
                        }
                    }
                   
                });
            })().catch((error) => {
                console.error("Error in script: ", error);
            });

            //|*****************************************************
            //|KHO LƯU TRỮ END
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

            //|*****************************************************
            //|CHECK BOX START
            //|*****************************************************
            // Lấy tất cả các checkbox
            const checkboxes = document.querySelectorAll('.form-check-input');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const checkedValue = this.value;
                    const isChecked = this.checked;

                    const listItems = document.querySelectorAll('#allfile li');
                    listItems.forEach(function(item) {
                        const itemType = item.getAttribute('data-type-value');
                        
                        if (checkedValue === itemType) {
                            // Nếu checkbox được chọn
                            if (isChecked) {
                                // Hiển thị item
                                item.classList.remove('d-none');
                            } else {
                                // Nếu checkbox không được chọn, ẩn item
                                item.classList.add('d-none');
                            }
                        }
                    });
                });
            });
            //|*****************************************************
            //|CHECK BOX END
            //|*****************************************************    

        });
    </script>
  
@endsection