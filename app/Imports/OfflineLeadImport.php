<?php

namespace App\Imports;

use App\Models\OfflineLead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class OfflineLeadImport implements ToModel , WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new OfflineLead([
            'username'      => $row['username'],
            'mobile'        => $row['mobile'], 
            'zipcode'       => $row['zipcode'],
            'post_id'       => 0,
            'category_id'   => 0,
            'user_id'       => 0,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }
}
