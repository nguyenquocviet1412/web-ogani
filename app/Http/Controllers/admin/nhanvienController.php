<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\roles;
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
        //validate tài khoản
        // $data = $request->validate( [
        //     'Fullname' =>'required|min:3|max:100',
        //     'email' =>'required|email',
        //     'address' =>'',
        //     'Phone_number'=>'',
        //     'password' => 'required|min:5|max:32',
        //     'role_id' =>'required',
        //     'avatar' => 'nullable|image',
        // ]);

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
        User::create($data);

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

        //Update data
        $user->update($data);

        return redirect()->route('admin.nhanvien')->with('message', 'Tài khoản đã được cập nhật thành công!');
    }

}
