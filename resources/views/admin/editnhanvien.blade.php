@extends('admin.layout')
@section('title')
Chỉnh sửa thông tin nhân viên | Quản trị Admin
@endsection
@section('title2')
Sửa thông tin nhân viên
@endsection
@section('content')
<!-- Main CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('admin/doc/css/main.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
<!-- or -->
<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
<!-- Font-icon css-->
<link rel="stylesheet" type="text/css"
  href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
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

        <h3 class="tile-title">Sửa thông tin nhân viên</h3>
        <div class="tile-body">
          <form class="row" action="{{route('admin.nhanvien.update',$user->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group col-md-4">
              <label class="control-label">Họ và tên</label>
              <input class="form-control" name="Fullname" type="text" required value="{{$user->Fullname}}">
            </div>
            @error('Fullname')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="form-group col-md-4">
              <label class="control-label">Địa chỉ email</label>
              <input class="form-control" name="email" type="email" required value="{{$user->email}}">
            </div>
            @error('email')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="form-group col-md-4">
              <label class="control-label">Địa chỉ thường trú</label>
              <input class="form-control" name="address" type="text" required value="{{$user->address}}">
            </div>
            @error('address')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="form-group  col-md-4">
              <label class="control-label">Số điện thoại</label>
              <input class="form-control" name="Phone_number" type="text" required value="{{$user->Phone_number}}">
            </div>
            @error('Phone_number')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="form-group  col-md-4">
                <label class="control-label">Mật khẩu</label>
                <input class="form-control" name="password" type="password" required >
            </div>
            @error('password')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="form-group col-md-3">
              <label class="control-label">Giới tính</label>
              <select name="gender" class="form-control" id="exampleSelect2" required>
                <option>-- Chọn giới tính --</option>
                <option @if ($user->gender == 1)
                    selected
                @endif value="1">Nam</option>
                <option @if ($user->gender == 2)
                    selected
                @endif value="2">Nữ</option>
              </select>
            </div>
            @error('gender')
                <span class="text-danger">{{$message}}</span>
            @enderror
            @if (session('user.role') === 'admin')
            <div class="form-group  col-md-3">
                <label for="exampleSelect1" class="control-label">Chức vụ</label>
                <select class="form-control" name="Role_id" id="exampleSelect1">
                  <option>-- Chọn chức vụ --</option>
                  @foreach ($listRole as $role)
                    <option
                    @if ($user->Role_id == $role->id)
                        selected
                    @endif
                    value="{{$role->id}}">{{$role->name}}</option>
                  @endforeach
                </select>
            </div>
            @else
            <div class="form-group  col-md-3">
                <label for="exampleSelect1" class="control-label">Chức vụ</label>
                <select class="form-control" name="Role_id" id="exampleSelect1">
                  <option>-- Chọn chức vụ --</option>
                  @foreach ($listRole as $role)
                    @if ($role->name == 'admin')
                    <option
                    @if ($user->Role_id == $role->id)
                        selected
                    @endif
                    disabled value="{{$role->id}}">{{$role->name}}</option>
                    @elseif ($role->name == 'user')

                    @else
                    <option
                    @if ($user->Role_id == $role->id)
                        selected
                    @endif
                    selected value="{{$role->id}}">{{$role->name}}</option>
                    @endif
                  @endforeach
                </select>
            </div>
            @endif
            @error('Role_id')
                <span class="text-danger">{{$message}}</span>
            @enderror


            <div class="form-group col-md-12">
              <label class="control-label">Ảnh 3x4 nhân viên</label>
              <div id="myfileupload">
                <input type="file" id="uploadfile" name="avatar" onchange="readURL(this);" />
              </div>
              <div id="thumbbox">
                <img height="200" width="200" alt="Thumb image" id="thumbimage" style="display: none" />
                <a class="removeimg" href="javascript:"></a>
              </div>
              <div id="boxchoice">
                <a href="javascript:" class="Choicefile"><i class='bx bx-upload'></i></a>
                <p style="clear:both"></p>
              </div>

            </div>
            @error('avatar')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <button class="btn btn-save" type="submit">Lưu lại</button>
            <a class="btn btn-cancel" href="{{route('admin.nhanvien')}}">Hủy bỏ</a>

          </form>
        </div>

      </div>

</main>


<!--
MODAL
-->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-body">
        <div class="row">
          <div class="form-group  col-md-12">
            <span class="thong-tin-thanh-toan">
              <h5>Tạo chức vụ mới</h5>
            </span>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">Nhập tên chức vụ mới</label>
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


<!-- Essential javascripts for application to work-->
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{{asset('js/plugins/pace.min.js')}}"></script>
@endsection
