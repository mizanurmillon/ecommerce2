<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;

class WarehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //warehouse index----------
    public function index(Request $request)
    {
        if ($request->ajax()) {
           $data=DB::table('warehouses')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action',function($row){
                        $actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#EditModal"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="'.route('warehouse.delete',[$row->id]).'" id="delete" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>';
                        return $actionbtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.category.warehouse.index');
    }
    //warehouse index
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_name' => 'required|unique:warehouses',
        ]);
        $data=array();
        $data['warehouse_name']=$request->warehouse_name;
        $data['warehouse_address']=$request->warehouse_address;
        $data['phone']=$request->phone;
        DB::table('warehouses')->insert($data);
        $notification = array('message' => 'warehouse Added successfully!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
    //warehouse delete---------
    public function Delete($id)
    {
        DB::table('warehouses')->where('id',$id)->delete();
         $notification = array('message' => 'warehouse Deleted!', 'alert-type' => 'warning');
        return redirect()->back()->with($notification);
    }
    //warehouse edit-----------
    public function Edit($id)
    {
        $data=DB::table('warehouses')->where('id',$id)->first();
        return view('admin.category.warehouse.edit',compact('data'));
    }
    //update warehouse-------------
    public function update(Request $request)
    {
        $data=array();
        $data['warehouse_name']=$request->warehouse_name;
        $data['warehouse_address']=$request->warehouse_address;
        $data['phone']=$request->phone;
        DB::table('warehouses')->where('id',$request->id)->update($data);
        $notification = array('message' => 'warehouse updated!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
