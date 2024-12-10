<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'image',
        'quantity',
        'description',
        'category_id',
        'origin_id',
        'luotxem'
    ];
    // Khai báo khóa chính
    protected $primaryKey = 'Product_id';

    // Nếu khóa chính không tự động tăng, khai báo:
    public $incrementing = false;

    // Đặt kiểu dữ liệu cho khóa chính
    protected $keyType = 'int'; // Nếu kiểu dữ liệu là string, sửa thành kiểu đúng nếu khác
    public function category()
    {
        // Chỉ định rõ cột khóa ngoại là 'category_id' (không phải 'categories_id')
        return $this->belongsTo(categories::class, 'category_id');
    }
    public function origin()
    {
        return $this->belongsTo(origins::class);
    }
    protected static function boot()
{
    parent::boot();

    static::saved(function ($product) {
        // Tìm tất cả các giỏ hàng liên quan đến sản phẩm vừa thay đổi
        $carts = carts::where('Product_id', $product->Product_id)->get();

        foreach ($carts as $cart) {
            // Cập nhật giá trong giỏ hàng
            $cart->price = $cart->Number_of_product * $product->price;
            $cart->save();
        }
    });
}
}
