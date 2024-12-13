<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\userbans;
use Illuminate\Http\Request;

class noiboController extends Controller
{
    //Trang nội bộ
    public function noibo(){
        // Lấy tất cả dữ liệu từ bảng userbans
    $userbans = userbans::all();
    return view('admin.noibo', compact('userbans'));
    }
    //Xóa thông tin nhân viên dùng bị khoá
    public function destroy($id){
        userbans::destroy($id);
        return redirect()->route('admin.noibo')->with('message', 'Thông tin người dùng đã bị khoá thành công!');
    }
    //Trang sửa nhân viên bị ban
    public function edit($id)
{
    $userban = userbans::findOrFail($id); // Tìm bản ghi theo ID

    // Trả về view edit và truyền dữ liệu userban
    return view('admin.editnoibo', compact('userban'));
}
    //Cập nhật thông tin nhân viên bị ban
    public function update(Request $request, $id)
    {
        $userban = userbans::findOrFail($id); // Tìm bản ghi theo ID

        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'Role_id' => 'required|integer',
            'note' => 'nullable|string|max:255',
            'active' => 'required|boolean',
        ]);

        // Cập nhật dữ liệu
        $userban->update([
            'name' => $request->name,
            'Role_id' => $request->Role_id,
            'note' => $request->note,
            'active' => $request->active,
        ]);

        // Quay về danh sách với thông báo
        return redirect()->route('admin.noibo')->with('message', 'Cập nhật thành công!');
    }
    //Trang tạo mới nhân viên bị ban
    public function create(){
        return view('admin.addnoibo');
    }
    //Thêm mới nhân viên bị ban
    public function store(Request $request){
        $request->validate([
            'name' =>'required|string|max:255',
            'Role_id' =>'required|integer',
            'note' => 'nullable|string|max:255',
            'active' =>'required|boolean',
        ]);

        userbans::create($request->all());

        return redirect()->route('admin.noibo')->with('message', 'Thông tin người dùng đã bị khoá thành công!');
    }

}
