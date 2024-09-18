<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use Auth;
use DB;
use Session;
use Mail;
use App\Mail\InvoiceMail;

class CheckoutController extends Controller
{
    //__chack out cart method
   public function CheckoutCart()
   {
       if (!Auth::check()) {
          $notification=array('message' => 'Login Your Account!','alert-type' => 'error'); 
            return redirect()->back()->with($notification);
       }
        $content=Cart::content();
       return view('frontend.cart.checkout',compact('content'));
   }
   //__Apply Coupon
   public function Applycoupon(Request $request)
   {
       $chack=DB::table('coupons')->where('coupon_code',$request->coupon)->first();
       if ($chack) {
          if (date('Y-m-d' , strtotime(date('d-m-Y'))) <= date('Y-m-d' , strtotime($chack->valid_date))) {
            session::put('coupon', [
                'name'=>$chack->coupon_code,
                'discount'=>$chack->coupon_amount,
                'after_discount'=>Cart::subtotal()-$chack->coupon_amount
            ]);
            $notification=array('message' => 'Coupon Applied!','alert-type' => 'success'); 
            return redirect()->back()->with($notification);
          }else{
            $notification=array('message' => 'Expire coupon code!','alert-type' => 'error'); 
            return redirect()->back()->with($notification);
          }
       }else{
            $notification=array('message' => 'Invalid coupon code! try again','alert-type' => 'error'); 
            return redirect()->back()->with($notification);
       }
   }
   //___Coupon Remove__
   public function RemoveCoupon()
   {
      Session::forget('coupon');
      $notification=array('message' => 'Coupon Removed!','alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //__OrderPlace___
    public function OrderPlace(Request $request)
    {

        if ($request->payment_type=="Hand Cash") {
            $order=array();
            $order['user_id']=Auth::id();
            $order['c_name']=$request->c_name;
            $order['c_phone']=$request->c_phone;
            $order['c_email']=$request->c_email;
            $order['c_address']=$request->c_address;
            $order['c_country']=$request->c_country;
            $order['c_city']=$request->c_city;
            $order['c_zip_code']=$request->c_zip_code;
            $order['c_extra_phone']=$request->c_extra_phone;
            if (Session::has('coupon')) {
                $order['subtotal']=Cart::subtotal();
                $order['coupon_code']=Session::get('coupon')['name'];
                $order['coupon_discount']=Session::get('coupon')['discount'];
                $order['after_discount']=Session::get('coupon')['after_discount'];
            }else{
                $order['subtotal']=Cart::subtotal();
            }
            $order['total']=Cart::total();
            $order['payment_type']=$request->payment_type;
            $order['tex']=0;
            $order['shipping_chareg']=0;
            $order['order_id']=rand(10000,900000);
            $order['status']=0;
            $order['date']=date('d-m-Y');
            $order['month']=date('F');
            $order['year']=date('Y');

            $orderId=DB::table('orders')->insertGetId($order);
            Mail::to($request->c_email)->send(new Invoicemail($order));

            //order details
            $content=Cart::content();

            $details=array();
            foreach($content as $row){
                $details['order_id']=$orderId;
                $details['product_id']=$row->id;
                $details['product_name']=$row->name;
                $details['color']=$row->options->color;
                $details['size']=$row->options->size;
                $details['quantity']=$row->qty;
                $details['single_price']=$row->price;
                $details['subtotal_price']=$row->price*$row->qty;
                
                DB::table('order_details')->insert($details);
            }
            Cart::destroy();
            if (Session::has('coupon')) {
                Session::forget('coupon');
            }
            $notification=array('message' => 'successfully Order Placed!','alert-type' => 'success'); 
            return redirect()->to('/')->with($notification);
            //___aamerpay payment gateway 
        }elseif($request->payment_type=="Aamerpay"){
            $aamerpay=DB::table('payment_gateway_bd')->first();
            if ($aamerpay->store_id==NULL) {
                $notification=array('message' => 'Please setting your payment gateway!','alert-type' => 'error'); 
                return redirect()->to('/')->with($notification);
            }else{
                if ($aamerpay->status==1) {
                   $url = 'https://secure.aamarpay.com/request.php'; // live url https://secure.aamarpay.com/request.php
                }else{
                    $url = 'https://sandbox.aamarpay.com/request.php';
                }

                $fields = array(
                    'store_id' => $aamerpay->store_id, //store id will be aamarpay,  contact integration@aamarpay.com for test/live id
                    'amount' => Cart::total(), //transaction amount
                    'payment_type' => 'VISA', //no need to change
                    'currency' => 'BDT',  //currenct will be USD/BDT
                    'tran_id' => rand(1111111,9999999), //transaction id must be unique from your end
                    'cus_name' => $request->c_name,  //customer name
                    'cus_email' => $request->c_email, //customer email address
                    'cus_add1' => $request->c_address,  //customer address
                    'cus_add2' => 'Mohakhali DOHS', //customer address
                    'cus_city' => $request->c_city,  //customer city
                    'cus_state' => $request->c_city,  //state
                    'cus_postcode' => $request->c_zip_code, //postcode or zipcode
                    'cus_country' => $request->c_country,  //country
                    'cus_phone' => $request->c_phone, //customer phone number
                    'cus_fax' => $request->c_extra_phone,  //fax
                    'ship_name' => 'ship name', //ship name
                    'ship_add1' => 'House B-121, Road 21',  //ship address
                    'ship_add2' => 'Mohakhali',
                    'ship_city' => 'Dhaka', 
                    'ship_state' => 'Dhaka',
                    'ship_postcode' => '1212', 
                    'ship_country' => 'Bangladesh',
                    'desc' => 'payment description', 
                    'success_url' => route('success'), //your success route
                    'fail_url' => route('fail'), //your fail route
                    'cancel_url' => route('cancel'), //your cancel url
                    'opt_a' => $request->c_city,  //optional paramter
                    'opt_b' => $request->c_country,
                    'opt_c' => $request->c_address,//customer address
                    'opt_d' => $request->c_zip_code,
                    'signature_key' => $aamerpay->signature_key); //signature key will provided aamarpay, contact integration@aamarpay.com for test/live signature key

                $fields_string = http_build_query($fields);
         
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_VERBOSE, true);
                curl_setopt($ch, CURLOPT_URL, $url);  
          
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));  
                curl_close($ch); 

                $this->redirect_to_merchant($url_forward);
            }
            
        }
        
    }
    //__payment gateway exter method
    function redirect_to_merchant($url) {

        ?>
        <html xmlns="http://www.w3.org/1999/xhtml">
          <head><script type="text/javascript">
            function closethisasap() { document.forms["redirectpost"].submit(); } 
          </script></head>
          <body onLoad="closethisasap();">
          
            <form name="redirectpost" method="post" action="<?php echo 'https://sandbox.aamarpay.com/'.$url; ?>"></form>
            <!-- for live url https://secure.aamarpay.com -->
          </body>
        </html>
        <?php   
        exit;
    } 
    public function success(Request $request){
            $order=array();
            $order['user_id']=Auth::id();
            $order['c_name']=$request->cus_name;
            $order['c_phone']=$request->cus_phone;
            $order['c_email']=$request->cus_email;
            $order['c_address']=$request->opt_c;
            $order['c_country']=$request->opt_b;
            $order['c_city']=$request->opt_a;
            $order['c_zip_code']=$request->opt_d;
            if (Session::has('coupon')) {
                $order['subtotal']=Cart::subtotal();
                $order['coupon_code']=Session::get('coupon')['name'];
                $order['coupon_discount']=Session::get('coupon')['discount'];
                $order['after_discount']=Session::get('coupon')['after_discount'];
            }else{
                $order['subtotal']=Cart::subtotal();
            }
            $order['total']=Cart::total();
            $order['payment_type']="Aamerpay";
            $order['tex']=0;
            $order['shipping_chareg']=0;
            $order['order_id']=rand(10000,900000);
            $order['status']=1;
            $order['date']=date('d-m-Y');
            $order['month']=date('F');
            $order['year']=date('Y');

            $orderId=DB::table('orders')->insertGetId($order);
            //__Mail__
            Mail::to(Auth::user()->email)->send(new Invoicemail($order));

            //order details
            $content=Cart::content();

            $details=array();
            foreach($content as $row){
                $details['order_id']=$orderId;
                $details['product_id']=$row->id;
                $details['product_name']=$row->name;
                $details['color']=$row->options->color;
                $details['size']=$row->options->size;
                $details['quantity']=$row->qty;
                $details['single_price']=$row->price;
                $details['subtotal_price']=$row->price*$row->qty;
                
                DB::table('order_details')->insert($details);
            }
            Cart::destroy();
            if (Session::has('coupon')) {
                Session::forget('coupon');
            }
            $notification=array('message' => 'successfully Order Placed!','alert-type' => 'success'); 
            return redirect()->route('home')->with($notification);
    }
    public function fail(Request $request){
        return $request;
    }

}
