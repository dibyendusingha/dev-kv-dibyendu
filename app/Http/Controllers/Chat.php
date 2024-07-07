<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\LaraEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Tractor;
use App\Models\Rent_tractor;
use App\Models\Goods_vehicle;
use App\Models\Harvester;
use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\User as Userss;
use Image;

class Chat extends Controller
{
    //
    public function chat_send(Request $request) {
        $output=[];
        $data=[];
        $sender_id = $request->sender_id;
        $user_token = $request->user_token;
        $receiver_id = $request->receiver_id;
        $message = $request->message;
        $date = $request->date;
         $Autn = DB::table('user')->where(['id'=>$sender_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        } else {
            
        $insert = DB::table('chat')->insert([
            'sender_id'=>$sender_id,
            'receiver_id'=>$receiver_id,
            'chat_no'=>rand(1000,9999),
            'message'=>$message,
            'date'=>$date
            ]);
        
        if ($insert) {
            $output['response']=true;
            $output['message']='Message Send Successfully';
            $output['data'] = $insert;
            $output['error'] = "";
        } else {
            $output['response']=false;
            $output['message']='Message Failed';
            $output['data'] = $insert;
            $output['error'] = "";
        }
        return $output;
        
        }
    }
    
    
    public function chat_details(Request $request) {
        $output=[];
        $data=[];
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $person = $request->person; //opposite person id
        
         $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        } else {
            
        $count = DB::table('chat')->where(['sender_id'=>$person,'receiver_id'=>$user_id])->orwhere(['sender_id'=>$user_id,'receiver_id'=>$person])->count();  
        if ($count>0) {
            
        
        $select = DB::table('chat')->
        
        where(function($query) use ($person,$user_id){
                    $query->where('sender_id','=',$person)
                   ->Where('receiver_id','=',$user_id);
               })->orwhere(function($query) use ($person,$user_id){
                    $query->where('receiver_id','=',$person)
                   ->Where('sender_id','=',$user_id);
               })->orderBy('id','DESC')->get();
        foreach ($select as $val) {
            $id = $val->id;
            $sender_id = $val->sender_id;
            $sender = DB::table('user')->where(['id'=>$sender_id])->first();
            $receiver_id = $val->receiver_id;
            $receiver = DB::table('user')->where(['id'=>$receiver_id])->first();
            $chat_no = $val->chat_no;
            $message = $val->message;
            $date = $val->date;
            
            $data[] = ['id'=>$id,'sender_id'=>$sender_id,'sender_name'=>$sender->name,'receiver_id'=>$receiver_id,'receiver_name'=>$receiver->name,'chat_no'=>$chat_no,'message'=>$message,'date'=>$date];
            
        }
            $output['response']=true;
            $output['message']='Message';
            $output['data'] = $data;
            $output['error'] = "";
            
            
        
        } else {
            $output['response']=false;
            $output['message']='no Data Found';
            $output['data'] = $data;
            $output['error'] = "";
            
        }
        return $output;
    }
    }
    
    
    public function chat_list (Request $request) {
        $output=[];
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
        } else {
            $get_data = DB::table('chat')->groupBy('sender_id')->orwhere(['sender_id'=>$user_id])->orwhere(['receiver_id'=>$user_id])->get();
            foreach ($get_data as $val_data) {
                $sender_id = $val_data->sender_id;
                $date = $val_data->date;
                
                $data_chat = DB::table('user')->where(['id'=>$sender_id])->first();
                $name = $data_chat->name;
                $mobile = $data_chat->mobile;
                $data[] = ['sender_id'=>$sender_id,'name'=>$name,'mobile'=>$mobile,'date'=>$date];
                
            }
            
            $output['response']=true;
            $output['message']='Message List';
            $output['data'] = $data;
            $output['error'] = "";
            
        }
        return $output;
    }
    
    
    
}
