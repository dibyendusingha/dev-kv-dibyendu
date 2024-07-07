<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification_save extends Model
{
    use HasFactory;
    protected $table = 'notification_saves'; // If the table name doesn't follow Laravel's conventions

    protected $fillable = ['id','ids', 'title', 'body', 'status', 'app_url', 'banner_id','category_id','post_id','image','created_at','updated_at'];

}
