@extends('welcome')
@section('content')
<?php $userLog= Session::get('userLog'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div>
            <h5 class="card-title fw-semibold pb-2">Cập nhật tài khoản cá nhân</h5>
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
          <div class="text-notice text-notice-danger alert alert-danger" id="alert-danger" style="display: none">
            Cập nhật thất bại!
            <i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = 'none'"></i>
          </div>
          <hr>
          <div class="card">
            <div class="card-body p-4">
              @foreach($account_info as $key => $account_info)
              <?php $userAcc = $account_info->ND_MA ?>
                <div class="position-center input-form">
                    <form role="form" action="{{URL::to('/tai-khoan/'.$userAcc)}}" method="post" enctype= "multipart/form-data" id="form">
                        {{ csrf_field() }}
                        <div class="form-group text-center">
                            <label><b>Ảnh đại diện:</b></label>
                            <input type="hidden" name="ND_ANHDAIDIENshow" disabled value="<?php if($account_info->ND_ANHDAIDIEN) echo $account_info->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'?>" class="form-control">

                            <style>
                                #file-input {
                                  display: none;
                                }

                                .circle {
                                  display: flex;
                                  justify-content: center;
                                  align-items: center;
                                  height: 200px;
                                  width: 200px;
                                  border-radius: 50%;
                                  border: 3px solid white;
                                  font-size: 60px;
                                  font-weight: bold;
                                  color: black;
                                  cursor: pointer;
                                }

                                .circle:hover {
                                  background-color: #f2f2f2;
                                }
                            </style>
                        
                            <div class="container" style="height: 200px;">
                                <label for="file-input" >
                                    <img class="circle" src="<?php if($account_info->ND_ANHDAIDIEN) echo $account_info->ND_ANHDAIDIEN; else echo 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'?>" id="img-preview" src="" alt="Image Preview">
                                    <input type="file" name="ND_ANHDAIDIEN" class="form-control" id="file-input">
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label><b>Họ tên:</b> <span class="text-danger">(*)</span>:</label>
                            <input type="text" name="ND_HOTEN" value="{{$account_info->ND_HOTEN}}" class="form-control" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label><b>Email:</b> <span class="text-danger">(*)</span>:</label>
                            <input type="text" name="ND_EMAIL" value="{{$account_info->ND_EMAIL}}" class="form-control" required=""  pattern="/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/">
                        </div> 
                        <div class="form-group mb-3">
                            <label><b>Mô tả:</b></label>
                            <textarea class="form-control mb-3" rows="5" id="comment" name="ND_MOTA"
                            placeholder="Nhập mô tả bản thân..." id="desc">{{$account_info->ND_MOTA}}</textarea>
                        </div> 
                        <button type="button" style="width: 100%; display: none" class="btn btn-primary" id="submit-form">Lưu cập nhật</button>
                        <div id="spinner" class="spinner-border text-primary" style="display: none;"></div>
                    </form>
                    <button type="button" style="width: 100%;" class="btn btn-primary" id="non-disabled">Cập nhật thông tin</button>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>


  <!-- MAIN START-->
  <script type="module">
    //|-----------------------------------------------------
    //|KHAI BÁO FIRESTORE
    //|-----------------------------------------------------
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getFirestore, setDoc, addDoc, doc, collection, serverTimestamp, getDocs, query, where, orderBy, limit, or, onSnapshot, updateDoc } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";
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

    //BIẾN CHO UPLOAD ẢNH

    $(document).ready(function() {

      //|*****************************************************
      //|XỬ LÝ GIAO DIỆN START
      //|*****************************************************
      // DISABLE FORM
        var formEdit = document.getElementById('form');
        var elements = formEdit.elements;
        for (var i = 0; i < elements.length; i++) {
            elements[i].disabled = true;
        }

      //NGƯNG DISABLE FORM
        $('#non-disabled').click(function(e) {
            e.preventDefault();

            for (var i = 0; i < elements.length; i++) {
                elements[i].disabled = false;
            }
            
            $('#non-disabled').hide();
            $('#submit-form').show();
        });

      //AVATAR
        const fileInputAva = document.getElementById('file-input');
        const imgPreview = document.getElementById('img-preview');

        fileInputAva.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.addEventListener('load', (event) => {
            imgPreview.src = event.target.result;
        });

        reader.readAsDataURL(file);
        }); 
      //|*****************************************************
      //|XỬ LÝ GIAO DIỆN END
      //|*****************************************************
      //|*****************************************************
      //|UPLOAD FILE START
      //|*****************************************************
      $('#submit-form').click(function(e) {
          e.preventDefault();
          var form = $(this).closest('form');
          var ND_HOTEN = form.find('input[name="ND_HOTEN"]').val();
          var ND_EMAIL = form.find('input[name="ND_EMAIL"]').val();
          var ND_ANHDAIDIEN = form.find('input[name="ND_ANHDAIDIEN"]').val();
          var ND_MOTA = form.find('textarea[name="ND_MOTA"]').val();
          var _token = $('input[name="_token"]').val();

          form.find('input[name="ND_HOTEN"]').css('border-color', '');
          form.find('input[name="ND_EMAIL"]').css('border-color', '');

          if(ND_HOTEN == ""){
            form.find('input[name="ND_HOTEN"]').css('border-color', '#FA896B');
          }
          else if(ND_EMAIL == ""){
            form.find('input[name="ND_EMAIL"]').css('border-color', '#FA896B');
          }
          else{
            //|-----------------------------------------------------
            //|XỬ LÝ LINK FILE
            //|-----------------------------------------------------
            //Cho nút gửi xoay
            document.getElementById('submit-form').style.display = 'none';
            document.getElementById('spinner').style.display = 'block';

            if(ND_ANHDAIDIEN != ""){//Gửi có file
                (async () => {
                    //STORAGE---------------------------------------
                    const fileInput = document.querySelector('#file-input');
                    const file = fileInput.files[0];
                    const fileName = file.name;
                    const fileExtension = fileName.slice((fileName.lastIndexOf(".") - 1 >>> 0) + 2);

                    const name = `${Date.now()}_user<?php echo $userAcc ?>.${fileExtension}`;
                    const folder = 'users';
                    const fullPath = `${folder}/${name}`;

                    const storageRef = ref(storage, fullPath);
                    //console.log('file: ',file);

                    await uploadBytes(storageRef, file);
                    const downloadURL = await getDownloadURL(storageRef); //Link file để add vào csdl
                    //console.log('Uploaded file:', downloadURL);
                    
                    $('input[name="ND_ANHDAIDIEN"]').val("");
                    UpdateAndForm (downloadURL);
                })().catch((error) => {
                    console.error('Error uploading file:', error);
                });
                //console.log("Xoá: ", dontUse);
            }
            else{ //Gửi không có file
              UpdateAndForm ('');
            }
  
            function UpdateAndForm (downloadURL){
              //|-----------------------------------------------------
              //|GỬI FORM
              //|-----------------------------------------------------
              /*console.log(ND_HOTEN);
              console.log(ND_EMAIL);
              console.log(ND_MOTA);
              console.log(ND_ANHDAIDIEN);
              console.log(name);
              console.log(downloadURL);*/
              
              $.ajax({
                url: '{{URL::to('/tai-khoan/'.$userAcc)}}',
                type: 'PUT',
                data: {
                  ND_HOTEN: ND_HOTEN,
                  ND_EMAIL: ND_EMAIL,
                  ND_MOTA: ND_MOTA,
                  downloadURL: downloadURL,
                  _token: _token // Include the CSRF token in the data
                },
                success: function(response) {
                    $('#form')[0].reset();
                    for (var i = 0; i < elements.length; i++) {
                        elements[i].disabled = true;
                    }
                    
                    $('#non-disabled').show();
                    $('#submit-form').hide();
                    $('#spinner').hide();

                    form.find('input[name="ND_HOTEN"]').css('border-color', '');
                    form.find('input[name="ND_EMAIL"]').css('border-color', '');
                    //console.log('Thành công');
                    window.location.href = '{{URL::to('/tai-khoan/'.$userAcc.'/edit')}}';
                },
                error: function(error) {
                    // Handle errors here
                    $('#form')[0].reset();
                    for (var i = 0; i < elements.length; i++) {
                        elements[i].disabled = true;
                    }
                    
                    $('#non-disabled').show();
                    $('#submit-form').hide();
                    $('#spinner').hide();

                    form.find('input[name="ND_HOTEN"]').css('border-color', '');
                    form.find('input[name="ND_EMAIL"]').css('border-color', '');

                    document.getElementById('alert-danger').style.display = 'block';
                    console.log(error);
                }
              });

            }
          }
      });
      //|*****************************************************
      //|UPLOAD FILE END
      //|***************************************************** 
    });
  </script>
  <!--MIN END-->
@endsection