<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\LaraEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Api extends Controller
{
    //
    
 

   /* public function data_get (Request $req) {
        $get_data = DB::table('customers')->where('id',3)->get();
        print_r($get_data);
        foreach ($get_data as $user)
        {
            echo $user_id = $user->id;
        }
         return $user_id;
    }*/
    
    
    public function age_category() {
        //DB::table('product_categories')->where()->get();
        $array = ['Junior'=>251,'Senior'=>252,'Super Senior'=>253];
        return $array;
    }
    
    
    public function mobile_checking (Request $request) {
        $mobile = $request->mobile;
        
        $data = [];
        $output = [];
          $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
            if ($mobile=='9999999999') {
                
            }
                
               $count = DB::table('customers')->where(['customer_contact_no'=>$mobile])->count();
               if ($count>0) {
                   $output['response']=false;
                   $output['message']='Mobile No. Already Exist';
                   $output['data'] = $data;
                   $output['error'] = "Mobile No. Already Exist"; 
               } else {
                   $output['response']=true;
                   $output['message']='';
                   $output['data'] = $data;
                   $output['error'] = "";
               }
                
                
               
                
        }
        
        return $output;


    }
    
    public function email_checking (Request $request) {
        $email = $request->email;
        
        $data = [];
        $output = [];
          $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
                
               $count = DB::table('customers')->where(['customer_email'=>$email])->count();
               if ($count>0) {
                   $output['response']=false;
                   $output['message']='Email Already Exist';
                   $output['data'] = $data;
                   $output['error'] = "Email Already Exist"; 
               } else {
                   $output['response']=true;
                   $output['message']='';
                   $output['data'] = $data;
                   $output['error'] = "";
               }
                
                
               
                
        }
        
        return $output;


    }
    
    public function mobile_otp (Request $request) {
        $mobile = $request->mobile;
        
        $output = [];
          $validator = Validator::make($request->all(), [
            'mobile' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
                
                $otp = rand(100000,999999);
                $data = ['otp'=>$otp];
                //otp sender
                
                
               $output['response']=true;
               $output['message']='OTP send';
               $output['data'] = $data;
               $output['error'] = ""; 
                
        }
        
        return $output;


    }
    
    public function email_otp (Request $request) {
        $email = $request->email;
        
        $output = [];
          $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
            $count = DB::table('customers')->where(['customer_email'=>$email])->count();
            if ($email=='user@demo.com') {
                $otp = 123456;
                $data = ['otp'=>123456];
            } else {
                
                 $otp = rand(100000,999999);
                    $data = ['otp'=>$otp];
                //otp sender
                
        $mailInfo = new \stdClass();
        $mailInfo->recieverName = "";
        $mailInfo->sender = "SP Robotic Works";
        $mailInfo->senderCompany = "SP Robotic Works";
        $mailInfo->to = $email;
        $mailInfo->subject = "Login Authentication";
        $mailInfo->name = "SP Robotic Works";
        $mailInfo->from = "noreply@sproboticworks.com";
        $mailInfo->cc = "";
        $mailInfo->bcc = "";
        $mailInfo->otp = $otp;
 
        Mail::to($email)
           ->send(new LaraEmail($mailInfo));
           
            }
   
      
           
                
               $output['response']=true;
               $output['message']='OTP send';
               $output['data'] = $data;
               $output['error'] = ""; 
                
            
        }
        
        return $output;


    }
    
    public function login_mobile (Request $request) {
        $mobile = $request->mobile;
        $mobile1 = $mobile;
        $name = $request->name;
        $child_age = $request->child_age;
        
         $token = Str::random(10);
        
       $output = [];
          $validator = Validator::make($request->all(), [
            'mobile' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
            
        function str_replace_first($a,$b,$s)
         {
         $w=strpos($s,$a);
         if($w===false)return $s;
         return substr($s,0,$w).$b.substr($s,$w+strlen($a));
         }
         
            $digit = strlen($mobile);
            if ($digit==13) {
            $mobile = str_replace_first('+91','',$mobile);
            } else if ($digit==12) {
            $mobile = str_replace_first('91','',$mobile);
            } else if ($digit==11) {
            $mobile = str_replace_first('0','',$mobile);
            } else{
            $mobile=$mobile;
            }
            //echo $mobile;

            $count = DB::table('customers')->where(['customer_contact_no'=>$mobile])->count(); if($count>0) {$mobile1 = $mobile;}
            $count1 = DB::table('customers')->where(['customer_contact_no'=>'+91'.$mobile])->count(); if($count1>0) {$mobile1 = '+91'.$mobile;}
            $count2 = DB::table('customers')->where(['customer_contact_no'=>'0'.$mobile])->count(); if($count2>0) {$mobile1 = '0'.$mobile;}
            $count3 = DB::table('customers')->where(['customer_contact_no'=>'91'.$mobile])->count(); if($count3>0) {$mobile1 = '91'.$mobile;}
            if  ($count1>0 || $count2>0 || $count3>0 || $count>0) {
              //echo $mobile1;exit;
                $get_data = DB::table('customers')->where(['customer_contact_no'=>$mobile1])->first();
                $data['customer_id'] = $get_data->id;
                $data['customer_name'] = $get_data->customer_name;
                $data['customer_email'] = $get_data->customer_email;
                $data['customer_contact_no'] = $get_data->customer_contact_no;
                
                    $output['response']=true;
                    $output['message']='Login Successfully';
                    $output['data'] = $data;
                    $output['error'] = "";
                    
                    
            } else {
                $customer_id = DB::table('customers')->insertGetId(['customer_name'=>$name,'customer_contact_no'=>'+91'.$mobile,'age'=>$child_age,'status'=>'STUDENT','sub_type'=>'ONLINE_USER','form_id'=>52,'lead_medium_id'=>21,
                'lead_source_id'=>48,'medium'=>'MOBILE_APP','source'=>'GOOGLE_PLAYSTORE','is_head_office'=>1,'is_otp_verified'=>1,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),
                'token'=>$token,'whatsapp_opt_in'=>1]);
                
                $customer = DB::table('customers')->where(['id'=>$customer_id])->first();
            
            $insert = DB::table('enquiries')->insert(['customer_id'=>$customer_id,'contact_no'=>$customer->customer_contact_no,'email_id'=>$customer->customer_email,
            'parent_name'=>$customer->customer_name,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'form_id'=>52,'source_id'=>48,'medium_id'=>21]);
            
            DB::table('customers')->where(['id'=>$customer_id])->update(['last_enquired_date'=>date('Y-m-d H:i:s')]);
                
                
                $get_data = DB::table('customers')->where(['customer_contact_no'=>'+91'.$mobile])->first();
                $data['customer_id'] = $get_data->id;
                $data['customer_name'] = $get_data->customer_name;
                $data['customer_email'] = $get_data->customer_email;
                $data['customer_contact_no'] = $get_data->customer_contact_no;
                
             
                    $output['response']=true;
                    $output['message']='Data Inserted Successfully';
                    $output['data'] = $data;
                    $output['error'] = "";
                
                
            }
        } 
        return $output;
        
    }
    
    public function login_email (Request $request) {
        $email = $request->email;
        $name = $request->name;
        $child_age = $request->child_age;
       
         $token = Str::random(10);
         
       $output = [];
          $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
            $count = DB::table('customers')->where(['customer_email'=>$email])->count();
            if  ($count>0) {
                $get_data = DB::table('customers')->where(['customer_email'=>$email])->first();
                $data['customer_id'] = $get_data->id;
                $data['customer_name'] = $get_data->customer_name;
                $data['customer_email'] = $get_data->customer_email;
                $data['customer_contact_no'] = $get_data->customer_contact_no;
                
                    $output['response']=true;
                    $output['message']='Login Successfully';
                    $output['data'] = $data;
                    $output['error'] = "";
                    
                    
            } else {
                $customer_id = DB::table('customers')->insertGetId(['customer_name'=>$name,'customer_email'=>$email,'age'=>$child_age,'status'=>'STUDENT','sub_type'=>'ONLINE_USER','form_id'=>52,'lead_medium_id'=>21,
                'lead_source_id'=>48,'medium'=>'MOBILE_APP','source'=>'GOOGLE_PLAYSTORE','is_head_office'=>1,'is_otp_verified'=>1,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),
                'token'=>$token,'whatsapp_opt_in'=>1]);
                
                    $customer = DB::table('customers')->where(['id'=>$customer_id])->first();
            
            $insert = DB::table('enquiries')->insert(['customer_id'=>$customer_id,'contact_no'=>$customer->customer_contact_no,'email_id'=>$customer->customer_email,
            'parent_name'=>$customer->customer_name,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'form_id'=>52,'source_id'=>48,'medium_id'=>21]);
            
            DB::table('customers')->where(['id'=>$customer_id])->update(['last_enquired_date'=>date('Y-m-d H:i:s')]);
                
                $get_data = DB::table('customers')->where(['customer_email'=>$email])->first();
                $data['customer_id'] = $get_data->id;
                $data['customer_name'] = $get_data->customer_name;
                $data['customer_email'] = $get_data->customer_email;
                $data['customer_contact_no'] = $get_data->customer_contact_no;
                
                
                    $output['response']=true;
                    $output['message']='Data Inserted Successfully';
                    $output['data'] = $data;
                    $output['error'] = "";
                
                
            }
        } 
        return $output;
        
    }
    
    public function product (Request $request) {
        $age_category_id = $request->age_category_id;
        
       $output = [];
       $data = [];
          $validator = Validator::make($request->all(), [
            'age_category_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['popular'] = '';
            $output['error'] = "Validation error!";
        } else {
            $count = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>$age_category_id,'status'=>'ACTIVE'])->count();
            if ($count>0) {
            $product_arr = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>$age_category_id,'status'=>'ACTIVE'])->get();
            foreach ($product_arr as $val) {
                $product_id = $val->id;
                $name = $val->name;
                $slug = $val->slug;
                $iamge = $val->large_image;
                $description = $val->description;
                $mobile_app_image = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_image;
                $mobile_app_video = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_video;
                $short_description = $val->short_description;
                
                $price = DB::table('product_price')->where(['product_id'=>$product_id,'currency_id'=>1,'client_id'=>NULL,'product_item_id'=>NULL])->pluck('offer_local_price');
                $age_category = DB::table('product_categories')->where(['id'=>$age_category_id])->pluck('name');
               

                
                $data[] = ['product_id'=>$product_id,'name'=>$name,'slug'=>$slug,'iamge'=>$iamge,'description'=>$description,'short_description'=>$short_description,
                'price'=>$price,'age_category'=>$age_category,'mobile_app_image'=>$mobile_app_image,'mobile_app_video'=>$mobile_app_video];
            }
            
            if($age_category_id==251) {
                $count = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>252,'status'=>'ACTIVE'])->count();
            if ($count>0) {
            $product_arr = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>252,'status'=>'ACTIVE'])->get();
            foreach ($product_arr as $val) {
                $product_id = $val->id;
                $name = $val->name;
                $slug = $val->slug;
                $iamge = $val->large_image;
                $description = $val->description;
                $mobile_app_image = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_image;
                $mobile_app_video = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_video;
                $short_description = $val->short_description;
                
                $price = DB::table('product_price')->where(['product_id'=>$product_id,'currency_id'=>1,'client_id'=>NULL,'product_item_id'=>NULL])->pluck('offer_local_price');
                $age_category = DB::table('product_categories')->where(['id'=>$age_category_id])->pluck('name');
               

                
                $data1[] = ['product_id'=>$product_id,'name'=>$name,'slug'=>$slug,'iamge'=>$iamge,'description'=>$description,'short_description'=>$short_description,
                'price'=>$price,'age_category'=>$age_category,'mobile_app_image'=>$mobile_app_image,'mobile_app_video'=>$mobile_app_video];
            }
            }
            } else if ($age_category_id==252) {
                
                $count = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>251,'status'=>'ACTIVE'])->count();
            if ($count>0) {
            $product_arr = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>251,'status'=>'ACTIVE'])->get();
            foreach ($product_arr as $val) {
                $product_id = $val->id;
                $name = $val->name;
                $slug = $val->slug;
                $iamge = $val->large_image;
                $description = $val->description;
                $mobile_app_image = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_image;
                $mobile_app_video = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_video;
                $short_description = $val->short_description;
                
                $price = DB::table('product_price')->where(['product_id'=>$product_id,'currency_id'=>1,'client_id'=>NULL,'product_item_id'=>NULL])->pluck('offer_local_price');
                $age_category = DB::table('product_categories')->where(['id'=>$age_category_id])->pluck('name');
               

                
                $data1[] = ['product_id'=>$product_id,'name'=>$name,'slug'=>$slug,'iamge'=>$iamge,'description'=>$description,'short_description'=>$short_description,
                'price'=>$price,'age_category'=>$age_category,'mobile_app_image'=>$mobile_app_image,'mobile_app_video'=>$mobile_app_video];
            }
            }
            
            }
            else if ($age_category_id==253) {
                
                $count = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>251,'status'=>'ACTIVE'])->count();
            if ($count>0) {
            $product_arr = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>251,'status'=>'ACTIVE'])->get();
            foreach ($product_arr as $val) {
                $product_id = $val->id;
                $name = $val->name;
                $slug = $val->slug;
                $iamge = $val->large_image;
                $description = $val->description;
                $mobile_app_image = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_image;
                $mobile_app_video = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_video;
                $short_description = $val->short_description;
                
                $price = DB::table('product_price')->where(['product_id'=>$product_id,'currency_id'=>1,'client_id'=>NULL,'product_item_id'=>NULL])->pluck('offer_local_price');
                $age_category = DB::table('product_categories')->where(['id'=>$age_category_id])->pluck('name');
               

                
                $data1[] = ['product_id'=>$product_id,'name'=>$name,'slug'=>$slug,'iamge'=>$iamge,'description'=>$description,'short_description'=>$short_description,
                'price'=>$price,'age_category'=>$age_category,'mobile_app_image'=>$mobile_app_image,'mobile_app_video'=>$mobile_app_video];
            }
            }
            
            }
            
            
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['popular'] = $data1;
            $output['error'] = "";
            
            } else {
                $output['response']=false;
            $output['message']='NO data found';
            $output['data'] = $data;
            $output['popular'] = '';
            $output['error'] = "";
            }
            
        }
        
        return $output;
    }
    
    public function cart (Request $request) {
        $customer_id = $request->customer_id;
        $total_local_price = $request->total_local_price;
        $billing_address_id = $request->billing_address_id;
        $delivery_address_id = $request->delivery_address_id;
        
        $cart_item_id = $request->cart_item_id;
        $cart_id = $request->cart_id;
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $local_price = $request->local_price;
        
        $output = [];
          $validator = Validator::make($request->all(), [
            'customer_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
            $count = DB::table('cart')->where(['customer_id'=>$customer_id,'currency_id'=>1])->count();
            if ($count>0) {
                //cart not empty
                $cart_get = DB::table('cart')->where(['customer_id'=>$customer_id,'currency_id'=>1])->first();
                $cart_id_get = $cart_get->id; //same cart_id
               
                
                if ($cart_item_id=='') {
                    $insert = DB::table('cart_items')->insert(['cart_id'=>$cart_id_get,'product_id'=>$product_id,'quantity'=>$quantity,'local_price'=>$local_price]);
                    $update_cart_item = DB::table('cart')->where(['id'=>$cart_id_get])->update(['total_local_price'=>$total_local_price]);
                    
                } else {
                    $update = DB::table('cart_items')->where(['id'=>$cart_item_id])->update(['quantity'=>$quantity]);
                    $update_cart_item = DB::table('cart')->where(['id'=>$cart_id_get])->update(['total_local_price'=>$total_local_price]);
                }
                
                $output['response']=true;
                $output['message']='Data';
                $output['data'] = "Cart Updated";
                $output['error'] = "";
                
            } else {
                //cart empty
                $token =  Str::random(40);
                $insert = DB::table('cart')->insert(['session_id'=>$token,'customer_id'=>$customer_id,'currency_id'=>1,'total_local_price'=>$total_local_price,'billing_address_id'=>$billing_address_id,
                'delivery_address_id'=>$delivery_address_id,'total_international_price'=>0]);
                
                $cart_get = DB::table('cart')->where(['customer_id'=>$customer_id,'currency_id'=>1])->first();
                $cart_id_get = $cart_get->id; //same cart_id
                
                $insert = DB::table('cart_items')->insert(['cart_id'=>$cart_id_get,'product_id'=>$product_id,'quantity'=>$quantity,'local_price'=>$local_price]);
                
                $output['response']=true;
                $output['message']='Data';
                $output['data'] = "Cart Added";
                $output['error'] = "";
            
            
            }
        }
        return $output;
    }
    
    public function get_cart (Request $request) {
        
       $customer_id = $request->customer_id;
        $data = [];
       $output = [];
          $validator = Validator::make($request->all(), [
            'customer_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
            $count = DB::table('cart')->where(['customer_id'=>$customer_id])->count();
            if ($count>0) {
                
                $get = DB::table('cart')->where(['customer_id'=>$customer_id])->first();
                $data1['cart_id'] = $get->id;
                $data1['product_total_price'] = $get->total_local_price;
                
                
                $cart_item_array = DB::table('cart_items')->where(['cart_id'=>$get->id])->get();
                foreach ($cart_item_array as $val) {
                    $product_id = $val->product_id;
                    $product_quantity = $val->quantity;
                    $product_local_price = $val->local_price;
                    
                    
                    $product_name = DB::table('product')->where('id',$product_id)->pluck('name');
                    $image = DB::table('product')->where('id',$product_id)->first();
                    $data[] = ['item_id'=>$val->id,'product_id'=>$product_id,'product_quantity'=>$product_quantity,'product_local_price'=>$product_local_price,'product_name'=>$product_name,
                    'image'=>'https://storage.googleapis.com/sproboticworks'.$image->mobile_app_image];
                }
                $output['response']=true;
                $output['message']='Data';
                $output['data'] = $data;
                $output['data1'] = $data1;
                $output['error'] = "";
                
            } else {
                $output['response']=true;
                $output['message']='No Data Found';
                $output['data'] = $data;
                $output['error'] = "";
            }
        }
        
        return $output;
    }
    
    public function cart_delete(Request $request) {
        $cart_item_id = $request->cart_item_id;
        $cart_id1 = $request->cart_id;
        
        $output = [];
          $validator = Validator::make($request->all(), [
            //'cart_item_id' => 'required'
        ]);
        if ($validator->fails()) {
            
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
            
        } else {
            
            if ($cart_item_id!='') {
            $cart_item = DB::table('cart_items')->where(['id'=>$cart_item_id])->first();
            $cart_id = $cart_item->cart_id;
            $product_id = $cart_item->product_id;
            $quantity = $cart_item->quantity;
            
            $cart = DB::table('cart')->where(['id'=>$cart_id])->first();
            $total_local_price = $cart->total_local_price;
            
            
            
            $product_price = DB::table('product_price')->where(['product_id'=>$product_id])->first();
            $product_price = $product_price->offer_local_price;
            
            $total_local_price = $total_local_price-$product_price*$quantity;
            
            DB::table('cart')->where(['id'=>$cart_id])->update(['total_local_price'=>$total_local_price]);
            
            
            $delete = DB::table('cart_items')->where(['id'=>$cart_item_id])->delete();
            }
            if ($cart_id1!='') {
                DB::table('cart_items')->where(['cart_id'=>$cart_id])->delete();
            //$delete = DB::table('cart')->where(['id'=>$cart_id])->delete();
            DB::table('cart')->where(['id'=>$cart_id])->update(['total_local_price'=>'0.00']);
            }
            
            $output['response']=true;
            $output['message']='Product Delete From Cart';
            $output['data'] = null;
            $output['error'] = "";
            
        }
        return $output;
    }
    
    public function cart_update (Request $request) {
        $cart_item_id = $request->cart_item_id;
        $qty = $request->qty;
        $action = $request->action;
        
        $output = [];
          $validator = Validator::make($request->all(), [
            'cart_item_id' => 'required',
            //'qty' => 'required'
        ]);
        if ($validator->fails()) {
            
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
            
        } else {
            
            $cart_item_detl = DB::table('cart_items')->where(['id'=>$cart_item_id])->first();
            $cart_id = $cart_item_detl->cart_id;
            $product_id = $cart_item_detl->product_id;
            
            $cart_detl = DB::table('cart')->where(['id'=>$cart_id])->first();
            $total = $cart_detl->total_local_price;
            
            $product_detl = DB::table('product_price')->where(['product_id'=>$product_id])->first();
            $price = $product_detl->offer_local_price;
            $item_total = $qty*$price;
            
            if ($action=='plus') {
                $cart_total = $total+$price;
            } else {
                $cart_total = $total-$price;
            }
            
            
            $update_item = DB::table('cart_items')->where(['id'=>$cart_item_id])->update(['quantity'=>$qty]);
            $update_cart = DB::table('cart')->where(['id'=>$cart_id])->update(['total_local_price'=>$cart_total]);
            
            $output['response']=true;
            $output['message']='Cart Update';
            $output['data'] = [];
            $output['error'] = "";
            
        }
        return $output;
    } 
    
    public function coupon (Request $request) {
        $code = $request->code;
        $cart_id = $request->cart_id;
        
        $output = [];
          $validator = Validator::make($request->all(), [
            'code' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
            
            $count = DB::table('coupon')->where(['code'=>$code,'status'=>'ACTIVE','apply_to'=>'PRODUCT'])->whereNull('currency_id')->count();//, //
            if ($count>0) {
                
                $coupon = DB::table('coupon')->where(['code'=>$code])->first();
                $data[] = [
                'coupon_id'=>$coupon->id,
                'code'=>$code,
                'currency_id'=>$coupon->currency_id,
                'coupon_name'=>$coupon->name,
                'coupon_tax_type'=>$coupon->coupon_tax_type,
                'coupon_type'=>$coupon->coupon_type,
                'value_type'=>$coupon->value_type,
                //'min_local_amount'=>$coupon->min_local_amount,
                'local_value'=>$coupon->local_value, //local value might be absolute or persentage
                'applicable_item_id'=>$coupon->applicable_item_id
                ];
                
                
                
                $cart_item_count = DB::table('cart_items')->where(['cart_id'=>$cart_id])->count();
                if ($cart_item_count>1) {
                    $output['response']=false;
                    $output['message']='Coupon Not Applicable';
                    $output['data'] = null;
                    $output['error'] = "";
                } else {
                    $product_check_coupon = DB::table('cart_items')->where(['cart_id'=>$cart_id,'product_id'=>$coupon->applicable_item_id])->count();
                    if ($product_check_coupon>0) {
                        $output['response']=true;
                        $output['message']='Coupon Applied';
                        $output['data'] = $data;
                        $output['error'] = "";
                    } else {
                        $output['response']=false;
                        $output['message']='Coupon Not Applicable';
                        $output['data'] = null;
                        $output['error'] = "";
                    }
                }
                
                
                
            } else {
                $output['response']=false;
                $output['message']='Sorry, No Coupon Found';
                $output['data'] = null;
                $output['error'] = "";
            }
            
        }
        return $output;
    }
    
    public function coupon_deduction (Request $request) {
        $code = $request->code;
        $cart = $request->cart;
        
        $output = [];
          $validator = Validator::make($request->all(), [
            'code' => 'required',
            'cart' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
            
            $cart_details = DB::table('cart')->where(['id'=>$cart])->first();
            $total_price = $cart_details->total_local_price;
            
            $coupon_details = DB::table('coupon')->where(['code'=>$code])->first();
            $amount = $coupon_details->local_value;
            $type = $coupon_details->value_type;
            
            if ($type=='PERCENTAGE') {
                $x = $total_price*$amount;
                $data['discount'] = round($x/100);
                //$z = $x-$y;
            } else if ($type=='ABSOLUTE') {
                $data['discount'] = $amount;
            }
            $output['response']=true;
            $output['message']='Discount Amount';
            $output['data'] = $data;
            $output['error'] = "";
        }
        return $output;
    }
    
    public function gst_calculation (Request $request) {
        $pincode = $request->pincode;
        $pincode = $request->pincode;
        
        $output = [];
          $validator = Validator::make($request->all(), [
            'code' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
            
            
            
        }
        return $output;    
    }
    
    //if the state id='tamil nadu' then cgst and sgst applied , else igst applied  
    
    public function order_place(Request $request) {
        $cart_id = $request->cart_id;
        $customer_id = $request->customer_id;
        $coupon_id = $request->coupon_id;
        $coupon_amount = $request->coupon_amount;
        $total_tax = $request->total_tax;
        $customer_address = $request->customer_address;
        $customer_city = $request->customer_city;
        $customer_city_id = $request->customer_city_id;
        $customer_state = $request->customer_state;
        $customer_state_id = $request->customer_state_id;
        $customer_postal_code = $request->customer_postal_code;
        $requested_json = $request->requested_json;
        
         $output = [];
          $validator = Validator::make($request->all(), [
            'cart_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
            
            $db_order_sequence = DB::table('sequence_number')->where(['name'=>'order'])->first();
            $order_sequence = $db_order_sequence->cur_value;
            
            $db_invoice_sequence = DB::table('sequence_number')->where(['name'=>'invoice'])->first();
            $invoice_sequence = $db_invoice_sequence->cur_value;
            
            $db_transaction_sequence = DB::table('sequence_number')->where(['name'=>'transaction'])->first();
            $transaction_sequence = $db_transaction_sequence->cur_value;
            
            $order_no = 'KORD'.date('Ymd').$order_sequence;
            $invoice_no = 'SP'.date('y').$invoice_sequence;
            $transaction_no = date('Ymd').$transaction_sequence;
            
            $token = Str::random(10);
            
            $customer_name = DB::table('customers')->where(['id'=>$customer_id])->pluck('customer_name');
            $customer_name = DB::table('customers')->where(['id'=>$customer_id])->first();
            $customer_name1 = $customer_name->customer_name;
            $contact_no1 = $customer_name->customer_contact_no;
         
            $cart_d = DB::table('cart')->where(['id'=>$cart_id])->first();
            $total_local_price = $cart_d->total_local_price;
            if ($coupon_amount!='') {
                $total_local_price = $total_local_price-$coupon_amount;
                $coupon_amount_withouttax = $coupon_amount/1.18;
                
            } else {
                $total_local_price = $total_local_price;
                $coupon_amount_withouttax = 0;
            }
                
            $total_tax1 = $total_local_price/1.18;
            $total_tax = $total_local_price-$total_tax1;
            
             $order = DB::table('order')->insertGetId(['order_no'=>$order_no,'customer_id'=>$customer_id,'cart_id'=>$cart_id,'coupon_id'=>$coupon_id,'currency'=>'INR','total_tax'=>$total_tax,
            'coupon_amount'=>$coupon_amount_withouttax,'discount'=>$coupon_amount_withouttax,'amount_payable'=>$total_local_price,'sub_total'=>$total_local_price-$total_tax,
            'total_without_tax'=>$total_tax1,'net_total'=>$total_local_price,'paid_amount'=>$total_local_price,'status'=>'PROCESSING','tds_amount'=>0,'order_date'=>date('Y-m-d H:i:s'),'payment_date'=>date('Y-m-d H:i:s')
            ,'is_mobile_order'=>1,'token'=>$token,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'last_paid_amount'=>$total_local_price,'order_results_shown'=>1,'license_status'=>'PENDING',
            'mobile_order_status'=>'PENDING']);
            
            $transaction_details = DB::table('transaction_details')->insert(['order_id'=>$order,'amount'=>$total_local_price,'status'=>'INITIATED','payment_mode_id'=>17,
            'transaction_id'=>$transaction_no,'initiated_at'=>date('Y-m-d H:i:s'),'completed_at'=>date('Y-m-d H:i:s'),'request_body'=>$requested_json]);
           
            $cart_arr = DB::table('cart_items')->where(['cart_id'=>$cart_id])->get();
            foreach ($cart_arr as $val_cart) {
                $product_id = $val_cart->product_id;
                $quantity = $val_cart->quantity;
                $local_price1 = $val_cart->local_price;
                $local_price = $val_cart->local_price*$quantity;
                
                $p = DB::table('product')->where(['id'=>$product_id])->first();
                $name = $p->name;
                $hsn_code = $p->hsn_code;
                /*$t = $local_price*18; 
                $t2 = $t/100; //( cgst+sgst ) + Igst
                $t3 = $t2/2; // signle 9% tax
                */
                
                if ($coupon_amount!='') {
                $local_price = $local_price-$coupon_amount;
                //$coupon_amount_withouttax = $coupon_amount/1.18;
                
                } else {
                    $local_price = $local_price;
                  //  $coupon_amount_withouttax = 0;
                }
                
                $before_tax = $local_price/1.18;
                $t2 = $local_price-$before_tax;
                
                $t3 = $t2/2;
                
                $price1 =  $local_price-$t2;
                //$price2 = $price1/$quantity;
                
                $order_item = DB::table('order_items')->insertGetId(['order_id'=>$order,'product_id'=>$product_id,'quantity'=>$quantity,'price'=>$before_tax,
                'sub_total'=>$local_price-$t2,'net_total'=>$local_price,'status'=>'PROCESSING',
                'item_name'=>$name,'hsncode'=>$hsn_code,'total_tax'=>$t2,'total_without_tax'=>$local_price-$t2,'paid_amount'=>$local_price,'last_paid_amount'=>$local_price,
                'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'license_status'=>'PENDING','discount'=>$coupon_amount_withouttax,'coupon_discount'=>$coupon_amount_withouttax,
                'license_status'=>'PENDING']);
                
                
                
                //if tamil nadu then order_item_taxes table fillup data
                if ($customer_state_id ==24) {
                   $cgst = DB::table('tax')->where(['code'=>'CGST-9'])->first();
                   $cgst_id = $cgst->id;
                   $sgst = DB::table('tax')->where(['code'=>'SGST-9'])->first();
                   $sgst_id = $sgst->id;
                   
                   DB::table('order_item_taxes')->insert([ 'order_id'=>$order,'order_item_id'=>$order_item,'tax_id'=>$cgst_id,'tax_amount'=>$t3,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s') ]);
                   
                   DB::table('order_item_taxes')->insert([ 'order_id'=>$order,'order_item_id'=>$order_item,'tax_id'=>$sgst_id,'tax_amount'=>$t3,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s') ]);
                   
                } else {
                    $igst_id = DB::table('tax')->where(['code'=>'IGST-18-PERCENTGAE'])->first();
                    $igst_id_id = $igst_id->id;
                    
                    DB::table('order_item_taxes')->insert([ 'order_id'=>$order,'order_item_id'=>$order_item,'tax_id'=>$igst_id_id,'tax_amount'=>$t2,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s') ]);
                    
                }
                
                
                
                
                
             
             
             
                
             $count = DB::table('customer_addresses')->where(['customer_id'=>$customer_id])->count();    
                $user = DB::table('customers')->where(['id'=>$customer_id])->first();
            if ($count>0) {
                DB::table('customer_addresses')->where(['customer_id'=>$customer_id])->orderBy('id','desc')->limit(1)->update(['name'=>$user->customer_name,'address'=>$customer_address,
                'city_id'=>$customer_city_id,'state_id'=>$customer_state_id,'country_id'=>3,'postal_code'=>$customer_postal_code,'contact_no'=>$user->customer_contact_no]);
                
                DB::table('customers')->where(['id'=>$customer_id])->update(['address'=>$customer_address,'city_id'=>$customer_city_id,
                'preferred_state_id'=>$customer_state_id,'country_id'=>3,'postal_code'=>$customer_postal_code]);
                
            } else {
                DB::table('customer_addresses')->insert(['name'=>$user->customer_name,'customer_id'=>$customer_id,'address'=>$customer_address,'city_id'=>$customer_city_id,
                'state_id'=>$customer_state_id,'country_id'=>3,'postal_code'=>$customer_postal_code,'contact_no'=>$user->customer_contact_no]);
                
                DB::table('customers')->where(['id'=>$customer_id])->update(['address'=>$customer_address,'city_id'=>$customer_city_id,
                'preferred_state_id'=>$customer_state_id,'country_id'=>3,'postal_code'=>$customer_postal_code]);
                
            }
            
            
            
            
                
               /* DB::table('billing_details')->insert(['order_id'=>$order,
                'customer_name'=>$customer_name,'customer_address'=>$customer_address,'customer_city'=>$customer_city,'customer_city_id'=>$customer_city_id,
                'customer_state'=>$customer_state,'customer_state_id'=>$customer_state_id,'customer_country_id'=>3,'customer_postal_code'=>$customer_postal_code
                ]);*/
                
                DB::table('shipping_details')->insert(['order_id'=>$order,'shipper_id'=>1,'order_item_id'=>$order_item,'order_product_item_id'=>null,
                'customer_name'=>$customer_name1,'customer_address'=>$customer_address,'customer_city'=>$customer_city,'customer_city_id'=>$customer_city_id,
                'customer_state'=>$customer_state,'customer_state_id'=>$customer_state_id,'customer_country_id'=>3]);
                
            }
            
            DB::table('billing_details')->insert(['order_id'=>$order,
                'customer_name'=>$customer_name1,'customer_address'=>$customer_address,'customer_city'=>$customer_city,'customer_city_id'=>$customer_city_id,
                'customer_state'=>$customer_state,'customer_state_id'=>$customer_state_id,'customer_country_id'=>3,'customer_postal_code'=>$customer_postal_code,
                'contact_no'=>$contact_no1]);
                
                
            DB::table('cart_items')->where(['cart_id'=>$cart_id])->delete();
            
            DB::table('cart')->where(['id'=>$cart_id])->update(['total_local_price'=>'0.00']);
            
            DB::table('sequence_number')->where(['name'=>'order'])->update(['cur_value'=>$order_sequence+1]);
            //DB::table('sequence_number')->where(['name'=>'invoice'])->update(['cur_value'=>$invoice_sequence+1]);    
            DB::table('sequence_number')->where(['name'=>'transaction'])->update(['cur_value'=>$transaction_sequence+1]);   
            
            
            
            
            
            
            $data['order_id']=$order;
            $data['order_no']=$order_no;
            $data['invoice_no']=$invoice_no;
            $data['transaction_no']=$transaction_no;
            $output['response']=true;
            $output['message']='Order Place successfully';
            $output['data'] = $data;
            $output['error'] = "";
            
        }
        return $output;
    }
    
    //AS FAILED TRANSACTION ORDER + ORDER-ITEM STATUS CANCELLED
    //SUCCESS ORDER + ORDER-ITEM STATUS PAID,  DATA INSER TRANSACTION TABLE, CART + CART ITEM REMOVE
    //Enquery
    
    
    public function order_success (Request $request) {
        $response_body = $request->response_body;
        $json = json_decode($response_body);
        $razorpay_payment_id = $json->razorpay_payment_id;
        $data = [];
        $output = [];
          $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'order_no'=>'required',
            'invoice_no'=>'',
            'transaction_no'=>'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
            //new invoice sequence
            $db_invoice_sequence = DB::table('sequence_number')->where(['name'=>'invoice'])->first();
            $invoice_sequence = $db_invoice_sequence->cur_value;
            $invoice_no = 'SP'.date('y').$invoice_sequence;
            
            //order details 
            $odrder_details = DB::table('order')->where(['id'=>$request->order_id])->first();
            $customer_id = $odrder_details->customer_id;
            
            //order , order_item, transaction details update while payment success
            DB::table('order')->where(['id'=>$request->order_id])->update(['invoice_no'=>$invoice_no,'status'=>'PAID']);
            DB::table('order_items')->where(['order_id'=>$request->order_id])->update(['status'=>'PAID']);
            DB::table('transaction_details')->where(['order_id'=>$request->order_id])->update(['vendor_transaction_id'=>$razorpay_payment_id,'status'=>'SUCCESS','response_body'=>$response_body]);
            
            //invoice sequence add
            DB::table('sequence_number')->where(['name'=>'invoice'])->update(['cur_value'=>$invoice_sequence+1]); 
            
            //isconverted customer
            $is_converted_count = DB::table('customers')->where(['id'=>$customer_id,'is_converted'=>1])->count();
            if ($is_converted_count==0) {
                DB::table('customers')->where(['id'=>$customer_id])->update(['is_converted'=>1,'converted_date'=>date('Y-m-d H:i:s')]);
            }
            
            $output['response']=true;
            $output['message']='Order Place successfully';
            $output['data'] = $data;
            $output['error'] = "";
            
        }
        return $output;
    }
    
    public function order_failed (Request $request) {
        $response_body = $request->response_body;
        $data = [];
        $output = [];
          $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = null;
            $output['error'] = "Validation error!";
        } else {
            $db_invoice_sequence = DB::table('sequence_number')->where(['name'=>'invoice'])->first();
            $invoice_sequence = $db_invoice_sequence->cur_value;
            $invoice_no = 'SP'.date('y').$invoice_sequence;
            
            //DB::table('order')->where(['id'=>$request->order_id])->update(['invoice_no'=>$invoice_no,'status'=>'PAID']);
            //DB::table('order_items')->where(['order_id'=>$request->order_id])->update(['status'=>'PAID']);
            DB::table('transaction_details')->where(['order_id'=>$request->order_id])->update(['status'=>'FAIL','response_body'=>$response_body]);
            
            $output['response']=true;
            $output['message']='Order Failed';
            $output['data'] = $data;
            $output['error'] = "";
            
        }
        return $output;
    }
    
    public function order_history (Request $request) {
        $customer_id = $request->customer_id;
        $data = [];
        $output = [];
          $validator = Validator::make($request->all(), [
            'customer_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            $count = DB::table('order')->where(['customer_id'=>$customer_id])->count();
            if ($count>0) {
                
                $order = DB::table('order')->orderBy('id','DESC')->where(['customer_id'=>$customer_id])->get();
                foreach ($order as $val) {
                 
                    $order_id = $val->id;
                    $order_no = $val->order_no;
                    $invoice_no = $val->invoice_no;
                    $order_date = $val->order_date;
                    $payment_date = $val->payment_date;
                    
                    $order_item_array = [];
                    $order_item = DB::table('order_items')->where(['order_id'=>$order_id])->get();
                    foreach ($order_item as $val1) {
                        $order_item_id = $val1->id;
                        $product_id = $val1->product_id;
                        $item_name = $val1->item_name;
                        $quantity = $val1->quantity;
                        $price = $val1->price;
                        $sub_total = $val1->sub_total;
                        $net_total = $val1->net_total;
                        $status = $val1->status;
                        
                        $product = DB::table('product')->where(['id'=>$product_id])->first();
                        $mobile_app_image = $product->mobile_app_image;
                        $item_name = $product->name;
                        
                        $order_item_array[] = ['order_item_id'=>$order_item_id,'product_id'=>$product_id,'item_name'=>$item_name,'quantity'=>$quantity,'price'=>$price,
                        'sub_total'=>$sub_total,'net_total'=>$net_total,'payment_date'=>$payment_date,'mobile_app_image'=>'https://storage.googleapis.com/sproboticworks'.$mobile_app_image,
                        'status'=>$status];
                    }
                    $data[] = ['order_id'=>$order_id,'order_no'=>$order_no,'invoice_no'=>$invoice_no,'order_date'=>$order_date,'order_item_array'=>$order_item_array];
                }
                $output['response']=true;
                $output['message']='Order data';
                $output['data'] = $data;
                $output['error'] = "";
                
            } else {
                $output['response']=false;
                $output['message']='Order is empty';
                $output['data'] = $data;
                $output['error'] = "";
            }
            
            
        }
        return $output;
    }
    
    //differst table add same data ==> billing details, customer
    
    public function state (Request $request) {
        $data = [];
        $output = [];
          $validator = Validator::make($request->all(), [
            //'customer_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $state = DB::table('state')->where(['country_id'=>3,'status'=>'ACTIVE'])->get();
            foreach ($state as $val) {
                $data[] = ['id'=>$val->id,'code'=>$val->code,'name'=>$val->name,'slug'=>$val->slug];
            }
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
        }
        return $output;
    }
    
    public function city (Request $request) {
        $state_id = $request->state_id;
        $data = [];
        $output = [];
          $validator = Validator::make($request->all(), [
            'state_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $cities = DB::table('cities')->where(['country_id'=>3,'status'=>'ACTIVE','state_id'=>$state_id])->get();
            foreach ($cities as $val) {
                $data[] = ['id'=>$val->id,'code'=>$val->code,'name'=>$val->name,'slug'=>$val->slug];
            }
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
        }
        return $output;
    }
    
    
    public function customer_reg_add_save (Request $request) {
        $customer_id = $request->customer_id;
        $state_id = $request->state;
        $postal_code = $request->postal_code;
        
        $data = [];
        $output = [];
          $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            //'postal_code' => 'digits:6',
            //'contact_no' => 'digits:10'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            $count = DB::table('customer_addresses')->where(['customer_id'=>$customer_id])->count();
           
              
            
            $user = DB::table('customers')->where(['id'=>$customer_id])->first();
            if ($count>0) {
                
                DB::table('customers')->where(['id'=>$customer_id])->update(['preferred_state_id'=>$state_id,'state_id'=>$state_id,'country_id'=>3,'postal_code'=>$postal_code]);
                
            } else {
                
                DB::table('customers')->where(['id'=>$customer_id])->update(['preferred_state_id'=>$state_id,'state_id'=>$state_id,'country_id'=>3,'postal_code'=>$postal_code]);
                
            }
            
            
            
            
            $data =[];
            
            
            
            
            $output['response']=true;
            $output['message']='Address Updated Successfully';
            $output['data'] = $data;
            $output['error'] = "";
            
            
            
            
        }
        return $output;
    }
    
    public function customer_address_save (Request $request) {
        $customer_id = $request->customer_id;
        $address = $request->address;
        $city_id = $request->city;
        $state_id = $request->state;
        $landmark = $request->landmark;
        $postal_code = $request->postal_code;
        $contact_no = $request->contact_no;
        
        $data = [];
        $output = [];
          $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            //'postal_code' => 'digits:6',
            //'contact_no' => 'digits:10'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            $count = DB::table('customer_addresses')->where(['customer_id'=>$customer_id])->count();
           
            if ($address!='') {
            
                
            
            $user = DB::table('customers')->where(['id'=>$customer_id])->first();
            if ($count>0) {
                DB::table('customer_addresses')->where(['customer_id'=>$customer_id])->orderBy('id','desc')->limit(1)->update(['name'=>$user->customer_name,'address'=>$address,
                'city_id'=>$city_id,'state_id'=>$state_id,'country_id'=>3,'postal_code'=>$postal_code,'contact_no'=>$contact_no]);
                
                DB::table('customers')->where(['id'=>$customer_id])->update(['address'=>$address,'city_id'=>$city_id,'preferred_city_id'=>$city_id,'preferred_location'=>$landmark,
                'preferred_state_id'=>$state_id,'state_id'=>$state_id,'country_id'=>3,'postal_code'=>$postal_code]);
                
            } else {
                DB::table('customer_addresses')->insert(['name'=>$user->customer_name,'customer_id'=>$customer_id,'address'=>$address,'city_id'=>$city_id,
                'state_id'=>$state_id,'country_id'=>3,'postal_code'=>$postal_code,'contact_no'=>$contact_no]);
                
                DB::table('customers')->where(['id'=>$customer_id])->update(['address'=>$address,'city_id'=>$city_id,'preferred_city_id'=>$city_id,'preferred_location'=>$landmark,
                'preferred_state_id'=>$state_id,'state_id'=>$state_id,'country_id'=>3,'postal_code'=>$postal_code]);
                
            }
            
            
            
            
            } 
            
            $data =[];
            if ($count>0) {
            $add_arry = DB::table('customer_addresses')->where(['customer_id'=>$customer_id])->orderBy('id', 'DESC')->limit(1)->first();
            $data[] = ['id'=>$add_arry->id,
            'address'=>$add_arry->address,
            'city_id'=>$add_arry->city_id,
            'city_name'=>DB::table('cities')->where(['id'=>$add_arry->city_id])->pluck('name'),
            'state_id'=>$add_arry->state_id,
            'state_name'=>DB::table('state')->where(['id'=>$add_arry->state_id])->pluck('name'),
            'country_id'=>$add_arry->country_id,
            'postal_code'=>$add_arry->postal_code,
            'contact_no'=>$add_arry->contact_no];
            }
            
            
            
            $output['response']=true;
            $output['message']='Address Updated Successfully';
            $output['data'] = $data;
            $output['error'] = "";
            
            
            
            
        }
        return $output;
    }
    
    
    public function profile_update (Request $request) {
        $customer_id = $request->customer_id;
        $customer_name = $request->customer_name;
        $customer_email = $request->customer_email;
        $customer_contact_no = $request->customer_contact_no;
        $student_name = $request->student_name;
        $student_email_id = $request->student_email_id;
        $student_contact_no = $request->student_contact_no;
        $dob = $request->dob;
        $gender = $request->gender;
        
        $data = [];
        $output = [];
          $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            //'customer_email' => 'email',
            //'customer_contact_no' => 'digits:10',
            //'student_email_id' => 'email',
            //'student_contact_no' =>'digits:10'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            if ($customer_name!='') {
            DB::table('customers')->where(['id'=>$customer_id])->update(['customer_name'=>$customer_name,'customer_email'=>$customer_email,'customer_contact_no'=>$customer_contact_no,
            'student_name'=>$student_name,'student_email_id'=>$student_email_id,'student_contact_no'=>$student_contact_no,'dob'=>$dob,'gender'=>$gender
            ]);
            
            }
            
            $customer = DB::table('customers')->where(['id'=>$customer_id])->first();
            $array['customer_name'] = $customer->customer_name;
            $array['customer_email'] = $customer->customer_email;
            $array['customer_contact_no'] = $customer->customer_contact_no;
            $array['student_name'] = $customer->student_name;
            $array['student_email_id'] = $customer->student_email_id;
            $array['student_contact_no'] = $customer->student_contact_no;
            $array['dob'] = date("d-m-Y",strtotime($customer->dob));
            $array['age'] = $customer->age;
            $array['gender'] = $customer->gender;
            
            $array['status'] = $customer->status;
            
            $data[] = ['details'=>$array];
            
            $output['response']=true;
            $output['message']='Datails';
            $output['data'] = $data;
            $output['error'] = "";
            
        }
        return $output;
    }
    
    public function enquiry (Request $request) {
        $customer_id = $request->customer_id;
        $product_id = $request->product_id;
        $message = $request->message;
        
        $data = [];
        $output = [];
          $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            //'product_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $customer = DB::table('customers')->where(['id'=>$customer_id])->first();
            
            $insert = DB::table('enquiries')->insert(['customer_id'=>$customer_id,'contact_no'=>$customer->customer_contact_no,'message'=>$message,'product_id'=>$product_id,
            'parent_name'=>$customer->customer_name,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'form_id'=>52,'source_id'=>48,'medium_id'=>21]);
            
            DB::table('customers')->where(['id'=>$customer_id])->update(['last_enquired_date'=>date('Y-m-d H:i:s')]);
            
           if ($insert==1) {
              $output['response']=true;
            $output['message']='Data Save Successfully';
            $output['data'] = $data;
            $output['error'] = ""; 
           } else {
           $output['response']=false;
            $output['message']='Something Went Wrong';
            $output['data'] = $data;
            $output['error'] = "";
           }
         }
         
         return $output;
     }
     
     
     
            
            
    public function all_course (Request $request) {
        
        
            $count = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>251,'status'=>'ACTIVE'])->count();
            if ($count>0) {
            $product_arr = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>251,'status'=>'ACTIVE'])->get();
            foreach ($product_arr as $val) {
                $product_id = $val->id;
                $name = $val->name;
                $age = '7+';
                $slug = $val->slug;
                $iamge = $val->large_image;
                $description = $val->description;
                $mobile_app_image = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_image;
                $mobile_app_video = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_video;
                $short_description = $val->short_description;
                
                $price = DB::table('product_price')->where(['product_id'=>$product_id,'currency_id'=>1,'client_id'=>NULL,'product_item_id'=>NULL])->pluck('offer_local_price');
                
                
                $data[] = ['product_id'=>$product_id,'name'=>$name,'age_group'=>$age,'slug'=>$slug,'description'=>$description,'short_description'=>$short_description,
                'price'=>$price,'mobile_app_image'=>$mobile_app_image,'mobile_app_video'=>$mobile_app_video];
            }
            }
            
            
                
            $count1 = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>252,'status'=>'ACTIVE'])->count();
            if ($count1>0) {
            $product_arr = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>252,'status'=>'ACTIVE'])->get();
            foreach ($product_arr as $val) {
                $product_id = $val->id;
                $name = $val->name;
                $age = '10+';
                $slug = $val->slug;
                $iamge = $val->large_image;
                $description = $val->description;
                $mobile_app_image = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_image;
                $mobile_app_video = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_video;
                $short_description = $val->short_description;
                
                $price = DB::table('product_price')->where(['product_id'=>$product_id,'currency_id'=>1,'client_id'=>NULL,'product_item_id'=>NULL])->pluck('offer_local_price');
                

                
                $data[] = ['product_id'=>$product_id,'name'=>$name,'age_group'=>$age,'slug'=>$slug,'description'=>$description,'short_description'=>$short_description,
                'price'=>$price,'mobile_app_image'=>$mobile_app_image,'mobile_app_video'=>$mobile_app_video];
            }
            }
            
            
           
                
            $count2 = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>253,'status'=>'ACTIVE'])->count();
            if ($count2>0) {
            $product_arr = DB::table('product')->where(['display_in_mobile_app'=>1,'age_category_id'=>253,'status'=>'ACTIVE'])->get();
            foreach ($product_arr as $val) {
                $product_id = $val->id;
                $name = $val->name;
                $age = '13+';
                $slug = $val->slug;
                $iamge = $val->large_image;
                $description = $val->description;
                $mobile_app_image = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_image;
                $mobile_app_video = 'https://storage.googleapis.com/sproboticworks'.$val->mobile_app_video;
                $short_description = $val->short_description;
                
                $price = DB::table('product_price')->where(['product_id'=>$product_id,'currency_id'=>1,'client_id'=>NULL,'product_item_id'=>NULL])->pluck('offer_local_price');
                //$age_category = DB::table('product_categories')->where(['id'=>$age_category_id])->pluck('name');
               

                
                $data[] = ['product_id'=>$product_id,'name'=>$name,'age_group'=>$age,'slug'=>$slug,'description'=>$description,'short_description'=>$short_description,
                'price'=>$price,'mobile_app_image'=>$mobile_app_image,'mobile_app_video'=>$mobile_app_video];
            }
            }
            
            $output['response']=true;
            $output['message']='Datails';
            $output['data'] = $data;
            $output['error'] = "";
            
        return $output;
    }
    
    public function dashboard_video () {
        $data[] = 'https://storage.googleapis.com/sproboticworks/master/assets/videos/mobile-app/marketing/cnbc.mp4';
        $data[] = 'https://storage.googleapis.com/sproboticworks/master/assets/videos/mobile-app/marketing/forum-mall-app.mp4';
        $data[] = 'https://storage.googleapis.com/sproboticworks/master/assets/videos/mobile-app/marketing/micro-forest.mp4';
        $data[] = 'https://storage.googleapis.com/sproboticworks/master/assets/videos/mobile-app/marketing/ndtv.mp4';
        $data[] = 'https://storage.googleapis.com/sproboticworks/master/assets/videos/mobile-app/marketing/parents-testimonial.mp4';
        $data[] = 'https://storage.googleapis.com/sproboticworks/master/assets/videos/mobile-app/marketing/sparc2019.mp4';
    $output['response']=true;
    $output['message']='Video Data';
    $output['data'] = $data;
    $output['error'] = "";
            
    return $output;
    }
    
    public function firebase() {
        
        $apiKey = 'AAAA3O878CM:APA91bEJ5hPX6nw2hzQJTXilHoGYQX4EQkpazZKC5OoIhhgoL9zOEzDTpx7OxNqyvL32BzLeN6x9dVlNlxWB5l8DrasKBLblJiDMHBZavHzX1mO4tkOda3Uw1sXdJtL1l5bqSGeh9WGP';
        $token[] = array('crmRGWWURxi5j9O5dvPhUR:APA91bFb1sBHP0dnJVZFD0De86A-N3vrcF_sDXXTjZAlxZ6PV0Y6rHFukLWiu9muyhAdyKsF8lKtsHF0GeJ-WTtu3bXicJBg0aoAvNpxssDuU4Mw4YgT05irz16ENcmzJtI5dcVPekjG');
        foreach ($token as $token) {            
                            
                            
        $post = array(
					'to' => $token,
					'notification' => array (
							'title' => 'ABCD',
							'message' => 'EFGH',
							'time' => '12.12pm'
					)
				 );

		$headers = array( 
							'Authorization: key=' . $apiKey,
							'Content-Type: application/json'
						);
    
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');   
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);    
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'FCM error: ' . curl_error($ch);
		} else {
			echo "<br><div class='textOutput'>Push sent to all devices.</div>";
			echo "<br><a href='index.php'>Send New Push Notification</a>";
			echo $result;
		}
		curl_close($ch);                    
          
        }
                            				
        					
    }
    
    
    public function firebase1 () {
        $token = $_POST['token'];
        // Server key from Firebase Console
        define( 'API_ACCESS_KEY', 'AAAA1_noWZQ:APA91bFdsqyIErUcVb4LIdsNp3J1jmeNmGIR9HLNFsJ1WzVxCC1gcXO4_lF06u61P9xtrFJ1lH1M8e8uhnj4ikqvSY6RdEF4yp4EZj9mCZtgphjMr3MctMOEjiIthK0D0uee2zI7dg1bNCgauAhYCfesWSKN1-ZoTg' );
        $data = array("to" => $token,
        "notification" => array( "title" => "Shareurcodes.com", "body" => "A Code Sharing Blog!","icon" => "icon.png", "click_action" => "http://shareurcodes.com"));
        $data_string = json_encode($data);
        echo "The Json Data : ".$data_string;
        $headers = array ( 'Authorization: key=' . API_ACCESS_KEY, 'Content-Type: application/json' );
        $ch = curl_init(); curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string);
        $result = curl_exec($ch);
        curl_close ($ch);
        echo "<p>&nbsp;</p>";
        echo "The Result : ".$result;
    }
    
    public function city_state (Request $request) {
        
        
            
            $state_arr = DB::table('state')->where(['country_id'=>3,'status'=>'ACTIVE'])->get();
            foreach ($state_arr as $val_state) {
                   $state_id = $val_state->id;
                   $state_code = $val_state->code;
                   $state_name = $val_state->name;
                   $state_slug = $val_state->slug;
                   
                   $city_arr = DB::table('cities')->orderBy('name','ASC')->where(['state_id'=>$state_id,'country_id'=>3,'status'=>'ACTIVE'])->get();
                    foreach ($city_arr as $val_city) {
                        $city_id = $val_city->id;
                        $city_code = $val_city->code;
                        $city_name = $val_city->name;
                        $city_slug = $val_city->slug;
                   $data[] = ['city_id'=>$city_id,'city_code'=>$city_code,'city_name'=>$city_name,'state_id'=>$state_id,'state_code'=>$state_code,'state_name'=>$state_name];
            }
            
        }
        
        $output['response']=true;
        $output['message']='Data';
        $output['data'] = $data;
        $output['error'] = "";
        
        return $output;
    }
    
    public function city1 (Request $request) {
        
        
                   $city_arr = DB::table('cities')->orderBy('name','ASC')->where(['country_id'=>3,'status'=>'ACTIVE'])->get();
                    foreach ($city_arr as $val_city) {
                        $city_id = $val_city->id;
                        $city_code = $val_city->code;
                        $city_name = $val_city->name;
                        $city_slug = $val_city->slug;
                   $data[] = ['city_id'=>$city_id,'city_code'=>$city_code,'city_name'=>$city_name];
            
            
        }
        
        $output['response']=true;
        $output['message']='Data';
        $output['data'] = $data;
        $output['error'] = "";
        
        return $output;
    }
    
    
    public function timeslot(Request $request) {
        $day_name = $request->day_name;
        date_default_timezone_set('Asia/Kolkata');
        $day = date("l");
        $time = date('H:i');
       
       $todays_batch_group = DB::table('batch_groups')->where(['name'=>$day])->first();
       $todays_batch_group_id = $todays_batch_group->id;
       
        $batch_group_id = DB::table('batch_groups')->where(['name'=>$day_name])->first();
        $batch_group_id->id;
        $arr = DB::table('batches')->where(['group_id'=>$batch_group_id->id])->get();
        foreach ($arr as $val) {
            $batch_id = $val->id;
            $batch_group_id = $val->group_id;
            $batch_name = $val->name;
            $batch_label = $val->label;
            $batch_time_slot = $val->is_time_slot;
            if ($todays_batch_group_id == $batch_group_id) {
                 $batch_time = date("H:i", strtotime($batch_name)); 
                if ($batch_time<$time) {
                    $batch_time_slot=0;
                }
            }
            
            $data[] = ['batch_id'=>$batch_id,'batch_group_id'=>$batch_group_id,'batch_name'=>$batch_name,'batch_label'=>$batch_label,'batch_time_slot'=>$batch_time_slot];
        }
        
        $output['response']=true;
        $output['message']='Data';
        $output['data'] = $data;
        $output['error'] = "";
        
        return $output;
        
    }
    
    
    public function timeslot_update (Request $request) {
        $customer_id = $request->customer_id;
        $batch_id = $request->batch_id;
        $demo_time_slot_id = $request->demo_time_slot_id;
        $demo_slot_date = $request->demo_slot_date;
        $student_name = $request->student_name;
        $city_id = $request->city_id;
        $customer_contact_no = $request->customer_contact_no;
        $grade = $request->grade;
        $product_id = $request->product_id;
        
        $get = DB::table('customers')->where('id',$customer_id)->first();
        $demo_time_slot_id_exist = $get->demo_time_slot_id;
        $demo_slot_date_exist = $get->demo_slot_date;
        if ($demo_time_slot_id_exist!='') {
            DB::table('batches')->where('id',$demo_time_slot_id_exist)->update(['is_time_slot'=>1]);
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $update = DB::table('customers')->where('id',$customer_id)->update(['demo_time_slot_id'=>$batch_id,'demo_slot_date'=>$demo_slot_date,'grade'=>$grade,
        'student_name'=>$student_name,'city_id'=>$city_id,'student_contact_no'=>$customer_contact_no,'product_id'=>$product_id,'latest_product_id'=>$product_id]);
        
        if ($update===true || $update==1) {
            
            DB::table('batches')->where('id',$batch_id)->update(['is_time_slot'=>0]);
        
            $output['response']=true;
            $output['message']='Data Updated Successfully';
            $output['data'] = '';
            $output['error'] = "";

        } else {
            $output['response']=false;
            $output['message']='Something Wend Wrong';
            $output['data'] = '';
            $output['error'] = "Error";
            
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return $output;
        
    }
    
    
    public function fetch_data_book_demo (Request $request) {
        $customer_id = $request->customer_id;
        
        $data = [];
        $output = [];
          $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            //'product_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            $count = DB::table('customers')->where(['id'=>$customer_id])->count();
            if ($count>0) {
            
            $select = DB::table('customers')->where(['id'=>$customer_id])->first();
            $student_name = $select->student_name;
            $city_id = $select->city_id;
            $customer_contact_no = $select->customer_contact_no;
            $grade = $select->grade;
            if ($student_name==null) {
                $student_name='';
            }
            if ($city_id==null) {
                $city_id='';
            }
            if ($customer_contact_no==null) {
                $customer_contact_no='';
            }
            if ($grade==null) {
                $grade='';
            }
            
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = ['student_name'=>$student_name,'city_id'=>$city_id,'customer_contact_no'=>$customer_contact_no,'grade'=>$grade];
            $output['error'] = "";
            
            } else {
                $output['response']=false;
                $output['message']='No data found';
                $output['data'] = '';
                $output['error'] = "Error!"; 
            }
            
        }
        return $output;
    }
    
    
}
