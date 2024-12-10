<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    //Login
    public function getLogin(){
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
            return view('client.login', compact(
                'categories',
                'products',
                'likeproducts',
                'newproducts',
                'featuredproducts'
            ));
    }
    public function postLogin(Request $request){
        $user = $request->only(['email','password']);

        //Xác thực thông tin của user
        if(Auth::attempt($user)){
            // Lưu thông tin user vào session
            session(['user' => Auth::user()]); // Lưu user đang đăng nhập vào session

            if(Auth::user()->Is_active == 0){
                return redirect()->back()->with('message', 'Tài khoản của bạn đã bị Khóa. Vui lòng liên hệ với quản trị để kích hoạt tài khoản.');
            }
            if(Auth::user()->Is_active == 1){
                $user = Auth::user();
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
            return view('client.index', compact(
                'user',
                'categories',
                'products',
                'likeproducts',
                'newproducts',
                'featuredproducts'
            ));
            }
        }else{
            return redirect()->back()->with('message', 'Email hoặc Password không chính xác');
        }
    }

    public function getRegister(){
        $categories = categories::get();
        return view('client.register',compact('categories'));
    }
    public function postRegister(Request $request){
        $data = $request->validate([
            'Fullname'=>['required','min:3'],
            'email' => ['required','email'],
            'password' => ['required','min:5'],
            'confirm_password' =>['required','same:password'],
            'Role_id'=>[]
        ]);
        // dd($data);
        User::query()->create($data);

        return redirect()->route('login')->with('message', 'Đăng lý tài khoản thành công');
    }

    public function logout(){
        Auth::logout();
        session()->forget('user');
        return redirect()->route('login');
    }
}
