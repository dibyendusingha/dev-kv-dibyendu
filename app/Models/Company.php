<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Company extends Model
{
    use HasFactory;

    protected $table ='company';

    protected $fillable = [
        'id',
        'name',
        'category',
        'logo',
        'description',
        'status'
    ];
    
    /** Dibyendu Change 01.09.2023 */
    public function get_category()
    {
        return $this->belongsTo(Category::class,'category');
    }


}
