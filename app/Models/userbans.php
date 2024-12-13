<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userbans extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'Role_id', 'note','active'];
}
