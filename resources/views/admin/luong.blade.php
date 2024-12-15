@extends('admin.layout')
@section('title')
Bảng kê lương | Quản trị Admin
@endsection
@section('title2')
Bảng kê lương
@endsection
@section('content')


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



<div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="row element-button">
            <div class="col-sm-2">

              <a class="btn btn-add btn-sm" href="{{route('salaries.create')}}" title="Thêm"><i class="fas fa-plus"></i>
                Tạo mới</a>
            </div>
          </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th width="10"><input type="checkbox" id="all"></th>
                                <th>Tên nhân viên</th>
                                <th>Chức vụ</th>
                                <th>Tiền lương</th>
                                <th>Trừ lương</th>
                                <th>Tiền thưởng</th>
                                <th>Tổng nhận</th>
                                <th>Trạng thái</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salaries as $salary)
                                <tr>
                                    <td width="10"><input type="checkbox" name="check1" value="{{ $salary->id }}"></td>
                                    <td>{{ $salary->user->Fullname ?? 'Không xác định' }}</td> <!-- Lấy tên nhân viên -->
                                    <td>
                                        @if ($salary->Role_id == 3)
                                            Nhân viên bán hàng
                                        @elseif ($salary->Role_id == 1)
                                            Quản lý
                                        @else
                                            Khác
                                        @endif
                                    </td>
                                    <td>{{ number_format($salary->salary, 0, ',', '.') }} đ</td> <!-- Hiển thị tiền lương -->
                                    <td>{{ number_format($salary->salary_deduction, 0, ',', '.') }} đ</td> <!-- Hiển thị trừ lương -->
                                    <td>{{ number_format($salary->bonus, 0, ',', '.') }} đ</td> <!-- Hiển thị tiền thưởng -->
                                    <td>{{ number_format($salary->salary - $salary->salary_deduction + $salary->bonus, 0, ',', '.') }} đ</td> <!-- Hiển thị tổng nhận -->
                                    <td>
                                        @if ($salary->active)
                                            <span class="badge bg-success">Đã nhận tiền</span>
                                        @else
                                            <span class="badge bg-warning">Chưa nhận tiền</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Nút Xóa -->
                                        <button class="btn btn-primary btn-sm trash" type="button" title="Xóa" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $salary->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                        <!-- Modal Xác Nhận Xóa -->
                                        <div class="modal fade" id="deleteModal-{{ $salary->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Bạn có chắc chắn muốn xóa bảng lương của nhân viên <strong>{{ $salary->user->Fullname ?? 'Không xác định' }}</strong> không?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                        <form action="{{ route('salaries.destroy', $salary->id) }}" method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger" type="submit">Xóa</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Nút Sửa -->
                                        <a href="{{ route('salaries.edit', $salary->id) }}" class="btn btn-primary btn-sm edit" title="Sửa"><i class="fa fa-edit"></i></a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
