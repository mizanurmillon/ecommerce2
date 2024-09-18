<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use DataTables;

class ChildcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //childcategory index------
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data=DB::table('childcategories')->leftJoin('categories','childcategories.category_id','categories.id')->leftJoin('subcategories','childcategories.subcategory_id','subcategories.id')->select('categories.category_name','subcategories.subcategory_name','childcategories.*')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action',function($row){
                        $actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#EditModal"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="'.route('childcategory.delete',[$row->id]).'" id="delete" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>';
                        return $actionbtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $category=DB::table('categories')->get();
        return view('admin.category.childcategory.index',compact('category'));
    }
    //childcategory store----------
    public function store(Request $request)
    {
        $cat=DB::table('subcategories')->where('id',$request->subcategory_id)->first();
        $data=array();
        $data['category_id']=$cat->category_id;
        $data['subcategory_id']=$request->subcategory_id;
        $data['childcategory_name']=$request->childcategory_name;
        $data['childcategory_slug']=Str::slug($request->childcategory_name,'-');
        DB::table('childcategories')->insert($data);
        $notification=array('message' => 'Child-category Added successfully!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //childcategory delete--------------
    public function Delete($id)
    {
        DB::table('childcategories')->where('id',$id)->delete();
        $notification=array('message' => 'Child-category Deleted!','alert-type' => 'warning'); 
        return redirect()->back()->with($notification);
    }
    //Edit childcategory-------------
    public function Edit($id)
    {
        $category=DB::table('categories')->get();
        $data=DB::table('childcategories')->where('id',$id)->first();
        return view('admin.category.childcategory.edit',compact('category','data'));
    }
    //Update childcategory------------
    public function update(Request $request)
    {
        $cat=DB::table('subcategories')->where('id',$request->subcategory_id)->first();
        $data=array();
        $data['category_id']=$cat->category_id;
        $data['subcategory_id']=$request->subcategory_id;
        $data['childcategory_name']=$request->childcategory_name;
        $data['childcategory_slug']=Str::slug($request->childcategory_name,'-');
        DB::table('childcategories')->where('id',$request->id)->update($data);
        $notification=array('message' => 'Child-category Updated!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
}
