<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahindra\Mahindra;
use DB;
use Carbon\Carbon;


class MahindraCompany extends Controller
{
    # Mahindra Index Page
    public function index_page_show(){
        $all_lead = DB::table('mahindra_enquiry')->count();
        $currentDate = now()->toDateString();
        $new_lead = DB::table('mahindra_enquiry')->whereDate('created_at', $currentDate)->count();
        $hot_lead = DB::table('mahindra_enquiry')->where('lead_status','=','Within 30 Days')->count();
        $warm_lead = DB::table('mahindra_enquiry')->where('lead_status','=','Within 30 to 90 Days')->count();
        $cold_lead = DB::table('mahindra_enquiry')->where('lead_status','=','More than 90 Days')->count();
        $top_lead =DB::table('mahindra_enquiry as a')
                    ->select('a.*','b.name as model_name')
                    ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                    ->orderBy('a.id', 'desc')->limit(10)
                    ->get();
        return view('mahindra.index',['all_lead'=>$all_lead,'new_lead'=>$new_lead,'hot_lead'=>$hot_lead,
                'warm_lead'=>$warm_lead,'cold_lead'=>$cold_lead,'top_lead'=>$top_lead]);
    }

    # Mahindra All Lead Page
    public function all_lead_page_show(){
        $all_data = DB::table('mahindra_enquiry as a')
                    ->select('a.*','b.name as model_name')
                    ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                    //->get();
                    ->paginate(15);

        $mahindra_details = DB::table('mahindra')->get();
        
        return view('mahindra.all_lead',['all_data'=>$all_data ,'mahindra_details'=>$mahindra_details]);
    }

    # Mahindra New Lead Page
    public function new_lead_page_show(){
        $currentDate = now()->toDateString();
        $new_lead = DB::table('mahindra_enquiry as a')
            ->select('a.*', 'b.name as model_name')
            ->leftJoin('mahindra as b', 'b.id', '=', 'a.mahindra_id')
            ->whereDate('a.created_at', $currentDate)
            ->get();

        $mahindra_details = DB::table('mahindra')->get();
        return view('mahindra.new_lead',['new_lead'=>$new_lead , 'mahindra_details'=>$mahindra_details]);
    }

    # Mahindra Hot Lead Page
    public function hot_lead_page_show(){
        $hot_lead = DB::table('mahindra_enquiry as a')
            ->select('a.*', 'b.name as model_name')
            ->leftJoin('mahindra as b', 'b.id', '=', 'a.mahindra_id')
            ->whereIn('a.lead_status',['Within 30 Days', '30 दिन के भीतर','30 দিনের মধ্যে'])
            ->get();

        $mahindra_details = DB::table('mahindra')->get();
        return view('mahindra.hot_lead',['hot_lead'=>$hot_lead , 'mahindra_details'=>$mahindra_details]);
    }

    # Mahindra Warm Lead Page
    public function warm_lead_page_show(){
        $warm_lead = DB::table('mahindra_enquiry as a')
            ->select('a.*', 'b.name as model_name')
            ->leftJoin('mahindra as b', 'b.id', '=', 'a.mahindra_id')
            ->where('a.lead_status','=','Within 30 to 90 Days')
            ->get();

            $mahindra_details = DB::table('mahindra')->get();
            
        return view('mahindra.warm_lead',['warm_lead'=>$warm_lead ,'mahindra_details'=>$mahindra_details]);
    }

    # Mahindra Warm Lead Page
    public function cold_lead_page_show(){
        $cold_lead = DB::table('mahindra_enquiry as a')
            ->select('a.*', 'b.name as model_name')
            ->leftJoin('mahindra as b', 'b.id', '=', 'a.mahindra_id')
            ->where('a.lead_status','=','More than 90 Days')
            ->get();

            $mahindra_details = DB::table('mahindra')->get();

        return view('mahindra.cold_lead',['cold_lead'=>$cold_lead , 'mahindra_details'=>$mahindra_details]);
    }

    # Mahindra Login Page
    public function login_page_show(){
        return view('mahindra.mahindra_login');
    }

