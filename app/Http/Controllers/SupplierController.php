<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;
use DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::get();
        return view('suppliers.index',compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        try {
            DB::beginTransaction();
            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone_no = $request->phone_no;
            $supplier->address = $request->address;

            $last = Supplier::select('code')->latest()->first();
            if($last == null){
                $code = 'S-'.(string)(100001) ;
            }else{
                $code_num =  ((int) ltrim($last->code, "S-"))+ 1;
                $code = 'S-'. (string) $code_num;
            }

            $supplier->code = $code;
            $supplier->save();

            DB::commit();
            toastr()->success('Supplier added successfully');
            return redirect()->route('suppliers.index');
        }  catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Supplier could not be added');
            return redirect()->route('suppliers.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return view('suppliers.view',compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit',compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        try {
            DB::beginTransaction();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone_no = $request->phone_no;
            $supplier->address = $request->address;
            $supplier->save();

            DB::commit();
            toastr()->success('Supplier is updated successfully');
            return redirect()->route('suppliers.index');
        }  catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
            toastr()->error('Supplier could not be updated');
            return redirect()->route('suppliers.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            toastr()->success('supplier is deleted successfully');
            return redirect()->route('suppliers.index');
         } catch (\Exception $e) {
            toastr()->error('The record could not be deleted');
         }
    }
}
