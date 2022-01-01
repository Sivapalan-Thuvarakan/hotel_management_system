<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        return view('users.profile',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $user = User::find(Auth::user()->id);
            if (Hash::check($request->current_password, $user->password)) {
            $user->password=bcrypt($request->password);
            $user->save();

            toastr()->success('message', "Password has been changed successfully");
            return back();

            } else {

                toastr()->error('error', "Password mismatch please try again");
                return back();

            }
        }catch(\Exception $e){
            toastr()->error('error', "Something went wrong.");
            return back();
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

    public function updateDetails(ProfileRequest $request,$id){
        try{
        $rules = array(
            'name' => 'required|unique:users,name,'.$id,
        );

        $customMessages = [
            'name.required' => 'Name cannot be empty',
            'name.unique' => 'This name has already been taken. Please try with another.',

        ];

        $this->validate($request, $rules, $customMessages);

            $user = User::find($id);
            $user->name = $request->name;
            $user->nic_no = $request->nic_no;
            $user->address = $request->address;
            $user->save();

            DB::commit();
            toastr()->success('Profile updated successfully');
            return redirect()->route('profile.index');
        }  catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Profile could not be updated');
            return redirect()->route('profile.index');
        }
    }
}
