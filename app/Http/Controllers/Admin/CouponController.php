<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //warehouse index----------
    public function index(Request $request)
    {
        if ($request->ajax()) {
           $data=DB::table('coupons')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action',function($row){
                        $actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#EditModal"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="'.route('coupon.delete',[$row->id]).'" id="delete_coupon" data-id="'.$row->id.'" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>';
                        return $actionbtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.offer.coupon.index');
    }
    //coupon store--------
    public function store(Request $request)
    {
        $data=array(
            'coupon_code' =>$request->coupon_code,
            'type'=>$request->type,
            'coupon_amount'=>$request->coupon_amount,
            'valid_date'=>$request->valid_date,
            'status'=>$request->status, 
        );
        DB::table('coupons')->insert($data);
        return response()->json('Coupon Added successfully!');
    }
    //Edit Coupon-----
    public function Edit($id)
    {
        $data=DB::table('coupons')->where('id',$id)->first();
        return view('admin.offer.coupon.edit',compact('data'));
    }
    //coupon Update----------
    public function update(Request $request)
    {
        $data=array(
            'coupon_code' =>$request->coupon_code,
            'type'=>$request->type,
            'coupon_amount'=>$request->coupon_amount,
            'valid_date'=>$request->valid_date,
            'status'=>$request->status, 
        );
        DB::table('coupons')->where('id',$request->id)->update($data);
        return response()->json('Coupon Updated!');
    }
    //delete coupon---------
    public function Delete($id)
    {
        DB::table('coupons')->where('id',$id)->delete();
        return response()->json('Coupon Deleted!');
    }
}
