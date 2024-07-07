<?php

namespace App\Models\Subscription;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Subscription extends Model
{
    use HasFactory;

    protected function getFinancialYear($inputDate,$format="Y"){
        $date=date_create($inputDate);
        if (date_format($date,"m") >= 4) {//On or After April (FY is current year - next year)
            $financial_year = (date_format($date,$format)) . '-' . (date_format($date,$format)+1);
        } else {//On or Before March (FY is previous year - current year)
            $financial_year = (date_format($date,$format)-1) . '-' . date_format($date,$format);
        }
    
        return $financial_year;
        //return '23-24';
    } 

    

}
