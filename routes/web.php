<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\doanhthuController;
use App\Http\Controllers\admin\donhangController;
use App\Http\Controllers\admin\khachhangController;
use App\Http\Controllers\admin\nhanvienController;
use App\Http\Controllers\admin\noiboController;
use App\Http\Controllers\admin\productController;
use App\Http\Controllers\admin\salariesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\client\ClientController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckAuth;
use Illuminate\Support\Facades\Route;
// use App\Http\Middleware\Authenticate;
// use App\Http\Middleware\CheckAuth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// ----------------------------------------------------------------
//Client
    //trang chủ
Route::get('/', [ClientController::class,'index'])->name('client');
    //Chức năng tìm kiếm
Route::get('/search', [ClientController::class, 'search'])->name('products.search');
    //Trang chi tiết sản phẩm
Route::get('/product/{id}', [ClientController::class,'productDetail'])->name('product.detail');
    //Trang danh mục sản phẩm
Route::get('/category/{id}', [ClientController::class,'productCategory'])->name('product.category');
    //Trang liệt kê sản phẩm
Route::get('/listproducts', [ClientController::class,'listproducts'])->name('product.listproducts');
    // Thêm vào giỏ hàng
    Route::get('/add-to-cart/{id}', [ClientController::class,'addToCart'])->name('product.addToCart');

    //Trang đăng nhập
    Route::get('/login', [AuthController::class,'getLogin'])->name('login');
    Route::post('/login', [AuthController::class,'postLogin'])->name('postLogin');

    //Trang đăng ký
    Route::get('/register', [AuthController::class,'getRegister'])->name('register');
    Route::post('/register', [AuthController::class,'postRegister'])->name('postRegister');

    //Trang giỏ hàng
    Route::get('/cart', [ClientController::class,'cart'])->name('cart');
    Route::post('/cart', [ClientController::class,'addToCart'])->name('cart.add');
    Route::post('/update-cart', [ClientController::class, 'updateCart']);
    Route::delete('/cart/delete/{id}', [ClientController::class,'deleteCartItem'])->name('cart.delete');

    Route::post('/cart/save-total', [ClientController::class, 'saveTotal']);
    Route::get('/cart/save-total', [ClientController::class, 'getTotal'])->name('cart.getTotal');

    //Trang thanh toán
    Route::get('/checkout', [ClientController::class, 'showCheckout']);

    Route::post('/checkout/place-order', [ClientController::class, 'placeOrder'])->name('checkout.place-order');
    Route::get('/order-success', [ClientController::class, 'orderSuccess'])->name('order.success');



// ----------------------------------------------------------------



//Login, register, logout

Route::get('/login', [AuthController::class,'getLogin'])->name('login');
Route::post('/login', [AuthController::class,'postLogin'])->name('postLogin');

Route::get('/register', [AuthController::class,'getRegister'])->name('register');
Route::post('/register', [AuthController::class,'postRegister'])->name('postRegister');

Route::get('/logout', [AuthController::class,'logout'])->name('logout');




