<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Mail;
use App\Mail\RecievedMail;

class OrderController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }
    //__order list
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $order="";
            $query=DB::table('orders')->orderBy('id','DESC');
           
            if ($request->payment_type) {
                $query->where('payment_type',$request->payment_type);
            }
            if ($request->date) {
                $order_date=date('d-m-Y',strtotime($request->date));
                $query->where('date',$order_date);
            }
            if ($request->status==0) {
                $query->where('status',0);
            }
            if ($request->status==1) {
                $query->where('status',1);
            }
            if ($request->status==2) {
                $query->where('status',2);
            }
            if ($request->status==3) {
                $query->where('status',3);
            }
            if ($request->status==4) {
                $query->where('status',4);
            }
            if ($request->status==5) {
                $query->where('status',5);
            }
            $order=$query->get();
            return DataTables::of($order)
                ->addIndexColumn()
                ->editColumn('status',function($row){
                    if ($row->status==0) {
                        return '<span class="badge badge-danger">Pending</span>';
                    }elseif($row->status==1){
                        return '<span class="badge badge-primary">Recieved</span>';
                    }elseif($row->status==2){
                        return '<span class="badge badge-info">Shipped</span>';
                    }elseif($row->status==3){
                        return '<span class="badge badge-success">Completed</span>';
                    }elseif($row->status==4){
                        return '<span class="badge badge-warning">Return</span>';
                    }elseif($row->status==5){
                        return '<span class="badge badge-danger">Cancel</span>';
                    }
                })
                ->addColumn('action',function($row){
                    $actionbtn='
                    <a href="#" data-id="'.$row->id.'" class="btn btn-success btn-sm view" data-toggle="modal" data-target="#ViewModal"><i class="fa-solid fa-eye"></i></a>
                    <a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#EditModal"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="'.route('order.delete',[$row->id]).'" id="delete_order" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>';
                    return $actionbtn;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }
        
        return view('admin.order.index');
    }
    //__Edit Order
    public function Edit($id)
    {
        $data=DB::table('orders')->where('id',$id)->first();
        return view('admin.order.edit',compact('data'));
    }
    //__UpdateStatus
    public function UpdateStatus(Request $request)
    {
        $data=array();
        $data['c_name']=$request->c_name;
        $data['c_phone']=$request->c_phone;
        $data['c_email']=$request->c_email;
        $data['c_address']=$request->c_address;
        $data['status']=$request->status;
        //__Mail__
        if($request->status==1){
            Mail::to($request->c_email)->send(new RecievedMail($data));
        }

        DB::table('orders')->where('id',$request->id)->update($data);
        return response()->json('Successfully Change Status!');
    }
    //__View Order
    public function View($id)
    {
        $order=DB::table('orders')->where('id',$id)->first();
        $order_details=DB::table('order_details')->where('order_id',$id)->get();
        return view('admin.order.order_details',compact('order','order_details'));
    }
    //__Order Delete
    public function Delete($id)
    {
        $order=DB::table('orders')->where('id',$id)->delete();
        $order_details=DB::table('order_details')->where('order_id',$id)->delete();
        return response()->json('Order Deleted!');
    }

    //___order report__
    public function ReportIndex(Request $request)
    {
       if ($request->ajax()) {
            $order="";
            $query=DB::table('orders')->orderBy('id','DESC');
           
            if ($request->payment_type) {
                $query->where('payment_type',$request->payment_type);
            }
            if ($request->date) {
                $order_date=date('d-m-Y',strtotime($request->date));
                $query->where('date',$order_date);
            }
            if ($request->status==0) {
                $query->where('status',0);
            }
            if ($request->status==1) {
                $query->where('status',1);
            }
            if ($request->status==2) {
                $query->where('status',2);
            }
            if ($request->status==3) {
                $query->where('status',3);
            }
            if ($request->status==4) {
                $query->where('status',4);
            }
            if ($request->status==5) {
                $query->where('status',5);
            }
            $order=$query->get();
            return DataTables::of($order)
                ->addIndexColumn()
                ->editColumn('status',function($row){
                    if ($row->status==0) {
                        return '<span class="badge badge-danger">Pending</span>';
                    }elseif($row->status==1){
                        return '<span class="badge badge-primary">Recieved</span>';
                    }elseif($row->status==2){
                        return '<span class="badge badge-info">Shipped</span>';
                    }elseif($row->status==3){
                        return '<span class="badge badge-success">Completed</span>';
                    }elseif($row->status==4){
                        return '<span class="badge badge-warning">Return</span>';
                    }elseif($row->status==5){
                        return '<span class="badge badge-danger">Cancel</span>';
                    }
                })
                ->rawColumns(['status'])
                ->make(true);
        }
        return view('admin.report.order_report.index');
    }
    //___report Print
    public function ReportPrint(Request $request)
    {
        if ($request->ajax()) {
            $order="";
            $query=DB::table('orders')->orderBy('id','DESC');
           
            if ($request->payment_type) {
                $query->where('payment_type',$request->payment_type);
            }
            if ($request->date) {
                $order_date=date('d-m-Y',strtotime($request->date));
                $query->where('date',$order_date);
            }
            if ($request->status==0) {
                $query->where('status',0);
            }
            if ($request->status==1) {
                $query->where('status',1);
            }
            if ($request->status==2) {
                $query->where('status',2);
            }
            if ($request->status==3) {
                $query->where('status',3);
            }
            if ($request->status==4) {
                $query->where('status',4);
            }
            if ($request->status==5) {
                $query->where('status',5);
            }
            $order=$query->get();
        }
        return view('admin.report.order_report.print',compact('order'));
    }
    
}
