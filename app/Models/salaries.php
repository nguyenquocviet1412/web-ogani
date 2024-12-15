<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salaries extends Model
{
    use HasFactory;
    protected $fillable = ['id_user', 'Role_id', 'salary','salary_deduction','bonus','active'];
    public function user()
{
    return $this->belongsTo(User::class, 'id_user');
}
}
