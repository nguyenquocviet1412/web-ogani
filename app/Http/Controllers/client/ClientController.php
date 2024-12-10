<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\carts;
use App\Models\categories;
use App\Models\order_details;
use App\Models\orders;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        //lấy dữ liệu categories
        $categories = categories::get();
        $products = products::get();
        $featuredproducts = categories::select('categories.*')
            ->join('products', 'products.category_id', '=', 'categories.id') // Kết hợp bảng categories và products
            ->groupBy('categories.id')  // Nhóm theo danh mục
            ->orderByRaw('MAX(products.luotxem) DESC')  // Lọc theo lượt xem cao nhất của sản phẩm trong mỗi danh mục
            ->limit(4)  // Lấy 4 danh mục
            ->get();

        foreach ($featuredproducts as $category) {
            // Lấy 2 sản phẩm có lượt xem cao nhất trong mỗi danh mục
            $category->top_products = products::where('category_id', $category->id) // Sử dụng query builder
                ->orderBy('luotxem', 'desc') // Sắp xếp theo lượt xem giảm dần
                ->take(2) // Lấy 2 sản phẩm
                ->get(); // Lấy kết quả
        }
        $likeproducts = products::orderBy('luotxem', 'desc')
            ->take(6) // Giới hạn kết quả trả về 6 sản phẩm
            ->get();
        $newproducts = products::orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo giảm dần
            ->take(6) // Giới hạn 6 sản phẩm
            ->get();
        // dd($categories);
        // truyền dữ liệu categories cho view
        return view('client.index', compact(
            'categories',
            'products',
            'likeproducts',
            'newproducts',
            'featuredproducts'
        ));
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('search'); // Lấy từ khóa từ form

        // Tìm kiếm sản phẩm theo tên hoặc danh mục
        $searchproducts = products::where('name', 'like', '%' . $searchTerm . '%')
            ->get();

        //lấy dữ liệu categories
        $categories = categories::get();
        $products = products::get();
        $featuredproducts = categories::select('categories.*')
            ->join('products', 'products.category_id', '=', 'categories.id') // Kết hợp bảng categories và products
            ->groupBy('categories.id')  // Nhóm theo danh mục
            ->orderByRaw('MAX(products.luotxem) DESC')  // Lọc theo lượt xem cao nhất của sản phẩm trong mỗi danh mục
            ->limit(4)  // Lấy 4 danh mục
            ->get();

        foreach ($featuredproducts as $category) {
            // Lấy 2 sản phẩm có lượt xem cao nhất trong mỗi danh mục
            $category->top_products = products::where('category_id', $category->id) // Sử dụng query builder
                ->orderBy('luotxem', 'desc') // Sắp xếp theo lượt xem giảm dần
                ->take(2) // Lấy 2 sản phẩm
                ->get(); // Lấy kết quả
        }
        $likeproducts = products::orderBy('luotxem', 'desc')
            ->take(6) // Giới hạn kết quả trả về 6 sản phẩm
            ->get();
        $newproducts = products::orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo giảm dần
            ->take(6) // Giới hạn 6 sản phẩm
            ->get();
        // dd($categories);
        // truyền dữ liệu categories cho view
        return view('client.index', compact(
            'categories',
            'products',
            'likeproducts',
            'newproducts',
            'featuredproducts',
            'searchproducts',
            'searchTerm'
        ));
    }
    //Trang sản phẩm theo danh mục
    public function productCategory($id){
        $categoryProducts = products::where('category_id', $id)->get();
        $nameCategories = categories::where('id', $id)->first();
        //lấy dữ liệu categories
        $categories = categories::get();
        $products = products::get();
        $featuredproducts = categories::select('categories.*')
            ->join('products', 'products.category_id', '=', 'categories.id') // Kết hợp bảng categories và products
            ->groupBy('categories.id')  // Nhóm theo danh mục
            ->orderByRaw('MAX(products.luotxem) DESC')  // Lọc theo lượt xem cao nhất của sản phẩm trong mỗi danh mục
            ->limit(4)  // Lấy 4 danh mục
            ->get();

        foreach ($featuredproducts as $category) {
            // Lấy 2 sản phẩm có lượt xem cao nhất trong mỗi danh mục
            $category->top_products = products::where('category_id', $category->id) // Sử dụng query builder
                ->orderBy('luotxem', 'desc') // Sắp xếp theo lượt xem giảm dần
                ->take(2) // Lấy 2 sản phẩm
                ->get(); // Lấy kết quả
        }
        $likeproducts = products::orderBy('luotxem', 'desc')
            ->take(6) // Giới hạn kết quả trả về 6 sản phẩm
            ->get();
        $newproducts = products::orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo giảm dần
            ->take(6) // Giới hạn 6 sản phẩm
            ->get();
        // dd($categories);
        // truyền dữ liệu categories cho view
        return view('client.index', compact(
            'categories',
            'products',
            'likeproducts',
            'newproducts',
            'featuredproducts',
            'categoryProducts',
            'nameCategories'
        ));
    }
    // Trang chi tiết sản phẩm
    public function productDetail($id)
{
    // Tìm sản phẩm theo ID
    $productDetail = products::where('Product_id', $id)->first();

    // Tăng số lượt xem
    $productDetail->increment('luotxem'); // Cột 'luotxem' là số lượt xem

    // Lấy các sản phẩm liên quan
    $relatedProducts = products::where('category_id', $productDetail->category_id)
        ->where('Product_id', '!=', $id) // Loại trừ sản phẩm hiện tại
        ->take(4) // Giới hạn 4 sản phẩm
        ->get();


    // Lấy dữ liệu categories
    $categories = categories::get();
    $products = products::with('category')->get();
    $nameCategories = categories::where('id', $productDetail->category_id)->first();

    return view('client.shop-details', compact(
        'categories',
        'products',
        'nameCategories',
        'productDetail',
        'relatedProducts'
    ));
}
    //Trang shop
    public function listproducts(){
        //lấy dữ liệu categories
        $categories = categories::get();
        $products = products::paginate(9);
        //đếm tổng số sản phẩm
        $totalProducts = $products->total();
        //lấy 6 sản phẩm mới nhất
        $newproducts = products::orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        //Lấy 6 sản phẩm có giá thấp nhất
        $saleproducts = products::orderBy('price', 'asc')
            ->take(6)
            ->get();
        return view('client.shop-grid',compact(
            'categories',
            'products',
            'newproducts',
            'saleproducts',
            'totalProducts'
        ));
    }
    //Thêm vào giỏ hàng
    public function addToCart($id){
        if (session()->has('user')) {
            $id_user = session('user.id');
            $product = products::find($id);
            $cart = carts::where('id_user', $id_user)->where('Product_id', $id)->first();
            if ($cart) {
                $cart->Number_of_product += 1;
                $cart->save();
            } else {
                $cart = new carts();
                $cart->id_user = $id_user;
                $cart->Product_id = $id;
                $cart->Number_of_product = 1;
                $cart->price = $product->price;
                $cart->save();
            }
            return redirect()->route('cart')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
        }
        if (!session()->has('user')) {
            return redirect()->route('login')->with('message', 'Vui lòng đăng nhập để mua hàng.');
        }
    }
    //Trang giỏ hàng
    public function cart(){
        if (session()->has('user')) {
            $categories = categories::get();
            $id_user = session('user.id');
            $cartProducts = carts::where('id_user', $id_user)->with('product')->get();
            return view('client.shop-cart', compact('cartProducts','categories'));
        }
        if (!session()->has('user')) {
            return redirect()->route('login')->with('message', 'Vui lòng đăng nhập để xem giỏ hàng.');
        }

    }
    //Cập nhật giỏ hàng
    public function updateCart(Request $request)
{
    $cartItems = $request->input('cart_items');

    foreach ($cartItems as $item) {
        $cart = carts::find($item['cart_id']);
        if ($cart) {
            $cart->Number_of_product = $item['quantity'];
            $cart->price = $item['total_price'];  // Cập nhật lại giá nếu cần
            $cart->save();
        }
    }

    return response()->json(['success' => true]);
}
    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteCartItem($id)
{
    $cartItem = carts::find($id);

    if ($cartItem) {
        $cartItem->delete();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}
//Trang checkout
public function showCheckout()
    {
        // Lấy thông tin giỏ hàng từ cơ sở dữ liệu
        $categories = categories::get();
        $cartItems = carts::where('id_user', auth()->id())->with('product')->get();
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Trả về view trang thanh toán
        return view('client.checkout', compact('cartItems', 'subtotal','categories'));
    }
//Lưu tổng tiền giỏ hàng
// Lưu giá trị Total vào session
public function saveTotal(Request $request)
{
    // Lấy dữ liệu từ request
    $subtotal = $request->input('subtotal');
    $total = $request->input('total');

    // Lưu vào session
    session([
        'subtotal' => $subtotal,
        'total' => $total
    ]);

    return response()->json(['message' => 'Tổng tiền đã được lưu']);
}
//Lấy giá trị total từ session
public function getTotal()
{
    $subtotal = session('subtotal', 0); // Mặc định là 0 nếu không có giá trị
    $total = session('total', 0); // Lấy tổng tiền từ session
    return response()->json([
        'success' => true,
        'total' => $total,
        'subtotal' =>$subtotal
    ]);
}



// Tạo đơn hàng
public function placeOrder(Request $request)
{
    // Lấy thông tin người dùng hiện tại
    $user = Auth::user();

    // Kiểm tra dữ liệu từ form, nếu thiếu thì lấy từ tài khoản người dùng
    $fullname = $request->input('fullname', $request->has('fullname') && $request->input('fullname') ? $request->input('fullname') : ($user->fullname ?? 'Guest'));
    $email = $request->input('email', $request->has('email') && $request->input('email') ? $request->input('email') : ($user->email ?? 'guest@example.com'));
    $phone = $request->input('phone', $request->has('Phone_number') && $request->input('Phone_number') ? $request->input('Phone_number') : ($user->phone ?? '0000000000'));
    $address = $request->input('address', $request->has('Shipping_address') && $request->input('Shipping_address') ? $request->input('Shipping_address') : ($user->address ?? 'No Address'));
    $note = $request->input('note', '');  // Ghi chú không bắt buộc
    $paymentId = $request->input('payment_id'); // Lấy thông tin payment_id từ form
    // Kiểm tra giỏ hàng
    $cartItems = carts::where('id_user', $user->id)->get();
    if ($cartItems->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Giỏ hàng của bạn đang trống.']);
    }

    // Tính tổng tiền
    $total = session()->get('total');

    // Kiểm tra số lượng sản phẩm trong kho trước khi tạo đơn hàng
    foreach ($cartItems as $item) {
        $product = products::find($item->Product_id);
        if ($product->quantity < $item->Number_of_product) {
            return redirect()->route('cart')->with('error', 'Số lượng sản phẩm trong kho không đủ.');
        }
    }

    // Tạo đơn hàng
    $order = new orders();
    $order->User_id = $user->id;
    $order->fullname = $fullname;
    $order->email = $email;
    $order->Phone_number = $phone;
    $order->Shipping_address = $address;
    $order->Total_money = $total;
    $order->note = $note;
    $order->status = 'pending'; // Trạng thái mặc định
    $order->order_date = now(); // Thêm thời gian hiện tại
    $order->payment_id = $paymentId; // Lưu payment_id
    $order->save();

    // Kiểm tra số lượng sản phẩm trước khi lưu chi tiết đơn hàng
    foreach ($cartItems as $item) {
        $product = products::find($item->Product_id);


        // Lưu chi tiết đơn hàng
        $orderDetail = new order_details();
        $orderDetail->order_id = $order->id;
        $orderDetail->Product_id = $item->Product_id;
        $orderDetail->price = $item->price;
        $orderDetail->Number_of_products = $item->Number_of_product;
        $orderDetail->total_money = $item->price * $item->Number_of_product;
        $orderDetail->save();

        // Giảm số lượng sản phẩm trong bảng products
        $product->quantity -= $item->Number_of_product;
        $product->save();
    }

    // Xóa giỏ hàng sau khi đặt hàng
    carts::where('id_user', $user->id)->delete();
    $categories = categories::get();
    return view('client.thankyou',compact('categories'));
}


// Trang thành công
public function orderSuccess()
{
    $categories = categories::get();
    return view('client.thankyou',compact('categories'));
}

}
