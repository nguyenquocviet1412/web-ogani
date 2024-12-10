<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\orders;
use App\Models\products;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Trang chủ Admin
        public function index(){
            //Tổng số người dùng
            $soUsers = User::where('role_id', 2)->count();
            //Tổng số sản phẩm
            $tongSP = products::count();
            //Tổng số đơn hàng trong tháng hiện tại (theo ngày)
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            $soDonHang = orders::whereMonth('Order_date', $currentMonth)
                            ->whereYear('Order_date', $currentYear)
                            ->count();
            //Tổng số sản phẩm sắp hết hàng (<=5 )
            $sapHetHang = products::where('quantity','<=',5)->count();
            //Tình trạng đơn hàng
            $litsDonHang = orders::query()->get();
            //Danh sách khách hàng mới 5 người
            $listkhachHangMoi = User::orderBy('created_at', 'desc')->limit(5)->get();

            return view('admin.index',
                compact(
                    'soUsers',
                    'tongSP',
                    'soDonHang',
                    'sapHetHang',
                    'litsDonHang',
                    'listkhachHangMoi' // Đổi tên biến cho khớp
                ));
        }



}
