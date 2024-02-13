@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
<!-- Content Start -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
        <div class="mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
              <h5 class="card-title fw-semibold">Kho lưu trữ</h5>
        </div>
        <hr>
        <div class="row mt-3">
            <a href="{{URL::to('/kho-bai-viet')}}" class="col-md-4">
                <div class="card">
                    <div class="card-body p-4">
                        <h4 class="card-title text-center">Bài viết</h4>
                        <div class="mb-3 mb-sm-0 p-5">
                            <img class="card-img-bottom" src="https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/systems%2Fpost.png?alt=media&token=3a0306e3-6ba4-469d-a258-e61ee011395e" alt="Card image">
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{URL::to('/kho-binh-luan')}}" class="col-md-4">
                <div class="card">
                    <div class="card-body p-4">
                        <h4 class="card-title text-center">Bình luận</h4>
                        <div class="mb-3 mb-sm-0 p-5">
                            <img class="card-img-bottom" src="https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/systems%2Fcomment.png?alt=media&token=abde05be-fd38-436a-b786-c2b5f6e77d40" alt="Card image">
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{URL::to('/kho-file')}}" class="col-md-4">
                <div class="card">
                    <div class="card-body p-4">
                        <h4 class="card-title text-center">File</h4>
                        <div class="mb-3 mb-sm-0 p-5">
                            <img class="card-img-bottom" src="https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/systems%2Ffile.png?alt=media&token=f46a710d-e38a-4287-b07f-77f4f3b0c808" alt="Card image">
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
  </div>
</div>

  
    <script>
        $(document).ready(function() {
         
        })
    </script>
  
@endsection