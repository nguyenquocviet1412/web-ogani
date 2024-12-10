<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\order_details;
use App\Models\orders;
use App\Models\payments;
use Illuminate\Http\Request;

class donhangController extends Controller
{
//Trang danh sách đơn hàng
    public function donhang(){
        // Lấy danh sách đơn hàng và các chi tiết liên quan
        $orders = orders::with('orderDetails')->get();
        return view('admin.donhang', compact('orders'));
    }


//Chi tiết đơn hàng theo id
    public function show($id)
{
        // Load order with its related data (Eager Loading)
        $order = orders::with([ 'orderDetails'])->findOrFail($id);

        // Pass the order data to the view
        return view('admin.showdonhang', compact('order'));
}


// Xóa đơn hàng theo id
    public function destroy($id)
{
        // Tìm đơn hàng theo ID
        $order = orders::findOrFail($id);

        // Xóa tất cả chi tiết liên quan
        $order->orderDetails()->delete();

        // Xóa đơn hàng
        $order->delete();

        // Chuyển hướng với thông báo thành công
        return redirect()->route('admin.donhang')->with('success', 'Đơn hàng đã được xóa thành công.');
}

//Trang sửa đơn hàng
public function edit($id)
{
    // Tìm đơn hàng theo ID và các chi tiết liên quan
    $order = orders::with('orderDetails')->findOrFail($id);
    $paymentMethods = payments::all(); // Lấy tất cả các phương thức thanh toán
    // Trả về view edit với dữ liệu đơn hàng
    return view('admin.editdonhang', compact('order', 'paymentMethods'));
}


// Cập nhật đơn hàng theo id
public function update(Request $request, $id)
{
    // Tìm và cập nhật đơn hàng
    $order = orders::findOrFail($id);

    // Validate request data
    $request->validate([
        'fullname' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'Phone_number' => 'required|numeric',
        'note' => 'nullable|string',
        'Shipping_address' => 'required|string',
        'Payment_id' => 'required|integer',
        'status' => 'required|string',
    ]);

    // Cập nhật thông tin đơn hàng
    $order->update($request->all());

    // Xử lý cập nhật các chi tiết đơn hàng
    if ($request->has('orderDetails')) {
        foreach ($request->orderDetails as $detail) {
            $orderDetail = order_details::find($detail['id']);
            if ($orderDetail) {
                $orderDetail->update([
                    'Product_id' => $detail['Product_id'],
                    'price' => $detail['price'],
                    'Number_of_products' => $detail['Number_of_products'],
                    'Total_money' => $detail['Total_money'],
                ]);
            }
        }
    }

    // Thêm thông báo và quay về trang danh sách đơn hàng
    return redirect()->route('admin.donhang')->with('success', 'Đơn hàng đã được cập nhật thành công!');
}

}