// ----------------------------------------------------------------
//Admin
Route::middleware([Authenticate::class,CheckAuth::class])->group(function(){
    Route::prefix('admin1')->group(function(){
        Route::get('/',[AdminController::class,'index'])->name('admin');
    //Nhân viên
        Route::get('/nhanvien', [nhanvienController::class,'nhanvien'])->name('admin.nhanvien');
        Route::delete('/nhanvien/delete/{user}',[nhanvienController::class,'deleteNhanVien'])->name('admin.nhanvien.destroy');
        Route::get('/nhanvien/them', [nhanvienController::class,'addnhanvien'])->name('admin.nhanvien.them');
        Route::post('/nhanvien/them', [nhanvienController::class,'storenhanvien'])->name('admin.nhanvien.store');
        Route::get('/nhanvien/edit/{user}', [nhanvienController::class,'editnhanvien'])->name('admin.nhanvien.edit');
        Route::put('/nhanvien/edit/{user}', [nhanvienController::class,'updatenhanvien'])->name('admin.nhanvien.update');
    //Khách hàng
        Route::get('/khachhang', [khachhangController::class,'khachhang'])->name('admin.khachhang');
        Route::get('/khachhang/them', [khachhangController::class,'addkhachhang'])->name('admin.khachhang.them');
        Route::post('/khachhang/them', [khachhangController::class,'storekhachhang'])->name('admin.khachhang.store');
        Route::get('/khachhang/edit/{user}', [khachhangController::class,'editkhachhang'])->name('admin.khachhang.edit');
        Route::put('/khachhang/edit/{user}', [khachhangController::class,'updatekhachhang'])->name('admin.khachhang.update');
    //Sản phẩm
        Route::get('/sanpham', [productController::class,'sanpham'])->name('admin.sanpham');
        Route::get('/sanpham/them', [productController::class,'addsanpham'])->name('admin.sanpham.them');
        Route::delete('/sanpham/delete/{product}',[productController::class,'deletesanpham'])->name('admin.sanpham.destroy');
        Route::post('/sanpham/them', [productController::class,'storesanpham'])->name('admin.sanpham.store');
        Route::get('/sanpham/edit/{product}', [productController::class,'editsanpham'])->name('admin.sanpham.edit');
        Route::put('/sanpham/edit/{product}', [productController::class,'updatesanpham'])->name('admin.sanpham.update');

        Route::get('/xuatxu/them', [productController::class,'addxuatxu'])->name('admin.xuatxu.them');
        Route::post('/xuatxu/them', [productController::class,'storexuatxu'])->name('admin.xuatxu.store');

        Route::get('/danhmuc/them', [productController::class,'adddanhmuc'])->name('admin.danhmuc.them');
        Route::post('/danhmuc/them', [productController::class,'storedanhmuc'])->name('admin.danhmuc.store');
    //Đơn hàng
        Route::get('/donhang', [donhangController::class,'donhang'])->name('admin.donhang');
        Route::get('/donhang/{id}', [donhangController::class, 'show'])->name('donhang.show');
        Route::delete('/donhang/{id}', [donhangController::class, 'destroy'])->name('donhang.destroy');
        Route::get('/donhang/{id}/edit', [donhangController::class, 'edit'])->name('donhang.edit');
        Route::put('/donhang/{id}', [donhangController::class, 'update'])->name('donhang.update');
    //Nội bộ
        Route::get('/noibo', [noiboController::class,'noibo'])->name('admin.noibo');
        Route::delete('/noibo/{id}', [noiboController::class,'destroy'])->name('userbans.destroy');
        Route::get('/noibo/edit/{id}', [noiboController::class,'edit'])->name('userbans.edit');
        Route::put('/noibo/edit/{id}', [noiboController::class,'update'])->name('userbans.update');
        Route::get('/noibo/create', [noiboController::class, 'create'])->name('userbans.create');
        Route::post('/noibo', [noiboController::class, 'store'])->name('userbans.store');
    // Quản lý bảng lương
    Route::get('/salaries', [salariesController::class, 'index'])->name('salaries.index'); // Danh sách bảng kê lương
    Route::get('/salaries/create', [salariesController::class, 'create'])->name('salaries.create'); // Form thêm bảng lương
    Route::post('/salaries', [salariesController::class, 'store'])->name('salaries.store'); // Xử lý thêm bảng lương
    Route::get('/salaries/{salary}/edit', [salariesController::class, 'edit'])->name('salaries.edit'); // Form sửa bảng lương
    Route::put('/salaries/{salary}', [salariesController::class, 'update'])->name('salaries.update'); // Cập nhật bảng lương
    Route::delete('/salaries/{salary}', [salariesController::class, 'destroy'])->name('salaries.destroy'); // Xóa bảng lương

    //Doanh thu
    Route::get('/doanhthu', [doanhthuController::class, 'index'])->name('doanhthu.index'); // Danh sách doanh thu

});
});
