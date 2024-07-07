<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
use App\Models\Leads_view;

class Lead extends Model
{
    use HasFactory;
    protected $table = 'seller_leads';
    
     protected $fillable = [
        'user_id',
        'post_user_id',
        'category_id',
        'post_id',
        'calls_status',
        'messages_status',
        'sms',
        'created_at',
        'updated_at'
        ];
        
    protected function city_pincode($pincode) {
        $first = DB::table('city')->where(['pincode'=>$pincode])->first();
        
    }
        
        
    protected function leadfunction ($user_id,$category) {
        if ($category==1) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('tractor as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 1)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->count();
            
        } else if ($category==3) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('goods_vehicle as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 3)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->count();
            
        } else if ($category==4) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('harvester as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 4)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->count();
            
        } else if ($category==5) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('implements as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 5)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->count();
            
        } else if ($category==6) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('seeds as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 6)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->count();
            
        } else if ($category==7) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('tyres as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 7)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->count();
            
        } else if ($category==8) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('pesticides as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 8)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->count();
            
        } else if ($category==9) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('fertilizers as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id')
            ->where('s.category_id', 9)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->count();
        }
        
        
        return $response;
    }
    
    protected function enquiryfunction ($user_id,$category) {
        if ($category==1) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('tractor as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 1)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->count();
            
        }  else if ($category==3) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('goods_vehicle as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 3)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->count();
            
        } else if ($category==4) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('harvester as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 4)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->count();
            
        } else if ($category==5) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('implements as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 5)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->count();
            
        } else if ($category==6) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('seeds as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 6)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->count();
            
        } else if ($category==7) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('tyres as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 7)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->count();
            
        } else if ($category==8) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('pesticides as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 8)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->count();
            
        } else if ($category==9) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('fertilizers as t', 's.post_id', '=', 't.id')
            ->select('s.*', 's.id')
            ->where('s.category_id', 9)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->count();
            
        }
        return $response;
    }
    
    
    protected function leadfunction_get_array ($user_id,$category) {
        $data=[];
        
       if ($category==1) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('tractor as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id' , 's.user_id')
            ->where('s.category_id', 1)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->get();
           
           foreach ($response as $val) {
                $id = $val->id;
                $viewed_user_id = $val->user_id;
                $where = ['id'=>$id];
                $data[] = Tractor::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
        } 
        else if ($category==3) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('goods_vehicle as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.user_id')
            ->where('s.category_id', 3)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->get();
           
           foreach ($response as $val) {
                $id = $val->id;
                $viewed_user_id = $val->user_id;
                $where = ['id'=>$id];
                $data[] = Goods_vehicle::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
           
        } else if ($category == 4) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('harvester as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.user_id')
            ->where('s.category_id', 4)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->get();
            
            foreach ($response as $val) {
                $id = $val->id;
                $viewed_user_id = $val->user_id;
                $where = ['id'=>$id];
                $data[] = Harvester::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
            
        } else if ($category==5) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('implements as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.user_id')
            ->where('s.category_id', 5)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->get();
            
            foreach ($response as $val) {
                $id = $val->id;
                $viewed_user_id = $val->user_id;
                $where = ['id'=>$id];
                $data[] = Implement::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
        } else if ($category==6) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('seeds as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.user_id')
            ->where('s.category_id', 6)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->get();
            
            foreach ($response as $val) {
                $id = $val->id;
                $viewed_user_id = $val->user_id;
                $where = ['id'=>$id];
                $data[] = Seed::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
            
        } else if ($category==7) {
            
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('tyres as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.user_id')
            ->where('s.category_id', 7)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->get();
            
            foreach ($response as $val) {
                $id = $val->id;
                $viewed_user_id = $val->user_id;
                $where = ['id'=>$id];
                $data[] = Tyre::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
            
        } else if ($category==8) {
            
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('pesticides as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.user_id')
            ->where('s.category_id', 8)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->get();
            
            foreach ($response as $val) {
                $id = $val->id;
                $viewed_user_id = $val->user_id;
                $where = ['id'=>$id];
                $data[] = pesticides::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
            
        } else if ($category==9) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.post_user_id', '=', 'u.id')
            ->join('fertilizers as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.user_id')
            ->where('s.category_id', 9)
            ->where('s.post_user_id', $user_id)
            ->where('t.status', 1)->get();
            
            foreach ($response as $val) {
                $id = $val->id;
                $viewed_user_id = $val->user_id;
                $where = ['id'=>$id];
                $data[] = fertilizers::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
            
        }
         return $data;
    }
    
    
    protected function enquiryfunction_get_array ($user_id,$category) {
        $data=[];
        
       if ($category==1) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('tractor as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id','s.post_user_id')
            ->where('s.category_id', 1)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->get();
           
           foreach ($response as $val) {
                $id = $val->id;
                $where = ['id'=>$id];
                $viewed_user_id = $val->post_user_id;
                $data[] = Tractor::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
        } 
        else if ($category==3) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('goods_vehicle as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.post_user_id')
            ->where('s.category_id', 3)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->get();
           
           foreach ($response as $val) {
                $id = $val->id;
                $where = ['id'=>$id];
                $viewed_user_id = $val->post_user_id;
                $data[] = Goods_vehicle::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
           
        } else if ($category==4) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('harvester as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.post_user_id')
            ->where('s.category_id', 4)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->get();
            
            foreach ($response as $val) {
                $id = $val->id;
                $where = ['id'=>$id];
                $viewed_user_id = $val->post_user_id;
                $data[] = Harvester::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
            
        } else if ($category==5) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('implements as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.post_user_id')
            ->where('s.category_id', 5)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->get();
            
            foreach ($response as $val) {
                $id = $val->id;
                $where = ['id'=>$id];
                $viewed_user_id = $val->post_user_id;
                $data[] = Implement::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
        } else if ($category==6) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('seeds as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.post_user_id')
            ->where('s.category_id', 6)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->get();
            
            foreach ($response as $val) {
                $id = $val->id;
                $where = ['id'=>$id];
                $viewed_user_id = $val->post_user_id;
                $data[] = Seed::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
            
        } else if ($category==7) {
            
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('tyres as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.post_user_id')
            ->where('s.category_id', 7)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->get();
            
            foreach ($response as $val) {
                $id = $val->id;
                $where = ['id'=>$id];
                $viewed_user_id = $val->post_user_id;
                $data[] = Tyre::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
            
        } else if ($category==8) {
            
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('pesticides as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.post_user_id')
            ->where('s.category_id', 8)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->get();
            
            foreach ($response as $val) {
                $id = $val->id;
                $where = ['id'=>$id];
                $viewed_user_id = $val->post_user_id;
                $data[] = pesticides::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
            
        } else if ($category==9) {
            $response = DB::table('seller_leads as s')
            ->join('user as u', 's.user_id', '=', 'u.id')
            ->join('fertilizers as t', 's.post_id', '=', 't.id')
            ->select('t.*', 't.id', 's.post_user_id')
            ->where('s.category_id', 9)
            ->where('s.user_id', $user_id)
            ->where('t.status', 1)->get();
            
            foreach ($response as $val) {
                $id = $val->id;
                $where = ['id'=>$id];
                $viewed_user_id = $val->post_user_id;
                $data[] = fertilizers::get_notification_data_by_where1($where,$user_id,$viewed_user_id);
            }
            
        }
         return $data;
    }
    
    
}
