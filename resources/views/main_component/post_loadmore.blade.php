
              @foreach($bai_viet as $key => $bv)
              <div class="card">
                <div class="card-body p-4">
                  <div class="mb-3 mb-sm-0">
                    <p>
                      <a href="javascript:void(0)" class="text-body">
                        <img src="<?php if($bv->ND_ANHDAIDIEN) echo $bv->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'?>" alt="" width="20" height="20" class="rounded-circle">
                        <b>{{$bv->ND_HOTEN}}</b> 
                      </a>
                      đã đăng vào {{date('H:i', strtotime($bv->BV_THOIGIANDANG))}} ngày {{date('d/m/Y', strtotime($bv->BV_THOIGIANDANG))}}
                    </p>
                    <a href="{{URL::to('/bai-dang/'.$bv->BV_MA)}}" class="text-dark mb-2">
                      <h5 class="card-title fw-semibold post-title">{{$bv->BV_TIEUDE}}</h5>

                      <span class="limited-lines">{!! nl2br(e($bv->BV_NOIDUNG)) !!}</span>
                    </a>
                    <div class="d-flex justify-content-end mt-2">
                        <a class="ms-3 text-muted"><i class="fas fa-eye"></i> Lượt xem: <b>{{$bv->BV_LUOTXEM}}</b></a>
                        <?php
                          $count_thich_tim= $count_thich->where('BV_MA',$bv->BV_MA)->first();
                          $count_binh_luan_tim= $count_binh_luan->where('BV_MA',$bv->BV_MA)->first();
                        ?>
                        <a class="ms-3 <?php 
                          if($userLog){
                              $check_bv_thich = $thich_no_get->clone()
                              ->where('baiviet_thich.BV_MA', $bv->BV_MA)->where('baiviet_thich.ND_MA', $userLog->ND_MA)->exists();
                              if($check_bv_thich) echo 'text-danger'; else echo "text-muted";
                          } else echo "text-muted"?> ">
                        <i class="fas fa-heart"></i> Thích: <b><?php if($count_thich_tim) echo $count_thich_tim->count; else echo 0;?></b></a>
                        <a class="ms-3 text-muted"><i class="fas fa-reply"></i> Trả lời: <b><?php if($count_binh_luan_tim) echo $count_binh_luan_tim->count; else echo 0;?></b></a>
                    </div>
                    <div class=" m-1 mt-2">
                      @if($bv->HP_MA)
                      <?php
                        $hoc_phan_tim= $hoc_phan->where('HP_MA',$bv->HP_MA)->first();
                      ?>
                      <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3"><i class="fa fa-folder"></i> {{$hoc_phan_tim->HP_MA}} {{$hoc_phan_tim->HP_TEN}}</span></a>
                      @endif

                      @foreach($hashtag_bai_viet as $key => $hbv)
                        @if($bv->BV_MA==$hbv->BV_MA)
                        <a href="javascript:void(0)"><span class="badge bg-primary rounded-3">#{{$hbv->H_HASHTAG}}</span></a>
                        @endif
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
              @endforeach