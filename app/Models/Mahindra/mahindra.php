<?php

namespace App\Models\Mahindra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahindra extends Model
{
    protected $table = 'mahindra';
    protected $fillable = ['id','category','name','engine_power','maximum_PTO_Power','cylinders','file','created_at','updated_at'];
    use HasFactory;
    
}
