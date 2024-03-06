@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
            <h5 class="card-title fw-semibold">Hashtag</h5>
            <a class="btn btn-primary" href="{{URL::to('/hashtag-theo-doi')}}" previewlistener="true">
              Hashtag bạn đang theo dõi
            </a>
      </div>
      <hr>
      <div class="mb-3 mb-sm-0 pb-3">
          <span>Hashtag nổi bật:</span>
          <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
          <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
          <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
          <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#ung_dung</span></a>
          <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#lay_y_kien</span></a>
          <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
          <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
          <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
      </div>
      <div class="card">
        <div class="card-body p-4">
          <div class="mb-3 mb-sm-0 row">
              @foreach($hashtag as $key => $tag)
                  <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{URL::to('/hashtag/'.$tag->H_HASHTAG)}}"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-4 p-2 long-hashtag">#{{$tag->H_HASHTAG}}</span></a>
                    <?php if($userLog) { 
                      $isFollowHashtag = $hashtag_theodoi_noget->clone()
                      ->where("H_HASHTAG", $tag->H_HASHTAG)->exists();
                    ?>
                      @if(!$isFollowHashtag)
                        <span class="follow-hashtag fs-1 cursor-pointer" data-hashtag-value="<?php echo $tag->H_HASHTAG ?>"><i class="fas fa-plus"></i></span>
                      @else
                        <span class="unfollow-hashtag fs-1 cursor-pointer" data-hashtag-value="<?php echo $tag->H_HASHTAG ?>"><i class="fas fa-check"></i></span>
                      @endif
                    <?php } ?>
                  </div>
              @endforeach
          </div>
        </div>
      </div>

      <!-- Page number start-->
      <div>
          <small class="text-muted inline m-t-sm m-b-sm">
          {{ "Hiển thị ". $hashtag->firstItem() ."-". $hashtag->lastItem() ." trong tổng số ". $hashtag->total() ." dòng dữ liệu" }}
          </small>
      </div>
      
      <nav aria-label="Page navigation">
          <div class="text-center d-flex justify-content-center mt-3">
              <ul class="pagination pagination-sm m-t-none m-b-none ">
                  {{-- Previous Page Link --}}
                  @if ($hashtag->onFirstPage())
                      <li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-left"></i></a></li>
                  @else
                      <li class="page-item">
                          <a class="page-link" href="{{ $hashtag->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
                      </li>
                  @endif
                  {{-- Pagination Elements --}}
                  @for ($key=0; $key+1<=$hashtag->lastPage(); $key++)
                          @if ($hashtag->currentPage() === $key + 1)
                              <li class="page-item active">
                                  <a class="page-link" href="{{ $hashtag->url($key + 1) }}">{{ $key + 1 }}</a>
                              </li>
                          @else
                              <li class="page-item">
                                  <a class="page-link" href="{{ $hashtag->url($key + 1) }}">{{ $key + 1 }}</a>
                              </li>
                          @endif
                  @endfor
              
                  {{-- Next Page Link --}}
                  @if ($hashtag->hasMorePages())
                      <li class="page-item">
                          <a class="page-link" href="{{ $hashtag->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
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
        })
    </script>
@endsection