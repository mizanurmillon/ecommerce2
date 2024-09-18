<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class ReviewController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    //product review store-------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'review' => 'required',
            'rating' => 'required',
        ]);

        $check=DB::table('reviews')->where('user_id',Auth::id())->where('product_id',$request->product_id)->first();
        if ($check) {
           $notification=array('message' => 'Already you have a review with this product !','alert-type' => 'error'); 
            return redirect()->back()->with($notification); 
        }

        $data=array();
        $data['user_id']=Auth::id();
        $data['product_id']=$request->product_id;
        $data['review']=$request->review;
        $data['rating']=$request->rating;
        $data['review_date']=date('d-m-Y');
        $data['review_month']=date('F');
        $data['review_year']=date('Y');
        DB::table('reviews')->insert($data);
        $notification=array('message' => 'Thank for your reviews !','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //Write Review website page
    public function WriteReview()
    {
       return view('user.write_review');
    }
    //Website Review store-----
    public function WebReviewStore(Request $request)
    {
        $check=DB::table('wbreviews')->where('user_id',Auth::id())->first();
        if ($check) {
            $notification=array('message' => 'Review Allready exist!','alert-type' => 'error'); 
            return redirect()->back()->with($notification); 
        }
        $data=array();
        $data['user_id']=Auth::id();
        $data['name']=$request->name;
        $data['review']=$request->review;
        $data['rating']=$request->rating;
        $data['date']=date('d , F Y');
        $data['status']=0;
        
        DB::table('wbreviews')->insert($data);
        $notification=array('message' => 'Thank for your reviews !','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    
}
