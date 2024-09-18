<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use App\Models\Product;
use DB;
use Auth;

class CartController extends Controller
{
    // Add to cart method-------
    public function AddToCartQV(Request $request)
    {
      // $product=DB::table('products')->where('id',$request->id)->first();
      // $product=Product::where('id',$request->id)->first();
      $product=Product::find($request->id);
      Cart::add([
        'id'=>$product->id,
        'name'=>$product->name,
        'qty'=>$request->qty,
        'price'=>$request->price,
        'weight'=>'1',
        'options'=>['size'=>$request->size, 'color'=>$request->color, 'thumbnail'=>$product->thumbnail]
      ]);
      return response()->json('product added on cart!');

    }
    //All Cart-------
    public function AllCart()
    {
        $data=array();
        $data['cart_qty']=Cart::count();
        $data['cart_total']=Cart::total();
        return response()->json($data);
    }
    //My Cart----------
    public function MyCart()
    {
       $content=Cart::content();
       return view('frontend.cart.cart',compact('content'));
    }

    //cart remove----
    public function Remove($rowId)
    {
        Cart::remove($rowId);
        return response()->json('Success');
    }
    //update Qty----
    public function updateQty($rowId,$qty)
    {
       Cart::update($rowId,['qty'=>$qty]);
       return response()->json('successfully updated !');
    }
    //update Color---------
    public function updateColor($rowId,$color)
    {
        $product=Cart::get($rowId);
        $thumbnail=$product->options->thumbnail;
        $size=$product->options->size;
        Cart::update($rowId,['options'=> ['color'=>$color,'size'=>$size,'thumbnail'=>$thumbnail]]);
        return response()->json('successfully updated color!');
    }
    //update Size---------
    public function updateSize($rowId,$size)
    {
        $product=Cart::get($rowId);
        $thumbnail=$product->options->thumbnail;
        $color=$product->options->color;
        Cart::update($rowId,['options'=> ['size'=>$size, 'color'=>$color, 'thumbnail'=>$thumbnail]]);
        return response()->json('successfully updated Size!');
    }
    //Cart destroy-------
    public function CartEmpty()
    {
        Cart::destroy();
        $notification=array('message' => 'Cart itmes clear!','alert-type' => 'success'); 
        return redirect()->to('/')->with($notification);
    }

     //AddWishlist
    public function AddWishlist($id)
    {
        if (Auth::check()) {
           $check=DB::table('wishlists')->where('product_id',$id)->where('user_id',Auth::id())->first();
            if ($check) {
               $notification=array('message' => 'Already have it on is Your Wishlist !','alert-type' => 'error'); 
                return redirect()->back()->with($notification); 
            }else{
                $data=array();
                $data['user_id']=Auth::id();
                $data['product_id']=$id;
                $data['date']=date('d , F Y');
                DB::table('wishlists')->insert($data);
                $notification=array('message' => 'Product Added on Wishlist !','alert-type' => 'success'); 
                return redirect()->back()->with($notification);
            } 
        }

        $notification=array('message' => 'Login Your Account !','alert-type' => 'error'); 
        return redirect()->back()->with($notification);
    }
    //Wishlist Showing Page-----------
    public function Wishlist()
    {
        if (Auth::check()) {
            $wishlist=DB::table('wishlists')->leftJoin('products','wishlists.product_id','products.id')->select('products.name','products.thumbnail','products.slug','wishlists.*')->where('wishlists.user_id',Auth::id())->get();
            return view('frontend.cart.wishlist',compact('wishlist'));
        }
        $notification=array('message' => 'Login Your Account !','alert-type' => 'error'); 
        return redirect()->back()->with($notification);
    } 
    //ClearWishlist-----
    public function ClearWishlist()
    {
        DB::table('wishlists')->where('user_id',Auth::id())->delete();
        $notification=array('message' => 'Clear Wishlist!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //Single wishlist Delete------
    public function Delete($id)
    {
        DB::table('wishlists')->where('id',$id)->delete();
        $notification=array('message' => 'Single Wishlist Deleted!','alert-type' => 'success'); 
        return redirect()->back()->with($notification); 
    }
}
