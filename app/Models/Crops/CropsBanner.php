<?php

namespace App\Models\Crops;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CropsBanner extends Model
{
    use HasFactory;

    protected function addCropBanner($crop_data){
        // dd($crop_data);
        $insert_crops = DB::table('crops_banners')->insertGetId($crop_data);
        return true;
    }
}
