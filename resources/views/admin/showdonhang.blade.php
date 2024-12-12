@extends('admin.layout')

@section('title', 'Chi tiết đơn hàng | Quản trị Admin')
@section('title2', 'Chi tiết đơn hàng')

@section('content')
<div class="container mt-5">
    <h2>Chi tiết đơn hàng</h2>
    <div class="card">
        <div class="card-header bg-primary text-white">
            Thông tin đơn hàng
        </div>
        <div class="card-body">
            <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
            <p><strong>Tên khách hàng:</strong> {{ $order->fullname }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->Phone_number }}</p>
            <p><strong>Địa chỉ giao hàng:</strong> {{ $order->Shipping_address }}</p>
            <p><strong>Ngày đặt hàng:</strong> {{ $order->Order_date }}</p>
            <p><strong>Ghi chú:</strong> {{ $order->note }}</p>
            <p><strong>Trạng thái:</strong>
                @if ($order->status == "pending")
                    <span class="badge bg-secondary">Đang xử lý</span>
                @elseif ($order->status == "processing")
                    <span class="badge bg-info">Đang xử lý</span>
                @elseif ($order->status == "shipped")
                    <span class="badge bg-warning">Đang giao hàng</span>
                @elseif ($order->status == "delivered")
                    <span class="badge bg-success">Đã giao</span>
                @elseif ($order->status == "cancelled")
                    <span class="badge bg-danger">Đã hủy</span>
                @endif
            </p>
            <p><strong>Tổng tiền:</strong> {{ number_format($order->Total_money, 2, ',', '.') }} $</p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-secondary text-white">
            Danh sách sản phẩm
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->Number_of_products }}</td>
                            <td>{{ number_format($detail->price, 2, ',', '.') }} $</td>
                            <td>{{ number_format($detail->Total_money, 2, ',', '.') }} $</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('admin.donhang') }}" class="btn btn-secondary mt-3">Quay lại</a>
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
</script>
@endsection
