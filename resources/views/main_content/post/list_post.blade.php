@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
            <h5 class="card-title fw-semibold">Danh sách bài viết của bạn</h5>
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
                            <h2 class="card-title fw-semibold text-center fs-6">DANH SÁCH BÀI VIẾT CỦA BẠN</h2>
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
                                            <th scope="col">Mã</th>
                                            <th scope="col" width="500">Tiêu đề bài viết</th>
                                            <th scope="col" width="150">Trạng thái</th>
                                            <th scope="col">Ngày tạo</th>
                                            <th scope="col" width="70"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bai_viet as $key => $bv)
                                        <tr data-post-id-value="{{$bv->BV_MA}}">
                                            <td>{{$bv->BV_MA}}</td>
                                            <td><span class="limited-lines">{{$bv->BV_TIEUDE}}</span></td>
                                            <td class="trangthai">
                                                <?php 
                                                    if($bv->BV_TRANGTHAI == 'Chưa duyệt') echo '<span class="badge-sm bg-danger rounded-pill fs-2"><i>Chưa duyệt</i></span>'; 
                                                    else if($bv->BV_TRANGTHAI == 'Đã duyệt') echo '<span class="badge-sm bg-success rounded-pill fs-2"><i>Đã duyệt</i></span>';
                                                    else if($bv->BV_TRANGTHAI == 'Đã xoá') echo '<span class="badge-sm bg-light rounded-pill fs-2"><i>Đã xoá</i></span>'; 
                                                    else echo '<span class="badge-sm bg-warning rounded-pill fs-2"><i>'.trim(strstr($bv->BV_TRANGTHAI, ':', true)).'</i></span>'; 
                                                ?>
                                            </td>
                                            <td>{{date('d/m/Y', strtotime($bv->BV_THOIGIANTAO))}}</td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{URL::to('/bai-dang/'.$bv -> BV_MA)}}" previewlistener="true"><i class="fas fa-info-circle text-primary"></i></a>
                                                </div>
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
                {{ "Hiển thị ". $bai_viet->firstItem() ."-". $bai_viet->lastItem() ." trong tổng số ". $bai_viet->total() ." dòng dữ liệu" }}
                </small>
            </div>
            
            <nav aria-label="Page navigation">
                <div class="text-center d-flex justify-content-center mt-3">
                    <ul class="pagination pagination-sm m-t-none m-b-none ">
                        {{-- Previous Page Link --}}
                        @if ($bai_viet->onFirstPage())
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-left"></i></a></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $bai_viet->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
                            </li>
                        @endif
                        {{-- Pagination Elements --}}
                        @for ($key=0; $key+1<=$bai_viet->lastPage(); $key++)
                                @if ($bai_viet->currentPage() === $key + 1)
                                    <li class="page-item active">
                                        <a class="page-link" href="{{ $bai_viet->url($key + 1) }}">{{ $key + 1 }}</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $bai_viet->url($key + 1) }}">{{ $key + 1 }}</a>
                                    </li>
                                @endif
                        @endfor
                    
                        {{-- Next Page Link --}}
                        @if ($bai_viet->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $bai_viet->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
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