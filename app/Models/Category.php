<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Category extends Model
{
    use HasFactory;

    protected $table ='category';

    protected $fillable = [
        'id',
        'sequence',
        'category',
        'icon',
        'status',
        'ln_bn',
        'ln_hn'
    ];
    
    /** Dibyendu Change 01.09.2023 */
    public function get_category()
    {
        return $this->hasMany(Company::class);
    }
}
