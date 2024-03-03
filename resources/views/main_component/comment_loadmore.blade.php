@foreach($binh_luan as $key => $bl)
<?php $userLog= Session::get('userLog'); ?>
<div class="d-flex flex-row pb-3 pt-1" data-comment-id-value="{{$bl->BL_MA}}">
  <div>
  <a class="text-body">
      <img src="<?php if($bl->ND_ANHDAIDIEN) echo $bl->ND_ANHDAIDIEN; else echo config('constants.default_avatar');?>" alt="" 
          width="40" height="40" class="rounded-circle me-2">
  </a>
  </div>
  <div class="pt-1" style="width:100%">
      <a class="text-muted"><p class="fw-bold mb-0">{{$bl->ND_HOTEN}}</p></a>
      <a href="{{URL::to('/bai-dang/'.$bl->BV_MA.'/?binh-luan='.$bl->BL_MA)}}" class="text-muted">{{$bl->BL_NOIDUNG}}</a>

      <div class="row">
          <div class="col-sm-6 d-flex mt-2 justify-content-start">
              <span>{{date('H:i', strtotime($bl->BL_THOIGIANTAO))}} ngày {{date('d/m/Y', strtotime($bl->BL_THOIGIANTAO))}}</span>
          </div>
          <div class="col-sm-6 d-flex mt-2 justify-content-end">
              <a class="ms-3 text-muted cursor-pointer">
                  <span  onclick="navigator.clipboard.writeText('{{URL::to('/bai-dang/'.$bl->BV_MA.'/?binh-luan='.$bl->BL_MA)}}').then(() => { this.style.color = 'var(--bs-success)'; setTimeout(() => { this.style.color = '#5A6A85'; }, 500); }).catch(console.error);">
                      <i class="fas fa-link"></i> Chia sẻ 
                  </span>
              </a>

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
              <a class="ms-3 cursor-pointer text-muted <?php 
                if($userLog){
                    $check_bl_luu = $binh_luan_luu->clone()
                    ->where('danh_dau_boi.BL_MA', $bl->BL_MA)->where('danh_dau_boi.ND_MA', $userLog->ND_MA)->exists();
                    if($check_bl_luu) echo ' unbookmark-comment'; else echo ' bookmark-comment';
                } ?> " data-comment-id-value="{{$bl->BL_MA}}">
                <?php 
                if($userLog){
                    if($check_bl_luu) echo '<i class="fas fa-vote-yea"></i> Đã lưu'; 
                    else echo '<i class="fas fa-bookmark"></i> Lưu';
                } else echo '<i class="fas fa-bookmark"></i> Lưu';
                ?></a>
          </div>
      </div>
  </div>
</div>
@endforeach