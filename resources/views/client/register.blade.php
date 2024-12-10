@extends('client.layout')
@section('content')

  <title>Đăng ký</title>



    <style>
        body {
  background-color: #f5f5f5;
}

.nav-tabs .nav-link {
  color: #555;
  border: none;
}

.nav-tabs .nav-link.active {
  color: #e91e63;
  border-bottom: 2px solid #e91e63;
}

.btn-outline-primary {
  border-color: #3b5998;
  color: #3b5998;
}

.btn-outline-primary:hover {
  background: #3b5998;
  color: #fff;
}

.btn-outline-danger {
  border-color: #db4437;
  color: #db4437;
}

.btn-outline-danger:hover {
  background: #db4437;
  color: #fff;
}

    </style>
  <div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100 shadow rounded overflow-hidden" style="max-width: 900px;">
      <!-- Left Section -->
      <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center bg-light">
        <img src="groceries.jpg" alt="Grocery" class="img-fluid" style="max-height: 80%;">
      </div>
      <!-- Right Section -->
      <div class="col-md-6 p-5 bg-white">
        <h2 class="text-center mb-4">Đăng ký</h2>
        <!-- Form -->
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" class="form-control mb-3" name="Fullname" placeholder="Họ và tên của bạn" required>

          <div class="tab-content mb-3">
            <div class="tab-pane fade show active" id="email" role="tabpanel">
              <input type="email" class="form-control mb-3" placeholder="Email của bạn" required>
            </div>
          </div>
          <input type="password" name="password" class="form-control mb-3" placeholder="Mật khẩu" required>
          <input type="password" name="confirm_password" class="form-control mb-3" placeholder="Nhập lại một mật khẩu" required>
          <input type="hidden" name="Role_id" value="2">
          <button type="submit" class="btn btn-primary w-100 mb-3" style="background: linear-gradient(45deg, #e91e63, #673ab7); border: none;">Đăng ký</button>
          <div class="text-center">
            <p>Hoặc</p>
            <button class="btn btn-outline-primary me-2"><i class="bi bi-facebook"></i> Facebook</button>
            <button class="btn btn-outline-danger"><i class="bi bi-google"></i> Google</button>
          </div>
        </form>
        <p class="text-center mt-3">Đã có tài khoản? <a href="{{route('login')}}" class="text-decoration-none text-danger">Đăng nhập ngay!</a></p>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


@endsection
