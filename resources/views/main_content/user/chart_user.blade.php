@extends('welcome')
@section('content')
<?php 
    $userLog= Session::get('userLog');  
?>
    
    <!-- Content Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Nhìn lại quá trình hoạt động của bạn (<?php echo (date('d/m/Y', strtotime($TGBDau)). ' - '.date('d/m/Y', strtotime($TGKThuc))) ?>)</h5>
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
                            <h2 class="card-title fw-semibold text-center fs-6">NHÌN LẠI THEO KHOẢNG THỜI GIAN</h2>
                            <div class="panel-body">
                                <form role="form" action="{{URL::to('/nhin-lai-qua-trinh')}}" method="GET">
                                    <div class="form-group row pt-4 align-items-center">
                                        <div class="col-sm-2 align-items-center pb-2"><label>Theo thời gian:</label></div>
                                        <div class="col-sm-4 d-flex d-block align-items-center justify-content-between pb-2">
                                            <span> Từ: </span>
                                            <input type="date" min="<?php echo date('Y-m-d', strtotime($userLog->ND_NGAYTHAMGIA)); ?>" name="TGBDau" required="" value="<?php echo date('Y-m-d', strtotime($TGBDau)) ?>" class="form-control w-75">
                                        </div>
                                        <div class="col-sm-4 d-flex d-block align-items-center justify-content-between pb-2">
                                            <span> Đến: </span>
                                            <input type="date" min="<?php echo date('Y-m-d', strtotime($userLog->ND_NGAYTHAMGIA)); ?>" name="TGKThuc" required="" value="<?php echo date('Y-m-d', strtotime($TGKThuc)) ?>" class="form-control w-75">
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
                        echo '<a class="btn btn-primary btn-sm me-2 mb-3" href="'.URL::to('/nhin-lai-qua-trinh').'?TGBDau='.$today.'&TGKThuc='.$today.'">Hôm nay</a>';

                        $yesterday = (new DateTime($today))->modify('-1 day')->format('Y-m-d');
                        echo '<a class="btn btn-primary btn-sm me-2 mb-3" href="'.URL::to('/nhin-lai-qua-trinh').'?TGBDau='.$yesterday.'&TGKThuc='.$yesterday.'">Hôm qua</a>';

                        $last7days = (new DateTime($today))->modify('-7 day')->format('Y-m-d');
                        echo '<a class="btn btn-primary btn-sm me-2 mb-3" href="'.URL::to('/nhin-lai-qua-trinh').'?TGBDau='.$last7days.'&TGKThuc='.$today.'">7 ngày qua</a>';

                        //$lastmonth = (new DateTime($today))->modify('-1 month')->format('Y-m-d');
                        $thismonthfirstday = (new DateTime($today))->modify('first day of this month')->format('Y-m-d');
                        $lastmonthfirstday = (new DateTime($today))->modify('first day of last month')->format('Y-m-d');
                        $lastmonthlastday = (new DateTime($today))->modify('last day of last month')->format('Y-m-d');
                        echo '<a class="btn btn-primary btn-sm me-2 mb-3" href="'.URL::to('/nhin-lai-qua-trinh').'?TGBDau='.$thismonthfirstday.'&TGKThuc='.$today.'">Tháng này</a>';
                        echo '<a class="btn btn-primary btn-sm me-2 mb-3" href="'.URL::to('/nhin-lai-qua-trinh').'?TGBDau='.$lastmonthfirstday.'&TGKThuc='.$lastmonthlastday.'">Tháng trước</a>';

                        /*$last3month = (new DateTime($today))->modify('-3 month')->format('Y-m-d');
                        $last3monthfirstday = (new DateTime($today))->modify('-3 month')->modify('first day of this month')->format('Y-m-d');
                        echo '<a class="btn btn-primary btn-sm me-2 mb-3" href="'.URL::to('/nhin-lai-qua-trinh').'?TGBDau='.$last3monthfirstday.'&TGKThuc='.$lastmonthlastday.'">3 tháng trước</a>';*/
                    ?>
                </div>

                <div class="card">
                    <div class="card-body p-4">
                        <div class="mb-3 mb-sm-0">
                            <h2 class="card-title fw-semibold text-center fs-6">THỐNG KÊ HOẠT ĐỘNG TƯƠNG TÁC CỦA BẠN</h2>
                            <div class="m-4 w-100 mx-auto">
                                <canvas id="chartActivity"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body p-4">
                        <div class="mb-3 mb-sm-0 row">
                            <h2 class="card-title fw-semibold text-center fs-6 col-sm-12">THỐNG KÊ MỨC ĐỘ TƯƠNG TÁC VỚI HASHTAG CỦA BẠN</h2>
                            <div class="col-sm-5">
                                <canvas id="chartHashtag" class="mx-auto"></canvas>
                            </div>
                            <div class="col-sm-7 ps-5" id="detailHashtag">
                                <div class="row pt-5 mt-5">
                                    @if(!(empty($result_suggest)))
                                        <h6 class="mt-3 mb-3">Gợi ý các hashtag có thể xem thêm dành cho bạn</h6>
                                        @foreach($result_suggest as $tag)
                                            <div class="col-lg-4 col-md-4 col-sm-6">
                                                <a href="{{URL::to('/hashtag/'.$tag['hashtag'])}}"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-4 p-2 long-hashtag">#{{$tag['hashtag']}}</span></a>
                                                <?php if($userLog) { 
                                                $isFollowHashtag = $hashtag_theodoi_noget->clone()
                                                ->where("H_HASHTAG", $tag['hashtag'])->exists();
                                                ?>
                                                @if(!$isFollowHashtag)
                                                    <span class="follow-hashtag fs-1 cursor-pointer" data-hashtag-value="<?php echo $tag['hashtag'] ?>"><i class="fas fa-plus"></i></span>
                                                @else
                                                    <span class="unfollow-hashtag fs-1 cursor-pointer" data-hashtag-value="<?php echo $tag['hashtag'] ?>"><i class="fas fa-check"></i></span>
                                                @endif
                                                <?php } ?>
                                            </div>
                                        @endforeach
                                        <hr>
                                    @endif
                                    @if(!(empty($hashtag_should_fl)))
                                        <h6 class="mt-3 mb-3">Những hashtag bạn đã tương tác nhiều trong thời gian này nhưng chưa theo dõi</h6>
                                        @foreach($hashtag_should_fl as $tagfl)
                                            <div class="col-lg-4 col-md-4 col-sm-6">
                                                <a href="{{URL::to('/hashtag/'.$tagfl)}}"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-4 p-2 long-hashtag">#{{$tagfl}}</span></a>
                                                <?php if($userLog) { 
                                                $isFollowHashtag = $hashtag_theodoi_noget->clone()
                                                ->where("H_HASHTAG", $tagfl)->exists();
                                                ?>
                                                @if(!$isFollowHashtag)
                                                    <span class="follow-hashtag fs-1 cursor-pointer" data-hashtag-value="<?php echo $tagfl ?>"><i class="fas fa-plus"></i></span>
                                                @else
                                                    <span class="unfollow-hashtag fs-1 cursor-pointer" data-hashtag-value="<?php echo $tagfl ?>"><i class="fas fa-check"></i></span>
                                                @endif
                                                <?php } ?>
                                            </div>
                                        @endforeach
                                        <hr>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-4">
                        <div class="mb-3 mb-sm-0">
                            <h2 class="card-title fw-semibold text-center fs-6">GỢI Ý NGƯỜI DÙNG DÀNH CHO BẠN</h2>
                            <div class="m-4 w-100 mx-auto row">
                            @if(!(empty($total_user)))
                                <?php 
                                    //$total_user_sum = collect($total_user)->sum('Total_user'); 
                                    $max_total_user = $total_user[0]['Total_user'];
                                ?>
                                @foreach($total_user as $u)    
                                    <?php $info = $account_info->where('ND_MA', $u['user'])->first();?>
                                    @if($userLog && $userLog->ND_MA == $info->ND_MA)
                                    @else
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
                                                                <div class="ms-auto pt-1">
                                                                    <span class="text-muted fs-2"><i>Mức độ gợi ý: <b class="fs-5 text-danger"><?php echo round(($u['Total_user'] / $max_total_user) * 100, 1); ?>%</b></i></span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-row">
                                                                <a href="{{URL::to('/tai-khoan/'.$info->ND_MA)}}" class="btn btn-primary w-100" type="button"><i class="fas fa-user-circle"></i>
                                                                    Xem trang cá nhân</a>
                                                                @if($userLog)
                                                                <button class="btn btn-success ms-2 follow w-100" data-user-id-value="<?php echo $info->ND_MA;?>" type="button"><i class="fa fa-portrait"></i> Theo dõi</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <p class="text-center pt-5 pb-5">Không có dữ liệu nào được thu thập để gợi ý người dùng đến bạn trong khoảng thời gian này!</p>
                            @endif
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
                    if($i >= 10){
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

    <?php if (empty($total_hashtag)) echo "$('#chartHashtag').closest('div').removeClass('col-sm-5').html(`<p class='text-center pt-5 pb-5'>Không có hashtag nào được tương tác trong khoảng thời gian này!</p>`); $('#detailHashtag').hide();" ?>



</script>
<script>
    $(document).ready(function() {
        //|*****************************************************
        //|LIKE HASHTAG START 
        //|*****************************************************
        <?php if($userLog) { ?>
        $(document).on('click', '.follow-hashtag', function() {
            // Truy cập giá trị của tham số từ thuộc tính dữ liệu
            var element = $(this);
            var H_HASHTAG = $(this).data('hashtag-value');
            var iconElement = $(this).find('i');

            iconElement.removeClass('fa-plus');
            iconElement.removeClass('fa-check');
            iconElement.removeClass('fa-exclamation-circle text-danger');

            iconElement.addClass('spinner-border spinner-border-sm');

            $.ajax({
                url: '{{URL::to('/theo-doi-hashtag/')}}' +'/'+ H_HASHTAG,
                type: 'GET',
                success: function(response) {
                element.removeClass('follow-hashtag');
                element.addClass('unfollow-hashtag');

                iconElement.removeClass('spinner-border spinner-border-sm');
                iconElement.addClass('fa-check');
                //console.log(number);
                },
                error: function(error) {
                iconElement.removeClass('spinner-border spinner-border-sm');
                iconElement.addClass('fa-exclamation-circle text-danger');
                console.log(error);
                }
            });
                
        });
        $(document).on('click', '.unfollow-hashtag', function() {
            // Truy cập giá trị của tham số từ thuộc tính dữ liệu
            var element = $(this);
            var H_HASHTAG = $(this).data('hashtag-value');
            var iconElement = $(this).find('i');

            iconElement.removeClass('fa-plus');
            iconElement.removeClass('fa-check');
            iconElement.removeClass('fa-exclamation-circle text-danger');

            iconElement.addClass('spinner-border spinner-border-sm');

            $.ajax({
                url: '{{URL::to('/huy-theo-doi-hashtag/')}}' +'/'+ H_HASHTAG,
                type: 'GET',
                success: function(response) {
                element.removeClass('unfollow-hashtag');
                element.addClass('follow-hashtag');

                iconElement.removeClass('spinner-border spinner-border-sm');
                iconElement.addClass('fa-plus');
                //console.log(number);
                },
                error: function(error) {
                iconElement.removeClass('spinner-border spinner-border-sm');
                iconElement.addClass('fa-exclamation-circle text-danger');
                console.log(error);
                }
            });
                
        });
        <?php } ?>
        //|*****************************************************
        //|LIKE HASHTAG END
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
    })
</script>
@endsection