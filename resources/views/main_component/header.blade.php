  <?php $userLog= Session::get('userLog'); ?>
    <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="fa fa-bars"></i>
              </a>
            </li>
            <form class="d-flex nav-search">
              <input class="form-control me-2" type="text" placeholder="Search">
              <button class="btn btn-outline-primary" type="button"><i class="fa fa-search"></i></button>
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
                    <form class="d-flex m-3">
                      <input class="form-control me-2" type="text" placeholder="Search">
                      <button class="btn btn-outline-primary" type="button"><i class="fa fa-search"></i></button>
                    </form>
                  </div>
                </div>
              </li>
              @if($userLog)
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop3" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fab fa-facebook-messenger"></i>
                  <div class="notification bg-primary rounded-circle"></div>
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
                  <div class="notification bg-primary rounded-circle"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item mt-1 mb-1"
                      style="flex-wrap: wrap;">
                      <img src="{{asset('public/images/profile/user-1.jpg')}}" alt="" width="35" height="35"
                        class="rounded-circle">
                      <p class="mb-0 fs-3" style="max-width: 85%; overflow-wrap: break-word; white-space: normal;">
                        Trần Kim Anh đã thích bài viết của bạn: Tìm giáo trình Anh văn căn bản chưa hết hạn.
                      </p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item mt-1 mb-1"
                      style="flex-wrap: wrap;">
                      <img src="{{asset('public/images/profile/user-1.jpg')}}" alt="" width="35" height="35"
                        class="rounded-circle">
                      <p class="mb-0 fs-3" style="max-width: 85%; overflow-wrap: break-word; white-space: normal;">
                        Trần Kim Anh đã thích bài viết của bạn: Tìm giáo trình Anh văn căn bản chưa hết hạn.
                      </p>
                    </a>
                    <hr>
                    <div class="text-center mb-1"><a href="javascript:void(0)" class="card-link">Xem thêm</a></div>
                  </div>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="public/images/users/<?php if($userLog->ND_ANHDAIDIEN) echo $userLog->ND_ANHDAIDIEN; else echo 'macdinh.png'?>" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="fa fa-user"></i>
                      <p class="mb-0 fs-3">Trang cá nhân</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="fas fa-user-cog"></i>
                      <p class="mb-0 fs-3">Cập nhật tài khoản</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
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
        import { getFirestore, doc, collection, getDocs, query, where, orderBy, limit, or } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";

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
            //|HIỆN CÁC THÔNG BÁO CHAT GẦN NHẤT
            //|-----------------------------------------------------
            <?php if($userLog) {?>//Không có dòng này navbar sẽ gây lỗi

              (async () => {
                const q = query(
                  collection(db, "messages"), 
                  or(where('ND_NHAN_MA', '==', <?php echo $userLog->ND_MA; ?>),
                    where('ND_GUI_MA', '==', <?php echo $userLog->ND_MA; ?>)
                  ),
                  orderBy("TN_REALTIME", "desc")
                );

                const querySnapshot = await getDocs(q);
                
                //KHÔNG TỒN TẠI TIN NHẮN CŨ
                if (querySnapshot.empty) {
                  //console.log('no data');
                  var divData = `<p class="text-center p-2">Bạn chưa có cuộc trò chuyện nào trước đây!</p>`;

                  var chatmess = document.getElementById('chat-message');
                  chatmess.insertAdjacentHTML('afterbegin', divData);

                  var chatmesslink = document.getElementById('chat-message-link');
                  chatmesslink.style.display = "none";
                }
                //TỒN TẠI TIN NHẮN CŨ
                else{
                  //console.log('have data');

                  var user =[];
                  querySnapshot.forEach((doc) => {
                      //doc.data() is never undefined for query doc snapshots
                      //console.log(doc.id, " => ", doc.data());

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
                      //|LẤY 5 NGƯỜI NHẮN GẦN NHẤT
                      //|-----------------------------------------------------
                      
                      var linkChat = <?php echo (json_encode(URL::to('/tin-nhan')).';'); ?>
                      //Checkuser chưa tồn tại trong mảng
                      if (user.indexOf(checkUser) === -1 && user.length <= 5) {
                          user.push(checkUser);
                          (async () => {
                            const q2 = query(
                              collection(db, "user_images"), 
                              where('ND_MA', '==', checkUser)
                            );

                            const querySnapshot2 = await getDocs(q2);
                          
                            querySnapshot2.forEach((doc) => {
                              ND_ANHDAIDIEN2 = doc.data().ND_ANHDAIDIEN;
                              ND_HOTEN2 = doc.data().ND_HOTEN;
                            });
                            //console.log(querySnapshot2);
                            //console.log(ND_ANHDAIDIEN2 +'-'+ ND_HOTEN2);
                            
                            var divData = 
                                '<a href="'+linkChat+'/'+checkUser+'" class="d-flex align-items-center gap-2 dropdown-item mt-1 mb-1" style="flex-wrap: wrap;">'+
                                '  <img src="public/images/users/'+ (ND_ANHDAIDIEN2 != "" ? ND_ANHDAIDIEN2 : 'macdinh.png') +'" alt="" width="35" height="35"'+
                                '    class="rounded-circle">'+
                                '  <span class="mb-0 fs-3" style="max-width: 85%; overflow-wrap: break-word; white-space: normal;">'+
                                '  <b>'+ND_HOTEN2+'</b><br>' + (checkUser == doc.data().ND_NHAN_MA ? '<i>Bạn: </i>' : '') + doc.data().TN_NOIDUNG+
                                '  </span>'+
                                '</a>';

                            var chatmess = document.getElementById('chat-message');
                            chatmess.insertAdjacentHTML('beforeend', divData);
                            
                          })().catch((error) => {
                              console.error("Error in script: ", error);
                          });
                      }
                      else if(user.length > 5){
                        return; //forEach không cho break
                      }
                      else{}
                  });
                }

              })().catch((error) => {
                  console.error("Error in script: ", error);
              });

            <?php } ?>
        });
    </script>