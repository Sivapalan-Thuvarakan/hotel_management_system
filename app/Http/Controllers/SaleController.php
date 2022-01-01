<?php

namespace App\Http\Controllers;
use DB;
use DateTime;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
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

        $sales = DB::table('sales');
        // $sales = DB::table('sales')->with('[customer]');
        if (!empty($search) and !is_null($search)  && $search != "") {
            $sales = $sales->where(function ($query) use ($search) {
                $query->where('sales.code', 'LIKE', '%' . $search . '%');
            });
        }

        if (!empty($from) and !empty($to) and !is_null($from) and !is_null($to)) {
            $sales = $sales->where(function ($query) use ($from, $to) {
                $query->where('sales.created_at', '>=', $from)
                    ->where('sales.created_at', '<=', $to);
            });
        }
        
        $sales = $sales->paginate(5);
        return view('sales.index',compact('sales','search','from','to'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::get();
        return view('sales.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $sale = new Sale();
            $sale->sold_price = $request->discount_price;
            $sale->quantity = $request->quantity;
            $sale->customer_id = $request->customer_id;
            
            
           
            //hardcode
            
            $sale->user_id = Auth::user()->id;
            $sale->department_id = Auth::user()->department_id;


            $last = Sale::select('code')->latest()->first();
            if($last == null){
                $code = 'SA-'.(string)(100001) ;
            }else{
                $code_num =  ((int) ltrim($last->code, "SA-"))+ 1;
                $code = 'SA-'. (string) $code_num;
            }

            $sale->code = $code;
            $sale->save();

            DB::commit();
            toastr()->success('Sale added successfully');
            return redirect()->route('sales.index');
        }  catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
            toastr()->error('Sale could not be added');
            return redirect()->route('sales.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }

    public function calculatePayment(Request $request){
        DB::beginTransaction();
        try {
        
            $product = Product::find($request->product_id);
            $quantity = $request->quantity;

            if(!empty($quantity)){
                $discount_percentage=($product->discount)/100;
                $discount=(($product->selling_price)*$discount_percentage);
                $discount_price=($product->selling_price) - $discount;
                $total_bill = ($discount_price) * ($quantity);
            }

            $arr = array('discount_percentage'=>$discount_percentage,'discount_price'=>$discount_price,'total_bill'=>$total_bill,'discount'=>$discount);
            DB::commit();

            $response["msg"] = 'sales created successfully.';
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
