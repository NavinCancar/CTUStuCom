@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); 
    use Carbon\Carbon;?>
    
    <!-- Content Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card" id="chat">
                    <div class="d-flex justify-content-start align-items-center p-1 bg-secondary" style="border-radius: 15px 15px 0 0">
                        <img src="https://i.pinimg.com/236x/cb/93/4b/cb934b08c56332e136eda2dc8142453b.jpg" alt="" width="40" height="40"
                            class="rounded-circle me-2">
                        <b>Nguyễn Minh Ngọc</b>
                    </div>
                    <div class="card-body p-3">
                        <!--Chat Start-->
                        <div class="pt-1 pe-3 scroll-chat" id="chat-box">

                            <!--<div class="d-flex flex-row justify-content-start">
                                <img src="https://i.pinimg.com/236x/cb/93/4b/cb934b08c56332e136eda2dc8142453b.jpg" alt="" width="40" height="40"
                                    class="rounded-circle me-2">
                                <div>
                                    <p class="fs-3 p-2 ms-1 mb-1 rounded-3 friend-chat">
                                        Neque porro quisquam
                                        est, qui dolorem ipsum quia dolor sit amet, consectetur,
                                        adipisci velit, sed quia non numquam
                                        eius modi tempora incidunt ut labore et dolore magnam aliquam
                                        quaerat voluptatem.</p>
                                    <p class="fs-2 ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM |
                                        Aug 13</p>
                                </div>
                            </div>
                            
                            <div class="d-flex flex-row justify-content-end">
                                <div>
                                    <p class="fs-3 p-2 me-3 mb-1 text-white rounded-3 bg-primary">
                                        enim ad minima veniam, quis
                                        nostrum exercitationem ullam corporis suscipit laboriosam, nisi
                                        ut aliquid ex ea commodi consequatur?</p>
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
                                
                                <label for="file-input" class="ms-3 text-muted">
                                    <i class="fas fa-paperclip"></i>
                                </label>
                                <!-- Input type file ẩn -->
                                <input name="TN_FDK" type="file" id="file-input" style="display: none" multiple/>
                                <button type="submit" id="message-btn" class="btn text-primary"><i class="fas fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary btn-block me-2 mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#kholuutru">
                    <i class="fas fa-box"></i> Kho lưu trữ
                </button>
                <!-- Kho lưu trữ Start-->
                <div class="offcanvas offcanvas-end" id="kholuutru">
                    <div class="offcanvas-header">
                        <h1 class="offcanvas-title">Heading</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body">
                        <p>Some text lorem ipsum.</p>
                        <p>Some text lorem ipsum.</p>
                        <p>Some text lorem ipsum.</p>
                        <button class="btn btn-secondary" type="button">A Button</button>
                    </div>
                </div>
                <!-- Kho lưu trữ End-->
                <!-- DS bạn Start -->
                <div class="card">
                    <div class="card-body p-3">
                        <div class="input-group rounded mb-2">
                            <form class="d-flex">
                                <input class="form-control me-2" type="text" placeholder="Search">
                                <button class="btn btn-outline-primary" type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>

                        <div class="scroll-chat">
                            <ul class="list-unstyled mb-0">
                                <li class="p-2 border-bottom">
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
                                </li>
                                <li class="p-2 border-bottom">
                                    <a href="#" class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <div>
                                                <img src="https://i.pinimg.com/236x/cb/93/4b/cb934b08c56332e136eda2dc8142453b.jpg" alt="" 
                                                    width="40" height="40" class="rounded-circle me-2">
                                            </div>
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0">Alexa Chung</p>
                                                <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-0">5 phút</p>
                                            <span class="badge bg-primary rounded-pill float-end fs-1">2</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="p-2 border-bottom">
                                    <a href="#" class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <div>
                                                <img src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg" alt="" 
                                                    width="40" height="40" class="rounded-circle me-2">
                                            </div>
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0">Trần Hùng</p>
                                                <p class="small text-muted">Mình xin tài liệu</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-0">Hôm qua</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="p-2 border-bottom">
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
                                            <p class="small text-muted mb-0">Hôm qua</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="p-2 border-bottom">
                                    <a href="#" class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <div>
                                                <img src="https://i.pinimg.com/236x/cb/93/4b/cb934b08c56332e136eda2dc8142453b.jpg" alt="" 
                                                    width="40" height="40" class="rounded-circle me-2">
                                            </div>
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0">Alexa Chung</p>
                                                <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-0">Hôm qua</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="p-2 border-bottom">
                                    <a href="#" class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <div>
                                                <img src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg" alt="" 
                                                    width="40" height="40" class="rounded-circle me-2">
                                            </div>
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0">Trần Hùng</p>
                                                <p class="small text-muted">Ê cho hỏi cái</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-0">5 ngày</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- DS bạn End -->
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <script type="module">
        //|-----------------------------------------------------
        //|KHAI BÁO FIRESTORE
        //|-----------------------------------------------------
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import { getFirestore, setDoc, addDoc, doc, collection, serverTimestamp, getDocs, query, where, orderBy  } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";

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


        $(document).ready(function() {
        
            //|-----------------------------------------------------
            //|SHOW CHAT
            //|-----------------------------------------------------

            /*(async () => {
                const querySnapshot = await getDocs(collection(db, "messages"));

                querySnapshot.forEach((doc) => {
                    // doc.data() is never undefined for query doc snapshots
                    console.log(doc.id, " => ", doc.data());
                });
            })().catch((error) => {
                console.error("Error in script: ", error);
            });*/

            (async () => {
                const q = query(
                    collection(db, "messages"),
                    where("ND_NHAN_MA", "in", [2, 4]),
                    where("ND_GUI_MA", "in", [2, 4]),
                    orderBy("TN_REALTIME", "asc")
                );

                const querySnapshot = await getDocs(q);
                querySnapshot.forEach((doc) => {
                    // doc.data() is never undefined for query doc snapshots
                    //console.log(doc.id, " => ", doc.data());

                    //|-----------------------------------------------------
                    //|HIỆN CHAT
                    //|-----------------------------------------------------
                    if(doc.data().ND_GUI_MA == <?php echo $userLog->ND_MA; ?>){
                        var divData = 
                            '<div class="d-flex flex-row justify-content-end">'+
                            '    <div>'+
                            '        <p class="fs-3 p-2 me-3 mb-1 text-white rounded-3 bg-primary">'+doc.data().TN_NOIDUNG+'</p>'+
                            '        <p class="fs-2 me-3 mb-3 rounded-3 text-muted">'+doc.data().TN_THOIGIANGUI+'</p>'+
                            '    </div>'+
                            '    <img src="public/images/users/<?php if($userLog->ND_ANHDAIDIEN) echo $userLog->ND_ANHDAIDIEN; else echo 'macdinh.png'?>" alt="" width="40" height="40" class="rounded-circle me-2">'+
                            '</div>';
                        var chatbox = document.getElementById('chat-box');
                        chatbox.insertAdjacentHTML('beforeend', divData);
                    }
                    else{
                        var divData = 
                            '<div class="d-flex flex-row justify-content-start">'+
                            '    <img src="https://i.pinimg.com/236x/cb/93/4b/cb934b08c56332e136eda2dc8142453b.jpg" alt="" width="40" height="40" class="rounded-circle me-2">'+
                            '    <div>'+
                            '        <p class="fs-3 p-2 ms-1 mb-1 rounded-3 friend-chat">'+doc.data().TN_NOIDUNG+'</p>'+
                            '        <p class="fs-2 ms-3 mb-3 rounded-3 text-muted float-end">'+doc.data().TN_THOIGIANGUI+'</p>'+
                            '    </div>'+
                            '</div>';
                        var chatbox = document.getElementById('chat-box');
                        chatbox.insertAdjacentHTML('beforeend', divData);
                    }


                    //|-----------------------------------------------------
                    //|GỌI SCROLL CHAT Ở CUỐI
                    //|-----------------------------------------------------
                    var messDiv = $('#chat-box');
                    messDiv.scrollTop(messDiv[0].scrollHeight);
                });
            })().catch((error) => {
                console.error("Error in script: ", error);
            });

            //|-----------------------------------------------------
            //|GỬI TIN NHẮN
            //|-----------------------------------------------------
            $("#message-btn").on("click", function(e) {
                
                //e.preventDefault();

                var messForm = document.getElementById('message-form');
                var TN_NOIDUNG = messForm.querySelector('textarea[name="TN_NOIDUNG"]').value;

                addDoc(collection(db, "messages"), {
                    ND_GUI_MA: <?php echo $userLog->ND_MA; ?>,
                    ND_NHAN_MA: 2,
                    TN_REALTIME: serverTimestamp(),
                    TN_THOIGIANGUI: '<?php echo Carbon::now('Asia/Ho_Chi_Minh')->format("H:i d/m/Y"); ?>',
                    TN_NOIDUNG: TN_NOIDUNG, // Use the value of the textarea
                    TN_TRANGTHAI: 0,
                }).then(function(docRef) {
                    console.log('Message đã gửi with ID: ', docRef.id);
                    messForm.querySelector('textarea[name="TN_NOIDUNG"]').value = "";
                }).catch(function(error) {
                    console.error('Error adding document: ', error);
                });
                
            });
        });
        
    </script>
@endsection