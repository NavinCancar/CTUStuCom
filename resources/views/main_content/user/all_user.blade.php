@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
            <h5 class="card-title fw-semibold">Quản lý tài khoản người dùng</h5>
            <a class="btn btn-primary" href="{{URL::to('/vai-tro/create')}}">
                <i class="fas fa-plus"></i> Thêm tài khoản người dùng
            </a>
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
                        <div class="row my-2">
                            <h2 class="card-title fw-semibold text-center fs-6">DANH SÁCH TÀI KHOẢN NGƯỜI DÙNG</h2>
                            <!--Header-->
                            <div class="row">
                                <div class="col-sm-9">
                                    
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                    <form class="d-flex input-group-sm w-100 mt-2 mb-3">
                                    <input class="form-control me-2" type="text" placeholder="Tìm kiếm">
                                    <button class="btn btn-outline-primary" type="button"><i class="fa fa-search"></i></button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <!--Content-->
                            <div class="col-12">
                            <div class="table-responsive">
                                <table class="table bg-white rounded shadow-sm  table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Mã người dùng</th>
                                            <th scope="col">Tên người dùng</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Ngày tham gia</th>
                                            <th scope="col">Vai trò</th>
                                            <th scope="col" width="70"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($all_user as $key => $item)
                                        <tr>
                                            <td>{{$item->ND_MA}}</td>
                                            <td>{{$item->ND_HOTEN}}</td>
                                            <td>
                                                <?php 
                                                    if($item->ND_TRANGTHAI ==0) echo '<span class="badge-sm bg-danger rounded-pill fs-2"><i>Vô hiệu hoá</i></span>'; 
                                                    else echo '<span class="badge-sm bg-success rounded-pill fs-2"><i>Hoạt động</i></span>'; 
                                                ?>
                                            </td>
                                            <td>{{date('d/m/Y', strtotime($item->ND_NGAYTHAMGIA))}}</td>
                                            <td>{{$item->VT_TEN}}</td>
                                            <td class="d-flex justify-content-between">
                                                <a href="{{URL::to('/tai-khoan/'.$item -> ND_MA)}}"><i class="fas fa-user text-primary"></i></a>
                                                <a href="{{URL::to('/tai-khoan/'.$item -> ND_MA.'/edit')}}"><i class="far fa-edit text-success"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page number start-->
            <div>
                <small class="text-muted inline m-t-sm m-b-sm">
                {{ "Hiển thị ". $all_user->firstItem() ."-". $all_user->lastItem() ." trong tổng số ". $all_user->total() ." dòng dữ liệu" }}
                </small>
            </div>
            
            <nav aria-label="Page navigation">
                <div class="text-center d-flex justify-content-center mt-3">
                    <ul class="pagination pagination-sm m-t-none m-b-none ">
                        {{-- Previous Page Link --}}
                        @if ($all_user->onFirstPage())
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-left"></i></a></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $all_user->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
                            </li>
                        @endif
                        {{-- Pagination Elements --}}
                        @for ($key=0; $key+1<=$all_user->lastPage(); $key++)
                                @if ($all_user->currentPage() === $key + 1)
                                    <li class="page-item active">
                                        <a class="page-link" href="{{ $all_user->url($key + 1) }}">{{ $key + 1 }}</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $all_user->url($key + 1) }}">{{ $key + 1 }}</a>
                                    </li>
                                @endif
                        @endfor
                    
                        {{-- Next Page Link --}}
                        @if ($all_user->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $all_user->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
                            </li>
                        @else
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-right"></i></a></li>
                        @endif
                    </ul>
                </div>
            </nav>
            <!-- Page number end-->
        </div>
    </div>
</div>
@endsection