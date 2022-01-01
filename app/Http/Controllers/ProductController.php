<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use DB;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();
        return view('products.index',compact('products')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
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
            $rules = array(
                'selling_price' => 'required',
                'discount' => 'required',
            );

            $customMessages = [
                'selling_price.required' => 'selling is Required.',
                'discount.required' => 'Discount is Required.',
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);

         
            if ($validator->fails()) {
                $response["msg"] = 'Something went wrong';
                $response["status"] = "Failed";
                $response["data"] = $validator->messages();;
                $response["is_success"] = false;
                return response()->json($response);
            }
            $product = new Product();
            $product->selling_price = (double)$request->selling_price;
            $product->discount = $request->discount;
            $product->product_name = $request->product_name;
           
            $product->user_id = Auth::user()->id;
            $product->department_id = Auth::user()->department_id;
            $product->stock_id = $request->stock_id;

            $last = Product::select('code')->latest()->first();
            if($last == null){
                $code = 'P-'.(string)(100001) ;
            }else{
                $code_num =  ((int) ltrim($last->code, "P-"))+ 1;
                $code = 'P-'. (string) $code_num;
            }

            $product->code = $code;
            $product->save();
            
            $stock = Stock::find($request->stock_id);
            $stock->is_product=1;
            $stock->save();

            DB::commit();

            $response["msg"] = 'Product has been saved successfully.';
            $response["status"] = "Success";
            $response["data"] = $product;
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $stock = Stock::find($product->stock_id);
        return view('products.view',compact('product','stock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $stock = Stock::find($product->stock_id);
        return view('products.edit',compact('product','stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();
            $product->product_name = $request->product_name;
            $product->selling_price = (double)$request->selling_price;
            $product->discount = $request->discount;
            //hardcode
            $product->user_id = Auth::user()->id;
            $product->department_id = Auth::user()->department_id;

            $last = Product::select('code')->latest()->first();
            if($last == null){
                $code = 'P-'.(string)(100001) ;
            }else{
                $code_num =  ((int) ltrim($last->code, "P-"))+ 1;
                $code = 'P-'. (string) $code_num;
            }

            $product->code = $code;
            $product->save();
            DB::commit();
            toastr()->success('Product is updated successfully');
            return redirect()->route('products.index');
        }  catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
            toastr()->error('Product could not be updated');
            return redirect()->route('products.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $stock = Stock::find($product->stock_id);
            $stock->is_product=0;
            $stock->save();
            $product->delete();
            toastr()->success('Product is deleted successfully');
            return redirect()->route('products.index');
         } catch (\Exception $e) {
            toastr()->error('The record could not be deleted');
            return redirect()->route('products.index');
         }
    }

    public function productCreate()
    {  
        $stocks=Stock::where('is_product',0)->get();
        return view('products.add_product',compact('stocks'));
    }

    public function productStore(Request $request)
    {
        try {
            DB::beginTransaction();
            $product = new Product();
            $product->selling_price = (double)$request->selling_price;
            $product->discount = $request->discount;
            $product->product_name = $request->product_name;
           
            $product->user_id = Auth::user()->id;
            $product->department_id = Auth::user()->department_id;
            $product->stock_id = $request->stock_id;

            $last = Product::select('code')->latest()->first();
            if($last == null){
                $code = 'P-'.(string)(100001) ;
            }else{
                $code_num =  ((int) ltrim($last->code, "P-"))+ 1;
                $code = 'P-'. (string) $code_num;
            }

            $product->code = $code;
            $product->save();
            
            $stock = Stock::find($request->stock_id);
            $stock->is_product=1;
            $stock->save();

            DB::commit();
            toastr()->success('Price added successfully');
            return redirect()->route('products.productCreate');
        }  catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
            toastr()->error('Price could not be added');
            return redirect()->route('products.productCreate');
        }
    }

    public function productSearch(Request $request)
    {
        $data = [];
        
        if($request->has('q')){
            $search = $request->q;
            $data = DB::table('products')
                ->select(DB::raw("products.product_name as product_name,products.id,products.code as code,products.selling_price as selling_price,products.discount as discount"))
                ->whereRaw('products.code LIKE ?', "%$search%") 
                ->orWhere('products.product_name', 'LIKE', "%$search%")
                ->orWhere('products.selling_price', 'LIKE', "%$search%")
                ->orWhere('products.discount', 'LIKE', "%$search%")
                ->limit(5)
                ->get();
        }
        return response()->json($data);
    }

}
