<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;
    protected $appends = ['room_count'];
    public function getRoomCountAttribute($value)
    {
        $rooms = Room::where('room_type_id', '=', $this->id)->where('status','=','open')->get();
        $count = $rooms->count();
        return $count;
    }

    public function rooms()
    {
        return $this->hasMany('App\Models\Room','room_type_id');
    }
}
