<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Hash;
use App\Models\User;
use Image;

class ProfileController extends Controller
{
     //
    public function __construct()
    {
        $this->middleware('auth');
    }
    //Profile Setting page---
    public function ProfileSetting()
    {
      return view('user.profile_setting');
    }
    //PasswordChange
    public function PasswordChange(Request $request)
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
           return redirect()->to('/')->with($notification);
        }else{
            $notification=array('message' => 'old password not matched!', 'alert-type' => 'error'); 
             return redirect()->back()->with($notification);
        }
    }
    //__MyOrder__
    public function MyOrder()
    {
        $order=DB::table('orders')->where('user_id',Auth::id())->orderBy('id','DESC')->get();
        return view('user.my_order',compact('order'));
    }
    //__order view
    public function orderView($id)
    {
        $order=DB::table('orders')->where('id',$id)->first();
        $order_details=DB::table('order_details')->where('order_id',$id)->get();
        return view('user.order_view',compact('order','order_details'));
    }
    //__OpenTicket___
    public function OpenTicket()
    {
        $ticket=DB::table('order_tickets')->where('user_id',Auth::id())->latest()->take(10)->get();
        return view('user.open_ticket',compact('ticket'));
    }
    //__NewTicket___
    public function NewTicket()
    {
        return view('user.new_ticket');
    }
    //__StoreTicket__
    public function StoreTicket(Request $request)
    {
        $data=array();
        $data['user_id']=Auth::id();
        $data['subject']=$request->subject;
        $data['service']=$request->service;
        $data['prortity']=$request->prortity;
        $data['message']=$request->message;
        $data['date']=date('d-m-Y');
        $data['status']=0;

        if ($request->image) {
            $photo=$request->image;
            $photoname=uniqid().'.'.$photo->getClientOriginalExtension();
            $photo->move('public/backend/files/ticket/',$photoname); //without image intervention
            //Image::make($photo)->resize(600,350)->seve('public/backend/files/ticket/'.$photoname);//without intervantion
            $data['image']='public/backend/files/ticket/'.$photoname;
        }
        DB::table('order_tickets')->insert($data);
        $notification=array('message' => 'Ticket Added successfully!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //__ShowTicket__
    public function ShowTicket($id)
    {
        $ticket=DB::table('order_tickets')->where('id',$id)->first();
        return view('user.view_ticket',compact('ticket'));
    }
    //__ReplyTicket
    public function ReplyTicket(Request $request)
    {
        $data=array();
        $data['user_id']=Auth::id();
        $data['message']=$request->message;
        $data['ticket_id']=$request->ticket_id;
        $data['date']=date('d-m-Y');
        if ($request->image) {
            $photo=$request->image;
            $photoname=uniqid().'.'.$photo->getClientOriginalExtension();
            $photo->move('public/backend/files/ticket/',$photoname); 
            $data['image']='public/backend/files/ticket/'.$photoname;
        }
        DB::table('order_replies')->insert($data);
        $notification=array('message' => 'Replied done!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
}
