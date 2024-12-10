@extends('client.layout')
@section('content')

  <title>Đăng nhập</title>

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
        <h2 class="text-center mb-4">Đăng nhập</h2>
            @if(session('message'))
                <div class="alert alert-danger">
                    {{ session('message') }}
                </div>
            @endif
        <!-- Form -->
        <form action="{{route('postLogin')}}" method="POST">
            @csrf
          <div class="tab-content mb-3">
            <div class="tab-pane fade show active" id="email" role="tabpanel">
              <input type="email" name="email" class="form-control mb-3" placeholder="Email của bạn" required>
            </div>
          </div>
          <input type="password" name="password" class="form-control mb-3" placeholder="Mật khẩu" required>
          <button type="submit" class="btn btn-primary w-100 mb-3" style="background: linear-gradient(45deg, #e91e63, #673ab7); border: none;">Đăng Nhập</button>
          <div class="d-flex justify-content-between mb-3">
            <div>
              <input type="checkbox" id="remember" class="form-check-input">
              <label for="remember" class="form-check-label">Ghi nhớ mật khẩu</label>
            </div>
            <a href="#" class="text-decoration-none">Quên mật khẩu?</a>
          </div>
          <div class="text-center">
            <p>Hoặc</p>
            <button class="btn btn-outline-primary me-2"><i class="bi bi-facebook"></i> Facebook</button>
            <button class="btn btn-outline-danger"><i class="bi bi-google"></i> Google</button>
          </div>
        </form>
        <p class="text-center mt-3">Bạn chưa có tài khoản? <a href="{{route('register')}}" class="text-decoration-none text-danger">Đăng kí</a></p>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
