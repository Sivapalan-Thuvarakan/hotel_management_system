<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role as ModelsRole;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Role::with('permissions')->orderBy('created_at','DESC')->paginate(5);
        return view('roles.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::where('group_name','!=','Main-Department')->get()->groupBy('group_name');
        return view('roles.create', compact('permissions'));
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
            $role = ModelsRole::create(['name' => $request->name]);

            $role->syncPermissions($request->permissions);

            DB::commit();
            toastr()->success('Role added successfully');
            return redirect()->route('roles.index');
        }  catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Role could not be added');
            return redirect()->route('roles.index');
        }
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
    public function edit(Role $role)
    {
        $permissions = Permission::where('group_name','!=','Main-Department')->get()->groupBy('group_name');
        return view('roles.edit', compact('permissions', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelsRole $role)
    {
        try {
            DB::beginTransaction();
            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions);

            DB::commit();
            toastr()->success('Role added successfully');
            return redirect()->route('roles.index');
        }  catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Role could not be added');
            return redirect()->route('roles.index');
        }
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
