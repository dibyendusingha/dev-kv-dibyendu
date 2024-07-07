<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineLead extends Model
{
    use HasFactory;
    protected $table = 'offline_leads';
    protected $fillable = [
        'username',
        'mobile', 
        'zipcode', 
        'post_id',
        'category_id',
        'user_id',
        'created_at', 
        'updated_at'
    ];
}
