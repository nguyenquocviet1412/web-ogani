<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\salaries;
use App\Models\User;
use Illuminate\Http\Request;

class salariesController extends Controller
{
    //Trang danh sách lương
    public function index(){
        // Lấy danh sách bảng lương
        $salaries = salaries::all();
        return view('admin.luong', compact('salaries'));
    }
    //Trang thêm bảng lương
    public function create()
{
    // Lấy danh sách user có Role_id khác 2 và chưa có trong bảng salaries
    $users = User::where('Role_id', '!=', 2)
                 ->whereDoesntHave('salaries') // Lọc các nhân viên không tồn tại trong bảng salaries
                 ->get();
    return view('admin.addluong', compact('users'));
}
    //Thêm mới bảng lương
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'id_user' => 'required|exists:users,id',
        'salary' => 'required|numeric|min:0',
        'salary_deduction' => 'nullable|numeric|min:0',
        'bonus' => 'nullable|numeric|min:0',
        'status' => 'required|in:Đã nhận tiền,Chưa nhận tiền',
    ]);

    try {
        // Lấy Role_id từ User
        $user = User::findOrFail($request->id_user);

        // Lưu vào bảng salaries
        salaries::create([
            'id_user' => $user->id,
            'Role_id' => $user->Role_id,
            'salary' => $request->salary,
            'salary_deduction' => $request->salary_deduction ?? 0,
            'bonus' => $request->bonus ?? 0,
            'active' => ($request->status === 'Đã nhận tiền') ? 1 : 0,
        ]);

        return redirect()->route('salaries.index')->with('success', 'Bảng lương đã được thêm thành công!');
    } catch (\Exception $e) {
        // Bắt lỗi và hiển thị thông báo
        return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
    }
}


    //Trang cập nhật bảng lương
    public function edit($id)
{
    $salary = salaries::findOrFail($id); // Tìm bảng lương theo ID
    $users = User::where('Role_id', '!=', 2)->get(); // Lấy danh sách nhân viên (Role_id khác 2)
    return view('admin.editluong', compact('salary', 'users')); // Trả về view chỉnh sửa
}
    //Cập nhật bảng lương
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'id_user' => 'required|exists:users,id',
        'salary' => 'required|numeric|min:0',
        'salary_deduction' => 'required|numeric|min:0',
        'bonus' => 'required|numeric|min:0',
        'active' => 'required|boolean',
    ]);

    try{
        $salary = salaries::findOrFail($id); // Tìm bảng lương theo ID

            // Cập nhật thông tin
            $salary->update([
                'id_user' => $validated['id_user'],
                'salary' => $validated['salary'],
                'salary_deduction' => $validated['salary_deduction'],
                'bonus' => $validated['bonus'],
                'active' => $validated['active'],
            ]);

            return redirect()->route('salaries.index')->with('success', 'Bảng lương được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->route('salaries.index')->with('error', 'Đã xảy ra lỗi khi cập nhật bảng lương. Vui lòng thử lại!');
        }

}

    //Xóa bảng lương
    public function destroy($id)
{
    try {
        $salary = salaries::findOrFail($id);
        $salary->delete();
        return redirect()->route('salaries.index')->with('success', 'Bảng lương đã được xóa thành công!');
    } catch (\Exception $e) {
        return redirect()->route('salaries.index')->with('error', 'Xóa bảng lương thất bại. Vui lòng thử lại!');
    }
}

}
