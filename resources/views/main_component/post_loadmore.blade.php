<?php $userLog= Session::get('userLog'); ?>
@foreach($bai_viet as $key => $bv)
  <div class="card">
    <div class="card-body p-4">
      <div class="mb-3 mb-sm-0">
        <div class="pb-2">
          <a href="{{URL::to('/tai-khoan/'.$bv->ND_MA)}}" class="text-body">
            <img src="<?php if($bv->ND_ANHDAIDIEN) echo $bv->ND_ANHDAIDIEN; else echo config('constants.default_avatar');?>" alt="" width="20" height="20" class="rounded-circle">
            <b>{{$bv->ND_HOTEN}}</b> 
          </a>
          @if($bv->VT_MA != 3)
            <span class="badge-sm bg-warning rounded-pill"><i>{{$bv->VT_TEN}}</i></span>
          @endif
          đã đăng vào {{date('H:i', strtotime($bv->BV_THOIGIANDANG))}} ngày {{date('d/m/Y', strtotime($bv->BV_THOIGIANDANG))}}
        </div>
        <a href="{{URL::to('/bai-dang/'.$bv->BV_MA)}}" class="text-dark mb-2">
          <h5 class="card-title fw-semibold post-title">{{$bv->BV_TIEUDE}}</h5>

          <span class="limited-lines">{!! nl2br(e($bv->BV_NOIDUNG)) !!}</span>
        </a>
        <div class="d-flex justify-content-end mt-2">
            <a class="ms-3 text-muted cursor-pointer">
              <span  onclick="navigator.clipboard.writeText('{{URL::to('/bai-dang/'.$bv->BV_MA)}}').then(() => { this.style.color = 'var(--bs-success)'; setTimeout(() => { this.style.color = '#5A6A85'; }, 500); }).catch(console.error);">
                <i class="fas fa-link"></i> Chia sẻ 
              </span>
            </a>

            <a class="ms-3 text-muted"><i class="fas fa-eye"></i> Lượt xem: <b>{{$bv->BV_LUOTXEM}}</b></a>
            <?php
              $count_thich_tim= $count_thich->where('BV_MA',$bv->BV_MA)->first();
              $count_binh_luan_tim= $count_binh_luan->where('BV_MA',$bv->BV_MA)->first();
            ?>
            <a class="ms-3 cursor-pointer <?php 
              if($userLog){
                  $check_bv_thich = $thich_no_get->clone()
                  ->where('baiviet_thich.BV_MA', $bv->BV_MA)->where('baiviet_thich.ND_MA', $userLog->ND_MA)->exists();
                  if($check_bv_thich) echo 'text-danger unlike-post'; else echo 'text-muted like-post';
              } else echo "text-muted" ?> " data-post-id-value="{{$bv->BV_MA}}">
            <i class="fas fa-heart"></i> Thích: <b><?php if($count_thich_tim) echo $count_thich_tim->count; else echo 0;?></b></a>
            <a class="ms-3 text-muted"><i class="fas fa-reply"></i> Trả lời: <b><?php if($count_binh_luan_tim) echo $count_binh_luan_tim->count; else echo 0;?></b></a>
            <a class="ms-3 cursor-pointer text-muted<?php 
                if($userLog){
                    $check_bv_luu = $bai_viet_luu->clone()
                    ->where('danh_dau.BV_MA', $bv->BV_MA)->where('danh_dau.ND_MA', $userLog->ND_MA)->exists();
                    if($check_bv_luu) echo ' unbookmark-post'; else echo ' bookmark-post';
                } ?> " data-post-id-value="{{$bv->BV_MA}}">
              <?php 
                if($userLog){
                  if($check_bv_luu) echo '<i class="fas fa-vote-yea"></i> Đã lưu'; 
                  else echo '<i class="fas fa-bookmark"></i> Lưu';
              } else echo '<i class="fas fa-bookmark"></i> Lưu';
              ?></a>
        </div>
        <div class=" m-1 mt-2">
          @if($bv->HP_MA)
          <?php
            $hoc_phan_tim= $hoc_phan->where('HP_MA',$bv->HP_MA)->first();
          ?>
          <a href="{{URL::to('/hoc-phan/'.$bv->HP_MA)}}"><span class="badge bg-indigo rounded-3"><i class="fa fa-folder"></i> {{$hoc_phan_tim->HP_MA}} {{$hoc_phan_tim->HP_TEN}}</span></a>
          @endif

          @foreach($hashtag_bai_viet as $key => $hbv)
            @if($bv->BV_MA==$hbv->BV_MA)
            <a href="{{URL::to('/hashtag/'.$hbv->H_HASHTAG)}}"><span class="badge bg-primary rounded-3">#{{$hbv->H_HASHTAG}}</span></a>
            @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endforeach