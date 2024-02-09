@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Quản lý khoa/trường</h5>
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
                            <h2 class="card-title fw-semibold text-center fs-6">CẬP NHẬT KHOA/TRƯỜNG</h2>
                            @foreach($all_college as $key => $item)
                            <form role="form" action="{{URL::to('/khoa-truong/'.$item->KT_MA)}}" method="POST">
                                @method('PUT')
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="form-label">Tên khoa/trường</label>
                                    <input type="text" name="KT_TEN" class="form-control" value="{{$item->KT_TEN}}" required="">
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">Cập nhật khoa/trường</button>
                            </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection