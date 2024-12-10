<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'User_id',
        'fullname',
        'email',
        'Phone_number',
        'note',
        'Order_date',
        'status',
        'Total_money',
        'Shipping_address',
        'Payment_id',
        'ative'
    ];
    public function orderDetails()
    {
        return $this->hasMany(order_details::class,'Order_id');
    }
}
