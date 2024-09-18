<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Image;
use Files;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    //Seo Setting Method-----------
    public function SeoSetting()
    {
        $data=DB::table('seos')->first();
        return view('admin.setting.seo',compact('data'));
    }
    //Seo Update--------
    public function SeoUpdate(Request $request,$id)
    {
        $data=array();
        $data['meta_title']=$request->meta_title;
        $data['meta_author']=$request->meta_author;
        $data['meta_tag']=$request->meta_tag;
        $data['meta_keyword']=$request->meta_keyword;
        $data['meta_description']=$request->meta_description;
        $data['google_verification']=$request->google_verification;
        $data['alexa_verification']=$request->alexa_verification;
        $data['google_analytics']=$request->google_analytics;
        $data['google_adsense']=$request->google_adsense;
        DB::table('seos')->where('id',$id)->update($data);
        $notification=array('message' => 'SEO Setting Updated !', 'alert-type' => 'success'); 
           return redirect()->back()->with($notification);
    }
    //SMTP setting------
    public function SmtpSetting()
    {
        $smtp=DB::table('smtps')->first();
        return view('admin.setting.smtp',compact('smtp'));
    }
    //SMTP Update----------
    public function SmtpUpdate(Request $request,$id)
    {
        $data=array();
        $data['mail_mailer']=$request->mail_mailer;
        $data['mail_host']=$request->mail_host;
        $data['mail_port']=$request->mail_port;
        $data['mail_username']=$request->mail_username;
        $data['mail_password']=$request->mail_password;
        DB::table('smtps')->where('id',$id)->update($data);
        $notification=array('message' => 'SMTP Setting Updated !', 'alert-type' => 'success'); 
           return redirect()->back()->with($notification);
    }
    //WEBSITE Setting----------
    public function websiteSetting()
    {
        $setting=DB::table('settings')->first();
        return view('admin.setting.website',compact('setting'));
    }
    //WEBSITE Setting update----------
    public function websiteUpdate(Request $request,$id)
    {
        $data=array();
        $data['currency']=$request->currency;
        $data['phone_one']=$request->phone_one;
        $data['phone_two']=$request->phone_two;
        $data['main_email']=$request->main_email;
        $data['support_email']=$request->support_email;
        $data['address']=$request->address;
        $data['facebook']=$request->facebook;
        $data['twitter']=$request->twitter;
        $data['instagram']=$request->instagram;
        $data['linkedin']=$request->linkedin;
        $data['youtube']=$request->youtube;
        if ($request->logo) { //New logo===
            $logo=$request->logo;
            $logo_name=uniqid().'.'.$logo->getClientOriginalExtension();
            //Image::make($logo)->resize(320,120)->save('public/backend/files/setting/'.$logo_name);
            $logo->move('public/backend/files/setting/',$logo_name);
            $data['logo']='public/backend/files/setting/'.$logo_name;
        }else{ //Old logo===
            $data['logo']=$request->old_logo;
        }
        if ($request->favicon) { //New Favicon===
            $favicon=$request->favicon;
            $favicon_name=uniqid().'.'.$favicon->getClientOriginalExtension();
            // Image::make($favicon)->resize(32,32)->save('public/backend/files/setting/'.$favicon_name);
            $favicon->move('public/backend/files/setting/',$favicon_name);
            $data['favicon']='public/backend/files/setting/'.$favicon_name;
        }else{ //Old Favicon===
            $data['favicon']=$request->old_favicon;
        }
        DB::table('settings')->where('id',$id)->update($data);
        $notification=array('message' => 'Website Setting Updated !', 'alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //page setting method--------
    public function index()
    {
        $page=DB::table('pages')->get();
        return view('admin.setting.page.index',compact('page'));
    }
    //page create method--------
    public function create()
    {
        return view('admin.setting.page.create');
    }
    //page insert-------------
    public function store(Request $request)
    {
        $data=array();
        $data['page_position']=$request->page_position;
        $data['page_name']=$request->page_name;
        $data['page_slug']=Str::slug($request->page_name,'-');
        $data['page_title']=$request->page_title;
        $data['page_description']=$request->page_description;
        DB::table('pages')->insert($data);
        $notification=array('message' => 'Page Created successfully!', 'alert-type' => 'success'); 
        return redirect()->route('page.index')->with($notification);
    }
    //page delete----------
    public function delete($id)
    {
        DB::table('pages')->where('id',$id)->delete();
        $notification=array('message' => 'Page Deleted!', 'alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //page edit-------------
    public function Edit($id)
    {
        $page=DB::table('pages')->where('id',$id)->first();
        return view('admin.setting.page.edit',compact('page'));
    }
    //page Update------------
    public function Update(Request $request, $id)
    {
        $data=array();
        $data['page_position']=$request->page_position;
        $data['page_name']=$request->page_name;
        $data['page_slug']=Str::slug($request->page_name,'-');
        $data['page_title']=$request->page_title;
        $data['page_description']=$request->page_description;
        DB::table('pages')->where('id',$id)->update($data);
        $notification=array('message' => 'Page Updated!', 'alert-type' => 'success'); 
        return redirect()->route('page.index')->with($notification);
    }
    //__Payment gateway
    public function PaymentGateway()
    {
       $aamerpay=DB::table('payment_gateway_bd')->first();
       $surjopay=DB::table('payment_gateway_bd')->skip(1)->first();
       $ssl=DB::table('payment_gateway_bd')->skip(2)->first();
       return view('admin.bdpayment_gateway.edit',compact('aamerpay','surjopay','ssl'));
    }
    //__AamerpayUpdate
    public function AamerpayUpdate(Request $request)
    {
        $data=array();
        $data['store_id']=$request->store_id;
        $data['signature_key']=$request->signature_key;
        $data['status']=$request->status;
        DB::table('payment_gateway_bd')->where('id',$request->id)->update($data);
        $notification=array('message' => 'Payment Gateway Updated!', 'alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //__SurjopayUpdate
    public function SurjopayUpdate(Request $request)
    {
        $data=array();
        $data['store_id']=$request->store_id;
        $data['signature_key']=$request->signature_key;
        $data['status']=$request->status;
        DB::table('payment_gateway_bd')->where('id',$request->id)->update($data);
        $notification=array('message' => 'Payment Gateway Updated!', 'alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
    //__SSlcommerzUpdate
    public function SSlcommerzUpdate(Request $request)
    {
        $data=array();
        $data['store_id']=$request->store_id;
        $data['signature_key']=$request->signature_key;
        $data['status']=$request->status;
        DB::table('payment_gateway_bd')->where('id',$request->id)->update($data);
        $notification=array('message' => 'Payment Gateway Updated!', 'alert-type' => 'success'); 
        return redirect()->back()->with($notification);
    }
}

