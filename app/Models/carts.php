<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carts extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = ['id_user', 'Product_id', 'Number_of_product','price'];
    public function product()
{
    return $this->belongsTo(products::class, 'Product_id');
}

}
