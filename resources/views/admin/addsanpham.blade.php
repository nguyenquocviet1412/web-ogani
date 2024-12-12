@extends('admin.layout')
@section('title')
Thêm sản phẩm | Quản trị Admin
@endsection
@section('title2')
Thêm sản phẩm
@endsection
@section('content')

<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
  <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
  <script>

    function readURL(input, thumbimage) {
      if (input.files && input.files[0]) { //Sử dụng  cho Firefox - chrome
        var reader = new FileReader();
        reader.onload = function (e) {
          $("#thumbimage").attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
      else { // Sử dụng cho IE
        $("#thumbimage").attr('src', input.value);

      }
      $("#thumbimage").show();
      $('.filename').text($("#uploadfile").val());
      $('.Choicefile').css('background', '#14142B');
      $('.Choicefile').css('cursor', 'default');
      $(".removeimg").show();
      $(".Choicefile").unbind('click');

    }
    $(document).ready(function () {
      $(".Choicefile").bind('click', function () {
        $("#uploadfile").click();

      });
      $(".removeimg").click(function () {
        $("#thumbimage").attr('src', '').hide();
        $("#myfileupload").html('<input type="file" id="uploadfile"  onchange="readURL(this);" />');
        $(".removeimg").hide();
        $(".Choicefile").bind('click', function () {
          $("#uploadfile").click();
        });
        $('.Choicefile').css('background', '#14142B');
        $('.Choicefile').css('cursor', 'pointer');
        $(".filename").text("");
      });
    })
  </script>
<style>
    .Choicefile {
      display: block;
      background: #14142B;
      border: 1px solid #fff;
      color: #fff;
      width: 150px;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
      padding: 5px 0px;
      border-radius: 5px;
      font-weight: 500;
      align-items: center;
      justify-content: center;
    }

    .Choicefile:hover {
      text-decoration: none;
      color: white;
    }

    #uploadfile,
    .removeimg {
      display: none;
    }

    #thumbbox {
      position: relative;
      width: 100%;
      margin-bottom: 20px;
    }

    .removeimg {
      height: 25px;
      position: absolute;
      background-repeat: no-repeat;
      top: 5px;
      left: 5px;
      background-size: 25px;
      width: 25px;
      /* border: 3px solid red; */
      border-radius: 50%;

    }

    .removeimg::before {
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
      content: '';
      border: 1px solid red;
      background: red;
      text-align: center;
      display: block;
      margin-top: 11px;
      transform: rotate(45deg);
    }

    .removeimg::after {
      /* color: #FFF; */
      /* background-color: #DC403B; */
      content: '';
      background: red;
      border: 1px solid red;
      text-align: center;
      display: block;
      transform: rotate(-45deg);
      margin-top: -2px;
    }
  </style>


<div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Tạo mới sản phẩm</h3>
        <div class="tile-body">
          <div class="row element-button">
            <div class="col-sm-2">
              <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#exampleModalCenter"><i
                  class="fas fa-folder-plus"></i> Thêm xuất xứ</a>
            </div>
            <div class="col-sm-2">
              <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#adddanhmuc"><i
                  class="fas fa-folder-plus"></i> Thêm danh mục</a>
            </div>
          </div>
          <form class="row" action="{{route('admin.sanpham.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-3">
              <label class="control-label">Tên sản phẩm</label>
              <input class="form-control" name="name" type="text">
            </div>


            <div class="form-group  col-md-3">
              <label class="control-label">Số lượng</label>
              <input class="form-control" name="quantity" type="number">
            </div>
            <div class="form-group col-md-3">
              <label for="exampleSelect1" class="control-label">Danh mục</label>
              <select class="form-control" name="category_id" id="exampleSelect1">
                <option>-- Chọn danh mục --</option>
                @foreach ($listCategories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach

              </select>
            </div>
            <div class="form-group col-md-3 ">
              <label for="exampleSelect1" class="control-label">Xuất xứ</label>
              <select class="form-control" name="origin_id" id="exampleSelect1">
                <option>-- Chọn xuất xứ --</option>
                @foreach ($listOrigins as $origin)
                    <option value="{{$origin->id}}">{{$origin->name}}</option>
                @endforeach
            </select>
            </div>
            <div class="form-group col-md-3">
              <label class="control-label">Giá bán</label>
              <input class="form-control" name="price" type="number" step="0.1">
            </div>
            <div class="form-group col-md-12">
              <label class="control-label">Ảnh sản phẩm</label>
              <div id="myfileupload">
                <input type="file" name="image" id="uploadfile" name="ImageUpload" onchange="readURL(this);" />
              </div>
              <div id="thumbbox">
                <img height="450" width="400" alt="Thumb image" id="thumbimage" style="display: none" />
                <a class="removeimg" href="javascript:"></a>
              </div>
              <div id="boxchoice">
                <a href="javascript:" class="Choicefile"><i class="fas fa-cloud-upload-alt"></i> Chọn ảnh</a>
                <p style="clear:both"></p>
              </div>

            </div>
            <div class="form-group col-md-12">
              <label class="control-label">Mô tả sản phẩm</label>
              <textarea class="form-control" name="description" id="description"></textarea>
              <script>CKEDITOR.replace('description');</script>
            </div>
            <button class="btn btn-save" type="submit">Lưu lại</button>
            <a class="btn btn-cancel" href="{{route('admin.sanpham')}}">Hủy bỏ</a>
          </form>

        </div>

      </div>
</main>


<!--
MODAL XUẤT XỨ
-->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-body">
        <div class="">
          <div class="form-group  col-md-12">
            <span class="thong-tin-thanh-toan">
              <h5>Thêm mới xuất xứ</h5>
            </span>
          </div>
          <form id="addOriginForm" action="{{route('admin.xuatxu.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-12">
                <label class="control-label">Nhập xuất xứ</label>
                <input class="form-control" name="name" type="text" required>
            </div>
            <button class="btn btn-save" type="submit">Lưu lại</button>
            <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
          </form>
          <!-- Hiển thị thông báo -->
          <div id="successMessageOrigin" style="display: none; color: green;"></div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $('#addOriginForm').on('submit', function(event) {
    event.preventDefault(); // Ngăn chặn form gửi yêu cầu theo cách truyền thống

    $.ajax({
        url: "{{ route('admin.xuatxu.store') }}",
        type: "POST",
        data: $(this).serialize(), // Lấy toàn bộ dữ liệu từ form
        success: function(response) {
            if (response.success) {
                $('#successMessageOrigin').text(response.message).show();

                // Reset form sau khi thêm thành công
                $('#addOriginForm')[0].reset();

                // Thêm xuất xứ vào danh sách nếu cần (tùy theo logic của bạn)
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
});

</script>
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!--
MODAL
-->



<!--
MODAL DANH MỤC
-->
<div class="modal fade" id="adddanhmuc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-body">
        <div class="row">
          <div class="form-group  col-md-12">
            <span class="thong-tin-thanh-toan">
              <h5>Thêm mới danh mục </h5>
            </span>
          </div>
          <form id="addCategoryForm" action="{{route('admin.danhmuc.store')}}" method="POST">
            @csrf
            <div class="form-group col-md-12">
                <label class="control-label">Nhập tên danh mục mới</label>
                <input class="form-control" name="name" type="text" required>
            </div>
            <div class="form-group col-md-12">
                <label class="control-label">Danh mục sản phẩm hiện đang có</label>
                <ul style="padding-left: 20px;">
                    @foreach ($listCategories as $category)
                    <li>{{$category->name}}</li>
                    @endforeach
                </ul>
            </div>
            <BR>
            <button class="btn btn-save" type="submit">Lưu lại</button>
            <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
            <BR>
          </form>
<!-- Hiển thị thông báo -->
<div id="successMessageCategory" style="display: none; color: green;"></div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $('#addCategoryForm').on('submit', function(event) {
    event.preventDefault(); // Ngăn chặn form gửi yêu cầu theo cách truyền thống

    $.ajax({
        url: "{{ route('admin.danhmuc.store') }}",
        type: "POST",
        data: $(this).serialize(), // Lấy toàn bộ dữ liệu từ form
        success: function(response) {
            if (response.success) {
                $('#successMessageCategory').text(response.message1).show();

                // Reset form sau khi thêm thành công
                $('#addCategoryForm')[0].reset();

                // Thêm danh mục vào danh sách nếu cần
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
});

</script>

        </div>

      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!--
MODAL
-->




<!--
MODAL TÌNH TRẠNG
-->
<div class="modal fade" id="addtinhtrang" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-body">
        <div class="row">
          <div class="form-group  col-md-12">
            <span class="thong-tin-thanh-toan">
              <h5>Thêm mới tình trạng</h5>
            </span>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">Nhập tình trạng mới</label>
            <input class="form-control" type="text" required>
          </div>
        </div>
        <BR>
        <button class="btn btn-save" type="button">Lưu lại</button>
        <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
        <BR>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!--
MODAL
-->



<script src="{{asset('admin/doc/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('admin/doc/js/popper.min.js')}}"></script>
<script src="{{asset('admin/doc/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/doc/js/main.js')}}"></script>
<script src="{{asset('admin/doc/js/plugins/pace.min.js')}}"></script>
<script>
  const inpFile = document.getElementById("inpFile");
  const loadFile = document.getElementById("loadFile");
  const previewContainer = document.getElementById("imagePreview");
  const previewContainer = document.getElementById("imagePreview");
  const previewImage = previewContainer.querySelector(".image-preview__image");
  const previewDefaultText = previewContainer.querySelector(".image-preview__default-text");
  inpFile.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      previewDefaultText.style.display = "none";
      previewImage.style.display = "block";
      reader.addEventListener("load", function () {
        previewImage.setAttribute("src", this.result);
      });
      reader.readAsDataURL(file);
    }
  });

</script>
@endsection
