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
                    <div class="text-center mb-1"><a href="{{URL::to('/tin-nhan')}}" class="card-link">Xem thêm</a></div>
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