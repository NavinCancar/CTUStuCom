@extends('welcome')
@section('content')
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

@endsection