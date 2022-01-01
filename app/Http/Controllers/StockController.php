<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\StockRequest;
use DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::get();
        return view('stocks.index',compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::get();
        return view('stocks.create',compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockRequest $request)
    {
        
        try {
            DB::beginTransaction();
            $stock = new Stock();
            $stock->product_name = $request->product_name;
            $stock->brand = $request->brand;
            $stock->purchase_price = (double)$request->purchase_price;
            $stock->quantity = (int)$request->quantity;
            $stock->description = $request->description;
            $stock->type = $request->type;
            $stock->is_product = 0;
            
            
           
            //hardcode
            
            $stock->user_id = Auth::user()->id;
            $stock->department_id = Auth::user()->department_id;

            // $stock->user_id = "1";         
            // $stock->department_id = "1";

            $stock->supplier_id = $request->supplier;

            $last = Stock::select('code')->latest()->first();
            if($last == null){
                $code = 'ST-'.(string)(100001) ;
            }else{
                $code_num =  ((int) ltrim($last->code, "ST-"))+ 1;
                $code = 'ST-'. (string) $code_num;
            }

            $stock->code = $code;
            $stock->save();

            DB::commit();
            toastr()->success('Stocks added successfully');
            return redirect()->route('stocks.index');
        }  catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
            toastr()->error('Stock could not be added');
            return redirect()->route('stocks.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        return view('stocks.view',compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        $suppliers = Supplier::get();
        return view('stocks.edit',compact('stock','suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(StockRequest $request, Stock $stock)
    {
        try {
            DB::beginTransaction();
            $stock->product_name = $request->product_name;
            $stock->brand = $request->brand;
            $stock->purchase_price = (double)$request->purchase_price;
            $stock->quantity =(int)$request->quantity;
            $stock->description = $request->description;
            $stock->type = $request->type;
            $stock->is_product = 0;

            $stock->department_id = Auth::user()->department_id;
            $stock->user_id = Auth::user()->id;

            $stock->supplier_id = $request->supplier;

            $last = Stock::select('code')->latest()->first();
            if($last == null){
                $code = 'ST-'.(string)(100001) ;
            }else{
                $code_num =  ((int) ltrim($last->code, "ST-"))+ 1;
                $code = 'ST-'. (string) $code_num;
            }

            $stock->code = $code;

            $stock->save();

            DB::commit();
            toastr()->success('Stock is updated successfully');
            return redirect()->route('stocks.index');
        }  catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
            toastr()->error('Stock could not be updated');
            return redirect()->route('stocks.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        try {
            $stock->delete();
            toastr()->success('Stock is deleted successfully');
            return redirect()->route('stocks.index');
         } catch (\Exception $e) {
            toastr()->error('The record could not be deleted');
            return redirect()->route('stocks.index');
         }
    }
}
