@extends('admin.layout')
@section('title')
Sửa bảng lương | Quản trị Admin
@endsection
@section('title2')
Sửa bảng lương
@endsection
@section('content')
<div class="app-title">
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item">Bản kê lương</li>
        <li class="breadcrumb-item"><a href="#">Sửa</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Sửa bảng lương</h3>
            <div class="tile-body">
                <form method="POST" action="{{ route('salaries.update', $salary->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="id_user">Nhân viên</label>
                        <select class="form-control" id="id_user" name="id_user">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $salary->id_user == $user->id ? 'selected' : '' }}>
                                    {{ $user->Fullname }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="salary">Tiền lương</label>
                        <input type="number" class="form-control" id="salary" name="salary" value="{{ $salary->salary }}">
                    </div>

                    <div class="form-group">
                        <label for="salary_deduction">Trừ lương</label>
                        <input type="number" class="form-control" id="salary_deduction" name="salary_deduction" value="{{ $salary->salary_deduction }}">
                    </div>

                    <div class="form-group">
                        <label for="bonus">Tiền thưởng</label>
                        <input type="number" class="form-control" id="bonus" name="bonus" value="{{ $salary->bonus }}">
                    </div>

                    <div class="form-group">
                        <label for="active">Trạng thái</label>
                        <select class="form-control" id="active" name="active">
                            <option value="1" {{ $salary->active ? 'selected' : '' }}>Đã nhận</option>
                            <option value="0" {{ !$salary->active ? 'selected' : '' }}>Chưa nhận</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-save">Lưu lại</button>
                    <a href="{{ route('salaries.index') }}" class="btn btn-cancel">Hủy bỏ</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
