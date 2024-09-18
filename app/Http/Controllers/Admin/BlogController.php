<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    //__blog category page 
    public function Category()
    {
        $category=DB::table('blog_category')->get();
        return view('admin.blog.category',compact('category'));
    }
    //Blog store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|max:55',
        ]);
        $data=array();
        $data['category_name']=$request->category_name;
        $data['category_slug']=Str::slug($request->category_name,'-');
        DB::table('blog_category')->insert($data);
        $notification=array('message' => 'Blog category Added successfully!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //__blog Delete
    public function Delete($id)
    {
        $data=DB::table('blog_category')->where('id',$id)->delete();
        $notification=array('message' => 'Blog category Deleted!','alert-type' => 'warning'); 
        return redirect()->back()->with($notification);
    }
    //__blog Edit
    public function Edit($id)
    {
        $data=DB::table('blog_category')->where('id',$id)->first();
        return view('admin.blog.category_edit',compact('data'));
    }
    //__blog Update
    public function Update(Request $request)
    {
        $data=array();
        $data['category_name']=$request->category_name;
        $data['category_slug']=Str::slug($request->category_name,'-');
        DB::table('blog_category')->where('id',$request->id)->update($data);
        $notification=array('message' => 'Blog category Updated!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
}
