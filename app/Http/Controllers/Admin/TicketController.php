<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Image;

class TicketController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            
            $ticket="";
            $query=DB::table('order_tickets')->leftJoin('users','order_tickets.user_id','users.id');
           
           
            if ($request->date) {
                $tickets_date=date('d-m-Y',strtotime($request->date));
                $query->where('order_tickets.date',$tickets_date);
            }
            if ($request->type=='Technicel') {
                $query->where('order_tickets.service',$request->type);
            }
            if ($request->type=='Payment') {
                $query->where('order_tickets.service',$request->type);
            }
            if ($request->type=='Affiliate') {
                $query->where('order_tickets.service',$request->type);
            }
            if ($request->type=='Return') {
                $query->where('order_tickets.service',$request->type);
            }
            if ($request->type=='Refund') {
                $query->where('order_tickets.service',$request->type);
            }
            if ($request->status==1) {
                $query->where('order_tickets.status',1);
            }
            if ($request->status==0) {
                $query->where('order_tickets.status',0);
            }
            if ($request->status==2) {
                $query->where('order_tickets.status',2);
            }
            
            $ticket=$query->select('order_tickets.*','users.name')->get();

            return DataTables::of($ticket)
                ->addIndexColumn()
                ->editColumn('status',function($row){
                    if ($row->status==1) {
                        return '<span class="badge badge-warning">Running</span>';
                    }elseif($row->status==2){
                        return '<span class="badge badge-danger">Close</span>';
                    }else{
                        return '<span class="badge badge-success">Pending</span>';
                    }
                })
                ->editColumn('date',function($row){
                    return (date('d F Y',strtotime($row->date)));
                })
                ->addColumn('action',function($row){
                    $actionbtn='
                    <a href="'.route('ticket.view',[$row->id]).'" class="btn btn-success btn-sm"><i class="fa-solid fa-eye"></i></a>
                    <a href="'.route('admin.ticket.delete',[$row->id]).'" id="delete_ticket" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>';
                    return $actionbtn;
                })
                ->rawColumns(['action','status','date'])
                ->make(true);
        }
        return view('admin.ticket.index');
    }
    //__ticket view__
    public function TicketView($id)
    {
        $ticket=DB::table('order_tickets')->where('order_tickets.id',$id)->leftJoin('users','order_tickets.user_id','users.id')->select('order_tickets.*','users.name')->first();
        return view('admin.ticket.view_ticket',compact('ticket'));
    }
    //__storeReply__
    public function storeReply(Request $request)
    {
        $data=array();
        $data['user_id']=0;
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
        DB::table('order_tickets')->where('id',$request->id)->update(['status'=>1]);
        $notification=array('message' => 'Replied done!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //__CloseTicket
    public function CloseTicket($id)
    {
        DB::table('order_tickets')->where('id',$id)->update(['status'=>2]);
        $notification=array('message' => 'Ticket Closed!','alert-type' => 'success'); 
        return redirect()->route('ticket.index')->with($notification);
    }
    //__DeleteTicket
    public function DeleteTicket($id)
    {
        DB::table('order_tickets')->where('id',$id)->delete();
        return response()->json('ticket delete successfully');
    }
}
