<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use DataTables;
use Image;
use Files;

class CampaingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    //Campaing Index------
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data=DB::table('campaings')->orderBy('id','DESC')->get();
            return DataTables::of($data)
                ->editColumn('status',function($row){
                    if ($row->status==1) {
                        return '<a href="#" ><span class="badge badge-success">Active</span></a>';
                    }else{
                        return '<a href="#" ><span class="badge badge-danger">Inactive</span></a>';
                    }
                })
                ->addColumn('action',function($row){
                    $actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#EditModal"><i class="fa-solid fa-pen-to-square"></i></a>

                    <a href="'.route('campaing.delete',[$row->id]).'" id="delete" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                     <a href="'.route('campaing.product',[$row->id]).'"class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i></a>
                    ';

                    return $actionbtn;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }
        return view('admin.offer.campaing.index');
    }
    // Campaing store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'campaing_title' => 'required|unique:campaings',
            'start_date' => 'required',
            'discount' => 'required',
            'image' => 'required',
        ]);
        $data=array();
        $data['campaing_title']=$request->campaing_title;
        $data['start_date']=$request->start_date;
        $data['end_date']=$request->end_date;
        $data['status']=$request->status;
        $data['discount']=$request->discount;
        $data['month']=date('F');
        $data['year']=date('Y');
        // working with image
        $photo=$request->image;
        $slug=Str::slug($request->campaing_title,'-');
        $photoname=$slug.'.'.$photo->getClientOriginalExtension();
        $photo->move('public/backend/files/campaing/',$photoname); //without image intervention
        //Image::make($photo)->resize(468,90)->seve('public/backend/files/campaing/'.$photoname);//without intervantion
        $data['image']='public/backend/files/campaing/'.$photoname;
        DB::table('campaings')->insert($data);
        $notification=array('message' => 'Campaing Added successfully!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //Campaing Delete
    public function Delete($id)
    {
        $data=DB::table('campaings')->where('id',$id)->first();
        $image=$data->image;
        $dlt=unlink($image);
        $delete=DB::table('campaings')->where('id',$id)->delete();
        $notification=array('message' => 'Campaing Deleted!','alert-type' => 'warning'); 
        return redirect()->back()->with($notification);
    }
    //Campaing Edit
    public function Edit($id)
    {
        $data=DB::table('campaings')->where('id',$id)->first();
        return view('admin.offer.campaing.edit',compact('data'));
    }
    //Campaing update---
    public function update(Request $request)
    {
        $data=array();
        $slug=Str::slug($request->campaing_title,'-');
        $data['campaing_title']=$request->campaing_title;
        $data['start_date']=$request->start_date;
        $data['end_date']=$request->end_date;
        $data['status']=$request->status;
        $data['discount']=$request->discount;
        $data['month']=date('F');
        $data['year']=date('Y');
        $image=$request->image;
        if ($image) {
            $image_name=Str::random(40);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $slug.'.'.$ext;
            $upload_path = 'public/backend/files/campaing/';
            $image_url = $upload_path.$image_full_name;
            $success = $image->move($upload_path,$image_full_name);
            if ($success) {
                $data['image']=$image_url;
                $campaing=DB::table('campaings') ->where('id',$request->id)->first();
                $image_path=$campaing->image;
                $dlt=unlink($image_path);
                $update=DB::table('campaings')->where('id',$request->id)->update($data);
                if ($update) {
                    $notification=array('message' => 'Campaing Update!','alert-type' => 'success'); 
                    return redirect()->back()->with($notification);
                }else{
                    $notification=array('message' => 'Error','alert-type' => 'error'); 
                return redirect()->back()->with($notification);
                } 
            }
        }else{
            $oldimage=$request->old_image;
            if ($oldimage) {
               $data['image']=$oldimage;
               $campaing=DB::table('campaings')->where('id',$request->id)->update($data);
               if ($campaing) {
                    $notification=array('message' => 'Campaing Update !','alert-type' => 'success'); 
                    return redirect()->back()->with($notification);
                }else{
                    $notification=array('message' => 'Error','alert-type' => 'error'); 
                return redirect()->back()->with($notification);
                } 
            }
        }
    }
    //___campaing Product all method__
    public function campaingProduct($campaing_id)
    {
        $product=DB::table('products')->leftJoin('categories','products.category_id','categories.id')
                ->leftJoin('subcategories','products.subcategory_id','subcategories.id')
                ->leftJoin('brands','products.brand_id','brands.id')
                ->select('products.*','categories.category_name','subcategories.subcategory_name','brands.brand_name')
                ->where('products.status','1')
                ->get();
        return view('admin.offer.campaing_product.index',compact('product','campaing_id'));
    }
    //___ProductAddToCampaing___//
    public function ProductAddToCampaing($id , $campaing_id)
    {
        $campaing=DB::table('campaings')->where('id',$campaing_id)->first();
        $product=DB::table('products')->where('id',$id)->first();
        $discount_amount=$product->selling_price/100*$campaing->discount;
        $discount_price=$product->selling_price-$discount_amount;
        $data=array();
        $data['campaing_id']=$campaing_id;
        $data['product_id']=$id;
        $data['price']=$discount_price;
        DB::table('campaing_product')->insert($data);
        $notification=array('message' => 'Product added to campaing successfully!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //__Campaing product list___
    public function ProductList($campaing_id)
    {
        $product=DB::table('campaing_product')->leftJoin('products','campaing_product.product_id','products.id')
                ->select('campaing_product.*','products.name','products.code','products.thumbnail')
                ->where('campaing_product.campaing_id',$campaing_id)
                ->get();
        $campaing=DB::table('campaings')->where('id',$campaing_id)->first();
        return view('admin.offer.campaing_product.campaing_product_list',compact('product','campaing'));
    }
    //__RemoveCampaing___
    public function RemoveCampaing($id)
    {
        DB::table('campaing_product')->where('id',$id)->delete();
        $notification=array('message' => 'Campaing product remove!','alert-type' => 'warning'); 
        return redirect()->back()->with($notification);
    }
}
