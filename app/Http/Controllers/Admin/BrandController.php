<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use DataTables;
use Image;
use Files;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //brand index-------------
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data=DB::table('brands')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('front_page',function($row){
                    if ($row->front_page==1) {
                        return '<span class="badge badge-success">home page</span>';
                    }
                })
                ->addColumn('action',function($row){
                    $actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#EditModal"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="'.route('brand.delete',[$row->id]).'" id="delete" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>';
                    return $actionbtn;
                })
                ->rawColumns(['action','front_page'])
                ->make(true);
        }
        return view('admin.category.brand.index');
    }
    //brand store----------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|max:55',
        ]);
        $data=array();
        $slug=Str::slug($request->brand_name,'-');
        $data['brand_name']=$request->brand_name;
        $data['brand_slug']=Str::slug($request->brand_name,'-');
        $data['front_page']=$request->front_page;
        // working with image
        $photo=$request->brand_logo;
        $photoname=$slug.'.'.$photo->getClientOriginalExtension();
        $photo->move('public/backend/files/brand/',$photoname); //without image intervention

        //Image::make($photo)->resize(240,120)->seve('public/backend/files/brand/'.$photoname);//without intervantion

        $data['brand_logo']='public/backend/files/brand/'.$photoname;
        DB::table('brands')->insert($data);
        $notification=array('message' => 'Brand Added successfully!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //brand delete------------
    public function Delete($id)
    {
        $data=DB::table('brands')->where('id',$id)->first();
        $image=$data->brand_logo;
        $dlt=unlink($image);
        $delete=DB::table('brands')->where('id',$id)->delete();
        $notification=array('message' => 'Brand Deleted!','alert-type' => 'warning'); 
        return redirect()->back()->with($notification);
    }
    //brand Edit------------
    public function Edit($id)
    {
        $data=DB::table('brands')->where('id',$id)->first();
        return view('admin.category.brand.edit',compact('data'));
    }
    //brand Update-------
    public function update(Request $request)
    {
        $slug=Str::slug($request->brand_name,'-');
        $data=array();
        $data['brand_name']=$request->brand_name;
        $data['brand_slug']=Str::slug($request->brand_name,'-');
         $data['front_page']=$request->front_page;
        $image=$request->brand_logo;
        if ($image) {
            $image_name=Str::random(40);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $slug.'.'.$ext;
            $upload_path = 'public/backend/files/brand/';
            $image_url = $upload_path.$image_full_name;
            $success = $image->move($upload_path,$image_full_name);
            if ($success) {
                $data['brand_logo']=$image_url;
                $brand=DB::table('brands')
                            ->where('id',$request->id)
                            ->first();
                $image_path=$brand->brand_logo;
                $dlt=unlink($image_path);
                $update=DB::table('brands')->where('id',$request->id)->update($data);
                if ($update) {
                    $notification=array(
                    'message' => 'Brand Update!',
                    'alert-type' => 'success' 
                    ); 
                    return redirect()->back()->with($notification);
                }else{
                    $notification=array(
                    'message' => 'Error',
                    'alert-type' => 'error' 
                    ); 
                return redirect()->back()->with($notification);
                } 
            }
        }else{
            $oldlogo=$request->old_logo;
            if ($oldlogo) {
               $data['brand_logo']=$oldlogo;
               $brand=DB::table('brands')->where('id',$request->id)->update($data);
               if ($brand) {
                    $notification=array(
                    'message' => 'Brand Update !',
                    'alert-type' => 'success' 
                    ); 
                    return redirect()->back()->with($notification);
                }else{
                    $notification=array(
                    'message' => 'Error',
                    'alert-type' => 'error' 
                    ); 
                return redirect()->back()->with($notification);
                } 
            }
        }
    }
}
