@extends('welcome')
@section('content')
<?php 
    $userLog= Session::get('userLog');  
?>
    <style>
        /* CSS cho đường gạch ngăn cách */
        .col-sm-6 {
            border-right: 1px solid #ccc; 
        }
        .col-sm-6:last-child {
            border-right: none;
        }
    </style>
    <!-- Content Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Thống kê (<?php echo (date('d/m/Y', strtotime($TGBDau)). ' - '.date('d/m/Y', strtotime($TGKThuc))) ?>)</h5>
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
                            <h2 class="card-title fw-semibold text-center fs-6">THỐNG KÊ THEO THỜI GIAN</h2>
                            <div class="panel-body">
                                <form role="form" action="{{URL::to('/thong-ke')}}" method="GET">
                                    <div class="form-group row pt-4 align-items-center">
                                        <div class="col-sm-2 align-items-center pb-2"><label>Theo thời gian:</label></div>
                                        <div class="col-sm-4 d-flex d-block align-items-center justify-content-between pb-2">
                                            <span> Từ: </span>
                                            <input type="date" name="TGBDau" required="" value="<?php echo date('Y-m-d', strtotime($TGBDau)) ?>" class="form-control w-75">
                                        </div>
                                        <div class="col-sm-4 d-flex d-block align-items-center justify-content-between pb-2">
                                            <span> Đến: </span>
                                            <input type="date" name="TGKThuc" required="" value="<?php echo date('Y-m-d', strtotime($TGKThuc)) ?>" class="form-control w-75">
                                        </div>
                                        <div class="col-sm-2 pb-2"><button type="submit" class="btn btn-primary w-100">Tính toán</button></div>
                                    </div>
                                </form> 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-block">
                    <?php 
                        $maxDate = (new DateTime($now))->format('Y-m-d H');


                        $today = (new DateTime($now))->format('Y-m-d'); 
                        echo '<a class="btn btn-primary btn-sm me-2 mb-3" href="'.URL::to('/thong-ke').'?TGBDau='.$today.'&TGKThuc='.$today.'">Hôm nay</a>';

                        $yesterday = (new DateTime($today))->modify('-1 day')->format('Y-m-d');
                        echo '<a class="btn btn-primary btn-sm me-2 mb-3" href="'.URL::to('/thong-ke').'?TGBDau='.$yesterday.'&TGKThuc='.$yesterday.'">Hôm qua</a>';

                        $last7days = (new DateTime($today))->modify('-7 day')->format('Y-m-d');
                        echo '<a class="btn btn-primary btn-sm me-2 mb-3" href="'.URL::to('/thong-ke').'?TGBDau='.$last7days.'&TGKThuc='.$today.'">7 ngày qua</a>';

                        //$lastmonth = (new DateTime($today))->modify('-1 month')->format('Y-m-d');
                        $thismonthfirstday = (new DateTime($today))->modify('first day of this month')->format('Y-m-d');
                        $lastmonthfirstday = (new DateTime($today))->modify('first day of last month')->format('Y-m-d');
                        $lastmonthlastday = (new DateTime($today))->modify('last day of last month')->format('Y-m-d');
                        echo '<a class="btn btn-primary btn-sm me-2 mb-3" href="'.URL::to('/thong-ke').'?TGBDau='.$thismonthfirstday.'&TGKThuc='.$today.'">Tháng này</a>';
                        echo '<a class="btn btn-primary btn-sm me-2 mb-3" href="'.URL::to('/thong-ke').'?TGBDau='.$lastmonthfirstday.'&TGKThuc='.$lastmonthlastday.'">Tháng trước</a>';

                        /*$last3month = (new DateTime($today))->modify('-3 month')->format('Y-m-d');
                        $last3monthfirstday = (new DateTime($today))->modify('-3 month')->modify('first day of this month')->format('Y-m-d');
                        echo '<a class="btn btn-primary btn-sm me-2 mb-3" href="'.URL::to('/thong-ke').'?TGBDau='.$last3monthfirstday.'&TGKThuc='.$lastmonthlastday.'">3 tháng trước</a>';*/
                    ?>
                </div>

                <div class="card">
                    <div class="card-body p-4">
                        <div class="mb-3 mb-sm-0">
                            <h2 class="card-title fw-semibold text-center fs-6">THỐNG KÊ TƯƠNG TÁC</h2>
                            <div class="mt-4 mb-4 w-100 mx-auto">
                                <canvas id="chartActivity"></canvas>
                                <div class="row h-100 mt-5">
                                    <div class="col-sm-6">
                                        <h2 class="card-title fw-semibold text-center fs-5" style="color: rgb(0, 175, 239)">BÀI VIẾT</h2>
                                        <div class="row h-100">
                                            <div class="col-sm-6">
                                                <h2 class="card-title fw-semibold text-center fs-4 pb-3">NỔI BẬT</h2>
                                                @if ($bai_viet_hot->count() > 0)
                                                    @foreach($bai_viet_hot as $key => $bvh)
                                                    <a href="{{URL::to('/bai-dang/'.$bvh->BV_MA)}}" class="fs-4 d-block mb-1">
                                                        <i class="fas fa-angle-double-right"></i> &ensp; {{ Str::limit($bvh->BV_TIEUDE, 50) }}
                                                        <br>
                                                        <div class="text-muted" style="text-align: end; font-size: 0.82rem !important;">
                                                            <i class="fas fa-eye pe-1"></i> <b>{{ isset($bvh->BV_LUOTXEM) ? $bvh->BV_LUOTXEM : 0 }}</b> <span class="px-2">|</span> 
                                                            <i class="fas fa-heart pe-1"></i> <b>{{ isset($bvh->SL_THICH) ? $bvh->SL_THICH : 0 }}</b> <span class="px-2">|</span>  
                                                            <i class="fas fa-reply pe-1"></i> <b>{{ isset($bvh->SL_BINHLUAN) ? $bvh->SL_BINHLUAN : 0 }}</b>
                                                        </div>
                                                    </a><hr>
                                                    @endforeach
                                                @else
                                                    <div class="text-center mt-4 mb-2">Rất tiếc! Không có nội dung nổi bật để hiển thị :(</div>
                                                @endif
                                            </div>
                                            <div class="col-sm-6">
                                                <h2 class="card-title fw-semibold text-center fs-4 pb-3">BỊ BÁO CÁO NỔI BẬT</h2>
                                                @if ($bai_viet_bc->count() > 0)
                                                    @foreach($bai_viet_bc as $key => $bvbc)
                                                    <a href="{{URL::to('/bai-dang/'.$bvbc->BV_MA)}}" class="fs-4 d-block mb-1">
                                                        <i class="fas fa-angle-double-right"></i> &ensp; {{ Str::limit($bvbc->BV_TIEUDE, 50) }}
                                                        <br>
                                                        <div class="text-muted" style="text-align: end; font-size: 0.82rem !important;">
                                                            <i class="fas fa-eye pe-1"></i> <b>{{ isset($bvbc->BV_LUOTXEM) ? $bvbc->BV_LUOTXEM : 0 }}</b> <span class="px-2">|</span> 
                                                            <i class="fas fa-flag pe-1"></i> <b>{{ isset($bvbc->BV_BC) ? $bvbc->BV_BC : 0 }}</b>
                                                        </div>
                                                    </a><hr>
                                                    @endforeach
                                                @else
                                                    <div class="text-center mt-4 mb-2">Rất tiếc! Không có nội dung nổi bật để hiển thị :(</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <h2 class="card-title fw-semibold text-center fs-5" style="color: rgb(239, 64, 0)">BÌNH LUẬN</h2>
                                        <div class="row h-100">
                                            <div class="col-sm-6">
                                                <h2 class="card-title fw-semibold text-center fs-4 pb-3">NỔI BẬT</h2>
                                                @if ($binh_luan_hot->count() > 0)
                                                    @foreach($binh_luan_hot as $key => $blh)
                                                    <a href="{{URL::to('/bai-dang/'.$blh->BV_MA.'?binh-luan='.$blh->BL_MA)}}" class="fs-4 d-block mb-1">
                                                        <i class="fas fa-angle-double-right"></i> &ensp; {{ Str::limit($blh->BL_NOIDUNG, 50) }}
                                                        <br>
                                                        <div class="text-muted" style="text-align: end; font-size: 0.82rem !important;">
                                                            <i class="fas fa-heart pe-1"></i> <b>{{ isset($blh->SL_THICH) ? $blh->SL_THICH : 0 }}</b> <span class="px-2">|</span>  
                                                            <i class="fas fa-reply pe-1"></i> <b>{{ isset($blh->SL_BINHLUAN) ? $blh->SL_BINHLUAN : 0 }}</b>
                                                        </div>
                                                    </a><hr>
                                                    @endforeach
                                                @else
                                                    <div class="text-center mt-4 mb-2">Rất tiếc! Không có nội dung nổi bật để hiển thị :(</div>
                                                @endif
                                            </div>
                                            <div class="col-sm-6">
                                                <h2 class="card-title fw-semibold text-center fs-4 pb-3">BỊ BÁO CÁO NỔI BẬT</h2>
                                                @if ($binh_luan_bc->count() > 0)
                                                    @foreach($binh_luan_bc as $key => $blbc)
                                                    <a href="{{URL::to('/bai-dang/'.$blbc->BV_MA.'?binh-luan='.$blbc->BL_MA)}}" class="fs-4 d-block mb-1">
                                                        <i class="fas fa-angle-double-right"></i> &ensp; {{ Str::limit($blbc->BL_NOIDUNG, 50) }}
                                                        <br>
                                                        <div class="text-muted" style="text-align: end; font-size: 0.82rem !important;">
                                                            <i class="fas fa-flag pe-1"></i> <b>{{ isset($blbc->BL_BC) ? $blbc->BL_BC : 0 }}</b>
                                                        </div>
                                                    </a><hr>
                                                    @endforeach
                                                @else
                                                    <div class="text-center mt-4 mb-2">Rất tiếc! Không có nội dung nổi bật để hiển thị :(</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body p-4">
                        <div class="mb-3 mb-sm-0">
                            <h2 class="card-title fw-semibold text-center fs-6">THỐNG KÊ MỨC ĐỘ TƯƠNG TÁC VỚI HASHTAG</h2>
                            <div class="mt-4 mb-4 row">
                                <div class="col-sm-5 pt-4">
                                    <canvas id="chartHashtag" class="mx-auto"></canvas>
                                </div>
                                <div class="col-sm-7">
                                    <div class="table-responsive">
                                        <table class="table bg-white rounded shadow-sm table-bordered table-hover">
                                            <thead>
                                                <!--<tr>
                                                    <th scope="col">Hashtag</th>
                                                    <th scope="col">Bài viết</th>
                                                    <th scope="col">Thích bài viết</th>
                                                    <th scope="col">Bình luận</th>
                                                    <th scope="col">Thích bình luận</th>
                                                    <th scope="col">Người tương tác</th>
                                                    <th scope="col">Người theo dõi</th>
                                                    <th scope="col">Mức độ tương tác</th>
                                                </tr>-->
                                                <tr class="text-center">
                                                    <th scope="col" rowspan="2">Hashtag</th>
                                                    <th scope="col" colspan="2">Bài viết</th>
                                                    <th scope="col" colspan="2">Bình luận</th>
                                                    <th scope="col" colspan="2">Người dùng</th>
                                                    <th scope="col" rowspan="2">Mức độ tương tác</th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Số lượng</th>
                                                    <th scope="col">Lượt thích</th>
                                                    <th scope="col">Số lượng</th>
                                                    <th scope="col">Lượt thích</th>
                                                    <th scope="col">Tương tác</th>
                                                    <th scope="col">Theo dõi</th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <?php $i=0; $sum_total_hashtag = array_sum(array_column($total_hashtag, 'Total_hashtag'));?>
                                                @foreach($total_hashtag as $item)
                                                    @if($i < 10)
                                                    <?php
                                                        $bv_hashtag_thich = $bv_hashtag->clone()
                                                        ->join('baiviet_thich', 'baiviet_thich.BV_MA', '=', 'bai_viet.BV_MA')
                                                        ->where('H_HASHTAG', $item["hashtag"])->count();

                                                        $bl_hashtag_thich = $bl_hashtag->clone()
                                                        ->join('binhluan_thich', 'binhluan_thich.BL_MA', '=', 'binh_luan.BL_MA')
                                                        ->where('H_HASHTAG', $item["hashtag"])->count();


                                                        $bv_hashtag_nd = $bv_hashtag->clone()
                                                        ->where('H_HASHTAG', $item["hashtag"])
                                                        ->pluck('bai_viet.ND_MA')->toArray();

                                                        $bl_hashtag_nd = $bl_hashtag->clone()
                                                        ->where('H_HASHTAG', $item["hashtag"])
                                                        ->pluck('binh_luan.ND_MA')->toArray();

                                                        $nd_hashtag = array_unique(array_merge($bl_hashtag_nd, $bv_hashtag_nd));

                                                        /*echo '<pre>';
                                                        print_r ($nd_hashtag);
                                                        echo '</pre>';*/
                                                    ?>
                                                    <tr>
                                                        <td>{{$item["hashtag"]}}</td>
                                                        <td>{{$item["sl_baiviet"]}}</td>
                                                        <td>{{$bv_hashtag_thich}}</td>
                                                        <td>{{$item["sl_binhluan"]+$item["sl_binhluantl"]}}</td>
                                                        <td>{{$bl_hashtag_thich}}</td>
                                                        <td>{{count($nd_hashtag)}}</td>
                                                        <td><?php echo $hashtagcount->clone()->where('H_HASHTAG', $item["hashtag"])->count(); ?></td>
                                                        <td>{{round(($item["Total_hashtag"] / $sum_total_hashtag) * 100, 1)}}%</td>
                                                    </tr>
                                                    <?php $i++ ?>
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

                <div class="card">
                    <div class="card-body p-4">
                        <div class="mb-3 mb-sm-0">
                            <h2 class="card-title fw-semibold text-center fs-6">THỐNG KÊ NGƯỜI DÙNG</h2>
                            <div class="mt-4 mb-4 w-100 mx-auto">
                                <canvas id="chartNewUser"></canvas>
                                <div class="row h-100 mt-5">
                                    <div class="col-sm-6">
                                        <h2 class="card-title fw-semibold text-center fs-5 pb-3">HOẠT ĐỘNG NỔI BẬT</h2>
                                        <div class="h-100">
                                        @if ($account_hot->count() > 0)
                                                @foreach($account_hot as $key => $info)    
                                                <div class="mb-3 mb-sm-0">
                                                    <div class="row">
                                                        <div class="col-sm-8">
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
                                                            <a href="{{URL::to('/tai-khoan/'.$info->ND_MA)}}" class="btn btn-primary w-100" type="button"><i class="fas fa-user-circle"></i> Trang cá nhân</a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            - Bài viết gửi: <b><?php if (isset($bv_nd_count[$info->ND_MA])) echo $bv_nd_count[$info->ND_MA]; else echo '0'; ?></b><br>
                                                            - Bài viết duyệt: <b><?php if (isset($bvd_nd_count[$info->ND_MA])) echo $bvd_nd_count[$info->ND_MA]; else echo '0'; ?></b><br>
                                                            - Bình luận: <b><?php if (isset($bl_nd_count[$info->ND_MA])) echo $bl_nd_count[$info->ND_MA]; else echo '0'; ?></b>
                                                        </div>
                                                    </div>
                                                </div><hr>
                                            @endforeach
                                        @else
                                            <div class="text-center mt-4 mb-2">Rất tiếc! Không có nội dung nổi bật để hiển thị :(</div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <h2 class="card-title fw-semibold text-center fs-5 pb-3">BỊ BÁO CÁO NỔI BẬT</h2>
                                        <div class="h-100">
                                        @if ($account_bc->count() > 0)
                                                @foreach($account_bc as $key => $infobc)    
                                                <div class="mb-3 mb-sm-0">
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <div class="d-flex flex-row">
                                                                <div>
                                                                    <img src="<?php if($infobc->ND_ANHDAIDIEN) echo $infobc->ND_ANHDAIDIEN; else echo config('constants.default_avatar');?>"
                                                                        alt="" width="50" height="50" class="rounded-circle me-2">
                                                                </div>
                                                                <div class="pt-1">
                                                                    <b>{{$infobc->ND_HOTEN}}</b>
                                                                    @if($infobc->VT_MA != 3)
                                                                        <span class="badge-sm bg-warning rounded-pill"><i>{{$infobc->VT_TEN}}</i></span>
                                                                    @endif
                                                                    <p>
                                                                        @if($infobc->KT_MA != null)
                                                                            <?php $c = $college->where('KT_MA', $infobc->KT_MA)->first(); echo $c->KT_TEN; ?>
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex">
                                                                <a href="{{URL::to('/tai-khoan/'.$infobc->ND_MA)}}" class="btn btn-primary w-50" type="button"><i class="fas fa-user-circle"></i></a>
                                                                <form role="form" action="{{URL::to('/tai-khoan/'.$infobc->ND_MA)}}" method="post" class="delete-form w-100 ms-3">
                                                                    @method('DELETE')
                                                                    {{csrf_field()}}
                                                                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?')" class="btn btn-danger w-100" ui-toggle-class="">
                                                                        <i class="fa fa-times text-white text"></i> Vô hiệu hoá tài khoản
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <?php if (isset($infobc->sl_baiviet) && $infobc->sl_baiviet != 0) { ?>
                                                            - <b><?php if (isset($infobc->sl_baocaobaiviet)) echo $infobc->sl_baocaobaiviet; else echo '0'; ?></b> báo cáo /
                                                                <b><?php if (isset($infobc->sl_baiviet)) echo $infobc->sl_baiviet; else echo '0'; ?></b> bài viết<br>
                                                                - Xác nhận vi phạm 
                                                                <b><?php if (isset($infobc->sl_baivietxl)) echo $infobc->sl_baivietxl; else echo '0'; ?></b> bài viết<br>
                                                            <?php } 
                                                            if (isset($infobc->sl_binhluan) && $infobc->sl_binhluan != 0) { ?>
                                                            - <b><?php if (isset($infobc->sl_baocaobinhluan)) echo $infobc->sl_baocaobinhluan; else echo '0'; ?></b> báo cáo /
                                                                <b><?php if (isset($infobc->sl_binhluan)) echo $infobc->sl_binhluan; else echo '0'; ?></b> bình luận<br>
                                                                - Xác nhận vi phạm 
                                                                <b><?php if (isset($infobc->sl_binhluanxl)) echo $infobc->sl_binhluanxl; else echo '0'; ?></b> bình luận
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div><hr>
                                            @endforeach
                                        @else
                                            <div class="text-center mt-4 mb-2">Rất tiếc! Không có nội dung nổi bật để hiển thị :(</div>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>-->

<script>

    //|-----------------------------------------------------
    //|THỐNG KÊ TƯƠNG TÁC
    //|-----------------------------------------------------
    const chartActivity = document.getElementById('chartActivity');

    const dataActivity = {
        labels: ["<?php echo date('Y-m-d H:i:s', strtotime($TGBDau)) ?>", "<?php if($now > $TGKThuc) echo date('Y-m-d H:i:s', strtotime($TGKThuc)); else echo date('Y-m-d H:i:s', strtotime($now)); ?>"],
        datasets: [
            {
                label: 'Bài viết mới',
                data: [
                    <?php
                        foreach ($allDates as $date) {
                            $found = false;
                            foreach ($tt_bv as $ttbv) {
                                if ($ttbv->thoi_diem === $date) {
                                    echo '{ x: "'.$ttbv->thoi_diem.'", y: "'.$ttbv->so_luong.'" },';
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                echo '{ x: "'.$date.'", y: "0" },';
                            }

                            if ($date == $maxDate) break;
                        }
                    ?>
                ],
                borderColor: 'rgb(0, 175, 239)',
                backgroundColor: 'rgb(0, 175, 239, 0.2)',
                pointStyle: 'circle',
                pointRadius: 5,
                pointHoverRadius: 9,
                fill: false,
            },
            {
                label: 'Bình luận mới',
                data: [
                    <?php
                        foreach ($allDates as $date) {
                            $found = false;
                            foreach ($tt_bl as $ttbl) {
                                if ($ttbl->thoi_diem === $date) {
                                    echo '{ x: "'.$ttbl->thoi_diem.'", y: "'.$ttbl->so_luong.'" },';
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                echo '{ x: "'.$date.'", y: "0" },';
                            }

                            if ($date == $maxDate) break;
                        }
                    ?>
                ],
                borderColor: 'rgb(239, 64, 0)',
                backgroundColor: 'rgb(239, 64, 0, 0.2)',
                pointStyle: 'circle',
                pointRadius: 5,
                pointHoverRadius: 9,
                fill: false,
            }
        ]
    };

    new Chart(chartActivity, {
        type: 'line',
        data: dataActivity,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                xAxes: [{
                    type: 'time',

                    <?php if($minUnit == "gio"){ ?>
                        time: {
                            unit: 'hour',
                            tooltipFormat: 'DD/MM/YYYY HH[h]', // Định dạng tooltip
                            displayFormats: {
                                hour: 'DD/MM/YYYY HH[h]' // Định dạng ngày tháng năm
                            }
                        },
                    <?php } else if($minUnit == "thang") { ?>
                        time: {
                            unit: 'month',
                            tooltipFormat: 'MM/YYYY',
                            displayFormats: {
                                month: 'MM/YYYY'
                            }
                        },
                    <?php } else { ?>
                        time: {
                            unit: 'day',
                            tooltipFormat: 'DD/MM/YYYY',
                            displayFormats: {
                                day: 'DD/MM/YYYY'
                            }
                        },
                    <?php }?>

                    scaleLabel: {
                        display: true,
                        labelString: 'Thời điểm'
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 12
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Số lượng'
                    }
                }]
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(tooltipItem, data) {
                        var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': ' + tooltipItem.yLabel;
                    }
                }
            }
        },
    });

    //|-----------------------------------------------------
    //|THỐNG KÊ HASHTAG TƯƠNG TÁC
    //|-----------------------------------------------------
    const chartHashtag = document.getElementById('chartHashtag');

    const dataHashtag = {
        labels: [
            <?php
                $i = 0; $other = 0;
                foreach ($total_hashtag as $item) {
                    if($i < 10){
                        echo '"'.$item["hashtag"].'", ';
                        $i++;
                    }
                    else{
                        $other += $item["Total_hashtag"];
                    }
                }
                if($other != 0){
                    echo '"Khác", ';
                }
            ?>
        ],
        datasets: [
            {
            data: [
                <?php
                    $j = 0;
                    foreach ($total_hashtag as $item) {
                        if($j < 10){
                            echo $item["Total_hashtag"].', ';
                            $j++;
                        }
                    }
                    if($other != 0){
                        echo $other.', ';
                    }
                ?>
            ],
            backgroundColor: [
                'rgba(0, 175, 239, 0.5)',
                'rgba(24, 181, 239, 0.5)',
                'rgba(48, 188, 239, 0.5)',
                'rgba(72, 194, 239, 0.5)',
                'rgba(96, 201, 239, 0.5)',
                'rgba(119, 207, 239, 0.5)',
                'rgba(143, 213, 239, 0.5)',
                'rgba(167, 220, 239, 0.5)',
                'rgba(191, 226, 239, 0.5)',
                'rgba(215, 233, 239, 0.5)',
                ],
            borderColor: [
                'rgb(0, 175, 239)',
                'rgb(24, 181, 239)',
                'rgb(48, 188, 239)',
                'rgba(72, 194, 239)',
                'rgba(96, 201, 239)',
                'rgba(119, 207, 239)',
                'rgba(143, 213, 239)',
                'rgba(167, 220, 239)',
                'rgba(191, 226, 239)',
                'rgba(215, 233, 239)',
                ],
            borderWidth: 2
            }
        ]
    };

    new Chart(chartHashtag, {
        type: 'doughnut',
        data: dataHashtag,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        },
    });

    <?php if (empty($total_hashtag)) echo "$('#chartHashtag').closest('div').html(`<p class='text-center pt-5 pb-5'>Không có hashtag nào được tương tác trong khoảng thời gian này!</p>`);" ?>

    //|-----------------------------------------------------
    //|THỐNG KÊ NGƯỜI DÙNG MỚI
    //|-----------------------------------------------------
    const chartNewUser = document.getElementById('chartNewUser');

    new Chart(chartNewUser, {
        type: 'bar',
        data: {
            labels: [
                <?php 
                    if($minUnit == "gio") {
                        echo '"'.date('Y-m-d', strtotime($TGBDau)).'", '; 
                        $endDate = date('Y-m-d', strtotime($TGBDau));
                    } 
                    else { 
                        foreach ($allDates as $date) { 
                            echo '"'.date('Y-m-d', strtotime($date)).'", '; 
                            $endDate = date('Y-m-d', strtotime($date));
                        } 
                    }

                    if($minUnit == "thang") echo '"'.date('Y-m-d', strtotime($endDate.' +1 month')).'", ';
                    else echo '"'.date('Y-m-d', strtotime($endDate.' +1 day')).'", '
                ?>],
            datasets: [{
                label: 'Số lượng người dùng mới',
                data: [
                    <?php
                        if($minUnit == "gio") {
                            if(!is_null($ndm)) echo $ndm->so_luong; else echo '0';
                        }
                        else{
                            foreach ($allDates as $date) {
                                $found = false;
                                foreach ($ndm as $nd) {
                                    if ($nd->thoi_diem === $date) {
                                        echo '"'.$nd->so_luong.'", ';
                                        $found = true;
                                        break;
                                    }
                                }
                                if (!$found) {
                                    echo '"0", ';
                                }
                            }
                        }
                        
                    ?>
                ],
                borderWidth: 1,
                borderColor: 'rgb(0, 175, 239)',
                backgroundColor: 'rgb(0, 175, 239, 0.5)',
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    type: 'time',

                    <?php if($minUnit == "thang") { ?>
                        time: {
                            unit: 'month',
                            tooltipFormat: 'MM/YYYY',
                            displayFormats: {
                                month: 'MM/YYYY'
                            }
                        },
                    <?php } else { ?>
                        time: {
                            unit: 'day',
                            tooltipFormat: 'DD/MM/YYYY',
                            displayFormats: {
                                day: 'DD/MM/YYYY'
                            }
                        },
                    <?php }?>
                    
                    scaleLabel: {
                        display: true,
                        labelString: 'Thời điểm'
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 12
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Người'
                    }
                }]
            },
        }
    });
</script>
@endsection