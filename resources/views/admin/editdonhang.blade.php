@extends('admin.layout')
@section('title')
Sửa Đơn hàng | Quản trị Admin
@endsection
@section('title2')
Sửa Đơn hàng
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <form action="{{ route('donhang.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="fullname">Họ và tên</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" value="{{ $order->fullname }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $order->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="Phone_number">Số điện thoại</label>
                        <input type="text" class="form-control" id="Phone_number" name="Phone_number" value="{{ $order->Phone_number }}" required>
                    </div>
                    <div class="form-group">
                        <label for="Shipping_address">Địa chỉ giao hàng</label>
                        <input type="text" class="form-control" id="Shipping_address" name="Shipping_address" value="{{ $order->Shipping_address }}" required>
                    </div>
                    <div class="form-group">
                        <label for="note">Ghi chú</label>
                        <textarea class="form-control" id="note" name="note" rows="3">{{ $order->note }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Tình trạng</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending" @if($order->status == 'pending') selected @endif>Chờ xử lý</option>
                            <option value="processing" @if($order->status == 'processing') selected @endif>Đang xử lý</option>
                            <option value="shipped" @if($order->status == 'shipped') selected @endif>Đã gửi</option>
                            <option value="delivered" @if($order->status == 'delivered') selected @endif>Đã giao</option>
                            <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Đã hủy</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Total_money">Tổng tiền</label>
                        <input type="text" class="form-control" id="Total_money" name="Total_money" value="{{ $order->Total_money }}" required>
                    </div>
                    <div class="form-group">
                        <label for="Payment_id">Phương thức thanh toán</label>
                        <select class="form-control" name="Payment_id" required>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}" {{ $order->Payment_id == $method->id ? 'selected' : '' }}>{{ $method->Payment_method }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="orderDetails">Chi tiết đơn hàng</label>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                    <tr>
                                        <td>{{ $detail->product->name }}</td>
                                        <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                                        <td>{{ $detail->Number_of_products }}</td>
                                        <td>{{ number_format($detail->Total_money, 0, ',', '.') }} đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Cập nhật đơn hàng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
