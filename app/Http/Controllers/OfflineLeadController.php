<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\OfflineLeadImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\OfflineLead;

class OfflineLeadController extends Controller
{
    public function addOfflineLead(Request $request, $category_id, $post_id,$user_id)
    {
       // dd($request->all());
        //dd($category_id);
        // dd($post_id);

        $request->validate([
            'excelFile' => 'required|mimes:xlsx,xls|max:20240',
        ]);

        $file = $request->file('excelFile');
        // dd($file);

        Excel::import(new OfflineLeadImport, $file);
        // (new OfflineLeadImport)->import($file);
        //dd("hi");

        $offline_lead = OfflineLead::where(['post_id' => 0, 'category_id' => 0 , 'user_id' => 0])->get();
        foreach ($offline_lead as $key => $lead) {
            $offline_lead = OfflineLead::where('id', $lead->id)->update(['post_id' => $post_id, 'category_id' => $category_id , 'user_id' => $user_id]);
        }

        return redirect()->back()->with('success', 'Excel data imported successfully.');
    }
}
