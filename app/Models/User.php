<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'user';
    
     protected $fillable = [
         'id',
        'user_type_id',
        'role_id',
        'name',
        'company_name',
        'gst_no',
        'mobile',
        'email',
        'facebook_id',
        'google_id',
        'gender',
        'address',
        'country_id',
        'state_id',
        'district_id',
        'city_id',
        'zipcode',
        'lat',
        'long',
        'photo',
        'dob',
        'latlong',
        'referral_code',
        'login_via',

        'phone_verified',
        'email_verified',
        'whatsapp_optin',
        'newsletter_optin',
        'sms_optin',
        'marketing_optin',
        'kyc',
        'ip_address',
        'device_id',
        'firebase_token',
        'user_source',
        'reference_id',
        'converted_seller',
        'paid_or_free',
        'token',
        'status',
        'profile_update',
        'email_newslatter',
        'whatsapp_notification',
        'promotin',
        'marketing_communication',
        'social_media_promotion',
        'last_activity',
        'last_login',
        'created_at',
        'updated_at',
        'user_disabled_date',
        'lamguage',
        'company_id',
        'notification_counter',
        'user_type'
        ];
        protected $hidden = [
            'password',
            'remember_token',
        ];

        /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
}
