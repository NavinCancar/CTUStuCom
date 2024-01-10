@extends('login_layout')
@section('content')
                <form action="{{URL::to('/kiem-tra-dang-nhap')}}" method="post">
                  {{ csrf_field() }}
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="ND_EMAIL" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Mật khẩu:</label>
                    <input type="password" class="form-control" name="ND_MATKHAU" id="exampleInputPassword1">
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <a class="text-primary fw-bold" href="javascript:void(0)">Quên mật khẩu?</a>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-2 rounded-2">Đăng nhập</button>
                </form>
                <a href="{{URL::to('/dang-ky')}}" class="btn btn-outline-primary w-100 py-8 fs-4 mb-2 rounded-2">Đăng ký</a>
@endsection