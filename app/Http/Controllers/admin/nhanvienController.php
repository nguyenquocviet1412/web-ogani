<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\roles;
use App\Models\salaries;
use App\Models\User;
use App\Models\userbans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class nhanvienController extends Controller
{
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Trang quản lý nhân viên
    public function nhanvien(){
        //Lấy danh sách nhân viên
        $listNhanVien = User::where('Role_id', '!=', 2)->get();
        return view('admin.nhanvien', compact('listNhanVien'));
    }
    //Xóa nhân viên
    public function deleteNhanVien(User $user)
{
    // Chuyển thông tin của nhân viên sang bảng userban
    userbans::create([
        'name' => $user->Fullname,
        'Role_id' => $user->Role_id,
        'note' => 'Tạm khóa tài khoản để xem xét vào ngày ' . now(),
        'active' => 0, // Đặt trạng thái không hoạt động
    ]);

    // Xóa hình ảnh cũ nếu có
    if ($user->avatar) {
        Storage::delete($user->avatar);
    }

    // Xóa tài khoản khỏi bảng users
    $user->delete();

    return redirect()->route('admin.nhanvien')->with('message', 'Nhân viên đã được xóa thành công!');
}

    //Trang thêm mới nhân viên
    public function addnhanvien(){
        //Lấy danh sách role
        $listRole = roles::get();
        return view('admin.addnhanvien',compact('listRole'));
    }
    //Thêm mới nhân viên
    public function storenhanvien(Request $request){
        $data =$request->except('avatar');

        //khi chưa có hình ảnh
        $path = '';
        //khi có hình ảnh
        if($request->hasFile('avatar')){
            $path = $request->file('avatar')->store('avatar');

        }
        //Đưa đường dẫn hình vào data
        $data['avatar'] = $path;

        //Insert data
        // dd($data);
        $user = User::create($data);

        //Insert salary data
        $salary = 0;
        if ($user->Role_id == 3) {
            $salary = 5000000;
        } elseif ($user->Role_id == 1) {
            $salary = 10000000;
        }
        salaries::create([
            'id_user' => $user->id,
            'Role_id' => $user->Role_id,
            'salary' => $salary,
            'salary_deduction' => 0,
            'bonus' => 0,
            'active' => 0,
        ]);

        return redirect()->route('admin.nhanvien')->with('message', 'Tài khoản đã được thêm thành công!');
    }
    //Trang cập nhật thông tin nhân viên
    public function editnhanvien(User $user){
        //Lấy danh sách role
        $listRole = roles::get();
        //Trả về trang cập nhật thông tin nhân viên
        return view('admin.editnhanvien', compact('user', 'listRole'));
    }
    //Cập nhật thông tin nhân viên
    public function updatenhanvien(Request $request, User $user){

        $data =$request->except('avatar');

        //khi chưa có hình ảnh
        $path = $user->avatar;
        //khi có hình ảnh
        if($request->hasFile('avatar')){
            //xóa hình ảnh cũ
            Storage::delete($user->avatar);
            //lưu hình ảnh mới
            $path = $request->file('avatar')->store('avatar');
        }
        //Đưa đường dẫn hình vào data
        $data['avatar'] = $path;

        //Update user data
    $oldRoleId = $user->Role_id;
    $user->update($data);

    //Update salary data if Role_id changes
    if ($oldRoleId != $user->Role_id) {
        $salary = 0;
        if ($user->Role_id == 3) {
            $salary = 5000000;
        } elseif ($user->Role_id == 1) {
            $salary = 10000000;
        }

        $salaryRecord = salaries::where('id_user', $user->id)->first();
        if ($salaryRecord) {
            $salaryRecord->update([
                'Role_id' => $user->Role_id,
                'salary' => $salary,
            ]);
        }
    }

        return redirect()->route('admin.nhanvien')->with('message', 'Tài khoản đã được cập nhật thành công!');
    }

}
