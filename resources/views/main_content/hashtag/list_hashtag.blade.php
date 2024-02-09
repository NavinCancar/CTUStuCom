@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-8">
      <div class="mb-3 mb-sm-0 d-flex">
        <h5 class="card-title fw-semibold">Hashtag</h5>
      </div>
      <hr>

      <div class="card">
        <div class="card-body p-4">
          <div class="mb-3 mb-sm-0 row">
              @foreach($hashtag as $key => $tag)
                  <a href="{{URL::to('/hashtag/'.$tag->H_HASHTAG)}}" class="col-lg-3 col-md-4 col-sm-6"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-4 p-2">#{{$tag->H_HASHTAG}}</span></a>
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

    <div class="col-lg-4">
      <div class="mb-3 mb-sm-0">
        <h5 class="card-title fw-semibold">Gợi ý khám phá</h5>
      </div>
      <hr>
      <div class="card">
        <div class="card-body p-4">
          <div class="mb-3 mb-sm-0">
            <h5 class="card-title fw-semibold">Bạn tương tác nhiều nhất:</h5>
            <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
            <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
            <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
            <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
            <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3 fw-semibold me-1 mb-1">#ung_dung</span></a>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body p-4">
          <div class="mb-3 mb-sm-0">
            <h5 class="card-title fw-semibold">Có thể bạn muốn khám phá thêm:</h5>
            <a href="javascript:void(0)"><span class="badge bg-success rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
            <a href="javascript:void(0)"><span class="badge bg-success rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
            <a href="javascript:void(0)"><span class="badge bg-success rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
            <a href="javascript:void(0)"><span class="badge bg-success rounded-3 fw-semibold me-1 mb-1">#ung_dung</span></a>
            <a href="javascript:void(0)"><span class="badge bg-success rounded-3 fw-semibold me-1 mb-1">#lay_y_kien</span></a>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body p-4">
          <div class="mb-3 mb-sm-0">
            <h5 class="card-title fw-semibold">Hot nhất gần đây:</h5>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#ung_dung</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#lay_y_kien</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#tsv</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#k49</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#pass_sach</span></a>
            <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-1">#ung_dung</span></a>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
@endsection