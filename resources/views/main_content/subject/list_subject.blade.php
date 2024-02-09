@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="mb-3 mb-sm-0 d-flex">
        <h5 class="card-title fw-semibold">Học phần</h5>
      </div>
      <hr>

      <div class="card">
        <div class="card-body p-4">
          <div class="mb-3 mb-sm-0 row">
              @foreach($subject as $key => $sb)
                  <a href="{{URL::to('/hoc-phan/'.$sb->HP_MA)}}" class="col-lg-4 col-md-6 col-sm-6"><span class="badge bg-primary rounded-3 fw-semibold me-1 mb-4 p-2">{{$sb->HP_MA}} {{$sb->HP_TEN}}</span></a>
              @endforeach
          </div>
        </div>
      </div>

      <!-- Page number start-->
      <div>
          <small class="text-muted inline m-t-sm m-b-sm">
          {{ "Hiển thị ". $subject->firstItem() ."-". $subject->lastItem() ." trong tổng số ". $subject->total() ." dòng dữ liệu" }}
          </small>
      </div>
      
      <nav aria-label="Page navigation">
          <div class="text-center d-flex justify-content-center mt-3">
              <ul class="pagination pagination-sm m-t-none m-b-none ">
                  {{-- Previous Page Link --}}
                  @if ($subject->onFirstPage())
                      <li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-left"></i></a></li>
                  @else
                      <li class="page-item">
                          <a class="page-link" href="{{ $subject->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
                      </li>
                  @endif
                  {{-- Pagination Elements --}}
                  @for ($key=0; $key+1<=$subject->lastPage(); $key++)
                          @if ($subject->currentPage() === $key + 1)
                              <li class="page-item active">
                                  <a class="page-link" href="{{ $subject->url($key + 1) }}">{{ $key + 1 }}</a>
                              </li>
                          @else
                              <li class="page-item">
                                  <a class="page-link" href="{{ $subject->url($key + 1) }}">{{ $key + 1 }}</a>
                              </li>
                          @endif
                  @endfor
              
                  {{-- Next Page Link --}}
                  @if ($subject->hasMorePages())
                      <li class="page-item">
                          <a class="page-link" href="{{ $subject->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
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
@endsection