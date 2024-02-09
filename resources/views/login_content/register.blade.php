@extends('login_layout')
@section('content')
    <form action="{{URL::to('/kiem-tra-dang-ky')}}" method="post">
        {{ csrf_field() }}
        <div class="mb-3">
            <label for="exampleInputText1" class="form-label">Họ tên:</label>
            <input type="text" class="form-control" id="exampleInputText1" required="" name="ND_HOTEN" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email:</label>
            <input type="email" class="form-control" id="exampleInputEmail1" required="" pattern="[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}" name="ND_EMAIL" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Mật khẩu:</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="ND_MATKHAU" required="">
        </div>
        <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-2 rounded-2">Đăng ký</button>
    </form>
    <a href="{{URL::to('/dang-nhap')}}" class="btn btn-outline-primary w-100 py-8 fs-4 mb-2 rounded-2">Đăng nhập</a>
@endsection