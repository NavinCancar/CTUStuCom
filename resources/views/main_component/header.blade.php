  <?php 
    $userLog= Session::get('userLog'); 
    $uSysAvatar= Session::get('uSysAvatar');
  ?>
    <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="fa fa-bars"></i>
              </a>
            </li>
            <form class="d-flex nav-search" role="form" action="{{URL::to('/ket-qua-tim-kiem')}}" method="POST">
              {{ csrf_field() }}
              <input class="form-control me-2" type="text" name="keywords" placeholder="Tìm kiếm...">
              <button class="btn btn-outline-primary" type="submit"><i class="fa fa-search"></i></button>
            </form>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item d-xl-none dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop4" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fa fa-search"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                  <div class="message-body">
                    <form class="d-flex m-3" role="form" action="{{URL::to('/ket-qua-tim-kiem')}}" method="POST">
                      {{ csrf_field() }}
                      <input class="form-control me-2" type="text" name="keywords" placeholder="Tìm kiếm...">
                      <button class="btn btn-outline-primary" type="submit"><i class="fa fa-search"></i></button>
                    </form>
                  </div>
                </div>
              </li>
              @if($userLog)
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop3" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fab fa-facebook-messenger"></i>
                  <!--<div class="notification bg-primary rounded-circle" id="message-circle" style="display:none"></div>-->
                  <span class="badge rounded-pill bg-primary float-end fs-1 px-2" id="message-circle" style="display:none; position: relative;top: -10px; left: -7px"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop3">
                  <div class="message-body">
                    <div id="chat-message">
                      <!--<a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item mt-1 mb-1"
                        style="flex-wrap: wrap;">
                        <img src="{{asset('public/images/profile/user-1.jpg')}}" alt="" width="35" height="35"
                          class="rounded-circle">
                        <span class="mb-0 fs-3" style="max-width: 85%; overflow-wrap: break-word; white-space: normal;">
                          <b>Nguyễn Minh Ngọc</b><br>
                          Chào bạn nhe!!!
                        </span>
                      </a>-->
                    </div>
                    <hr>
                    <div class="text-center mb-1"><a href="{{URL::to('/tin-nhan')}}" id="chat-message-link" class="card-link">Xem thêm</a></div>
                  </div>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fa fa-bell"></i>
                  <!--<div class="notification bg-primary rounded-circle"></div>-->
                  <span class="badge rounded-pill bg-primary float-end fs-1 px-2" id="noti-circle" style="display:none; position: relative;top: -10px; left: -7px"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                  <div class="message-body">
                    <div id="list-noti">
                    <!--<a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item mt-1 mb-1"
                      style="flex-wrap: wrap;">
                      <img src="{{asset('public/images/profile/user-1.jpg')}}" alt="" width="35" height="35"
                        class="rounded-circle">
                      <p class="mb-0 fs-3" style="max-width: 85%; overflow-wrap: break-word; white-space: normal;">
                        Trần Kim Anh đã thích bài viết của bạn: Tìm giáo trình Anh văn căn bản chưa hết hạn.
                      </p>
                    </a>-->
                    </div>
                    <hr>
                    <div class="text-center mb-1"><a href="{{URL::to('/thong-bao')}}" id="list-noti-link" class="card-link">Xem thêm</a></div>
                  </div>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="<?php if($userLog->ND_ANHDAIDIEN) echo $userLog->ND_ANHDAIDIEN; else echo config('constants.default_avatar');?>" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                  <div class="message-body">
                    <a href="{{URL::to('/tai-khoan/'.$userLog -> ND_MA)}}" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="fa fa-user"></i>
                      <p class="mb-0 fs-3">Trang cá nhân</p>
                    </a>
                    <a href="{{URL::to('/tai-khoan/'.$userLog -> ND_MA.'/edit')}}" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="fas fa-user-cog"></i>
                      <p class="mb-0 fs-3">Cập nhật tài khoản</p>
                    </a>
                    <a href="{{URL::to('/doi-mat-khau')}}" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="fas fa-lock"></i>
                      <p class="mb-0 fs-3">Đổi mật khẩu</p>
                    </a>
                    <a href="{{URL::to('/dang-xuat')}}" class="btn btn-outline-danger mx-3 mt-2 d-block">Đăng xuất</a>
                  </div>
                </div>
              </li>
              @else
              <li class="nav-item d-flex">
                <a href="{{URL::to('/dang-nhap')}}" class="btn btn-primary px-2 me-2">Đăng nhập</a>
                <a href="{{URL::to('/dang-ky')}}" class="btn btn-outline-primary px-2">Đăng ký</a>
              </li>
              @endif
            </ul>
          </div>
        </nav>
      </header>

      
      <script type="module">
        //|-----------------------------------------------------
        //|KHAI BÁO FIRESTORE
        //|-----------------------------------------------------
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import { getFirestore, doc, collection, getDocs, updateDoc, query, where, orderBy, limit, or, onSnapshot } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";

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
            <?php if($userLog) {?>//Không có dòng này navbar sẽ gây lỗi
              //|*****************************************************
              //|NHẮN TIN START
              //|***************************************************** 
              var justLoad = new Date();
              var userFormList = [];

              //|-----------------------------------------------------
              //|HIỆN CÁC THÔNG BÁO CHAT GẦN NHẤT -> XOÁ
              //|-----------------------------------------------------
              //|-----------------------------------------------------
              //|BẮT SỰ KIỆN REALTIME
              //|-----------------------------------------------------
              //console.log(justLoad);

              const qrealchat = query(
                  collection(db, "TIN_NHAN"),
                  (or(where('ND_NHAN_MA', '==', <?php echo $userLog->ND_MA; ?>),
                      where('ND_GUI_MA', '==', <?php echo $userLog->ND_MA; ?>))),
                  orderBy("TN_REALTIME", "desc")
              );

              var firstLoad = 0;
              //console.log("Before onSnapshot");
              const unsubscriberealchat = onSnapshot(qrealchat, (querySnapshot) => {
                //console.log("Snapshot event received");
                //console.log(userFormList);

                //KHÔNG TỒN TẠI TIN NHẮN CŨ
                if (querySnapshot.empty && firstLoad == 0) {
                    //console.log('no data');
                    var divData = `<p class="text-center p-2 no-chat">Bạn chưa có cuộc trò chuyện nào trước đây!</p>`;

                    var chatmess = document.getElementById('chat-message');
                    chatmess.insertAdjacentHTML('afterbegin', divData);

                    var chatmesslink = document.getElementById('chat-message-link');
                    chatmesslink.style.display = "none";
                    firstLoad = 1;
                }
                //TỒN TẠI TIN NHẮN CŨ
                else{
                  querySnapshot.docChanges().forEach((change) => {
                      firstLoad = 1;
                      $('.no-chat').remove();
                      $('#chat-message-link').show();
                      //|-----------------------------------------------------
                      //|ICON MESSAGE
                      //|-----------------------------------------------------
                      (async () => {
                        const qiconmess = query(
                          collection(db, "TIN_NHAN"), 
                          where('ND_NHAN_MA', '==', <?php echo $userLog->ND_MA; ?>),
                          where("TN_TRANGTHAI", "==", 0)
                        );
                        const querySnapshoticonmess = await getDocs(qiconmess);
                        //console.log(querySnapshotnocheck);
                        var noCheckMessSum = querySnapshoticonmess.size;
                        if (noCheckMessSum != 0){
                          var messcircle = document.getElementById('message-circle');
                          messcircle.innerHTML = noCheckMessSum;
                          messcircle.style.display = "block";
                        }
                      })().catch((error) => {
                          console.error("Error in script: ", error);
                      });
                      
                      const idChat = change.doc.id;
                      const data = change.doc.data(); // Cũng có thể dùng change.doc.id / change.doc.data().TN_REALTIME
                      var checkRealtime = justLoad;
                      if (data.TN_REALTIME != null){
                          checkRealtime = new Date(data.TN_REALTIME.seconds * 1000);
                      }

                      // Kiểm tra loại thay đổi
                      if (change.type === "added") { //Tương tự có thể dùng modified hoặc removed
                          //console.log("Document added:", data);
                          //console.log(userFormList);
                          //|-----------------------------------------------------
                          //|LẮNG NGHE SỰ KIỆN TRÊN KHUNG LIST FRIEND NOTI
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

                              if (checkRealtime < justLoad) {
                                  //|-----------------------------------------------------
                                  //|MỚI LOAD LẤY 5 NGƯỜI NHẮN GẦN NHẤT
                                  //|-----------------------------------------------------
                      
                                  //Checkuser chưa tồn tại trong mảng
                                  if (userFormList.indexOf(checkUser) === -1 && userFormList.length < 5) {
                                      userFormList.push(checkUser);
                                      AddListFriendHeader();
                                  }
                                  else if(userFormList.length >= 5){
                                    return; //forEach không cho break
                                  }
                              }
                              else{
                                  //Người vừa nhắn tin chưa tồn tại trong mảng
                                  if (userFormList.indexOf(checkUser) === -1) {
                                    if (userFormList.length >= 5) {
                                      var lastElement = userFormList[4];
                                      //console.log(lastElement);
                                      removeAByValue(lastElement);
                                      // Xoá phần tử cuối cùng
                                      userFormList.pop();
                                    }
                                    //thêm đầu mảng, push là thêm cuối mảng
                                    userFormList.unshift(checkUser);
                                  }
                                  //Có tồn tại trong mảng rồi
                                  else{
                                      removeAByValue(checkUser);
                                  }
                                  AddListFriendHeader();
                              }
                          function AddListFriendHeader(){
                            
                            (async () => {
                                //Lấy tên và ảnh người dùng
                                <?php if ($uSysAvatar) { ?>
                                  var uSysAvatar = <?php echo json_encode($uSysAvatar); ?>;
                                  uSysAvatar.forEach(function(ava) {
                                      if (ava.ND_MA == checkUser) {
                                          if(ava.ND_ANHDAIDIEN != null) ND_ANHDAIDIEN2 = ava.ND_ANHDAIDIEN;
                                          else ND_ANHDAIDIEN2 = '';
                                          ND_HOTEN2 = ava.ND_HOTEN;
                                          return;
                                      }
                                  });
                                <?php } ?>

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
                                  '<a data-value="'+checkUser+'" href="'+linkChat+'/'+checkUser+'" class="d-flex align-items-center gap-2 dropdown-item mt-1 mb-1" style="flex-wrap: wrap;">'+
                                  '  <img src="'+ (ND_ANHDAIDIEN2 != "" ? ND_ANHDAIDIEN2 : '<?php echo config('constants.default_avatar'); ?>') +'" alt="" width="35" height="35"'+
                                  '    class="rounded-circle">'+
                                  '  <span class="mb-0 fs-3 wrap-friend-text" style="max-width: 250px;">'+
                                  '  <b>'+ND_HOTEN2+'</b>' +
                                  ((noCheckMess == 0)? '' : '<span class="badge bg-primary rounded-pill float-end fs-1 ms-2">'+ noCheckMess +'</span>' ) + '<p data-chat-id-header-value="' + idChat + '">'+
                                  (checkUser == data.ND_NHAN_MA ? '<i>Bạn: </i>' : '') + (data.TN_NOIDUNG == "" ? '<i class="chat-detail">Đã gửi file đính kèm</i>' : '<span class="chat-detail">'+data.TN_NOIDUNG+'</span>') +
                                  '  </p>'+
                                  '  </span>'+
                                  '</a>';

                                var chatmess = document.getElementById('chat-message');
                                
                                if (checkRealtime >= justLoad) chatmess.insertAdjacentHTML('afterbegin', divData); //Thêm đầu_Load ban đầu
                                else chatmess.insertAdjacentHTML('beforeend', divData); //Thêm cuối

                            })().catch((error) => {
                                console.error("Error in script: ", error);
                            });
                          }
                      }
                      else if (change.type === "removed") { 
                          //|-----------------------------------------------------
                          //|XOÁ CHAT
                          //|-----------------------------------------------------
                          $('p[data-chat-id-header-value="' + idChat + '"]').find('.chat-detail').html('<i>Tin nhắn đã bị xoá</i>');
                      }
                  });
                  //console.log("Current data: ", messages.join(", "));
                }
              });

              //|-----------------------------------------------------
              //|HÀM XỬ LÝ KHÁC
              //|-----------------------------------------------------

              //XOÁ A CÓ DATA-VALUE YÊU CẦU
              function removeAByValue(value) {
                  var div = document.getElementById('chat-message');

                  var as = div.querySelectorAll('a[data-value]');

                  // Lặp qua từng li để tìm li có data-value trùng với giá trị cần xoá
                  as.forEach(function(a) {
                      var aValue = parseInt(a.getAttribute('data-value'));
                      if (aValue === value) {
                          a.parentNode.removeChild(a);
                      }
                  });
              }
              //|*****************************************************
              //|NHẮN TIN END
              //|***************************************************** 
              //|*****************************************************
              //|THÔNG BÁO START
              //|***************************************************** 
              var notiFormList = [];

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
                  var divData = `<p class="text-center p-2">Bạn chưa thông báo nào trước đây!</p>`;

                  var listnoti = document.getElementById('list-noti');
                  listnoti.insertAdjacentHTML('afterbegin', divData);

                  var listnotilink = document.getElementById('list-noti-link');
                  listnotilink.style.display = "none";
                }
                //TỒN TẠI THÔNG BÁO CŨ
                else{
                  querySnapshot.docChanges().forEach((change) => {

                      //|-----------------------------------------------------
                      //|ICON NOTI
                      //|-----------------------------------------------------
                      (async () => {
                        const qiconnoti = query(
                          collection(db, "THONG_BAO"), 
                          where('ND_NHAN_MA', '==', <?php echo $userLog->ND_MA; ?>),
                          where("TB_TRANGTHAI", "==", 0)
                        );
                        const querySnapshoticonnoti = await getDocs(qiconnoti);
                        //console.log(querySnapshotnocheck);
                        var noCheckNotiSum = querySnapshoticonnoti.size;
                        if (noCheckNotiSum != 0){
                          var noticircle = document.getElementById('noti-circle');
                          noticircle.innerHTML = noCheckNotiSum;
                          noticircle.style.display = "block";
                        }
                      })().catch((error) => {
                          console.error("Error in script: ", error);
                      });
                      
                      const iddata = change.doc.id;
                      const data = change.doc.data(); // Cũng có thể dùng change.doc.id / change.doc.data().TB_REALTIME
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
                          if (notiFormList.indexOf(iddata) === -1 && notiFormList.length < 5) {
                              notiFormList.push(iddata);
                              AddListNotiHeader();
                          }
                          else if(notiFormList.length >= 5){
                            return; //forEach không cho break
                          }
                        }
                        else{
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
                          AddListNotiHeader();
                          //console.log("New ",notiFormList);
                        }

                        function AddListNotiHeader(){
                          var divData = 
                              '<a data-value="'+iddata+'" data-href="'+data.TB_DUONGDAN+'" class="d-flex align-items-center gap-2 dropdown-item mt-1 mb-1 noti-href" style="flex-wrap: wrap;">' +
                              '  <img src="'+ (data.TB_ANHDINHKEM != null ? data.TB_ANHDINHKEM : '<?php echo config('constants.default_avatar'); ?>') +'" alt="" width="35" height="35"'+
                              '    class="rounded-circle">'+
                              '  <p class="mb-0 fs-3 wrap-noti-text">' +
                              data.TB_NOIDUNG +
                              '  </p>' +
                              (data.TB_TRANGTHAI==0 ? '<div class="notification bg-primary rounded-circle"></div>' : '') +
                              '</a>';

                          var listnoti = document.getElementById('list-noti');
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
                  var div = document.getElementById('list-noti');

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
        });
    </script>