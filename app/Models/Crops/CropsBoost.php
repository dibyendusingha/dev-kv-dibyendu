<?php

namespace App\Models\Crops;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CropsBoost extends Model
{
    use HasFactory;

    protected function addCropBoost($crop_data){
        // dd($crop_data);
        $insert_crops = DB::table('crops_boosts')->insertGetId($crop_data);
        return true;
    }
    
    protected function cropBoostOtp($mobile){
       // dd($mobile);

       $user_mobile = $mobile;
       $rand = rand(1000, 9999);
       $sms_code = $rand . '.';
       $message = 'Your Krishi Vikas Udyog verification code is ' . $sms_code . ' Please enter it in the required space to process your sign-up. | Krishi Vikas';
       //$message = 'Your OTP for offline product boost on Krishi Vikas is ' . $sms_code . ' Please enter the OTP in the required space to process further.';
       $encoded_message = urlencode($message);
       
       $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number=' . $user_mobile . '&message=' . $encoded_message . '&format=json';
       
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_URL, $url);
       $res = curl_exec($ch);
       
       if(curl_errno($ch)){
           $error_message = curl_error($ch);
           // Handle the error appropriately, such as logging or returning an error response
           echo "Error: " . $error_message;
       } else {
           // Check the response from the API if needed
           $response = json_decode($res, true);
           // Process the response as required
           curl_close($ch);
       }

       session()->put('OTP', $rand);

       dd($res);

       return $res;
       
        
    }
}
