<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Api_model extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_user_id',
        'category_id',
        'post_id',
        'calls_status',
        'messages_status',
        'wishlist',
        'share',
        'status',
        'post_click_count',
        ];
    
    protected $table = 'seller_leads';
}
