<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Subcategory index----
    public function index()
    {
        $subcategory=DB::table('subcategories')->leftJoin('categories','subcategories.category_id','categories.id')->select('categories.category_name','subcategories.*')->get();
        $category=DB::table('categories')->get();
        return view('admin.category.subcategory.index',compact('subcategory','category'));
    }
    //Subcategory store--------
    public function store(Request $request)
    {
        $data=array();
        $data['category_id']=$request->category_id;
        $data['subcategory_name']=$request->subcategory_name;
        $data['subcategory_slug']=Str::slug($request->subcategory_name,'-');
        DB::table('subcategories')->insert($data);
        $notification = array('message' => 'Subcategory Added successfully!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
    //Subcategory Delete--------
    public function Delete($id)
    {
        DB::table('subcategories')->where('id',$id)->delete();
        $notification = array('message' => 'Subcategory Deleted!', 'alert-type' => 'warning');
        return redirect()->back()->with($notification);
    }
    //Subcategory Edit--------
    public function Edit($id)
    {
        $subcategory=DB::table('subcategories')->where('id',$id)->first();
        $category=DB::table('categories')->get();
        return view('admin.category.subcategory.edit',compact('subcategory','category'));
    }
    //Subcategory Update-------------
    public function update(Request $request)
    {
        $data=array();
        $data['category_id']=$request->category_id;
        $data['subcategory_name']=$request->subcategory_name;
        $data['subcategory_slug']=Str::slug($request->subcategory_name,'-');
        DB::table('subcategories')->where('id',$request->id)->update($data);
        $notification = array('message' => 'Subcategory Updated!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
