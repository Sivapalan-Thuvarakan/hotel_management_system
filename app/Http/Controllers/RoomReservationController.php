<?php

namespace App\Http\Controllers;

use DB;
use DateTime;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\ReservedRoom;
use Illuminate\Http\Request;
use App\Models\RoomReservation;
use App\Models\ReservationPayment;
use App\Http\Requests\RoomReservationRequest;
use Auth;

class RoomReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search ? $request->search : '';
        $from = $request->from ? $request->from : '';
        $to = $request->to ? $request->to : '';

        $data = DB::table('room_reservations')
        ->select('room_reservations.*',
        DB::raw("CONCAT(customers.first_name,' ',customers.last_name) as full_name,customers.id as customer_id"),
        'rooms.id as room_id','rooms.code as room_code','room_types.name as room_type')
        ->leftJoin('reserved_rooms','reserved_rooms.reservation_id','=','room_reservations.id')
        ->leftJoin('customers','customers.id','=','room_reservations.customer_id')
        ->leftJoin('rooms','reserved_rooms.room_id','=','rooms.id')
        ->leftJoin('room_types','room_types.id','=','rooms.room_type_id');

        if (!empty($search) and !is_null($search)  && $search != "") {
            $data = $data->where(function ($query) use ($search) {
                $query->where('room_reservations.code', 'LIKE', '%' . $search . '%')
                ->orWhere('customers.first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('customers.last_name', 'LIKE', '%' . $search . '%')
                ->whereRaw("CONCAT(customers.first_name,' ',customers.last_name) LIKE ? ", "%" . $search . "%");
            });
        }

        if (!empty($from) and !empty($to) and !is_null($from) and !is_null($to)) {
            $data = $data->where(function ($query) use($from,$to) {
                $query->where('room_reservations.check_in_date',  '>=',  $from)
                    ->where('room_reservations.check_out_date',  '<=',  $to);
            });
        }

        $data = $data->orderBy('room_reservations.created_at','DESC')
        ->paginate(5);
        return view('room-reservations.index',compact('data','search','from','to'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roomTypes = RoomType::get();
        return view('room-reservations.create',compact('roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomReservationRequest $request)
    {
        try{
            DB::beginTransaction();
            $datetime1 = new DateTime($request->from_date);
            $datetime2 = new DateTime($request->to_date);
            $roomType = RoomType::find($request->room_type_id);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');//now do whatever you like with $days

            if(!empty($roomType)){
                $totalRoomFee = ($roomType->rental_price) * ($days +1);
                $reservationFee = $roomType->rental_price * ($roomType->reservation_fee_percentage/100) * ($days +1);
            }


            $last = RoomReservation::select('code')->latest()->first();
            if($last == null){
                $code = 'RES-'.(string)(100001) ;
            }else{
                $code_num =  ((int) ltrim($last->code, "RES-"))+ 1;
                $code = 'RES-'. (string) $code_num;
            }

            $roomReservation = new RoomReservation();
            $roomReservation->code = $code;
            $roomReservation->check_in_date = $request->from_date;
            $roomReservation->check_out_date = $request->to_date;
            $roomReservation->total_payable = $totalRoomFee + $request->hotel_payment;
            $roomReservation->status = 'open';
            $roomReservation->department_id = Auth::user()->department_id;
            $roomReservation->customer_id = $request->customer_id;
            $roomReservation->save();

            $reservedRoom = new ReservedRoom();
            $reservedRoom->status = 'checked_in';
            $reservedRoom->room_id = $request->room_id;
            $roomTypeId = Room::find($request->room_id);
            $reservedRoom->room_type_id = $roomTypeId->room_type_id;
            $reservedRoom->reservation_id = $roomReservation->id;
            $reservedRoom->save();

            $room = Room::find($request->room_id);
            $room->status = 'reserved';
            $room->save();

            $reservationPayment = new ReservationPayment();
            $reservationPayment->payments = $request->payment_received;
            $reservationPayment->customer_id = $request->customer_id;
            $reservationPayment->reservation_id = $roomReservation->id;
            $reservationPayment->save();
            DB::commit();
            toastr()->success('Reservation added successfully');
            return redirect()->route('reservations.create');
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
            toastr()->error('Reservation Could not be added');
            return redirect()->route('reservations.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoomReservation  $roomReservation
     * @return \Illuminate\Http\Response
     */
    public function show(RoomReservation $roomReservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RoomReservation  $roomReservation
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomReservation $roomReservation)
    {
        $amountPaid = ReservationPayment::where('reservation_id',$roomReservation->id)->sum('payments');
        $toBePaid = $roomReservation->total_payable - $amountPaid;
        return view('room-reservations.edit',compact('roomReservation','amountPaid','toBePaid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoomReservation  $roomReservation
     * @return \Illuminate\Http\Response
     */
    public function update(RoomReservationRequest $request, RoomReservation $roomReservation)
    {
        try{
            DB::beginTransaction();
            $amountPaid = ReservationPayment::where('reservation_id',$roomReservation->id)->sum('payments');
            $toBePaid = $roomReservation->total_payable - $amountPaid;

            $reservationPayment = new ReservationPayment();
            $reservationPayment->payments = $request->amount_received;
            $reservationPayment->customer_id = $roomReservation->customer_id;
            $reservationPayment->reservation_id = $roomReservation->id;
            $reservationPayment->save();

            $reservedRoom = ReservedRoom::where('status','=','checked_in')->where('reservation_id',$roomReservation->id)->first();
            if($toBePaid == $request->amount_received){
                $reservedRoom->status = 'checked_out';
                $reservedRoom->save();
                $room = Room::find($reservedRoom->room_id);
                $room->status = 'open';
                $room ->save();
            }

            $roomReservation->status = 'closed';
            $roomReservation->save();
            DB::commit();
            toastr()->success('Reservation closed successfully');
            return redirect()->route('reservations.index');
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Reservation Could not be closed');
            return redirect()->route('reservations.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoomReservation  $roomReservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomReservation $roomReservation)
    {
        //
    }

    public function roomSearch ($id){
        $data = [];

        if($id){
            $data = DB::table('rooms')
                ->select(DB::raw("rooms.id as id ,rooms.code as code"))
                ->where('room_type_id','=',$id)
                ->where('department_id','=',Auth::user()->department_id)
                ->where('status','=','open')
                ->get();
        }
        return response()->json($data);
    }

    public function calculatePayment(Request $request){
        DB::beginTransaction();
        try {
            $datetime1 = new DateTime($request->from);
            $datetime2 = new DateTime($request->to);
            $roomType = RoomType::find($request->room_type_id);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');//now do whatever you like with $days

            if(!empty($roomType)){
                $totalRoomFee = ($roomType->rental_price) * ($days +1);
                $reservationFee = $roomType->rental_price * ($roomType->reservation_fee_percentage/100) * ($days +1);
            }

            $arr = array('totalRoomFee'=>$totalRoomFee, 'reservationFee' => $reservationFee);
            DB::commit();

            $response["msg"] = 'Patient has been saved successfully.';
            $response["status"] = "Success";
            $response["data"] = $arr;
            $response["is_success"] = true;
            return response()->json($response);
        } catch (\Throwable $th) {
            DB::rollback();
            $response["msg"] = 'Something went wrong.';
            $response["status"] = "Failed";
            $response["data"] = $th->getMessage();
            $response["is_success"] = true;
            return response()->json($response);
        }
    }
}
