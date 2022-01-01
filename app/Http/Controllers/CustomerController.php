<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use DB;
use Validator;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::get();
        return view('customers.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        try {
            DB::beginTransaction();
            $customer = new Customer();
            $customer->first_name = $request->fname;
            $customer->last_name = $request->lname;
            $customer->email = $request->email;
            $customer->phone_no = $request->phone_no;
            $customer->national_id = $request->national_id;

            $last = Customer::select('code')->latest()->first();
            if($last == null){
                $code = 'C-'.(string)(100001) ;
            }else{
                $code_num =  ((int) ltrim($last->code, "C-"))+ 1;
                $code = 'C-'. (string) $code_num;
            }

            $customer->code = $code;
            $customer->save();

            DB::commit();
            toastr()->success('Customer added successfully');
            return redirect()->route('customers.index');
        }  catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Customer could not be added');
            return redirect()->route('customers.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('customers.view',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {

        try {
            DB::beginTransaction();
            $customer->first_name = $request->fname;
            $customer->last_name = $request->lname;
            $customer->email = $request->email;
            $customer->phone_no = $request->phone_no;
            $customer->national_id = $request->national_id;
            $customer->save();

            DB::commit();
            toastr()->success('Customer is updated successfully');
            return redirect()->route('customers.index');
        }  catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
            toastr()->error('Customer could not be updated');
            return redirect()->route('customers.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            toastr()->success('Customer is deleted successfully');
            return redirect()->route('customers.index');
         } catch (\Exception $e) {
            toastr()->error('The record could not be deleted');
         }
    }

    public function customerSearch(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table('customers')
                ->select(DB::raw("CONCAT(customers.first_name,' ',customers.last_name) as full_name,customers.id,customers.national_id as nic, customers.code as code"))
                ->whereRaw("CONCAT(customers.first_name,' ',customers.last_name) LIKE ? ", "%$search%")
                ->orWhere('customers.code', 'LIKE', "%$search%")
                ->orWhere('customers.email', 'LIKE', "%$search%")
                ->orWhere('customers.national_id', 'LIKE', "%$search%")
                ->orWhere('customers.phone_no', 'LIKE', "%$search%")
                ->limit(5)
                ->get();
        }
        return response()->json($data);
    }

    public function customerAdd(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = array(
                'fname' => 'required',
                'lname' => 'required',
                'email' => 'nullable',
                'phone_no' => 'required',
                'address' => 'required',
                'national_id' => 'required|unique:customers,national_id',
            );

            $customMessages = [
                'fname.required' => 'Full Name is Required.',
                'lname.required' => 'Last Name is Required.',
                'phone_no.required' => 'Phone No is Required.',
                'address.required' => 'Address is Required.',
                'national_id.unique' => 'National ID should be unique.',
                'national_id.required' => 'National ID is Required.'
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);

            if ($validator->fails()) {
                $response["msg"] = 'Something went wrong';
                $response["status"] = "Failed";
                $response["data"] = $validator->messages();;
                $response["is_success"] = false;
                return response()->json($response);
            }

            $customer = new Customer();
            $customer->first_name = $request->fname;
            $customer->last_name = $request->lname;
            $customer->email = $request->email;
            $customer->phone_no = $request->phone_no;
            $customer->national_id = $request->national_id;

            $last = Customer::select('code')->latest()->first();
            if($last == null){
                $code = 'C-'.(string)(100001) ;
            }else{
                $code_num =  ((int) ltrim($last->code, "C-"))+ 1;
                $code = 'C-'. (string) $code_num;
            }

            $customer->code = $code;
            $customer->save();

            DB::commit();

            $response["msg"] = 'Patient has been saved successfully.';
            $response["status"] = "Success";
            $response["data"] = $customer;
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
