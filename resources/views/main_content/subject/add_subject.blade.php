@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Quản lý học phần</h5>
            </div>
            <hr>
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
            <div class="card">
                <div class="card-body p-4">
                    <div class="mb-3 mb-sm-0">
                        <div class="position-center">
                            <h2 class="card-title fw-semibold text-center fs-6">THÊM HỌC PHẦN</h2>
                            <form role="form" action="{{URL::to('/hoc-phan')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="form-label">Mã học phần</label>
                                    <input type="text" maxlength="5" name="HP_MA" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tên học phần</label>
                                    <input type="text" name="HP_TEN" class="form-control" required="">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Khoa/trường giảng dạy</label>
                                    <select name="KT_MA" class="form-select" required="">
                                        @foreach($college as $key => $c)
                                            <option value="{{$c->KT_MA}}">{{ $c->KT_TEN }}</option>
                                        @endforeach
                                    </select>
                                </div> 
                                
                                <button type="submit" class="btn btn-primary w-100">Thêm học phần</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection