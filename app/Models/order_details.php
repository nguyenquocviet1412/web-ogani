<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_details extends Model
{
    use HasFactory;
    protected $fillable = ['Order_id', 'Product_id','price', 'Number_of_products','Total_money'];
    public function order()
    {
        return $this->belongsTo(orders::class,'id');
    }
    public function product()
{
    return $this->belongsTo(products::class, 'Product_id');
}
}
