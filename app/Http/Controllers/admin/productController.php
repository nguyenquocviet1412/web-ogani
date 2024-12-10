<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\categories;
use App\Models\origins;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class productController extends Controller
{
    //Trang sản phẩm
    public function sanpham(){
        $listProducts = products::with('category','origin')->get();

        return view('admin.product',compact('listProducts'));
    }
    //Trang thêm sản phẩm
    public function addSanPham(){
        $listCategories =categories::get();
        $listOrigins =origins::get();


        return view('admin.addsanpham',compact('listCategories','listOrigins'));
    }
    //Thêm xuất xứ
    public function storeXuatXu(Request $request){
        $data = $request->validate([
            'name' =>'required',
        ]);

        $origin = origins::create($data);

        // Trả về phản hồi JSON để AJAX xử lý
    return response()->json([
        'success' => true,
        'message' => 'Xuất xứ đã được thêm thành công!',
        'origin' => $origin
    ]);
    }
    //Thêm dah mục
    public function storedanhmuc(Request $request){
        $data = $request->validate([
            'name' =>'required',
        ]);
        $category = categories::create($data);

        // Trả về phản hồi JSON để AJAX xử lý
        return response()->json([
           'success' => true,
           'message1' => 'Danh mục đã được thêm thành công!',
            'category' => $category
        ]);
    }
    //Thêm sản phẩm
    public function storeSanPham(Request $request){
        $data = $request->validate([
            'name' =>'required',
            'price' =>'required',
            'quantity' =>'required',
            'description' =>'required',
            'category_id' =>'required',
            'origin_id' =>'required',
        ]);

        $data =$request->except('image');

        //khi chưa có hình ảnh
        $path = '';
        //khi có hình ảnh
        if($request->hasFile('image')){
            $path = $request->file('image')->store('product');

        }
        //Đưa đường dẫn hình vào data
        $data['image'] = $path;

        //Insert data
        // dd($data);

        $product = products::create($data);
        return redirect()->route('admin.sanpham')->with('message', 'Sản phẩm đã được thêm thành công!');
    }
    //Xóa sản phẩm
    public function deletesanpham($id){
        $product = products::where('Product_id', $id)->first();
        //xóa hình ảnh cũ
        if($product->image){
            Storage::delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.sanpham')->with('message', 'Sản phẩm đã xóa thành công!');
    }
    //Trang sửa sản phẩm
    public function editsanpham($id){
        $product = products::where('Product_id', $id)->first();
        $listCategories = categories::get();
        $listOrigins = origins::get();

        return view('admin.editsanpham',compact('product','listCategories','listOrigins'));
    }
    //Cập nhật sản phẩm
    public function updatesanpham(Request $request, $id){
        $product = products::where('Product_id', $id)->first();
        $data = $request->validate([
            'name' =>'required',
            'price' =>'required',
            'quantity' =>'required',
            'description' =>'nullable',
            'category_id' =>'required',
            'origin_id' =>'required',
        ]);

        $data =$request->except('image');

        //khi chưa có hình ảnh
        $path = $product->image;
        //khi có hình ảnh
        if($request->hasFile('image')){
            Storage::delete($product->image);
            $path = $request->file('image')->store('product');
        }
        //Đưa đường dẫn hình vào data
        $data['image'] = $path;

        //Update data
        $product->update($data);
        return redirect()->route('admin.sanpham')->with('message', 'Sản phẩm đã được cập nhật thành công!');
    }

}

