@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div>
            <h5 class="card-title fw-semibold pb-2">Đổi mật khẩu</h5>
          </div>
          <?php
            $alert = Session::get('alert');
            if ($alert && is_array($alert)) {
                echo '<div class="text-notice text-notice-' . $alert['type'] . ' alert alert-' . $alert['type'] . '">';
                echo $alert['content'];
                echo '<i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = \'none\'"></i>';
                echo '</div>';
                Session::put('alert', null);
            }
            Session::put('alert',null);
          ?>
          <hr>
          <div class="card">
            <div class="card-body p-4">
                <div class="position-center input-form">
                    <form role="form" action="{{URL::to('/kiem-tra-mat-khau')}}" method="post" id="form">
                        {{ csrf_field() }}
                        <div class="form-group mb-3">
                            <label class="form-label">Mật khẩu cũ: <span class="text-danger">(*)</span>:</label>
                            <input type="password" name="ND_MATKHAUCU" placeholder="Nhập mật khẩu cũ..." class="form-control" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Mật khẩu mới: <span class="text-danger">(*)</span>:</label>
                            <input type="password" name="ND_MATKHAUMOI1" placeholder="Nhập mật khẩu mới..." class="form-control" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Xác nhận mật khẩu mới: <span class="text-danger">(*)</span>:</label>
                            <input type="password" name="ND_MATKHAUMOI2" placeholder="Nhập lại mật khẩu mới..." class="form-control" required="">
                        </div>

                        <button type="submit" style="width: 100%" class="btn btn-primary" id="submit-form">Đổi mật khẩu</button>
                        <div class="text-center" style="display: none;" id="spinner">
                            <div class="spinner-border text-primary"></div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection