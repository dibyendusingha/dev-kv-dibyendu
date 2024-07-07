<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\LaraEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Api_model;
use App\Models\user;
use App\Models\Tractor;
use App\Models\Rent_tractor;
use App\Models\Goods_vehicle;
use App\Models\Harvester;
use App\Models\Implement;
use App\Models\Tyre;
use App\Models\Seed;
use App\Models\pesticides;
use App\Models\fertilizers;

use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\User as Userss;





class Leadapi extends Controller
{
    //
    
    public function lead_view (Request $request) {
        $output=[];
        $data=[];
        $user_id = $request->user_id;
        $post_user_id = $request->post_user_id;
        $category_id = $request->category_id;
        $post_id = $request->post_id;
        $user_token = $request->user_token;
        
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'post_user_id' => 'required',
            'category_id' => 'required',
            'post_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
          //App\Flight::create(['name' => 'Flight 10']);
          $count = Leads_view::where(['user_id'=>$user_id,'post_user_id'=>$post_user_id,'category_id'=>$category_id,'post_id'=>$post_id])->count();
          if ($count==0) {
              
           $data = Leads_view::create(['user_id'=>$user_id,'post_user_id'=>$post_user_id,'category_id'=>$category_id,'post_id'=>$post_id]);
           //echo $data;
           if ($data['id']>0) {
                $output['response']=true;
                $output['message']='Lead Generate Successfully';
                $output['data'] = $data;
                $output['error'] = "";
           }
           
           
          } else {
                $output['response']=false;
                $output['message']='Already Done';
                $output['data'] = '';
                $output['error'] = "";
          }
           //print_r($data);
           
        }
        return $output;
    }
    
    public function lead_generate (Request $request) {
        $output=[];
        $data=[];
        $user_id = $request->user_id;
        $post_user_id = $request->post_user_id;
        $category_id = $request->category_id;
        $post_id = $request->post_id;
        $calls_status = $request->calls_status;
        $messages_status = $request->messages_status;
        $sms = $request->sms;
        $user_token = $request->user_token;
        
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'post_user_id' => 'required',
            'category_id' => 'required',
            'post_id' => 'required',
            'calls_status' => 'required',
            'messages_status' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
          //App\Flight::create(['name' => 'Flight 10']);
          $count = Api_model::where(['user_id'=>$user_id,'post_user_id'=>$post_user_id,'category_id'=>$category_id,'post_id'=>$post_id])->count();
          if ($count==0) {
              
           $data = Api_model::create(['user_id'=>$user_id,'post_user_id'=>$post_user_id,'category_id'=>$category_id,'post_id'=>$post_id,'calls_status'=>$calls_status,
           'messages_status'=>$messages_status]);
           //echo $data;
           if ($data['id']>0) {
                $output['response']=true;
                $output['message']='Lead Generate Successfully';
                $output['data'] = $data;
                $output['error'] = "";
           }
           
           
          } else {
                $output['response']=false;
                $output['message']='Already Done';
                $output['data'] = '';
                $output['error'] = "";
          }
           //print_r($data);
           
        }
        return $output;
    }
    
    public function account_counter (Request $request) {
        $output = [];
        $data=[];
        
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            $tractor = DB::table('category')->where(['id'=>1])->first();
            //$rent_tractor = DB::table('category')->where(['id'=>2])->first();
            $gd = DB::table('category')->where(['id'=>3])->first();
            $harvestor = DB::table('category')->where(['id'=>4])->first();
            $implements = DB::table('category')->where(['id'=>5])->first();
            $seeds = DB::table('category')->where(['id'=>6])->first();
            $tyre = DB::table('category')->where(['id'=>7])->first();
            $pesticides = DB::table('category')->where(['id'=>8])->first();
            $fertilizers = DB::table('category')->where(['id'=>9])->first();
            
            $mypost1['category_id'] = 1;
            $mypost1['name'] = $tractor->category;
            $mypost1['ln_bn'] = $tractor->ln_bn;
            $mypost1['ln_hn'] = $tractor->ln_hn;
            $mypost1['count'] = Tractor::where(['user_id'=>$user_id])->count();
            $mypost1['image'] = asset("storage/images/category/".$tractor->icon);
            
            /*$mypost2['category_id'] = 2;
            $mypost2['name'] = $rent_tractor->category;
            $mypost2['count'] = Rent_tractor::where(['user_id'=>$user_id])->count();
            $mypost2['image'] = env('APP_URL')."storage/images/category/".$rent_tractor->icon;
            */
            $mypost3['category_id'] = 3;
            $mypost3['name'] = $gd->category;
            $mypost3['ln_bn'] = $gd->ln_bn;
            $mypost3['ln_hn'] = $gd->ln_hn;
            $mypost3['count'] = Goods_vehicle::where(['user_id'=>$user_id])->count();
            $mypost3['image'] = asset("storage/images/category/".$gd->icon);
            
            $mypost4['category_id'] = 4;
            $mypost4['name'] = $harvestor->category;
            $mypost4['ln_bn'] = $harvestor->ln_bn;
            $mypost4['ln_hn'] = $harvestor->ln_hn;
            $mypost4['count'] = Harvester::where(['user_id'=>$user_id])->count();
            $mypost4['image'] = asset("storage/images/category/".$harvestor->icon);
            
            $mypost5['category_id'] = 5;
            $mypost5['name'] = $implements->category;
            $mypost5['ln_bn'] = $implements->ln_bn;
            $mypost5['ln_hn'] = $implements->ln_hn;
            $mypost5['count'] = Implement::where(['user_id'=>$user_id])->count();
            $mypost5['image'] = asset("storage/images/category/".$implements->icon);
            
            $mypost6['category_id'] = 6;
            $mypost6['name'] = $seeds->category;
            $mypost6['ln_bn'] = $seeds->ln_bn;
            $mypost6['ln_hn'] = $seeds->ln_hn;
            $mypost6['count'] = Seed::where(['user_id'=>$user_id])->count();
            $mypost6['image'] = asset("storage/images/category/".$seeds->icon);
            
            $mypost7['category_id'] = 7;
            $mypost7['name'] = $tyre->category;
            $mypost7['ln_bn'] = $tyre->ln_bn;
            $mypost7['ln_hn'] = $tyre->ln_hn;
            $mypost7['count'] = Tyre::where(['user_id'=>$user_id])->count();
            $mypost7['image'] = asset("storage/images/category/".$tyre->icon);
            
            $mypost8['category_id'] = 8;
            $mypost8['name'] = $pesticides->category;
            $mypost8['ln_bn'] = $pesticides->ln_bn;
            $mypost8['ln_hn'] = $pesticides->ln_hn;
            $mypost8['count'] = pesticides::where(['user_id'=>$user_id])->count();
            $mypost8['image'] = asset("storage/images/category/".$pesticides->icon);
            
            $mypost9['category_id'] = 9;
            $mypost9['name'] = $fertilizers->category;
            $mypost9['ln_bn'] = $fertilizers->ln_bn;
            $mypost9['ln_hn'] = $fertilizers->ln_hn;
            $mypost9['count'] = fertilizers::where(['user_id'=>$user_id])->count();
            $mypost9['image'] = asset("storage/images/category/".$fertilizers->icon);
            
            $mypost[] = [$mypost1,$mypost3,$mypost4,$mypost5,$mypost6,$mypost7,$mypost8,$mypost9];
            
            $mylead1['category_id'] = 1;
            $mylead1['name'] = $tractor->category;
            $mylead1['ln_bn'] = $tractor->ln_bn;
            $mylead1['ln_hn'] = $tractor->ln_hn;
            $mylead1['count'] = 0;//Lead::leadfunction($user_id,'1');
            $mylead1['image'] = asset("storage/images/category/".$tractor->icon);
            
            /*$mylead2['category_id'] = 2;
            $mylead2['name'] = $rent_tractor->category;
            $mylead2['count'] = Lead::where(['post_user_id'=>$user_id,'category_id'=>2])->count();
            $mylead2['image'] = env('APP_URL')."storage/images/category/".$rent_tractor->icon;
            */
            $mylead3['category_id'] = 3;
            $mylead3['name'] = $gd->category;
            $mylead3['ln_bn'] = $gd->ln_bn;
            $mylead3['ln_hn'] = $gd->ln_hn;
            $mylead3['count'] = 0;//Lead::leadfunction($user_id,'3');
            $mylead3['image'] = asset("storage/images/category/".$gd->icon);
            
            $mylead4['category_id'] = 4;
            $mylead4['name'] = $harvestor->category;
            $mylead4['ln_bn'] = $harvestor->ln_bn;
            $mylead4['ln_hn'] = $harvestor->ln_hn;
            $mylead4['count'] = 0;//Lead::leadfunction($user_id,'4');
            $mylead4['image'] = asset("storage/images/category/".$harvestor->icon);
            
            $mylead5['category_id'] = 5;
            $mylead5['name'] = $implements->category;
            $mylead5['ln_bn'] = $implements->ln_bn;
            $mylead5['ln_hn'] = $implements->ln_hn;
            $mylead5['count'] = 0;//Lead::leadfunction($user_id,'5');
            $mylead5['image'] = asset("storage/images/category/".$implements->icon);
            
            $mylead6['category_id'] = 6;
            $mylead6['name'] = $seeds->category;
            $mylead6['ln_bn'] = $seeds->ln_bn;
            $mylead6['ln_hn'] = $seeds->ln_hn;
            $mylead6['count'] = 0;//Lead::leadfunction($user_id,'6');
            $mylead6['image'] = asset("storage/images/category/".$seeds->icon);
            
            $mylead7['category_id'] = 7;
            $mylead7['name'] = $tyre->category;
            $mylead7['ln_bn'] = $tyre->ln_bn;
            $mylead7['ln_hn'] = $tyre->ln_hn;
            $mylead7['count'] = 0;//Lead::leadfunction($user_id,'7');
            $mylead7['image'] = asset("storage/images/category/".$tyre->icon);
            
            $mylead8['category_id'] = 8;
            $mylead8['name'] = $pesticides->category;
            $mylead8['ln_bn'] = $pesticides->ln_bn;
            $mylead8['ln_hn'] = $pesticides->ln_hn;
            $mylead8['count'] = 0;//Lead::leadfunction($user_id,'8');
            $mylead8['image'] = asset("storage/images/category/".$pesticides->icon);
            
            $mylead9['category_id'] = 9;
            $mylead9['name'] = $fertilizers->category;
            $mylead9['ln_bn'] = $fertilizers->ln_bn;
            $mylead9['ln_hn'] = $fertilizers->ln_hn;
            $mylead9['count'] = 0;//Lead::leadfunction($user_id,'9');
            $mylead9['image'] = asset("storage/images/category/".$fertilizers->icon);
            
            $mylead[] = [$mylead1,$mylead3,$mylead4,$mylead5,$mylead6,$mylead7,$mylead8,$mylead9];
            
            $enquiry1['category_id'] = 1;
            $enquiry1['name'] = $tractor->category;
            $enquiry1['ln_bn'] = $tractor->ln_bn;
            $enquiry1['ln_hn'] = $tractor->ln_hn;
            $enquiry1['count'] = 0;//Lead::enquiryfunction($user_id,'1');
            $enquiry1['image'] = asset("storage/images/category/".$tractor->icon);
            
            /*$enquiry2['category_id'] = 2;
            $enquiry2['name'] = $rent_tractor->category;
            $enquiry2['count'] = Lead::where(['user_id'=>$user_id,'category_id'=>2])->count();
            $enquiry2['image'] = env('APP_URL')."storage/images/category/".$rent_tractor->icon;
            */
            $enquiry3['category_id'] = 3;
            $enquiry3['name'] = $gd->category;
            $enquiry3['ln_bn'] = $gd->ln_bn;
            $enquiry3['ln_hn'] = $gd->ln_hn;
            $enquiry3['count'] = 0;//Lead::enquiryfunction($user_id,'3');
            $enquiry3['image'] = asset("storage/images/category/".$gd->icon);
            
            $enquiry4['category_id'] = 4;
            $enquiry4['name'] = $harvestor->category;
            $enquiry4['ln_bn'] = $harvestor->ln_bn;
            $enquiry4['ln_hn'] = $harvestor->ln_hn;
            $enquiry4['count'] =  0;//Lead::enquiryfunction($user_id,'4');
            $enquiry4['image'] = asset("storage/images/category/".$harvestor->icon);
            
            $enquiry5['category_id'] = 5;
            $enquiry5['name'] = $implements->category;
            $enquiry5['ln_bn'] = $implements->ln_bn;
            $enquiry5['ln_hn'] = $implements->ln_hn;
            $enquiry5['count'] =  0;//Lead::enquiryfunction($user_id,'5');
            $enquiry5['image'] = asset("storage/images/category/".$implements->icon);
            
            $enquiry6['category_id'] = 6;
            $enquiry6['name'] = $seeds->category;
            $enquiry6['ln_bn'] = $seeds->ln_bn;
            $enquiry6['ln_hn'] = $seeds->ln_hn;
            $enquiry6['count'] = 0;// Lead::enquiryfunction($user_id,'6');
            $enquiry6['image'] = asset("storage/images/category/".$seeds->icon);
            
            $enquiry7['category_id'] = 7;
            $enquiry7['name'] = $tyre->category;
            $enquiry7['ln_bn'] = $tyre->ln_bn;
            $enquiry7['ln_hn'] = $tyre->ln_hn;
            $enquiry7['count'] =  0;//Lead::enquiryfunction($user_id,'7');
            $enquiry7['image'] = asset("storage/images/category/".$tyre->icon);
            
            $enquiry8['category_id'] = 8;
            $enquiry8['name'] = $pesticides->category;
            $enquiry8['ln_bn'] = $pesticides->ln_bn;
            $enquiry8['ln_hn'] = $pesticides->ln_hn;
            $enquiry8['count'] =  0;//Lead::enquiryfunction($user_id,'8');
            $enquiry8['image'] = asset("storage/images/category/".$pesticides->icon);
            
            $enquiry9['category_id'] = 9;
            $enquiry9['name'] = $fertilizers->category;
            $enquiry9['ln_bn'] = $fertilizers->ln_bn;
            $enquiry9['ln_hn'] = $fertilizers->ln_hn;
            $enquiry9['count'] =  0;//Lead::enquiryfunction($user_id,'9');
            $enquiry9['image'] = asset("storage/images/category/".$fertilizers->icon);
            
            $enquiry[] = [$enquiry1,$enquiry3,$enquiry4,$enquiry5,$enquiry6,$enquiry7,$enquiry8,$enquiry9];
            
            $new[] = ['mypost'=>$mypost,'mylead'=>$mylead,'enquiry'=>$enquiry];
            
                $output['response']=true;
                $output['message']='Account counter';
                $output['data'] = $new;
                $output['error'] = "";
        }
        return $output;
    }
    
    
    public function my_post (Request $request) {
        $output = [];
        $data = [];
        $new=[];
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $user_token = $request->user_token;
        
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            /*$tractor_data =  Tractor::where(['user_id'=>$user_id])->get();
            foreach ($tractor_data as $val) {
                
            }*/
            $where = ['user_id'=>$user_id];
            
            if ($category_id==1) {
            $count = Tractor::where($where)->count();
            if ($count>0) {
            $new = Tractor::get_data_by_where($where);
            
                $output['response']=true;
                $output['message']='Data Found';
                $output['data'] = $new;
                $output['error'] = "";
                
            } else {
                $output['response']=false;
                $output['message']='No Data Found';
                $output['data'] = '';
                $output['error'] = "";
            }
            
            }
            
            /*if ($category_id==2) {
            $count = Rent_tractor::where($where)->count();
            if ($count>0) {
            $new = Rent_tractor::get_data_by_where($where);
            
                $output['response']=true;
                $output['message']='Data Found';
                $output['data'] = $new;
                $output['error'] = "";
                
            } else {
                $output['response']=false;
                $output['message']='No Data Found';
                $output['data'] = '';
                $output['error'] = "";
            }
            
            }*/
            
            if ($category_id==3) {
            $count = Goods_vehicle::where($where)->count();
            if ($count>0) {
            $new = Goods_vehicle::get_data_by_where($where);
            
                $output['response']=true;
                $output['message']='Data Found';
                $output['data'] = $new;
                $output['error'] = "";
                
            } else {
                $output['response']=false;
                $output['message']='No Data Found';
                $output['data'] = '';
                $output['error'] = "";
            }
            
            }
            
            if ($category_id==4) {
            $count = Harvester::where($where)->count();
            if ($count>0) {
            $new = Harvester::get_data_by_where($where);
            
                $output['response']=true;
                $output['message']='Data Found';
                $output['data'] = $new;
                $output['error'] = "";
                
            } else {
                $output['response']=false;
                $output['message']='No Data Found';
                $output['data'] = '';
                $output['error'] = "";
            }
            
            }
            
            if ($category_id==5) {
            $count = Implement::where($where)->count();
            if ($count>0) {
            $new = Implement::get_data_by_where($where);
            
                $output['response']=true;
                $output['message']='Data Found';
                $output['data'] = $new;
                $output['error'] = "";
                
            } else {
                $output['response']=false;
                $output['message']='No Data Found';
                $output['data'] = '';
                $output['error'] = "";
            }
            
            }
            
            if ($category_id==6) {
            $count = Seed::where($where)->count();
            if ($count>0) {
            $new = Seed::get_data_by_where($where);
            
                $output['response']=true;
                $output['message']='Data Found';
                $output['data'] = $new;
                $output['error'] = "";
                
            } else {
                $output['response']=false;
                $output['message']='No Data Found';
                $output['data'] = '';
                $output['error'] = "";
            }
            
            }
            
            if ($category_id==7) {
            $count = Tyre::where($where)->count();
            if ($count>0) {
            $new = Tyre::get_data_by_where($where);
            
                $output['response']=true;
                $output['message']='Data Found';
                $output['data'] = $new;
                $output['error'] = "";
                
            } else {
                $output['response']=false;
                $output['message']='No Data Found';
                $output['data'] = '';
                $output['error'] = "";
            }
            
            }
            
            if ($category_id==8) {
            $count = pesticides::where($where)->count();
            if ($count>0) {
            $new = pesticides::get_data_by_where($where);
            
                $output['response']=true;
                $output['message']='Data Found';
                $output['data'] = $new;
                $output['error'] = "";
                
            } else {
                $output['response']=false;
                $output['message']='No Data Found';
                $output['data'] = '';
                $output['error'] = "";
            }
            
            }
            
            if ($category_id==9) {
            $count = fertilizers::where($where)->count();
            if ($count>0) {
            $new = fertilizers::get_data_by_where($where);
            
                $output['response']=true;
                $output['message']='Data Found';
                $output['data'] = $new;
                $output['error'] = "";
                
            } else {
                $output['response']=false;
                $output['message']='No Data Found';
                $output['data'] = '';
                $output['error'] = "";
            }
            
            }
            
            /*else {
                $output['response']=false;
                $output['message']='Category Mistmatch';
                $output['data'] = '';
                $output['error'] = "";
            }*/
            
        }
        
        return $output;
    }
    
    public function my_lead (Request $request) {
        $output = [];
        $data=[];
        $count=0;
        $new=[];
        
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $user_token = $request->user_token;
        
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
         
         
         if ($category_id==1) {
         //$count = Lead::leadfunction($user_id,$category_id);
         if ($count>0) {
         /*$gat_data = Lead::orderBy('id','desc')->where(['post_user_id'=>$user_id,'category_id'=>$category_id])->get();
         foreach ($gat_data as $val_l) {
            $user_id_db = $val_l->user_id;
            $category_id = $val_l->category_id;
            $post_id = $val_l->post_id;
            $calls_status = $val_l->calls_status;
            $messages_status = $val_l->messages_status;
             
            $where = ['id'=>$post_id];
            $new[] = Tractor::get_notification_data_by_where($where,$user_id_db);
            
           
         }*/
         
          //$new = Lead::leadfunction_get_array($user_id,$category_id);
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         /*if ($category_id==2) {
         $count = Lead::where(['post_user_id'=>$user_id,'category_id'=>$category_id])->count();
         if ($count>0) {
         $gat_data = Lead::orderBy('id','desc')->where(['post_user_id'=>$user_id,'category_id'=>$category_id])->get();
         foreach ($gat_data as $val_l) {
            $user_id_db = $val_l->user_id;
            $category_id = $val_l->category_id;
            $post_id = $val_l->post_id;
            $calls_status = $val_l->calls_status;
            $messages_status = $val_l->messages_status;
             
            $where = ['id'=>$post_id];
            $new[] = Rent_tractor::get_notification_data_by_where($where,$user_id_db);
         }
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }*/
         
         else if ($category_id==3) {
         //$count = Lead::leadfunction($user_id,$category_id);
         if ($count>0) {
         
         //$new = Lead::leadfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         else if ($category_id==4) {
         //$count = Lead::leadfunction($user_id,$category_id);
         if ($count>0) {
         
         //$new = Lead::leadfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         else if ($category_id==5) {
         //$count = Lead::leadfunction($user_id,$category_id);
         if ($count>0) {
         
         //$new = Lead::leadfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         else if ($category_id==6) {
         //$count = Lead::leadfunction($user_id,$category_id);
         if ($count>0) {
         
         //$new = Lead::leadfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         else if ($category_id==7) {
         //$count = Lead::leadfunction($user_id,$category_id);
         if ($count>0) {
         
         //$new = Lead::leadfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         else if ($category_id==8) {
         //$count = Lead::leadfunction($user_id,$category_id);
         if ($count>0) {
         
         //$new = Lead::leadfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         else if ($category_id==9) {
         //$count = Lead::leadfunction($user_id,$category_id);
         if ($count>0) {
         
          //$new = Lead::leadfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
        }
        
        return $output;
    }
    
    public function my_enquery (Request $request) {
        
        $output = [];
        $data=[];
        $new =[];
        $count=0;
        
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $user_token = $request->user_token;
        
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
         
         
         if ($category_id==1) {
         //$count = Lead::enquiryfunction($user_id,$category_id);
         if ($count>0) {
         /*$gat_data = Lead::orderBy('id','desc')->where(['user_id'=>$user_id,'category_id'=>$category_id])->get();
         foreach ($gat_data as $val_l) {
            $user_id_db = $val_l->post_user_id;
            $category_id = $val_l->category_id;
            $post_id = $val_l->post_id;
            $calls_status = $val_l->calls_status;
            $messages_status = $val_l->messages_status;
             
            
            
            $where = ['id'=>$post_id];
            $new[] = Tractor::get_notification_data_by_where($where,$user_id);
         }*/
          //$new = Lead::enquiryfunction_get_array($user_id,$category_id);
         
      
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         
         else if ($category_id==3) {
         //$count = Lead::enquiryfunction($user_id,$category_id);
         if ($count>0) {
          //$new = Lead::enquiryfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         else if ($category_id==4) {
         //$count = Lead::enquiryfunction($user_id,$category_id);
         if ($count>0) {
          //$new = Lead::enquiryfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         else if ($category_id==5) {
         //$count = Lead::enquiryfunction($user_id,$category_id);
         if ($count>0) {
          //$new = Lead::enquiryfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         else if ($category_id==6) {
         //$count = Lead::enquiryfunction($user_id,$category_id);
         if ($count>0) {
         //$new = Lead::enquiryfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         else if ($category_id==7) {
         //$count = Lead::enquiryfunction($user_id,$category_id);
         if ($count>0) {
          //$new = Lead::enquiryfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         else if ($category_id==8) {
        //$count = Lead::enquiryfunction($user_id,$category_id);
         if ($count>0) {
          //$new = Lead::enquiryfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
         else if ($category_id==9) {
         //$count = Lead::enquiryfunction($user_id,$category_id);
         if ($count>0) {
          //$new = Lead::enquiryfunction_get_array($user_id,$category_id);
         
            $output['response']=true;
            $output['message']='Leads Found';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         } else {
            $output['response']=false;
            $output['message']='No Leads Found';
            $output['data'] = '';
            $output['error'] = "";
         }
         }
         
        }
        
        return $output;
    
    }
    
    public function notification (Request $request) {
        $output = [];
        $data=[];
        $new=[];
        
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $user_token = $request->user_token;
        
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $count = Lead::where(['post_user_id'=>$user_id])->count();
            if ($count>0) {
            $lead_arr = Lead::orderBy('id','desc')->where(['post_user_id'=>$user_id])->get();
            foreach ($lead_arr as $val_lead) {
                $id = $val_lead->id;
                $user_id_db = $val_lead->user_id;
                $post_user_id = $val_lead->post_user_id;
                $category_id = $val_lead->category_id;
                $post_id = $val_lead->post_id;
                
                
                if ($category_id==1) {
                $where = ['id'=>$post_id];
                $data = Tractor::get_notification_data_by_where($where,$user_id_db);
                } 
                
                /*if ($category_id==2) {
                $where = ['id'=>$post_id];
                $data = Rent_tractor::get_notification_data_by_where($where,$user_id_db);    
                } */
                
                if ($category_id==3) {
                $where = ['id'=>$post_id];
                $data = Goods_vehicle::get_notification_data_by_where($where,$user_id_db);    
                }
                
                if ($category_id==4) {
                $where = ['id'=>$post_id];
                $data = Harvester::get_notification_data_by_where($where,$user_id_db);    
                }
                
                if ($category_id==5) {
                $where = ['id'=>$post_id];
                $data = Implement::get_notification_data_by_where($where,$user_id_db);    
                }
                
                if ($category_id==6) {
                $where = ['id'=>$post_id];
                $data = Seed::get_notification_data_by_where($where,$user_id_db);    
                }
                
                if ($category_id==7) {
                $where = ['id'=>$post_id];
                $data = Tyre::get_notification_data_by_where($where,$user_id_db);    
                }
                
                if ($category_id==8) {
                $where = ['id'=>$post_id];
                $data = pesticides::get_notification_data_by_where($where,$user_id_db);    
                }
                
                if ($category_id==9) {
                $where = ['id'=>$post_id];
                $data = fertilizers::get_notification_data_by_where($where,$user_id_db);    
                }
                
                
                $new[] = $data;
            }
                $output['response']=true;
                $output['message']='Notification Found';
                $output['data'] = $new;
                $output['error'] = "";
            
            } else {
                $output['response']=false;
                $output['message']='No Notification Found';
                $output['data'] = '';
                $output['error'] = "";
            }
            
        }
        return $output;
    }
    
    
    public function tractor_filter (Request $request) {
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $set = $request->set;
        $type = $request->type;
        $state = $request->state;
        $district = $request->district;
        $brand = $request->brand;
        $model = $request->model;
        $purchase_year = $request->purchase_year;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        
        //$price_filter = $request->price_filter;
        //$order_filter = $request->order_filter;
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
      
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            
            $where_type = $type;
            $where_state = $state;
            $where_district = $district;
            $where_brand = $brand;
            $where_model = $model;
            $purchase = $purchase_year;
            //print_r($where_district);
            $data = Tractor::get_filter_data_by_where($user_id,$set,$type,$where_type,$where_state,$where_district,$where_brand,$where_model,$purchase,$price_start,$price_end,$skip,$take);
            //$data['count'] = count($data);
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    }
    
    public function rent_tractor_filter (Request $request) {
        $output = [];
        $data=[];
        $new=[];
        
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $set = $request->set;
        $type = $request->type;
        $state = $request->state;
        $district[] = $request->district;
        $brand[] = $request->brand;
        $model[] = $request->model;
        $purchase_year[] = $request->purchase_year;
        $price[] = $request->price;
        $skip = $request->skip;
        $take = $request->take;
        
        $price_filter = $request->price_filter;
        $order_filter = $request->order_filter;
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
      
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $where_type = ['type'=>$type];
            $where_state = ['state_id'=>$state];
            $where_district = $district;
            $where_brand = $brand;
            $where_model = $model;
            $purchase = $purchase_year;
            $price = $price;
            //print_r($where_district);
            $data = Rent_tractor::get_filter_data_by_where($user_id,$set,$where_type,$where_state,$where_district,$where_brand,$where_model,$purchase,$price,$skip,$take,$price_filter,$order_filter);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    }
    
    public function goods_vehicle_filter (Request $request) {
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $set = $request->set;
        $type = $request->type;
        $state = $request->state;
        $district = $request->district;
        $brand = $request->brand;
        $model = $request->model;
        $purchase_year = $request->purchase_year;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        
        //$price_filter = $request->price_filter;
        //$order_filter = $request->order_filter;
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
      
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $where_type = $type;
            $where_state = $state;
            $where_district = $district;
            $where_brand = $brand;
            $where_model = $model;
            $purchase = $purchase_year;
            //print_r($where_district);
            $data = Goods_vehicle::get_filter_data_by_where($user_id,$set,$type,$where_type,$where_state,$where_district,$where_brand,$where_model,$purchase,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    }
    
    public function harvester_filter (Request $request) {
        
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $set = $request->set;
        $type = $request->type;
        $state = $request->state;
        $district = $request->district;
        $brand = $request->brand;
        $model = $request->model;
        $purchase_year = $request->purchase_year;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        //$price_filter = $request->price_filter;
        //$order_filter = $request->order_filter;
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
      
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $where_type = $type;
            $where_state = $state;
            $where_district = $district;
            $where_brand = $brand;
            $where_model = $model;
            $purchase = $purchase_year;
            //print_r($where_district);
            $data = Harvester::get_filter_data_by_where($user_id,$set,$type,$where_type,$where_state,$where_district,$where_brand,$where_model,$purchase,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    
    }
    
    public function implements_filter (Request $request) {
        
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $set = $request->set;
        $type = $request->type;
        $state = $request->state;
        $district = $request->district;
        $brand = $request->brand;
        $model = $request->model;
        $purchase_year = $request->purchase_year;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        
        //$price_filter = $request->price_filter;
        //$order_filter = $request->order_filter;
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
      
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $where_type = $type;
            $where_state = $state;
            $where_district = $district;
            $where_brand = $brand;
            $where_model = $model;
            $purchase = $purchase_year;
            //print_r($where_district);
            $data = Implement::get_filter_data_by_where($user_id,$set,$type,$where_type,$where_state,$where_district,$where_brand,$where_model,$purchase,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    
    }
    
    public function tyre_filter (Request $request) {
        
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $type = $request->type;
        $state = $request->state;
        $district = $request->district;
        $brand = $request->brand;
        $model = $request->model;
        //$purchase_year = $request->purchase_year;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        
        //$price_filter = $request->price_filter;
        //$order_filter = $request->order_filter;
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
      
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $where_type = $type;
            $where_state = $state;
            $where_district = $district;
            $where_brand = $brand;
            $where_model = $model;
            //$purchase = $purchase_year;
            //print_r($where_district);
            $data = Tyre::get_filter_data_by_where($user_id,$type,$where_type,$where_state,$where_district,$where_brand,$where_model,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    
    }
    
    public function seed_filter (Request $request) {
        
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $state = $request->state;
        $district = $request->district;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
      
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $where_state = $state;
            $where_district = $district;
            //print_r($where_district);
            $data = Seed::get_filter_data_by_where($user_id,$where_state,$where_district,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    
    }
    
    public function pesticides_filter (Request $request) {
        
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $state = $request->state;
        $district = $request->district;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
      
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $where_state = $state;
            $where_district = $district;
            //print_r($where_district);
            $data = pesticides::get_filter_data_by_where($user_id,$where_state,$where_district,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    
    }
    
    public function fertilizers_filter (Request $request) {
        
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $state = $request->state;
        $district = $request->district;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
      
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $where_state = $state;
            $where_district = $district;
            //print_r($where_district);
            $data = fertilizers::get_filter_data_by_where($user_id,$where_state,$where_district,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    
    }
    
    
}
