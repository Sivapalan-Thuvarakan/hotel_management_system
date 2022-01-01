<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ReservedRoom;
use App\Models\Stock;
use App\Models\Room;
use App\Models\RoomReservation;
use App\Models\RoomType;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barDatas = [];
        $pieDatas = [];
        $customerCount = Customer::count();
        $reservationCount = RoomReservation::count();
        $piePreDatas = ReservedRoom::select(DB::raw('room_type_id, count(room_id) as count'))->groupBy('room_type_id')->get();
        $barPreDatas = Stock::select(DB::raw('type, count(id) as count'))->groupBy('type')->get();
        foreach($piePreDatas as $data){
            $roomType = RoomType::find($data->room_type_id);
            $pieDatas[$roomType->name] = $data->count;
        }

        foreach($barPreDatas as $data){
            $barDatas[$data->type] = $data->count;
        }

        return view('dashboard',compact('customerCount','reservationCount','barDatas','pieDatas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
