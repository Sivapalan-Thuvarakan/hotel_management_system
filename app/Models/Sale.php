<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function products(){
        return $this->hasMany(Product::class,'id','product_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class,'id','customer_id');
    }
}
