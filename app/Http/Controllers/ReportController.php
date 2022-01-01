<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DateTime;

class ReportController extends Controller
{
    public function reservationReport(Request $request)
    {
        $dt = new DateTime();
        $department = Auth::user()->department_id;
        $data = [];


        $from = $request->has('from') ? $request->from : $dt->format('Y-m-d');

        $to = $request->has('to') ? $request->to : $dt->format('Y-m-d');

        $type = empty($request->type) ? "MONTH" :  $request->type;

        $total_amount = 0;
        $total_amount_rec = 0;
        $total_unit = 0;
        $total_qty = 0;

        if(strcmp($type,"MONTH") == 0){
            $data = DB::table('room_reservations')
                    ->join('reservation_payments','reservation_payments.reservation_id','=','room_reservations.id')
                    ->where('room_reservations.status','=','closed')
                    ->select( DB::raw("DATE_FORMAT(room_reservations.check_out_date, '%Y-%m (%M)') as date") ,
                                    DB::raw('COUNT(room_reservations.code) as reservation_count'),
                                    DB::raw('SUM(room_reservations.total_payable) as payment_total'),
                                    DB::raw('SUM(reservation_payments.payments) as payment_total_received'))
                        ->groupBy('date');
            $data = $data->get();

            // dd($data);
        }
        elseif(strcmp($type,"YEAR") == 0){
            $data = DB::table('room_reservations')
                    ->leftjoin('reservation_payments','reservation_payments.reservation_id','=','room_reservations.id')
                    ->where('room_reservations.status','=','closed')
                    ->select( DB::raw("DATE_FORMAT(room_reservations.check_out_date, '%Y') as date") ,
                                    DB::raw('COUNT(room_reservations.code) as reservation_count'),
                                    DB::raw('SUM(room_reservations.total_payable) as payment_total'),
                                    DB::raw('SUM(reservation_payments.payments) as payment_total_received'))
                        ->groupBy('date');
            $data = $data->get();
        }
        elseif(strcmp($type ,"CUSTOMER") == 0){
            $data  = DB::table('room_reservations')
                    ->leftjoin('reservation_payments','reservation_payments.reservation_id','=','room_reservations.id')
                    ->where('room_reservations.status','=','closed')
                    ->leftjoin('customers','customers.id','=','room_reservations.customer_id')
                    ->select(DB::raw("CONCAT(customers.first_name,' ',customers.last_name) as full_name"),
                                        DB::raw('COUNT(room_reservations.id) as qty'),
                                        DB::raw('SUM(room_reservations.total_payable) as payment_total'),
                                        DB::raw('SUM(reservation_payments.payments) as payment_total_received')
                                    )
                ->groupBy('full_name');
            $data  =  $data->get();
        }

        $data = $data;
        $type = $type;

        return view('reports.reservation-income-report',compact('data','from','to','type'));
    }
}
