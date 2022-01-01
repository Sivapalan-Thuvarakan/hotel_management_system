<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Requests\RoomTypeRequest;
use DB;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = RoomType::orderBy('created_at','DESC')->paginate(5);
        return view('room-types.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('room-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomTypeRequest $request)
    {
        try {
            DB::beginTransaction();
            $roomType = new RoomType();
            $roomType->name = $request->name;
            $roomType->rental_price = $request->rental_price;
            $roomType->reservation_fee_percentage = $request->reservation_fee_percentage;
            $roomType->description = $request->description;
            $roomType->save();

            DB::commit();
            toastr()->success('Room Type added successfully');
            return redirect()->route('room_types.index');
        }  catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Room Type could not be added');
            return redirect()->route('room_types.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function show(RoomType $roomType)
    {
        return view('room-types.view',compact('roomType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomType $roomType)
    {
        return view('room-types.edit',compact('roomType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function update(RoomTypeRequest $request, RoomType $roomType)
    {
        try {
            DB::beginTransaction();
            $roomType->name = $request->name;
            $roomType->rental_price = $request->rental_price;
            $roomType->description = $request->description;
            $roomType->save();

            DB::commit();
            toastr()->success('Room Type updated successfully');
            return redirect()->route('room_types.index');
        }  catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Room Type could not be updated');
            return redirect()->route('room_types.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomType $roomType)
    {
        try {
            $roomType->delete();
            toastr()->success('Room Type deleted successfully');
            return redirect()->route('room_types.index');
         } catch (\Exception $e) {
            toastr()->error('The record could not be deleted');
            return redirect()->route('room_types.index');
         }
    }
}
