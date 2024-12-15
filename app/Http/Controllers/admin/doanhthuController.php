<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\orders;
use App\Models\products;
use App\Models\User;
use App\Models\userbans;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class doanhthuController extends Controller
{
    public function index(Request $request)
    {
        // Lấy giá trị tháng từ form (nếu có), nếu không có lấy tháng hiện tại
        $month = $request->input('month', now()->format('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $month);

        $currentMonth = $date->month;
        $currentYear = $date->year;

        // Tổng số nhân viên
        $totalEmployees = User::where('Role_id', '!=', 2)->count();

        // Tổng sản phẩm
        $totalProducts = products::count();

        // Tổng đơn hàng trong tháng
        $totalOrders = orders::whereMonth('Order_date', $currentMonth)
                            ->whereYear('Order_date', $currentYear)
                            ->count();

        // Nhân viên bị cấm
        $bannedEmployees = userbans::where('active', 1)->count();

        // Tổng thu nhập trong tháng
        $totalIncome = orders::where('status', 'delivered')
                            ->whereMonth('Order_date', $currentMonth)
                            ->whereYear('Order_date', $currentYear)
                            ->sum('Total_money');

        // Nhân viên mới trong tháng
        $newEmployees = User::where('Role_id', '!=', 2)
                            ->whereMonth('created_at', $currentMonth)
                            ->whereYear('created_at', $currentYear)
                            ->count();

        // Sản phẩm hết hàng
        $outOfStockProducts = products::where('quantity', 0)->count();

        // Đơn hàng bị hủy trong tháng
        $canceledOrders = orders::where('status', 'Đã hủy')
                                ->whereMonth('Order_date', $currentMonth)
                                ->whereYear('Order_date', $currentYear)
                                ->count();




        // Lấy danh sách sản phẩm bán chạy theo tháng
        $topSellingProducts = products::with('category')
            ->join('order_details', 'products.Product_id', '=', 'order_details.Product_id')
            ->select('products.*', DB::raw('SUM(order_details.Number_of_products) as total_quantity'))
            ->groupBy('products.Product_id')
            ->orderBy('total_quantity', 'desc')
            ->whereMonth('order_details.created_at', $currentMonth)
            ->whereYear('order_details.created_at', $currentYear)
            ->get();

        // Lấy danh sách các đơn hàng theo tháng
        $orders = orders::with('orderDetails.product')
            ->whereMonth('Order_date', $currentMonth)
            ->whereYear('Order_date', $currentYear)
            ->get();

        // Lấy danh sách sản phẩm đã hết hàng theo tháng
        $outOfStockProducts2 = products::where('quantity', 0)
            ->whereMonth('updated_at', $currentMonth)
            ->whereYear('updated_at', $currentYear)
            ->get();

        // Lấy danh sách nhân viên mới

        $newEmployees2 = User::where('Role_id', '!=', 2)
                            ->whereMonth('created_at', $currentMonth)
                            ->whereYear('created_at', $currentYear)
                            ->get();

        // Truyền dữ liệu sang view
        return view('admin.doanhthu', compact(
            'totalEmployees',
            'totalProducts',
            'totalOrders',
            'bannedEmployees',
            'totalIncome',
            'newEmployees',
            'outOfStockProducts',
            'canceledOrders',
            'currentMonth',
            'currentYear',
            'month',
            'topSellingProducts',
            'orders',
            'outOfStockProducts2',
            'newEmployees2'
        ));
    }
}
