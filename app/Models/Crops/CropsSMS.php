<?php

namespace App\Models\Crops;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Crops\CropSubscriptionFeatures;
use App\Models\Crops\CropSubscription;

class CropsSMS extends Model
{
    use HasFactory;

    protected $table = 'sms';
    protected $fillable = ['name', 'value', 'status'];
    private $api_key = 'T6g6MD0t57gQ6auG';
    private $sender_id = 'KRVIKS';



    # CROPS SUBSCRIPTION , BANNER AND BOOST EXPIRY
    protected function expiry_crops_plan($user_id, $subscription_id)
    {
        # SMS
        $subscription_plane_name  = CropSubscription::where('id', $subscription_id)->value('crop_subscriptions_name');
       // dd($subscription_plane_name);
        $mobile = DB::table('user')->where('id', $user_id)->value('mobile');

        $user = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $user_id        = $user->id;
        $user_name      = $user->name;
        $language       = $user->lamguage;

        if (!empty($user->firebase_token)) {
            $firebase_token = $user->firebase_token;
        } else if (empty($user->firebase_token)) {
            // $firebase_token = "cHq7ILqJQBGgTSwPpajyAM:APA91bF5punEMtH4TYdEd93I5BnDV1uBCfsgLA3gKmjha8FbV-Qg5FwepioqXDG-5tNalY3fvVd6e-EIjZ97cLd3ljHbWs6TeDgW-USfL7WP5joMZQFhe-vqVJ6B04oY40nSKw2beBAE";
            $firebase_token = 'cpe1afX5Tpy9MlBY0p7PsN:APA91bHAlN7R1WIKppa86yeF_WCuxFZw9PP_4QQ_OTZ-m4uz-mUtsGp2jXqnVjlHPuTmO1u5KGgm22YUKFqhZHwJ-fc3CrdGgKKHIBMWteF-Ggx_8NiTPfQG9XmpEUXIlzLD9mT-q71g';
        }

        $message        = DB::table('sms')->where(['name' => 'expiry_plan'])->where(['status' => 1])->value('value');
        $message        = str_replace('{var1}', $user_name, $message);
        $message        = str_replace('{var2}', $subscription_plane_name, $message);
        $encode_message = urlencode($message);

        $title = 'Krishi Vikas';
        $url   = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);


