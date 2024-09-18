<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;

class PickupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //pickup point index---------
    public function index(Request $request)
    {
        if ($request->ajax()) {
           $data=DB::table('pickup_point')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action',function($row){
                        $actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#EditModal"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="'.route('pickuppoint.delete',[$row->id]).'" id="delete_pickup" data-id="'.$row->id.'" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>';
                        return $actionbtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.pickup_point.index');
    }
    //pickup Point store---------
    public function store(Request $request)
    {
        $data=array(
            'pickup_point_name' =>$request->pickup_point_name, 
            'pickup_point_address' =>$request->pickup_point_address, 
            'pickup_point_phone' =>$request->pickup_point_phone, 
            'pickup_point_phone_two' =>$request->pickup_point_phone_two, 
        );
        DB::table('pickup_point')->insert($data);
        return response()->json('pickuppoint inserted!');
    }
    //delete Pickup point----------
    public function Delete($id)
    {
        DB::table('pickup_point')->where('id',$id)->delete();
        return response()->json('pickuppoint deleted');
    }
    //pickup point Edit--------
    public function Edit($id)
    {
        $data=DB::table('pickup_point')->where('id',$id)->first();
        return view('admin.pickup_point.edit',compact('data'));
    }
    //pickup point Update----------
    public function update(Request $request)
    {
        $data=array(
            'pickup_point_name' =>$request->pickup_point_name, 
            'pickup_point_address' =>$request->pickup_point_address, 
            'pickup_point_phone' =>$request->pickup_point_phone, 
            'pickup_point_phone_two' =>$request->pickup_point_phone_two, 
        );
        DB::table('pickup_point')->where('id',$request->id)->update($data);
        return response()->json('pickuppoint Updated!');
    }
}
