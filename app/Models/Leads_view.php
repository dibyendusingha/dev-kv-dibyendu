<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Leads_view extends Model
{
    use HasFactory;
    // protected $table = 'seller_leads';
    
     protected $fillable = [
        'user_id',
        'post_user_id',
        'category_id',
        'post_id',
        'created_at',
        'updated_at'
        ];
}
