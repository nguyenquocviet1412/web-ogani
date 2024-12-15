@extends('admin.layout')
@section('title', 'Thêm mới bảng kê lương | Quản trị Admin')
@section('title2', 'Thêm mới bảng kê lương')
@section('content')

<div class="app-title">
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('salaries.index') }}">Bảng kê lương</a></li>
        <li class="breadcrumb-item">Thêm mới</li>
    </ul>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Tạo mới bảng kê lương</h3>
            <form method="POST" action="{{ route('salaries.store') }}">
                @csrf
                <div class="tile-body">
                    <div class="form-group">
                        <label for="id_user" class="control-label">Tên nhân viên</label>
                        <select name="id_user" id="id_user" class="form-control">
                            <option value="">-- Chọn nhân viên --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->Fullname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="salary" class="control-label">Tiền lương</label>
                        <input name="salary" type="number" class="form-control" id="salary" placeholder="Nhập tiền lương" oninput="calculateTotal()">
                    </div>

                    <div class="form-group">
                        <label for="salary_deduction" class="control-label">Trừ lương</label>
                        <input name="salary_deduction" type="number" class="form-control" id="salary_deduction" placeholder="Nhập số tiền trừ" oninput="calculateTotal()">
                    </div>

                    <div class="form-group">
                        <label for="bonus" class="control-label">Tiền thưởng</label>
                        <input name="bonus" type="number" class="form-control" id="bonus" placeholder="Nhập tiền thưởng" oninput="calculateTotal()">
                    </div>

                    <div class="form-group">
                        <label for="total" class="control-label">Tổng nhận</label>
                        <input name="total" type="text" class="form-control" id="total" readonly>
                    </div>

                    <div class="form-group">
                        <label for="status" class="control-label">Trạng thái</label>
                        <select name="status" id="status" class="form-control">
                            <option value="Đã nhận tiền">Đã nhận tiền</option>
                            <option value="Chưa nhận tiền">Chưa nhận tiền</option>
                        </select>
                    </div>
                </div>

                <div class="tile-footer">
                    <button type="submit" class="btn btn-save">Lưu lại</button>
                    <a class="btn btn-cancel" href="{{ route('salaries.index') }}">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Hàm tính toán tổng nhận
    function calculateTotal() {
        // Lấy giá trị từ các ô nhập liệu
        const salary = parseFloat(document.getElementById('salary').value) || 0;
        const deduction = parseFloat(document.getElementById('salary_deduction').value) || 0;
        const bonus = parseFloat(document.getElementById('bonus').value) || 0;

        // Tính tổng nhận
        const total = salary - deduction + bonus;

        // Cập nhật ô Tổng nhận
        document.getElementById('total').value = total.toLocaleString('vi-VN') + ' VND';
    }
</script>

@endsection
