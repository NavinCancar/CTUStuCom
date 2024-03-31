@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>

<!-- Content Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
                <h5 class="card-title fw-semibold">Tổng hợp tài khoản vi phạm đang hoạt động</h5> 
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
                            <h2 class="card-title fw-semibold text-center fs-6">DANH SÁCH TÀI KHOẢN NGƯỜI DÙNG VI PHẠM ĐANG HOẠT ĐỘNG</h2>
                            <!--Header-->
                            <div class="row">
                                <div class="col-sm-9">
                                    
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                    <form class="d-flex input-group-sm w-100 mt-2 mb-3" role="form" action="{{URL::to('/tai-khoan-vi-pham')}}" method="GET">
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
                                            <th scope="col">Mã</th>
                                            <th scope="col">Tên người dùng</th>
                                            <th scope="col">Vai trò</th>
                                            <th scope="col"><i class="fas fa-flag"></i> Bài viết</th>
                                            <th scope="col"><i class="fas fa-flag"></i> Bình luận</th>
                                            <th scope="col"><i class="fas fa-flag"></i> Người dùng</th>
                                            <th scope="col" width="100"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($all_user as $key => $item)
                                        @if($item->BC_total!=0)
                                        <tr data-user-id-value="{{$item->ND_MA}}">
                                            <td class="check-highlight">{{$item->ND_MA}}</td>
                                            <td class="check-highlight">{{$item->ND_HOTEN}}</td>
                                            <td>{{$item->VT_TEN}}</td>
                                            <td>{{$item->BV_BC}}</td>
                                            <td>{{$item->BL_BC}}</td>
                                            <td>{{$item->ND_BC}}</td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{URL::to('/tai-khoan/'.$item -> ND_MA)}}"><i class="fas fa-user text-primary"></i></a>
                                                    <a data-bs-toggle="modal" id="role-modal" data-bs-target="#role" data-user-id-value="{{$item -> ND_MA}}" data-user-name-value="{{$item -> ND_HOTEN}}" data-role-id-value="{{$item -> VT_MA}}"><i class="far fa-edit text-success"></i></a>
                                                    <form role="form" action="{{URL::to('/tai-khoan/'.$item -> ND_MA)}}" method="post" class="delete-form">
                                                        @method('DELETE')
                                                        {{csrf_field()}}
                                                        <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?')" class="delete-button" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
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
            
            <?php
                $add = '';
                if(request()->query('trang-thai')){
                    $add .= '&trang-thai='.request()->query('trang-thai');
                }
                if(request()->query('vai-tro')){
                    $add .= '&vai-tro='.request()->query('vai-tro');
                }
                if(request()->query('tu-khoa')){
                    $add .= '&tu-khoa='.request()->query('tu-khoa');
                }
            ?>
            <nav aria-label="Page navigation">
                <div class="text-center d-flex justify-content-center mt-3">
                    <ul class="pagination pagination-sm m-t-none m-b-none ">
                        {{-- Previous Page Link --}}
                        @if ($all_user->onFirstPage())
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-left"></i></a></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $all_user->previousPageUrl().$add }}"><i class="fas fa-angle-left"></i></a>
                            </li>
                        @endif
                        {{-- Pagination Elements --}}
                        @for ($key=0; $key+1<=$all_user->lastPage(); $key++)
                                @if ($all_user->currentPage() === $key + 1)
                                    <li class="page-item active">
                                        <a class="page-link" href="{{ $all_user->url($key + 1).$add }}">{{ $key + 1 }}</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $all_user->url($key + 1).$add }}">{{ $key + 1 }}</a>
                                    </li>
                                @endif
                        @endfor
                    
                        {{-- Next Page Link --}}
                        @if ($all_user->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $all_user->nextPageUrl().$add }}"><i class="fas fa-angle-right"></i></a>
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

