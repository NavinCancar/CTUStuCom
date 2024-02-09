@extends('welcome')
@section('content')
<?php 
    $userLog= Session::get('userLog'); 
    $userChat= Session::get('userChat'); 
?>
    
    <!-- Content Start -->
    <div class="container-fluid">
        <div class="row" id="khungchatlon">
            <div class="col-md-8">
                <div class="card" id="chat">
                    <div class="d-flex justify-content-start align-items-center p-1 bg-secondary" style="border-radius: 15px 15px 0 0">
                    <?php if($userChat){ ?> <a href="{{URL::to('/tai-khoan/'.$userChat->ND_MA)}}" class="text-muted"> <?php  } ?>
                        <?php if($userChat){ ?> <img src="<?php if($userChat->ND_ANHDAIDIEN) echo $userChat->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'; ?>" alt="" width="40" height="40" 
                            class="rounded-circle me-2"><?php  } else { echo '<div style="height:40px"></div>';} ?>
                        <b><?php if($userChat) echo $userChat->ND_HOTEN; ?></b>
                        <?php if($userChat){ ?> </a> <?php  } ?>
                    </div>
                    <div class="card-body p-3">
                        <!--Chat Start-->
                        <div class="pt-1 pe-3 scroll-chat" id="chat-box">

                            <!--<div class="d-flex flex-row justify-content-start">
                                <img src="https://i.pinimg.com/236x/cb/93/4b/cb934b08c56332e136eda2dc8142453b.jpg" alt="" width="40" height="40"
                                    class="rounded-circle me-2">
                                <div>
                                    <p class="fs-3 p-2 ms-1 mb-1 rounded-3 friend-chat">
                                        Neque porro quisquam</p>
                                    <p class="fs-2 ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM |
                                        Aug 13</p>
                                </div>
                            </div>
                            
                            <div class="d-flex flex-row justify-content-end">
                                <div>
                                    <p class="fs-3 p-2 me-3 mb-1 text-white rounded-3 bg-primary">
                                        enim ad minima veniam, quis</p>
                                    <p class="fs-2 me-3 mb-3 rounded-3 text-muted">12:00 PM |
                                        Aug 13</p>
                                </div>
                                <img src="../assets/images/profile/user-1.jpg" alt="" width="40" height="40"
                                    class="rounded-circle me-2">
                            </div>-->
                            
                        </div>
                        <!--Chat End-->
                        <div>
                            <form id="message-form" class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                                <textarea name="TN_NOIDUNG" class="form-control border-secondary ms-3" placeholder="Nhập tin nhắn" rows="1" style="resize: none;"></textarea>
                                
                                <label for="file-input" class="ms-3 text-muted" style="cursor: pointer;">
                                    <i class="fas fa-paperclip"></i>
                                </label>
                                <!-- Input type file ẩn -->
                                <input name="TN_FDK[]" type="file" id="file-input" style="display: none" multiple accept=".jpg, .jpeg, .png, .doc, .docx, .pdf, .xls, .xlsx, .ppt, .pptx"/>
                                <button type="submit" id="message-btn" class="btn text-primary"><i class="fas fa-paper-plane"></i></button>
                            </form>
                            <!-- File Container -->
                            <div id="selected-files-container" class=" m-2 ">
                                <!--<span class="badge bg-secondary rounded-3 fw-semiboldms-0 p-1 px-3">
                                    <a class="text-white" href="../assets/file/TB4823-DHCT_Thong bao Vv dang ky hoc cung luc hai chuong trinh nam 2024.pdf">
                                    <i class="far fa-file-pdf"></i>
                                        TB4823-DHCT_Thong bao Vv dang ky hoc cung luc hai chuong trinh nam 2024.pdf
                                    </a>
                                    <button class="btn btn-secondary btn-sm"><i class="fas fa-bookmark"></i></button>
                                </span>-->
                            </div>
                            <!-- Images Container -->
                            <div  id="selected-images-container" class="m-2 mb-3 position-relative">
                                <!--<span class="rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block">
                                    <a target="_blank" href="../assets/file/Banner-VN.jpg">
                                        <img src="../assets/file/Banner-VN.jpg" width="100px" height="100px" alt="Banner Image" class="d-block mx-auto">
                                    </a>
                                    <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle" style="transform: translateX(-50%);"><i class="fas fa-bookmark"></i></button>
                                </span>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary btn-block me-2 mb-3 w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#kholuutru" id="kholuutru-btn">
                    <i class="fas fa-box"></i> Kho lưu trữ
                </button>
                <!-- Kho lưu trữ Start-->
                <div class="offcanvas offcanvas-end" id="kholuutru">
                    <div class="offcanvas-header">
                        <h1 class="offcanvas-title">Kho lưu trữ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body">
                        
                        <div class="card">
                            <div class="card-body p-3">
                                <h4>Ảnh</h4>
                                <ul class="list-unstyled mb-0 row" id="list-images">
                                    <!--<span class="col-md-3 col-sm-4 rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block mb-3">
                                        <a target="_blank" href="https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/files%2F1706364777868_screenshot_1705728200.png?alt=media&amp;token=d49a6560-f0c5-4208-ba42-50ae8fd39e03" previewlistener="true">
                                            <img src="https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/files%2F1706364777868_screenshot_1705728200.png?alt=media&amp;token=d49a6560-f0c5-4208-ba42-50ae8fd39e03" width="100px" height="100px" alt="1706364777868_screenshot_1705728200.png" class="d-block mx-auto">
                                        </a>
                                        <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle" style="transform: translateX(-50%);">
                                            <i class="fas fa-bookmark"></i>
                                        </button>
                                    </span>
                                    <div class="text-center">
                                        <button class="btn btn-secondary mt-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#kholuutrudetail"> Xem thêm</button>
                                    </div>-->
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body p-3">
                                <h4>File</h4>
                                <ul class="list-unstyled mb-0 row" id="list-documents">
                                    <!--<li data-value="4" class="p-2 border-bottom">
                                        <a href="http://localhost/ctustucom/tin-nhan/4" class="d-flex justify-content-between">
                                            <div class="d-flex flex-row" style="max-width:100%">
                                                <div>
                                                    <i class="fas fa-file-pdf me-2 document-icon"></i>
                                                </div>
                                                <div class="pt-1">
                                                    <p class="fw-bold mb-0"> 1706363718753_Book1.pdf</p>
                                                    <p class="small text-muted"><i>Từ: </i><i>Hoàng Mai Trang</i></p>
                                                </div>
                                            </div>
                                            <div class="pt-1">            
                                                <button class="btn btn-secondary btn-sm"><i class="fas fa-bookmark"></i></button>       
                                            </div>
                                        </a>
                                    </li>
                                    <div class="text-center">
                                        <button class="btn btn-secondary mt-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#kholuutrudetail"> Xem thêm</button>
                                    </div>-->
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body p-3">
                                <h4>Link</h4>
                                <ul class="list-unstyled mb-0 row"  id="list-links">
                                    <!--<li data-value="4" class="p-2 border-bottom">
                                        <a href="http://localhost/ctustucom/tin-nhan/4" class="d-flex justify-content-between">
                                            <div class="d-flex flex-row" style="max-width:100%">
                                                <div>
                                                    <i class="fas fa-link me-2 document-icon"></i>
                                                </div>
                                                <div class="pt-1">
                                                    <p class="fw-bold mb-0"> 1706363718753_Book1.pdf</p>
                                                    <p class="small text-muted"><i>Từ: </i><i>Hoàng Mai Trang</i></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <div class="text-center">
                                        <button class="btn btn-secondary mt-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#kholuutrudetail"> Xem thêm</button>
                                    </div>-->
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Kho lưu trữ End-->
                
                <!-- Kho lưu trữ Detail Start-->
                <div class="offcanvas offcanvas-end" id="kholuutrudetail">
                    <div class="offcanvas-header">
                        <h1 class="offcanvas-title" id="detail-title"></h1>
                        <button type="button" class="btn-close" data-bs-toggle="offcanvas" data-bs-target="#kholuutru"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="card">
                            <div class="card-body p-3">
                                <ul class="list-unstyled mb-0 row" id="detail-body">
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Kho lưu trữ Detail End-->

                
                <!-- DS bạn Start -->
                <div class="card">
                    <div class="card-body p-3">
                        <div class="input-group rounded mb-2">
                            <input class="form-control me-2" id="search-friend" type="text" placeholder="Tìm bạn bè">
                        </div>

                        <div class="scroll-chat" id="list-scroll">
                            <ul class="list-unstyled mb-0" id="list-friend">
                                <!--<li class="p-2 border-bottom">
                                    <a href="#" class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <div>
                                                <img src="https://i.pinimg.com/236x/cb/93/4b/cb934b08c56332e136eda2dc8142453b.jpg" alt="" 
                                                    width="40" height="40" class="rounded-circle me-2">
                                            </div>
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0">Marie Horwitz</p>
                                                <p class="small text-muted">Hello, Are you there?</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-0">Just now</p>
                                            <span class="badge bg-primary rounded-pill float-end fs-1">3</span>
                                        </div>
                                    </a>
                                </li>-->
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- DS bạn End -->
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
        //BIẾN CHO UPLOAD ẢNH
        const fileInput = document.getElementById('file-input');
        const selectedFilesContainer = document.getElementById('selected-files-container');
        const selectedImagesContainer = document.getElementById('selected-images-container');
        var dontUse = [];
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

            //|-----------------------------------------------------
            //|-----------------------------------------------------
            var justLoad = new Date();
            var userFormList = [];
            //|-----------------------------------------------------
            //|KIỂM TRA ĐƯỜNG DẪN
            //|-----------------------------------------------------
            var currentPath = window.location.pathname;
            
            //|*****************************************************
            //|NHẮN TIN START
            //|*****************************************************

            //ĐƯỜNG DẪN KẾT THÚC BẰNG /tin-nhan
            if (currentPath.endsWith('/tin-nhan') || currentPath.endsWith('/<?php echo $userLog->ND_MA?>')) {
                (async () => {
                    const qcheck = query(
                    collection(db, "TIN_NHAN"), 
                    or(where('ND_NHAN_MA', '==', <?php echo $userLog->ND_MA; ?>),
                        where('ND_GUI_MA', '==', <?php echo $userLog->ND_MA; ?>)
                    ),
                    orderBy("TN_REALTIME", "desc"), 
                    limit(1)
                    );

                    const querySnapshotcheck = await getDocs(qcheck);
                    
                    //KHÔNG TỒN TẠI TIN NHẮN CŨ
                    if (querySnapshotcheck.empty) {
                        var divData = `<h4 class="text-center p-2 m-5 p-5">Bạn chưa có cuộc trò chuyện nào trước đây!</h4>`;
                        var khungchatlon = document.getElementById('khungchatlon');
                        khungchatlon.insertAdjacentHTML('beforebegin', divData);
                        khungchatlon.style.display = "none";
                    }
                    //TỒN TẠI TIN NHẮN CŨ
                    else{
                        querySnapshotcheck.forEach((doc) => {
                            var userChat = (doc.data().ND_NHAN_MA == <?php echo $userLog->ND_MA; ?> ? doc.data().ND_GUI_MA : doc.data().ND_NHAN_MA)
                            //console.log(userChat);
                            var newPath = currentPath + '/' + userChat;
                            window.location.href = newPath;
                        });
                    }
                })().catch((error) => {
                    console.error("Error in script: ", error);
                });
            }
            else{
                seenChat(<?php if($userChat) echo $userChat->ND_MA; else echo 0; ?>);

                //|-----------------------------------------------------
                //|SHOW CHAT
                //|-----------------------------------------------------
                (async () => {
                    /*(async () => {
                        const querySnapshot = await getDocs(collection(db, "TIN_NHAN"));

                        querySnapshot.forEach((doc) => {
                            //doc.data() is never undefined for query doc snapshots
                            console.log(doc.id, " => ", doc.data());
                        });
                    })().catch((error) => {
                        console.error("Error in script: ", error);
                    });*/

                    
                    const qshow = query(
                        collection(db, "TIN_NHAN"),
                        where("ND_NHAN_MA", "in", [<?php if($userChat) echo $userChat->ND_MA; ?>, <?php echo $userLog->ND_MA; ?>]),
                        where("ND_GUI_MA", "in", [<?php if($userChat) echo $userChat->ND_MA; ?>, <?php echo $userLog->ND_MA; ?>]),
                        orderBy("TN_REALTIME", "desc")
                    );
                    
                    const querySnapshotshow = await getDocs(qshow);
                    querySnapshotshow.forEach((doc) => {
                        //doc.data() is never undefined for query doc snapshots
                        //console.log(doc.id, " => ", doc.data());

                        //|-----------------------------------------------------
                        //|ĐỒNG BỘ HOÁ TỐC ĐỘ HOẠT ĐỘNG TÌM FILE
                        //|-----------------------------------------------------
                        (async () => {
                            //Lấy file đính kèm
                            const qfile = query(
                                collection(db, "FILE_DINH_KEM"), 
                                where('ND_NHAN_MA', '==', doc.data().ND_NHAN_MA),
                                where('ND_GUI_MA', '==', doc.data().ND_GUI_MA),
                                where('BV_MA', '==', 0),
                                where('BL_MA', '==', 0),
                                where('TN_THOIGIANGUI', '==', doc.data().TN_THOIGIANGUI),
                            );

                            const querySnapshotfile = await getDocs(qfile);
                        
                            //|-----------------------------------------------------
                            //|HIỆN CHAT
                            //|-----------------------------------------------------
                            var chatbox = document.getElementById('chat-box');
                            if(doc.data().ND_GUI_MA == <?php echo $userLog->ND_MA; ?>){
                                //Tin nhắn văn bản
                                if(querySnapshotfile.empty){
                                    var divData = 
                                        '<div class="d-flex flex-row justify-content-end">'+
                                        '    <div>'+
                                        '        <p class="fs-3 p-2 me-3 mb-1 text-white rounded-3 bg-primary">'+doc.data().TN_NOIDUNG+'</p>'+
                                        '        <p class="fs-2 me-3 mb-3 rounded-3 text-muted">'+ (secondsDifference(doc.data().TN_REALTIME.toDate()) == -1 ? doc.data().TN_THOIGIANGUI : secondsDifference(doc.data().TN_REALTIME.toDate())) +'</p>'+
                                        '    </div>'+
                                        '    <img src="<?php if($userLog->ND_ANHDAIDIEN) echo $userLog->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'?>" alt="" width="40" height="40" class="rounded-circle me-2">'+
                                        '</div>';
                                    chatbox.insertAdjacentHTML('afterbegin', divData);
                                }
                                //Tin nhắn file
                                else {
                                    var divData = 
                                        '<div class="d-flex flex-row justify-content-end">'+
                                        '    <div>'+
                                        ((doc.data().TN_NOIDUNG=="")?'':'<p class="fs-3 p-2 me-3 mb-1 text-white rounded-3 bg-primary">'+doc.data().TN_NOIDUNG+'</p>');
                                        
                                    querySnapshotfile.forEach((doc2) => {
                                        const fileName = doc2.data().FDK_TEN;
                                        const fileLink = doc2.data().FDK_DUONGDAN;
                                        
                                        divData += '<div class="d-flex flex-row justify-content-end">' + showFileMessage(fileName, fileLink, '', doc2.id) + '</div>';
                                    });

                                    divData +=
                                        '        <p class="fs-2 me-3 mb-3 rounded-3 text-muted">'+ (secondsDifference(doc.data().TN_REALTIME.toDate()) == -1 ? doc.data().TN_THOIGIANGUI : secondsDifference(doc.data().TN_REALTIME.toDate())) +'</p>'+
                                        '    </div>'+
                                        '    <img src="<?php if($userLog->ND_ANHDAIDIEN) echo $userLog->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'?>" alt="" width="40" height="40" class="rounded-circle me-2">'+
                                        '</div>';
                                    chatbox.insertAdjacentHTML('afterbegin', divData);
                                }
                            }

                            else{
                                //Tin nhắn văn bản
                                if(querySnapshotfile.empty){
                                    var divData = 
                                        '<div class="d-flex flex-row justify-content-start">'+
                                        '    <img src="<?php if($userChat){ if($userChat->ND_ANHDAIDIEN) echo $userChat->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76';}?>" alt="" width="40" height="40" class="rounded-circle me-2">'+
                                        '    <div>'+
                                        '        <p class="fs-3 p-2 ms-1 mb-1 rounded-3 friend-chat">'+doc.data().TN_NOIDUNG+'</p>'+
                                        '        <p class="fs-2 ms-3 mb-3 rounded-3 text-muted float-end">'+ (secondsDifference(doc.data().TN_REALTIME.toDate()) == -1 ? doc.data().TN_THOIGIANGUI : secondsDifference(doc.data().TN_REALTIME.toDate())) +'</p>'+
                                        '    </div>'+
                                        '</div>';
                                    chatbox.insertAdjacentHTML('afterbegin', divData);
                                }
                                //Tin nhắn file
                                else{
                                    var divData = 
                                        '<div class="d-flex flex-row justify-content-start">'+
                                        '    <img src="<?php if($userChat) {if($userChat->ND_ANHDAIDIEN) echo $userChat->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76';}?>" alt="" width="40" height="40" class="rounded-circle me-2">'+
                                        '    <div>'+
                                        ((doc.data().TN_NOIDUNG=="")?'':'<p class="fs-3 p-2 ms-1 mb-1 rounded-3 friend-chat">'+doc.data().TN_NOIDUNG+'</p>');

                                    querySnapshotfile.forEach((doc2) => {
                                        const fileName = doc2.data().FDK_TEN;
                                        const fileLink = doc2.data().FDK_DUONGDAN;
                                        
                                        divData += '<div class="d-flex flex-row justify-content-start">' + showFileMessage(fileName, fileLink, 'friend-chat', doc2.id) + '</div>';
                                    });

                                    divData +=
                                        '        <p class="fs-2 ms-3 mb-3 rounded-3 text-muted float-end">'+ (secondsDifference(doc.data().TN_REALTIME.toDate()) == -1 ? doc.data().TN_THOIGIANGUI : secondsDifference(doc.data().TN_REALTIME.toDate())) +'</p>'+
                                        '    </div>'+
                                        '</div>';
                                    chatbox.insertAdjacentHTML('afterbegin', divData);
                                }
                            }
                            //|-----------------------------------------------------
                            //|GỌI SCROLL CHAT Ở CUỐI
                            //|-----------------------------------------------------
                            var messDiv = $('#chat-box');
                            messDiv.scrollTop(messDiv[0].scrollHeight);

                        })().catch((error) => {
                            console.error("Error in script: ", error);
                        });
                    });
                })().catch((error) => {
                    console.error("Error in script: ", error);
                });

                //|-----------------------------------------------------
                //|GỬI TIN NHẮN
                //|-----------------------------------------------------
                $("#message-btn").on("click", function(e) {
                    e.preventDefault();

                    var messForm = document.getElementById('message-form');
                    var TN_NOIDUNG = messForm.querySelector('textarea[name="TN_NOIDUNG"]').value;
                    // Thay thế ký tự xuống hàng bằng thẻ <br>
                    TN_NOIDUNG = TN_NOIDUNG.replace(/\n/g, '<br>');

                    var TN_FDK = fileInput.files;

                    if(TN_NOIDUNG!="" && TN_FDK.length == 0){//Thuần gửi tin nhắn thôi
                        var now = new Date();
                        var thoigiangui = formatDate(now);

                        addDoc(collection(db, "TIN_NHAN"), {
                            ND_GUI_MA: <?php echo $userLog->ND_MA; ?>,
                            ND_NHAN_MA: <?php if($userChat) echo $userChat->ND_MA; else echo 0; ?>,
                            TN_REALTIME: serverTimestamp(),
                            TN_THOIGIANGUI: thoigiangui,
                            TN_NOIDUNG: TN_NOIDUNG, // Use the value of the textarea
                            TN_TRANGTHAI: 0,
                        }).then(function(docRef) {
                            console.log('Message đã gửi with ID: ', docRef.id);
                            messForm.querySelector('textarea[name="TN_NOIDUNG"]').value = "";
                        }).catch(function(error) {
                            console.error('Error adding document: ', error);
                        });
                    }

                    if(TN_FDK.length > 0 && TN_FDK.length > dontUse.length){//Gửi có file
                        (async () => {
                            //Cho nút gửi xoay
                            const messageBtn = document.getElementById('message-btn');
                            messageBtn.classList.add('disabled-mess');
                            messageBtn.querySelector('i').classList.remove('fas', 'fa-paper-plane');
                            messageBtn.querySelector('i').classList.add('spinner-border', 'spinner-border-sm');
                            //Dùng realtime bắt sự kiện mới hiện lại nút gửi

                            //FIRESTORE----------------------------------------
                            var realtime = serverTimestamp();
                            var now = new Date();
                            var thoigiangui = formatDate(now);

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
                                    console.log('Uploaded file:', downloadURL);

                                    //FIRESTORE----------------------------------------

                                    addDoc(collection(db, "FILE_DINH_KEM"), {
                                        BV_MA: 0,
                                        BL_MA: 0,
                                        ND_GUI_MA: <?php echo $userLog->ND_MA; ?>,
                                        ND_NHAN_MA: <?php if($userChat) echo $userChat->ND_MA; else echo 0; ?>,
                                        TN_REALTIME: realtime,
                                        TN_THOIGIANGUI: thoigiangui,
                                        FDK_TEN: name,
                                        FDK_DUONGDAN: downloadURL,
                                    }).then(function(docRef) {
                                        console.log('File đã gửi with ID: ', docRef.id);
                                    }).catch(function(error) {
                                        console.error('Error adding document: ', error);
                                    });
                                }
                            }
                            selectedFilesContainer.innerHTML = '';
                            selectedImagesContainer.innerHTML = '';
                            $("input[name^='TN_FDK']").val("");

                            //Tin nhắn cần add sau để không gọi sự kiện real time
                            if(TN_NOIDUNG!=""){//Gửi kèm tin nhắn
                                addDoc(collection(db, "TIN_NHAN"), {
                                    ND_GUI_MA: <?php echo $userLog->ND_MA; ?>,
                                    ND_NHAN_MA: <?php if($userChat) echo $userChat->ND_MA; else echo 0; ?>,
                                    TN_REALTIME: realtime,
                                    TN_THOIGIANGUI: thoigiangui,
                                    TN_NOIDUNG: TN_NOIDUNG, 
                                    TN_TRANGTHAI: 0,
                                }).then(function(docRef) {
                                    console.log('Message đã gửi with ID: ', docRef.id);
                                    messForm.querySelector('textarea[name="TN_NOIDUNG"]').value = "";
                                }).catch(function(error) {
                                    console.error('Error adding document: ', error);
                                });
                            }
                            else{//Không có chat kèm theo
                                addDoc(collection(db, "TIN_NHAN"), {
                                    ND_GUI_MA: <?php echo $userLog->ND_MA; ?>,
                                    ND_NHAN_MA: <?php if($userChat) echo $userChat->ND_MA; else echo 0; ?>,
                                    TN_REALTIME: realtime,
                                    TN_THOIGIANGUI: thoigiangui,
                                    TN_NOIDUNG: '', 
                                    TN_TRANGTHAI: 0,
                                }).then(function(docRef) {
                                    console.log('Message đã gửi with ID: ', docRef.id);
                                }).catch(function(error) {
                                    console.error('Error adding document: ', error);
                                });
                            }
                            
                        })().catch((error) => {
                            console.error('Error uploading file:', error);
                        });
                        //console.log("Xoá: ", dontUse);
                    }
                });

                //|-----------------------------------------------------
                //|HIỆN LIST FRIEND
                //|-----------------------------------------------------
                (async () => {
                    const qlist = query(
                    collection(db, "TIN_NHAN"), 
                    or(where('ND_NHAN_MA', '==', <?php echo $userLog->ND_MA; ?>),
                        where('ND_GUI_MA', '==', <?php echo $userLog->ND_MA; ?>)
                    ),
                    orderBy("TN_REALTIME", "desc")
                    );

                    const querySnapshotlist = await getDocs(qlist);
                
                    //KHÔNG TỒN TẠI TIN NHẮN CŨ
                    if (querySnapshotlist.empty) {
                        var divData = `<p class="text-center p-5 m-5">Bạn và <b><?php if($userChat) echo $userChat->ND_HOTEN; ?></b> chưa có cuộc trò chuyện nào trước đây!</p>`;
                        var chatbox = document.getElementById('chat-box');
                        chatbox.insertAdjacentHTML('afterbegin', divData);

                        divData = `<p class="text-center  p-2 m-5">Bạn chưa trò chuyện với ai trước đây!</p>`;
                        var chatmesslink = document.getElementById('list-friend');
                        chatmesslink.insertAdjacentHTML('afterbegin', divData);
                    }
                    //TỒN TẠI TIN NHẮN CŨ
                    else{
                    querySnapshotlist.forEach((doc) => {
                        var checkUser =0;
                        var ND_ANHDAIDIEN2 ="";
                        var ND_HOTEN2 = "";
                        //|-----------------------------------------------------
                        //|LẤY MÃ NGƯỜI NHẮN TIN CÙNG
                        //|-----------------------------------------------------
                        if(doc.data().ND_NHAN_MA == <?php echo $userLog->ND_MA; ?>){ 
                            checkUser = doc.data().ND_GUI_MA
                        }
                        else{
                            checkUser = doc.data().ND_NHAN_MA
                        }
                        //console.log(checkUser +'-'+ user.indexOf(checkUser));

                        //|-----------------------------------------------------
                        //|NHỮNG NGƯỜI NHẮN GẦN NHẤT
                        //|-----------------------------------------------------
                        
                        var linkChat = <?php echo (json_encode(URL::to('/tin-nhan')).';'); ?>
                        //Checkuser chưa tồn tại trong mảng
                        if (userFormList.indexOf(checkUser) === -1) {
                            userFormList.push(checkUser);
                            (async () => {
                                //Lấy tên và ảnh người dùng
                                const qfriend = query(
                                    collection(db, "ANH_DAI_DIEN"), 
                                    where('ND_MA', '==', checkUser)
                                );

                                const querySnapshotfriend = await getDocs(qfriend);
                            
                                querySnapshotfriend.forEach((doc) => {
                                    ND_ANHDAIDIEN2 = doc.data().ND_ANHDAIDIEN;
                                    ND_HOTEN2 = doc.data().ND_HOTEN;
                                });
                                //console.log(querySnapshot2);
                                //console.log(ND_ANHDAIDIEN2 +'-'+ ND_HOTEN2);


                                //Đếm số lượng tin nhắn chưa xem
                                const qnocheck = query(
                                    collection(db, "TIN_NHAN"), 
                                    where("ND_NHAN_MA", "==", <?php echo $userLog->ND_MA ?>),
                                    where("ND_GUI_MA", "==", checkUser),
                                    where("TN_TRANGTHAI", "==", 0)
                                );
                                const querySnapshotnocheck = await getDocs(qnocheck);
                                //console.log(querySnapshotnocheck);
                                var noCheckMess = querySnapshotnocheck.size;
                                
                                var divData = 
                                    '<li data-value="'+checkUser+'" class="p-2 border-bottom">'+
                                    '    <a href="'+linkChat+'/'+checkUser+'" class="row">'+
                                    '        <div class="col-sm-8 d-flex flex-row">'+
                                    '            <div>'+
                                    '                <img src="'+ (ND_ANHDAIDIEN2 != "" ? ND_ANHDAIDIEN2 : 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76') +'" alt="" '+
                                    '                    width="40" height="40" class="rounded-circle me-2">'+
                                    '            </div>'+
                                    '            <div class="pt-1">'+
                                    '                <p class="fw-bold mb-0 friendName">'+ND_HOTEN2+'</p>'+
                                    '                <p class="small text-muted wrap-friend-text">' + (checkUser == doc.data().ND_NHAN_MA ? '<i>Bạn: </i>' : '') + (doc.data().TN_NOIDUNG == "" ? '<i>Đã gửi file đính kèm</i>' : doc.data().TN_NOIDUNG) +'</p>'+
                                    '            </div>'+
                                    '        </div>'+
                                    '        <div class="pt-1 col-sm-4">'+
                                    '            <p class="small text-muted mb-0">'+ (secondsDifference(doc.data().TN_REALTIME.toDate()) == -1 ? doc.data().TN_THOIGIANGUI : secondsDifference(doc.data().TN_REALTIME.toDate())) +'</p>'+
                                    ((noCheckMess == 0)? '' : '<span class="badge bg-primary rounded-pill float-end fs-1">'+ noCheckMess +'</span>' ) +
                                    '        </div>'+
                                    '    </a>'+
                                    '</li>';

                                var chatmess = document.getElementById('list-friend');
                                chatmess.insertAdjacentHTML('beforeend', divData);
                                
                            })().catch((error) => {
                                console.error("Error in script: ", error);
                            });
                        }
                        else{}
                    });
                    }

                })().catch((error) => {
                    console.error("Error in script: ", error);
                });


                //|-----------------------------------------------------
                //|BẮT SỰ KIỆN REALTIME
                //|-----------------------------------------------------
                //console.log(justLoad);

                const qrealchat = query(
                    collection(db, "TIN_NHAN"),
                    (or(where('ND_NHAN_MA', '==', <?php echo $userLog->ND_MA; ?>),
                        where('ND_GUI_MA', '==', <?php echo $userLog->ND_MA; ?>)),
                    where("TN_REALTIME", ">", justLoad)),
                    orderBy("TN_REALTIME", "desc")
                );

                //console.log("Before onSnapshot");
                const unsubscriberealchat = onSnapshot(qrealchat, (querySnapshot) => {
                    //console.log("Snapshot event received");

                    //const messages = [];
                    //Bắt tất cả dữ liệu đã có
                    /*querySnapshot.forEach((doc) => {

                        const data = doc.id; //doc.data().TN_REALTIME
                        if (data) {
                            messages.push(data);
                        } else {
                            console.error("Document is missing 'id' field:", data);
                        }
                    }*/

                    querySnapshot.docChanges().forEach((change) => {
                        const data = change.doc.data(); // Cũng có thể dùng change.doc.id / change.doc.data().TN_REALTIME
                        // Kiểm tra loại thay đổi
                        if (change.type === "added") { //Tương tự có thể dùng modified hoặc removed
                            //console.log("Document added:", data);
                            //|-----------------------------------------------------
                            //|ĐỒNG BỘ HOÁ TỐC ĐỘ HOẠT ĐỘNG TÌM FILE
                            //|-----------------------------------------------------
                            (async () => {
                                //Lấy file đính kèm
                                const qfile = query(
                                    collection(db, "FILE_DINH_KEM"), 
                                    where('ND_NHAN_MA', '==', data.ND_NHAN_MA),
                                    where('ND_GUI_MA', '==', data.ND_GUI_MA),
                                    where('BV_MA', '==', 0),
                                    where('BL_MA', '==', 0),
                                    where('TN_THOIGIANGUI', '==', data.TN_THOIGIANGUI),
                                );

                                const querySnapshotfile = await getDocs(qfile);
                                console.log(querySnapshotfile);

                                var chatbox = document.getElementById('chat-box');
                                var messDiv = $('#chat-box');

                                //NGHE TỪ BẢN THÂN GỬI ĐI => HIỆN TIN NHẮN BẢN THÂN => NGƯỜI ĐANG CÙNG TRÒ CHUYỆN
                                if(data.ND_NHAN_MA == <?php if($userChat) echo $userChat->ND_MA; else echo 0; ?>){

                                    //Tin nhắn văn bản
                                    if(querySnapshotfile.empty){
                                        var divData = 
                                            '<div class="d-flex flex-row justify-content-end">'+
                                            '    <div>'+
                                            '        <p class="fs-3 p-2 me-3 mb-1 text-white rounded-3 bg-primary">'+data.TN_NOIDUNG+'</p>'+
                                            '        <p class="fs-2 me-3 mb-3 rounded-3 text-muted">'+ (secondsDifference(data.TN_REALTIME.toDate()) == -1 ? data.TN_THOIGIANGUI : secondsDifference(data.TN_REALTIME.toDate())) +'</p>'+
                                            '    </div>'+
                                            '    <img src="<?php if($userLog->ND_ANHDAIDIEN) echo $userLog->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'?>" alt="" width="40" height="40" class="rounded-circle me-2">'+
                                            '</div>';
                                        chatbox.insertAdjacentHTML('beforeend', divData);
                                    }
                                    //Tin nhắn file
                                    else{
                                        //Cho nút gửi xoay mất đi
                                        const messageBtn = document.getElementById('message-btn');
                                        messageBtn.classList.remove('disabled-mess');
                                        messageBtn.querySelector('i').classList.remove('spinner-border', 'spinner-border-sm');
                                        messageBtn.querySelector('i').classList.add('fas', 'fa-paper-plane');

                                        var divData = 
                                            '<div class="d-flex flex-row justify-content-end">'+
                                            '    <div>'+
                                            ((data.TN_NOIDUNG=="")?'':'<p class="fs-3 p-2 me-3 mb-1 text-white rounded-3 bg-primary">'+data.TN_NOIDUNG+'</p>');

                                        querySnapshotfile.forEach((doc2) => {
                                            const fileName = doc2.data().FDK_TEN;
                                            const fileLink = doc2.data().FDK_DUONGDAN;
                                            
                                            divData += '<div class="d-flex flex-row justify-content-end">' + showFileMessage(fileName, fileLink, '', doc2.id) + '</div>';
                                        });

                                        divData +=
                                            '        <p class="fs-2 me-3 mb-3 rounded-3 text-muted">'+ (secondsDifference(data.TN_REALTIME.toDate()) == -1 ? data.TN_THOIGIANGUI : secondsDifference(data.TN_REALTIME.toDate())) +'</p>'+
                                            '    </div>'+
                                            '    <img src="<?php if($userLog->ND_ANHDAIDIEN) echo $userLog->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'?>" alt="" width="40" height="40" class="rounded-circle me-2">'+
                                            '</div>';
                                        chatbox.insertAdjacentHTML('beforeend', divData);
                                    }
                                    messDiv.scrollTop(messDiv[0].scrollHeight);
                                }

                                //NGHE TỪ CÁC BÊN GỬI ĐẾN => HIỆN TIN NHẮN NGƯỜI ĐANG CHAT CÙNG
                                if(data.ND_GUI_MA == <?php if($userChat) echo $userChat->ND_MA; else echo 0; ?>){
                                    //Tin nhắn văn bản
                                    if(querySnapshotfile.empty){
                                        // Biểu thức chính quy để tìm kiếm liên kết trong chuỗi
                                        const linkRegex = /https?:\/\/[^\s]+/g;

                                        // Sử dụng match để lấy tất cả các liên kết từ chuỗi
                                        const links = (data.TN_NOIDUNG).match(linkRegex);
                                        if (links && Array.isArray(links)) {
                                            //Tắt khung kho lưu trữ
                                            $('#kholuutru').offcanvas('hide');
                                            $('#kholuutrudetail').offcanvas('hide');
                                        }

                                        var divData = 
                                            '<div class="d-flex flex-row justify-content-start">'+
                                            '    <img src="<?php if($userChat) {if($userChat->ND_ANHDAIDIEN) echo $userChat->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76';}?>" alt="" width="40" height="40" class="rounded-circle me-2">'+
                                            '    <div>'+
                                            '        <p class="fs-3 p-2 ms-1 mb-1 rounded-3 friend-chat">'+data.TN_NOIDUNG+'</p>'+
                                            '        <p class="fs-2 ms-3 mb-3 rounded-3 text-muted float-end">'+ (secondsDifference(data.TN_REALTIME.toDate()) == -1 ? data.TN_THOIGIANGUI : secondsDifference(data.TN_REALTIME.toDate())) +'</p>'+
                                            '    </div>'+
                                            '</div>';
                                        chatbox.insertAdjacentHTML('beforeend', divData);
                                    }
                                    //Tin nhắn file
                                    else{
                                        //Tắt khung kho lưu trữ
                                        $('#kholuutru').offcanvas('hide');
                                        $('#kholuutrudetail').offcanvas('hide');

                                        var divData = 
                                            '<div class="d-flex flex-row justify-content-start">'+
                                            '    <img src="<?php if($userChat) {if($userChat->ND_ANHDAIDIEN) echo $userChat->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76';}?>" alt="" width="40" height="40" class="rounded-circle me-2">'+
                                            '    <div>'+
                                            ((data.TN_NOIDUNG=="")?'':'<p class="fs-3 p-2 ms-1 mb-1 rounded-3 friend-chat">'+data.TN_NOIDUNG+'</p>');

                                        querySnapshotfile.forEach((doc2) => {
                                            const fileName = doc2.data().FDK_TEN;
                                            const fileLink = doc2.data().FDK_DUONGDAN;
                                            
                                            divData += '<div class="d-flex flex-row justify-content-start">' + showFileMessage(fileName, fileLink, 'friend-chat', doc2.id) + '</div>';
                                        });

                                        divData +=
                                            '        <p class="fs-2 ms-3 mb-3 rounded-3 text-muted float-end">'+ (secondsDifference(data.TN_REALTIME.toDate()) == -1 ? data.TN_THOIGIANGUI : secondsDifference(data.TN_REALTIME.toDate())) +'</p>'+
                                            '    </div>'+
                                            '</div>';
                                        chatbox.insertAdjacentHTML('beforeend', divData);
                                    }
                                    messDiv.scrollTop(messDiv[0].scrollHeight);
                                    seenChat(<?php if($userChat) echo $userChat->ND_MA; else echo 0; ?>);
                                }
                            })().catch((error) => {
                                console.error("Error in script: ", error);
                            });
                            //|-----------------------------------------------------
                            //|LẮNG NGHE SỰ KIỆN TRÊN KHUNG LIST FRIEND
                            //|-----------------------------------------------------
                            var ND_ANHDAIDIEN2 ="";
                            var ND_HOTEN2 = "";
                            var linkChat = <?php echo (json_encode(URL::to('/tin-nhan')).';'); ?>
                            var checkUser =0;
                                //|-----------------------------------------------------
                                //|LẤY MÃ NGƯỜI NHẮN TIN CÙNG
                                //|-----------------------------------------------------
                                if(data.ND_NHAN_MA == <?php echo $userLog->ND_MA; ?>){ 
                                    checkUser = data.ND_GUI_MA
                                }
                                else{
                                    checkUser = data.ND_NHAN_MA
                                }

                            //Người vừa nhắn tin chưa tồn tại trong mảng
                            if (userFormList.indexOf(checkUser) === -1) {
                                userFormList.push(checkUser);
                            }
                            //Có tồn tại trong mảng rồi
                            else{
                                removeLiByValue(checkUser);
                            }
                            
                            (async () => {
                                //Lấy tên và ảnh người dùng
                                const qfriend = query(
                                    collection(db, "ANH_DAI_DIEN"), 
                                    where('ND_MA', '==', checkUser)
                                );

                                const querySnapshotfriend = await getDocs(qfriend);
                            
                                querySnapshotfriend.forEach((doc) => {
                                    ND_ANHDAIDIEN2 = doc.data().ND_ANHDAIDIEN;
                                    ND_HOTEN2 = doc.data().ND_HOTEN;
                                });

                                //Đếm số lượng tin nhắn chưa xem
                                const qnocheck = query(
                                    collection(db, "TIN_NHAN"), 
                                    where("ND_NHAN_MA", "==", <?php echo $userLog->ND_MA ?>),
                                    where("ND_GUI_MA", "==", checkUser),
                                    where("TN_TRANGTHAI", "==", 0)
                                );
                                const querySnapshotnocheck = await getDocs(qnocheck);
                                //console.log(querySnapshotnocheck);
                                var noCheckMess = querySnapshotnocheck.size;
                                
                                var divData = 
                                    '<li data-value="'+checkUser+'" class="p-2 border-bottom">'+
                                    '    <a href="'+linkChat+'/'+checkUser+'" class="row">'+
                                    '        <div class="col-sm-8 d-flex flex-row">'+
                                    '            <div>'+
                                    '                <img src="'+ (ND_ANHDAIDIEN2 != "" ? ND_ANHDAIDIEN2 : 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76') +'" alt="" '+
                                    '                    width="40" height="40" class="rounded-circle me-2">'+
                                    '            </div>'+
                                    '            <div class="pt-1">'+
                                    '                <p class="fw-bold mb-0 friendName">'+ND_HOTEN2+'</p>'+
                                    '                <p class="small text-muted wrap-friend-text">' + (checkUser == data.ND_NHAN_MA ? '<i>Bạn: </i>' : '') + (data.TN_NOIDUNG == "" ? '<i>Đã gửi file đính kèm</i>' : data.TN_NOIDUNG) +'</p>'+
                                    '            </div>'+
                                    '        </div>'+
                                    '        <div class="pt-1 col-sm-4">'+
                                    '            <p class="small text-muted mb-0">'+ (secondsDifference(data.TN_REALTIME.toDate()) == -1 ? data.TN_THOIGIANGUI : secondsDifference(data.TN_REALTIME.toDate())) +'</p>'+
                                    ((noCheckMess == 0)? '' : '<span class="badge bg-primary rounded-pill float-end fs-1">'+ noCheckMess +'</span>' ) +
                                    '        </div>'+
                                    '    </a>'+
                                    '</li>';

                                var chatmess = document.getElementById('list-friend');
                                chatmess.insertAdjacentHTML('afterbegin', divData);
                                var listDiv = $('#list-scroll');
                                listDiv.scrollTop(0);
                            })().catch((error) => {
                                console.error("Error in script: ", error);
                            });
                        }
                    });
                    //console.log("Current data: ", messages.join(", "));
                });
            }

            //|-----------------------------------------------------
            //|HÀM XỬ LÝ KHÁC
            //|-----------------------------------------------------
            //TÍNH KHOẢNG CÁCH THỜI GIAN
            function secondsDifference(realtime){
                // Ngày giờ hiện tại
                var currentDate = new Date();
                var timestampFS = realtime;

                // Sự chênh lệch giữa ngày giờ hiện tại và TN_REALTIME
                var timeDifference = currentDate - timestampFS;
                var secondsDifference = timeDifference / 1000; //giây

                if (secondsDifference < 0) {
                    return('0 giây trước');
                } else if (secondsDifference < 60) {
                    return(Math.round(secondsDifference) + ' giây trước');
                } else if (secondsDifference < 3600) {
                    return(Math.round(secondsDifference / 60) + ' phút trước');
                } else if (secondsDifference < 86400) {
                    return(Math.round(secondsDifference / 3600) + ' giờ trước');
                } else if (secondsDifference < 1296000) { 
                    return(Math.round(secondsDifference / 86400) + ' ngày trước');
                }
                else { //Nếu hơn 15 ngày
                    return -1;
                }
            }

            //ĐÁNH DẤU ĐÃ ĐỌC TIN NHẮN
            function seenChat(userChat){
                //console.log(userChat);
                (async () => {
                    const qupdatett = query(
                        collection(db, "TIN_NHAN"),
                        where("ND_NHAN_MA", "==", <?php echo $userLog->ND_MA;?>),
                        where("ND_GUI_MA", "==", userChat),
                        where("TN_TRANGTHAI", "==", 0)
                    );

                    const querySnapshotupdatett = await getDocs(qupdatett);

                    // Create an array to store all update promises
                    const updatePromises = [];
                    querySnapshotupdatett.forEach((doc) => {
                        const tnChuaDocRef = doc.ref; // Use doc.ref to get the reference to the document
                        console.log(tnChuaDocRef);
                        // Add each update operation to the promises array
                        updatePromises.push(
                            updateDoc(tnChuaDocRef, {
                            "TN_TRANGTHAI": 1
                            })
                        );
                    });
                    // Wait for all update operations to complete
                    await Promise.all(updatePromises);
                    // The updates are complete
                })().catch((error) => {
                    console.error("Error in script: ", error);
                });
            }

            //XOÁ LI CÓ DATA-VALUE YÊU CẦU
            function removeLiByValue(value) {
                // Lấy thẻ ul
                var ul = document.getElementById('list-friend');

                // Lấy tất cả các li có data-value bên trong ul
                var lis = ul.querySelectorAll('li[data-value]');

                // Lặp qua từng li để tìm li có data-value trùng với giá trị cần xoá
                lis.forEach(function(li) {
                    var liValue = parseInt(li.getAttribute('data-value'));
                    if (liValue === value) {
                        // Nếu tìm thấy, xoá li
                        li.parentNode.removeChild(li);
                    }
                });
            }

            //SHOW FILE TRONG TIN NHẮN
            function showFileMessage(fileName, fileLink, addStyle, docid){
                const fileExtension = fileName.split('.').pop().toLowerCase();
                var string;
                if(addStyle == ''){
                    var bg = 'bg-primary';
                    var txt = 'class="text-white"';
                    var btn = 'btn-primary';
                }
                else{
                    var bg = 'friend-chat';
                    var txt = 'class="text-dark"';
                    var btn = 'friend-chat text-dark';
                }
                if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                    // Image
                    string =
                        '<span class="rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block mb-3">' +
                        '    <a target="_blank" href="'+fileLink+'">' +
                        '        <img src="'+fileLink+'" width="100px" height="100px" alt="'+fileName+'" class="d-block mx-auto">' +
                        '    </a>' +
                        '    <button class="btn '+btn+' btn-sm position-absolute start-100 translate-middle bookmark-file" data-fdk-id-value="'+docid+'" style="transform: translateX(-50%);">';
                        if (fileSaved.includes(docid)) string += '    <i class="fas fa-vote-yea"></i>';
                        else  string += '    <i class="fas fa-bookmark"></i>';
                        string += 
                        '</span>';
                }
                else{
                    string =
                        '<span class="badge '+bg+' rounded-3 fw-semiboldms-0 p-1 px-3 mb-2">' +
                        '    <a target="_blank" '+txt+' href="'+fileLink+'">';

                    if (['pdf'].includes(fileExtension)){
                        string += '    <i class="fas fa-file-pdf fs-5 me-2"></i> ';
                    }
                    else if (['docx', 'doc'].includes(fileExtension)) {
                        string += '    <i class="fas fa-file-word fs-5 me-2"></i> ';
                    }
                    else if (['xlsx', 'xls'].includes(fileExtension)) {
                        string += '    <i class="fas fa-file-excel fs-5 me-2"></i> ';
                    }
                    else if (['ppt', 'pptx'].includes(fileExtension)) {
                        string += '    <i class="fas fa-file-powerpoint fs-5 me-2"></i> ';
                    }
                    else {
                        string += '    <i class="fas fa-file fs-5 me-2"></i> ';
                    }
                        
                    string += fileName +
                        '    </a>' +
                        '    <button class="btn '+btn+' btn-sm bookmark-file" data-fdk-id-value="'+docid+'">';
                    if (fileSaved.includes(docid)) string += '    <i class="fas fa-vote-yea"></i>';
                    else  string += '    <i class="fas fa-bookmark"></i>';
                    string += 
                        '</span>';
                } 
                return string;
            }

            //ĐỊNH DẠNG NGÀY THÁNG
            function formatDate(currentDate){
                const hours = currentDate.getHours();
                const minutes = currentDate.getMinutes();
                const seconds = currentDate.getSeconds();
                const day = currentDate.getDate();
                const month = currentDate.getMonth() + 1; // Tháng trong JavaScript bắt đầu từ 0
                const year = currentDate.getFullYear();

                // Định dạng lại chuỗi theo "H:i:s d/m/Y"
                const formattedDate = `${hours}:${minutes}:${seconds} ${day}/${month}/${year}`;
                return formattedDate;
            }

            //|*****************************************************
            //|NHẮN TIN END
            //|*****************************************************
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

                    console.log("Xoá " + dataValue + ": " + dontUse);
                });
            });
            //|*****************************************************
            //|UPLOAD FILE END
            //|*****************************************************
            //|*****************************************************
            //|KHO LƯU TRỮ START
            //|*****************************************************

            const qklt = query(
                collection(db, "FILE_DINH_KEM"), 
                where("ND_NHAN_MA", "in", [<?php if($userChat) echo $userChat->ND_MA; ?>, <?php echo $userLog->ND_MA; ?>]),
                where("ND_GUI_MA", "in", [<?php if($userChat) echo $userChat->ND_MA; ?>, <?php echo $userLog->ND_MA; ?>]),
                orderBy("TN_REALTIME", "desc")
            );

            const qlink = query(
                collection(db, "TIN_NHAN"), 
                where("ND_NHAN_MA", "in", [<?php if($userChat) echo $userChat->ND_MA; ?>, <?php echo $userLog->ND_MA; ?>]),
                where("ND_GUI_MA", "in", [<?php if($userChat) echo $userChat->ND_MA; ?>, <?php echo $userLog->ND_MA; ?>]),
                orderBy("TN_REALTIME", "desc")
            );

            //KHO LƯU TRỮ TỔNG
            $('#kholuutru-btn').on('click', function() {
                //|-----------------------------------------------------
                //|DANH SÁCH FILE NGƯỜI DÙNG ĐÃ LƯU
                //|-----------------------------------------------------
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
                    const querySnapshotlink = await getDocs(qlink);

                    var imagecount = 0;
                    var documentcount = 0;
                    var linkcount = 0;
                    var listimages = document.getElementById('list-images');
                    var listdocuments = document.getElementById('list-documents');
                    var listlinks = document.getElementById('list-links');
                    
                    listimages.innerHTML = '';
                    listdocuments.innerHTML = '';
                    listlinks.innerHTML = '';

                    querySnapshotklt.forEach((doc) => {
                        const fileName = doc.data().FDK_TEN;
                        const fileLink = doc.data().FDK_DUONGDAN;
                        const fileExtension = fileName.split('.').pop().toLowerCase();
                        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension) && imagecount < 5) {
                            var divData = 
                                '<span class="col-md-3 col-sm-4 rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block mb-3">' +
                                '    <a target="_blank" href="'+fileLink+'" previewlistener="true">' +
                                '        <img src="'+fileLink+'"  width="100px" height="100px" alt="'+fileName+'" class="d-block mx-auto">' +
                                '    </a>' +
                                '    <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle bookmark-file" data-fdk-id-value="'+doc.id+'" style="transform: translateX(-50%);">' ;
                            if (fileSaved.includes(doc.id)) divData += '    <i class="fas fa-vote-yea"></i>';
                            else  divData += '    <i class="fas fa-bookmark"></i>';
                            divData += 
                                '    </button>' +
                                '</span>';
                            listimages.insertAdjacentHTML('beforeend', divData);
                            imagecount++;
                        }
                        else if (!['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension) && documentcount < 5){
                            var divData =
                                '<li class="p-2 border-bottom d-flex justify-content-between">' +
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
                                '                <p class="small text-muted"><i>Từ: </i><i>' + 
                                ((doc.data().ND_GUI_MA == <?php echo $userLog->ND_MA?>)? '<?php echo $userLog->ND_HOTEN?>' : '<?php if($userChat) echo $userChat->ND_HOTEN; else echo 0?>') +
                                '                   </i></p>' +
                                '            </div>' +
                                '        </div>' +
                                '    </a>' +
                                '    <button class="btn btn-secondary btn-sm bookmark-file" data-fdk-id-value="'+doc.id+'" style="height: 28px !important;">';
                            if (fileSaved.includes(doc.id)) divData += '    <i class="fas fa-vote-yea"></i>';
                            else  divData += '    <i class="fas fa-bookmark"></i>';
                            divData += 
                                '</li>';

                            listdocuments.insertAdjacentHTML('beforeend', divData);
                            documentcount++;
                        }
                        else if (imagecount >= 5 && documentcount >= 5 ) return;
                        else{}
                    });

                    querySnapshotlink.forEach((doc2) => {
                        // Biểu thức chính quy để tìm kiếm liên kết trong chuỗi
                        const linkRegex = /https?:\/\/[^\s]+/g;

                        // Sử dụng match để lấy tất cả các liên kết từ chuỗi
                        const links = (doc2.data().TN_NOIDUNG).match(linkRegex);
                        if (links && Array.isArray(links)) {
                            links.forEach((link) => {
                                if (linkcount < 5){
                                    var divData =
                                        '<li data-value="4" class="p-2 border-bottom">'+
                                        '    <a href="'+link+'" target="_blank" class="d-flex justify-content-between">'+
                                        '        <div class="d-flex flex-row" style="max-width:100%">'+
                                        '            <div>'+
                                        '                <i class="fas fa-link me-2 document-icon"></i>'+
                                        '            </div>'+
                                        '            <div class="pt-1" style="overflow: hidden;">'+
                                        '                <p class="fw-bold mb-0">'+link+'</p>'+
                                        '                <p class="small text-muted"><i>Từ: </i><i>' + 
                                        ((doc2.data().ND_GUI_MA == <?php echo $userLog->ND_MA?>)? '<?php echo $userLog->ND_HOTEN?>' : '<?php if($userChat) echo $userChat->ND_HOTEN; else echo 0?>') +
                                        '                   </i></p>' +
                                        '            </div>'+
                                        '        </div>'+
                                        '    </a>'+
                                        '</li>';

                                    listlinks.insertAdjacentHTML('beforeend', divData);
                                    linkcount++;
                                }
                                else return;
                            });
                        }
                    });

                    if(imagecount >= 5){
                        var divData = 
                            '<div class="text-center">' +
                            '    <button class="btn btn-secondary mt-2" type="button" data-bs-toggle="offcanvas" id="kholuutruimages-btn" data-bs-target="#kholuutrudetail"> Xem thêm</button>' +
                            '</div>';
                        listimages.insertAdjacentHTML('beforeend', divData);
                    }
                    if(documentcount >= 5){
                        var divData = 
                            '<div class="text-center">' +
                            '    <button class="btn btn-secondary mt-2" type="button" data-bs-toggle="offcanvas" id="kholuutrudocuments-btn" data-bs-target="#kholuutrudetail"> Xem thêm</button>' +
                            '</div>';
                        listdocuments.insertAdjacentHTML('beforeend', divData);
                    }
                    if(linkcount >= 5){
                        var divData = 
                            '<div class="text-center">' +
                            '    <button class="btn btn-secondary mt-2" type="button" data-bs-toggle="offcanvas" id="kholuutrulinks-btn" data-bs-target="#kholuutrudetail"> Xem thêm</button>' +
                            '</div>';
                        listlinks.insertAdjacentHTML('beforeend', divData);
                    }

                    //KHO LƯU TRỮ ẢNH
                    $('#kholuutruimages-btn').on('click', function() {
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

                            var detailtitle = document.getElementById('detail-title');
                            var detailbody = document.getElementById('detail-body');
                            
                            detailtitle.innerHTML = 'Ảnh';
                            detailbody.innerHTML = '';

                            querySnapshotklt.forEach((doc) => {
                                const fileName = doc.data().FDK_TEN;
                                const fileLink = doc.data().FDK_DUONGDAN;
                                const fileExtension = fileName.split('.').pop().toLowerCase();
                                if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                                    var divData = 
                                        '<span class="col-md-3 col-sm-4 rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block mb-3">' +
                                        '    <a target="_blank" href="'+fileLink+'" previewlistener="true">' +
                                        '        <img src="'+fileLink+'"  width="100px" height="100px" alt="'+fileName+'" class="d-block mx-auto">' +
                                        '    </a>' +
                                        '    <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle bookmark-file" data-fdk-id-value="'+doc.id+'" style="transform: translateX(-50%);">' ;
                                    if (fileSaved.includes(doc.id)) divData += '    <i class="fas fa-vote-yea"></i>';
                                    else  divData += '    <i class="fas fa-bookmark"></i>';
                                    divData += 
                                        '    </button>' +
                                        '</span>';
                                        detailbody.insertAdjacentHTML('beforeend', divData);
                                }
                            })
                        })().catch((error) => {
                            console.error("Error in script: ", error);
                        });
                    });

                    //KHO LƯU TRỮ FILE
                    $('#kholuutrudocuments-btn').on('click', function() {
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

                            var detailtitle = document.getElementById('detail-title');
                            var detailbody = document.getElementById('detail-body');
                            
                            detailtitle.innerHTML = 'File';
                            detailbody.innerHTML = '';

                            querySnapshotklt.forEach((doc) => {
                                const fileName = doc.data().FDK_TEN;
                                const fileLink = doc.data().FDK_DUONGDAN;
                                const fileExtension = fileName.split('.').pop().toLowerCase();
                                if (!['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                                    var divData =
                                        '<li class="p-2 border-bottom d-flex justify-content-between">' +
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
                                        '                <p class="small text-muted"><i>Từ: </i><i>' + 
                                        ((doc.data().ND_GUI_MA == <?php echo $userLog->ND_MA?>)? '<?php echo $userLog->ND_HOTEN?>' : '<?php if($userChat) echo $userChat->ND_HOTEN; else echo 0?>') +
                                        '                   </i></p>' +
                                        '            </div>' +
                                        '        </div>' +
                                        '    </a>' +
                                        '    <button class="btn btn-secondary btn-sm bookmark-file" data-fdk-id-value="'+doc.id+'" style="height: 28px !important;">';
                                    if (fileSaved.includes(doc.id)) divData += '    <i class="fas fa-vote-yea"></i>';
                                    else  divData += '    <i class="fas fa-bookmark"></i>';
                                    divData += 
                                        '</li>';

                                    detailbody.insertAdjacentHTML('beforeend', divData);
                                }
                            })
                        })().catch((error) => {
                            console.error("Error in script: ", error);
                        });
                    });

                    $('#kholuutrulinks-btn').on('click', function() {
                        (async () => {
                            const querySnapshotlink = await getDocs(qlink);

                            var detailtitle = document.getElementById('detail-title');
                            var detailbody = document.getElementById('detail-body');
                            
                            detailtitle.innerHTML = 'Link';
                            detailbody.innerHTML = '';

                            querySnapshotlink.forEach((doc2) => {
                                // Biểu thức chính quy để tìm kiếm liên kết trong chuỗi
                                const linkRegex = /https?:\/\/[^\s]+/g;

                                // Sử dụng match để lấy tất cả các liên kết từ chuỗi
                                const links = (doc2.data().TN_NOIDUNG).match(linkRegex);
                                if (links && Array.isArray(links)) {
                                    links.forEach((link) => {
                                        var divData =
                                            '<li data-value="4" class="p-2 border-bottom">'+
                                            '    <a href="'+link+'" target="_blank" class="d-flex justify-content-between">'+
                                            '        <div class="d-flex flex-row" style="max-width:100%">'+
                                            '            <div>'+
                                            '                <i class="fas fa-link me-2 document-icon"></i>'+
                                            '            </div>'+
                                            '            <div class="pt-1" style="overflow: hidden;">'+
                                            '                <p class="fw-bold mb-0">'+link+'</p>'+
                                            '                <p class="small text-muted"><i>Từ: </i><i>' + 
                                            ((doc2.data().ND_GUI_MA == <?php echo $userLog->ND_MA?>)? '<?php echo $userLog->ND_HOTEN?>' : '<?php if($userChat) echo $userChat->ND_HOTEN; else echo 0?>') +
                                            '                   </i></p>' +
                                            '            </div>'+
                                            '        </div>'+
                                            '    </a>'+
                                            '</li>';

                                        detailbody.insertAdjacentHTML('beforeend', divData);
                                    });
                                }
                            });
                        })().catch((error) => {
                            console.error("Error in script: ", error);
                        });
                    });

                })().catch((error) => {
                    console.error("Error in script: ", error);
                });
            });

            //|*****************************************************
            //|KHO LƯU TRỮ END
            //|*****************************************************
            //|*****************************************************
            //|SEARCH FRIEND START
            //|*****************************************************
                // Bắt sự kiện khi người dùng nhập liệu
                $('#search-friend').on('input', function() {
                    // Lấy giá trị nhập liệu
                    const inputValue = $(this).val().trim().toLowerCase();

                    // Lặp qua các phần tử cần tìm kiếm
                    $('.friendName').each(function() {
                        const targetText = $(this).text().toLowerCase();

                        // So sánh nếu từ khóa xuất hiện trong nội dung
                        if (targetText.includes(inputValue)) {
                            $(this).parent().parent().parent().parent().show();
                            //console.log('true: ', targetText);
                        } else {
                            $(this).parent().parent().parent().parent().hide();
                            //console.log('False: ', targetText);
                        }
                    });
                });
            //|*****************************************************
            //|SEARCH FRIEND END
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
        });
    </script>


<?php $userChat= Session::put('userChat', null);  ?>
@endsection