@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
                <h5 class="card-title fw-semibold">Danh sách khoa trường</h5>
                <?php if($userLog && $userLog->KT_MA!=null) { ?>
                    <a class="btn btn-primary" href="{{URL::to('/khoa-truong/'.$userLog->KT_MA)}}">
                        Truy cập nhanh khoa trường của bạn
                    </a>
                <?php } ?>
            </div>
            <hr>
            <div class="row">
            @foreach($college as $key => $c)
                <div class=" col-lg-6">
                    <a href="{{URL::to('/khoa-truong/'.$c->KT_MA)}}">
                        <div class="card noti-item text-muted cursor-pointer">
                            <div class="card-body p-4">
                                <div class="mb-3 mb-sm-0">
                                    <div class="pt-1 fs-4">
                                        <b><i class="fa fa-school"></i> {{$c->KT_TEN}}</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endsection