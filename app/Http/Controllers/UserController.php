<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\LaraEmail;
use carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Tractor;
use App\Models\Rent_tractor;
use App\Models\Goods_vehicle;
use App\Models\Harvester;
use App\Models\Implement;
use App\Models\Seed;
use App\Models\Tyre;
use App\Models\pesticides;
use App\Models\fertilizers;

use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\Search as Search;
use App\Models\User as Userss;
use Image;
use App\Models\Subscription\Subscribed_boost;


class UserController extends Controller
{
    
    #Update promotional status
    public function updatePromotionalStatus(Request $request) {
        $output=[];
        $data=[];
        $userId = auth()->user()->id;
        $promotionalStatus = $request->promotional_status;

         $validator = Validator::make($request->all(), [
            'promotional_status' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $update = DB::table('user')->where('id',$userId)->update(['promotion_offers'=>$promotionalStatus]);
            if ($update) {
                $output['response']=true;
                $output['message']='Update Successfully';
                $output['data'] = $update;
                $output['error'] = "";
            } else {
                $output['response']=false;
                $output['message']='Something Went Wrong';
                $output['data'] = '';
                $output['error'] = "Database Error";
            }
        }
        return $output;
    }
}
