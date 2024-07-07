<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Category;
use App\Models\User;
use Redirect;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{

    public function company_page_show(){
        return view('admin.company.add-company');
    }

    public function company_edit_page_show(){
        return view('admin.company.edit-company');
    }

    /** Add Company Data */
    public function addCompany(Request $request){
       // dd($request->all());

         $request->validate([
             'name'     => 'required',
             'brand_name_full' =>'required',
             'category' => 'required'
         ]);
        //  if ($request->hasFile('logo')) {

             $request->validate([
                 'logo' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
             ]);
            //  $request->logo->store('company','public');

             $category_count = Company::where('category',$request->category)->count();
             
             if($category_count == 0){
               $company = 0;
             }
             else{
                $company        = Company::where('category',$request->category)->orderBy('company_id','desc')->first()->company_id;
             }
             
             
             //dd($company);

             if ($photo = $request->file('logo')) {
                    $file = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('logo')->getClientOriginalName();
                    $ext = $request->file('logo')->getClientOriginalExtension();
                    $request->file('logo')->storeAs('public/company', $file);
                }else {
                    $file='';
                }
            

            $season = new Company;
            $season->name           = $request->name;
            $season->brand_name_full= $request->brand_name_full;
            $season->company_id     = $company+1;
            $season->category       = $request->category;
            $season->logo           = $file;
            $season->description    = $request->description;
            $season->sequence       = $category_count+1;
            $season->status         = 1;
            $season->save();
        // }

        return Redirect::to("krishi-add-company");
    }

    /** Read Season Data */
    public function getAllCompany(){
        $company_data  = Company::with('get_category')->orderBy('sequence','asc')->get();
        $category_data = Category::where('status',1)->get();
        //dd($company_data);
        return view('admin.company.add-company',['company_data'=>$company_data ,'category_data'=>$category_data]);
    }

     /** Company Delete */
    public function companyDelete($companyId){
        $companyData = Company::where(['id'=>$companyId])->first();
        if(!empty($companyData)){
            $companyDelete = Company::where(['id'=>$companyId])->first();
            $companyDelete->status = 0;
            $companyDelete->update();

            return Redirect::to("krishi-add-company");
        }
        else {
            return array('msg'=>['Cannot Deleted Season']);
        }
    }

     /** Company Edit */
    public function companyEdit($companyId){

        $category_data = Category::where('status',1)->get();
        $company_data  = Company::where('status',1)->get();
        $company_edit  = Company::where(['id'=>$companyId])->first();
         //dd( $season_edit);

        return view('admin.company.edit-company', compact('category_data','company_data','company_edit'));
    }


    /** Company Update */
    public function companyUpdate(Request $request , $companyId){
     //dd($request->category);
        $this->validate($request, [
            'name'     => 'required',
            'brand_name_full'=>'required',
            'category' => 'required'
        ]);

        // if ($request->hasFile('logo') || $request->logo == '') {
            $request->validate([
                'logo' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            // if(!empty($request->logo)){
            //     $request->logo->store('company','public');
            // }

            $category_count = Company::where('category',$request->category)->count();
            if($category_count == 0){
                $company = 0;
            }
            else{
                $company  = Company::where('category',$request->category)->orderBy('company_id','desc')->first()->company_id;
            }

           if ($photo = $request->file('logo')) {
                $file = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('logo')->getClientOriginalName();
                $ext = $request->file('logo')->getClientOriginalExtension();
                $request->file('logo')->storeAs('public/company', $file);
            }else {
                $file='';
            }

            $company_Update = Company::where(['id'=>$companyId])->first();

            $company_Update->name         = $request->name;
            $company_Update->brand_name_full= $request->brand_name_full;
            $company_Update->company_id   = $company+1;
            $company_Update->category     = $request->category;
            $company_Update->description  = $request->description;

            if(!empty($request->logo)){
                $company_Update->logo     = $file;
            }

            $company_Update->sequence     = ($category_count+1) ;
            $company_Update->update();

            return redirect('/krishi-add-company');
        // }

    }


    /** Dealer Data Show */
    public function getAllDealersData($companyId){
        $getUser = User::where('user_type_id',2)->where('company_id',$companyId)->paginate(10);
        return view('admin.company.dealer-company',compact('getUser'));
    }

    /** Delete Dealer  */
    public function deleteDealersData($dealerId){
       // dd($dealerId);
        $dealerData = User::where(['id'=>$dealerId])->first();
        if(!empty($dealerData)){
            $dealerData = User::where(['id'=>$dealerId])->first();
            $dealerData->status = 0;
            $dealerData->update();
            return Redirect::to("krishi-add-company");
        }

    }

    /** Product Data Show */
    public function getProductData($companyId){
            $getProduct = DB::table('company_product')->where(['company_id'=>$companyId,'status'=>1])->get();
        
        return view('admin.company.dealer-product',compact('getProduct'));
    }
    
    
}
