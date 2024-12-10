@extends('admin.layout')

@section('title', 'Danh sách Đơn hàng | Quản trị Admin')
@section('title2', 'Danh sách Đơn hàng')

@section('content')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Thành công!</strong> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Lỗi!</strong> {{ session('error') }}
        </div>
    @endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <button class="btn btn-primary btn-sm" onclick="myApp.printTable()">In danh sách</button>
                </div>
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>ID đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Đơn hàng</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Tình trạng</th>
                            <th>Tính năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td width="10">
                                <input type="checkbox" name="check" value="{{ $order->id }}">
                            </td>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->fullname }}</td>
                            <td>
                                @foreach ($order->orderDetails as $orderDetail)
                                    <div>{{ $orderDetail->product->name }}</div>
                                @endforeach
                            </td>
                            <td>{{ $order->orderDetails->sum('Number_of_products') }}</td>
                            <td>{{ number_format($order->Total_money) }} $</td>
                            <td>
                                <span class="badge
                                    @if ($order->status == "pending")
                                        bg-secondary
                                    @elseif ($order->status == "processing")
                                        bg-info
                                    @elseif ($order->status == "shipped")
                                        bg-warning
                                    @elseif ($order->status == "delivered")
                                        bg-success
                                    @elseif ($order->status == "cancelled")
                                        bg-danger
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="d-flex">
                                <form action="{{ route('donhang.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                <a href="{{route('donhang.edit',$order->id)}}" class="btn btn-primary btn-sm edit" title="Sửa">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ route('donhang.show', $order->id) }}" class="btn btn-primary btn-sm view-details" title="Xem chi tiết">
                                    <i class="fa fa-eye"></i> Xem chi tiết
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('admin/doc/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('admin/doc/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/doc/js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
    $('#sampleTable').DataTable();

    $('#all').click(function () {
        $('#sampleTable tbody :checkbox').prop('checked', $(this).is(':checked'));
    });

    $('.trash').click(function () {
        const id = $(this).data('id');
        if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')) {
            $.ajax({
                url: '/orders/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function (result) {
                    location.reload();
                }
            });
        }
    });

    const myApp = new function () {
        this.printTable = function () {
            const tableContent = document.getElementById('sampleTable').outerHTML;
            const printWindow = window.open('', '', 'height=700,width=700');
            printWindow.document.write(tableContent);
            printWindow.document.close();
            printWindow.print();
        }
    }


    //chỉnh thời gian hiển thị thông báo
    setTimeout(function() {
    let alert = document.querySelector('.alert');
    if (alert) {
        alert.remove();
    }
}, 5000); // Ẩn sau 5 giây

</script>
@endsection
