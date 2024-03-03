@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
    <!-- Content Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Danh sách chặn</h5>
                </div>
                <hr>
                <div class="row">
                    @foreach($account_info as $key => $info)    
                        @if($userLog && $userLog->ND_MA !=$info->ND_MA)
                        <div class=" col-lg-6">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="mb-3 mb-sm-0">
                                        <div class="justify-content-between">
                                            <div class="d-flex flex-row">
                                                <div>
                                                    <img src="<?php if($info->ND_ANHDAIDIEN) echo $info->ND_ANHDAIDIEN; else echo config('constants.default_avatar');?>"
                                                        alt="" width="50" height="50" class="rounded-circle me-2">
                                                </div>
                                                <div class="pt-1">
                                                    <b>{{$info->ND_HOTEN}}</b>
                                                    @if($info->VT_MA != 3)
                                                        <span class="badge-sm bg-warning rounded-pill"><i>{{$info->VT_TEN}}</i></span>
                                                    @endif
                                                    <p>
                                                        @if($info->KT_MA != null)
                                                            <?php $c = $college->where('KT_MA', $info->KT_MA)->first(); echo $c->KT_TEN; ?>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <button class="btn btn-muted ms-2 w-100 unblock" data-user-id-value="<?php echo $info->ND_MA;?>" type="button"><i class="fas fa-ban"></i> Bỏ chặn</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    

  <!-- MAIN START-->
  <script>
    $(document).ready(function() {
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
                    window.location.href = '{{URL::to('/tai-khoan/')}}'+'/'+ND_MA;
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
  <!--MIN END-->
@endsection