<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;

class IndexController extends Controller
{
    //index page----
    public function index()
    {
        $category=DB::table('categories')->orderBy('category_name','ASC')->get();
        $brand=DB::table('brands')->where('front_page',1)->limit(24)->get();
        $bannerproduct=Product::where('status',1)->where('product_slider',1)->latest()->first();
        $featured=Product::where('status',1)->where('featured',1)->orderBy('id','DESC')->limit(16)->get();
        $populer_product=Product::where('status',1)->orderBy('product_views','DESC')->limit(16)->get();
        $trendy_product=Product::where('status',1)->where('trendy',1)->orderBy('id','DESC')->limit(8)->get();
        $today_product=Product::where('status',1)->where('today_deal',1)->orderBy('id','DESC')->limit(6)->get();
        $random_product=Product::where('status',1)->inRandomOrder()->limit(8)->get();
        $review=DB::table('wbreviews')->where('status',1)->orderBy('id','DESC')->limit(12)->get();
        //Home page Category
        $home_category=DB::table('categories')->where('home_page',1)->orderBy('category_name','ASC')->get();
        //campaing 
        $campaing=DB::table('campaings')->where('status',1)->orderBy('id','DESC')->first();

        return view('frontend.index',compact('category','bannerproduct','featured','populer_product','trendy_product','home_category','brand','random_product','today_product','review','campaing'));
    }
    //product details page
    public function ProductDetails($slug)
    {
       $product=Product::where('slug',$slug)->first();
                Product::where('slug',$slug)->increment('product_views');
       $related_product=DB::table('products')->where('subcategory_id',$product->subcategory_id)->orderBy('id','DESC')->take(10)->get();
       $review=Review::where('product_id',$product->id)->orderBy('id','DESC')->take(6)->get();
       return view('frontend.product.product_details',compact('product','related_product','review'));
    }
    //Product Quick view page-----
    public function ProductQuickView($id)
    {
        $product=Product::where('id',$id)->first();
        return view('frontend.product.quick_view',compact('product'));
    }
    //Categorywise Product page--
    public function CategorywiseProduct($id)
    {
        $category=DB::table('categories')->where('id',$id)->first();
        $subcategory=DB::table('subcategories')->where('category_id',$id)->get();
        $brand=DB::table('brands')->get();
        $product=DB::table('products')->where('category_id',$id)->paginate(60);
        $random_product=Product::where('status',1)->inRandomOrder()->limit(8)->get();
        return view('frontend.product.categorywise_product',compact('subcategory','brand','product','random_product','category'));
    }
    //Subcategorywise Product page
    public function SubcategorywiseProduct($id)
    {
        $subcategory=DB::table('subcategories')->where('id',$id)->first();
        $childcategory=DB::table('childcategories')->where('subcategory_id',$id)->get();
        $brand=DB::table('brands')->get();
        $product=DB::table('products')->where('subcategory_id',$id)->paginate(60);
        $random_product=Product::where('status',1)->inRandomOrder()->limit(8)->get();
        return view('frontend.product.subcategorywise_product',compact('childcategory','brand','product','random_product','subcategory'));
    }
    //Childcategorywise Product page
    public function ChildcategorywiseProduct($id)
    {
        $childcategory=DB::table('childcategories')->where('id',$id)->first();
        $category=DB::table('categories')->get();
        $brand=DB::table('brands')->get();
        $product=DB::table('products')->where('childcategory_id',$id)->paginate(60);
        $random_product=Product::where('status',1)->inRandomOrder()->limit(8)->get();
        return view('frontend.product.childcategorywise_product',compact('childcategory','brand','product','random_product','category'));
    }
    //Brand wise product
    public function BrandwiseProduct($id)
    {
        $brand=DB::table('brands')->where('id',$id)->first();
        $category=DB::table('categories')->get();
        $brands=DB::table('brands')->get();
        $product=DB::table('products')->where('brand_id',$id)->paginate(60);
        $random_product=Product::where('status',1)->inRandomOrder()->limit(8)->get();
        return view('frontend.product.brandwise_product',compact('brand','brands','product','random_product','category'));
    }
    //page view method-----
    public function PageView($page_slug)
    {
        $page=DB::table('pages')->where('page_slug',$page_slug)->first();
        return view('frontend.product.page_view',compact('page'));
    }
    //Newsletter Store store method
    public function NewsletterStore(Request $request)
    {
        $email=$request->email;
        $check=DB::table('newsletters')->where('email',$email)->first();
        if ($check) {
           return response()->json('Email Allready Exist!');
        }else{
            $data=array();
            $data['email']=$request->email;
            DB::table('newsletters')->insert($data);
            return response()->json('Thanks For Subscribe us!');
        }
    }
    //__OrderTracking
    public function OrderTracking()
    {
        return view('frontend.order_tracking');
    }
    //__CheckTrack
    public function CheckOrder(Request $request)
    {
        $check=DB::table('orders')->where('order_id',$request->order_id)->first();
        if ($check) {
            $order=DB::table('orders')->where('order_id',$request->order_id)->first();

            $order_details=DB::table('order_details')->where('order_id',$order->id)->get();
            
            return view('frontend.order_details',compact('order','order_details'));
        }else{
            $notification=array('message' => 'Invalid order id! try again','alert-type' => 'error'); 
            return redirect()->back()->with($notification);
        }
    }
    //__contact Store
    public function Store(Request $request)
    {
        $data=array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['phone']=$request->phone;
        $data['message']=$request->message;
        $data['status']=0;
        DB::table('contacts')->insert($data);
        $notification=array('message' => 'Message send','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //__contact page
    public function Contact()
    {
        return view('frontend.contact.contact');
    }
    //__blog page
    public function Blog()
    {
        return view('frontend.contact.blog');
    }

    //___CampaingProduct____
    public function CampaingProduct($id)
    {
        $product=DB::table('campaing_product')->leftJoin('products','campaing_product.product_id','products.id')
                ->select('campaing_product.*','products.name','products.code','products.thumbnail','products.slug')
                ->where('campaing_product.campaing_id',$id)
                ->paginate(32);
        return view('frontend.campaing.campaing_product_list',compact('product'));
    }
    //__campaing product details___
    public function CampaingProductDetails($slug)
    {
        $product=Product::where('slug',$slug)->first();
                Product::where('slug',$slug)->increment('product_views');
        $product_price=DB::table('campaing_product')->where('product_id',$product->id)->first();
        $random_product=DB::table('campaing_product')->leftJoin('products','campaing_product.product_id','products.id')
            ->select('campaing_product.*','products.name','products.code','products.thumbnail','products.slug')
            ->inRandomOrder(12)->get();

       $review=Review::where('product_id',$product->id)->orderBy('id','DESC')->take(6)->get();
       return view('frontend.campaing.product_details',compact('product','random_product','review','product_price'));
    }
}
