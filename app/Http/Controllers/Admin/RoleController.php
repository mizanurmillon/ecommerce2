<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    //__manage role__//
    public function index()
    {
        $data=DB::table('users')->where('is_admin',1)->where('role_admin',1)->get();
        return view('admin.role.index',compact('data'));
    }

    //__create role__//
    public function create()
    {
        return view('admin.role.create_role');
    }
    //__store role___//
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|unique:users',
        ]);
        $data=array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['password']=Hash::make($request->password);
        $data['category']=$request->category;
        $data['product']=$request->product;
        $data['offer']=$request->offer;
        $data['order']=$request->order;
        $data['blog']=$request->blog;
        $data['pickup']=$request->pickup;
        $data['ticket']=$request->ticket;
        $data['contact']=$request->contact;
        $data['report']=$request->report;
        $data['setting']=$request->setting;
        $data['userrole']=$request->userrole;
        $data['is_admin']=1;
        $data['role_admin']=1;
        DB::table('users')->insert($data);
        $notification=array('message' => 'UserRole Created!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //__role edit__//
    public function Edit($id)
    {
        $data=DB::table('users')->where('id',$id)->first();
        return view('admin.role.edit',compact('data'));
    }
    //__role update__//
    public function Update(Request $request)
    {
       
        $data=array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['category']=$request->category;
        $data['product']=$request->product;
        $data['offer']=$request->offer;
        $data['order']=$request->order;
        $data['blog']=$request->blog;
        $data['pickup']=$request->pickup;
        $data['ticket']=$request->ticket;
        $data['contact']=$request->contact;
        $data['report']=$request->report;
        $data['setting']=$request->setting;
        $data['userrole']=$request->userrole;
        DB::table('users')->where('id',$request->id)->update($data);
        $notification=array('message' => 'UserRole Updated!','alert-type' => 'success'); 
        return redirect()->route('manage.role')->with($notification);
    }

    //__role Delete__//
    public function Delete($id)
    {
        DB::table('users')->where('id',$id)->delete();
        $notification=array('message' => 'UserRole Deleted!','alert-type' => 'warning'); 
        return redirect()->back()->with($notification);
    }
    
    
}
