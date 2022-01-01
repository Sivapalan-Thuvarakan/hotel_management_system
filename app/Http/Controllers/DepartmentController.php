<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Department::select('departments.id as id','departments.name as name','departments.code as code','users.name as admin')
        ->whereNotIn('department_id', [Auth::user()->department_id])
        ->leftJoin('users','users.department_id','=','departments.id')
        ->orderBy('departments.created_at','DESC')->paginate(5);
        return view('departments.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $main_departments = Department::where('type','=','main')->where('id','!=',Auth::user()->department_id)->get();
        $admin_role = Role::select('id')->where('name','=','admin')->first();
        $admins = User::select('users.id as id','users.name as name')
        ->leftJoin('model_has_roles','model_has_roles.model_id','=','users.id')
        ->where('model_has_roles.role_id','=',$admin_role->id)
        ->where('users.id','!=',Auth::user()->department_id)
        ->whereNull('users.department_id')
        ->get();
        return view('departments.create',compact('admins','main_departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        try {
            DB::beginTransaction();
            if(Auth::user()->isSuperAdmin() == true){
                $last = Department::select('code')->latest()->first();
                if($last == null){
                    $code = 'D-'.(string)(100001) ;
                }else{
                    $code_num =  ((int) ltrim($last->code, "D-"))+ 1;
                    $code = 'D-'. (string) $code_num;
                }

                $department = new Department();
                if($request->has('is_sub')){
                    if($request->has('parent_id')){
                        $department->parent_id = $request->parent_id;
                    }
                }
                $department->name = $request->name;
                $department->code = $code;
                if($request->has('is_sub')){
                    if($request->has('parent_id')){
                        $department->type ='sub';
                    }
                }else{
                    $department->type ='main';
                }
                $department->address = $request->address;
                $department->contact_no = $request->contact_no;

                $department->save();

                $admin = User::find($request->admin_id);
                $admin->department_id = $department->id;
                $admin->save();

            } else {
                $last = Department::select('code')->latest()->first();
                if($last == null){
                    $code = 'D-'.(string)(100001) ;
                }else{
                    $code_num =  ((int) ltrim($last->code, "D-"))+ 1;
                    $code = 'D-'. (string) $code_num;
                }
                $department = new Department();
                $department->parent_id = Auth::user()->department_id;
                $department->name = $request->name;
                $department->code = $code;
                $department->type ='sub';
                $department->address = $request->address;
                $department->contact_no = $request->contact_no;

                $department->save();
            }


            DB::commit();
            toastr()->success('Department added successfully');
            return redirect()->route('departments.index');
        }  catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Department could not be added');
            return redirect()->route('departments.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $department = Department::with('admin')->find($department->id);
        $admin_role = Role::select('id')->where('name','=','admin')->first();
        $admins = User::select('users.id as id','users.name as name')
        ->leftJoin('model_has_roles','model_has_roles.model_id','=','users.id')
        ->where('model_has_roles.role_id','=',$admin_role->id)
        ->where('users.id','!=',Auth::user()->department_id)
        ->whereNull('users.department_id')
        ->get();
        return view('departments.edit',compact('department','admins'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        try {
            DB::beginTransaction();
            $department->name = $request->name;
            $department->address = $request->address;
            $department->contact_no = $request->contact_no;

            $department->save();

            $oldAdmin = User::find($department->admin->id);
            $newAdmin = User::find($request->admin_id);
            if($newAdmin != $oldAdmin){
                $oldAdmin->is_active = 0;
                $newAdmin->department_id = $department->id;
                $oldAdmin->save();
                $newAdmin->save();
            }

            DB::commit();
            toastr()->success('Department updated successfully');
            return redirect()->route('departments.index');
        }  catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Department could not be updated');
            return redirect()->route('departments.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }

}
