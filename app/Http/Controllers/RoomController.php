<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->status ? $request->status : '';
        $search = $request->search ? $request->search : '';

        $data = Room::with('roomTypes');

        if(Auth::user()->isSuperAdmin() == false){
            $data->where('department_id', '=',Auth::user()->department_id);
        }

        if (!empty($search) and !is_null($search) ) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('code', 'LIKE', '%' . $search . '%');
            });
        }

        if(isset($status) && $status != "All"  && $status != "") {
            $data->where('status', '=', $status);
        }

        $data = $data->orderBy('created_at','DESC')->paginate(5);
        return view('rooms.index',compact('data','status','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roomTypes = RoomType::get();
        return view('rooms.create',compact('roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        try {
            DB::beginTransaction();

            $last = Room::select('code')->latest()->first();
            if($last == null){
                $code = 'R-'.(string)(100001) ;
            }else{
                $code_num =  ((int) ltrim($last->code, "R-"))+ 1;
                $code = 'R-'. (string) $code_num;
            }

            $room = new Room();
            $room->code = $code;
            $room->status = 'open';
            $room->description = $request->description;
            $room->room_type_id = $request->room_type_id;
            $room->department_id = Auth::user()->department_id;
            $room->save();

            DB::commit();
            toastr()->success('Room added successfully');
            return redirect()->route('rooms.index');
        }  catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Room could not be added');
            return redirect()->route('rooms.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        $room = Room::with('roomTypes','departments')->first();
        return view('rooms.view',compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        $roomTypes = RoomType::get();
        return view('rooms.edit',compact('room','roomTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, Room $room)
    {
        try {
            DB::beginTransaction();
            $room->description = $request->description;
            $room->room_type_id = $request->room_type_id;
            $room->save();

            DB::commit();
            toastr()->success('Room updated successfully');
            return redirect()->route('rooms.index');
        }  catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Room could not be updated');
            return redirect()->route('rooms.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        try {
            $room->delete();
            toastr()->success('Room deleted successfully');
            return redirect()->route('rooms.index');
        } catch (\Exception $e) {
            toastr()->error('The record could not be deleted');
            return redirect()->route('rooms.index');
        }
    }
}