        # NOTIFICATION
        if ($language == 1) {
            $n_title = 'We miss you!';
            $n_message = 'Your subscription plane : '.$subscription_plane_name.' has expired! Recharge now to resume your sales journey. Tap here to subscribe.';
        } elseif ($language == 2) {
            $n_title = 'आपका सब्सक्रिप्शन समाप्त हो गया है!';
            $n_message = 'निर्बाध सेवा का आनंद लेने के लिए आज ही सब्सक्राइब करें।';
        } elseif ($language == 3) {
            $n_title = 'আপনার সাবস্ক্রিপশান শেষ!';
            $n_message = 'আপনার সাবস্ক্রিপশান প্ল্যান শেষ হয়েছে! অবিচ্ছিন্ন পরিষেবা উপভোগ করতে আজই সাবস্ক্রাইব করুন।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'image' => '',
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_subscription',
                'badge' => '1',
                'vibrate' => 1,
                'importance' => 'Max'
            )
        );

        $fields = json_encode($fields);
        $headers = array(
            'Authorization: key=' . "AAAAggkuf0U:APA91bFBX11jYY_-0wGkxNL1D1CDlsFStOwl_1XP6W9P7nGzGKCvQPuiw7gYxJTGIl979OnB7puZ8msM4pPz7TslSjZysTyG0pZwTWH8PhriZO3sGt-a8u5UFiNJfyRh2M1h0f05jZl4",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        \Log::info('Expired' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        return $res;
    }

    # CROPS SUBSCRIPTION EXPIRY IN 3,2,1 DAYS
    protected function subscription_day_left($user_id, $subscription_id, $days)
    {
        $subscription_plane_name  = CropSubscriptionFeatures::where('crops_subscription_id', $subscription_id)->value('name');
        $mobile = DB::table('user')->where('id', $user_id)->value('mobile');

        $user = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $user_id        = $user->id;
        $user_name      = $user->name;
        $language       = $user->lamguage;

        if (!empty($user->firebase_token)) {
            $firebase_token = $user->firebase_token;
        } else if (empty($user->firebase_token)) {
            // $firebase_token = "cHq7ILqJQBGgTSwPpajyAM:APA91bF5punEMtH4TYdEd93I5BnDV1uBCfsgLA3gKmjha8FbV-Qg5FwepioqXDG-5tNalY3fvVd6e-EIjZ97cLd3ljHbWs6TeDgW-USfL7WP5joMZQFhe-vqVJ6B04oY40nSKw2beBAE";
            $firebase_token = 'cpe1afX5Tpy9MlBY0p7PsN:APA91bHAlN7R1WIKppa86yeF_WCuxFZw9PP_4QQ_OTZ-m4uz-mUtsGp2jXqnVjlHPuTmO1u5KGgm22YUKFqhZHwJ-fc3CrdGgKKHIBMWteF-Ggx_8NiTPfQG9XmpEUXIlzLD9mT-q71g';
        }

        $message = DB::table('sms')->where(['name' => 'subscription_day_left'])->where(['status' => 1])->value('value');
        $message = str_replace('{var1}', $user_name, $message);
        $message = str_replace('{var2}', $subscription_plane_name, $message);
        $message = str_replace('{var3}', $days, $message);

        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        if ($language == 1) {
            $n_title = 'Your subscription expires within '.$days.'days!!';
            $n_message = 'Attention dear user! Your crop subscription package'.$subscription_plane_name.' is expiring within'.$days.'days! Renew to enjoy uninterrupted services.';
        } elseif ($language == 2) {
            $n_title = 'आपका फसल सबक्रिप्शन पैकेज'.$subscription_plane_name.''.$days.'दिनों में समाप्त हो जाएगा!! ';
            $n_message = 'आपका बैनर सब्सक्रिप्शन प्लान समाप्त होने को है ! निर्बाध सेवा का आनंद लेने के लिए आज ही सब्सक्राइब करें। ';
        } elseif ($language == 3) {
            $n_title = 'আপনার ফসল সাবস্ক্রিপশন প্যাকেজ '.$subscription_plane_name.'এর মেয়াদ '.$days.'দিনের মধ্যে শেষ হয়ে যাবে!!';
            $n_message = 'নিরবচ্ছিন্ন পরিষেবা উপভোগ করতে এখনই রিচার্জ করুন। বিশদে সাবস্ক্রিপশান প্ল্যান জানতে এখানে ক্লিক করুন।';
        }


        $n_title = 'Your subscription is expiring soon!';
        $n_message = 'Renew now to enjoy uninterrupted services. Check the subscription plans here.';

        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title'           => $n_title,
                'body'            => $n_message,
                'image'           => '',
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action'    => 'OPEN_SPECIFIC_PAGE',
                'url'             => '/my_subscription',
                'badge'           => '1',
                'vibrate'         => 1,
                'importance'      => 'Max'
            )
        );

        $fields = json_encode($fields);
        $headers = array(
            'Authorization: key=' . "AAAAggkuf0U:APA91bFBX11jYY_-0wGkxNL1D1CDlsFStOwl_1XP6W9P7nGzGKCvQPuiw7gYxJTGIl979OnB7puZ8msM4pPz7TslSjZysTyG0pZwTWH8PhriZO3sGt-a8u5UFiNJfyRh2M1h0f05jZl4",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    # ADD CROPS SUBSCRIPTION
    protected function add_subscription($user_id,$subscription_id)
    {
        $subscription_name = CropSubscription::where('id',$subscription_id)->value('crop_subscriptions_name');
        $mobile = DB::table('user')->where('id', $user_id)->value('mobile');

        # SMS
        $message = 'Your post has been successfully submitted and is now approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        # NOTIFICATION
        $user = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $user_id        = $user->id;
        $user_name      = $user->name;
        $language       = $user->lamguage;

        if (!empty($user->firebase_token)) {
            $firebase_token = $user->firebase_token;
        } else if (empty($user->firebase_token)) {
            // $firebase_token = "cHq7ILqJQBGgTSwPpajyAM:APA91bF5punEMtH4TYdEd93I5BnDV1uBCfsgLA3gKmjha8FbV-Qg5FwepioqXDG-5tNalY3fvVd6e-EIjZ97cLd3ljHbWs6TeDgW-USfL7WP5joMZQFhe-vqVJ6B04oY40nSKw2beBAE";
            $firebase_token = 'cpe1afX5Tpy9MlBY0p7PsN:APA91bHAlN7R1WIKppa86yeF_WCuxFZw9PP_4QQ_OTZ-m4uz-mUtsGp2jXqnVjlHPuTmO1u5KGgm22YUKFqhZHwJ-fc3CrdGgKKHIBMWteF-Ggx_8NiTPfQG9XmpEUXIlzLD9mT-q71g';
        }

        if ($language == 1) {
            $n_title = 'Congratulations!! Crop subscription added successfully!';
            $n_message = 'Dear user, your crop subscription package'.$subscription_name.'has been added successfully. Enjoy the 30 days of growth!';
        } elseif ($language == 2) {
            $n_title = 'बहुत बधाई! क्रॉप सब्सक्रिपशन सफलतापूर्वक जोड़ी गई';
            $n_message = ' प्रिय ग्राहक, आपका क्रॉप सब्सक्रिपशन पैकेज'.$subscription_name.'सफलतापूर्वक जोड़ दिया गया है। इन 30 दिनों का आनंद लें!';
        } elseif ($language == 3) {
            $n_title = 'অনেক অভিনন্দন! ক্রপ সাবস্ক্রিপশন সফল্ভাবে অ্যাড করা হয়েছে!';
            $n_message = ' প্রিয় গ্রাহক, আপনার ক্রপ সাবস্ক্রিপশন প্যাকেজ'.$subscription_name.'সফল্ভাবে অ্যাড করা হয়েছে। এই ৩০ দিন উপভোগ করুন!';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title'           => $n_title,
                'body'            => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action'    => 'OPEN_SPECIFIC_PAGE',
                'url'             => '/my-crops',
                'badge'           => '1',
                'vibrate'         => 1,
                'importance'      => 'Max'
            )
        );

        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . "AAAAggkuf0U:APA91bFBX11jYY_-0wGkxNL1D1CDlsFStOwl_1XP6W9P7nGzGKCvQPuiw7gYxJTGIl979OnB7puZ8msM4pPz7TslSjZysTyG0pZwTWH8PhriZO3sGt-a8u5UFiNJfyRh2M1h0f05jZl4",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        \Log::info('Post Approve' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        return $res;
    }

    # APPROVE CROPS POST
    protected function add_crops($user_id) 
    {
        $mobile = DB::table('user')->where('id', $user_id)->value('mobile');

        # SMS
        $message = 'Your post has been successfully submitted and is now approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        # NOTIFICATION
        $user = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $user_id        = $user->id;
        $user_name      = $user->name;
        $language       = $user->lamguage;

        if (!empty($user->firebase_token)) {
            $firebase_token = $user->firebase_token;
        } else if (empty($user->firebase_token)) {
            // $firebase_token = "cHq7ILqJQBGgTSwPpajyAM:APA91bF5punEMtH4TYdEd93I5BnDV1uBCfsgLA3gKmjha8FbV-Qg5FwepioqXDG-5tNalY3fvVd6e-EIjZ97cLd3ljHbWs6TeDgW-USfL7WP5joMZQFhe-vqVJ6B04oY40nSKw2beBAE";
            $firebase_token = 'cpe1afX5Tpy9MlBY0p7PsN:APA91bHAlN7R1WIKppa86yeF_WCuxFZw9PP_4QQ_OTZ-m4uz-mUtsGp2jXqnVjlHPuTmO1u5KGgm22YUKFqhZHwJ-fc3CrdGgKKHIBMWteF-Ggx_8NiTPfQG9XmpEUXIlzLD9mT-q71g';
        }

        if ($language == 1) {
            $n_title = 'APPROVE CROPS POST';
            $n_message = 'Your post has been approved! Click here to see insights!';
        } elseif ($language == 2) {
            $n_title = 'बहुत बधाई! आपका पोस्ट स्वीकृत हो गई है!';
            $n_message = 'प्रिय ग्राहक,आपका पोस्ट हमारे द्वारा स्वीकृत हो गई है। अधिक जानकारी के लिए यहां क्लिक करें!';
        } elseif ($language == 3) {
            $n_title = 'অনেক অভিনন্দন! আপনার পোস্ট অ্যাপ্রুভ করা হয়েছে!';
            $n_message = 'প্রিয় গ্রাহক, আপনার পোস্টটি আমাদের তরফ থেকে অনুমোদিত হয়েছে। বিশদে জানতে এখানে ক্লিক করুন!';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title'           => $n_title,
                'body'            => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action'    => 'OPEN_SPECIFIC_PAGE',
                'url'             => '/my_crops',
                'badge'           => '1',
                'vibrate'         => 1,
                'importance'      => 'Max'
            )
        );

        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . "AAAAggkuf0U:APA91bFBX11jYY_-0wGkxNL1D1CDlsFStOwl_1XP6W9P7nGzGKCvQPuiw7gYxJTGIl979OnB7puZ8msM4pPz7TslSjZysTyG0pZwTWH8PhriZO3sGt-a8u5UFiNJfyRh2M1h0f05jZl4",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        \Log::info('Post Approve' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        return $res;
    }

    # PENDING CROPS POST
    protected function pending_crops($user_id)
    {
        $mobile = DB::table('user')->where('id', $user_id)->value('mobile');

        # SMS
        $message = 'Your post has been successfully submitted and is now approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        # NOTIFICATION
        $user = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $user_id        = $user->id;
        $user_name      = $user->name;
        $language       = $user->lamguage;

        if (!empty($user->firebase_token)) {
            $firebase_token = $user->firebase_token;
        } else if (empty($user->firebase_token)) {
            // $firebase_token = "cHq7ILqJQBGgTSwPpajyAM:APA91bF5punEMtH4TYdEd93I5BnDV1uBCfsgLA3gKmjha8FbV-Qg5FwepioqXDG-5tNalY3fvVd6e-EIjZ97cLd3ljHbWs6TeDgW-USfL7WP5joMZQFhe-vqVJ6B04oY40nSKw2beBAE";
            $firebase_token = 'cpe1afX5Tpy9MlBY0p7PsN:APA91bHAlN7R1WIKppa86yeF_WCuxFZw9PP_4QQ_OTZ-m4uz-mUtsGp2jXqnVjlHPuTmO1u5KGgm22YUKFqhZHwJ-fc3CrdGgKKHIBMWteF-Ggx_8NiTPfQG9XmpEUXIlzLD9mT-q71g';
        }

        if ($language == 1) {
            $n_title = 'PENDDING CROPS POST';
            $n_message = 'Your post has been pending! Click here to see insights!';
        } elseif ($language == 2) {
            $n_title = 'बहुत बधाई! आपका पोस्ट स्वीकृत हो गई है!';
            $n_message = 'प्रिय ग्राहक,आपका पोस्ट हमारे द्वारा स्वीकृत हो गई है। अधिक जानकारी के लिए यहां क्लिक करें!';
        } elseif ($language == 3) {
            $n_title = 'অনেক অভিনন্দন! আপনার পোস্ট মুলতবি করা হয়েছে!';
            $n_message = 'প্রিয় গ্রাহক, আপনার পোস্টটি আমাদের তরফ থেকে অনুমোদিত হয়েছে। বিশদে জানতে এখানে ক্লিক করুন!';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title'           => $n_title,
                'body'            => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action'    => 'OPEN_SPECIFIC_PAGE',
                'url'             => '/my_crops',
                'badge'           => '1',
                'vibrate'         => 1,
                'importance'      => 'Max'
            )
        );

        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . "AAAAggkuf0U:APA91bFBX11jYY_-0wGkxNL1D1CDlsFStOwl_1XP6W9P7nGzGKCvQPuiw7gYxJTGIl979OnB7puZ8msM4pPz7TslSjZysTyG0pZwTWH8PhriZO3sGt-a8u5UFiNJfyRh2M1h0f05jZl4",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        \Log::info('Post Approve' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        return $res;
    }

    # PENDING CROPS POST
    protected function reject_crops($user_id)
    {
        $mobile = DB::table('user')->where('id', $user_id)->value('mobile');

        # SMS
        $message = 'Your post has been successfully submitted and is now approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        # NOTIFICATION
        $user = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $user_id        = $user->id;
        $user_name      = $user->name;
        $language       = $user->lamguage;

        if (!empty($user->firebase_token)) {
            $firebase_token = $user->firebase_token;
        } else if (empty($user->firebase_token)) {
            // $firebase_token = "cHq7ILqJQBGgTSwPpajyAM:APA91bF5punEMtH4TYdEd93I5BnDV1uBCfsgLA3gKmjha8FbV-Qg5FwepioqXDG-5tNalY3fvVd6e-EIjZ97cLd3ljHbWs6TeDgW-USfL7WP5joMZQFhe-vqVJ6B04oY40nSKw2beBAE";
            $firebase_token = 'cpe1afX5Tpy9MlBY0p7PsN:APA91bHAlN7R1WIKppa86yeF_WCuxFZw9PP_4QQ_OTZ-m4uz-mUtsGp2jXqnVjlHPuTmO1u5KGgm22YUKFqhZHwJ-fc3CrdGgKKHIBMWteF-Ggx_8NiTPfQG9XmpEUXIlzLD9mT-q71g';
        }

        if ($language == 1) {
            $n_title = 'REJECT CROPS POST';
            $n_message = 'Your post has been pending! Click here to see insights!';
        } elseif ($language == 2) {
            $n_title = 'बहुत बधाई! आपका पोस्ट स्वीकृत हो गई है!';
            $n_message = 'प्रिय ग्राहक,आपका पोस्ट हमारे द्वारा स्वीकृत हो गई है। अधिक जानकारी के लिए यहां क्लिक करें!';
        } elseif ($language == 3) {
            $n_title = 'অনেক অভিনন্দন! আপনার পোস্ট প্রত্যাখ্যান করা হয়েছে!';
            $n_message = 'প্রিয় গ্রাহক, আপনার পোস্টটি আমাদের তরফ থেকে অনুমোদিত হয়েছে। বিশদে জানতে এখানে ক্লিক করুন!';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title'           => $n_title,
                'body'            => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action'    => 'OPEN_SPECIFIC_PAGE',
                'url'             => '/my_crops',
                'badge'           => '1',
                'vibrate'         => 1,
                'importance'      => 'Max'
            )
        );

        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . "AAAAggkuf0U:APA91bFBX11jYY_-0wGkxNL1D1CDlsFStOwl_1XP6W9P7nGzGKCvQPuiw7gYxJTGIl979OnB7puZ8msM4pPz7TslSjZysTyG0pZwTWH8PhriZO3sGt-a8u5UFiNJfyRh2M1h0f05jZl4",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        \Log::info('Post Approve' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        return $res;
    }

    # PENDING CROPS BANNER
    protected function pending_banner($user_id)
    {
        $mobile = DB::table('user')->where('id', $user_id)->value('mobile');

        # SMS
        $message = 'Your post has been successfully submitted and is now approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        $user = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $user_id        = $user->id;
        $user_name      = $user->name;
        $language       = $user->lamguage;

        if (!empty($user->firebase_token)) {
            $firebase_token = $user->firebase_token;
        } else if (empty($user->firebase_token)) {
            // $firebase_token = "cHq7ILqJQBGgTSwPpajyAM:APA91bF5punEMtH4TYdEd93I5BnDV1uBCfsgLA3gKmjha8FbV-Qg5FwepioqXDG-5tNalY3fvVd6e-EIjZ97cLd3ljHbWs6TeDgW-USfL7WP5joMZQFhe-vqVJ6B04oY40nSKw2beBAE";
            $firebase_token = 'cpe1afX5Tpy9MlBY0p7PsN:APA91bHAlN7R1WIKppa86yeF_WCuxFZw9PP_4QQ_OTZ-m4uz-mUtsGp2jXqnVjlHPuTmO1u5KGgm22YUKFqhZHwJ-fc3CrdGgKKHIBMWteF-Ggx_8NiTPfQG9XmpEUXIlzLD9mT-q71g';
        }

        if ($language == 1) {
            $n_title = 'ATTENTION! Your banner is pending approval!';
            $n_message = 'Dear user, your banner is pending approval from our end. We will notify you once it is approved. Thanks!';
        } elseif ($language == 2) {
            $n_title = 'ध्यान दें !! आपका क्रॉप का बैनर अनुमोदन हेतु रूका हुआ है!';
            $n_message = 'प्रिय ग्राहक, आपका बैनर हमारे तरफ से अनुमोदन हेतु अभी भी रुका हुआ है। स्वीकृत होते ही हम आपको सूचित करेंगे। धन्यवाद!';
        } elseif ($language == 3) {
            $n_title = 'মনোযোগ দিন !! আপনার ক্রপ ব্যানার অনুমোদনের জন্য মুলতুবি আছে!';
            $n_message = 'প্রিয় গ্রাহক, আপনার ক্রপ সম্পর্কিত ব্যানার আমাদের তরফ থেকে মুলতুবি রাখা হয়েছে। স্বীকৃত হতেই আপনাকে জানানো হবে।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data'       => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action'    => 'OPEN_SPECIFIC_PAGE',
                'url'             => '/my-crops',
                'badge' => '1',
                'vibrate' => 1,
                'importance' => 'Max'
            )
        );


        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . "AAAAggkuf0U:APA91bFBX11jYY_-0wGkxNL1D1CDlsFStOwl_1XP6W9P7nGzGKCvQPuiw7gYxJTGIl979OnB7puZ8msM4pPz7TslSjZysTyG0pZwTWH8PhriZO3sGt-a8u5UFiNJfyRh2M1h0f05jZl4",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        \Log::info('Post Approve' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        return $res;
    }

    # APPROVE CROPS BANNER
    protected function add_banner($user_id)
    {
        $mobile = DB::table('user')->where('id', $user_id)->value('mobile');

        # SMS
        $message = 'Your post has been successfully submitted and is now approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        $user = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $user_id        = $user->id;
        $user_name      = $user->name;
        $language       = $user->lamguage;

        if (!empty($user->firebase_token)) {
            $firebase_token = $user->firebase_token;
        } else if (empty($user->firebase_token)) {
            // $firebase_token = "cHq7ILqJQBGgTSwPpajyAM:APA91bF5punEMtH4TYdEd93I5BnDV1uBCfsgLA3gKmjha8FbV-Qg5FwepioqXDG-5tNalY3fvVd6e-EIjZ97cLd3ljHbWs6TeDgW-USfL7WP5joMZQFhe-vqVJ6B04oY40nSKw2beBAE";
            $firebase_token = 'cpe1afX5Tpy9MlBY0p7PsN:APA91bHAlN7R1WIKppa86yeF_WCuxFZw9PP_4QQ_OTZ-m4uz-mUtsGp2jXqnVjlHPuTmO1u5KGgm22YUKFqhZHwJ-fc3CrdGgKKHIBMWteF-Ggx_8NiTPfQG9XmpEUXIlzLD9mT-q71g';
        }

        if ($language == 1) {
            $n_title = ' Woah!! Your banner is live now!!';
            $n_message = 'Dear user, your banner has been approved on our end. Now enjoy our services without any tension!';
        } elseif ($language == 2) {
            $n_title = 'बधाई हो! आपका बैनर स्वीकारा गया है !';
            $n_message = 'प्रिय ग्राहक, आपका फसल बैनर हमारे तरफ से स्वीकारा गया है। अब बिना किसी हिचकिचाहट के हमारी सेवाओं का आनंद लें। ';
        } elseif ($language == 3) {
            $n_title = 'অভিনন্দন ! আপনার ব্যানার স্বীকৃত হয়েছে!';
            $n_message = 'প্রিয় গ্রাহক, আপনার ফসল সম্পর্কিত ব্যানার আমাদের তরফ থেকে স্বীকৃত হয়েছে। এবার নির্বিবাদে আমদের পরিষেবা উপভোগ করুন।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data'       => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action'    => 'OPEN_SPECIFIC_PAGE',
                'url'             => '/my-crops',
                'badge' => '1',
                'vibrate' => 1,
                'importance' => 'Max'
            )
        );


        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . "AAAAggkuf0U:APA91bFBX11jYY_-0wGkxNL1D1CDlsFStOwl_1XP6W9P7nGzGKCvQPuiw7gYxJTGIl979OnB7puZ8msM4pPz7TslSjZysTyG0pZwTWH8PhriZO3sGt-a8u5UFiNJfyRh2M1h0f05jZl4",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        \Log::info('Post Approve' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        return $res;
    }

    # REJECT CROPS BANNER
    protected function reject_banner($user_id)
    {
        $mobile = DB::table('user')->where('id', $user_id)->value('mobile');

        # SMS
        $message = 'Your post has been successfully submitted and is now approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        $user = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $user_id        = $user->id;
        $user_name      = $user->name;
        $language       = $user->lamguage;

        if (!empty($user->firebase_token)) {
            $firebase_token = $user->firebase_token;
        } else if (empty($user->firebase_token)) {
            // $firebase_token = "cHq7ILqJQBGgTSwPpajyAM:APA91bF5punEMtH4TYdEd93I5BnDV1uBCfsgLA3gKmjha8FbV-Qg5FwepioqXDG-5tNalY3fvVd6e-EIjZ97cLd3ljHbWs6TeDgW-USfL7WP5joMZQFhe-vqVJ6B04oY40nSKw2beBAE";
            $firebase_token = 'cpe1afX5Tpy9MlBY0p7PsN:APA91bHAlN7R1WIKppa86yeF_WCuxFZw9PP_4QQ_OTZ-m4uz-mUtsGp2jXqnVjlHPuTmO1u5KGgm22YUKFqhZHwJ-fc3CrdGgKKHIBMWteF-Ggx_8NiTPfQG9XmpEUXIlzLD9mT-q71g';
        }

        if ($language == 1) {
            $n_title = 'Oops! Better luck next time!';
            $n_message = 'Unfortunately your banner wasn’t approved. We noticed a revision is needed for your banner. Edit and resubmit when ready!';
        } elseif ($language == 2) {
            $n_title = ' हमें खेद है!';
            $n_message = 'दुर्भाग्य से आपका बैनर स्वीकृत नहीं हुआ है। आपके बैनर में सुधार की आवश्यकता है। विचार करने के बाद फिरसे सबमिट करें।';
        } elseif ($language == 3) {
            $n_title = 'দুঃখিত! আপনার ব্যানার অনুমোদিত হয়নি!';
            $n_message = 'দুর্ভাগ্যবশত আপনার ব্যানার অনুমোদিত হয়নি। আমরা দেখেছি যে আপনার ব্যানারে সংশোধন প্রয়োজন। বিবেচনা করে পুনরায় জমা দিন!';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data'       => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action'    => 'OPEN_SPECIFIC_PAGE',
                'url'             => '/my-crops',
                'badge' => '1',
                'vibrate' => 1,
                'importance' => 'Max'
            )
        );


        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . "AAAAggkuf0U:APA91bFBX11jYY_-0wGkxNL1D1CDlsFStOwl_1XP6W9P7nGzGKCvQPuiw7gYxJTGIl979OnB7puZ8msM4pPz7TslSjZysTyG0pZwTWH8PhriZO3sGt-a8u5UFiNJfyRh2M1h0f05jZl4",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        \Log::info('Post Approve' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        return $res;
    }

    # ADD CROPS BOOST
    protected function add_boost($user_id)
    {
        $mobile = DB::table('user')->where('id', $user_id)->value('mobile');

        # SMS
        $message = 'Your post has been successfully submitted and is now approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        $user = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $user_id        = $user->id;
        $user_name      = $user->name;
        $language       = $user->lamguage;
        
        if (!empty($user->firebase_token)) {
            $firebase_token = $user->firebase_token;
        } else if (empty($user->firebase_token)) {
            // $firebase_token = "cHq7ILqJQBGgTSwPpajyAM:APA91bF5punEMtH4TYdEd93I5BnDV1uBCfsgLA3gKmjha8FbV-Qg5FwepioqXDG-5tNalY3fvVd6e-EIjZ97cLd3ljHbWs6TeDgW-USfL7WP5joMZQFhe-vqVJ6B04oY40nSKw2beBAE";
            $firebase_token = 'cpe1afX5Tpy9MlBY0p7PsN:APA91bHAlN7R1WIKppa86yeF_WCuxFZw9PP_4QQ_OTZ-m4uz-mUtsGp2jXqnVjlHPuTmO1u5KGgm22YUKFqhZHwJ-fc3CrdGgKKHIBMWteF-Ggx_8NiTPfQG9XmpEUXIlzLD9mT-q71g';
        }

        if ($language == 1) {
            $n_title = 'Crop boosted successfully!';
            $n_message = 'Dear user, your crop has been boosted successfully. Enjoy more and more attention from potential customers now!';
        } elseif ($language == 2) {
            $n_title = 'आपके फसल को सफलतापूर्वक बूस्ट कर दिया गया है!';
            $n_message = 'प्रिय ग्राहक, आपके फसल को सफलतापूर्वक बूस्ट कर दिया गया है! अब देश के विभिन्न हिस्सों से खरीदार प्राप्त करें!';
        } elseif ($language == 3) {
            $n_title = 'আপনার ফসল সফল্ভাবে বুস্ট করা হয়েছে!';
            $n_message = ' প্রিয় গ্রাহক, আপনার ফসল সফল্ভাবে বুস্ট করা হয়েছে! এখন দেশের বিভিন্ন প্রান্ত থেকে খরিদ্দার পেয়ে যান!';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title'           => $n_title,
                'body'            => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action'    => 'OPEN_SPECIFIC_PAGE',
                'url'             => '/my-crops',
                'badge'           => '1',
                'vibrate'         => 1,
                'importance'      => 'Max'
            )
        );

        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . "AAAAggkuf0U:APA91bFBX11jYY_-0wGkxNL1D1CDlsFStOwl_1XP6W9P7nGzGKCvQPuiw7gYxJTGIl979OnB7puZ8msM4pPz7TslSjZysTyG0pZwTWH8PhriZO3sGt-a8u5UFiNJfyRh2M1h0f05jZl4",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        \Log::info('Post Approve' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        return $res;
    }
}
