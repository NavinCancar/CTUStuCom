@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
            <h5 class="card-title fw-semibold">Quản lý học phần</h5>
            <a class="btn btn-primary" href="{{URL::to('/hoc-phan/create')}}">
                <i class="fas fa-plus"></i> Thêm học phần
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
                            <h2 class="card-title fw-semibold text-center fs-6">DANH SÁCH HỌC PHẦN</h2>
                            <!--Header-->
                            <div class="row">
                                <div class="col-sm-9">
                                    
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                    <form class="d-flex input-group-sm w-100 mt-2 mb-3" role="form" action="{{URL::to('/hoc-phan')}}" method="GET">
                                        <input class="form-control me-2" type="text" name="tu-khoa" placeholder="Tìm kiếm">
                                        <button class="btn btn-outline-primary" type="submit"><i class="fa fa-search"></i></button>
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
                                            <th scope="col">Mã học phần</th>
                                            <th scope="col">Tên học phần</th>
                                            <th scope="col">Khoa/trường giảng dạy</th>
                                            <th scope="col" width="100"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($all_subject as $key => $item)
                                        <tr>
                                            <td class="check-highlight">{{$item->HP_MA}}</td>
                                            <td class="check-highlight">{{$item->HP_TEN}}</td>
                                            <td class="check-highlight">{{$item->KT_TEN}}</td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{URL::to('/hoc-phan/'.$item -> HP_MA)}}" previewlistener="true"><i class="fas fa-info-circle text-primary"></i></a>
                                                    <a href="{{URL::to('/hoc-phan/'.$item -> HP_MA.'/edit')}}"><i class="far fa-edit text-success"></i></a>
                                                    <form role="form" action="{{URL::to('/hoc-phan/'.$item -> HP_MA)}}" method="POST" class="delete-form">
                                                        @method('DELETE')
                                                        {{csrf_field()}}
                                                        <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?')" class="delete-button" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></button>
                                                    </form>
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
                {{ "Hiển thị ". $all_subject->firstItem() ."-". $all_subject->lastItem() ." trong tổng số ". $all_subject->total() ." dòng dữ liệu" }}
                </small>
            </div>
            
            <?php
                $add = '';
                if(request()->query('tu-khoa')){
                    $add .= '&tu-khoa='.request()->query('tu-khoa');
                }
            ?>
            <nav aria-label="Page navigation">
                <div class="text-center d-flex justify-content-center mt-3">
                    <ul class="pagination pagination-sm m-t-none m-b-none ">
                        {{-- Previous Page Link --}}
                        @if ($all_subject->onFirstPage())
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-left"></i></a></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $all_subject->previousPageUrl().$add }}"><i class="fas fa-angle-left"></i></a>
                            </li>
                        @endif
                        {{-- Pagination Elements --}}
                        @for ($key=0; $key+1<=$all_subject->lastPage(); $key++)
                                @if ($all_subject->currentPage() === $key + 1)
                                    <li class="page-item active">
                                        <a class="page-link" href="{{ $all_subject->url($key + 1).$add }}">{{ $key + 1 }}</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $all_subject->url($key + 1).$add }}">{{ $key + 1 }}</a>
                                    </li>
                                @endif
                        @endfor
                    
                        {{-- Next Page Link --}}
                        @if ($all_subject->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $all_subject->nextPageUrl().$add }}"><i class="fas fa-angle-right"></i></a>
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
<script>
    $(document).ready(function() {
        //|-----------------------------------------------------
        //|HIGHLIGHT
        //|-----------------------------------------------------
        highLight();
        function highLight(){
            <?php 
                $keywords = request()->query('tu-khoa'); 
                if($keywords) { 
            ?>
                $('.check-highlight').each(function() {
                <?php $words = explode(' ', $keywords); ?>
                    var txtToHighlight = $(this).text();
                    <?php foreach ($words as $word) { ?>
                
                        var txtToHighlight = txtToHighlight.replace(new RegExp("<?php echo $word ?>", "gi"), '<span class="mark">$&</span>');
                        
                    <?php } ?>
                $(this).html(txtToHighlight);
                });
            <?php } ?>
        }
    })
</script>
@endsection