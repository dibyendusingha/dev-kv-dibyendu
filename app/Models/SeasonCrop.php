<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Season;

class SeasonCrop extends Model
{
    use HasFactory;

    protected $table = 'season_crop_table';

    protected $fillable = [
        'id',
        'season_id',
        'cropName',
        'status'
    ];

    public function get_season()
    {
      return $this->belongsTo(Season::class,'season_id');
    }
}
