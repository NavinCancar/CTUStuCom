@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
    <!-- Content Start -->
    @if(!$checkBlockND && !$checkBlockND2 && !$checkBlockND3)
        @foreach($account_info as $key => $info)
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
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
                    <div class="row px-3 pt-4 pb-4" style="background: linear-gradient(30deg, #84ccf4, #539BFF);">
                        <div class="col-lg-2 d-flex justify-content-center align-items-center">
                            <img src="<?php if($info->ND_ANHDAIDIEN) echo $info->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'?>" alt="" width="100px" height="100px"
                                class="rounded-circle border border-light border-5">
                        </div>
                        <div class="col-lg-10 d-flex justify-content-center align-items-center">
                            <div class="card m-3">
                                <div class="card-body p-4">
                                    <h4 class="fw-bold">{{$info->ND_HOTEN}}
                                    @if($info->VT_MA != 3)
                                        <span class="fs-3 badge-sm bg-warning rounded-pill"><i>{{$info->VT_TEN}}</i></span>
                                    @endif
                                    </h4>
                                    @if($info->KT_MA != null)
                                        <a href="{{URL::to('/khoa-truong/'.$info->KT_MA)}}" class="fw-bold"><i class="fas fa-school"></i> 
                                        <?php $c = $college->where('KT_MA', $info->KT_MA)->first(); echo $c->KT_TEN; ?>
                                    @endif
                                    <div class="text-center">
                                        <div class="row p-3 mb-3 mt-3">
                                            <a href="{{URL::to('/danh-sach-nguoi-theo-doi/'.$info->ND_MA)}}" class="col-lg-3 col-md-3 col-sm-6 text-muted ml-3">
                                                <b class="fs-6"><?php if($nguoi_theo_doi) echo $nguoi_theo_doi; else echo '0'; ?></b><br> Người theo dõi
                                            </a>
                                            <a href="{{URL::to('/danh-sach-theo-doi/'.$info->ND_MA)}}" class="col-lg-3 col-md-3 col-sm-6 text-muted">
                                                <b class="fs-6"><?php if($dang_theo_doi) echo $dang_theo_doi; else echo '0'; ?></b><br> Đang theo dõi
                                            </a>
                                            <a href="{{URL::to('/danh-sach-bai-dang')}}" class="col-lg-3 col-md-3 col-sm-6 text-muted">
                                                <b class="fs-6"><?php if($bai_viet_count) echo $bai_viet_count; else echo '0'; ?></b><br> Bài đăng
                                            </a>
                                            <a href="javascript:void(0)" class="col-lg-3 col-md-3 col-sm-6 text-muted ml-3">
                                                <b class="fs-6">111</b><br> Điểm cống hiến
                                            </a>
                                        </div>
                                        @if($info->ND_MOTA != null)
                                        <div class="text-center">
                                            <i class="fas fa-quote-left"></i> 
                                            &emsp;<i>{{$info->ND_MOTA}}</i>&emsp;
                                            <i class="fas fa-quote-right"></i>
                                        </div>
                                        @endif
                                    
                                        <div class="mt-3 mb-sm-0">
                                            <span>Đóng góp nhiều cho các nội dung:</span>
                                            <a href="javascript:void(0)"><span class="badge bg-info rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
                                            <a href="javascript:void(0)"><span class="badge bg-info rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
                                            <a href="javascript:void(0)"><span class="badge bg-info rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
                                            <a href="javascript:void(0)"><span class="badge bg-info rounded-3 fw-semibold me-1 mb-1">#ung_dung</span></a>
                                            <a href="javascript:void(0)"><span class="badge bg-info rounded-3 fw-semibold me-1 mb-1">#lay_y_kien</span></a>
                                            <a href="javascript:void(0)"><span class="badge bg-info rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
                                            <a href="javascript:void(0)"><span class="badge bg-info rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
                                            <a href="javascript:void(0)"><span class="badge bg-info rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 mb-3 d-flex justify-content-end">
                        @if ($userLog)
                            @if($userLog && $info->ND_MA == $userLog->ND_MA)
                                <a href="{{URL::to('/danh-sach-bai-dang')}}"><button class="btn btn-primary ms-2" type="button"><i class="fa fa-comment-alt"></i> Bài viết của bạn</button></a>
                                <a href="javascript:void(0)"><button class="btn btn-success ms-2" type="button"><i class="fas fa-chart-pie"></i> Nhìn lại quá trình</button></a>
                            @else
                                <a href="{{URL::to('/tin-nhan/'.$info->ND_MA)}}"><button class="btn btn-primary" type="button"><i class="fab fa-facebook-messenger"></i> Nhắn tin</button></a>
                                <?php 
                                    $check_follow = $nguoi_theo_doi_no_get->where('ND_THEODOI_MA', $userLog->ND_MA)->exists(); 
                                    if(!$check_follow){ ?>
                                    <button class="btn btn-success ms-2 follow" data-user-id-value="<?php echo $info->ND_MA;?>" type="button"><i class="fa fa-portrait"></i> Theo dõi</button>
                                <?php
                                    } else{ ?>
                                    <button class="btn btn-danger ms-2 unfollow" data-user-id-value="<?php echo $info->ND_MA;?>" type="button"><i class="fa fa-portrait"></i> Huỷ theo dõi</button>
                                <?php
                                    }
                                    $check_block = $nguoi_bi_chan_no_get->where('ND_CHAN_MA', $userLog->ND_MA)->exists(); 
                                    if(!$check_block){ ?>
                                    <button class="btn btn-muted ms-2 block" data-user-id-value="<?php echo $info->ND_MA;?>" type="button"><i class="fas fa-ban"></i> Chặn</button>
                                <?php
                                    } else{ ?>
                                    <button class="btn btn-muted ms-2 unblock" data-user-id-value="<?php echo $info->ND_MA;?>" type="button"><i class="fas fa-ban"></i> Bỏ chặn</button>
                                <?php
                                    } 
                                ?> 
                            @endif
                        @endif
                    </div>
                
                </div>

                <div class="col-lg-4">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Bài viết nổi bật</h5>
                    </div>
                    <hr>
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="mb-3 mb-sm-0">
                                @if($bai_viet_count)
                                    @foreach($bai_viet as $key => $bv)
                                        <a href="{{URL::to('/bai-dang/'.$bv->BV_MA)}}" class="fs-4">
                                            {{$bv->BV_TIEUDE}}
                                        </a><br>
                                    @endforeach
                                @else
                                    <p class="text-center">Chưa có bài viết nào!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Bình luận nổi bật</h5>
                    </div>
                    <hr>
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="mb-3 mb-sm-0">
                            @if($binh_luan_count)
                                @foreach($binh_luan as $key => $bl)
                                <div class="d-flex flex-row pb-3 pt-1" data-comment-id-value="{{$bl->BL_MA}}">
                                    <div>
                                    <a class="text-body">
                                        <img src="<?php if($info->ND_ANHDAIDIEN) echo $info->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'?>" alt="" 
                                            width="40" height="40" class="rounded-circle me-2">
                                    </a>
                                    </div>
                                    <div class="pt-1" style="width:100%">
                                        <a class="text-muted"><p class="fw-bold mb-0">{{$info->ND_HOTEN}}</p></a>
                                        <a href="{{URL::to('/bai-dang/'.$bl->BV_MA.'/?binh-luan='.$bl->BL_MA)}}" class="text-muted">{{$bl->BL_NOIDUNG}}</a>

                                        <div class="row">
                                            <div class="col-sm-6 d-flex mt-2 justify-content-start">
                                                <span>{{date('H:i', strtotime($bl->BL_THOIGIANTAO))}} ngày {{date('d/m/Y', strtotime($bl->BL_THOIGIANTAO))}}</span>
                                            </div>
                                            <div class="col-sm-6 d-flex mt-2 justify-content-end">
                                                <a class="ms-3 cursor-pointer <?php 
                                                    if($userLog){
                                                        $check_bl_thich0 = $binh_luan_thich_no_get->clone()
                                                        ->where('binh_luan.BL_MA', $bl->BL_MA)->where('binhluan_thich.ND_MA', $userLog->ND_MA)->exists();
                                                        if($check_bl_thich0) echo 'text-danger unlike-comment'; else echo 'text-muted like-comment';
                                                    } else echo "text-muted"?> " data-comment-id-value="{{$bl->BL_MA}}">
                                                <i class="fas fa-heart"></i> Thích:
                                                <b>
                                                    <?php 
                                                    $count_bl_thich0 = $binh_luan_thich_no_get->clone()->where('binh_luan.BL_MA', $bl->BL_MA)->count();
                                                    if($count_bl_thich0) echo $count_bl_thich0; else echo 0;
                                                    ?>
                                                </b>
                                                </a>
                                                @if($bl->BL_TRALOI_MA == null)
                                                <a class="ms-3 text-muted reply-comment-btn" data-comment-id-value="{{$bl->BL_MA}}">
                                                <i class="fas fa-reply"></i> Trả lời: 
                                                <b>
                                                    <?php 
                                                    $count_bl_traloi = $binh_luan_no_get->clone()->where('binh_luan.BL_TRALOI_MA', $bl->BL_MA)->count();
                                                    //dd($count_bl_traloi);
                                                    if($count_bl_traloi) echo $count_bl_traloi; else echo 0;
                                                    ?>
                                                </b>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p class="text-center">Chưa có bình luận nào!</p>
                            @endif
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center text-muted">
                    <h4>Người dùng này đã bị ẩn đến bạn!</h4>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(!$checkBlockND && !$checkBlockND2 && !$checkBlockND3)
  <script>
    $(document).ready(function() {

        //|*****************************************************
        //|LIKE BÌNH LUẬN START //
        //|*****************************************************
        <?php if($userLog) { ?>
        $(document).on('click', '.like-comment', function() {
            // Truy cập giá trị của tham số từ thuộc tính dữ liệu
            var $element = $(this);
            var number = $element.find('b').text();
            var BL_MA = $(this).data('comment-id-value');
            //var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{URL::to('/thich-binh-luan/')}}' +'/'+ BL_MA,
                type: 'GET',
                success: function(response) {
                $element.removeClass('text-muted like-comment');
                $element.addClass('text-danger unlike-comment');

                number = parseInt(number) + 1;
                $element.find('b').text(number);
                //console.log(number);

                //Notification start
                $.ajax({
                    url: '{{URL::to('/thong-bao-thich-binh-luan/')}}' +'/'+ BL_MA,
                    type: 'GET',
                    success: function(response2) {
                        //console.log('ok');
                    },
                    error: function(error2) {
                        console.log(error);
                    }
                });
                //Notification end
                },
                error: function(error) {
                console.log(error);
                }
            });
                
        });
        $(document).on('click', '.unlike-comment', function() {
            // Truy cập giá trị của tham số từ thuộc tính dữ liệu
            var $element = $(this);
            var number = $element.find('b').text();
            var BL_MA = $(this).data('comment-id-value');
            //var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{URL::to('/huy-thich-binh-luan/')}}' +'/'+ BL_MA,
                type: 'GET',
                success: function(response) {
                $element.removeClass('text-danger unlike-comment');
                $element.addClass('text-muted like-comment');

                number = parseInt(number) - 1;
                $element.find('b').text(number);
                //console.log(number);
                },
                error: function(error) {
                console.log(error);
                }
            });
                
        });
        <?php } ?>
        //|*****************************************************
        //|LIKE BÌNH LUẬN END
        //|*****************************************************
        //|*****************************************************
        //|THEO DÕI START //
        //|*****************************************************
        <?php if($userLog) { ?>
        $(document).on('click', '.follow', function() {
            // Truy cập giá trị của tham số từ thuộc tính dữ liệu
            var $element = $(this);
            var ND_MA = $(this).data('user-id-value');
            //var _token = $('meta[name="csrf-token"]').attr('content');

            $element.removeClass('btn-danger');
            $element.removeClass('btn-success');

            $element.html('<div class="spinner-border text-primary spinner-border-sm"></div>');

            $.ajax({
                url: '{{URL::to('/theo-doi/')}}' +'/'+ ND_MA,
                type: 'GET',
                success: function(response) {
                $element.removeClass('follow');
                $element.addClass('unfollow btn-danger');

                $element.html('<i class="fa fa-portrait"></i> Huỷ theo dõi');
                
                //Notification start
                $.ajax({
                    url: '{{URL::to('/thong-bao-theo-doi/')}}' +'/'+ ND_MA,
                    type: 'GET',
                    success: function(response2) {
                        //console.log('ok');
                    },
                    error: function(error2) {
                        console.log(error);
                    }
                });
                //Notification end
                },
                error: function(error) {
                console.log(error);
                }
            });
                
        });
        $(document).on('click', '.unfollow', function() {
            // Truy cập giá trị của tham số từ thuộc tính dữ liệu
            var $element = $(this);
            var ND_MA = $(this).data('user-id-value');
            //var _token = $('meta[name="csrf-token"]').attr('content');

            $element.removeClass('btn-danger');
            $element.removeClass('btn-success');

            $element.html('<div class="spinner-border text-primary spinner-border-sm"></div>');

            $.ajax({
                url: '{{URL::to('/huy-theo-doi/')}}' +'/'+ ND_MA,
                type: 'GET',
                success: function(response) {
                $element.removeClass('unfollow');
                $element.addClass('follow btn-success');

                $element.html('<i class="fa fa-portrait"></i> Theo dõi');
                
                },
                error: function(error) {
                console.log(error);
                }
            });
        });
        <?php } ?>
        //|*****************************************************
        //|THEO DÕI END
        //|*****************************************************      
        //|*****************************************************
        //|CHẶN START
        //|*****************************************************
        <?php if($userLog) { ?>
        $(document).on('click', '.block', function() {
            // Truy cập giá trị của tham số từ thuộc tính dữ liệu
            var $element = $(this);
            var ND_MA = $(this).data('user-id-value');
            //var _token = $('meta[name="csrf-token"]').attr('content');

            $element.removeClass('btn-muted');

            $element.html('<div class="spinner-border text-primary spinner-border-sm"></div>');

            $.ajax({
                url: '{{URL::to('/chan/')}}' +'/'+ ND_MA,
                type: 'GET',
                success: function(response) {
                    window.location.href = '{{URL::to('/trang-chu')}}';
                },
                error: function(error) {
                console.log(error);
                }
            });
                
        });
        $(document).on('click', '.unblock', function() {
            // Truy cập giá trị của tham số từ thuộc tính dữ liệu
            var $element = $(this);
            var ND_MA = $(this).data('user-id-value');
            //var _token = $('meta[name="csrf-token"]').attr('content');

            $element.removeClass('btn-muted');

            $element.html('<div class="spinner-border text-primary spinner-border-sm"></div>');

            $.ajax({
                url: '{{URL::to('/bo-chan/')}}' +'/'+ ND_MA,
                type: 'GET',
                success: function(response) {
                $element.removeClass('unblock');
                $element.addClass('block btn-muted');

                $element.html('<i class="fas fa-ban"></i> Chặn');
                
                },
                error: function(error) {
                console.log(error);
                }
            });
        });
        <?php } ?>
        //|*****************************************************
        //|CHẶN END
        //|*****************************************************    
    });
  </script>
  @endif
@endsection