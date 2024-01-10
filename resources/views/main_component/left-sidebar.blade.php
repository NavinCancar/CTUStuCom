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