<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SeasonCrop;

class Season extends Model
{
    use HasFactory;

    protected $table ='season_table';

    protected $fillable = [
        'id',
        'name',
        'image',
        'status'
    ];

    public function get_season()
    {
        return $this->hasMany(SeasonCrop::class);
    }


}
