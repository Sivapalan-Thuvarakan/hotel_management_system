<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use App\Http\Requests\TestRequest;
use DB;
class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Test::orderBy('created_at','DESC')->paginate(5);
        return view('tests.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestRequest $request)
    {
        try {
            DB::beginTransaction();
            $test = new Test();
            $test->name = $request->name;
            $test->description = $request->description;
            $test->save();

            DB::commit();
            toastr()->success('Test added successfully');
            return redirect()->route('tests.index');
        }  catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Test could not be added');
            return redirect()->route('tests.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        return view('tests.view',compact('test'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        return view('tests.edit',compact('test'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(TestRequest $request, Test $test)
    {
        try {
            DB::beginTransaction();
            $test->name = $request->name;
            $test->description = $request->description;
            $test->save();

            DB::commit();
            toastr()->success('Test updated successfully');
            return redirect()->route('tests.index');
        }  catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
            toastr()->error('Test could not be updated');
            return redirect()->route('tests.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        try {
            $test->delete();
            toastr()->success('Test deleted successfully');
            return redirect()->route('tests.index');
         } catch (\Exception $e) {
            toastr()->error('The record could not be deleted');
         }
    }
}
