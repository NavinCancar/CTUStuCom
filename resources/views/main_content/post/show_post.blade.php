@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div>
            <h5 class="card-title fw-semibold pb-2">Chi tiết bài đăng</h5>
          </div>
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
          <hr>
          @foreach($bai_viet as $key => $bv)
          <?php $BV_MA = $bv->BV_MA; ?>
            <div class="card">
              <div class="card-body p-4">
                <div class="mb-3 mb-sm-0">
                  <p>
                    <a href="javascript:void(0)" class="text-body">
                      <img src="<?php if($bv->ND_ANHDAIDIEN) echo $bv->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'?>" alt="" width="40" height="40" class="rounded-circle">
                      <b>{{$bv->ND_HOTEN}}</b> 
                    </a>
                    đã đăng vào {{date('H:i', strtotime($bv->BV_THOIGIANDANG))}} ngày {{date('d/m/Y', strtotime($bv->BV_THOIGIANDANG))}}
                  </p>
                  <h5 class="card-title fw-semibold post-title">{{$bv->BV_TIEUDE}}</h5>
                  <span class="limited-lines">{!! nl2br(e($bv->BV_NOIDUNG)) !!}</span>

                  <!-- Images Container -->
                  <div id="images-container" class="m-2 mt-3 mb-3 position-relative">
                    <!--<span data-value="1" class="rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block file-item">    
                      <a target="_blank" href="https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/files%2F1706752716087_ldm1.png?alt=media&amp;token=0af3fc1b-79fa-480a-b8bc-63977782e1bc" previewlistener="true">
                        <img src="https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/files%2F1706752716087_ldm1.png?alt=media&token=0af3fc1b-79fa-480a-b8bc-63977782e1bc" width="100px" height="100px" alt="Banner Image" class="d-block mx-auto">    
                      </a>                        <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle file-item-btn" style="transform: translateX(-50%);">
                          <i class="fas fa-bookmark"></i>
                        </button>
                    </span>-->
                  </div>

                  <!-- File Container -->
                  <div id="files-container" class=" m-2 mt-3">
                    <!--<span data-value="0" class="badge bg-secondary rounded-3 fw-semiboldms-0 p-1 px-3 me-2 mb-2 text-white file-item">    
                      <i class="fas fa-file-pdf fs-5 me-2"></i> Đề tài.pdf    
                      <button class="btn btn-secondary btn-sm file-item-btn">
                        <i class="fas fa-bookmark"></i>
                      </button>
                    </span>-->
                  </div>
                  
                  <div class="m-2">
                    @if($bv->HP_MA)
                    <?php
                      $hoc_phan_tim= $hoc_phan->where('HP_MA',$bv->HP_MA)->first();
                    ?>
                    <a href="javascript:void(0)"><span class="badge bg-indigo rounded-3"><i class="fa fa-folder"></i> {{$hoc_phan_tim->HP_MA}} {{$hoc_phan_tim->HP_TEN}}</span></a>
                    @endif

                    @foreach($hashtag_bai_viet as $key => $hbv)
                      <a href="javascript:void(0)"><span class="badge bg-primary rounded-3 fw-semibold">#{{$hbv->H_HASHTAG}}</span></a>
                    @endforeach
                  </div>
                  <div class="row">
                    <div class="col-sm-6 d-flex mt-2 justify-content-start">
                      <a class="ms-3 text-muted"><i class="fas fa-eye"></i> Lượt xem: <b>{{$bv->BV_LUOTXEM}}</b></a>
                      <a class="ms-3 text-muted cursor-pointer report-post" data-post-id-value="{{$bv->BV_MA}}"><i class="fas fa-flag"></i> Báo cáo</a>
                    </div>
                    <div class="col-sm-6 d-flex mt-2 justify-content-end">
                      <a class="ms-3 cursor-pointer <?php 
                          if($userLog){
                              $check_bv_thich = $thich_no_get->clone()
                              ->where('baiviet_thich.BV_MA', $bv->BV_MA)->where('baiviet_thich.ND_MA', $userLog->ND_MA)->exists();
                              if($check_bv_thich) echo 'text-danger unlike-post'; else echo 'text-muted like-post';
                          } else echo "text-muted" ?> " data-post-id-value="{{$bv->BV_MA}}">
                        <i class="fas fa-heart"></i> Thích: <b><?php if($count_thich) echo $count_thich; else echo 0;?></b></a>
                      <a class="ms-3 text-muted cursor-pointer"><i class="fas fa-reply"></i> Trả lời: <b><?php if($count_binh_luan) echo $count_binh_luan; else echo 0;?></b></a>
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
                  </div>
                </div>
              </div>
            </div>
          @endforeach

          
          <div class="mb-3 mb-sm-0">
            <h5 class="card-title fw-semibold">Trả lời bài viết</h5>
          </div>
          <hr>
          @if($userLog)  
            <div class="card" id="form-comment0">
                <div class="card-body p-3">
                    <form id="reply-form0" class="text-muted d-flex justify-content-start align-items-center pe-3 mt-3">
                        {{ csrf_field() }}
                        <textarea name="BL_NOIDUNG0" class="form-control border-secondary ms-3" placeholder="Nhập bình luận" rows="3" style="resize: none;"></textarea>
                        <label for="file-input0" class="ms-3 text-muted" style="cursor: pointer;">
                            <i class="fas fa-paperclip"></i>
                        </label>
                        <input name="BL_TRALOI_MA0" value="0" type="number" style="display: none"/>
                        <!-- Input type file ẩn -->
                        <input name="TN_FDK0[]" type="file" id="file-input0" style="display: none" multiple accept=".jpg, .jpeg, .png, .doc, .docx, .pdf, .xls, .xlsx, .ppt, .pptx"/>
                        <input type="hidden" name="linkFile0" id="linkFileInput0" value="">
                        
                        <button type="button" id="reply-btn0" class="btn text-primary"><i class="fas fa-paper-plane"></i></button>
                    </form>
                  
                    <!-- File Container -->
                    <div id="selected-files-container0" class=" m-2">
                        <!--<span class="badge bg-secondary rounded-3 fw-semiboldms-0 p-1 px-3">
                            <a class="text-white" href="../assets/file/TB4823-DHCT_Thong bao Vv dang ky hoc cung luc hai chuong trinh nam 2024.pdf">
                            <i class="far fa-file-pdf"></i>
                                TB4823-DHCT_Thong bao Vv dang ky hoc cung luc hai chuong trinh nam 2024.pdf
                            </a>
                            <button class="btn btn-secondary btn-sm"><i class="fas fa-bookmark"></i></button>
                        </span>-->
                    </div>
                    <!-- Images Container -->
                    <div id="selected-images-container0" class="m-2 mb-3 position-relative">
                        <!--<span class="rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block">
                            <a target="_blank" href="../assets/file/Banner-VN.jpg">
                                <img src="../assets/file/Banner-VN.jpg" width="100px" height="100px" alt="Banner Image" class="d-block mx-auto">
                            </a>
                            <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle" style="transform: translateX(-50%);"><i class="fas fa-bookmark"></i></button>
                        </span>-->
                    </div>
                </div>
            </div>
          @endif

          <!-- Comment -->
          @foreach($binh_luan_goc as $key => $blg)
            <div class="card" id="form-comment1">
                <div class="card-body p-3">
                    <div class="list-unstyled mb-0 p-2 reply-comment-card">
                        <div class="d-flex flex-row pb-3 pt-1" data-comment-id-value="{{$blg->BL_MA}}">
                            <div>
                              <a href="javascript:void(0)" class="text-body">
                                <img src="<?php if($blg->ND_ANHDAIDIEN) echo $blg->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'?>" alt="" 
                                    width="40" height="40" class="rounded-circle me-2">
                              </a>
                            </div>
                            <div class="pt-1" style="width:100%">
                                <a href="javascript:void(0)" class="text-muted"><p class="fw-bold mb-0">{{$blg->ND_HOTEN}}</p></a>
                                <span class="text-muted">{{$blg->BL_NOIDUNG}}</span>

                                <!-- Images Container -->
                                <div id="images-container-{{$blg->BL_MA}}" class="mt-3 mb-3 position-relative"></div>
                                <!-- File Container -->
                                <div id="files-container-{{$blg->BL_MA}}" class="mt-3"></div>

                                <div class="row">
                                  <div class="col-sm-6 d-flex mt-2 justify-content-start">
                                    <span>{{date('H:i', strtotime($blg->BL_THOIGIANTAO))}} ngày {{date('d/m/Y', strtotime($blg->BL_THOIGIANTAO))}}</span>
                                  </div>
                                  <div class="col-sm-6 d-flex mt-2 justify-content-end">
                                    <a class="ms-3 text-muted cursor-pointer report-comment" data-comment-id-value="{{$blg->BL_MA}}"><i class="fas fa-flag"></i> Báo cáo</a>
                                    <a class="ms-3 cursor-pointer <?php 
                                        if($userLog){
                                            $check_bl_thich0 = $binh_luan_thich_no_get->clone()
                                            ->where('binh_luan.BL_MA', $blg->BL_MA)->where('binhluan_thich.ND_MA', $userLog->ND_MA)->exists();
                                            if($check_bl_thich0) echo 'text-danger unlike-comment'; else echo 'text-muted like-comment';
                                        } else echo "text-muted"?> " data-comment-id-value="{{$blg->BL_MA}}">
                                      <i class="fas fa-heart"></i> Thích:
                                      <b>
                                        <?php 
                                          $count_bl_thich0 = $binh_luan_thich_no_get->clone()->where('binh_luan.BL_MA', $blg->BL_MA)->count();
                                          if($count_bl_thich0) echo $count_bl_thich0; else echo 0;
                                        ?>
                                      </b>
                                    </a>
                                    <a class="ms-3 text-muted reply-comment-btn cursor-pointer" data-comment-id-value="{{$blg->BL_MA}}">
                                      <i class="fas fa-reply"></i> Trả lời: 
                                      <b>
                                        <?php 
                                          $count_bl_traloi = $binh_luan_no_get->clone()->where('binh_luan.BL_TRALOI_MA', $blg->BL_MA)->count();
                                          //dd($count_bl_traloi);
                                          if($count_bl_traloi) echo $count_bl_traloi; else echo 0;
                                        ?>
                                      </b>
                                    </a>
                                    <a class="ms-3 cursor-pointer text-muted <?php 
                                      if($userLog){
                                          $check_bl_luu = $binh_luan_luu_no_get->clone()
                                          ->where('danh_dau_boi.BL_MA', $blg->BL_MA)->where('danh_dau_boi.ND_MA', $userLog->ND_MA)->exists();
                                          if($check_bl_luu) echo ' unbookmark-comment'; else echo ' bookmark-comment';
                                      } ?> " data-comment-id-value="{{$blg->BL_MA}}">
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

                        <!-- Rep Comment -->
                        @foreach($binh_luan_traloi as $key => $bltl)
                          @if($bltl->BL_TRALOI_MA == $blg->BL_MA)
                            <div class="d-flex flex-row ms-5 pb-1 pt-3" data-comment-id-value="{{$bltl->BL_MA}}">
                                <div>
                                  <a href="javascript:void(0)" class="text-body">
                                    <img src="<?php if($bltl->ND_ANHDAIDIEN) echo $bltl->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'?>" alt="" 
                                        width="40" height="40" class="rounded-circle me-2">
                                  </a>
                                </div>
                                <div class="pt-1" style="width:100%">
                                    <a href="javascript:void(0)" class="text-muted"><p class="fw-bold mb-0">{{$bltl->ND_HOTEN}}</p></a>
                                    <span class="text-muted">{{$bltl->BL_NOIDUNG}}</span>

                                    <!-- Images Container -->
                                    <div id="images-container-{{$bltl->BL_MA}}" class="mt-3 mb-3 position-relative"></div>
                                    <!-- File Container -->
                                    <div id="files-container-{{$bltl->BL_MA}}" class="mt-3"></div>

                                    <div class="row">
                                      <div class="col-sm-6 d-flex mt-2 justify-content-start">
                                        <span>{{date('H:i', strtotime($bltl->BL_THOIGIANTAO))}} ngày {{date('d/m/Y', strtotime($bltl->BL_THOIGIANTAO))}}</span>
                                      </div>
                                      <div class="col-sm-6 d-flex mt-2 justify-content-end">
                                        <a class="ms-3 text-muted cursor-pointer report-comment" data-comment-id-value="{{$bltl->BL_MA}}"><i class="fas fa-flag"></i> Báo cáo</a>
                                        <a class="ms-3 cursor-pointer <?php 
                                            if($userLog){
                                                $check_bl_thich1 = $binh_luan_thich_no_get->clone()
                                                ->where('binh_luan.BL_MA', $bltl->BL_MA)->where('binhluan_thich.ND_MA', $userLog->ND_MA)->exists();
                                                if($check_bl_thich1) echo 'text-danger unlike-comment'; else echo 'text-muted like-comment';
                                            } else echo "text-muted"?> "  data-comment-id-value="{{$bltl->BL_MA}}">
                                          <i class="fas fa-heart"></i> Thích:
                                          <b>
                                            <?php 
                                              $count_bl_thich1 = $binh_luan_thich_no_get->clone()->where('binh_luan.BL_MA', $bltl->BL_MA)->count();
                                              if($count_bl_thich1) echo $count_bl_thich1; else echo 0;
                                            ?>
                                          </b>
                                          <a class="ms-3 cursor-pointer text-muted <?php 
                                            if($userLog){
                                                $check_bl_luu = $binh_luan_luu_no_get->clone()
                                                ->where('danh_dau_boi.BL_MA', $bltl->BL_MA)->where('danh_dau_boi.ND_MA', $userLog->ND_MA)->exists();
                                                if($check_bl_luu) echo ' unbookmark-comment'; else echo ' bookmark-comment';
                                            } ?> " data-comment-id-value="{{$bltl->BL_MA}}">
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
                          @endif
                        @endforeach

                        <!--<div id="divdata-unique" class="ms-5 pb-1 pt-3">
                        <form id="reply-form1" class="text-muted d-flex justify-content-start align-items-center pe-3 mt-3">
                            {{ csrf_field() }}
                            <textarea name="BL_NOIDUNG1" class="form-control border-secondary ms-3" placeholder="Nhập bình luận" rows="2" style="resize: none;"></textarea>
                            <label for="file-input1" class="ms-3 text-muted" style="cursor: pointer;">
                                <i class="fas fa-paperclip"></i>
                            </label>
                            <input name="BL_TRALOI_MA1" value="{{$blg->BL_MA}}" type="number" style="display: none"/>
                            <input name="TN_FDK1[]" type="file" id="file-input1" style="display: none" multiple accept=".jpg, .jpeg, .png, .doc, .docx, .pdf, .xls, .xlsx, .ppt, .pptx"/>
                            <input type="hidden" name="linkFile1" id="linkFileInput1" value="">
                            <button type="button" id="reply-btn1" class="btn text-primary"><i class="fas fa-paper-plane"></i></button>
                        </form>
                        <div id="selected-files-container1" class=" m-2"></div>
                        <div id="selected-images-container1" class="m-2 mb-3 position-relative"></div>
                        </div>-->

                    </div>
                </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <script type="module">
        //|-----------------------------------------------------
        //|KHAI BÁO FIRESTORE
        //|-----------------------------------------------------
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import { getFirestore, setDoc, addDoc, doc, collection, serverTimestamp, getDocs, query, where, orderBy, limit, or, onSnapshot, updateDoc, deleteDoc } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";
        import { getStorage, ref, uploadBytes, listAll, getDownloadURL, deleteObject  } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-storage.js";

        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyCM8jj3tql4LSIaPvjI6D9_BTLYnaspwks",
            authDomain: "ctu-student-community.firebaseapp.com",
            databaseURL: "https://ctu-student-community-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "ctu-student-community",
            storageBucket: "ctu-student-community.appspot.com",
            messagingSenderId: "977339665171",
            appId: "1:977339665171:web:9c200c8bc8907bd9ff28e6"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const db = getFirestore(app);
        const storage = getStorage(app);

        //-----------------------------------------------------------------------------------
        //***********************************************************************************
        //***********************************************************************************
        const filesContainer = document.getElementById('files-container');
        const imagesContainer = document.getElementById('images-container');
        var fileSaved = [];

        $(document).ready(function() {
          //|-----------------------------------------------------
          //|DANH SÁCH FILE NGƯỜI DÙNG ĐÃ LƯU
          //|-----------------------------------------------------
          <?php if($userLog) { ?>

            (async () => {
                  const qbookmarkfileSaved = query(
                  collection(db, "DANH_DAU_FILE"), 
                  where('ND_MA', '==', <?php if($userLog) echo $userLog->ND_MA; ?>)
                  );
                  
                  const querySnapshotbookmarkfileSaved = await getDocs(qbookmarkfileSaved);
                  
                  querySnapshotbookmarkfileSaved.forEach((doc) => {
                      fileSaved.push(doc.data().FDK_MA);
                  });
            })().catch((error) => {
                console.error("Error in script: ", error);
            });

          <?php } ?>
          //|-----------------------------------------------------
          //|HIỆN FILE BÀI VIẾT
          //|-----------------------------------------------------
          (async () => {
            const qfile = query(
                collection(db, "FILE_DINH_KEM"), 
                where('ND_NHAN_MA', '==', 0),
                where('ND_GUI_MA', '==', 0),
                where('BV_MA', '==', <?php echo $BV_MA; ?>),
                where('BL_MA', '==', 0),
                where('TN_THOIGIANGUI', '==', null)
            );

            const querySnapshotfile = await getDocs(qfile);
        
            querySnapshotfile.forEach((doc) => {
                const fileName = doc.data().FDK_TEN;
                const fileLink = doc.data().FDK_DUONGDAN;
                const fileExtension = fileName.split('.').pop().toLowerCase();

                if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                    // Image
                    var divData =
                      '<span class="rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block file-item">' +
                      '  <a target="_blank" href="'+fileLink+'" previewlistener="true">' +
                      '    <img src="'+fileLink+'" width="100px" height="100px" alt="'+fileName+'" class="d-block mx-auto">' +
                      '  </a>' +
                      '  <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle file-item-btn bookmark-file" data-fdk-id-value="'+doc.id+'" style="transform: translateX(-50%);">' ;
                    if (fileSaved.includes(doc.id)) divData += '    <i class="fas fa-vote-yea"></i>';
                    else  divData += '    <i class="fas fa-bookmark"></i>';
                    divData += 
                      '  </button>' +
                      '</span>';
                    imagesContainer.insertAdjacentHTML('afterbegin', divData);
                }
                else{
                    var divData =
                        '<span class="badge bg-secondary rounded-3 fw-semiboldms-0 p-1 px-3 me-2 mb-2 text-white file-item">' +    
                        ' <a target="_blank" class="text-white" href="'+fileLink+'">';

                    if (['pdf'].includes(fileExtension)){
                        divData += '    <i class="fas fa-file-pdf fs-5 me-2"></i> ';
                    }
                    else if (['docx', 'doc'].includes(fileExtension)) {
                        divData += '    <i class="fas fa-file-word fs-5 me-2"></i> ';
                    }
                    else if (['xlsx', 'xls'].includes(fileExtension)) {
                        divData += '    <i class="fas fa-file-excel fs-5 me-2"></i> ';
                    }
                    else if (['ppt', 'pptx'].includes(fileExtension)) {
                        divData += '    <i class="fas fa-file-powerpoint fs-5 me-2"></i> ';
                    }
                    else {
                        divData += '    <i class="fas fa-file fs-5 me-2"></i> ';
                    }

                    divData += fileName +
                        ' </a>' +
                        '  <button class="btn btn-secondary btn-sm file-item-btn bookmark-file" data-fdk-id-value="'+doc.id+'">' ;
                    if (fileSaved.includes(doc.id)) divData += '    <i class="fas fa-vote-yea background-indigo"></i>';
                    else  divData += '    <i class="fas fa-bookmark"></i>';
                    divData += 
                        '  </button>' +
                        '</span>';
                    filesContainer.insertAdjacentHTML('afterbegin', divData);
                } 
            });
          })().catch((error) => {
              console.error("Error in script: ", error);
          });

          //|-----------------------------------------------------
          //|HIỆN FILE BÌNH LUẬN
          //|-----------------------------------------------------
          (async () => {
            const qfilecmt = query(
                collection(db, "FILE_DINH_KEM"), 
                where('ND_NHAN_MA', '==', 0),
                where('ND_GUI_MA', '==', 0),
                where('BV_MA', '==', 0),
                where('BL_MA', '!=', 0),
                where('TN_THOIGIANGUI', '==', null)
            );

            const querySnapshotfilecmt = await getDocs(qfilecmt);
            var binhLuanJS = @json($binh_luan_bv);

            querySnapshotfilecmt.forEach((doc) => {

              if (binhLuanJS.includes(doc.data().BL_MA)) {
                const BL_MA = doc.data().BL_MA;
                const filesContainercmt = document.getElementById(`files-container-${BL_MA}`);
                const imagesContainercmt = document.getElementById(`images-container-${BL_MA}`);
                
                const fileName = doc.data().FDK_TEN;
                const fileLink = doc.data().FDK_DUONGDAN;
                const fileExtension = fileName.split('.').pop().toLowerCase();

                if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                    // Image
                    var divData =
                      '<span class="rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block file-item">' +
                      '  <a target="_blank" href="'+fileLink+'" previewlistener="true">' +
                      '    <img src="'+fileLink+'" width="100px" height="100px" alt="'+fileName+'" class="d-block mx-auto">' +
                      '  </a>' +
                      '  <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle file-item-btn bookmark-file" data-fdk-id-value="'+doc.id+'" style="transform: translateX(-50%);">' ;
                    if (fileSaved.includes(doc.id)) divData += '    <i class="fas fa-vote-yea"></i>';
                    else  divData += '    <i class="fas fa-bookmark"></i>';
                    divData += 
                      '  </button>' +
                      '</span>';
                    imagesContainercmt.insertAdjacentHTML('afterbegin', divData);
                }
                else{
                    var divData =
                        '<span class="badge bg-secondary rounded-3 fw-semiboldms-0 p-1 px-3 me-2 text-white file-item">' +    
                        ' <a target="_blank" class="text-white" href="'+fileLink+'">';

                    if (['pdf'].includes(fileExtension)){
                        divData += '    <i class="fas fa-file-pdf fs-5 me-2"></i> ';
                    }
                    else if (['docx', 'doc'].includes(fileExtension)) {
                        divData += '    <i class="fas fa-file-word fs-5 me-2"></i> ';
                    }
                    else if (['xlsx', 'xls'].includes(fileExtension)) {
                        divData += '    <i class="fas fa-file-excel fs-5 me-2"></i> ';
                    }
                    else if (['ppt', 'pptx'].includes(fileExtension)) {
                        divData += '    <i class="fas fa-file-powerpoint fs-5 me-2"></i> ';
                    }
                    else {
                        divData += '    <i class="fas fa-file fs-5 me-2"></i> ';
                    }

                    divData += fileName +
                        ' </a>' +
                        '  <button class="btn btn-secondary btn-sm file-item-btn bookmark-file" data-fdk-id-value="'+doc.id+'">' ;
                    if (fileSaved.includes(doc.id)) divData += '    <i class="fas fa-vote-yea"></i>';
                    else  divData += '    <i class="fas fa-bookmark"></i>';
                    divData += 
                        '  </button>' +
                        '</span>';
                    filesContainercmt.insertAdjacentHTML('afterbegin', divData);
                } 
              }
            });
          })().catch((error) => {
              console.error("Error in script: ", error);
          });

          //|*****************************************************
          //|GỬI COMMENT GỐC START
          //|*****************************************************
          //BIẾN CHO UPLOAD ẢNH
          const fileInput0 = document.getElementById('file-input0');
          const selectedFilesContainer0 = document.getElementById('selected-files-container0');
          const selectedImagesContainer0 = document.getElementById('selected-images-container0');
          var dontUse0 = [];

          $('#reply-btn0').click(function(e) {
              e.preventDefault();

              var form0 = $(this).closest('form');
              var BL_NOIDUNG0 = form0.find('textarea[name="BL_NOIDUNG0"]').val();

              //|-----------------------------------------------------
              //|XỬ LÝ LINK FILE
              //|-----------------------------------------------------
              const replyBtn = document.getElementById('reply-btn0');
              const formComment = document.getElementById('form-comment0');
              var urlFile0 = [];
              var TN_FDK0 = fileInput0.files;

              if(TN_FDK0.length > 0 && TN_FDK0.length > dontUse0.length && BL_NOIDUNG0 != ""){//Gửi có file
                //Cho nút gửi xoay
                replyBtn.classList.add('disabled-mess');
                replyBtn.querySelector('i').classList.remove('fas', 'fa-paper-plane');
                replyBtn.querySelector('i').classList.add('spinner-border', 'spinner-border-sm');

                  (async () => {
                      for (var i = 0; i < TN_FDK0.length; i++) {
                          //console.log("Selected File " + (i) + ": " + TN_FDK[i].name);
                          if (dontUse0.indexOf(i) !== -1) {
                              // console.log(i + " đã tồn tại trong mảng dontUse.");
                              //Không xử lý
                          } else {
                              //console.log(i + " không tồn tại trong mảng dontUse.");
                              const file0 = TN_FDK0[i];
                              
                              //STORAGE---------------------------------------
                              const name0 = `${Date.now()}_${file0.name}`;
                              const folder0 = 'files';
                              const fullPath0 = `${folder0}/${name0}`;

                              //const storageRef = ref(storage, name); //Đường dẫn trực tiếp
                              const storageRef0 = ref(storage, fullPath0);
                              //console.log('file: ',file);

                              await uploadBytes(storageRef0, file0);
                              const downloadURL0 = await getDownloadURL(storageRef0); //Link file để add vào csdl
                              //console.log('Uploaded file:', downloadURL);
                              urlFile0.push({name: name0, link: downloadURL0});
                          }
                      }
                      document.getElementById('linkFileInput0').value = JSON.stringify(urlFile0);
                      
                      selectedFilesContainer0.innerHTML = '';
                      selectedImagesContainer0.innerHTML = '';
                      
                      Upload0 ()
                  })().catch((error) => {
                      console.error('Error uploading file:', error);
                  });
                  //console.log("Xoá: ", dontUse0);
              }
              else if (BL_NOIDUNG0 != ""){ //Gửi không có file
                Upload0 ()
              }
    
              function Upload0 (){

                //|-----------------------------------------------------
                //|GỬI FORM
                //|-----------------------------------------------------
                var BL_TRALOI_MA0 = form0.find('input[name="BL_TRALOI_MA0"]').val();
                var linkFile0 = form0.find('input[name="linkFile0"]').val();
                var _token0 = $('input[name="_token"]').val(); 
                
                /*console.log("BL_NOIDUNG0: ", BL_NOIDUNG0);
                console.log("linkFile0: ", linkFile0);
                console.log("_token0: ", _token0);*/
                $.ajax({
                  url: '{{URL::to('/binh-luan')}}',
                  type: 'POST',
                  data: {
                    BV_MA: <?php echo $BV_MA; ?>,
                    BL_NOIDUNG: BL_NOIDUNG0,
                    BL_TRALOI_MA: BL_TRALOI_MA0,
                    linkFile: linkFile0,
                    _token: _token0 // Include the CSRF token in the data
                  },
                  success: function(response) {
                      $('#reply-form0')[0].reset();
                      replyBtn.classList.remove('disabled-mess');
                      replyBtn.querySelector('i').classList.remove('spinner-border', 'spinner-border-sm');
                      replyBtn.querySelector('i').classList.add('fas', 'fa-paper-plane');

                      window.location.href = '{{URL::to('/bai-dang/'.$BV_MA)}}';
                      //document.getElementById('alert-success').style.display = 'block';
                      //console.log('Thành công');
                  },
                  error: function(error) {
                      // Handle errors here
                      //document.getElementById('alert-danger').style.display = 'block';
                      var divData =
                          '<div class="text-notice text-notice-danger alert alert-danger" id="alert-danger" style="display: none">' +
                          '  Bình luận thất bại!' +
                          '  <i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = \'none\'"></i>' +
                          '</div>';
                      formComment.insertAdjacentHTML('beforebegin', divData);
                      console.log(error);
                  }
                });
              }
          });
          //|*****************************************************
          //|GỬI COMMENT GỐC END
          //|*****************************************************
          //|*****************************************************
          //|UPLOAD FILE COMMENT GỐC START
          //|*****************************************************
          $('#file-input0').on('click', function() {
              $("input[name^='TN_FDK0']").val("");
              dontUse0 = [];
          });
          $('#file-input0').on('change', function() {

              selectedFilesContainer0.innerHTML = '';
              selectedImagesContainer0.innerHTML = '';

              if (fileInput0.files.length > 0) {
                  for (let i = 0; i < fileInput0.files.length; i++) {
                      const file0 = fileInput0.files[i];
                      const fileType0 = file0.type;
                      console.log(file0);
                      // Kiểm tra loại file
                      if (fileType0.startsWith('image/')) {
                          // Image
                          const imageUrl0 = URL.createObjectURL(file0);
                          var divData = 
                              '<span data-value="'+i+'" class="rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block file-item">' +
                              '    <img src="'+imageUrl0+'" width="100px" height="100px" alt="Banner Image" class="d-block mx-auto">' +
                              '    <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle file-item-btn" style="transform: translateX(-50%);"><i class="fas fa-times"></i></button>' +
                              '</span>';
                          selectedImagesContainer0.insertAdjacentHTML('beforeend', divData);
                      } else{
                          var divData = 
                              '<span data-value="'+i+'" class="badge bg-secondary rounded-3 fw-semiboldms-0 p-1 px-3 me-2 mb-2 text-white file-item">';
                          if (fileType0.startsWith('application/pdf')) {// PDF
                              divData += '    <i class="fas fa-file-pdf fs-5 me-2"></i> ';
                          }
                          else if (fileType0.startsWith('application/msword') || fileType0.startsWith('application/vnd.openxmlformats-officedocument.wordprocessingml.document')) { //Word
                              divData += '    <i class="fas fa-file-word fs-5 me-2"></i> ';
                          }
                          else if (fileType0.startsWith('application/vnd.ms-excel') || fileType0.startsWith('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')) {// Excel
                              divData += '    <i class="fas fa-file-excel fs-5 me-2"></i> ';
                          }
                          else if (fileType0.startsWith('application/vnd.ms-powerpoint') || fileType0.startsWith('application/vnd.openxmlformats-officedocument.presentationml.presentation')) {// Powerpoint
                              divData += '    <i class="fas fa-file-powerpoint fs-5 me-2"></i> ';
                          }
                          else{
                              divData += '    <i class="fas fa-file fs-5 me-2"></i> ';
                          }
                              divData += file0.name + 
                              '    <button class="btn btn-secondary btn-sm file-item-btn"><i class="fas fa-times"></i></button>' +
                              '</span>';
                          selectedFilesContainer0.insertAdjacentHTML('beforeend', divData);
                      }
                  }
              }

              $('.file-item-btn').on('click', function() {
                  const fileItem0 = $(this).closest('.file-item');
                  const dataValue0 = fileItem0.data('value');

                  fileItem0.remove();
                  dontUse0.push(dataValue0);

                  // Gán giá trị của mảng vào một input ẩn trong form $dontUseArray = json_decode($request->input('dontUse'));
                  // document.getElementById('dontUseInput').value = JSON.stringify(dontUse);
                  console.log("Xoá " + dataValue0 + ": " + dontUse0);
              });
          });
          //|*****************************************************
          //|UPLOAD FILE COMMENT GỐC END
          //|*****************************************************  

          //-------------------------------------------------------------------------------------------------
          //|-----------------------------------------------------
          //|GỌI FORM REPLY COMMENT
          //|-----------------------------------------------------
          <?php if($userLog){ ?> 
           $('.reply-comment-btn').click(function(e) {
              e.preventDefault();

              //Chỉ 1 form rep comment tồn tại
              $( "#divdata-unique" ).remove();

              var dataValue = $(this).attr('data-comment-id-value');
              var closestReplyComment = $(this).closest('.reply-comment-card')[0];
              var divData = 
                      `<div id="divdata-unique" tabindex="0" class="ms-5 pb-1 pt-3">`+
                      `<form id="reply-form1" class="text-muted d-flex justify-content-start align-items-center pe-3 mt-3">`+
                      `    {{ csrf_field() }}`+
                      `    <textarea name="BL_NOIDUNG1" class="form-control border-secondary ms-3" placeholder="Nhập bình luận" rows="2" style="resize: none;"></textarea>`+
                      `    <label for="file-input1" class="ms-3 text-muted" style="cursor: pointer;">`+
                      `        <i class="fas fa-paperclip"></i>`+
                      `    </label>`+
                      `    <input name="BL_TRALOI_MA1" value="`+dataValue+`" type="number" style="display: none"/>`+
                      `    <input name="TN_FDK1[]" type="file" id="file-input1" style="display: none" multiple accept=".jpg, .jpeg, .png, .doc, .docx, .pdf, .xls, .xlsx, .ppt, .pptx"/>`+
                      `    <input type="hidden" name="linkFile1" id="linkFileInput1" value="">`+
                      `    <button type="button" id="reply-btn1" class="btn text-primary"><i class="fas fa-paper-plane"></i></button>`+
                      `</form>`+
                      `<div id="selected-files-container1" class=" m-2"></div>`+
                      `<div id="selected-images-container1" class="m-2 mb-3 position-relative"></div>`+
                      `</div>`;
              closestReplyComment.insertAdjacentHTML('beforeend', divData);
              $( "#divdata-unique" ).focus();
              //|*****************************************************
              //|GỬI COMMENT REPLY START
              //|*****************************************************
              //BIẾN CHO UPLOAD ẢNH
              const fileInput1 = document.getElementById('file-input1');
              const selectedFilesContainer1 = document.getElementById('selected-files-container1');
              const selectedImagesContainer1 = document.getElementById('selected-images-container1');
              var dontUse1 = [];

              $('#reply-btn1').click(function(e) {
                  e.preventDefault();

                  var form1 = $(this).closest('form');
                  var BL_NOIDUNG1 = form1.find('textarea[name="BL_NOIDUNG1"]').val();

                  //|-----------------------------------------------------
                  //|XỬ LÝ LINK FILE
                  //|-----------------------------------------------------
                  const replyBtn = document.getElementById('reply-btn1');
                  const formComment = document.getElementById('form-comment1');
                  var urlFile1 = [];
                  var TN_FDK1 = fileInput1.files;

                  if(TN_FDK1.length > 0 && TN_FDK1.length > dontUse1.length && BL_NOIDUNG1 != ""){//Gửi có file
                    //Cho nút gửi xoay
                    replyBtn.classList.add('disabled-mess');
                    replyBtn.querySelector('i').classList.remove('fas', 'fa-paper-plane');
                    replyBtn.querySelector('i').classList.add('spinner-border', 'spinner-border-sm');

                      (async () => {
                          for (var i = 0; i < TN_FDK1.length; i++) {
                              //console.log("Selected File " + (i) + ": " + TN_FDK[i].name);
                              if (dontUse1.indexOf(i) !== -1) {
                                  // console.log(i + " đã tồn tại trong mảng dontUse.");
                                  //Không xử lý
                              } else {
                                  //console.log(i + " không tồn tại trong mảng dontUse.");
                                  const file1 = TN_FDK1[i];
                                  
                                  //STORAGE---------------------------------------
                                  const name1 = `${Date.now()}_${file1.name}`;
                                  const folder1 = 'files';
                                  const fullPath1 = `${folder1}/${name1}`;

                                  //const storageRef = ref(storage, name); //Đường dẫn trực tiếp
                                  const storageRef1 = ref(storage, fullPath1);
                                  //console.log('file: ',file);

                                  await uploadBytes(storageRef1, file1);
                                  const downloadURL1 = await getDownloadURL(storageRef1); //Link file để add vào csdl
                                  //console.log('Uploaded file:', downloadURL);
                                  urlFile1.push({name: name1, link: downloadURL1});
                              }
                          }
                          document.getElementById('linkFileInput1').value = JSON.stringify(urlFile1);
                          
                          selectedFilesContainer1.innerHTML = '';
                          selectedImagesContainer1.innerHTML = '';
                          
                          Upload1 ()
                      })().catch((error) => {
                          console.error('Error uploading file:', error);
                      });
                      //console.log("Xoá: ", dontUse1);
                  }
                  else if (BL_NOIDUNG1 != ""){ //Gửi không có file
                    Upload1 ()
                  }
        
                  function Upload1 (){

                    //|-----------------------------------------------------
                    //|GỬI FORM
                    //|-----------------------------------------------------
                    var BL_TRALOI_MA1 = form1.find('input[name="BL_TRALOI_MA1"]').val();
                    var linkFile1 = form1.find('input[name="linkFile1"]').val();
                    var _token1 = $('input[name="_token"]').val(); 
                    
                    /*console.log("BL_NOIDUNG1: ", BL_NOIDUNG1);
                    console.log("linkFile1: ", linkFile1);
                    console.log("_token1: ", _token1);*/
                    $.ajax({
                      url: '{{URL::to('/binh-luan')}}',
                      type: 'POST',
                      data: {
                        BV_MA: <?php echo $BV_MA; ?>,
                        BL_NOIDUNG: BL_NOIDUNG1,
                        BL_TRALOI_MA: BL_TRALOI_MA1,
                        linkFile: linkFile1,
                        _token: _token1 // Include the CSRF token in the data
                      },
                      success: function(response) {
                          $('#reply-form1')[0].reset();
                          replyBtn.classList.remove('disabled-mess');
                          replyBtn.querySelector('i').classList.remove('spinner-border', 'spinner-border-sm');
                          replyBtn.querySelector('i').classList.add('fas', 'fa-paper-plane');

                          window.location.href = '{{URL::to('/bai-dang/'.$BV_MA)}}';
                          //document.getElementById('alert-success').style.display = 'block';
                          //console.log('Thành công');
                      },
                      error: function(error) {
                          // Handle errors here
                          //document.getElementById('alert-danger').style.display = 'block';
                          var divData =
                              '<div class="text-notice text-notice-danger alert alert-danger" id="alert-danger" style="display: none">' +
                              '  Bình luận thất bại!' +
                              '  <i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = \'none\'"></i>' +
                              '</div>';
                          formComment.insertAdjacentHTML('beforeend', divData);
                          console.log(error);
                      }
                    });
                    

                  }
              });
              //|*****************************************************
              //|GỬI COMMENT REPLY END
              //|*****************************************************
              //|*****************************************************
              //|UPLOAD FILE COMMENT REPLY START
              //|*****************************************************
              $('#file-input1').on('click', function() {
                  $("input[name^='TN_FDK1']").val("");
                  dontUse1 = [];
              });
              $('#file-input1').on('change', function() {

                  selectedFilesContainer1.innerHTML = '';
                  selectedImagesContainer1.innerHTML = '';

                  if (fileInput1.files.length > 0) {
                      for (let i = 0; i < fileInput1.files.length; i++) {
                          const file1 = fileInput1.files[i];
                          const fileType1 = file1.type;
                          console.log(file1);
                          // Kiểm tra loại file
                          if (fileType1.startsWith('image/')) {
                              // Image
                              const imageUrl1 = URL.createObjectURL(file1);
                              var divData = 
                                  '<span data-value="'+i+'" class="rounded-3 fw-semibold me-4 p-1 position-relative d-inline-block file-item">' +
                                  '    <img src="'+imageUrl1+'" width="100px" height="100px" alt="Banner Image" class="d-block mx-auto">' +
                                  '    <button class="btn btn-secondary btn-sm position-absolute start-100 translate-middle file-item-btn" style="transform: translateX(-50%);"><i class="fas fa-times"></i></button>' +
                                  '</span>';
                              selectedImagesContainer1.insertAdjacentHTML('beforeend', divData);
                          } else{
                              var divData = 
                                  '<span data-value="'+i+'" class="badge bg-secondary rounded-3 fw-semiboldms-0 p-1 px-3 me-2 mb-2 text-white file-item">';
                              if (fileType1.startsWith('application/pdf')) {// PDF
                                  divData += '    <i class="fas fa-file-pdf fs-5 me-2"></i> ';
                              }
                              else if (fileType1.startsWith('application/msword') || fileType1.startsWith('application/vnd.openxmlformats-officedocument.wordprocessingml.document')) { //Word
                                  divData += '    <i class="fas fa-file-word fs-5 me-2"></i> ';
                              }
                              else if (fileType1.startsWith('application/vnd.ms-excel') || fileType1.startsWith('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')) {// Excel
                                  divData += '    <i class="fas fa-file-excel fs-5 me-2"></i> ';
                              }
                              else if (fileType1.startsWith('application/vnd.ms-powerpoint') || fileType1.startsWith('application/vnd.openxmlformats-officedocument.presentationml.presentation')) {// Powerpoint
                                  divData += '    <i class="fas fa-file-powerpoint fs-5 me-2"></i> ';
                              }
                              else{
                                  divData += '    <i class="fas fa-file fs-5 me-2"></i> ';
                              }
                                  divData += file1.name + 
                                  '    <button class="btn btn-secondary btn-sm file-item-btn"><i class="fas fa-times"></i></button>' +
                                  '</span>';
                              selectedFilesContainer1.insertAdjacentHTML('beforeend', divData);
                          }
                      }
                  }

                  $('.file-item-btn').on('click', function() {
                      const fileItem1 = $(this).closest('.file-item');
                      const dataValue1 = fileItem1.data('value');

                      fileItem1.remove();
                      dontUse1.push(dataValue1);

                      // Gán giá trị của mảng vào một input ẩn trong form $dontUseArray = json_decode($request->input('dontUse'));
                      // document.getElementById('dontUseInput').value = JSON.stringify(dontUse);
                      console.log("Xoá " + dataValue1 + ": " + dontUse1);
                  });
              });
              //|*****************************************************
              //|UPLOAD FILE COMMENT REPLY END
              //|*****************************************************  

            });
          <?php } ?>

          //|-----------------------------------------------------
          //|FOCUS BÌNH LUẬN NẾU CO
          //|-----------------------------------------------------
          <?php 
            $BL_MA_Focus = Session::get('BL_MA_Focus');
            if($BL_MA_Focus) { 
          ?>
              var commentIdValue = <?php echo $BL_MA_Focus ?>;
              
              var divToFocus = document.querySelector(`div[data-comment-id-value="${commentIdValue}"]`);
              //console.log("focus:", divToFocus)
              if (divToFocus) {
                  divToFocus.style.background = 'linear-gradient(to right, #ffffff00, #ffff0038, #ffff0038, #ffffff00)';
                  divToFocus.tabIndex = 0;
                  divToFocus.scrollIntoView({
                      behavior: 'smooth',
                      block: 'center', // Hoặc 'center', 'end', 'nearest'
                  });
              }
          <?php 
              Session::put('BL_MA_Focus',null);
            } 
          ?>

          //|*****************************************************
          //|LƯU FILE START
          //|*****************************************************
          <?php if($userLog) { ?>
            $(document).on('click', '.bookmark-file', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var FDK_MA = $(this).data('fdk-id-value');
                var _token = $('meta[name="csrf-token"]').attr('content');
                const iconElement = $(this).find('i');
                iconElement.removeClass('fa fa-bookmark');
                iconElement.removeClass('fa fa-vote-yea');
                iconElement.removeClass('fa-exclamation-circle text-danger');
                iconElement.addClass('spinner-border text-light spinner-border-sm');

                (async () => {
                    const qbookmarkfile = query(
                    collection(db, "DANH_DAU_FILE"), 
                    where('FDK_MA', '==', FDK_MA),
                    where('ND_MA', '==', <?php echo $userLog->ND_MA; ?>)
                    );
                    
                    const querySnapshotbookmarkfile = await getDocs(qbookmarkfile);
                    
                    if (querySnapshotbookmarkfile.empty) {
                        //Lưu file
                        $.ajax({
                          url: '{{URL::to('/danh-dau-file')}}',
                          type: 'POST',
                          data: {
                            FDK_MA: FDK_MA,
                            _token: _token // Include the CSRF token in the data
                          },
                          success: function(response) {
                              iconElement.removeClass('spinner-border text-light spinner-border-sm');
                              iconElement.addClass('fa-vote-yea');
                              //console.log('Thành công');
                          },
                          error: function(error) {
                              iconElement.removeClass('spinner-border text-light spinner-border-sm');
                              iconElement.addClass('fa-exclamation-circle text-danger');
                              console.log(error);
                          }
                        });
                    }
                    else{
                      //Xoá file
                      querySnapshotbookmarkfile.forEach((doc2) => {
                         (async () => {
                            await deleteDoc(doc(db, "DANH_DAU_FILE", doc2.id));

                            iconElement.removeClass('spinner-border text-light spinner-border-sm');
                                iconElement.addClass('fa-bookmark');
                        })().catch((error) => {
                            iconElement.removeClass('spinner-border text-light spinner-border-sm');
                            iconElement.addClass('fa-exclamation-circle text-danger');
                            console.error("Error in delete script: ", error);
                        });
                      });
                    }
                })().catch((error) => {
                    console.error("Error in script: ", error);
                });
                // Thực hiện các xử lý khác với tham số đã truyền
                //console.log("Additional Parameter: " + FDK_MA);
            });
          <?php } ?>
          //|*****************************************************
          //|LƯU FILE END
          //|*****************************************************
          //|*****************************************************
          //|LƯU BÀI VIẾT START
          //|*****************************************************
          <?php if($userLog) { ?>
            $(document).on('click', '.bookmark-post', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var $element = $(this);
                var BV_MA = $(this).data('post-id-value');
                //var _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                  url: '{{URL::to('/luu-bai-dang/')}}' +'/'+ BV_MA,
                  type: 'GET',
                  success: function(response) {
                    $element.removeClass('bookmark-post');
                    $element.addClass('unbookmark-post');

                    $element.empty();
                    $element.html(`<i class="fas fa-vote-yea"></i> Đã lưu`);
                    //console.log(number);
                  },
                  error: function(error) {
                    console.log(error);
                  }
                });
                    
            });
            $(document).on('click', '.unbookmark-post', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var $element = $(this);
                var BV_MA = $(this).data('post-id-value');
                //var _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                  url: '{{URL::to('/huy-luu-bai-dang/')}}' +'/'+ BV_MA,
                  type: 'GET',
                  success: function(response) {
                    $element.removeClass('unbookmark-post');
                    $element.addClass('bookmark-post');

                    $element.empty();
                    $element.html(`<i class="fas fa-bookmark"></i> Lưu`);
                    //console.log(number);
                  },
                  error: function(error) {
                    console.log(error);
                  }
                });
                    
            });
          <?php } ?>
          //|*****************************************************
          //|LƯU BÀI VIẾT END
          //|*****************************************************
          //|*****************************************************
          //|LƯU BÌNH LUẬN START
          //|*****************************************************
          <?php if($userLog) { ?>
            $(document).on('click', '.bookmark-comment', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var $element = $(this);
                var BL_MA = $(this).data('comment-id-value');
                //var _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                  url: '{{URL::to('/luu-binh-luan/')}}' +'/'+ BL_MA,
                  type: 'GET',
                  success: function(response) {
                    $element.removeClass('bookmark-comment');
                    $element.addClass('unbookmark-comment');

                    $element.empty();
                    $element.html(`<i class="fas fa-vote-yea"></i> Đã lưu`);
                    //console.log(number);
                  },
                  error: function(error) {
                    console.log(error);
                  }
                });
                    
            });
            $(document).on('click', '.unbookmark-comment', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var $element = $(this);
                var BL_MA = $(this).data('comment-id-value');
                //var _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                  url: '{{URL::to('/huy-luu-binh-luan/')}}' +'/'+ BL_MA,
                  type: 'GET',
                  success: function(response) {
                    $element.removeClass('unbookmark-comment');
                    $element.addClass('bookmark-comment');

                    $element.empty();
                    $element.html(`<i class="fas fa-bookmark"></i> Lưu`);
                    //console.log(number);
                  },
                  error: function(error) {
                    console.log(error);
                  }
                });
                    
            });
          <?php } ?>
          //|*****************************************************
          //|LƯU BÌNH LUẬN END
          //|*****************************************************

          //|*****************************************************
          //|LIKE BÀI VIẾT START
          //|*****************************************************
          <?php if($userLog) { ?>
            $(document).on('click', '.like-post', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var $element = $(this);
                var number = $element.find('b').text();
                var BV_MA = $(this).data('post-id-value');
                //var _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                  url: '{{URL::to('/thich-bai-dang/')}}' +'/'+ BV_MA,
                  type: 'GET',
                  success: function(response) {
                    $element.removeClass('text-muted like-post');
                    $element.addClass('text-danger unlike-post');

                    number = parseInt(number) + 1;
                    $element.find('b').text(number);
                    //console.log(number);
                  },
                  error: function(error) {
                    console.log(error);
                  }
                });
                    
            });
            $(document).on('click', '.unlike-post', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var $element = $(this);
                var number = $element.find('b').text();
                var BV_MA = $(this).data('post-id-value');
                //var _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                  url: '{{URL::to('/huy-thich-bai-dang/')}}' +'/'+ BV_MA,
                  type: 'GET',
                  success: function(response) {
                    $element.removeClass('text-danger unlike-post');
                    $element.addClass('text-muted like-post');

                    number = parseInt(number) - 1;
                    $element.find('b').text(number);
                    //console.log(number);
                  },
                  error: function(error) {
                    console.log(error);
                  }
                });
                    
            });
          <?php } ?>
          //|*****************************************************
          //|LIKE BÀI VIẾT END
          //|*****************************************************
          //|*****************************************************
          //|LIKE BÌNH LUẬN START
          //|*****************************************************
          <?php if($userLog) { ?>
            $(document).on('click', '.like-comment', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var $element = $(this);
                var number = $element.find('b').text();
                var BL_MA = $(this).data('comment-id-value');
                //var _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                  url: '{{URL::to('/thich-binh-luan/')}}' +'/'+ BL_MA,
                  type: 'GET',
                  success: function(response) {
                    $element.removeClass('text-muted like-comment');
                    $element.addClass('text-danger unlike-comment');

                    number = parseInt(number) + 1;
                    $element.find('b').text(number);
                    //console.log(number);
                  },
                  error: function(error) {
                    console.log(error);
                  }
                });
                    
            });
            $(document).on('click', '.unlike-comment', function() {
                // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                var $element = $(this);
                var number = $element.find('b').text();
                var BL_MA = $(this).data('comment-id-value');
                //var _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                  url: '{{URL::to('/huy-thich-binh-luan/')}}' +'/'+ BL_MA,
                  type: 'GET',
                  success: function(response) {
                    $element.removeClass('text-danger unlike-comment');
                    $element.addClass('text-muted like-comment');

                    number = parseInt(number) - 1;
                    $element.find('b').text(number);
                    //console.log(number);
                  },
                  error: function(error) {
                    console.log(error);
                  }
                });
                    
            });
          <?php } ?>
          //|*****************************************************
          //|LIKE BÌNH LUẬN END
          //|*****************************************************

          //|*****************************************************
          //|REPORT BÀI VIẾT START
          //|*****************************************************
          <?php if($userLog) { ?>
            $(document).on('click', '.report-post', function() {
              var BVBC_NOIDUNG;

              while (true) {
                  BVBC_NOIDUNG = prompt("Nội dung báo cáo:");

                  if (BVBC_NOIDUNG !== null && BVBC_NOIDUNG.trim() !== "") {
                      //Báo cáo hơp lệ có nội dung
                      //console.log("Giá trị đã nhập: " + BVBC_NOIDUNG);
                      // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                      var $element = $(this);
                      var BV_MA = $(this).data('post-id-value');
                      var _token = $('meta[name="csrf-token"]').attr('content');

                      $.ajax({
                        url: '{{URL::to('/bao-cao-bai-dang/')}}' +'/'+ BV_MA,
                        type: 'POST',
                        data: {
                          BVBC_NOIDUNG: BVBC_NOIDUNG,
                          _token: _token // Include the CSRF token in the data
                        },
                        success: function(response) {
                          window.location.href = '{{URL::to('/trang-chu')}}';
                          //console.log(number);
                        },
                        error: function(error) {
                          console.log(error);
                        }
                      });
                      break;
                  } else if (BVBC_NOIDUNG === null) {
                      //console.log("Người dùng đã hủy.");
                      break;
                  } else {
                      alert("Vui lòng nhập nội dung báo cáo!"); 
                  }
              }
            });
          <?php } ?>
          //|*****************************************************
          //|REPORT BÀI VIẾT END
          //|*****************************************************
          //|*****************************************************
          //|REPORT BÌNH LUẬN START
          //|*****************************************************
          <?php if($userLog) { ?>
            $(document).on('click', '.report-comment', function() {
              var BLBC_NOIDUNG;

              while (true) {
                  BLBC_NOIDUNG = prompt("Nội dung báo cáo:");

                  if (BLBC_NOIDUNG !== null && BLBC_NOIDUNG.trim() !== "") {
                      //Báo cáo hơp lệ có nội dung
                      //console.log("Giá trị đã nhập: " + BLBC_NOIDUNG);
                      // Truy cập giá trị của tham số từ thuộc tính dữ liệu
                      var $element = $(this);
                      var BL_MA = $(this).data('comment-id-value');
                      var _token = $('meta[name="csrf-token"]').attr('content');

                      $.ajax({
                        url: '{{URL::to('/bao-cao-binh-luan/')}}' +'/'+ BL_MA,
                        type: 'POST',
                        data: {
                          BLBC_NOIDUNG: BLBC_NOIDUNG,
                          _token: _token // Include the CSRF token in the data
                        },
                        success: function(response) {
                          window.location.href = '{{URL::to('/bai-dang/'.$BV_MA)}}';
                          //console.log(number);
                        },
                        error: function(error) {
                          console.log(error);
                        }
                      });
                      break;
                  } else if (BLBC_NOIDUNG === null) {
                      //console.log("Người dùng đã hủy.");
                      break;
                  } else {
                      alert("Vui lòng nhập nội dung báo cáo!"); 
                  }
              }
            });
          <?php } ?>
          //|*****************************************************
          //|REPORT BÌNH LUẬN END
          //|*****************************************************
        });
    </script>
@endsection