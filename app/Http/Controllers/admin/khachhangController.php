<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class khachhangController extends Controller
{
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Trang quản lý khách hàng
    public function khachhang(){
        //Lấy danh sách khách hàng
        $listkhachHang = User::where('Role_id', '=', 2)->get();
        return view('admin.khachhang',compact('listkhachHang'));
    }
    //Trang thêm mới khách hàng
    public function addkhachhang(){
        return view('admin.addkhachhang');
    }
    //Thêm mới khách hàng
    public function storekhachhang(Request $request){
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

        return redirect()->route('admin.khachhang')->with('message', 'Tài khoản đã được thêm thành công!');
    }
    //Trang cập nhật thông tin khách hàng
    public function editkhachhang(User $user){
        //Lấy danh sách role
        $listRole = roles::get();
        //Trả về trang cập nhật thông tin khách hàng
        return view('admin.editkhachhang', compact('user', 'listRole'));
    }
    //Cập nhật thông tin khách hàng
    public function updatekhachhang(Request $request, User $user){

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

        return redirect()->route('admin.khachhang')->with('message', 'Tài khoản đã được cập nhật thành công!');
    }

}
