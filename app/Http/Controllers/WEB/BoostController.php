<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Subscription\Subscription;
use App\Models\Subscription\Subscribed_boost;
use Illuminate\Support\Facades\Validator;
use Redirect;
use DateTime;
USE App\Models\sms;

class BoostController extends Controller
{

    public function boostInvoice($id)
    {
        //dd($id);
        $subscribed_boosts_id = DB::table('subscribed_boosts')->where('product_id', $id)->orderBy('id', 'desc')->first()->id;
        // dd($subscribed_boosts_id);
        $boost_details = DB::table('subscribed_boosts as sb')
            ->select(
                'u.name',
                'u.address',
                'u.zipcode',
                's.state_name',
                'd.district_name',
                'c.city_name',
                'sb.invoice_no',
                'sb.gst',
                'sb.sgst',
                'sb.cgst',
                'sb.igst',
                'sb.purchased_price',
                'sb.price',
                'sb.start_date',
                'sb.end_date',
                'sb.end_date'
            )
            ->leftJoin('user as u', 'u.id', '=', 'sb.user_id')
            ->leftJoin('state as s', 's.id', '=', 'u.state_id')
            ->leftJoin('district as d', 'd.id', '=', 'u.district_id')
            ->leftJoin('city as c', 'c.id', '=', 'u.city_id')
            ->where('sb.id', $subscribed_boosts_id)
            ->first();

        //dd($boost_details);

        $timeString = $boost_details->start_date;
        //dd($timeString);
        $time = new DateTime($timeString);
        $start_time = $time->format('g:i A');
        $start_date = $time->format('j F Y');

        $dateString = $boost_details->end_date;
        $date = new DateTime($dateString);
        $end_date = $date->format('j F Y');

        return view('admin.offline_invoice', ['start_date' => $start_date, 'start_time' => $start_time, 'end_date' => $end_date, 'boost_details' => $boost_details]);
    }
    public function boostPaymentForm($category_name, $post_id)
    {
        // dd($category_name);
        if ($category_name == "tractor") {
            $product = DB::table('tractorView as t')
                ->select('t.id', 't.brand_name', 'u.name',)
                ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                ->where('t.id', $post_id)
                ->first();
        }
        if ($category_name == "gv") {
            $product = DB::table('goodVehicleView as t')
                ->select('t.id', 't.brand_name', 'u.name',)
                ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                ->where('t.id', $post_id)
                ->first();
        }
        if ($category_name == "harvester") {
            $product = DB::table('harvesterView as t')
                ->select('t.id', 't.brand_name', 'u.name',)
                ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                ->where('t.id', $post_id)
                ->first();
        }
        if ($category_name == "implements") {
            $product = DB::table('implementView as t')
                ->select('t.id', 't.brand_name', 'u.name',)
                ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                ->where('t.id', $post_id)
                ->first();
        }
        if ($category_name == "seed") {
            $product = DB::table('seedView as t')
                ->select('t.id', 't.title as brand_name', 'u.name',)
                ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                ->where('t.id', $post_id)
                ->first();
        }
        if ($category_name == "tyre") {
            $product = DB::table('tyresView as t')
                ->select('t.id', 't.brand_name', 'u.name',)
                ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                ->where('t.id', $post_id)
                ->first();
        }
        if ($category_name == "seed") {
            $product = DB::table('seedView as t')
                ->select('t.id', 't.title as brand_name', 'u.name',)
                ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                ->where('t.id', $post_id)
                ->first();
        }
        if ($category_name == "fertilizer") {
            $product = DB::table('fertilizerView as t')
                ->select('t.id', 't.title as brand_name', 'u.name',)
                ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                ->where('t.id', $post_id)
                ->first();
        }
        if ($category_name == "pesticides") {
            $product = DB::table('pesticidesView as t')
                ->select('t.id', 't.title as brand_name', 'u.name',)
                ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                ->where('t.id', $post_id)
                ->first();
        }

        $market_user = DB::table('user')->where('market_status',1)->get();

        return view('admin.boost_form', ['market_user' => $market_user, 'product' => $product]);
    }
    public function boostPayment(Request $request, $category_name, $product_id)
    {
        $otpData = $request->first . $request->second . $request->third . $request->forth;
        //dd($otpData);
        //dd($request->all());
        $otp = session()->get('OTP');
        $sentOtp = strval($otp);
        //dd($sentOtp);

        if ($sentOtp == $otpData) {

            if ($category_name == 'tractor') {
                $category_id = 1;
                $user_id = DB::table('tractorView as t')->where('t.id', $product_id)->first()->user_id;
            } else if ($category_name == 'gv') {
                $category_id = 3;
                $user_id = DB::table('goodVehicleView as t')->where('t.id', $product_id)->first()->user_id;
            } else if ($category_name == 'harvester') {
                $category_id = 4;
                $user_id = DB::table('harvesterView as t')->where('t.id', $product_id)->first()->user_id;
            } else if ($category_name == 'implements') {
                $category_id = 5;
                $user_id = DB::table('implementView as t')->where('t.id', $product_id)->first()->user_id;
            } else if ($category_name == 'seed') {
                $category_id = 6;
                $user_id = DB::table('seedView as t')->where('t.id', $product_id)->first()->user_id;
            } else if ($category_name == 'tyre') {
                $category_id = 7;
                $user_id = DB::table('tyresView as t')->where('t.id', $product_id)->first()->user_id;
            } else if ($category_name == 'fertilizer') {
                $category_id = 9;
                $user_id = DB::table('fertilizerView as t')->where('t.id', $product_id)->first()->user_id;
            } else if ($category_name == 'pesticides') {
                $category_id = 8;
                $user_id = DB::table('pesticidesView as t')->where('t.id', $product_id)->first()->user_id;
            }

            $subscription_boosts_id  = $request->subscription_boosts_id;
            $purchased_price         = $request->purchased_price;
            $tax                     = $request->tax;
            $market_user_id          = $request->market_user_id;

            if (!empty($request->transaction_id) || $request->transaction_id != null) {
                $transaction_id  = $request->transaction_id;
            } else {
                $transaction_id  = null;
            }
            //dd($transaction_id);



            if (!empty($request->days)) {
                $days = $request->days;

                $date1 =  Carbon::now();
                $start_date = date("Y-m-d H:i:s", strtotime($date1));

                $futureDate = $date1->addDays($days);
                $date2      = $futureDate->format('Y-m-d H:i:s');
                $end_date   = date("Y-m-d H:i:s", strtotime($date2));
            }

            if (!empty($request->tax)) {
                if ($request->tax == "gst") {
                    $gst = ($purchased_price * 18) / 100;
                    $price = ($purchased_price - $gst);
                } else if ($request->tax == "cgst") {
                    $sgst = ($purchased_price * 9) / 100;
                    $cgst = ($purchased_price * 9) / 100;

                    $total = ($sgst + $cgst);
                    $price = ($purchased_price - $total);
                }
            }


            $financialYear = Subscription::getFinancialYear($start_date, "y"); //21-22 

            $getId = 0;
            $getId = DB::select("SELECT 
    LPAD(
        MAX(
            CAST(
                SUBSTRING(invoice_no, LENGTH('AECPL/') + 1) AS UNSIGNED
            )
        ),
        LENGTH(MAX(CAST(SUBSTRING(invoice_no, LENGTH('AECPL/') + 1) AS UNSIGNED))), '0'
    ) AS max_invoice_number
        FROM (
            SELECT invoice_no FROM subscribed_boosts
            UNION ALL
            SELECT invoice_no FROM subscribeds
            -- UNION ALL
            -- SELECT invoice_no FROM crops_subscribed
        ) AS combined_tables");

            $invoiceId = $getId[0]->max_invoice_number + 1; #new id for Invoice

            try {
                DB::beginTransaction();

                $boost = new Subscribed_boost;

                $boost->subscription_boosts_id         = $subscription_boosts_id;
                $boost->offlice_plane                  = 'Trial 99';
                $boost->user_id                        = $user_id;
                $boost->category_id                    = $category_id;
                $boost->product_id                     = $product_id;
                $boost->price                          = $price;
                $boost->start_date                     = $start_date;
                $boost->end_date                       = $end_date;
                $boost->purchased_price                = $purchased_price;
                $boost->transaction_id                 = $transaction_id;
                $boost->status                         = 1;
                $boost->invoice_no                     = "AECPL/" . str_pad($invoiceId, 5, "0", STR_PAD_LEFT) . "/" . $financialYear;
                $boost->market_user_id                 = $market_user_id;

                if ($request->tax == "gst") {
                    $boost->gst   = $gst;
                    $boost->sgst  = 0.00;
                    $boost->cgst  = 0.00;
                    $boost->igst  = 0.00;
                } else {
                    $boost->gst   = 0.00;
                    $boost->sgst  = $sgst;
                    $boost->cgst  = $cgst;
                    $boost->igst  = 0.00;
                }

                // dd($boost);

                $boost->save();
                
                $sms = sms::boostPaymentOffline($user_id);

                DB::commit();

                if ($category_name == 'tractor') {
                    return Redirect::to('krishi-tractor-post-view/' . $product_id);
                }
                if ($category_name == 'gv') {
                    return Redirect::to('krishi-gv-post-view/' . $product_id);
                }
                if ($category_name == 'harvester') {
                    return Redirect::to('krishi-harvester-post-view/' . $product_id);
                }
                if ($category_name == 'implements') {
                    return Redirect::to('krishi-implements-post-view/' . $product_id);
                }
                if ($category_name == 'seed') {
                    return Redirect::to('krishi-seeds-post-view/' . $product_id);
                }
                if ($category_name == 'tyre') {
                    return Redirect::to('krishi-tyre-post-view/' . $product_id);
                }
                if ($category_name == 'fertilizer') {
                    return Redirect::to('krishi-fertilizers-post-view/' . $product_id);
                }
                if ($category_name == 'pesticides') {
                    return Redirect::to('krishi-pesticides-post-view/' . $product_id);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                $output['response']       = false;
                $output['message']        = $e;
            }
        }else{
            if ($category_name == "tractor") {
                $product = DB::table('tractorView as t')
                    ->select('t.id', 't.brand_name', 'u.name',)
                    ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                    ->where('t.id', $product_id)
                    ->first();
            }
            if ($category_name == "gv") {
                $product = DB::table('goodVehicleView as t')
                    ->select('t.id', 't.brand_name', 'u.name',)
                    ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                    ->where('t.id', $product_id)
                    ->first();
            }
            if ($category_name == "harvester") {
                $product = DB::table('harvesterView as t')
                    ->select('t.id', 't.brand_name', 'u.name',)
                    ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                    ->where('t.id', $product_id)
                    ->first();
            }
            if ($category_name == "implements") {
                $product = DB::table('implementView as t')
                    ->select('t.id', 't.brand_name', 'u.name',)
                    ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                    ->where('t.id', $product_id)
                    ->first();
            }
            if ($category_name == "seed") {
                $product = DB::table('seedView as t')
                    ->select('t.id', 't.title as brand_name', 'u.name',)
                    ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                    ->where('t.id', $product_id)
                    ->first();
            }
            if ($category_name == "tyre") {
                $product = DB::table('tyresView as t')
                    ->select('t.id', 't.brand_name', 'u.name',)
                    ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                    ->where('t.id', $product_id)
                    ->first();
            }
            if ($category_name == "seed") {
                $product = DB::table('seedView as t')
                    ->select('t.id', 't.title as brand_name', 'u.name',)
                    ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                    ->where('t.id', $product_id)
                    ->first();
            }
            if ($category_name == "fertilizer") {
                $product = DB::table('fertilizerView as t')
                    ->select('t.id', 't.title as brand_name', 'u.name',)
                    ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                    ->where('t.id', $product_id)
                    ->first();
            }
            if ($category_name == "pesticides") {
                $product = DB::table('pesticidesView as t')
                    ->select('t.id', 't.title as brand_name', 'u.name',)
                    ->leftJoin('user as u', 'u.id', '=', 't.user_id')
                    ->where('t.id', $product_id)
                    ->first();
            }

            $market_user = DB::table('user')->where('market_status',1)->get();
          //  return response()->json(['success' => 'error']);
          return view('admin.boost_form', ['msg'=> 'OTP not matched' ,'market_user' => $market_user, 'product' => $product]);
        }
    }

    public function otp_sent($category_name, $product_id)
    {
        // dd($category_name);

        if ($category_name == 'tractor') {
            $user_id = DB::table('tractorView')->where('id', $product_id)->first()->user_id;
            $mobile = DB::table('user')->where('id', $user_id)->first()->mobile;
        }
        if ($category_name == 'gv') {
            $user_id = DB::table('goodVehicleView')->where('id', $product_id)->first()->user_id;
            $mobile = DB::table('user')->where('id', $user_id)->first()->mobile;
            //  dd($mobile);
        }
        if ($category_name == 'harvester') {
            $user_id = DB::table('harvesterView')->where('id', $product_id)->first()->user_id;
            $mobile = DB::table('user')->where('id', $user_id)->first()->mobile;
        }
        if ($category_name == 'implements') {
            $user_id = DB::table('implementView')->where('id', $product_id)->first()->user_id;
            $mobile = DB::table('user')->where('id', $user_id)->first()->mobile;
        }
        if ($category_name == 'seed') {
            $user_id = DB::table('seedView')->where('id', $product_id)->first()->user_id;
            $mobile = DB::table('user')->where('id', $user_id)->first()->mobile;
        }
        if ($category_name == 'tyre') {
            $user_id = DB::table('tyresView')->where('id', $product_id)->first()->user_id;
            $mobile = DB::table('user')->where('id', $user_id)->first()->mobile;
        }
        if ($category_name == 'fertilizer') {
            $user_id = DB::table('fertilizerView')->where('id', $product_id)->first()->user_id;
            $mobile = DB::table('user')->where('id', $user_id)->first()->mobile;
        }
        if ($category_name == 'pesticides') {
            $user_id = DB::table('pesticidesView')->where('id', $product_id)->first()->user_id;
            $mobile = DB::table('user')->where('id', $user_id)->first()->mobile;
        }

        // dd($mobile);
        //$mobile2 = 8617899557;

        $rand = rand(1000, 9999);
        $sms_code = $rand . '.';
        $message = 'Your Krishi Vikas Udyog verification code is ' . $sms_code . ' Please enter it in the required space to process your sign-up. | Krishi Vikas';
        //$message = 'Your OTP for offline product boost on Krishi Vikas is ' . $sms_code . ' Please enter the OTP in the required space to process further.';
        $encoded_message = urlencode($message);
        
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number=' . $mobile . '&message=' . $encoded_message . '&format=json';
        
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

        return $res;

        // return response()->json(['message' => true]);

    }
}