    public function mahindra_login (Request $request) {
       // dd($request->all());
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
          ]);
        $username = $request->username;
        $password = $request->password;
        //$request->session()->put('admin-krishi-mahindra', $username);
        $count = DB::table('admin')->where(['first_name'=>'mahindra','username'=>$username,'password'=>$password,'status'=>1])->count();
        //dd($count);
        if ($count>0) {
            session()->put('admin-krishi-mahindra',$username);
            return redirect('mahindra-dasboard')->with('success','Login Successfully');
        } else {
            return redirect('mahindra-login')->with('failed','Login Failed');
        }
    }

    public function mahindra_logout (){
        session()->flush();
        return redirect('mahindra-login');
    }


    public function all_product (Request $request) {
        $new = [];
        $user_id = auth()->user()->id; 

        //dd("User id: ".$user_id);
        $data = DB::table('mahindra')->get();
        foreach ($data as $val) {
            $arr['id']               = $val->id;
            $arr['category']         = $val->category;
            $arr['name']             = $val->name;
            $arr['engine_power']     = $val->engine_power;
            $arr['maximum_PTO_Power']= $val->maximum_PTO_Power;
            $arr['cylinders']        = $val->cylinders;
            $arr['file']             = asset('storage/mahindra/'.$val->file);
            $count = DB::table('mahindra_enquiry')->where(['user_id'=>$user_id,'mahindra_id'=>$val->id])
            ->count();
            if ($count>0) {
                $arr['lead']         = 1;
            } else {
                $arr['lead']         = 0;
            }
            $arr['created_at']       = $val->created_at;
            $arr['updated_at']       = $val->updated_at;

            

            $new[] = $arr;

        }
        $output['response']     = true;
        $output['message']      = 'Data';
        $output['data']         = $new;
        $output['status_code']  = 200;
        $output['error']        = '';

        return $output;
    }

    public function add_lead (Request $request) {
        $user_id = auth()->user()->id;
        $mahindra_id = $request->mahindra_id;
        $name = $request->name;
        $mobile = $request->mobile;
        $district = $request->district;
        $state = $request->state;
        $pincode = $request->pincode;
        $lead_status = $request->lead_status;
        $created_at = $request->created_at;
        $insert = DB::table('mahindra_enquiry')->insert([
            'user_id'       => $user_id,
            'mahindra_id'   =>$mahindra_id,
            'name'          => $name,
            'mobile'        => $mobile,
            'district'      => $district,
            'state'         => $state,
            'pincode'       => $pincode,
            'lead_status'   => $lead_status,
            'created_at'    => $created_at 
        ]);

        $output['response']     = true;
        $output['message']      = 'Lead Generate Successfully';
        $output['data']         = $insert;
        $output['status_code']  = 201;
        $output['error']        = '';

        return $output;
    }

    public function user_feedback_save (Request $request) {
        $user_id = auth()->user()->id;
        $mahindra_id = $request->mahindra_id;
        $feedback = $request->feedback;
        $insert = DB::table('mahindra_feedback')->insert([
            'user_id'=>$user_id,
            'mahindra_id'=>$mahindra_id,
            'feedback'=>$feedback,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $output['response']     = true;
        $output['message']      = 'Inserted Successfully';
        $output['data']         = $insert;
        $output['status_code']  = 201;
        $output['error']        = '';

        return $output;

    }


    # Filter All Leads
    public function filter_all_leads(Request $request) {
     // dd($request->all());

        try{
            if($request->startDate == null && $request->endDate == null && $request->mahindra_id == null){
               // dd($request->status);
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.lead_status',$request->status)
                           ->get();
                           // ->paginate(10); 
            }    
            else if($request->startDate == null && $request->endDate == null && $request->status == null){
               // dd($request->mahindra_id);
                    $get_filter = DB::table('mahindra_enquiry as a')
                    ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                                ->where('a.mahindra_id',$request->mahindra_id)
                                ->get();
                                //->paginate(10); 
            }
            else if($request->startDate == null && $request->endDate == null){
                //dd("hi");
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.mahindra_id',$request->mahindra_id)
                            ->where('a.lead_status',$request->status)
                            ->get();
                            //->paginate(10);              
            }
            else if($request->status == null && $request->mahindra_id == null ){
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->whereBetween('a.created_at',[$request->startDate,$request->endDate])
                            ->get();
                            //->paginate(10); 
            }
            else{
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.mahindra_id',$request->mahindra_id)
                            ->where('a.lead_status',$request->status)
                            ->whereBetween('a.created_at',[$request->startDate,$request->endDate])
                            ->get();
                            // ->paginate(10);              
            }
            //dd($get_filter);

           $mahindra_details = DB::table('mahindra')->get();

           return view('mahindra.all_lead',['all_data1'=>$get_filter,'mahindra_details'=>$mahindra_details]);

        }catch(\Exception $e){
            return [
                'success' => false,
                'message' => $e
            ];

        }

       


    }

    # Filter New Leads
    public function filter_new_leads(Request $request) {
        
        // dd($request->all());
        $now = Carbon::now()->format('Y-m-d');
      //  dd($now);

        try{
            if($request->startDate == null && $request->endDate == null && $request->mahindra_id == null){
                //dd($request->status);
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.lead_status',$request->status)
                            ->whereDate('a.created_at',$now)
                            ->get();
                            // ->paginate(10); 
            }    
            else if($request->startDate == null && $request->endDate == null && $request->status == null){
                // dd($request->mahindra_id);
                    $get_filter = DB::table('mahindra_enquiry as a')
                    ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                                ->where('a.mahindra_id',$request->mahindra_id)
                                ->whereDate('a.created_at',$now)
                                ->get();
                                //->paginate(10); 
            }
            else if($request->startDate == null && $request->endDate == null){
                //dd("hi");
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.mahindra_id',$request->mahindra_id)
                            ->where('a.lead_status',$request->status)
                            ->whereDate('a.created_at',$now)
                            ->get();
                            //->paginate(10);              
            }
            else if($request->status == null && $request->mahindra_id == null ){
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->whereDate('a.created_at',$now)
                            ->get();
                            //->paginate(10); 
            }
            else{
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.mahindra_id',$request->mahindra_id)
                            ->where('a.lead_status',$request->status)
                            ->whereDate('a.created_at',$now)
                            ->get();
                            // ->paginate(10);              
            }
           // dd($get_filter);

            $mahindra_details = DB::table('mahindra')->get();

            return view('mahindra.all_lead',['all_data1'=>$get_filter,'mahindra_details'=>$mahindra_details]);

        }catch(\Exception $e){
            return [
                'success' => false,
                'message' => $e
            ];

        }

    }
    

    # Filter Hot Leads
    public function filter_hot_leads(Request $request) {
       // dd($request->all());
        try{
            if($request->startDate == null && $request->endDate == null && $request->mahindra_id == null){
                // dd($request->status);
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.lead_status','Within 30 Days')
                            ->get();
                            // ->paginate(10); 
            }    
            else if($request->startDate == null && $request->endDate == null && $request->status == null){
                // dd($request->mahindra_id);
                    $get_filter = DB::table('mahindra_enquiry as a')
                    ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                                ->where('a.mahindra_id',$request->mahindra_id)
                                ->where('a.lead_status','Within 30 Days')
                                ->get();
                                //->paginate(10); 
            }
            else if($request->startDate == null && $request->endDate == null){
                //dd("hi");
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.mahindra_id',$request->mahindra_id)
                            ->where('a.lead_status','Within 30 Days')
                            ->get();
                            //->paginate(10);              
            }
            else if($request->status == null && $request->mahindra_id == null ){
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->whereBetween('a.created_at',[$request->startDate,$request->endDate])
                            ->where('a.lead_status','Within 30 Days')
                            ->get();
                            //->paginate(10); 
            }
            else{
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.mahindra_id',$request->mahindra_id)
                            ->where('a.lead_status','Within 30 Days')
                            ->whereBetween('a.created_at',[$request->startDate,$request->endDate])
                            ->get();
                            // ->paginate(10);              
            }
            //dd($get_filter);

            $mahindra_details = DB::table('mahindra')->get();

            return view('mahindra.hot_lead',['all_data1'=>$get_filter,'mahindra_details'=>$mahindra_details]);
           

        }catch(\Exception $e){
            return [
                'success' => false,
                'message' => $e
            ];

        }

    }

    # Filter Warm Leads
    public function filter_warm_leads(Request $request) {
        //dd($request->all());
   
        try{
            if($request->startDate == null && $request->endDate == null && $request->mahindra_id == null){
                // dd($request->status);
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.lead_status','Within 30 to 90 Days')
                            ->get();
                            // ->paginate(10); 
            }    
            else if($request->startDate == null && $request->endDate == null && $request->status == null){
                // dd($request->mahindra_id);
                    $get_filter = DB::table('mahindra_enquiry as a')
                    ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                                ->where('a.mahindra_id',$request->mahindra_id)
                                ->where('a.lead_status','Within 30 to 90 Days')
                                ->get();
                                //->paginate(10); 
            }
            else if($request->startDate == null && $request->endDate == null){
                //dd("hi");
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.mahindra_id',$request->mahindra_id)
                            ->where('a.lead_status','Within 30 to 90 Days')
                            ->get();
                            //->paginate(10);              
            }
            else if($request->status == null && $request->mahindra_id == null ){
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->whereBetween('a.created_at',[$request->startDate,$request->endDate])
                            ->where('a.lead_status','Within 30 to 90 Days')
                            ->get();
                            //->paginate(10); 
            }
            else{
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.mahindra_id',$request->mahindra_id)
                            ->where('a.lead_status','Within 30 to 90 Days')
                            ->whereBetween('a.created_at',[$request->startDate,$request->endDate])
                            ->get();
                            // ->paginate(10);              
            }
            //dd($get_filter);

            $mahindra_details = DB::table('mahindra')->get();

            return view('mahindra.warm_lead',['all_data1'=>$get_filter,'mahindra_details'=>$mahindra_details]);
           

        }catch(\Exception $e){
            return [
                'success' => false,
                'message' => $e
            ];

        }

    }

    # Filter Cold Leads
    public function filter_cold_leads(Request $request) {
        //dd($request->all());
   
        try{
            if($request->startDate == null && $request->endDate == null && $request->mahindra_id == null){
                // dd($request->status);
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.lead_status','More than 90 Days')
                            ->get();
                            // ->paginate(10); 
            }    
            else if($request->startDate == null && $request->endDate == null && $request->status == null){
                // dd($request->mahindra_id);
                    $get_filter = DB::table('mahindra_enquiry as a')
                    ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                                ->where('a.mahindra_id',$request->mahindra_id)
                                ->where('a.lead_status','More than 90 Days')
                                ->get();
                                //->paginate(10); 
            }
            else if($request->startDate == null && $request->endDate == null){
                //dd("hi");
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.mahindra_id',$request->mahindra_id)
                            ->where('a.lead_status','More than 90 Days')
                            ->get();
                            //->paginate(10);              
            }
            else if($request->status == null && $request->mahindra_id == null ){
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->whereBetween('a.created_at',[$request->startDate,$request->endDate])
                            ->where('a.lead_status','More than 90 Days')
                            ->get();
                            //->paginate(10); 
            }
            else{
                $get_filter = DB::table('mahindra_enquiry as a')
                            ->select('a.*','b.name as model_name')
                            ->leftJoin('mahindra as b','b.id','=','a.mahindra_id')
                            ->where('a.mahindra_id',$request->mahindra_id)
                            ->where('a.lead_status','More than 90 Days')
                            ->whereBetween('a.created_at',[$request->startDate,$request->endDate])
                            ->get();
                            // ->paginate(10);              
            }
            //dd($get_filter);

            $mahindra_details = DB::table('mahindra')->get();

            return view('mahindra.cold_lead',['all_data1'=>$get_filter,'mahindra_details'=>$mahindra_details]);

        }catch(\Exception $e){
            return [
                'success' => false,
                'message' => $e
            ];

        }

    }

    /** Website Mahindra all product show */
    public function mahindra_all_product_show(Request $request)
    {
       // dd($request->all());
        $skip  = $request->skip;
        $limit = $request->limit ;
        $mahindra = DB::table('mahindra')->limit($limit)->offset($skip)->get();
      
        return  $mahindra;
    }

    public function all_product_list_mahindra(){
        $mahindra = DB::table('mahindra')->get();
        return  $mahindra;

    }

}
