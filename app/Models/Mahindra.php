<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Mahindra extends Model
{
    use HasFactory;

    protected function get_all_tractor(){
        $all_tractor = DB::table('tractorView')->where(['status'=>1])->get();
        // foreach($all_tractor as $tractor){
        //     #left_image
        //     if($tractor->left_image){
        //         $left_image = asset("storage/tractor/".$tractor->left_image);
        //     }else{
        //         $left_image = "null";
        //     }

        //     # right_image
        //     if($tractor->right_image){
        //         $right_image = asset("storage/tractor/".$tractor->right_image);
        //     }else{
        //         $right_image = "null";
        //     }

        //     # front_image
        //     if($tractor->front_image){
        //         $front_image = asset("storage/tractor/".$tractor->front_image);
        //     }else{
        //         $front_image = "null";
        //     }

        //     # back_image
        //     if($tractor->back_image){
        //         $back_image = asset("storage/tractor/".$tractor->back_image);
        //     }else{
        //         $back_image = "null";
        //     }

        //     # meter_image
        //     if($tractor->meter_image){
        //         $meter_image = asset("storage/tractor/".$tractor->meter_image);
        //     }else{
        //         $meter_image = "null";
        //     }

        // }
        return $all_tractor;
    }
}
