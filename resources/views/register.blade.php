<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CTU Student Community</title>
  <link rel="shortcut icon" type="image/png" href="{{('public/images/logos/logo.png')}}" />

  <!--css-->
  <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}" />
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
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="{{URL::to('/')}}" class="text-nowrap logo-img text-center d-block py-1 w-100">
                  <img src="{{('public/images/logos/logo2.png')}}" width="300px" alt="">
                </a>
                <form>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Họ tên:</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Mật khẩu:</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-2 rounded-2">Đăng ký</button>
                </form>
                <a href="{{URL::to('/dang-nhap')}}" class="btn btn-outline-primary w-100 py-8 fs-4 mb-2 rounded-2">Đăng nhập</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--js-->
  <script src="{{asset('public/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('public/js/bootstrap.bundle.min.js')}}"></script>
</body>

</html>