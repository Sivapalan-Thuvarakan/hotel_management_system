<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\ExampleMail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::with(['roles','roles.permissions']);

        $search =$request->search;
        $role =$request->role;

        if(Auth::user()->isSuperAdmin() == false){
            $data = $data->where('department_id', Auth::user()->department_id);
        }

        if(isset($role) && $role==''){
            $data = $data->with([
                'roles' => function ($query) use ($role) {
                    $query->where('id', '=', $role);
                }
            ]);
        }

        if(isset($search) && $search!=''){
            $data = $data->where('name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%');
        }

        $data = $data->where('id','!=',Auth::user()->id)->orderBy('created_at','DESC')->paginate(5);

        $roles =[];
        return view('users.index',compact('data','search','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->isSuperAdmin() == true){
            $roles = Role::whereNotIn('name',['super_admin'])->get();
        }elseif(Auth::user()->isAdmin() == true){
            $roles = Role::whereNotIn('name',['super_admin','admin'])->get();
        }else{
            $roles = Role::whereNotIn('name',['super_admin','admin'])->get();
        }
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->email_verified_at =  now();
            $user->password = bcrypt($request->password);

            if(Auth::user()->isAdmin() == true){
                $user->department_id = Auth::user()->department_id;
            }

            $user->save();
            DB::table('model_has_roles')->insert([
                ['model_id'=>$user->id, 'model_type' => 'App\Models\User', 'role_id'=>$request->role]
            ]);
            // $role_permissions = DB::table('role_has_permissions')->where('role_id' , $request->role)->get();
            // foreach ($role_permissions as $key => $permission) {
            //     DB::table('model_has_permissions')->insert([
            //         ['model_id'=>$user->id, 'model_type' => 'App\Models\User', 'permission_id'=>$permission->permission_id]
            //     ]);
            // }
            // Mail::to($request->email)->send(new ExampleMail());
            DB::commit();
            toastr()->success('User added successfully');
            return redirect()->route('users.index');

        } catch(\Exception $e) {
            DB::rollback();
            toastr()->error('User could not be added');
            return redirect()->route('users.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // if(Auth::user()->isSuperAdmin() == false){
        //     $user = $user->where('department_id', Auth::user()->department_id)->first();
        // }
        // $roles = Role::all();

        // $userPermissions = $user->permissions->groupBy('group_name');


        return view('users.view',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $permissions = Permission::all();
        if(Auth::user()->isSuperAdmin() == false){
            $permissions = $permissions->except([1,2,3,4]);
             $user = $user->where('department_id', Auth::user()->department_id)->first();
        }
        $permissions = $permissions->groupBy('group_name');
        $roles = Role::all()->except(1);
        return view('users.edit',compact('user','roles',  'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {
            DB::beginTransaction();
            if($user->is_active == 1){
                $user->is_active = 0;
            }else {
                $user->is_active = 1;
            }
            $user->save();

            DB::commit();
            toastr()->success('User status changed successfully');
            return redirect()->route('users.show',$user->id);
        }  catch (\Exception $e) {
            DB::rollback();
            toastr()->error('User status could not be changed');
            return redirect()->route('users.show',$user->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
