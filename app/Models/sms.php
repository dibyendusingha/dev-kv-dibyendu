<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification_save;
use DB;

class sms extends Model
{
    use HasFactory;
    protected $table = 'sms';
    protected $fillable = ['name', 'value', 'status'];
    private $api_key = 'T6g6MD0t57gQ6auG';
    private $sender_id = 'KRVIKS';

    # Product post pending (Admin) /(Add and Update)
    protected function post_pending($mobile, $category_id)
    {

        //sms..
        $message = 'Your post is now pending for approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        $data = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $id = $data->id;
        $firebase_token = $data->firebase_token;
        $name = $data->name;
        $lamguage = $data->lamguage;

        if ($lamguage == 1) {
            $n_title = 'Post is pending!!';
            $n_message = 'Hello ,Your post is pending approval. We’ll notify you shortly once it is approved.';
        } elseif ($lamguage == 2) {
            $n_title = 'आपका पोस्ट स्थगित कर दी गई है';
            $n_message = 'प्रिय ग्राहक, आपका/आपकी पोस्ट वर्तमान में स्थगित कर दी गई है। स्वीकृत होने पर आपको सूचित किया जाएगा.';
        } elseif ($lamguage == 3) {
            $n_title = 'আপনার পোস্ট মুলতুবী রাখা হয়েছে।';
            $n_message = 'প্রিয় গ্রাহক, আপনার পোস্টটি আপাতত মুলতুবী রাখা হয়েছে। অনুমোদিত হলে আপনাকে জানিয়ে দেওয়া হবে।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_post',
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
        \Log::info('Post Pending' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);
        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_post', 'status' => 1]);

        return $res;
    }

    # Product post Approve (Admin)
    protected function post_approve($mobile, $category_id)
    {
        # SMS
        $message = 'Your post has been successfully submitted and is now approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        $data = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $id = $data->id;
        $firebase_token = $data->firebase_token;
        $name = $data->name;
        $lamguage = $data->lamguage;

        if ($lamguage == 1) {
            $n_title = 'Congratulations! You did it!';
            $n_message = 'Your post has been approved! Click here to see insights!';
        } elseif ($lamguage == 2) {
            $n_title = 'बहुत बधाई! आपका पोस्ट स्वीकृत हो गई है!';
            $n_message = 'प्रिय ग्राहक,आपका पोस्ट हमारे द्वारा स्वीकृत हो गई है। अधिक जानकारी के लिए यहां क्लिक करें!';
        } elseif ($lamguage == 3) {
            $n_title = 'অনেক অভিনন্দন! আপনার পোস্ট অ্যাপ্রুভ করা হয়েছে!';
            $n_message = 'প্রিয় গ্রাহক, আপনার পোস্টটি আমাদের তরফ থেকে অনুমোদিত হয়েছে। বিশদে জানতে এখানে ক্লিক করুন!';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_post',
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
        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_post', 'status' => 1]);

        return $res;
    }

    # Product post Reject (Admin)
    protected function post_reject($mobile, $category_id)
    {

        //sms..
        $message = 'Your post has been rejected from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);


        $data = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $id = $data->id;
        $firebase_token = $data->firebase_token;
        $name = $data->name;
        $lamguage = $data->lamguage;

        //push notification..
        if ($lamguage == 1) {
            $n_title = 'OOPS! Your post did not cut!';
            $n_message = 'Unfortunately your post did not meet our guidelines. Please review and resubmit.';
        } elseif ($lamguage == 2) {
            $n_title = 'क्षमा करें, आपका पोस्ट रद्द कर दिया गया है!';
            $n_message = 'दुर्भाग्य से आपका पोस्ट हमारे शर्तों के अनुरूप नहीं है। कृपया पुनर्विचार करें और पोस्ट करें।';
        } elseif ($lamguage == 3) {
            $n_title = 'দুঃখিত, আপনার পোস্ট বাতিল করা হয়েছে!';
            $n_message = 'দুর্ভাগ্যবশত আপনার পোস্ট আমাদের শর্তাবলী অনুযায়ী ছিল না। অনুগ্রহ করে পুনর্বিবেচনা করে পোস্ট করুন।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_post',
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
        \Log::info('Post Reject' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);
        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_post', 'status' => 1]);

        return $res;
    }

    # subscription payment
    protected function subscription_payment($mobile, $name, $subscription_name, $transaction_id, $invoice_no, $purchased_price, $end_date)
    {

        //sms...
        $message = DB::table('sms')->where(['name' => 'transaction'])->where(['status' => 1])->value('value');
        //Dear {var1}, Thank you for subscribing to the {var2} on Krishi Vikas! Your payment was successful.
        // Transaction ID: {var3} Invoice Number: {var4} Amount: {var5} Validity: {var6} For support, contact us. Krishi Vikas!
        $message = str_replace('{var1}', $name, $message);
        $message = str_replace('{var2}', $subscription_name, $message);
        $message = str_replace('{var3}', $transaction_id, $message);
        $message = str_replace('{var4}', $invoice_no, $message);
        $message = str_replace('{var5}', $purchased_price, $message);
        $message = str_replace('{var6}', $end_date, $message);


        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        //push notification ...
        $data = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $id = $data->id;
        $name = $data->name;
        $lamguage = $data->lamguage;
        $firebase_token = $data->firebase_token;

        if ($lamguage == 1) {
            $n_title = 'Bingo! Your payment is done!';
            $n_message = 'Dear User, your payment has been successfully made for the banner ad. Get the hold of buyers and grow your sales.';
        } elseif ($lamguage == 2) {
            $n_title = 'आपका पेमेंट सफल हो गया है!';
            $n_message = 'प्रिय ग्राहक, बैनर के लिए आपका पेमेंट सफल हुआ है। अब आसानी से मुनाफ़ा कमाएँ!';
        } elseif ($lamguage == 3) {
            $n_title = 'আপনার পেমেন্ট সফল হয়েছে!';
            $n_message = 'প্রিয় গ্রাহক, ব্যানারের জন্য আপনার পেমেন্ট সফল হয়েছে। এখন স্বচ্ছন্দে মুনাফা লাভ করুন!';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
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
        \Log::info('Subscription Payment' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);
        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_subscription', 'status' => 1]);
        return $res;
    }

    # subscription boost payment
    protected function subscription_boost_payment($mobile, $name, $subscription_name, $transaction_id, $invoice_no, $purchased_price, $end_date)
    {

        //sms...
        $message = DB::table('sms')->where(['name' => 'transaction'])->where(['status' => 1])->value('value');
        //Dear {var1}, Thank you for subscribing to the {var2} on Krishi Vikas! Your payment was successful.
        // Transaction ID: {var3} Invoice Number: {var4} Amount: {var5} Validity: {var6} For support, contact us. Krishi Vikas!
        $message = str_replace('{var1}', $name, $message);
        $message = str_replace('{var2}', $subscription_name, $message);
        $message = str_replace('{var3}', $transaction_id, $message);
        $message = str_replace('{var4}', $invoice_no, $message);
        $message = str_replace('{var5}', $purchased_price, $message);
        $message = str_replace('{var6}', $end_date, $message);

        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);


        $data = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $id = $data->id;
        $firebase_token = $data->firebase_token;
        $lamguage = $data->lamguage;
        $name = $data->name;

        //push notification..
        if ($lamguage == 1) {
            $n_title = 'Payment done Successfully!!';
            $n_message = 'Dear User, your payment for the product boost has been done successfully. Check leads every day and get a deal done!';
        } elseif ($lamguage == 2) {
            $n_title = 'आपका पेमेंट सफल हुआ है!';
            $n_message = 'प्रिय ग्राहक, बूस्ट के लिए आपका पेमेंट सफल हुआ है। रोज़ाना नज़र रखें और डिल जल्द से जल्द पूरा करें।';
        } elseif ($lamguage == 3) {
            $n_title = 'আপনার পেমেন্ট সফল হয়েছে!';
            $n_message = 'প্রিয় গ্রাহক,প্রোডাক্ট বুস্টের জন্য আপনার পেমেন্ট সফল হয়েছে। প্রতিদিন নজর রাখুন এবং শীঘ্রই ডিল পাকা করে ফেলুন।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_post',
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
        \Log::info('Post Reject' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);
        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_post', 'status' => 1]);
        return $res;
    }

    # Subscription Boost Payment / api: boost-payment
    protected function boost_sms($mobile, $user_name, $brand_name, $category, $name, $end_date, $front_image, $product_id)
    {
        //$campaign_banner = DB::table('ads_banners')->where(['id'=>$ads_banner_id])->value('campaign_banner');
        $data = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $id = $data->id;
        $name = $data->name;
        $lamguage = $data->lamguage;
        $firebase_token = $data->firebase_token;

        if ($lamguage == 1) {
            $n_title = 'Payment done Successfully!!';
            $n_message = 'Dear ' . $name . ', your payment for the product boost has been done successfully. Check leads every day and get a deal done!';
        } elseif ($lamguage == 2) {
            $n_title = 'आपका पेमेंट सफल हो गया है!';
            $n_message = 'प्रिय ग्राहक, बूस्ट के लिए आपका पेमेंट सफल हुआ है। रोज़ाना नज़र रखें और सौदे जल्द से जल्द पूरा करें।';
        } elseif ($lamguage == 3) {
            $n_title = 'আপনার পেমেন্ট সফল হয়েছে!';
            $n_message = 'প্রিয় গ্রাহক, বুস্টের জন্য আপনার পেমেন্ট সফল হয়েছে। প্রতিদিন নজর রাখুন এবং শীঘ্রই ডিল পাকা করে ফেলুন।';
        }

        $message = DB::table('sms')->where(['name' => 'boost_payment'])->where(['status' => 1])->value('value');
        $title = 'Krishi Vikas';
        $message = str_replace('{var1}', $user_name, $message);
        $message = str_replace('{var2}', $brand_name, $message);
        $message = str_replace('{var3}', $category, $message);
        $message = str_replace('{var4}', $name, $message);
        $message = str_replace('{var5}', $end_date, $message);

        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        $id = DB::table('user')->where(['mobile' => $mobile])->value('id');
        $firebase_token = DB::table('user')->where(['mobile' => $mobile])->value('firebase_token');
        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(

                'title' => $n_title,
                'body' => $n_message,
                'image' => $front_image,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/Home',
                'category' => $category,
                'product_id' => $product_id,
                //'sound' => $sound, 
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

        curl_close($ch);
        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/Home', 'status' => 1]);

        return $res;
    }

    # banner --- Subscription Plane expiry soon ( 3,2,1 days) / Cron Job => renewal
    protected function subscription_day_left($mobile, $user_name, $subscription_name, $days)
    {

        $data = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $id = $data->id;
        $name = $data->name;
        $lamguage = $data->lamguage;
        $firebase_token = $data->firebase_token;

        $message = DB::table('sms')->where(['name' => 'subscription_day_left'])->where(['status' => 1])->value('value');
        //Dear {var1}, Your {var2} on Krishi Vikas is expiring in {var3} days! Renew now to continue enjoying premium features. For support, contact us. Krishi Vikas!
        $message = str_replace('{var1}', $user_name, $message);
        $message = str_replace('{var2}', $subscription_name, $message);
        $message = str_replace('{var3}', $days, $message);

        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        if ($lamguage == 1) {
            $n_title = 'Your subscription is expiring soon!';
            $n_message = 'Renew now to enjoy uninterrupted services. Check the subscription plans here.';
        } elseif ($lamguage == 2) {
            $n_title = 'आपका सब्सक्रिप्शन समाप्त होने वाला है!';
            $n_message = 'आपका बैनर सब्सक्रिप्शन प्लान समाप्त होने को है ! निर्बाध सेवा का आनंद लेने के लिए आज ही सब्सक्राइब करें। ';
        } elseif ($lamguage == 3) {
            $n_title = 'আপনার সাবস্ক্রিপশান শীঘ্রই শেষ হচ্ছে।';
            $n_message = 'নিরবচ্ছিন্ন পরিষেবা উপভোগ করতে এখনই রিচার্জ করুন। বিশদে সাবস্ক্রিপশান প্ল্যান জানতে এখানে ক্লিক করুন।';
        }

        $data = DB::table('user')->select('id', 'name', 'firebase_token')->where(['mobile' => $mobile])->first();
        $id = $data->id;
        $name = $data->name;
        $firebase_token = $data->firebase_token;

        $n_title = 'Your subscription is expiring soon!';
        $n_message = 'Renew now to enjoy uninterrupted services. Check the subscription plans here.';

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
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
                //'sound' => $sound, 
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
        \Log::info('Renew' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_subscription', 'status' => 1]);
        return $res;
    }

    # banner -- Subscription Plane expiry today / Cron Job
    protected function expiry_plan($mobile, $user_name, $subscription_name)
    {
        $data = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $id = $data->id;
        $name = $data->name;
        $lamguage = $data->lamguage;
        $firebase_token = $data->firebase_token;

        $message = DB::table('sms')->where(['name' => 'expiry_plan'])->where(['status' => 1])->value('value');
        //Dear {var1}, Your {var2} on Krishi Vikas has expired. Renew now to regain access to premium features and enhance your farming experience. For support, contact us. Krishi Vikas!
        $message = str_replace('{var1}', $user_name, $message);
        $message = str_replace('{var2}', $subscription_name, $message);

        $encode_message = urlencode($message);
        $title = 'Krishi Vikas';
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);


        $data = DB::table('user')->where(['mobile' => $mobile])->first();
        $id = $data->id;
        $name = $data->name;
        $firebase_token = $data->firebase_token;

        if ($lamguage == 1) {
            $n_title = 'We miss you!';
            $n_message = 'Your subscription has expired! Recharge now to resume your sales journey. Tap here to subscribe.';
        } elseif ($lamguage == 2) {
            $n_title = 'आपका सब्सक्रिप्शन समाप्त हो गया है!';
            $n_message = 'निर्बाध सेवा का आनंद लेने के लिए आज ही सब्सक्राइब करें।';
        } elseif ($lamguage == 3) {
            $n_title = 'আপনার সাবস্ক্রিপশান শেষ!';
            $n_message = 'আপনার সাবস্ক্রিপশান প্ল্যান শেষ হয়েছে! অবিচ্ছিন্ন পরিষেবা উপভোগ করতে আজই সাবস্ক্রাইব করুন।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';

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
                //'sound' => $sound, 
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
        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_subscription', 'status' => 1]);

        return $res;
    }

    # Banner Approve 
    protected function approve_banner($banner_id, $campaign_banner)
    {

        $banner_update = DB::table('ads_banners')->where('id', $banner_id)->first();
        $banner_user_id = $banner_update->user_id;

        $user_details = DB::table('user')->where(['id' => $banner_user_id])->first();
        $mobile = $user_details->mobile;
        $name = $user_details->name;
        $firebase_token = $user_details->firebase_token;
        $lamguage = $user_details->lamguage;

        $message = 'Your Banner is now live in Krishi Vikas. Trigger buyer action to boost your sales!';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        $id = $banner_user_id;

        if ($lamguage == 1) {
            $n_title = 'Congrats! Banner ad live!';
            $n_message = " Your Banner ad has been approved and is live now! Get ready for a sales boost!";
        } elseif ($lamguage == 2) {
            $n_title = ' बहुत बधाई!';
            $n_message = 'प्रिय ग्राहक, आपका बैनर स्वीकृत हो गया है! अधिक जानकारी के लिए यहां क्लिक करें!';
        } elseif ($lamguage == 3) {
            $n_title = 'অনেক অভিনন্দন! আপনার ব্যানার অ্যাপ্রুভ করা হয়েছে!';
            $n_message = ' প্রিয় গ্রাহক, আপনার ব্যানার আমাদের তরফ থেকে অনুমোদিত হয়েছে। বিশদে জানতে এখানে ক্লিক করুন!';
        }



        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(

                'title' => $n_title,
                'body' => $n_message,
                'image' => asset("storage/sponser/" . $campaign_banner),
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_ads',
                'banner_id' => $banner_id,
                //'sound' => $sound, 
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
        \Log::info('Banner approve' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_ads', 'banner_id' => $banner_id, 'status' => 1]);

        return $res;
    }

    # Banner Reject 
    protected function reject_banner($banner_id, $campaign_banner)
    {

        $banner_update = DB::table('ads_banners')->where('id', $banner_id)->first();
        $banner_user_id = $banner_update->user_id;

        $user_details = DB::table('user')->where(['id' => $banner_user_id])->first();
        $mobile = $user_details->mobile;
        $firebase_token = $user_details->firebase_token;
        $lamguage = $user_details->lamguage;


        $message = 'We regret to inform you that your ad has been rejected. Please review our guidelines before posting.Good luck';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        $id = $banner_user_id;
        if ($lamguage = 1) {
            $n_title = 'Sorry, not this time!';
            $n_message = 'Unfortunately your banner ad did not quite make it this time. No worries, revise and resubmit.';
        } else if ($lamguage = 2) {
            $n_title = 'क्षमा करें, आपका बैनर रद कर दिया गया है!';
            $n_message = 'दुर्भाग्य से आपका बैनर हमारे शर्तों के अनुरूप नहीं है। कृपया पुनर्विचार करें और पोस्ट करें।';
        } else if ($lamguage = 3) {
            $n_title = 'দুঃখিত, আপনার ব্যানার বাতিল করা হয়েছে!';
            $n_message = ' দুর্ভাগ্যবশত আপনার ব্যানার আমাদের শর্তাবলী অনুযায়ী ছিল না। অনুগ্রহ করে পুনর্বিবেচনা করে পোস্ট করুন।';
        }


        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(

                'title' => $n_title,
                'body' => $n_message,
                'image' => asset("storage/sponser/" . $campaign_banner),
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_ads',
                'banner_id' => $banner_id, //$banner_id,
                //'sound' => $sound, 
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
        \Log::info('Banner approve' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_ads', 'banner_id' => $banner_id, 'status' => 1]);

        return $res;
    }

    # Banner pending 
    protected function pending_banner($banner_id, $campaign_banner1)
    {
        //dd($banner_id);
        $banner_update = DB::table('ads_banners')->where('id', $banner_id)->first();
        $banner_user_id = $banner_update->user_id;
        $campaign_banner = $banner_update->campaign_banner;

        $user_details = DB::table('user')->select('id', 'name', 'mobile', 'firebase_token', 'lamguage')->where(['id' => $banner_user_id])->first();
        $id = $user_details->id;
        $name = $user_details->name;
        $mobile = $user_details->mobile;
        $firebase_token = $user_details->firebase_token;
        $lamguage = $user_details->lamguage;

        //sms...
        $message = 'Complete the steps to get it live and start reaching more buyers!';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        //push notification..
        $id = $banner_user_id;

        if ($lamguage == 1) {
            $n_title = 'Your Banner Ad is Pending Approval!';
            $n_message = "Hey! Just a heads-up —your banner ad is currently pending approval from our end. We're working diligently to review it and will notify you shortly. Thanks for your patience!";
        } elseif ($lamguage == 2) {
            $n_title = 'आपका बैनर विज्ञापन स्थगित कर दी गई है।';
            $n_message = 'प्रिय ग्राहक, आपका बैनर विज्ञापन वर्तमान में स्थगित कर दी गई है। स्वीकृत होने पर आपको सूचित किया जाएगा। आपके धैर्य के लिए धन्यवाद!';
        } elseif ($lamguage == 3) {
            $n_title = 'আপনার ব্যানার অ্যাড আপাতত মুলতুবী রাখা হয়েছে।';
            $n_message = 'প্রিয় গ্রাহক, আপনার ব্যানার বিজ্ঞাপন বর্তমানে আমাদের পক্ষ থেকে অনুমোদনের অপেক্ষায় রয়েছে।  এটি লাইভ হওয়ার সাথে সাথে আপনাকে জানানো হবে। আপনার ধৈর্য্যের জন্য ধন্যবাদ!';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(

                'title' => $n_title,
                'body' => $n_message,
                'image' => asset("storage/sponser/" . $campaign_banner),
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_ads',
                'banner_id' => $banner_id, //$banner_id,
                //'sound' => $sound, 
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
        \Log::info('Banner approve' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_ads', 'status' => 1]);

        return $res;
    }


    # Banner Lead Generated
    protected function lead_banner($banner_id)
    {

        $banner_update = DB::table('ads_banners')->where('id', $banner_id)->first();
        $banner_user_id = $banner_update->user_id;


        $user_details = DB::table('user')->select('id', 'name', 'mobile', 'firebase_token', 'lamguage')->where(['id' => $banner_user_id])->first();
        $id = $user_details->id;
        $name = $user_details->name;
        $mobile = $user_details->mobile;
        $firebase_token = $user_details->firebase_token;
        $lamguage = $user_details->lamguage;

        //sms...
        $message = 'Complete the steps to get Lead Generate your banner';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        //push notification..
        if ($lamguage == 1) {
            $n_title = 'Someone liked your Banner!';
            $n_message = "Congratulations! Your Banner is scoring leads! Tap to know the insights.";
        } elseif ($lamguage == 2) {
            $n_title = 'किसी को आपका बैनर पसंद आया!';
            $n_message = 'आपके बैनर पर बहुत ध्यान दिया जा रहा है! अधिक जानने के लिए यहां क्लिक करें!';
        } elseif ($lamguage == 3) {
            $n_title = 'কেউ আপনার ব্যানার পছন্দ করেছে!';
            $n_message = 'আপনার ব্যানার অনেকের নজর কাড়ছে! বিশদে এ ব্যাপারে জানতে এখানে ক্লিক করুন!';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_ads',
                'banner_id' => $banner_id, //$banner_id,
                //'sound' => $sound, 
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
        \Log::info('Banner Lead Generate' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);


        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_ads', 'status' => 1]);

        return $res;
    }

    # Product boost Lead Generated
    protected function lead_boost($post_id, $category_id, $user_id)
    {

        $seller_details = DB::table('seller_leads')->where('post_id', $post_id)->where('category_id', $category_id)->where('post_user_id', $user_id)->first();
        $user_id = $seller_details->post_user_id;

        $data = DB::table('user')->select('id', 'name', 'mobile', 'firebase_token', 'lamguage')->where('id', $user_id)->first();
        $id = $data->id;
        $name = $data->name;
        $mobile = $data->mobile;
        $firebase_token = $data->firebase_token;
        $lamguage = $data->lamguage;

        //sms...
        $message = 'Complete the steps to get Lead Generate your product';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);


        //push notification..
        if ($lamguage == 1) {
            $n_title = 'Knock! Knock! Customer at your door!';
            $n_message = "Your product is getting more and more likes! Check the potential buyers here.";
        } elseif ($lamguage == 2) {
            $n_title = 'अरे ग्राहक अब हाथ में है!';
            $n_message = 'आपका प्रोडक्ट सफलतापूर्वक लीड आकर्षित कर रहा है! अधिक जानने के लिए यहां टैप करें!';
        } elseif ($lamguage == 3) {
            $n_title = 'গ্রাহক এখন হাতের মুঠোয়!';
            $n_message = 'আপনার পণ্য সফলভাবে লিড আকর্ষণ করছে! আরও জানতে এখানে ট্যাপ করুন!';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_post',
                'post_id' => $post_id, //$banner_id,
                //'sound' => $sound, 
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
        \Log::info('Post Lead Generate' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_post', 'status' => 1]);

        return $res;
    }

    # Subscription Expiry / Cron Job : StatusUpdate
    protected function subcription_expiry($subcription_id)
    {


        $subcription_update = DB::table('subscribeds')->where('id', $subcription_id)->first();
        $subcription_user_id = $subcription_update->user_id;
        // dd($subcription_user_id);

        $user_details = DB::table('user')->select('id', 'name', 'mobile', 'lamguage', 'firebase_token')->where(['id' => $subcription_user_id])->first();
        $id = $user_details->id;
        $mobile = $user_details->mobile;
        $name = $user_details->name;
        $lamguage = $user_details->lamguage;
        $firebase_token = $user_details->firebase_token;

        //sms...
        $message = 'Your subscription plane has been expired. Please recharge your plane';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        $id = $subcription_user_id;

        //push notification...
        if ($lamguage == 1) {
            $n_title = 'Attention!!';
            $n_message = 'Dear user , your subscription plan is expired.';
        } elseif ($lamguage == 2) {
            $n_title = 'कृपया ध्यान दें!';
            $n_message = 'प्रिय ग्राहक,आपका सब्सक्रिप्शन प्लान समाप्त हो गया है!';
        } elseif ($lamguage == 3) {
            $n_title = 'অনুগ্রহ করে শুনবেন!';
            $n_message = 'প্রিয় গ্রাহক, আপনার সাবস্ক্রিপশান প্ল্যান শেষ হয়ে গেছে।';
        }


        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_subscription',
                'subcription_id' => $subcription_id,
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
        \Log::info('Subscription Expiry' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_subscription', 'status' => 1]);

        return $res;
    }

    # Subscribed Boost Expiry / Cron Job : subscribed_boosts_expiry
    protected function subscribed_boosts_expiry($subscribed_boosts_id)
    {

        $subcription_update = DB::table('subscribed_boosts')->where('id', $subscribed_boosts_id)->first();
        $subcription_user_id = $subcription_update->user_id;
        // dd($subcription_user_id);

        $user_details = DB::table('user')->select('id', 'name', 'mobile', 'lamguage', 'firebase_token')->where(['id' => $subcription_user_id])->first();
        $id = $user_details->id;
        $name = $user_details->name;
        $mobile = $user_details->mobile;
        $lamguage = $user_details->lamguage;
        $firebase_token = $user_details->firebase_token;

        //sms..
        $message = 'Your subscribed boosts plane has been expired. Please recharge your plane';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        $id = $subcription_user_id;

        //push notification..
        if ($lamguage == 1) {
            $n_title = 'Time to renew!!';
            $n_message = 'Your Product Boost Subscription has expired. Resume now to enjoy uninterrupted services.';
        } elseif ($lamguage == 2) {
            $n_title = 'आपका प्रोडक्ट बुस्ट सब्सक्रिप्शन समाप्त हो गया है!';
            $n_message = 'आपका प्रोडक्ट बुस्ट सब्सक्रिप्शन समाप्त हो गया है! निर्बाध सेवा का आनंद लेने के लिए आज ही सब्सक्राइब करें।';
        } elseif ($lamguage == 3) {
            $n_title = 'আপনার প্রোডাক্ট বুস্ট সাবস্ক্রিপশান শেষ!';
            $n_message = 'আপনার প্রোডাক্ট বুস্ট সাবস্ক্রিপশান শেষ হয়েছে! অবিচ্ছিন্ন পরিষেবা উপভোগ করতে আজই সাবস্ক্রাইব করুন।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        // $firebase_token = 'ceXgn5T-S-6omPfb5pWlnB:APA91bEZxi5GT8AWAS6-0j8t5QRlZKs9TnItvRaP01wmSYrjb9g6hJHuuRbyWYZb7o8Yf-5nsCQfD5PB3MTm2ZTCue4eWwZ2g1NTCR_k0v2xhjKGypimDtpq-bAVqJFSPD5hHhETKa8w';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_boost',
                'subcription_boosts_id' => $subscribed_boosts_id, //$banner_id,
                //'sound' => $sound, 
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
        \Log::info('Subscribed Boost Expiry' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_boost', 'status' => 1]);

        return $res;
    }

    # Seller post but not post Ads / Cron Job : n_sellerPost_not_Ads
    protected function n_seller_post_not_ads($mobile, $category_id)
    {
        $data = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $id = $data->id;
        $name = $data->name;
        $lamguage = $data->lamguage;
        $firebase_token = $data->firebase_token;


        if ($lamguage == 1) {
            $n_title = "Level up with Banner Ads!";
            $n_message = "Consider adding a banner ad , and see the magic of sales boost! Tap to learn more.";
        } elseif ($lamguage == 2) {
            $n_title = 'नहीं मिलेगा ये मौका!';
            $n_message = 'अधिक ग्राहक का अर्थ है अधिक लाभ! आज ही बैनर विज्ञापन पोस्ट करें और बड़ी संख्या में दर्शकों तक आसानी से पहुंचें।';
        } elseif ($lamguage == 3) {
            $n_title = 'এ সুযোগ পাবে না আর!';
            $n_message = 'বেশী পরিমানে খদ্দের অর্থাৎ বেশী মুনাফা! আজই ব্যানার অ্যাড পোস্ট করুন এবং অনায়াসে বিপুল সংখ্যক দর্শকের কাছে পৌঁছান।';
        }
        //push notification..
        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => array(
                $firebase_token,
            ),
            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'image' => '',
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/Home',
                'banner_id' => 2,
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
        \Log::info('Seller But Giving Ads--' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/Home', 'status' => 1]);
    }

    # Mahindra Enquiry
    protected function mahindra_enquiry($user_id)
    {
        // dd($user_id);
        $user_details = DB::table('user')->where('id', $user_id)->first();
        $firebase_token = $user_details->firebase_token;
        $user_id = $user_details->id;
        $lamguage = $user_details->lamguage;

        $title   = 'Attention! Mahindra inquiry!';
        $message = 'Mahindra Enquiry';

        if ($lamguage == 1) {
            $title = 'Attention! Mahindra inquiry!';
            $message = 'Dear user, your inquiry about the Mahindra product has been successfully submitted!';
        } elseif ($lamguage == 2) {
            $title = 'महिंद्रा एनक्वायरि!';
            $message = 'प्रिय ग्राहक,  महिंद्रा के प्रोडक्ट के बारे मैं आपका जिज्ञासा सफलतापूर्वक जमा कर दिया गया है।';
        } elseif ($lamguage == 3) {
            $title = 'মাহিন্দ্রা এনকোয়ারি!!';
            $message = 'প্রিয় গ্রাহক, মাহিন্দ্রার প্রোডাক্ট সম্পর্কিত আপনার প্রশ্নগুলি সফলভাবে জমা দেওয়া হয়েছে।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        $firebase_token = 'fx_1O0Icz0sYh7oF67Gl8i:APA91bEg4f8Lbkt771mjvbUQC6ahc-vBY8aEw7bU__ujvCXdYrhBZVLSChprHNaJCF7J0MXCeUseQvfum83P8-hF0BoDUrD-LD1PPBLU8yXcNwEbh48H2TTkXNoAfzIT1HU-dxewoSPa';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title'           => $title,
                'body'            => $message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action'    => 'OPEN_SPECIFIC_PAGE',
                'url'             => '/mahindra',
                'user_id'         => $user_id,
                'action'          => true,
                'badge'           => '1',
                'vibrate'         =>  1,
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
        \Log::info('Mahindra Enquiry' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        //Notification_save::insert(['ids'=>$user_id,'title'=>$title,'body'=>$message,'app_url'=>'/my_subscription','status'=>1]);
    }


    # Product Lead Generated
    protected function product_lead($post_user_id)
    {

        $user_details = DB::table('user')->select('id', 'name', 'mobile', 'firebase_token', 'lamguage')->where(['id' => $post_user_id])->first();
        $id             = $user_details->id;
        $name           = $user_details->name;
        $mobile         = $user_details->mobile;
        $firebase_token = $user_details->firebase_token;
        $lamguage       = $user_details->lamguage;

        //sms...
        $message = 'Congratulations! Your product is scoring leads! Tap to know the insights.';
        $encode_message = urlencode($message);

        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        //push notification..
        if ($lamguage == 1) {
            $n_title = 'Someone liked your product!';
            $n_message = "Congratulations! Your product is scoring leads! Tap to know the insights.";
        } elseif ($lamguage == 2) {
            $n_title = 'किसी को आपका उत्पाद पसंद आया!';
            $n_message = 'आपके पोस्ट किए गए प्रोडक्ट पर बहुत ध्यान दिया जा रहा है! अधिक जानने के लिए यहां क्लिक करें!';
        } elseif ($lamguage == 3) {
            $n_title = 'কেউ আপনার প্রোডাক্ট পছন্দ করেছে!';
            $n_message = 'আপনার পোস্ট করা প্রোডাক্ট অনেকের নজর কাড়ছে! বিশদে এ ব্যাপারে জানতে এখানে ক্লিক করুন!';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_ads',
                'user_id' => $post_user_id, //$banner_id,
                //'sound' => $sound, 
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
        \Log::info('Product Lead Generate' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);

        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_ads', 'status' => 1]);

        return $res;
    }

    # Boost Payment Offline
    protected function boostPaymentOffline($user_id)
    {
        // dd($user_id);
        $data = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token', 'mobile')->where(['id' => $user_id])->first();
        $id = $data->id;
        $name = $data->name;
        $lamguage = $data->lamguage;
        $firebase_token = $data->firebase_token;
        $mobile = $data->mobile;

        if ($lamguage == 1) {
            $n_title = 'Payment done successfully!';
            $n_message = ' Dear user, your payment for offline product boost has been done successfully!';
        } elseif ($lamguage == 2) {
            $n_title = 'पेमेंट सफल हुआ है!';
            $n_message = ' प्रिय ग्राहक, ऑफलाइन प्रोडक्ट बुस्ट के लिए आपका पेमेंट सफल हुआ है!';
        } elseif ($lamguage == 3) {
            $n_title = ' পেমেন্ট সফল হয়েছে!';
            $n_message = 'প্রিয় গ্রাহক, অফলাইন প্রোডাক্ট বুস্টের জন্য আপনার পেমেন্ট সফল হয়েছে!';
        }

        $message = 'Dear user, your payment for offline product boost on Krishi Vikas has been done successfully. Enjoy unlimited customers at your doorstep now!';
        $encode_message = urlencode($message);
        // dd($mobile);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);


        $id = DB::table('user')->where(['mobile' => $mobile])->value('id');
        $firebase_token = DB::table('user')->where(['mobile' => $mobile])->value('firebase_token');
        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(

                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/Home',
                //'sound' => $sound, 
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
        curl_close($ch);
        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/Home', 'status' => 1]);
        \Log::info("payment success" . $res);


        return $res;
    }


    # Crops 
    protected function cropApprovelPending($mobile, $category_id)
    {

        //sms..
        $message = 'Your subscription is now pending for approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        $data = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $id = $data->id;
        $firebase_token = $data->firebase_token;
        $name = $data->name;
        $lamguage = $data->lamguage;

        if ($lamguage == 1) {
            $n_title = 'Subscription is pending!!';
            $n_message = 'Hello ,Your post is pending approval. We’ll notify you shortly once it is approved.';
        } elseif ($lamguage == 2) {
            $n_title = 'आपका पोस्ट स्थगित कर दी गई है';
            $n_message = 'प्रिय ग्राहक, आपका/आपकी पोस्ट वर्तमान में स्थगित कर दी गई है। स्वीकृत होने पर आपको सूचित किया जाएगा.';
        } elseif ($lamguage == 3) {
            $n_title = 'আপনার পোস্ট মুলতুবী রাখা হয়েছে।';
            $n_message = 'প্রিয় গ্রাহক, আপনার পোস্টটি আপাতত মুলতুবী রাখা হয়েছে। অনুমোদিত হলে আপনাকে জানিয়ে দেওয়া হবে।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_post',
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
        \Log::info('Subscription Pending' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);
        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/getMyCrops', 'status' => 1]);

        return $res;
    }

    //# subscription crops payment
    protected function subscriptionPaymentForCrops($mobile, $name, $subscription_name, $transaction_id, $invoice_no, $purchased_price, $end_date)
    {

        //sms...
        $message = DB::table('sms')->where(['name' => 'transaction'])->where(['status' => 1])->value('value');
        //Dear {var1}, Thank you for subscribing to the {var2} on Krishi Vikas! Your payment was successful.
        // Transaction ID: {var3} Invoice Number: {var4} Amount: {var5} Validity: {var6} For support, contact us. Krishi Vikas!
        $message = str_replace('{var1}', $name, $message);
        $message = str_replace('{var2}', $subscription_name, $message);
        $message = str_replace('{var3}', $transaction_id, $message);
        $message = str_replace('{var4}', $invoice_no, $message);
        $message = str_replace('{var5}', $purchased_price, $message);
        $message = str_replace('{var6}', $end_date, $message);


        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        //push notification ...
        $data = DB::table('user')->select('id', 'name', 'lamguage', 'firebase_token')->where(['mobile' => $mobile])->first();
        $id = $data->id;
        $name = $data->name;
        $lamguage = $data->lamguage;
        $firebase_token = $data->firebase_token;

        if ($lamguage == 1) {
            $n_title = 'Bingo! Your payment is done!';
            $n_message = 'Dear User, your payment has been successfully made for the banner ad. Get the hold of buyers and grow your sales.';
        } elseif ($lamguage == 2) {
            $n_title = 'आपका पेमेंट सफल हो गया है!';
            $n_message = 'प्रिय ग्राहक, बैनर के लिए आपका पेमेंट सफल हुआ है। अब आसानी से मुनाफ़ा कमाएँ!';
        } elseif ($lamguage == 3) {
            $n_title = 'আপনার পেমেন্ট সফল হয়েছে!';
            $n_message = 'প্রিয় গ্রাহক, ব্যানারের জন্য আপনার পেমেন্ট সফল হয়েছে। এখন স্বচ্ছন্দে মুনাফা লাভ করুন!';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
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
        \Log::info('Subscription Payment' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);
        Notification_save::insert(['ids' => $id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my-crops', 'status' => 1]);
        return $res;
    }

    protected function offlinePaymentMembership($language, $coupon_code, $user_id, $mobile)
    {

        // dd($user_id);
        //sms...
        $message = DB::table('sms')->where(['name' => 'offline_package_active'])->where(['status' => 1])->value('value');


        $message = str_replace('{var1}', $coupon_code, $message);
        //dd($message);

        $encode_message = urlencode($message);
        //dd($encode_message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
       // dd($res);

        if ($language == 1) {
            $n_title = 'You are a member now!';
            $n_message = 'Dear user, you are successfully registered with us as a member. Your membership code is :' . $coupon_code;
        } elseif ($language == 2) {
            $n_title = 'अब से आप हैं कृषि विकास का मेम्बर!';
            $n_message = 'प्रिय ग्राहक,  आपको सफलतापूर्वक कृषि विकास के मेम्बर के तौर पर स्वीकारा गया है। आपका मेम्बरशिप कोड है :' . $coupon_code;
        } elseif ($language == 3) {
            $n_title = 'কৃষি বিকাশের মেম্বার হিসাবে আপনাকে স্বাগত!';
            $n_message = ' প্রিয় গ্রাহক, আপনি সফলতা পূর্বক কৃষি বিকাশের মেম্বার হিসাবে স্বীকৃত হয়েছেন। আপনার মেম্বারশিপ কোড হল : ' . $coupon_code . '।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        if (empty($firebase_token)) {
            $firebase_token = 'eXlce9g6SlKnl8WHlXBAOT:APA91bHJPd9u3zN-NRF4fjo8YFbo-3T-a3uiqHgnAy4TDZnOP_5aNNYOlSEHsJmWnD4A7uUCbkWaaTkhwdaok-HaMDm5Fh7vAryR4_3XjKTaV1PusQzvR9MyO9Z4xuJ03TuEDwdggc-O';
        }
        //$firebase_token = $user->firebase_token;
        $fields = array(
            'registration_ids' => array(
                // $user->firebase_token
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_post',
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

        \Log::info('Offline Membership Package' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);
        Notification_save::insert(['ids' => $user_id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_post', 'status' => 1]);
        return $res;
    }

    protected function dueClearOfflineMembership($language, $user_id, $firebase_token)
    {
        // dd($firebase_token);

        if ($language == 1) {
            $n_title = 'Complete your payment now!';
            $n_message = 'Dear user, you have not yet finished your payment. Complete payment to enjoy our services.';
        } elseif ($language == 2) {
            $n_title = 'अभी पेमेंट समाप्त करे!';
            $n_message = 'प्रिय ग्राहक, आपने अभी तक अपना पेमेंट पुरा नहीं किया है। हमारी सेवाओं का आनंद लेने के लिए अभी पेमेंट करें';
        } elseif ($language == 3) {
            $n_title = 'এখুনি পেমেন্ট শেষ করুন!';
            $n_message = 'প্রিয় গ্রাহক, আপনি এখনও আপনার পেমেন্ট সম্পূর্ণ করেননি। আমাদের পরিষেবা উপভোগ করার জন্য এখনই পেমেন্ট করুন।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';

        if (empty($firebase_token)) {
            $firebase_token = 'eXlce9g6SlKnl8WHlXBAOT:APA91bHJPd9u3zN-NRF4fjo8YFbo-3T-a3uiqHgnAy4TDZnOP_5aNNYOlSEHsJmWnD4A7uUCbkWaaTkhwdaok-HaMDm5Fh7vAryR4_3XjKTaV1PusQzvR9MyO9Z4xuJ03TuEDwdggc-O';
        }
        // dd($firebase_token);


        //$firebase_token = $user->firebase_token;
        $fields = array(
            'registration_ids' => array(
                // $user->firebase_token
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_post',
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

        \Log::info('Offline Membership Package' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);
        Notification_save::insert(['ids' => $user_id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_post', 'status' => 1]);
    }

    protected function offlineMembershipBufferDays($lamguage, $firebase_token, $days, $user_id,$mobile)
    {
        //sms...
        $message = DB::table('sms')->where(['name' => 'offline_package_buffer_days'])->where(['status' => 1])->value('value');
        $message = str_replace('{var1}', $days, $message);

        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        if ($lamguage == 1) {
            $n_title = 'Plan duration extended!';
            $n_message = 'Dear user, upon communicating with Krishi Vikas Team, we have extended the duration of your membership plan. Finish payment within'.$days.'days  to enjoy our services.';
        } elseif ($lamguage == 2) {
            $n_title = 'प्लान कि अवधि बढ़ा दी गई है!';
            $n_message = 'प्रिय ग्राहक, हमने कृषि विकास टीम से बात करने के बाद आपकी मेम्बरशिप प्लान अवधि बढ़ा दी है। निर्बाध सेवा का आनंद लेने के लिए'.$days.'दिन के भीतर  पेमेंट पूरा करें।';
        } elseif ($lamguage == 3) {
            $n_title = 'প্ল্যানের মেয়াদ বাড়ানো হয়েছে!';
            $n_message = 'প্রিয় গ্রাহক, কৃষি বিকাশ টিমের সাথে কথা বলে আমরা আপনার মেম্বারশিপ প্ল্যানের মেয়াদ বাড়িয়েছি। অবিচ্ছিন্ন পরিষেবা উপভোগ করতে'.$days.' দিনের মধ্যে পেমেন্ট সম্পূর্ণ করুন।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$firebase_token = 'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi';
        if (empty($firebase_token)) {
            $firebase_token = 'eXlce9g6SlKnl8WHlXBAOT:APA91bHJPd9u3zN-NRF4fjo8YFbo-3T-a3uiqHgnAy4TDZnOP_5aNNYOlSEHsJmWnD4A7uUCbkWaaTkhwdaok-HaMDm5Fh7vAryR4_3XjKTaV1PusQzvR9MyO9Z4xuJ03TuEDwdggc-O';
        }
        $fields = array(
            'registration_ids' => array(
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
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
        \Log::info('Subscription Payment' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);
        Notification_save::insert(['ids' => $user_id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my-crops', 'status' => 1]);

        return $res;
    }

    protected function offlineMembershipExpired($language, $firebase_token,$user_id,$mobile,$package_name){
       
        //sms...
        $message = DB::table('sms')->where(['name' => 'offline_package_expire'])->where(['status' => 1])->value('value');
        
        $message = str_replace('{var1}', $package_name, $message);

        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=' . $this->api_key . '&senderid=' . $this->sender_id . '&number=' . $mobile . '&message=' . $encode_message . '&format=json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

       // dd($user_id);
        if ($language == 1) {
            $n_title = 'Your membership plan has expired!';
            $n_message = 'Dear user, your membership plan has expired! Recharge now to enjoy uninterrupted services.';
        } elseif ($language == 2) {
            $n_title = 'आपका मेम्बरशिप प्लान समाप्त हुआ है!';
            $n_message = ' प्रिय ग्राहक,  आपके मेम्बरशिप प्लान कि अवधि समाप्त हो चुका है। हमारे सेवाओं का लाभ उठाने के लिए आज ही रिचार्ज करें।';
        } elseif ($language == 3) {
            $n_title = 'আপনার মেম্বারশিপ প্ল্যানের মেয়াদ সমাপ্ত হয়েছে!';
            $n_message = 'প্রিয় গ্রাহক,  আপনার মেম্বারশিপ প্ল্যানের মেয়াদ শেষ হয়েছে। অবিচ্ছিন্ন পরিষেবা উপভোগ করতে আজই রিচার্জ করুন।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';

        if (empty($firebase_token)) {
            $firebase_token = 'eXlce9g6SlKnl8WHlXBAOT:APA91bHJPd9u3zN-NRF4fjo8YFbo-3T-a3uiqHgnAy4TDZnOP_5aNNYOlSEHsJmWnD4A7uUCbkWaaTkhwdaok-HaMDm5Fh7vAryR4_3XjKTaV1PusQzvR9MyO9Z4xuJ03TuEDwdggc-O';
        }

        $fields = array(
            'registration_ids' => array(
                // $user->firebase_token
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_post',
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

        \Log::info('Offline Membership Package' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);
        Notification_save::insert(['ids' => $user_id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_post', 'status' => 1]);

        return $res;
    }

    protected function offlineMembershipDueClear($language, $firebase_token,$user_id,$mobile){
       
        // dd($user_id);
        if ($language == 1) {
            $n_title = 'Complete your payment now!';
            $n_message = 'Dear user, you have not yet finished your payment. Complete payment to enjoy our services.';
        } elseif ($language == 2) {
            $n_title = 'अभी पेमेंट समाप्त करे!';
            $n_message = 'प्रिय ग्राहक, आपने अभी तक अपना पेमेंट पुरा नहीं किया है। हमारी सेवाओं का आनंद लेने के लिए अभी पेमेंट करें';
        } elseif ($language == 3) {
            $n_title = 'এখুনি পেমেন্ট শেষ করুন!';
            $n_message = ' প্রিয় গ্রাহক, আপনি এখনও আপনার পেমেন্ট সম্পূর্ণ করেননি। আমাদের পরিষেবা উপভোগ করার জন্য এখনই পেমেন্ট করুন।';
        }

        $url = 'https://fcm.googleapis.com/fcm/send';

        if (empty($firebase_token)) {
            $firebase_token = 'eXlce9g6SlKnl8WHlXBAOT:APA91bHJPd9u3zN-NRF4fjo8YFbo-3T-a3uiqHgnAy4TDZnOP_5aNNYOlSEHsJmWnD4A7uUCbkWaaTkhwdaok-HaMDm5Fh7vAryR4_3XjKTaV1PusQzvR9MyO9Z4xuJ03TuEDwdggc-O';
        }

        $fields = array(
            'registration_ids' => array(
                // $user->firebase_token
                $firebase_token
            ),

            'data' => array(
                'title' => $n_title,
                'body' => $n_message,
                'notification_id' => rand(1000, 9999) . strtotime('Y-m-d H:i:s'),
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/my_post',
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

        \Log::info('Offline Membership Package' . $result . ' ftkn-' . $firebase_token);
        curl_close($ch);
        Notification_save::insert(['ids' => $user_id, 'title' => $n_title, 'body' => $n_message, 'app_url' => '/my_post', 'status' => 1]);

        
    }
}
