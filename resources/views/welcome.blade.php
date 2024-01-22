<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CTU Student Community</title>
  <link rel="shortcut icon" type="image/png" href="{{asset('public/images/logos/logo.png')}}" />

  <!-- css -->
  <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('public/css/tokenfield.css')}}" />
  <link rel="stylesheet" href="{{asset('public/css/style.css')}}">

  <!-- js -->
  <script src="{{asset('public/jquery/dist/jquery.min.js')}}"></script>

  <!-- fontawesome -->
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
  <?php $userLog= Session::get('userLog'); ?>

  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    @include('main_component.left-sidebar')
    <!--  Sidebar End -->

    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      @include('main_component.header')
      <!--  Header End -->

      <!-- Content Start -->
      @yield('content')
    </div>
  </div>


  <!-- js -->
  <script src="{{asset('public/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('public/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('public/js/sidebarmenu.js')}}"></script>
  <script src="{{asset('public/js/app.min.js')}}"></script>
  <script src="{{asset('public/js/nav-search.js')}}"></script>
</body>

</html>