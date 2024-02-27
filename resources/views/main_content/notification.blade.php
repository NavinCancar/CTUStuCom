@extends('welcome')
@section('content')
<?php 
    $userLog= Session::get('userLog');  
?>
    
    <!-- Content Start -->
    <div class="container-fluid">
        <div class="row" id="khungnotilon">
            <div class="col-lg-12">
                <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Thông báo</h5>
                </div>
                <hr>
        
                <div class="card">
                    <div class="card-body p-2">
                        <div class="mb-3 mb-sm-0" id="list-noti-lon">
                            <!--Noti Start -->
                            <!--<div class="noti-item p-3">
                                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 text-muted mt-1 mb-2"
                                style="flex-wrap: wrap;">
                                <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35"
                                    class="rounded-circle">
                                <p class="mb-0 fs-3" style="max-width: 85%; overflow-wrap: break-word; white-space: normal;">
                                    Trần Kim Anh đã thích bài viết của bạn: Tìm giáo trình Anh văn căn bản chưa hết hạn.
                                </p>
                                </a>
                            </div>-->
                            <!--Noti End -->
                        </div>
                    </div>
                </div>
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
            <?php if($userLog) { ?>
              //|*****************************************************
              //|THÔNG BÁO START
              //|***************************************************** 
              var notiFormList = [];
              var justLoad = new Date();
              //|-----------------------------------------------------
              //|HIỆN CÁC THÔNG BÁO CHAT GẦN NHẤT -> XOÁ
              //|-----------------------------------------------------
              //|-----------------------------------------------------
              //|BẮT SỰ KIỆN REALTIME
              //|-----------------------------------------------------
              //console.log(justLoad);
              
              const qrealnoti = query(
                  collection(db, "THONG_BAO"), 
                  where('ND_NHAN_MA', '==', <?php echo $userLog->ND_MA; ?>),
                  orderBy("TB_REALTIME", "desc")
              );

              //console.log("Before onSnapshot");
              const unsubscriberealnoti = onSnapshot(qrealnoti, (querySnapshot) => {
                //console.log("Snapshot event received");
                //console.log(notiFormList);

                //KHÔNG TỒN TẠI THÔNG BÁO CŨ
                if (querySnapshot.empty) {
                    //console.log('no data');
                    var divData = `<h4 class="text-center p-2 m-5 p-5">Bạn chưa có thông báo nào trước đây!</h4>`;
                    var khungnotilon = document.getElementById('khungnotilon');
                    khungnotilon.insertAdjacentHTML('beforebegin', divData);
                    khungnotilon.style.display = "none";
                }
                //TỒN TẠI THÔNG BÁO CŨ
                else{
                  querySnapshot.docChanges().forEach((change) => {
                      
                      const iddata = change.doc.id;
                      const data = change.doc.data(); // Cũng có thể dùng change.doc.id / change.doc.data().TN_REALTIME
                      var checkRealtimeNoti = justLoad;
                      if (data.TB_REALTIME != null){
                        checkRealtimeNoti = new Date(data.TB_REALTIME.seconds * 1000);
                      }
                      // Kiểm tra loại thay đổi
                      if (change.type === "added" || change.type === "modified") { //Tương tự có thể dùng modified hoặc removed
                        //console.log("ID Document added:", iddata);
                        //console.log("Document added:", data);
                        //console.log("Ori ",notiFormList);
                        
                        //|-----------------------------------------------------
                        //|LẤY 5 NGƯỜI NHẮN GẦN NHẤT
                        //|-----------------------------------------------------
                        if (checkRealtimeNoti < justLoad) {
                            //checkNoti chưa tồn tại trong mảng
                            if (notiFormList.indexOf(iddata) === -1) {
                                notiFormList.push(iddata);
                                AddListNoti();
                            }
                            else{}
                        }
                        else {
                          //Người vừa nhắn tin chưa tồn tại trong mảng
                          if (notiFormList.indexOf(iddata) === -1) {
                            if (notiFormList.length >= 5) {
                              var lastElement = notiFormList[4];
                              //console.log(lastElement);
                              removeAByValueNoti(lastElement);
                              // Xoá phần tử cuối cùng
                              notiFormList.pop();
                            }
                            //thêm đầu mảng, push là thêm cuối mảng
                            notiFormList.unshift(iddata);
                          }
                          //Có tồn tại trong mảng rồi
                          else{
                              removeAByValueNoti(iddata);
                          }
                          AddListNoti();
                          //console.log("New ",notiFormList);
                        }

                        function AddListNoti(){
                            var divData = 
                                '    <a data-value="'+iddata+'" data-href="'+data.TB_DUONGDAN+'" class="p-3 noti-item cursor-pointer d-flex align-items-center gap-2 text-muted mt-1 mb-2 noti-href"' +
                                '    style="flex-wrap: wrap;">' +
                                '  <img src="'+ (data.TB_ANHDINHKEM != null ? data.TB_ANHDINHKEM : 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76') +'" alt="" width="35" height="35"'+
                                '        class="rounded-circle">' +
                                '    <p class="mb-0 fs-3" style="max-width: 85%; overflow-wrap: break-word; white-space: normal;">' +
                                data.TB_NOIDUNG +
                                '    </p>' +
                                (data.TB_TRANGTHAI==0 ? '<div class="notification bg-primary rounded-circle"></div>' : '') +
                                '    </a>';

                            var listnoti = document.getElementById('list-noti-lon');
                            if (checkRealtimeNoti < justLoad) listnoti.insertAdjacentHTML('beforeend', divData);
                            else listnoti.insertAdjacentHTML('afterbegin', divData);
                        }
                      }
                  });
                  //console.log("Current data: ", messages.join(", "));
                }
              });

              //|-----------------------------------------------------
              //|HÀM XỬ LÝ KHÁC
              //|-----------------------------------------------------

              //XOÁ A CÓ DATA-VALUE YÊU CẦU
              function removeAByValueNoti(value) {
                  var div = document.getElementById('list-noti-lon');

                  var as = div.querySelectorAll('a[data-value]');

                  // Lặp qua từng li để tìm li có data-value trùng với giá trị cần xoá
                  as.forEach(function(a) {
                      var aValue = a.getAttribute('data-value');
                      if (aValue === value) {
                          a.parentNode.removeChild(a);
                      }
                  });
              }

              $(document).on('click', '.noti-href', function() {
                  var element = $(this);
                  var iddata = element.data('value');
                  var href = element.data('href');

                  (async () => {
                      const ref = doc(db, "THONG_BAO", iddata);

                      await updateDoc(ref, {
                          TB_TRANGTHAI: 1
                      });
                  })().catch((error) => {
                      console.error("Error in script: ", error);
                  });
                  window.location.href = href;
              });
              //|*****************************************************
              //|THÔNG BÁO END
              //|***************************************************** 
            <?php } ?>
        })
    </script>
@endsection