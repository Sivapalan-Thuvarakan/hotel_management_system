<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedRoom extends Model
{
    use HasFactory;

    public function roomType(){
        return $this->hasOne(RoomType::class,'room_type_id','id');
    }
}
