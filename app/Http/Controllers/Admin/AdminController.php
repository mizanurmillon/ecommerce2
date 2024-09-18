<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    //Admin home-------
    public function Admin(){
        return view('admin.home');
    }
    //admin logout-----
    public function AdminLogout()
    {
        Auth::logout();
        $notification = array('message' => 'You are logged out!','alert-type'=>'success' );
        return redirect()->route('admin.login')->with($notification);
    }
    //Password Change ------------
    public function PasswordChange()
    {
        return view('admin.profile.password_change');
    }
    //password Update----------
    public function Update(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        $current_password=Auth::user()->password;
        $oldpass=$request->old_password;
        $password=$request->password;
        if (Hash::check($oldpass, $current_password)) {
           $user=User::findorfail(Auth::id());
           $user->password=Hash::make($request->password);
           $user->save();
           Auth::logout();
           $notification=array('message' => 'Your Password Changed!', 'alert-type' => 'success'); 
           return redirect()->route('admin.login')->with($notification);
        }else{
            $notification=array('message' => 'old password not matched!', 'alert-type' => 'error'); 
             return redirect()->back()->with($notification);
        }
    }
}
