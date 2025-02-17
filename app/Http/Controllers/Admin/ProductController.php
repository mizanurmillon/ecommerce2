<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use DataTables;
use Image;
use Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Warehouse;
use File;


class ProductController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    //Product index-----------
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $imgurl='public/backend/files/product';
            $product="";
            $query=DB::table('products')->leftJoin('categories','products.category_id','categories.id')
                ->leftJoin('subcategories','products.subcategory_id','subcategories.id')
                ->leftJoin('brands','products.brand_id','brands.id');
            if ($request->category_id) {
                $query->where('products.category_id',$request->category_id);
            }
            if ($request->brand_id) {
                $query->where('products.brand_id',$request->brand_id);
            }
            if ($request->warehouse_id) {
                $query->where('products.warehouse_id',$request->warehouse_id);
            }
            if ($request->status==1) {
                $query->where('products.status',1);
            }
            
            $product=$query->select('products.*','categories.category_name','subcategories.subcategory_name','brands.brand_name')->get();

            return DataTables::of($product)
                ->addIndexColumn()
                ->editColumn('thumbnail',function($row) use ($imgurl){
                    return '<img src="'.$imgurl.'/'.$row->thumbnail.'" height="30" width="30">';
                })
                // ->editColumn('category_name',function($row){
                //     return $row->category->category_name;
                // })
                // ->editColumn('subcategory_name',function($row){
                //     return $row->subcategory->subcategory_name;
                // })
                // ->editColumn('brand_name',function($row){
                //     return $row->brand->brand_name;
                // })
                ->editColumn('featured',function($row){
                    if ($row->featured==1) {
                        return '<a href="#" data-id="'.$row->id.'" class="deactive_featured"><i class="fa-solid fa-thumbs-down text-danger"></i> <span class="badge badge-success">active</span></a>';
                    }else{
                        return '<a href="#" data-id="'.$row->id.'" class="active_featured"><i class="fa-solid fa-thumbs-up text-success"></i> <span class="badge badge-danger">deactive</span></a>';
                    }
                })
                ->editColumn('today_deal',function($row){
                    if ($row->today_deal==1) {
                        return '<a href="#" data-id="'.$row->id.'" class="deactive_deal"><i class="fa-solid fa-thumbs-down text-danger"></i> <span class="badge badge-success">active</span></a>';
                    }else{
                        return '<a href="#" data-id="'.$row->id.'" class="active_deal" ><i class="fa-solid fa-thumbs-up text-success"></i> <span class="badge badge-danger">deactive</span></a>';
                    }
                })
                ->editColumn('status',function($row){
                    if ($row->status==1) {
                        return '<a href="#" data-id="'.$row->id.'" class="deactive_status"><i class="fa-solid fa-thumbs-down text-danger"></i> <span class="badge badge-success">active</span></a>';
                    }else{
                        return '<a href="#" data-id="'.$row->id.'" class="active_status"><i class="fa-solid fa-thumbs-up text-success"></i> <span class="badge badge-danger">deactive</span></a>';
                    }
                })
                ->addColumn('action',function($row){
                    $actionbtn='
                    <a href="#" class="btn btn-success btn-sm"><i class="fa-solid fa-eye"></i></a>
                    <a href="'.route('product.edit',[$row->id]).'" class="btn btn-info btn-sm edit"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="'.route('product.delete',[$row->id]).'" id="delete_product" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>';
                    return $actionbtn;
                })
                ->rawColumns(['action','category_name','subcategory_name','brand_name','thumbnail','featured','today_deal','status'])
                ->make(true);
        }
        $category=DB::table('categories')->get();
        $brand=DB::table('brands')->get();
        $warehouse=DB::table('warehouses')->get();
        return view('admin.product.index',compact('category','brand','warehouse'));
    }
    //Product create--------
    public function create()
    {
        $category=DB::table('categories')->get();
        $childcategory=DB::table('childcategories')->get();
        $brand=DB::table('brands')->get();
        $warehouse=DB::table('warehouses')->get();
        $pickup_point=DB::table('pickup_point')->get();
        return view('admin.product.create',compact('category','childcategory','brand','warehouse','pickup_point'));
    }
    //Product store--------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:products|max:55',
            'subcategory_id' => 'required',
            'childcategory_id' => 'required',
            'brand_id' => 'required',
            'unit' => 'required',
            'selling_price' => 'required',
            'stock_quantity' => 'required',
            'color' => 'required',
            'thumbnail' => 'required',
            'description' => 'required',
        ]);
       $subcategory=DB::table('subcategories')->where('id',$request->subcategory_id)->first();

       $slug=Str::slug($request->name,'-');
       $data=array();
       $data['name']=$request->name;
       $data['slug']=Str::slug($request->name,'-');
       $data['code']=$request->code;
       $data['category_id']=$subcategory->category_id;
       $data['subcategory_id']=$request->subcategory_id;
       $data['childcategory_id']=$request->childcategory_id;
       $data['brand_id']=$request->brand_id;
       $data['pickup_point_id']=$request->pickup_point_id;
       $data['color']=$request->color;
       $data['size']=$request->size;
       $data['unit']=$request->unit;
       $data['tags']=$request->tags;
       $data['video']=$request->video;
       $data['purchase_price']=$request->purchase_price;
       $data['selling_price']=$request->selling_price;
       $data['discount_price']=$request->discount_price;
       $data['stock_quantity']=$request->stock_quantity;
       $data['warehouse_id']=$request->warehouse_id;
       $data['description']=$request->description;
       $data['featured']=$request->featured;
       $data['today_deal']=$request->today_deal;
       $data['trendy']=$request->trendy;
       $data['product_slider']=$request->product_slider;
       $data['status']=$request->status;
       $data['admin_id']=Auth::id();
       $data['month']=date('F');
       $data['date']=date('d-m-Y');
       //Single Image--------
       if($request->thumbnail){
            $thumbnail=$request->thumbnail;
            $photoname=$slug.'.'.$thumbnail->getClientOriginalExtension();
            $thumbnail->move('public/backend/files/product/',$photoname); //without image intervention
            // Image::make($thumbnail)->resize(600,600)->seve('public/backend/files/product/'.$photoname);
            $data['thumbnail']=$photoname;
       }
       //Multiple Image----
        $images = array();
        if($request->hasFile('images')){
            foreach ($request->file('images') as $key => $image) {
                $image_name = Str::random(40);
                $ext = strtolower($image->getClientOriginalExtension());
                $image_full_name = $image_name.'.'.$ext;
                $upload_path = 'public/backend/files/product/';
                $image_url = $image_full_name;
                $success = $image->move($upload_path ,$image_full_name); // Only Image Upload
                array_push($images, $image_url);
            }
            $data['images']  = json_encode($images);
        }
       DB::table('products')->insert($data);
       $notification=array('message' => 'product Added successfully!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //Edit Method-------------
    public function Edit($id)
    {
        $product=DB::table('products')->where('id',$id)->first();
        $category=Category::all();
        $subcategory=Subcategory::all();
        $brand=Brand::all();
        $warehouse=Warehouse::all();
        $pickup_point=DB::table('pickup_point')->get();
        $childcategory=DB::table('childcategories')->where('category_id',$product->category_id)->get();
        return view('admin.product.edit',compact('product','category','subcategory','brand','warehouse','pickup_point','childcategory'));

    }
    //___product update___//
    public function update(Request $request)
    {
       $validated = $request->validate([
            'name' => 'required',
            'code' => 'required|max:55',
            'subcategory_id' => 'required',
            'childcategory_id' => 'required',
            'brand_id' => 'required',
            'unit' => 'required',
            'selling_price' => 'required',
            'stock_quantity' => 'required',
            'color' => 'required',
            'description' => 'required',
        ]);
       $subcategory=DB::table('subcategories')->where('id',$request->subcategory_id)->first();

       $slug=Str::slug($request->name,'-');
       $data=array();
       $data['name']=$request->name;
       $data['slug']=Str::slug($request->name,'-');
       $data['code']=$request->code;
       $data['category_id']=$subcategory->category_id;
       $data['subcategory_id']=$request->subcategory_id;
       $data['childcategory_id']=$request->childcategory_id;
       $data['brand_id']=$request->brand_id;
       $data['pickup_point_id']=$request->pickup_point_id;
       $data['color']=$request->color;
       $data['size']=$request->size;
       $data['unit']=$request->unit;
       $data['tags']=$request->tags;
       $data['video']=$request->video;
       $data['purchase_price']=$request->purchase_price;
       $data['selling_price']=$request->selling_price;
       $data['discount_price']=$request->discount_price;
       $data['stock_quantity']=$request->stock_quantity;
       $data['warehouse_id']=$request->warehouse_id;
       $data['description']=$request->description;
       $data['featured']=$request->featured;
       $data['today_deal']=$request->today_deal;
       $data['trendy']=$request->trendy;
       $data['product_slider']=$request->product_slider;
       $data['status']=$request->status;

       $thumbnail=$request->file('thumbnail');
       if ($thumbnail) {
            $old_thumbnail='public/backend/files/product/'.$request->old_thumbnail;
            if (File::exists($old_thumbnail)) {
                File::delete($old_thumbnail);
            }
            $thumbnail=$request->thumbnail;
            $photoname=$slug.'.'.$thumbnail->getClientOriginalExtension();
            $thumbnail->move('public/backend/files/product/',$photoname); 
            $data['thumbnail']=$photoname;
       }

       //Multiple Image------
       $old_images=$request->has('old_image');
       if ($old_images) {
           $images=$request->old_images;
           $data['images']=json_encode($images);
       }else{
            $images=array();
            $data['images']=json_encode($images);
       }
       if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $upload_path = 'public/backend/files/product/'.$image_name;
                $success = $image->move('public/backend/files/product/',$image_name); // Only Image Upload
                array_push($images, $image_name);
            }
            $data['images']  = json_encode($images);
       }
       
       DB::table('products')->where('id',$request->id)->update($data);
       $notification=array('message' => 'Product Updated Successfully!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }

    //deactive Featured---------
    public function deactive($id)
    {
        DB::table('products')->where('id',$id)->update(['featured'=>0]);
        return response()->json('Featured Deactive');
    }
    //active Featured----------
    public function active($id)
    {
        DB::table('products')->where('id',$id)->update(['featured'=>1]);
        return response()->json('Featured active');
    }
     //deactive Today Deal---------
    public function deactivedeal($id)
    {
        DB::table('products')->where('id',$id)->update(['today_deal'=>0]);
        return response()->json('Today Deal Deactive');
    }
    //active Today Deal----------
    public function activedeal($id)
    {
        DB::table('products')->where('id',$id)->update(['today_deal'=>1]);
        return response()->json('Today Deal active');
    }
     //deactive Status ---------
    public function deactiveStatus($id)
    {
        DB::table('products')->where('id',$id)->update(['status'=>0]);
        return response()->json('Deactive Status');
    }
    //active Status----------
    public function activeStatus($id)
    {
        DB::table('products')->where('id',$id)->update(['status'=>1]);
        return response()->json('Active Status');
    }
    //product Delete------------
    public function Delete($id)
    {
        
        $product=DB::table('products')->where('id',$id)->first();
        
        if (File::exists('public/backend/files/product/'.$product->thumbnail)) {
            File::delete('public/backend/files/product/'.$product->thumbnail);
        }

        DB::table('products')->where('id',$id)->delete();

        return response()->json('successfully Deleted!');
    }
}
