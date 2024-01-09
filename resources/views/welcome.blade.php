<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CTU Student Community</title>
  <link rel="shortcut icon" type="image/png" href="{{('public/images/logos/logo.png')}}" />

  <!--css-->
  <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('public/css/tokenfield.css')}}" />
  <link rel="stylesheet" href="{{asset('public/css/style.css')}}">

  <!--fontawesome-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
    integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

  <!-- Scroll bar -->
  <style>
    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb {
      background: #bebebe;
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #a5a5a5;
    }
  </style>
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.php" class="text-nowrap logo-img">
            <img src="{{('public/images/logos/logo2.png')}}" width="230" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="fa fa-times fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <!-- Trang chủ -->
            <li class="nav-small-cap" data-bs-toggle="collapse" data-bs-target="#trangchu">
              <span class="hide-menu">Trang chủ</span>
            </li>
            <div id="trangchu" class="collapse show">
              <li class="sidebar-item">
                <a class="sidebar-link" href="./index.php" aria-expanded="false">
                  <span>
                    <i class="fas fa-home"></i>
                  </span>
                  <span class="hide-menu">Bảng tin</span>
                </a>
              </li>
            </div>

            <!-- Kiểm duyệt -->
            <li class="nav-small-cap" data-bs-toggle="collapse" data-bs-target="#kiemduyet">
              <span class="hide-menu">Kiểm duyệt</span>
            </li>
            <div id="kiemduyet" class="collapse">
              <li class="sidebar-item">
                <a class="sidebar-link" href="#" aria-expanded="false">
                  <span>
                    <i class="fa fa-comment-alt"></i>
                  </span>
                  <span class="hide-menu">Kiểm duyệt bài viết</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="#" aria-expanded="false">
                  <span>
                    <i class="fas fa-comments"></i>
                  </span>
                  <span class="hide-menu">Kiểm duyệt bình luận</span>
                </a>
              </li>
            </div>


            <!-- Quản trị -->
            <li class="nav-small-cap" data-bs-toggle="collapse" data-bs-target="#quantri">
              <span class="hide-menu">Quản trị</span>
            </li>
            <div id="quantri" class="collapse">
              <li class="sidebar-item">
                <a class="sidebar-link" href="./truong-khoa.php" aria-expanded="false">
                  <span>
                    <i class="fas fa-school"></i>
                  </span>
                  <span class="hide-menu">Quản lý trường\khoa</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="#" aria-expanded="false">
                  <span>
                    <i class="fas fa-folder"></i>
                  </span>
                  <span class="hide-menu">Quản lý học phần</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="#" aria-expanded="false">
                  <span>
                    <i class="fa fa-users"></i>
                  </span>
                  <span class="hide-menu">Quản lý người dùng</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="#" aria-expanded="false">
                  <span>
                    <i class="fas fa-user-tag"></i>
                  </span>
                  <span class="hide-menu">Quản lý vai trò</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="./thong-ke.php" aria-expanded="false">
                  <span>
                    <i class="fas fa-chart-bar"></i>
                  </span>
                  <span class="hide-menu">Thống kê</span>
                </a>
              </li>
            </div>
            
            <!-- Khám phá -->
            <li class="nav-small-cap" data-bs-toggle="collapse" data-bs-target="#khampha">
              <span class="hide-menu">Khám phá</span>
            </li>
            <div id="khampha" class="collapse show">
              <li class="sidebar-item">
                <a class="sidebar-link" href="./hashtag.php" aria-expanded="false">
                  <span>
                    <i class="fa fa-hashtag"></i>
                  </span>
                  <span class="hide-menu">Hashtag</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="./khoa-truong.php" aria-expanded="false">
                  <span>
                    <i class="fa fa-school"></i>
                  </span>
                  <span class="hide-menu">Khoa/Trường</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="./users.php" aria-expanded="false">
                  <span>
                    <i class="fa fa-user-tag"></i>
                  </span>
                  <span class="hide-menu">Người dùng</span>
                </a>
              </li>
            </div>

            <!-- Tài khoản -->
            <li class="nav-small-cap" data-bs-toggle="collapse" data-bs-target="#taikhoan">
              <span class="hide-menu">Tài khoản</span>
            </li>
            <div id="taikhoan" class="collapse show">
              <li class="sidebar-item">
                <a class="sidebar-link" href="./follow.php" aria-expanded="false">
                  <span>
                    <i class="fas fa-layer-group"></i>
                  </span>
                  <span class="hide-menu">Kho tài liệu</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="./follow.php" aria-expanded="false">
                  <span>
                    <i class="fa fa-portrait"></i>
                  </span>
                  <span class="hide-menu">Theo dõi</span>
                </a>
              </li>
            </div>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
    </aside>
    <!--  Sidebar End -->

    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
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
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop3" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fab fa-facebook-messenger"></i>
                  <div class="notification bg-primary rounded-circle"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop3">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item mt-1 mb-1"
                      style="flex-wrap: wrap;">
                      <img src="{{('public/images/profile/user-1.jpg')}}" alt="" width="35" height="35"
                        class="rounded-circle">
                      <span class="mb-0 fs-3" style="max-width: 85%; overflow-wrap: break-word; white-space: normal;">
                        <b>Nguyễn Minh Ngọc</b><br>
                        Chào bạn nhe!!!
                      </span>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item mt-1 mb-1"
                      style="flex-wrap: wrap;">
                      <img src="{{('public/images/profile/user-1.jpg')}}" alt="" width="35" height="35"
                        class="rounded-circle">
                      <span class="mb-0 fs-3" style="max-width: 85%; overflow-wrap: break-word; white-space: normal;">
                        <b>Nguyễn Minh Ngọc</b><br>
                        Chào bạn nhe!!!
                      </span>
                    </a>
                    <hr>
                    <div class="text-center mb-1"><a href="./mess.php" class="card-link">Xem thêm</a></div>
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
                      <img src="{{('public/images/profile/user-1.jpg')}}" alt="" width="35" height="35"
                        class="rounded-circle">
                      <p class="mb-0 fs-3" style="max-width: 85%; overflow-wrap: break-word; white-space: normal;">
                        Trần Kim Anh đã thích bài viết của bạn: Tìm giáo trình Anh văn căn bản chưa hết hạn.
                      </p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item mt-1 mb-1"
                      style="flex-wrap: wrap;">
                      <img src="{{('public/images/profile/user-1.jpg')}}" alt="" width="35" height="35"
                        class="rounded-circle">
                      <p class="mb-0 fs-3" style="max-width: 85%; overflow-wrap: break-word; white-space: normal;">
                        Trần Kim Anh đã thích bài viết của bạn: Tìm giáo trình Anh văn căn bản chưa hết hạn.
                      </p>
                    </a>
                    <hr>
                    <div class="text-center mb-1"><a href="./noti.php" class="card-link">Xem thêm</a></div>
                  </div>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="{{('public/images/profile/user-1.jpg')}}" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                  <div class="message-body">
                    <a href="./account.php" class="d-flex align-items-center gap-2 dropdown-item">
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
                    <a href="{{URL::to('/dang-nhap')}}" class="btn btn-outline-danger mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->

      <!-- Content Start -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-8">
            <div class="mb-3 mb-sm-0 d-flex">
              <h5 class="card-title fw-semibold">Bảng tin</h5>
            </div>
            <hr>
            <div class="d-block">
              <button class="btn btn-primary me-2 mb-3" data-bs-toggle="collapse" data-bs-target="#thembaiviet"><i
                  class="fas fa-plus"></i> Thêm bài viết</button>
              <button class="btn btn-outline-primary me-2 mb-3" data-bs-toggle="collapse" data-bs-target="#loc"><i
                  class="fa fa-filter"></i> Lọc bài viết</button>
            </div>

            <!-- Thêm bài viết Start -->
            <div id="thembaiviet" class="collapse">
              <div class="card">
                <div class="card-body p-4">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Thêm bài viết mới</h5>
                    <form id="form">
                      <div class="mb-3 mt-3">
                        <label>Tiêu đề:</label>
                        <input type="text" class="form-control mb-3" placeholder="Nhập tiêu đề" id="title">
                        <label>Nội dung:</label>
                        <textarea class="form-control mb-3" rows="5" id="comment" name="text"
                          placeholder="Nhập nội dung" id="desc"></textarea>
                        <div class="mb-3">
                          <label for="hashtag_input" class="form-label">Hashtag đính kèm (tối đa 5 hashtag):</label>
                          <div class="output"></div>
                          <input class="basic" placeholder="e.g. HTML, JavaScript, CSS" />
                        </div>
                        <div class="mb-3">
                          <label for="formFileMultiple" class="form-label">Các file đính kèm (nếu có):</label>
                          <input class="form-control" type="file" id="formFileMultiple" multiple>
                        </div>
                        <label for="exampleDataList" class="form-label">Học phần liên quan (nếu có):</label>
                        <input class="form-control" list="datalistOptions" id="exampleDataList"
                          placeholder="Tìm kiếm học phần">
                        <datalist id="datalistOptions">
                          <option value="CT204">
                          <option value="ML101">
                          <option value="CT212">
                        </datalist>
                      </div>
                      <button type="submit" class="btn btn-primary float-sm-end">Đăng bài</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Thêm bài viết End -->
            <!-- Lọc Start -->
            <div id="loc" class="collapse">
              <div class="card">
                <div class="card-body p-4">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Lọc bài viết</h5>
                    <form id="form">
                      <div class="mb-3 mt-3">
                        <div class="row mb-3">
                          <div class="col-lg-4 col-md-4 col-sm-12 ">
                            <label for="exampleDataList" class="form-label">Xếp theo:</label>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                            <input class="form-check-input" type="checkbox" value="" name="group_loai" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                              Nổi bật
                            </label>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                            <input class="form-check-input" type="checkbox" value="" name="group_loai">
                            <label class="form-check-label" for="flexCheckDefault">
                              Mới nhất
                            </label>
                          </div>
                        </div>
                        
                        <div class="row mb-3">
                          <div class="col-lg-4 col-md-4 col-sm-6 ">
                            <label for="exampleDataList" class="form-label">Đính kèm:</label>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                            <input class="form-check-input" type="checkbox" value="" name="group_loai" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                              Ảnh
                            </label>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                            <input class="form-check-input" type="checkbox" value="" name="group_loai" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                              Pdf
                            </label>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                            <input class="form-check-input" type="checkbox" value="" name="group_loai" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                              Word
                            </label>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                            <input class="form-check-input" type="checkbox" value="" name="group_loai" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                              Khác
                            </label>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-6 form-check">
                            <input class="form-check-input" type="checkbox" value="" name="group_loai">
                            <label class="form-check-label" for="flexCheckDefault">
                              Không kèm file
                            </label>
                          </div>
                        </div>

                        <label for="exampleDataList" class="form-label">Hashtag đi kèm:</label>
                        <div class="mb-3">
                          <div class="output2"></div>
                          <input class="basic2" placeholder="e.g. HTML, JavaScript, CSS" />
                        </div>

                        <label for="exampleDataList" class="form-label">Học phần liên quan:</label>
                        <input class="form-control" list="datalistOptions" id="exampleDataList"
                          placeholder="Tìm kiếm học phần">
                        <datalist id="datalistOptions">
                          <option value="CT204">
                          <option value="ML101">
                          <option value="CT212">
                        </datalist>
                      </div>
                      <button type="submit" class="btn btn-primary float-sm-end">Lọc</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Lọc End -->

            <!--  Bài 1  -->
            <div class="card">
              <div class="card-body p-4">
                <div class="mb-3 mb-sm-0">
                  <p>
                    <a href="#" class="text-body">
                      <img src="{{('public/images/profile/user-1.jpg')}}" alt="" width="20" height="20" class="rounded-circle">
                      <b>Lý Thị Lan</b> 
                    </a>
                    đã đăng vào 15:20 ngày 29/12/2023
                  </p>
                  <a href="./bai-viet.php" class="text-dark">
                    <h5 class="card-title fw-semibold">Ứng dụng mới</h5>
                    <p>Xin chào mọi người!
                      Hiện tại nhóm của mình có phát triển ứng dụng nhằm hỗ trợ sinh viên #CTU trong quá trình lập thời
                      khóa biểu để đăng ký học phần.
                      Nên rất mong nhận được sự phản hồi của mn để phát triển ứng dụng hơn nữa ạ...
                      <a href="./bai-viet.php" class="card-link">Xem thêm</a>
                    </p>
                  </a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1">#ung_dung</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1">#lay_y_kien</span></a>
                </div>
              </div>
            </div>
            <!--  Bài 1  -->
            <div class="card">
              <div class="card-body p-4">
                <div class="mb-3 mb-sm-0">
                  <p>
                    <a href="#" class="text-body">
                      <img src="{{('public/images/profile/user-1.jpg')}}" alt="" width="20" height="20" class="rounded-circle">
                      <b>Lý Thị Lan</b> 
                    </a>
                    đã đăng vào 15:20 ngày 29/12/2023
                  </p>
                  <a href="#" class="text-dark">
                    <h5 class="card-title fw-semibold">Ứng dụng mới</h5>
                    <p>Xin chào mọi người!
                      Hiện tại nhóm của mình có phát triển ứng dụng nhằm hỗ trợ sinh viên #CTU trong quá trình lập thời
                      khóa biểu để đăng ký học phần.
                      Nên rất mong nhận được sự phản hồi của mn để phát triển ứng dụng hơn nữa ạ...
                      <a href="#" class="card-link">Xem thêm</a>
                    </p>
                  </a>
                  <p><a href="#"><span class="badge bg-indigo rounded-3 fw-semibold me-1"><i class="fa fa-folder"></i> CT101 Kỹ năng
                      đại học</span></a></p>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1">#ung_dung</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1">#lay_y_kien</span></a>
                </div>
              </div>
            </div>
            <!--  Bài 1  -->
            <div class="card">
              <div class="card-body p-4">
                <div class="mb-3 mb-sm-0">
                  <p>
                    <a href="#" class="text-body">
                      <img src="{{('public/images/profile/user-1.jpg')}}" alt="" width="20" height="20" class="rounded-circle">
                      <b>Lý Thị Lan</b> 
                    </a>
                    đã đăng vào 15:20 ngày 29/12/2023
                  </p>
                  <a href="#" class="text-dark">
                    <h5 class="card-title fw-semibold">Ứng dụng mới</h5>
                    <p>Xin chào mọi người!
                      Hiện tại nhóm của mình có phát triển ứng dụng nhằm hỗ trợ sinh viên #CTU trong quá trình lập thời
                      khóa biểu để đăng ký học phần.
                      Nên rất mong nhận được sự phản hồi của mn để phát triển ứng dụng hơn nữa ạ...
                      <a href="#" class="card-link">Xem thêm</a>
                    </p>
                  </a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1">#ung_dung</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1">#lay_y_kien</span></a>
                </div>
              </div>
            </div>
            <!--  Bài 1  -->
            <div class="card">
              <div class="card-body p-4">
                <div class="mb-3 mb-sm-0">
                  <p>
                    <a href="#" class="text-body">
                      <img src="{{('public/images/profile/user-1.jpg')}}" alt="" width="20" height="20" class="rounded-circle">
                      <b>Lý Thị Lan</b> 
                    </a>
                    đã đăng vào 15:20 ngày 29/12/2023
                  </p>
                  <a href="#" class="text-dark">
                    <h5 class="card-title fw-semibold">Ứng dụng mới</h5>
                    <p>Xin chào mọi người!
                      Hiện tại nhóm của mình có phát triển ứng dụng nhằm hỗ trợ sinh viên #CTU trong quá trình lập thời
                      khóa biểu để đăng ký học phần.
                      Nên rất mong nhận được sự phản hồi của mn để phát triển ứng dụng hơn nữa ạ...
                      <a href="#" class="card-link">Xem thêm</a>
                    </p>
                  </a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1">#ung_dung</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1">#lay_y_kien</span></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Nổi bật</h5>
            </div>
            <hr>
            <div class="card">
              <div class="card-body p-4">
                <div class="mb-3 mb-sm-0">
                  <h5 class="card-title fw-semibold">Bài viết</h5>
                  <a href="javascript:void(0)" class="fs-4">
                    Bán các giáo trình anh văn căn bản giá siêu rẻ
                  </a><br>
                  <a href="javascript:void(0)" class="fs-4">
                    Chuẩn bị gì khi học quân sự?
                  </a><br>
                  <a href="javascript:void(0)" class="fs-4">
                    Sơ đồ khu II
                  </a><br>
                  <a href="javascript:void(0)" class="fs-4">
                    Chào mừng tân sinh viên
                  </a><br>
                  <a href="javascript:void(0)" class="fs-4">
                    Lịch nghỉ lễ
                  </a><br>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-body p-4">
                <div class="mb-3 mb-sm-0">
                  <h5 class="card-title fw-semibold">Hashtag</h5>
                  <a href="./tag.php"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#ung_dung</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#lay_y_kien</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
                  <a href="#"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#ung_dung</span></a>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-body p-4">
                <div class="mb-3 mb-sm-0">
                  <h5 class="card-title fw-semibold">Học phần</h5>
                  <a href="hoc-phan.php"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-folder"></i> CT101 Kỹ
                    năng đại học</span></a><br>
                  <a href="#"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-folder"></i> CT101 Nền
                    tảng công nghệ thông tin</span></a><br>
                  <a href="#"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-folder"></i> CT101 Triết
                    Mác Lênin</span></a><br>
                  <a href="#"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-folder"></i> CT101 Lịch
                    sử Đảng</span></a><br>
                  <a href="#"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1"><i class="fa fa-folder"></i> CT101 Chủ
                    nghĩa xã hội khoa học</span></a><br>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- js -->
  <script src="{{asset('public/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('public/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('public/js/sidebarmenu.js')}}"></script>
  <script src="{{asset('public/js/app.min.js')}}"></script>
  <script src="{{asset('public/js/nav-search.js')}}"></script>

  <!--Xử lý hashtag Start-->
  <script src="{{asset('public/js/tokenfield.web.js')}}"></script>
  <script>
    //Thêm bài
    const myItems = [
      { name: 'JavaScript' },
      { name: 'HTML' },
      { name: 'CSS' },
      { name: 'Angular' },
      { name: 'React' },
      { name: 'can_tho' },
    ];
    const instance = new Tokenfield({
      el: document.querySelector('.basic'),
      items: myItems,

      form: true, // Listens to reset event
      mode: 'tokenfield', // tokenfield or list.
      addItemOnBlur: false,
      addItemsOnPaste: false,
      keepItemsOrder: true,
      setItems: [], // array of pre-selected items
      newItems: true,
      multiple: true,
      maxItems: 5,
      minLength: 1,
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
      minChars: 0,
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

    /*
    const instance = new Tokenfield({
          el: document.querySelector('.basic'),
          remote: {
            type: 'GET', // GET or POST
            url: null, // Full url.
            queryParam: 'q', // query parameter
            delay: 300, // delay in ms
            timestampParam: 't',
            params: {},
            headers: {}
          },
    });*/
    // Sự kiện thay đổi trạng thái của tokenfield, hiển thị cả item lẫn
    instance.on('change', () => {
      const selectedItems = instance.getItems();
      const outputDiv = document.querySelector('.output');
      outputDiv.innerHTML = `Mục đã chọn: ${selectedItems.map(item => item.name).join(', ')}`;
    });
  </script>

<script>
  //Lọc bài
    const myItems2 = [
      { name: 'k49' },
      { name: 'tsv' },
      { name: 'pass_tai_lieu' },
      { name: 'mail' },
      { name: 'cit' },
      { name: 'can_tho' },
    ];
    const instance2 = new Tokenfield({
      el: document.querySelector('.basic2'),
      items: myItems2,

      form: true, // Listens to reset event
      mode: 'tokenfield', // tokenfield or list.
      addItemOnBlur: false,
      addItemsOnPaste: false,
      keepItemsOrder: true,
      setItems: [], // array of pre-selected items
      newItems: false,
      multiple: true,
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

    /*
    const instance = new Tokenfield({
          el: document.querySelector('.basic'),
          remote: {
            type: 'GET', // GET or POST
            url: null, // Full url.
            queryParam: 'q', // query parameter
            delay: 300, // delay in ms
            timestampParam: 't',
            params: {},
            headers: {}
          },
    });*/
    // Sự kiện thay đổi trạng thái của tokenfield, hiển thị cả item lẫn
    instance2.on('change', () => {
      const selectedItems2 = instance2.getItems();
      const outputDiv2 = document.querySelector('.output2');
      outputDiv2.innerHTML = `Mục đã chọn: ${selectedItems2.map(item => item.name).join(', ')}`;
    });
  </script>
  <!--Xử lý hashtag End-->
</body>

</html>