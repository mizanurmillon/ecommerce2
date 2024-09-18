<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use App\Http\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Category index------
    public function index()
    {
        $category=DB::table('categories')->get();
        return view('admin.category.category.index',compact('category'));
    }
    // Category Store-------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:55',
            'icon' => 'required',
        ]);
        $data=array();
        $slug=Str::slug($request->category_name,'-');
        $data['category_name']=$request->category_name;
        $data['category_slug']=$slug;
        $data['home_page']=$request->home_page;
        $photo=$request->icon;
        $photoname=$slug.'.'.$photo->getClientOriginalExtension();
        $photo->move('public/backend/files/category/',$photoname); //without image intervention
        $data['icon']='public/backend/files/category/'.$photoname;
        DB::table('categories')->insert($data);
        $notification=array('message' => 'category Added successfully!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //Delete Category-----------
    public function Delete($id)
    {
        $data=DB::table('categories')->where('id',$id)->delete();
        $icon=$data->icon;
        $dlt=unlink($icon);
        $notification=array('message' => 'category Deleted!','alert-type' => 'warning'); 
        return redirect()->back()->with($notification);
    }
    // Edit category-------------
    public function Edit($id)
    {
        //qurey builder=========
        $data=DB::table('categories')->where('id',$id)->first();
        return view('admin.category.category.edit',compact('data'));
        //eloquent ORM=========
        //$data= Category::findorfail($id);
        // return response()->json($data);
    }
    //update Category------
    public function update(Request $request)
    {
        $slug=Str::slug($request->category_name,'-');
        $data['category_name']=$request->category_name;
        $data['category_slug']=$slug;
        $data['home_page']=$request->home_page;
        $photo=$request->icon;
        if ($photo) {
            $image_name=Str::random(40);
            $ext = strtolower($photo->getClientOriginalExtension());
            $image_full_name = $slug.'.'.$ext;
            $upload_path = 'public/backend/files/category/';
            $image_url = $upload_path.$image_full_name;
            $success = $photo->move($upload_path,$image_full_name);
            if ($success) {
                $data['icon']=$image_url;
                $categoey=DB::table('categories') ->where('id',$request->id)->first();
                $image_path=$categoey->icon;
                $dlt=unlink($image_path);
                $update=DB::table('categories')->where('id',$request->id)->update($data);
                if ($update) {
                    $notification=array('message' => 'category Update!','alert-type' => 'success'); 
                    return redirect()->back()->with($notification);
                }else{
                    $notification=array('message' => 'Error','alert-type' => 'error'); 
                return redirect()->back()->with($notification);
                } 
            }
        }else{
            $oldphoto=$request->old_icon;
            if ($oldphoto) {
               $data['icon']=$oldphoto;
               $categorycategoey=DB::table('categories')->where('id',$request->id)->update($data);
               if ($categorycategoey) {
                    $notification=array('message' => 'category Update !','alert-type' => 'success'); 
                    return redirect()->back()->with($notification);
                }else{
                    $notification=array('message' => 'Error','alert-type' => 'error'); 
                return redirect()->back()->with($notification);
                } 
            }
        }
    }
    public function getchildcategory($id)
    {
        $data=DB::table('childcategories')->where('subcategory_id',$id)->get();
        return response()->json($data);
    }
}
