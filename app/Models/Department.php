<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function admin(){
        return $this->belongsTo(User::class,'id','department_id');
    }

    public function stocks(){
        return $this->hasMany(Stock::class,'id','stock_id');
    }

    public function sales(){
        return $this->hasMany(Sale::class,'id','sale_id');
    }

    public function products(){
        return $this->hasMany(Product::class,'id','product_id');
    }
}
