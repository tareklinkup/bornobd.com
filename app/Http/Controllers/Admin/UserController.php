<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function register()
    {
        $user = User::all();
        return view('auth.register', compact('user'));
    }

    public function createUser(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|max:50',
            'username' => 'required|unique:users|max:50',
            'role' => 'required',
            'email' => 'required|unique:users|max:30',
            'image' => 'required|image|mimes:jpg,png,gif,bmp',
            'password' => 'required|confirmed|min:2',
            'ip_address' => 'max:15'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->image = $this->imageUpload($request, 'image', 'uploads/user') ?? '';
        $user->role = $request->role;
        $user->status = 1;
        $user->save_by = 1;
        $user->ip_address = $request->ip();
        $user->save();
        if ($user) {
            Session::flash('success', ' User Added Successfully');
            return back();
        } else {
            Session::flash('errors', ' something went wrong');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        $userList = User::all();
        return view('auth.edit', compact('user', 'userList'));
    }

    public function updateUser(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|max:50',
            // 'username' =>'required',
            'email' => 'required|max:30',
            'image' => 'image|mimes:jpg,png,gif,bmp',
            // 'password'=>'confirmed|min:2',
            'ip_address' => 'max:15'
        ]);
        $user = User::find($id);
        $duplicate = User::where('id', '!=',  $id)->where('email', $request->email)->get();
        if (count($duplicate) > 0) {
        } else {

            $userImage = '';
            if ($request->hasFile('image')) {
                if (!empty($user->image) && file_exists($user->image)) {
                    unlink($user->image);
                }
                $userImage = $this->imageUpload($request, 'image', 'uploads/user');
            } else {
                $userImage = $user->image;
            }
            $user->name = $request->name;
            $user->email = $request->email;
            // if ($request->password) {
            //     $user->password = Hash::make($request->password);
            // } else {
            //     $user->password = $user->password;
            // }
            $user->image = $userImage;
            $user->role = $request->role;
            $user->status = 1;
            $user->updated_by = 1;
            $user->ip_address = $request->ip();
            $user->save();
            if ($user) {
                Session::flash('success', ' User update Successfully');
                return back();
            } else {
                Session::flash('errors', ' something went wrong');
            }
        }
    }
    public function passwordChange(){
       return view('auth.password_change');
    }
    public function passwordUpdate(Request $request){
        $request->validate([
            'currentPass' => 'required',
            'password' => 'required|confirmed|min:2',
        ]);
        $currentPassword = Auth::user()->password;
        if (Hash::check($request->currentPass, $currentPassword)) {
            if (!Hash::check($request->password, $currentPassword)) {
                $user =Auth::user();
                $user->password = HasH::make($request->password);
                $user->save();
                if ($user) {
                    Session::flash('success', 'Password Update Successfully');
                   
                    return back();
                } else {
                    Session::flash('error', 'Current password not match');
                    return back();
                }
            } else {
                Session::flash('error', 'Same as Current password');
                return back();
            }
        } else {
            Session::flash('error', '!Current password not match');
            return back();
        }
    }
   

    public function deleteUser($id){
        $user = User::find($id);
        if($user->id != Auth::guard()->user()->id && $user->role != '1' ){
            if (!empty($user->image) && file_exists($user->image)) {
                unlink($user->image);
            }
            $user->delete();
            Session::flash('error', 'User Delete Successfully');
            return back();
        }else{
            Session::flash('error', 'Not Allow For delete User Account');
            return back();  
        }
    }
    
}