<div class="modal" id="role">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <b class="fs-4">Cập nhật vai trò người dùng: <i id="userName" class="text-danger fs-5"></i> _ Mã người dùng: <i id="userId" class="text-danger fs-5"></i></b>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body px-4 scroll-chat" style="height: auto; max-height: 320px;">
                <form role="form" action="{{URL::to('/vai-tro-nguoi-dung')}}" method="POST" class="modal-title row" style="width: 95%">
                    {{ csrf_field() }}
                    <span class="d-flex justify-content-between align-items-center col-sm-9 mb-2">
                        <b style="width: 12rem;">Vai trò người dùng:</b>
                        <select name="VT_MA" class="form-select w-75">
                            @foreach($all_vaitro as $key => $r)
                                <option value="{{$r->VT_MA}}">{{ $r->VT_TEN }}</option>
                            @endforeach
                        </select>
                        <input name="ND_MA" hidden/>
                    </span>
                    <button type="submit" id="update_BL_TRANGTHAI" class="btn btn-primary col-sm-3 mb-2">Cập nhật</button>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer"></div>
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

        //|-----------------------------------------------------
        //|MODAL CẬP NHẬT VAI TRÒ
        //|-----------------------------------------------------
        $(document).on('click', '#role-modal', function(e) {
            e.preventDefault();
            var element = $(this);
            var VT_MA = $(this).data('role-id-value');
            $('select[name="VT_MA"] option[value="' + VT_MA + '"]').prop('selected', true);

            var ND_MA = $(this).data('user-id-value');
            $('#userId').text(ND_MA);
            $('input[name="ND_MA"]').val(ND_MA);

            var ND_HOTEN = $(this).data('user-name-value');
            $('#userName').text(ND_HOTEN);
        });

        //|-----------------------------------------------------
        //|FOCUS NGƯỜI DÙNG NẾU CÓ
        //|-----------------------------------------------------
        <?php 
        $ND_MA_Focus = Session::get('ND_MA_Focus');
        if($ND_MA_Focus) { 
        ?>
            var userIdValue = <?php echo $ND_MA_Focus ?>;

            var trToFocus = document.querySelector(`tr[data-user-id-value="${userIdValue}"]`);
            //console.log("focus:", trToFocus)
            if (trToFocus) {
                trToFocus.style.background = 'linear-gradient(to right, #ffffff00, #ffff0038, #ffff0038, #ffff0038, #ffffff00)';
                trToFocus.tabIndex = 0;
                trToFocus.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center', // Hoặc 'center', 'end', 'nearest'
                });
            }
            else{
                //|-----------------------------------------------------
                //|KIỂM TRA NẾU CÓ CHUYỂN PAGE
                //|-----------------------------------------------------
                const currentURL = window.location.href;
                if (currentURL.includes('?nguoi-dung=')) {
                    async function processURLs(urls) {
                        for (let i = 0; i < urls.length; i++) {
                            var newURL = urls[i];
                            const response = await fetch(newURL); //để tải nội dung của newURL
                            const htmlString = await response.text(); //chuyển response qua text
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(htmlString, 'text/html'); //chuyển text qua html
                            var trToFocus = doc.querySelector(`tr[data-user-id-value="${userIdValue}"]`);
                            if (trToFocus) {
                                trToFocus.style.background = 'linear-gradient(to right, #ffffff00, #ffff0038, #ffff0038, #ffff0038, #ffffff00)';
                                trToFocus.tabIndex = 0;
                                trToFocus.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center', // Hoặc 'center', 'end', 'nearest'
                                });
                                window.location.href = newURL;
                                break;
                            }
                        }
                    }

                    // Sử dụng hàm
                    const urls = [];
                    for (let i = 2; i <= <?php echo $all_user->lastPage(); ?>; i++) {
                        urls.push(currentURL + `&page=${i}`);
                    }

                    processURLs(urls);
                }
            }
        <?php 
            Session::put('ND_MA_Focus',null);
        } 
        ?>
    })
</script>
@endsection