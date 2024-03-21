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
                            <div class="m-4 w-100 mx-auto">
                                <canvas id="chartActivity"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body p-4">
                        <div class="mb-3 mb-sm-0">
                            <h2 class="card-title fw-semibold text-center fs-6">THỐNG KÊ MỨC ĐỘ TƯƠNG TÁC VỚI HASHTAG</h2>
                            <div class="m-4 w-50 mx-auto">
                                <canvas id="chartHashtag" class="mx-auto"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-4">
                        <div class="mb-3 mb-sm-0">
                            <h2 class="card-title fw-semibold text-center fs-6">THỐNG KÊ NGƯỜI DÙNG MỚI</h2>
                            <div class="m-4 w-100 mx-auto">
                                <canvas id="chartNewUser"></canvas>
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