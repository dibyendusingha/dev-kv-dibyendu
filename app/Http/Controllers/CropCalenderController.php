<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\DB;
use App\Models\SeasonCrop;
use App\Models\Season;

class CropCalenderController extends Controller
{


    /** Show Company Page */
    public function company_page_show(){
        return view('admin.company.add-company');
    }

    /** Show Dealer Company Page */
    public function dealer_company_page_show(){
        return view('admin.company.dealer-company');
    }

    /** Show Dealer Product Page */
    public function dealer_product_page_show(){
        return view('admin.company.dealer-product');
    }

    /** Show Season Page */
    public function season_page_show(){
        return view('admin.crop_calendar.season');
    }

     /** Show Season Edit Page */
     public function season_edit_page_show(){
        return view('admin.crop_calendar.season-edit');
    }

    /** Show Season Crop Page */
    public function season_crop_page_show(){
        return view('admin.crop_calendar.season-crop');
    }

    /** Show Season Crop Edit Page */
    public function season_crop_edit_page_show(){
        return view('admin.crop_calendar.season-crop-edit');
    }


    /** Season Add Data */
    public function addSeasons(Request $request){
       // dd($request->all());
        $request->validate([
            'season_name' => 'required'
        ]);
        if ($request->hasFile('image')) {

            $request->validate([
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            $request->image->store('crop_calender','public');
            $season = new Season([
                "name" => $request->get('season_name'),
                "image" => $request->image->hashName(),
                "status" => 1,
            ]);
            $season->save();
        }
        return Redirect::to("krishi-season-list");
    }


    /** Read Season Data */
    public function readSeason(){
        $season_data = Season::where('status',1)->get();
        //dd($season_data);
        return view('admin.crop_calendar.season',['season_data'=>$season_data]);
    }


    /** Season Delete */
    public function seasonDelete($seasonId){
        $seasonData = Season::where(['id'=>$seasonId])->first();
        if(!empty($seasonData)){
            $seasonDelete = Season::where(['id'=>$seasonId])->first();
            $seasonDelete->status = 0;
            $seasonDelete->update();

            return Redirect::to("krishi-season-list");
        }
        else {
            return array('msg'=>['Cannot Deleted Season']);
        }
    }


    /** Season Edit */
    public function seasonEdit($seasonId){
       // dd($seasonId);
        //dd($seasonId);
        $season_data = Season::get();
        $season_edit = Season::where(['id'=>$seasonId])->first();
        //dd( $season_edit);

        return view('admin.crop_calendar.season-edit', compact('season_edit','season_data'));
    }


    /** Season Update */
    public function seasonUpdate(Request $request , $seasonId){
       // dd($seasonId);
        $this->validate($request, [
            'season_name' => 'required'
        ]);

        if ($request->hasFile('image') || $request->image == '') {
            $request->validate([
                'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            if(!empty($request->image)){
                $request->image->store('crop_calender','public');
            }


            $season_Update = Season::where(['id'=>$seasonId])->first();

            $season_Update->name = $request->season_name;
            if(!empty($request->image)){
                $season_Update->image = $request->image->hashName();
            }
            $season_Update->update();

            return redirect('/krishi-season-list');
        }

    }



    /** Season Crop Add Data */
    public function addSeasonCrop(Request $request){
       // dd($request->all());

        $request->validate([
            'season_id' => 'required',
            'cropName'  => 'required',
            'image'     => 'required',
        ]);

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            $request->image->store('crop_calender','public');
        }

        try{
            DB::beginTransaction();

            $addSeasonCrop = new SeasonCrop;

            $addSeasonCrop->season_id        = $request->season_id;
            $addSeasonCrop->cropName         = $request->cropName;
            $addSeasonCrop->image            = $request->image->hashName();
            $addSeasonCrop->status           = 1;
            $addSeasonCrop->save();

            DB::commit();

            return Redirect::to("krishi-season-crop-calender-list") ;

        }catch(\Exception $e){
            DB::rollBack();
            return array('success' => false, 'msg'=>['Error']);
        }


    }

     /** Read Season Crop Data */
    public function getSeasonCropData(){
        $season_crop_data = SeasonCrop::where('status',1)->with('get_season')->get();
        $season_all_data = Season::where('status',1)->get();
        return view('admin.crop_calendar.season-crop',['season_crop_data'=>$season_crop_data,'season_all_data'=>$season_all_data]);
    }

    /** Delete Season Crop Data */
    public function seasonCropDelete($seasonId){
        $seasonData = SeasonCrop::where(['id'=>$seasonId])->first();
       // dd($seasonData);
            if(!empty($seasonData)){
                $seasonCropDelete = SeasonCrop::where(['id'=>$seasonId])->first();
                $seasonDelete     = Season::where(['id'=>$seasonCropDelete->season_id])->first();
               // dd($seasonDelete);
                $seasonDelete->status = 0;
                $seasonDelete->Update();

                $seasonCropDelete->status = 0;
                $seasonCropDelete->update();

                return Redirect::to("krishi-season-crop-calender-list");
            }
            else {
                return array('msg'=>['Cannot Deleted Season']);
            }
    }

    /** Season Crop Edit */
    public function seasonCropEdit($seasonId){

        $season_data  = Season::where('status',1)->get();
        $season_crop_data = SeasonCrop::where('status',1)->with('get_season')->get();
        $season_Crop_edit = SeasonCrop::with('get_season')->where(['id'=>$seasonId])->first();
        //dd( $season_edit);

        return view('admin.crop_calendar.season-crop-edit', compact('season_Crop_edit','season_crop_data','season_data'));
    }


    /** Season Crop Update */
    public function seasonCropUpdate(Request $request , $seasonId){
         //dd($seasonId);
         $this->validate($request, [
            'season_id' => 'required',
            'cropName'  => 'required',
         ]);

         if ($request->hasFile('image') || $request->image == '') {
             $request->validate([
                 'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
             ]);
             if(!empty($request->image)){
                 $request->image->store('crop_calender','public');
             }


             $season_crop_Update = SeasonCrop::where(['id'=>$seasonId])->first();

             $season_crop_Update->season_id = $request->season_id;
             $season_crop_Update->cropName  = $request->cropName;
             if(!empty($request->image)){
                $season_crop_Update->image = $request->image->hashName();
             }
             $season_crop_Update->update();

            return redirect('/krishi-season-crop-calender-list');
         }

     }

}
