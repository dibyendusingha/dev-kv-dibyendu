<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Tractor as tractor_model;
use App\Models\Goods_vehicle as gv_model;
use App\Models\Harvester as harvester_model;
use App\Models\Implement as implement_model;
use App\Models\Tyre as tyre_model;
use App\Models\Seed as seed_model;
use App\Models\pesticides as pesticide__model;
use App\Models\fertilizers as fertilizer_model;
use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\sms;
use App\Models\User as Userss;
use App\Models\Subscription\Subscription;
use Image;
use Storage;
use Carbon\Carbon;
use App\Models\Notification_save;
use Redirect;
use DateTime;
use App\Models\OfflineLead;
class AdminEnd extends Controller
{
    //
    public function brand(Request $request)
    {
        $arr = [];
        $arr = DB::table('brand')->where(['status' => 1, 'category_id' => 1])->get();
        return view('admin.tractor.brand', ['get' => $arr]);
    }

    public function brand_submit(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required',
            //'file' => 'required|image'//|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=30,min_height=30,max_width=1000,max_height=1000
        ]);

        $brand_name = $request->brand_name;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/brands', $file);
        } else {
            $file = '';
        }



        //image resize by Intervention Image
        // $image       = $request->file('file');
        // $filename    = $image->getClientOriginalName();

        // $image_resize = Image::make($image->getRealPath());              
        // $image_resize->resize(300, 300);
        // $image_resize->save(public_path('storage/images/brands/'.$filename));

        $insert = DB::table('brand')->insert(['category_id' => 1, 'name' => $brand_name, 'logo' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-tractor-brand')->with('success', 'Brand Added Successfully');
        } else {
            return redirect('krishi-tractor-brand')->with('failed', 'Failed! Something Went Wrong');
        }
    }

    public function brand_edit(Request $request)
    {
        $id = $request->id;

        $arr = [];
        $arr = DB::table('brand')->where(['status' => 1, 'category_id' => 1])->get();

        $edit_data = DB::table('brand')->where(['id' => $id])->first();
        return view('admin.tractor.brand_edit', ['edit_data' => $edit_data, 'get' => $arr]);
    }

    public function brand_update(Request $request)
    {
        $brand_id = $request->brand_id;
        $brand_name = $request->brand_name;
        $validatedData = $request->validate([
            'brand_name' => 'required'
        ]);


        $b_arr = DB::table('brand')->where(['id' => $brand_id])->first();
        $logo = $b_arr->logo;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/brands', $file);
        } else {
            $file = $logo;
        }

        $update = DB::table('brand')->where(['id' => $brand_id])->update(['name' => $brand_name, 'logo' => $file]);
        if ($update) {
            return redirect('krishi-tractor-brand-edit/' . $brand_id)->with('success', 'Brand Updated Successfully');
        } else {
            return redirect('krishi-tractor-brand-edit/' . $brand_id)->with('failed', 'Something went wrong');
        }
    }

    public function tractor_brand_delete(Request $request)
    {
        $id = $request->id;

        $model_count = DB::table('model')->where(['brand_id' => $id])->count();
        if ($model_count > 0) {
            return redirect('krishi-tractor-brand')->with('failed', 'First Delete Model');
        } else {
            $delete = DB::table('brand')->where(['id' => $id])->delete();
            if ($delete) {
                return redirect('krishi-tractor-brand')->with('success', 'Brand Deleted Successfully');
            } else {
                return redirect('krishi-tractor-brand')->with('failed', 'Failed');
            }
        }
    }

    public function krishi_tractor_model(Request $request)
    {
        $get = DB::table('model')->where(['status' => 1, 'company_id' => 1])->get();
        //print_r($get); 
        return view('admin.tractor.model', ['get' => $get]);
    }

    public function tractor_model_submit(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required'
        ]);
        $brand_id = $request->brand_id;
        $model = $request->model;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/model', $file);
        } else {
            $file = '';
        }

        $insert = DB::table('model')->insert(['company_id' => 1, 'brand_id' => $brand_id, 'model_name' => $model, 'icon' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-tractor-model')->with('success', 'Model Added Successfully');
        } else {
            return redirect('krishi-tractor-model')->with('failed', 'Something went wrong');
        }
    }

    public function tractor_model_edit(Request $request)
    {
        $id = $request->id;
        $edit_data = DB::table('model')->where(['id' => $id])->first();
        $get = DB::table('model')->where(['status' => 1, 'company_id' => 1])->get();

        return view('admin.tractor.model_edit', ['edit_data' => $edit_data, 'get' => $get]);
    }

    public function tractor_model_update(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required'
        ]);
        $model_id = $request->model_id;
        $brand_id = $request->brand_id;
        $model = $request->model;

        $m_arr = DB::table('model')->where(['id' => $model_id])->first();
        $icon = $m_arr->icon;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/model', $file);
        } else {
            $file = $icon;
        }

        $update = DB::table('model')->where(['id' => $model_id])->update(['brand_id' => $brand_id, 'model_name' => $model, 'icon' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($update) {
            return redirect('krishi-tractor-model-edit/' . $model_id)->with('success', 'Model Updated Successfully');
        } else {
            return redirect('krishi-tractor-model-edit/' . $model_id)->with('failed', 'Something went wrong');
        }
    }

    public function tractor_model_delete(Request $request)
    {
        $id = $request->id;

        $post_count = DB::table('tractor')->where(['model_id' => $id])->count();
        if ($post_count > 0) {
            return redirect('krishi-tractor-model')->with('failed', 'First Delete Post');
        } else {
            $delete = DB::table('model')->where(['id' => $id])->delete();
            if ($delete) {
                return redirect('krishi-tractor-model')->with('success', 'Brand Deleted Successfully');
            } else {
                return redirect('krishi-tractor-model')->with('failed', 'Failed');
            }
        }
    }

    public function tractor_specification()
    {
        $get =    DB::table('specifications')
            ->join('model', 'model.id', '=', 'specifications.model_id')
            ->where('model.company_id', 1)
            ->get('specifications.*');

        // print_r($get);

        return view('admin.tractor.specification', ['get' => $get]);
    }


    public function brand_to_model(Request $request)
    {
        $brand_id = $request->brand_id;

        $brand_arr = DB::table('model')->where(['brand_id' => $brand_id])->get();
        foreach ($brand_arr as $val) { ?>
            <option value="<?= $val->id; ?>"><?= $val->model_name; ?></option>
            <?php }
    }

    public function tractor_specification_submit(Request $request)
    {
        $validatedData = $request->validate([
            'specification' => 'required',
            'value' => 'required'
        ]);
        $brand = $request->brand;
        $model = $request->model;
        $specification = $request->specification;
        $value = $request->value;

        $insert = DB::table('specifications')->insert(['model_id' => $model, 'spec_name' => $specification, 'value' => $value, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-tractor-specification')->with('success', 'Specification added Successfully');
        } else {
            return redirect('krishi-tractor-specification')->with('failed', 'Something went wrong');
        }
    }


    public function tractor_specification_edit(Request $request)
    {
        $id = $request->id;
        $edit_data = DB::table('specifications')->where(['id' => $id])->first();
        $get =    DB::table('specifications')
            ->join('model', 'model.id', '=', 'specifications.model_id')
            ->where('model.company_id', 1)
            ->get('specifications.*');
        return view('admin.tractor.specification_edit', ['get' => $get, 'edit_data' => $edit_data]);
    }


    public function tractor_specification_update(Request $request)
    {
        $validatedData = $request->validate([
            'specification' => 'required',
            'value' => 'required'
        ]);
        $specification_id = $request->specification_id;
        $brand = $request->brand;
        $model = $request->model;
        $specification = $request->specification;
        $value = $request->value;

        $update = DB::table('specifications')->where(['id' => $specification_id])->update([
            'model_id' => $model, 'spec_name' => $specification, 'value' => $value, 'status' => 1, 'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($update) {
            return redirect('krishi-tractor-specification-edit/' . $specification_id)->with('success', 'Specification updated Successfully');
        } else {
            return redirect('krishi-tractor-specification-edit/' . $specification_id)->with('failed', 'Something went wrong');
        }
    }

    public function tractor_specification_delete(Request $request)
    {
        $id = $request->id;

        $delete = DB::table('specifications')->where(['id' => $id])->delete();
        if ($delete) {
            return redirect('krishi-tractor-specification')->with('success', 'Specification deleted Successfully');
        } else {
            return redirect('krishi-tractor-specification')->with('failed', 'Something went wrong');
        }
    }



    public function krishi_tractor_post_list()
    {
        return view('admin.tractor.post_list');
    }

    public function krishi_tractor_post_view(Request $request)
    {
        $id = $request->id;
        $arr = tractor_model::tractor_single($id, '');

        $post_lead_user = DB::table('seller_leads as s')
            ->select('u.name', 'u.mobile', 'u.user_type_id', 'u.zipcode','s.created_at')
            ->leftJoin('user as u', 'u.id', '=', 's.user_id')
            ->where('s.post_id', $id)
            ->where('s.category_id', 1)
            ->get();

           // dd($post_lead_user);
        
        $offline_lead = OfflineLead::where(['post_id'=> $id , 'category_id'=> 1])->get();

        return view('admin.tractor.post_details', ['data' => $arr, 'post_lead_user' => $post_lead_user,'offline_lead' => $offline_lead]);
    }


    public function tractor_status_change(Request $request)
    {
        // dd($request->status_change);
        $status = $request->status_change;
        $item_id = $request->item_id;
        if ($status == 'pending') {
            $status = 0;
            $user_id = DB::table('tractor')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_send = sms::post_pending($mobile, 1);
        } else if ($status == 'Approved') {
            $status = 1;
            $user_id = DB::table('tractor')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_approve = sms::post_approve($mobile, 1);
         
        } else if ($status == 'sold') {
            $status = 4;
            $user_id = DB::table('tractor')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_send = sms::post_pending($mobile, 1);
        } else {
            $status = 2;
            $user_id = DB::table('tractor')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_reject = sms::post_reject($mobile, 1);
        }
        $update = DB::table('tractor')->where(['id' => $item_id])->update(['status' => $status]);



        if ($update > 0) {
            return response()->json(['success' => 'success', 'msg' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
        }
    }

    public function tractor_post_delete(Request $request)
    {
        $id = $request->id;

        $delete = DB::table('tractor')->where(['id' => $id])->delete();
        if ($delete) {
            return redirect('krishi-tractor-post-list')->with('success', 'Tractor Delete Successfully');
        } else {
            return redirect('krishi-tractor-specification')->with('failed', 'Something went wrong');
        }
    }

    public function tractor_filter_data(Request $request)
    {
        $post_type = $request->post_type;
        $status = $request->status;
        $creater_at = $request->creater_at;


        if ($post_type != '') {
            $type_condition = 'where';
            $type_col = 'type';
            $where_type = $post_type;
        } else {
            $type_condition = 'orwhereIn';
            $type_col = 'type';
            $where_type = ['old', 'new'];
        }
        if ($status != '') {
            $status_condition = 'where';
            $status_col = 'status';
            $where_status = $status;
        } else {
            $status_condition = 'orwhere';
            $status_col = 'status';
            $where_status = '';
        }
        if ($creater_at != '') {
            $date_condition = 'whereBetween';
            $date_col = 'created_at';
            $where_date_start = date("Y-m-d 00:00:00", strtotime($creater_at));
            $where_date_end = date("Y-m-d 11:59:59", strtotime($creater_at));
        } else {
            $date_condition = 'orwhereBetween';
            $date_col = 'created_at';
            $where_date_start = '';
            $where_date_end = '';
        }


        $count = DB::table('tractor')->$type_condition($type_col, $where_type)->$status_condition($status_col, $where_status)->$date_condition($date_col, [$where_date_start, $where_date_end])->count();

        if ($count > 0) {
            $tractor_data = DB::table('tractor')
                ->$type_condition($type_col, $where_type)
                ->$status_condition($status_col, $where_status)
                ->$date_condition($date_col, [$where_date_start, $where_date_end])
                ->paginate(10);

            foreach ($tractor_data as $val) { ?>
                <tr>
                    <td><?= $val->created_at; ?></td>
                    <td>
                        <?php
                        $brand = DB::table('brand')->where(['id' => $val->brand_id])->first();
                        echo $brand->name;
                        ?>
                    </td>
                    <td>
                        <?php
                        $brand = DB::table('model')->where(['id' => $val->model_id])->first();
                        echo $brand->model_name;
                        ?>
                    </td>
                    <td><?= $val->type; ?></td>
                    <td><span class="badge rounded-pill alert-<?php if ($val->status == 1) {
                                                                    echo 'success';
                                                                } else if ($val->status == 0) {
                                                                    echo 'warning';
                                                                } else {
                                                                    echo 'danger';
                                                                } ?>"><?php if ($val->status == 1) {
                                                                            echo 'Approved';
                                                                        } else if ($val->status == 0) {
                                                                            echo 'Pending';
                                                                        } else {
                                                                            echo 'Rejected';
                                                                        } ?></span></td>
                    <td class="text-end">
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= url('krishi-tractor-post-view/' . $val->id) ?>">View Post</a>
                                <a class="dropdown-item text-danger" href="<?= url('krishi-tractor-post-delete/' . $val->id) ?>">Delete</a>
                            </div>
                        </div>
                        <!-- dropdown //end -->
                    </td>
                </tr>
            <?php    }
        } else {
            echo '<center>No Data found</center>';
        }
    }

    public function tractor_update(Request $request)
    {
        $update_id = $request->update_id;
        $data = DB::table('tractor')->where(['id' => $update_id])->first();
        $set = $request->set;
        $type = $request->type;
        $title = $request->title;
        $price = $request->price;
        $pincode = $request->pincode;
        $rent_type = $request->rent_type;
        $brnad = $request->brnad;

        $roc_available = $request->roc_available;
        $noc_available = $request->noc_available;
        $is_negotiable = $request->is_negotiable;


        if ($request->model_id == '') {
            $model_id = $data->model_id;
        } else {
            $model_id = $request->model_id;
        }

        if ($f_image = $request->file('f_image')) {
            $f_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('f_image')->getClientOriginalName();
            $ext = $request->file('f_image')->getClientOriginalExtension();

            $request->file('f_image')->storeAs('public/tractor', $f_image);
        } else {
            $f_image = $data->front_image;
        }
        if ($l_image = $request->file('l_image')) {
            $l_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('l_image')->getClientOriginalName();
            $ext = $request->file('l_image')->getClientOriginalExtension();

            $request->file('l_image')->storeAs('public/tractor', $l_image);
        } else {
            $l_image = $data->left_image;;
        }
        if ($r_image = $request->file('r_image')) {
            $r_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('r_image')->getClientOriginalName();
            $ext = $request->file('r_image')->getClientOriginalExtension();
            $request->file('r_image')->storeAs('public/tractor', $r_image);
        } else {
            $r_image = $data->right_image;
        }
        if ($b_image = $request->file('b_image')) {
            $b_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('b_image')->getClientOriginalName();
            $ext = $request->file('b_image')->getClientOriginalExtension();
            $request->file('b_image')->storeAs('public/tractor', $b_image);
        } else {
            $b_image = $data->back_image;
        }
        if ($m_image = $request->file('m_image')) {
            $m_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('m_image')->getClientOriginalName();
            $ext = $request->file('m_image')->getClientOriginalExtension();
            $request->file('m_image')->storeAs('public/tractor', $m_image);
        } else {
            $m_image = $data->meter_image;
        }
        if ($t_image = $request->file('t_image')) {
            $t_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('t_image')->getClientOriginalName();
            $ext = $request->file('t_image')->getClientOriginalExtension();
            $request->file('t_image')->storeAs('public/tractor', $t_image);
        } else {
            $t_image = $data->tyre_image;
        }

        $update = DB::table('tractor')->where(['id' => $update_id])->update([
            'set' => $set, 'type' => $type, 'brand_id' => $brnad, 'model_id' => $model_id, 'title' => $title, 'price' => $price, 'pincode' => $pincode, 'rent_type' => $rent_type,
            'left_image' => $l_image, 'right_image' => $r_image, 'front_image' => $f_image, 'back_image' => $b_image, 'meter_image' => $m_image, 'tyre_image' => $t_image, 'rc_available' => $roc_available, 'noc_available' => $noc_available, 'is_negotiable' => $is_negotiable
        ]);
        if ($update) {
            return redirect('krishi-tractor-post-view/' . $update_id)->with('success', 'Tractor Updated Successfully');
        } else {
            return redirect('krishi-tractor-post-view/' . $update_id)->with('failed', 'Something went wrong');
        }
    }


    /******** Good and vahicle *************/













    public function gv_brand(Request $request)
    {
        $arr = [];
        $arr = DB::table('brand')->where(['status' => 1, 'category_id' => 3])->get();
        return view('admin.goods_vehicle.brand', ['get' => $arr]);
    }

    public function gv_brand_submit(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required'
        ]);
        $brand_name = $request->brand_name;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/brands', $file);
        } else {
            $file = '';
        }
        $insert = DB::table('brand')->insert(['category_id' => 3, 'name' => $brand_name, 'logo' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-gv-brand')->with('success', 'Brand Added Successfully');
        } else {
            return redirect('krishi-gv-brand')->with('failed', 'Failed! Something Went Wrong');
        }
    }

    public function gv_brand_edit(Request $request)
    {
        $id = $request->id;

        $arr = [];
        $arr = DB::table('brand')->where(['status' => 1, 'category_id' => 3])->get();

        $edit_data = DB::table('brand')->where(['id' => $id])->first();
        return view('admin.goods_vehicle.brand_edit', ['edit_data' => $edit_data, 'get' => $arr]);
    }

    public function gv_brand_update(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required'
        ]);
        $brand_id = $request->brand_id;
        $brand_name = $request->brand_name;


        $b_arr = DB::table('brand')->where(['id' => $brand_id])->first();
        $logo = $b_arr->logo;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/brands', $file);
        } else {
            $file = $logo;
        }

        $update = DB::table('brand')->where(['id' => $brand_id])->update(['name' => $brand_name, 'logo' => $file]);
        if ($update) {
            return redirect('krishi-gv-brand-edit/' . $brand_id)->with('success', 'Brand Updated Successfully');
        } else {
            return redirect('krishi-gv-brand-edit/' . $brand_id)->with('failed', 'Something went wrong');
        }
    }

    public function gv_brand_delete(Request $request)
    {
        $id = $request->id;

        $model_count = DB::table('model')->where(['brand_id' => $id])->count();
        if ($model_count > 0) {
            return redirect('krishi-gv-brand')->with('failed', 'First Delete Model');
        } else {
            $delete = DB::table('brand')->where(['id' => $id])->delete();
            if ($delete) {
                return redirect('krishi-gv-brand')->with('success', 'Brand Deleted Successfully');
            } else {
                return redirect('krishi-gv-brand')->with('failed', 'Failed');
            }
        }
    }

    public function gv_model(Request $request)
    {
        $get = DB::table('model')->where(['status' => 1, 'company_id' => 3])->get();
        return view('admin.goods_vehicle.model', ['get' => $get]);
    }

    public function gv_model_submit(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required'
        ]);
        $brand_id = $request->brand_id;
        $model = $request->model;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/model', $file);
        } else {
            $file = '';
        }

        $insert = DB::table('model')->insert(['company_id' => 3, 'brand_id' => $brand_id, 'model_name' => $model, 'icon' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-gv-model')->with('success', 'Model Added Successfully');
        } else {
            return redirect('krishi-gv-model')->with('failed', 'Something went wrong');
        }
    }

    public function gv_model_edit(Request $request)
    {
        $id = $request->id;
        $edit_data = DB::table('model')->where(['id' => $id])->first();
        $get = DB::table('model')->where(['status' => 1, 'company_id' => 3])->get();

        return view('admin.goods_vehicle.model_edit', ['edit_data' => $edit_data, 'get' => $get]);
    }

    public function gv_model_update(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required'
        ]);
        $model_id = $request->model_id;
        $brand_id = $request->brand_id;
        $model = $request->model;

        $m_arr = DB::table('model')->where(['id' => $model_id])->first();
        $icon = $m_arr->icon;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/model', $file);
        } else {
            $file = $icon;
        }

        $update = DB::table('model')->where(['id' => $model_id])->update(['brand_id' => $brand_id, 'model_name' => $model, 'icon' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($update) {
            return redirect('krishi-gv-model-edit/' . $model_id)->with('success', 'Model Updated Successfully');
        } else {
            return redirect('krishi-gv-model-edit/' . $model_id)->with('failed', 'Something went wrong');
        }
    }

    public function gv_model_delete(Request $request)
    {
        $id = $request->id;

        $post_count = DB::table('goods_vehicle')->where(['model_id' => $id])->count();
        if ($post_count > 0) {
            return redirect('krishi-tractor-model')->with('failed', 'First Delete Post');
        } else {
            $delete = DB::table('model')->where(['id' => $id])->delete();
            if ($delete) {
                return redirect('krishi-gv-model')->with('success', 'Brand Deleted Successfully');
            } else {
                return redirect('krishi-gv-model')->with('failed', 'Failed');
            }
        }
    }

    public function gv_specification()
    {
        $get =    DB::table('specifications')
            ->join('model', 'model.id', '=', 'specifications.model_id')
            ->where('model.company_id', 3)
            ->get('specifications.*');
        return view('admin.goods_vehicle.specification', ['get' => $get]);
    }



    public function gv_specification_submit(Request $request)
    {
        $validatedData = $request->validate([
            'specification' => 'required',
            'value' => 'required'
        ]);
        $brand = $request->brand;
        $model = $request->model;
        $specification = $request->specification;
        $value = $request->value;

        $insert = DB::table('specifications')->insert(['model_id' => $model, 'spec_name' => $specification, 'value' => $value, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-gv-specification')->with('success', 'Specification added Successfully');
        } else {
            return redirect('krishi-gv-specification')->with('failed', 'Something went wrong');
        }
    }


    public function gv_specification_edit(Request $request)
    {
        $id = $request->id;
        $edit_data = DB::table('specifications')->where(['id' => $id])->first();
        $get =    DB::table('specifications')
            ->join('model', 'model.id', '=', 'specifications.model_id')
            ->where('model.company_id', 3)
            ->get('specifications.*');
        return view('admin.goods_vehicle.specification_edit', ['get' => $get, 'edit_data' => $edit_data]);
    }


    public function gv_specification_update(Request $request)
    {
        $validatedData = $request->validate([
            'specification' => 'required',
            'value' => 'required'
        ]);
        $specification_id = $request->specification_id;
        $brand = $request->brand;
        $model = $request->model;
        $specification = $request->specification;
        $value = $request->value;

        $update = DB::table('specifications')->where(['id' => $specification_id])->update([
            'model_id' => $model, 'spec_name' => $specification, 'value' => $value, 'status' => 1, 'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($update) {
            return redirect('krishi-gv-specification-edit/' . $specification_id)->with('success', 'Specification updated Successfully');
        } else {
            return redirect('krishi-gv-specification-edit/' . $specification_id)->with('failed', 'Something went wrong');
        }
    }

    public function gv_specification_delete(Request $request)
    {
        $id = $request->id;

        $delete = DB::table('specifications')->where(['id' => $id])->delete();
        if ($delete) {
            return redirect('krishi-gv-specification')->with('success', 'Specification deleted Successfully');
        } else {
            return redirect('krishi-gv-specification')->with('failed', 'Something went wrong');
        }
    }



    public function gv_post_list()
    {
        return view('admin.goods_vehicle.post_list');
    }

    public function gv_post_view(Request $request)
    {
        $id = $request->id;
        $arr = gv_model::gv_single($id, '');
        $post_lead_user = DB::table('seller_leads as s')
            ->select('u.name', 'u.mobile', 'u.user_type_id', 'u.zipcode')
            ->leftJoin('user as u', 'u.id', '=', 's.user_id')
            ->where('s.post_id', $id)
            ->where('s.category_id', 3)
            ->get();

        $offline_lead = OfflineLead::where(['post_id'=> $id , 'category_id'=> 3])->get();
        return view('admin.goods_vehicle.post_details', ['data' => $arr, 'post_lead_user' => $post_lead_user ,'offline_lead' => $offline_lead]);
    }

    public function gv_status_change(Request $request)
    {
        $status = $request->status_change;
        $item_id = $request->item_id;
        if ($status == 'pending') {
            $status = 0;

            $user_id = DB::table('goods_vehicle')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_send = sms::post_pending($mobile, 1);
        } else if ($status == 'Approved') {
            $status = 1;

            $user_id = DB::table('goods_vehicle')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_approve = sms::post_approve($mobile, 1);

            /*$message = 'Your product has been approved and listed on Krishi Vikas Udyog. Now, your products are ready to reach a wider audience. | Krishi Vikas';
            	$encode_message = urlencode($message);
                $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$mobile.'&message='.$encode_message.'&format=json';
                $ch = curl_init();   
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
                curl_setopt($ch, CURLOPT_URL, $url);   
                $res = curl_exec($ch); */
        } else if ($status == 'sold') {
            $status = 4;

            $user_id = DB::table('goods_vehicle')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            // $notification_send = sms::post_pending($mobile,1);
        } else {
            $status = 2;

            $user_id = DB::table('goods_vehicle')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_reject = sms::post_reject($mobile, 1);
        }
        $update = DB::table('goods_vehicle')->where(['id' => $item_id])->update(['status' => $status]);

        if ($update > 0) {
            return response()->json(['success' => 'success', 'msg' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
        }
    }

    public function gv_post_delete(Request $request)
    {
        $id = $request->id;

        $delete = DB::table('goods_vehicle')->where(['id' => $id])->delete();
        if ($delete) {
            return redirect('krishi-gv-post-list')->with('success', 'Goods & vehicle Deleted Successfully');
        } else {
            return redirect('krishi-gv-specification')->with('failed', 'Something went wrong');
        }
    }


    public function gv_filter_data(Request $request)
    {

        $post_type = $request->post_type;
        $status = $request->status;
        $creater_at = $request->creater_at;



        if ($post_type != '') {
            $type_condition = 'where';
            $type_col = 'type';
            $where_type = $post_type;
        } else {
            $type_condition = 'orwhereIn';
            $type_col = 'type';
            $where_type = ['old', 'new'];
        }
        if ($status != '') {
            $status_condition = 'where';
            $status_col = 'status';
            $where_status = $status;
        } else {
            $status_condition = 'orwhere';
            $status_col = 'status';
            $where_status = '';
        }
        if ($creater_at != '') {
            $date_condition = 'whereBetween';
            $date_col = 'created_at';
            $where_date_start = date("Y-m-d 00:00:00", strtotime($creater_at));
            $where_date_end = date("Y-m-d 11:59:59", strtotime($creater_at));
        } else {
            $date_condition = 'orwhereBetween';
            $date_col = 'created_at';
            $where_date_start = '';
            $where_date_end = '';
        }


        $count = DB::table('goods_vehicle')->$type_condition($type_col, $where_type)->$status_condition($status_col, $where_status)->$date_condition($date_col, [$where_date_start, $where_date_end])->count();

        if ($count > 0) {
            $tractor_data = DB::table('goods_vehicle')
                ->$type_condition($type_col, $where_type)
                ->$status_condition($status_col, $where_status)
                ->$date_condition($date_col, [$where_date_start, $where_date_end])
                ->paginate(10);

            foreach ($tractor_data as $val) {
            ?>
                <tr>
                    <td><?= $val->created_at ?></td>
                    <td>
                        <?php
                        $brand = DB::table('brand')->where(['id' => $val->brand_id])->first();
                        echo $brand->name;
                        ?>
                    </td>
                    <td>
                        <?php
                        $brand = DB::table('model')->where(['id' => $val->model_id])->first();
                        echo $brand->model_name;
                        ?>
                    </td>
                    <td><?= $val->type ?></td>
                    <td><span class="badge rounded-pill alert-<?php if ($val->status == 1) {
                                                                    echo 'success';
                                                                } else if ($val->status == 0) {
                                                                    echo 'warning';
                                                                } else {
                                                                    echo 'danger';
                                                                } ?>"><?php if ($val->status == 1) {
                                                                            echo 'Approved';
                                                                        } else if ($val->status == 0) {
                                                                            echo 'Pending';
                                                                        } else {
                                                                            echo 'Rejected';
                                                                        } ?></span></td>
                    <td class="text-end">
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo  url('krishi-gv-post-view', $val->id) ?>">View Post</a>
                                <!-- <a class="dropdown-item text-danger" href="{{url('krishi-gv-post-delete/'.$val->id)}}">Delete</a> -->
                                <a class="dropdown-item text-danger" href="<?php echo url('krishi-gv-post-delete/' . $val->id) ?>">Delete</a>
                            </div>
                        </div>
                        <!-- dropdown //end -->
                    </td>
                </tr>
            <?php }
        } else {
            echo '<center>No Data found</center>';
        }
    }

    public function gv_update(Request $request)
    {
        $update_id = $request->update_id;
        $data = DB::table('goods_vehicle')->where(['id' => $update_id])->first();
        $set = $request->set;
        $type = $request->type;
        $title = $request->title;
        $price = $request->price;
        $pincode = $request->pincode;
        $rent_type = $request->rent_type;
        $brnad = $request->brnad;
        if ($request->model_id == '') {
            $model_id = $data->model_id;
        } else {
            $model_id = $request->model_id;
        }

        if ($f_image = $request->file('f_image')) {
            $f_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('f_image')->getClientOriginalName();
            $ext = $request->file('f_image')->getClientOriginalExtension();

            $request->file('f_image')->storeAs('public/goods_vehicle', $f_image);
        } else {
            $f_image = $data->front_image;
        }
        if ($l_image = $request->file('l_image')) {
            $l_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('l_image')->getClientOriginalName();
            $ext = $request->file('l_image')->getClientOriginalExtension();

            $request->file('l_image')->storeAs('public/goods_vehicle', $l_image);
        } else {
            $l_image = $data->left_image;;
        }
        if ($r_image = $request->file('r_image')) {
            $r_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('r_image')->getClientOriginalName();
            $ext = $request->file('r_image')->getClientOriginalExtension();
            $request->file('r_image')->storeAs('public/goods_vehicle', $r_image);
        } else {
            $r_image = $data->right_image;
        }
        if ($b_image = $request->file('b_image')) {
            $b_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('b_image')->getClientOriginalName();
            $ext = $request->file('b_image')->getClientOriginalExtension();
            $request->file('b_image')->storeAs('public/goods_vehicle', $b_image);
        } else {
            $b_image = $data->back_image;
        }
        if ($m_image = $request->file('m_image')) {
            $m_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('m_image')->getClientOriginalName();
            $ext = $request->file('m_image')->getClientOriginalExtension();
            $request->file('m_image')->storeAs('public/goods_vehicle', $m_image);
        } else {
            $m_image = $data->meter_image;
        }
        if ($t_image = $request->file('t_image')) {
            $t_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('t_image')->getClientOriginalName();
            $ext = $request->file('t_image')->getClientOriginalExtension();
            $request->file('t_image')->storeAs('public/goods_vehicle', $t_image);
        } else {
            $t_image = $data->tyre_image;
        }
        $update = DB::table('goods_vehicle')->where(['id' => $update_id])->update([
            'set' => $set, 'type' => $type, 'brand_id' => $brnad, 'model_id' => $model_id, 'title' => $title, 'price' => $price, 'pincode' => $pincode, 'rent_type' => $rent_type,
            'left_image' => $l_image, 'right_image' => $r_image, 'front_image' => $f_image, 'back_image' => $b_image, 'meter_image' => $m_image, 'tyre_image' => $t_image
        ]);
        if ($update) {
            return redirect('krishi-gv-post-view/' . $update_id)->with('success', 'Goods Vehicle Updated Successfully');
        } else {
            return redirect('krishi-gv-post-view/' . $update_id)->with('failed', 'Something went wrong');
        }
    }



    /******** harvester *************/













    public function harvester_brand(Request $request)
    {
        $arr = [];
        $arr = DB::table('brand')->where(['status' => 1, 'category_id' => 4])->get();
        return view('admin.harvester.brand', ['get' => $arr]);
    }

    public function harvester_brand_submit(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required'
        ]);
        $brand_name = $request->brand_name;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/brands', $file);
        } else {
            $file = '';
        }
        $insert = DB::table('brand')->insert(['category_id' => 4, 'name' => $brand_name, 'logo' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-harvester-brand')->with('success', 'Brand Added Successfully');
        } else {
            return redirect('krishi-harvester-brand')->with('failed', 'Failed! Something Went Wrong');
        }
    }

    public function harvester_brand_edit(Request $request)
    {
        $id = $request->id;

        $arr = [];
        $arr = DB::table('brand')->where(['status' => 1, 'category_id' => 4])->get();

        $edit_data = DB::table('brand')->where(['id' => $id])->first();
        return view('admin.harvester.brand_edit', ['edit_data' => $edit_data, 'get' => $arr]);
    }

    public function harvester_brand_update(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required'
        ]);
        $brand_id = $request->brand_id;
        $brand_name = $request->brand_name;

        $b_arr = DB::table('brand')->where(['id' => $brand_id])->first();
        $logo = $b_arr->logo;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/brands', $file);
        } else {
            $file = $logo;
        }

        $update = DB::table('brand')->where(['id' => $brand_id])->update(['name' => $brand_name, 'logo' => $file]);
        if ($update) {
            return redirect('krishi-harvester-brand-edit/' . $brand_id)->with('success', 'Brand Updated Successfully');
        } else {
            return redirect('krishi-harvester-brand-edit/' . $brand_id)->with('failed', 'Something went wrong');
        }
    }

    public function harvester_brand_delete(Request $request)
    {
        $id = $request->id;

        $model_count = DB::table('model')->where(['brand_id' => $id])->count();
        if ($model_count > 0) {
            return redirect('krishi-harvester-brand')->with('failed', 'First Delete Model');
        } else {
            $delete = DB::table('brand')->where(['id' => $id])->delete();
            if ($delete) {
                return redirect('krishi-harvester-brand')->with('success', 'Brand Deleted Successfully');
            } else {
                return redirect('krishi-harvester-brand')->with('failed', 'Failed');
            }
        }
    }

    public function harvester_model(Request $request)
    {
        $get = DB::table('model')->where(['status' => 1, 'company_id' => 4])->get();
        return view('admin.harvester.model', ['get' => $get]);
    }

    public function harvester_model_submit(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required'
        ]);
        $brand_id = $request->brand_id;
        $model = $request->model;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/model', $file);
        } else {
            $file = '';
        }

        $insert = DB::table('model')->insert(['company_id' => 4, 'brand_id' => $brand_id, 'model_name' => $model, 'icon' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-harvester-model')->with('success', 'Model Added Successfully');
        } else {
            return redirect('krishi-harvester-model')->with('failed', 'Something went wrong');
        }
    }

    public function harvester_model_edit(Request $request)
    {
        $id = $request->id;
        $edit_data = DB::table('model')->where(['id' => $id])->first();
        $get = DB::table('model')->where(['status' => 1, 'company_id' => 4])->get();

        return view('admin.harvester.model_edit', ['edit_data' => $edit_data, 'get' => $get]);
    }

    public function harvester_model_update(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required'
        ]);
        $model_id = $request->model_id;
        $brand_id = $request->brand_id;
        $model = $request->model;

        $m_arr = DB::table('model')->where(['id' => $model_id])->first();
        $icon = $m_arr->icon;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/model', $file);
        } else {
            $file = $icon;
        }

        $update = DB::table('model')->where(['id' => $model_id])->update(['brand_id' => $brand_id, 'model_name' => $model, 'icon' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($update) {
            return redirect('krishi-harvester-model-edit/' . $model_id)->with('success', 'Model Updated Successfully');
        } else {
            return redirect('krishi-harvester-model-edit/' . $model_id)->with('failed', 'Something went wrong');
        }
    }

    public function harvester_model_delete(Request $request)
    {
        $id = $request->id;

        $post_count = DB::table('harvester')->where(['model_id' => $id])->count();
        if ($post_count > 0) {
            return redirect('krishi-harvester-model')->with('failed', 'First Delete Post');
        } else {
            $delete = DB::table('model')->where(['id' => $id])->delete();
            if ($delete) {
                return redirect('krishi-harvester-model')->with('success', 'Brand Deleted Successfully');
            } else {
                return redirect('krishi-harvester-model')->with('failed', 'Failed');
            }
        }
    }

    public function harvester_specification()
    {
        $get =    DB::table('specifications')
            ->join('model', 'model.id', '=', 'specifications.model_id')
            ->where('model.company_id', 4)
            ->get('specifications.*');
        return view('admin.harvester.specification', ['get' => $get]);
    }



    public function harvester_specification_submit(Request $request)
    {
        $validatedData = $request->validate([
            'specification' => 'required',
            'value' => 'required'
        ]);
        $brand = $request->brand;
        $model = $request->model;
        $specification = $request->specification;
        $value = $request->value;

        $insert = DB::table('specifications')->insert(['model_id' => $model, 'spec_name' => $specification, 'value' => $value, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-harvester-specification')->with('success', 'Specification added Successfully');
        } else {
            return redirect('krishi-harvester-specification')->with('failed', 'Something went wrong');
        }
    }


    public function harvester_specification_edit(Request $request)
    {
        $id = $request->id;
        $edit_data = DB::table('specifications')->where(['id' => $id])->first();
        $get =    DB::table('specifications')
            ->join('model', 'model.id', '=', 'specifications.model_id')
            ->where('model.company_id', 4)
            ->get('specifications.*');
        return view('admin.harvester.specification_edit', ['get' => $get, 'edit_data' => $edit_data]);
    }


    public function harvester_specification_update(Request $request)
    {
        $validatedData = $request->validate([
            'specification' => 'required',
            'value' => 'required'
        ]);
        $specification_id = $request->specification_id;
        $brand = $request->brand;
        $model = $request->model;
        $specification = $request->specification;
        $value = $request->value;

        $update = DB::table('specifications')->where(['id' => $specification_id])->update([
            'model_id' => $model, 'spec_name' => $specification, 'value' => $value, 'status' => 1, 'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($update) {
            return redirect('krishi-harvester-specification-edit/' . $specification_id)->with('success', 'Specification updated Successfully');
        } else {
            return redirect('krishi-harvester-specification-edit/' . $specification_id)->with('failed', 'Something went wrong');
        }
    }

    public function harvester_specification_delete(Request $request)
    {
        $id = $request->id;

        $delete = DB::table('specifications')->where(['id' => $id])->delete();
        if ($delete) {
            return redirect('krishi-harvester-specification')->with('success', 'Specification deleted Successfully');
        } else {
            return redirect('krishi-harvester-specification')->with('failed', 'Something went wrong');
        }
    }


    public function harvester_post_list()
    {
        return view('admin.harvester.post_list');
    }

    public function harvester_post_view(Request $request)
    {
        $id = $request->id;
        $arr = harvester_model::harvester_single($id, '');
        $post_lead_user = DB::table('seller_leads as s')
            ->select('u.name', 'u.mobile', 'u.user_type_id', 'u.zipcode')
            ->leftJoin('user as u', 'u.id', '=', 's.user_id')
            ->where('s.post_id', $id)
            ->where('s.category_id', 4)
            ->get();

        $offline_lead = OfflineLead::where(['post_id'=> $id , 'category_id'=> 4])->get();
        return view('admin.harvester.post_details', ['data' => $arr, 'post_lead_user' => $post_lead_user ,'offline_lead' => $offline_lead]);
    }

    public function harvester_status_change(Request $request)
    {
        $status = $request->status_change;
        $item_id = $request->item_id;
        if ($status == 'pending') {
            $status = 0;
            $user_id = DB::table('harvester')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_send = sms::post_pending($mobile, 1);
        } else if ($status == 'Approved') {
            $status = 1;

            $user_id = DB::table('harvester')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_approve = sms::post_approve($mobile, 1);

            /*$message = 'Your product has been approved and listed on Krishi Vikas Udyog. Now, your products are ready to reach a wider audience. | Krishi Vikas';
            	$encode_message = urlencode($message);
                $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$mobile.'&message='.$encode_message.'&format=json';
                $ch = curl_init();   
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
                curl_setopt($ch, CURLOPT_URL, $url);   
                $res = curl_exec($ch);*/
        } else if ($status == 'sold') {
            $status = 4;
            $user_id = DB::table('harvester')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            //$notification_send = sms::post_pending($mobile,1);
        } else {
            $status = 2;
            $user_id = DB::table('harvester')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_reject = sms::post_reject($mobile, 1);
        }
        $update = DB::table('harvester')->where(['id' => $item_id])->update(['status' => $status]);




        if ($update > 0) {
            return response()->json(['success' => 'success', 'msg' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
        }
    }

    public function harvester_post_delete(Request $request)
    {
        $id = $request->id;

        $delete = DB::table('harvester')->where(['id' => $id])->delete();
        if ($delete) {
            return redirect('krishi-harvester-post-list')->with('success', 'Harvester Deleted Successfully');
        } else {
            return redirect('krishi-harvester-specification')->with('failed', 'Something went wrong');
        }
    }

    public function harvester_filter_data(Request $request)
    {

        $post_type = $request->post_type;
        $status = $request->status;
        $creater_at = $request->creater_at;



        if ($post_type != '') {
            $type_condition = 'where';
            $type_col = 'type';
            $where_type = $post_type;
        } else {
            $type_condition = 'orwhereIn';
            $type_col = 'type';
            $where_type = ['old', 'new'];
        }
        if ($status != '') {
            $status_condition = 'where';
            $status_col = 'status';
            $where_status = $status;
        } else {
            $status_condition = 'orwhere';
            $status_col = 'status';
            $where_status = '';
        }
        if ($creater_at != '') {
            $date_condition = 'whereBetween';
            $date_col = 'created_at';
            $where_date_start = date("Y-m-d 00:00:00", strtotime($creater_at));
            $where_date_end = date("Y-m-d 11:59:59", strtotime($creater_at));
        } else {
            $date_condition = 'orwhereBetween';
            $date_col = 'created_at';
            $where_date_start = '';
            $where_date_end = '';
        }


        $count = DB::table('harvester')->$type_condition($type_col, $where_type)->$status_condition($status_col, $where_status)->$date_condition($date_col, [$where_date_start, $where_date_end])->count();

        if ($count > 0) {
            $hv_data = DB::table('harvester')
                ->$type_condition($type_col, $where_type)
                ->$status_condition($status_col, $where_status)
                ->$date_condition($date_col, [$where_date_start, $where_date_end])
                ->paginate(10);

            foreach ($hv_data as $val) {
            ?>
                <tr>
                    <td><?= $val->created_at ?></td>
                    <td>
                        <?php
                        $brand = DB::table('brand')->where(['id' => $val->brand_id])->first();
                        echo $brand->name;
                        ?>
                    </td>
                    <td>
                        <?php
                        $brand = DB::table('model')->where(['id' => $val->model_id])->first();
                        echo $brand->model_name;
                        ?>
                    </td>
                    <td><?= $val->type ?></td>
                    <td><span class="badge rounded-pill alert-<?php if ($val->status == 1) {
                                                                    echo 'success';
                                                                } else if ($val->status == 0) {
                                                                    echo 'warning';
                                                                } else {
                                                                    echo 'danger';
                                                                } ?>"><?php if ($val->status == 1) {
                                                                            echo 'Approved';
                                                                        } else if ($val->status == 0) {
                                                                            echo 'Pending';
                                                                        } else {
                                                                            echo 'Rejected';
                                                                        } ?></span></td>
                    <td class="text-end">
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{url('krishi-harvester-post-view/'.$val->id)}}">View Post</a>
                                <a class="dropdown-item text-danger" href="{{url('krishi-harvester-post-delete/'.$val->id)}}">Delete</a>
                            </div>
                        </div>
                        <!-- dropdown //end -->
                    </td>
                </tr>
            <?php }
        } else {
            echo '<center>No Data found</center>';
        }
    }

    public function harvester_update(Request $request)
    {
        $update_id = $request->update_id;
        $data = DB::table('harvester')->where(['id' => $update_id])->first();
        $set = $request->set;
        $type = $request->type;
        $title = $request->title;
        $price = $request->price;
        $pincode = $request->pincode;
        $rent_type = $request->rent_type;
        $brnad = $request->brnad;
        if ($request->model_id == '') {
            $model_id = $data->model_id;
        } else {
            $model_id = $request->model_id;
        }

        if ($f_image = $request->file('f_image')) {
            $f_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('f_image')->getClientOriginalName();
            $ext = $request->file('f_image')->getClientOriginalExtension();

            $request->file('f_image')->storeAs('public/harvester', $f_image);
        } else {
            $f_image = $data->front_image;
        }
        if ($l_image = $request->file('l_image')) {
            $l_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('l_image')->getClientOriginalName();
            $ext = $request->file('l_image')->getClientOriginalExtension();

            $request->file('l_image')->storeAs('public/harvester', $l_image);
        } else {
            $l_image = $data->left_image;;
        }
        if ($r_image = $request->file('r_image')) {
            $r_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('r_image')->getClientOriginalName();
            $ext = $request->file('r_image')->getClientOriginalExtension();
            $request->file('r_image')->storeAs('public/harvester', $r_image);
        } else {
            $r_image = $data->right_image;
        }
        if ($b_image = $request->file('b_image')) {
            $b_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('b_image')->getClientOriginalName();
            $ext = $request->file('b_image')->getClientOriginalExtension();
            $request->file('b_image')->storeAs('public/harvester', $b_image);
        } else {
            $b_image = $data->back_image;
        }

        $update = DB::table('harvester')->where(['id' => $update_id])->update([
            'set' => $set, 'type' => $type, 'brand_id' => $brnad, 'model_id' => $model_id, 'title' => $title, 'price' => $price, 'pincode' => $pincode, 'rent_type' => $rent_type,
            'left_image' => $l_image, 'right_image' => $r_image, 'front_image' => $f_image,
            'back_image' => $b_image
        ]);
        if ($update) {
            return redirect('krishi-harvester-post-view/' . $update_id)->with('success', 'Harvester Updated Successfully');
        } else {
            return redirect('krishi-harvester-post-view/' . $update_id)->with('failed', 'Something went wrong');
        }
    }




    /******** implements *************/













    public function implements_brand(Request $request)
    {
        $arr = [];
        $arr = DB::table('brand')->where(['status' => 1, 'category_id' => 5])->get();
        return view('admin.implements.brand', ['get' => $arr]);
    }

    public function implements_brand_submit(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required'
        ]);
        $brand_name = $request->brand_name;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/brands', $file);
        } else {
            $file = '';
        }
        $insert = DB::table('brand')->insert(['category_id' => 5, 'name' => $brand_name, 'logo' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-implements-brand')->with('success', 'Brand Added Successfully');
        } else {
            return redirect('krishi-implements-brand')->with('failed', 'Failed! Something Went Wrong');
        }
    }

    public function implements_brand_edit(Request $request)
    {
        $id = $request->id;

        $arr = [];
        $arr = DB::table('brand')->where(['status' => 1, 'category_id' => 5])->get();

        $edit_data = DB::table('brand')->where(['id' => $id])->first();
        return view('admin.implements.brand_edit', ['edit_data' => $edit_data, 'get' => $arr]);
    }

    public function implements_brand_update(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required'
        ]);
        $brand_id = $request->brand_id;
        $brand_name = $request->brand_name;

        $b_arr = DB::table('brand')->where(['id' => $brand_id])->first();
        $logo = $b_arr->logo;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/brands', $file);
        } else {
            $file = $logo;
        }

        $update = DB::table('brand')->where(['id' => $brand_id])->update(['name' => $brand_name, 'logo' => $file]);
        if ($update) {
            return redirect('krishi-implements-brand-edit/' . $brand_id)->with('success', 'Brand Updated Successfully');
        } else {
            return redirect('krishi-implements-brand-edit/' . $brand_id)->with('failed', 'Something went wrong');
        }
    }

    public function implements_brand_delete(Request $request)
    {
        $id = $request->id;

        $model_count = DB::table('model')->where(['brand_id' => $id])->count();
        if ($model_count > 0) {
            return redirect('krishi-implements-brand')->with('failed', 'First Delete Model');
        } else {
            $delete = DB::table('brand')->where(['id' => $id])->delete();
            if ($delete) {
                return redirect('krishi-implements-brand')->with('success', 'Brand Deleted Successfully');
            } else {
                return redirect('krishi-implements-brand')->with('failed', 'Failed');
            }
        }
    }

    public function implements_model(Request $request)
    {
        $get = DB::table('model')->where(['status' => 1, 'company_id' => 5])->get();

        return view('admin.implements.model', ['get' => $get]);
    }

    public function implements_model_submit(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required'
        ]);
        $brand_id = $request->brand_id;
        $model = $request->model;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/model', $file);
        } else {
            $file = '';
        }

        $insert = DB::table('model')->insert(['company_id' => 5, 'brand_id' => $brand_id, 'model_name' => $model, 'icon' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-implements-model')->with('success', 'Model Added Successfully');
        } else {
            return redirect('krishi-implements-model')->with('failed', 'Something went wrong');
        }
    }

    public function implements_model_edit(Request $request)
    {
        $id = $request->id;
        $edit_data = DB::table('model')->where(['id' => $id])->first();
        $get = DB::table('model')->where(['status' => 1, 'company_id' => 5])->get();

        return view('admin.implements.model_edit', ['edit_data' => $edit_data, 'get' => $get]);
    }

    public function implements_model_update(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required'
        ]);
        $model_id = $request->model_id;
        $brand_id = $request->brand_id;
        $model = $request->model;

        $m_arr = DB::table('model')->where(['id' => $model_id])->first();
        $icon = $m_arr->icon;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/model', $file);
        } else {
            $file = $icon;
        }

        $update = DB::table('model')->where(['id' => $model_id])->update(['brand_id' => $brand_id, 'model_name' => $model, 'icon' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($update) {
            return redirect('krishi-implements-model-edit/' . $model_id)->with('success', 'Model Updated Successfully');
        } else {
            return redirect('krishi-implements-model-edit/' . $model_id)->with('failed', 'Something went wrong');
        }
    }

    public function implements_model_delete(Request $request)
    {
        $id = $request->id;

        $post_count = DB::table('implements')->where(['model_id' => $id])->count();
        if ($post_count > 0) {
            return redirect('krishi-implements-model')->with('failed', 'First Delete Post');
        } else {
            $delete = DB::table('model')->where(['id' => $id])->delete();
            if ($delete) {
                return redirect('krishi-implements-model')->with('success', 'Brand Deleted Successfully');
            } else {
                return redirect('krishi-implements-model')->with('failed', 'Failed');
            }
        }
    }

    public function implements_specification()
    {
        $get =    DB::table('specifications')
            ->join('model', 'model.id', '=', 'specifications.model_id')
            ->where('model.company_id', 5)
            ->get('specifications.*');
        return view('admin.implements.specification', ['get' => $get]);
    }



    public function implements_specification_submit(Request $request)
    {
        $validatedData = $request->validate([
            'specification' => 'required',
            'value' => 'required'
        ]);
        $brand = $request->brand;
        $model = $request->model;
        $specification = $request->specification;
        $value = $request->value;

        $insert = DB::table('specifications')->insert(['model_id' => $model, 'spec_name' => $specification, 'value' => $value, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-implements-specification')->with('success', 'Specification added Successfully');
        } else {
            return redirect('krishi-implements-specification')->with('failed', 'Something went wrong');
        }
    }


    public function implements_specification_edit(Request $request)
    {
        $id = $request->id;
        $edit_data = DB::table('specifications')->where(['id' => $id])->first();
        $get =    DB::table('specifications')
            ->join('model', 'model.id', '=', 'specifications.model_id')
            ->where('model.company_id', 5)
            ->get('specifications.*');
        return view('admin.implements.specification_edit', ['get' => $get, 'edit_data' => $edit_data]);
    }


    public function implements_specification_update(Request $request)
    {
        $validatedData = $request->validate([
            'specification' => 'required',
            'value' => 'required'
        ]);
        $specification_id = $request->specification_id;
        $brand = $request->brand;
        $model = $request->model;
        $specification = $request->specification;
        $value = $request->value;

        $update = DB::table('specifications')->where(['id' => $specification_id])->update([
            'model_id' => $model, 'spec_name' => $specification, 'value' => $value, 'status' => 1, 'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($update) {
            return redirect('krishi-implements-specification-edit/' . $specification_id)->with('success', 'Specification updated Successfully');
        } else {
            return redirect('krishi-implements-specification-edit/' . $specification_id)->with('failed', 'Something went wrong');
        }
    }

    public function implements_specification_delete(Request $request)
    {
        $id = $request->id;

        $delete = DB::table('specifications')->where(['id' => $id])->delete();
        if ($delete) {
            return redirect('krishi-implements-specification')->with('success', 'Specification deleted Successfully');
        } else {
            return redirect('krishi-implements-specification')->with('failed', 'Something went wrong');
        }
    }



    public function implements_post_list()
    {
        return view('admin.implements.post_list');
    }

    public function implements_post_view(Request $request)
    {
        $id = $request->id;
        $arr = implement_model::implement_single($id, '');
        $post_lead_user = DB::table('seller_leads as s')
            ->select('u.name', 'u.mobile', 'u.user_type_id', 'u.zipcode')
            ->leftJoin('user as u', 'u.id', '=', 's.user_id')
            ->where('s.post_id', $id)
            ->where('s.category_id', 5)
            ->get();

        $offline_lead = OfflineLead::where(['post_id'=> $id , 'category_id'=> 5])->get();
        return view('admin.implements.post_details', ['data' => $arr, 'post_lead_user' => $post_lead_user , 'offline_lead' => $offline_lead]);
    }

    public function implements_status_change(Request $request)
    {
        $status = $request->status_change;
        $item_id = $request->item_id;
        if ($status == 'pending') {
            $status = 0;
            $user_id = DB::table('implements')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_send = sms::post_pending($mobile, 1);
        } else if ($status == 'Approved') {
            $status = 1;

            $user_id = DB::table('implements')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_approve = sms::post_approve($mobile, 1);

            /*$message = 'Your product has been approved and listed on Krishi Vikas Udyog. Now, your products are ready to reach a wider audience. | Krishi Vikas';
            	$encode_message = urlencode($message);
                $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$mobile.'&message='.$encode_message.'&format=json';
                $ch = curl_init();   
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
                curl_setopt($ch, CURLOPT_URL, $url);   
                $res = curl_exec($ch); */
        } else if ($status == 'sold') {
            $status = 4;
            $user_id = DB::table('implements')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            // $notification_send = sms::post_pending($mobile,1);
        } else {
            $status = 2;

            $user_id = DB::table('implements')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_reject = sms::post_reject($mobile, 1);
        }
        $update = DB::table('implements')->where(['id' => $item_id])->update(['status' => $status]);




        if ($update > 0) {
            return response()->json(['success' => 'success', 'msg' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
        }
    }

    public function implements_post_delete(Request $request)
    {
        $id = $request->id;

        $delete = DB::table('implements')->where(['id' => $id])->delete();
        if ($delete) {
            return redirect('krishi-implements-post-list')->with('success', 'implements Deleted Successfully');
        } else {
            return redirect('krishi-implements-specification')->with('failed', 'Something went wrong');
        }
    }

    public function implements_filter_data(Request $request)
    {
        $post_type = $request->post_type;
        $status = $request->status;
        $creater_at = $request->creater_at;


        if ($post_type != '') {
            $type_condition = 'where';
            $type_col = 'type';
            $where_type = $post_type;
        } else {
            $type_condition = 'orwhereIn';
            $type_col = 'type';
            $where_type = ['old', 'new'];
        }
        if ($status != '') {
            $status_condition = 'where';
            $status_col = 'status';
            $where_status = $status;
        } else {
            $status_condition = 'orwhere';
            $status_col = 'status';
            $where_status = '';
        }
        if ($creater_at != '') {
            $date_condition = 'whereBetween';
            $date_col = 'created_at';
            $where_date_start = date("Y-m-d 00:00:00", strtotime($creater_at));
            $where_date_end = date("Y-m-d 11:59:59", strtotime($creater_at));
        } else {
            $date_condition = 'orwhereBetween';
            $date_col = 'created_at';
            $where_date_start = '';
            $where_date_end = '';
        }


        $count = DB::table('implements')->$type_condition($type_col, $where_type)->$status_condition($status_col, $where_status)->$date_condition($date_col, [$where_date_start, $where_date_end])->count();

        if ($count > 0) {
            $im_data = DB::table('implements')
                ->$type_condition($type_col, $where_type)
                ->$status_condition($status_col, $where_status)
                ->$date_condition($date_col, [$where_date_start, $where_date_end])
                ->paginate(10);

            foreach ($im_data as $val) {
            ?>
                <tr>
                    <td><?= $val->created_at ?></td>
                    <td>
                        <?php
                        $brand = DB::table('brand')->where(['id' => $val->brand_id])->first();
                        echo $brand->name;
                        ?>
                    </td>
                    <td>
                        <?php
                        $brand = DB::table('model')->where(['id' => $val->model_id])->first();
                        echo $brand->model_name;
                        ?>
                    </td>
                    <td><?= $val->type ?></td>
                    <td><span class="badge rounded-pill alert-<?php if ($val->status == 1) {
                                                                    echo 'success';
                                                                } else if ($val->status == 0) {
                                                                    echo 'warning';
                                                                } else {
                                                                    echo 'danger';
                                                                } ?>"><?php if ($val->status == 1) {
                                                                            echo 'Approved';
                                                                        } else if ($val->status == 0) {
                                                                            echo 'Pending';
                                                                        } else {
                                                                            echo 'Rejected';
                                                                        } ?></span></td>
                    <td class="text-end">
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{url('krishi-implements-post-view/'.$val->id)}}">View Post</a>
                                <a class="dropdown-item text-danger" href="{{url('krishi-implements-post-delete/'.$val->id)}}">Delete</a>
                            </div>
                        </div>
                        <!-- dropdown //end -->
                    </td>
                </tr>
            <?php
            }
        } else {
            echo '<center>No Data found</center>';
        }
    }

    public function implements_update(Request $request)
    {

        $update_id = $request->update_id;
        $data = DB::table('implements')->where(['id' => $update_id])->first();
        $set = $request->set;
        $type = $request->type;
        $title = $request->title;
        $price = $request->price;
        $pincode = $request->pincode;
        $rent_type = $request->rent_type;
        $brnad = $request->brnad;
        if ($request->model_id == '') {
            $model_id = $data->model_id;
        } else {
            $model_id = $request->model_id;
        }

        if ($f_image = $request->file('f_image')) {
            $f_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('f_image')->getClientOriginalName();
            $ext = $request->file('f_image')->getClientOriginalExtension();

            $request->file('f_image')->storeAs('public/implements', $f_image);
        } else {
            $f_image = $data->front_image;
        }
        if ($l_image = $request->file('l_image')) {
            $l_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('l_image')->getClientOriginalName();
            $ext = $request->file('l_image')->getClientOriginalExtension();

            $request->file('l_image')->storeAs('public/implements', $l_image);
        } else {
            $l_image = $data->left_image;;
        }
        if ($r_image = $request->file('r_image')) {
            $r_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('r_image')->getClientOriginalName();
            $ext = $request->file('r_image')->getClientOriginalExtension();
            $request->file('r_image')->storeAs('public/implements', $r_image);
        } else {
            $r_image = $data->right_image;
        }
        if ($b_image = $request->file('b_image')) {
            $b_image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('b_image')->getClientOriginalName();
            $ext = $request->file('b_image')->getClientOriginalExtension();
            $request->file('b_image')->storeAs('public/implements', $b_image);
        } else {
            $b_image = $data->back_image;
        }

        $update = DB::table('implements')->where(['id' => $update_id])->update([
            'set' => $set, 'type' => $type, 'brand_id' => $brnad, 'model_id' => $model_id, 'title' => $title, 'price' => $price, 'pincode' => $pincode, 'rent_type' => $rent_type,
            'left_image' => $l_image, 'right_image' => $r_image, 'front_image' => $f_image, 'back_image' => $b_image
        ]);
        if ($update) {
            return redirect('krishi-implements-post-view/' . $update_id)->with('success', 'Implements Updated Successfully');
        } else {
            return redirect('krishi-implements-post-view/' . $update_id)->with('failed', 'Something went wrong');
        }
    }



    /******** seeds *********/

    public function seeds_post_list()
    {
        return view('admin.seeds.post_list');
    }

    public function seeds_post_view(Request $request)
    {
        $id = $request->id;
        $arr = seed_model::seed_single($id, '');
        $post_lead_user = DB::table('seller_leads as s')
            ->select('u.name', 'u.mobile', 'u.user_type_id', 'u.zipcode')
            ->leftJoin('user as u', 'u.id', '=', 's.user_id')
            ->where('s.post_id', $id)
            ->where('s.category_id', 6)
            ->get();

        $offline_lead = OfflineLead::where(['post_id'=> $id , 'category_id'=> 6])->get();
        return view('admin.seeds.post_details', ['data' => $arr, 'post_lead_user' => $post_lead_user , 'offline_lead' => $offline_lead]);
    }

    public function seeds_status_change(Request $request)
    {
        $status = $request->status_change;
        $item_id = $request->item_id;
        if ($status == 'pending') {
            $status = 0;
            $user_id = DB::table('seeds')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_send = sms::post_pending($mobile, 1);
        } else if ($status == 'Approved') {
            $status = 1;

            $user_id = DB::table('seeds')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_approve = sms::post_approve($mobile, 1);

            /*$message = 'Your product has been approved and listed on Krishi Vikas Udyog. Now, your products are ready to reach a wider audience. | Krishi Vikas';
            	$encode_message = urlencode($message);
                $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$mobile.'&message='.$encode_message.'&format=json';
                $ch = curl_init();   
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
                curl_setopt($ch, CURLOPT_URL, $url);   
                $res = curl_exec($ch);*/
        } else {
            $status = 2;

            $user_id = DB::table('seeds')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_reject = sms::post_reject($mobile, 1);
        }
        $update = DB::table('seeds')->where(['id' => $item_id])->update(['status' => $status]);




        if ($update > 0) {
            return response()->json(['success' => 'success', 'msg' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
        }
    }

    public function seeds_post_delete(Request $request)
    {
        $id = $request->id;

        $delete = DB::table('seeds')->where(['id' => $id])->delete();
        if ($delete) {
            return redirect('krishi-seeds-post-list')->with('success', 'Seeds Deleted Successfully');
        } else {
            return redirect('krishi-seeds-specification')->with('failed', 'Something went wrong');
        }
    }

    public function seed_filter_data(Request $request)
    {
        dd($request->all());

        $status = $request->status;
        $creater_at = $request->creater_at;


        if ($status != '') {
            $status_condition = 'where';
            $status_col = 'status';
            $where_status = $status;
        } else {
            $status_condition = 'orwhere';
            $status_col = 'status';
            $where_status = '';
        }
        if ($creater_at != '') {
            $date_condition = 'whereBetween';
            $date_col = 'created_at';
            $where_date_start = date("Y-m-d 00:00:00", strtotime($creater_at));
            $where_date_end = date("Y-m-d 11:59:59", strtotime($creater_at));
        } else {
            $date_condition = 'orwhereBetween';
            $date_col = 'created_at';
            $where_date_start = '';
            $where_date_end = '';
        }


        $count = DB::table('seeds')->$status_condition($status_col, $where_status)->$date_condition($date_col, [$where_date_start, $where_date_end])->count();

        if ($count > 0) {
            $sd_data = DB::table('seeds')
                ->$status_condition($status_col, $where_status)
                ->$date_condition($date_col, [$where_date_start, $where_date_end])
                ->paginate(10);

            foreach ($sd_data as $val) {
            ?>
                <tr>
                    <td><?= $val->created_at ?></td>
                    <td>
                        <?= $val->title; ?>
                    </td>
                    <td><span class="badge rounded-pill alert-<?php if ($val->status == 1) {
                                                                    echo 'success';
                                                                } else if ($val->status == 0) {
                                                                    echo 'warning';
                                                                } else {
                                                                    echo 'danger';
                                                                } ?>"><?php if ($val->status == 1) {
                                                                            echo 'Approved';
                                                                        } else if ($val->status == 0) {
                                                                            echo 'Pending';
                                                                        } else {
                                                                            echo 'Rejected';
                                                                        } ?></span></td>
                    <td class="text-end">
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{url('krishi-seeds-post-view/'.$val->id)}}">View Post</a>
                                <a class="dropdown-item text-danger" href="{{url('krishi-seeds-post-delete/'.$val->id)}}">Delete</a>
                            </div>
                        </div>
                        <!-- dropdown //end -->
                    </td>
                </tr>
            <?php }
        } else {
            echo '<center>No Data found</center>';
        }
    }

    public function seeds_update(Request $request)
    {

        $update_id = $request->update_id;
        $data = DB::table('seeds')->where(['id' => $update_id])->first();
        $title = $request->title;
        $price = $request->price;
        $pincode = $request->pincode;

        if ($image1 = $request->file('image1')) {
            $image1 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image1')->getClientOriginalName();
            $ext = $request->file('image1')->getClientOriginalExtension();

            $request->file('image1')->storeAs('public/seeds', $image1);
        } else {
            $image1 = $data->image1;
        }
        if ($image2 = $request->file('image2')) {
            $image2 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image2')->getClientOriginalName();
            $ext = $request->file('image2')->getClientOriginalExtension();

            $request->file('image2')->storeAs('public/seeds', $image2);
        } else {
            $image2 = $data->image2;
        }
        if ($image3 = $request->file('image3')) {
            $image3 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image3')->getClientOriginalName();
            $ext = $request->file('image3')->getClientOriginalExtension();
            $request->file('image3')->storeAs('public/seeds', $image3);
        } else {
            $image3 = $data->image3;
        }

        $update = DB::table('seeds')->where(['id' => $update_id])->update(['image1' => $image1, 'image2' => $image2, 'image3' => $image3, 'price' => $price, 'pincode' => $pincode, 'title' => $title]);
        if ($update) {
            return redirect('krishi-seeds-post-view/' . $update_id)->with('success', 'Seeds Updated Successfully');
        } else {
            return redirect('krishi-seeds-post-view/' . $update_id)->with('failed', 'Something went wrong');
        }
    }


    /******** pesticides *********/

    public function pesticides_post_list()
    {
        return view('admin.pesticides.post_list');
    }

    public function pesticides_post_view(Request $request)
    {
        $id = $request->id;
        $arr = pesticide__model::pesticides_single($id, '');

        $post_lead_user = DB::table('seller_leads as s')
            ->select('u.name', 'u.mobile', 'u.user_type_id', 'u.zipcode')
            ->leftJoin('user as u', 'u.id', '=', 's.user_id')
            ->where('s.category_id', 8)
            ->where('s.post_id', $id)
            ->get();
        
        $offline_lead = OfflineLead::where(['post_id'=> $id , 'category_id'=> 8])->get();
        return view('admin.pesticides.post_details', ['data' => $arr, 'post_lead_user' => $post_lead_user, 'offline_lead' => $offline_lead]);
    }

    public function pesticides_status_change(Request $request)
    {
        $status = $request->status_change;
        $item_id = $request->item_id;
        if ($status == 'pending') {
            $status = 0;
            $user_id = DB::table('pesticides')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_send = sms::post_pending($mobile, 1);
        } else if ($status == 'Approved') {
            $status = 1;

            $user_id = DB::table('pesticides')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_approve = sms::post_approve($mobile, 1);

            /*$message = 'Your product has been approved and listed on Krishi Vikas Udyog. Now, your products are ready to reach a wider audience. | Krishi Vikas';
            	$encode_message = urlencode($message);
                $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$mobile.'&message='.$encode_message.'&format=json';
                $ch = curl_init();   
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
                curl_setopt($ch, CURLOPT_URL, $url);   
                $res = curl_exec($ch);*/
        } else {
            $status = 2;
            $user_id = DB::table('pesticides')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_reject = sms::post_reject($mobile, 1);
        }
        $update = DB::table('pesticides')->where(['id' => $item_id])->update(['status' => $status]);




        if ($update > 0) {
            return response()->json(['success' => 'success', 'msg' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
        }
    }

    public function pesticides_post_delete(Request $request)
    {
        $id = $request->id;

        $delete = DB::table('pesticides')->where(['id' => $id])->delete();
        if ($delete) {
            return redirect('krishi-pesticides-post-list')->with('success', 'Pesticides Deleted Successfully');
        } else {
            return redirect('krishi-pesticides-specification')->with('failed', 'Something went wrong');
        }
    }

    public function pesticides_filter_data(Request $request)
    {


        $status = $request->status;
        $creater_at = $request->creater_at;


        if ($status != '') {
            $status_condition = 'where';
            $status_col = 'status';
            $where_status = $status;
        } else {
            $status_condition = 'orwhere';
            $status_col = 'status';
            $where_status = '';
        }
        if ($creater_at != '') {
            $date_condition = 'whereBetween';
            $date_col = 'created_at';
            $where_date_start = date("Y-m-d 00:00:00", strtotime($creater_at));
            $where_date_end = date("Y-m-d 11:59:59", strtotime($creater_at));
        } else {
            $date_condition = 'orwhereBetween';
            $date_col = 'created_at';
            $where_date_start = '';
            $where_date_end = '';
        }


        $count = DB::table('pesticides')->$status_condition($status_col, $where_status)->$date_condition($date_col, [$where_date_start, $where_date_end])->count();

        if ($count > 0) {
            $ps_data = DB::table('pesticides')
                ->$status_condition($status_col, $where_status)
                ->$date_condition($date_col, [$where_date_start, $where_date_end])
                ->paginate(10);

            foreach ($ps_data as $val) {
            ?>
                <tr>
                    <td><?= $val->created_at ?></td>
                    <td>
                        <?= $val->title ?>
                    </td>
                    <td><span class="badge rounded-pill alert-<?php if ($val->status == 1) {
                                                                    echo 'success';
                                                                } else if ($val->status == 0) {
                                                                    echo 'warning';
                                                                } else {
                                                                    echo 'danger';
                                                                } ?>"><?php if ($val->status == 1) {
                                                                            echo 'Approved';
                                                                        } else if ($val->status == 0) {
                                                                            echo 'Pending';
                                                                        } else {
                                                                            echo 'Rejected';
                                                                        } ?></span></td>
                    <td class="text-end">
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{url('krishi-pesticides-post-view/'.$val->id)}}">View Post</a>
                                <a class="dropdown-item text-danger" href="{{url('krishi-pesticides-post-delete/'.$val->id)}}">Delete</a>
                            </div>
                        </div>
                        <!-- dropdown //end -->
                    </td>
                </tr>
            <?php }
        } else {
            echo '<center>No Data found</center>';
        }
    }

    public function pesticides_update(Request $request)
    {
        $update_id = $request->update_id;
        $data = DB::table('pesticides')->where(['id' => $update_id])->first();
        $title = $request->title;
        $price = $request->price;
        $pincode = $request->pincode;

        if ($image1 = $request->file('image1')) {
            $image1 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image1')->getClientOriginalName();
            $ext = $request->file('image1')->getClientOriginalExtension();

            $request->file('image1')->storeAs('public/pesticides', $image1);
        } else {
            $image1 = $data->image1;
        }
        if ($image2 = $request->file('image2')) {
            $image2 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image2')->getClientOriginalName();
            $ext = $request->file('image2')->getClientOriginalExtension();

            $request->file('image2')->storeAs('public/pesticides', $image2);
        } else {
            $image2 = $data->image2;
        }
        if ($image3 = $request->file('image3')) {
            $image3 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image3')->getClientOriginalName();
            $ext = $request->file('image3')->getClientOriginalExtension();
            $request->file('image3')->storeAs('public/pesticides', $image3);
        } else {
            $image3 = $data->image3;
        }

        $update = DB::table('pesticides')->where(['id' => $update_id])->update(['image1' => $image1, 'image2' => $image2, 'image3' => $image3, 'price' => $price, 'pincode' => $pincode, 'title' => $title]);
        if ($update) {
            return redirect('krishi-pesticides-post-view/' . $update_id)->with('success', 'Pesticides Updated Successfully');
        } else {
            return redirect('krishi-pesticides-post-view/' . $update_id)->with('failed', 'Something went wrong');
        }
    }



    /******** fertilizers *********/

    public function fertilizers_post_list()
    {
        return view('admin.fertilizers.post_list');
    }

    public function fertilizers_post_view(Request $request)
    {
        $id = $request->id;
        //dd($id);
        $arr = fertilizer_model::fertilizers_single($id, '');

        $post_lead_user = DB::table('seller_leads as s')
            ->select('u.name', 'u.mobile', 'u.user_type_id', 'u.zipcode')
            ->leftJoin('user as u', 'u.id', '=', 's.user_id')
            ->where('s.category_id', 9)
            ->where('s.post_id', $id)
            ->get();

        $offline_lead = OfflineLead::where(['post_id'=> $id , 'category_id'=> 9])->get();
        return view('admin.fertilizers.post_details', ['data' => $arr, 'post_lead_user' => $post_lead_user,'offline_lead' => $offline_lead]);
    }

    public function fertilizers_status_change(Request $request)
    {
        $status = $request->status_change;
        $item_id = $request->item_id;
        if ($status == 'pending') {
            $status = 0;

            $user_id = DB::table('fertilizers')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_send = sms::post_pending($mobile, 1);
        } else if ($status == 'Approved') {
            $status = 1;

            $user_id = DB::table('fertilizers')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_approve = sms::post_approve($mobile, 1);

            /*$message = 'Your product has been approved and listed on Krishi Vikas Udyog. Now, your products are ready to reach a wider audience. | Krishi Vikas';
            	$encode_message = urlencode($message);
                $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$mobile.'&message='.$encode_message.'&format=json';
                $ch = curl_init();   
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
                curl_setopt($ch, CURLOPT_URL, $url);   
                $res = curl_exec($ch); */
        } else {
            $status = 2;
            $user_id = DB::table('fertilizers')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_reject = sms::post_reject($mobile, 1);
        }
        $update = DB::table('fertilizers')->where(['id' => $item_id])->update(['status' => $status]);




        if ($update > 0) {
            return response()->json(['success' => 'success', 'msg' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
        }
    }

    public function fertilizers_post_delete(Request $request)
    {
        $id = $request->id;

        $delete = DB::table('fertilizers')->where(['id' => $id])->delete();
        if ($delete) {
            return redirect('krishi-fertilizers-post-list')->with('success', 'Fertilizers Deleted Successfully');
        } else {
            return redirect('krishi-fertilizers-specification')->with('failed', 'Something went wrong');
        }
    }

    public function fertilizer_filter_data(Request $request)
    {



        $status = $request->status;
        $creater_at = $request->creater_at;


        if ($status != '') {
            $status_condition = 'where';
            $status_col = 'status';
            $where_status = $status;
        } else {
            $status_condition = 'orwhere';
            $status_col = 'status';
            $where_status = '';
        }
        if ($creater_at != '') {
            $date_condition = 'whereBetween';
            $date_col = 'created_at';
            $where_date_start = date("Y-m-d 00:00:00", strtotime($creater_at));
            $where_date_end = date("Y-m-d 11:59:59", strtotime($creater_at));
        } else {
            $date_condition = 'orwhereBetween';
            $date_col = 'created_at';
            $where_date_start = '';
            $where_date_end = '';
        }


        $count = DB::table('fertilizers')->$status_condition($status_col, $where_status)->$date_condition($date_col, [$where_date_start, $where_date_end])->count();

        if ($count > 0) {
            $fl_data = DB::table('fertilizers')
                ->$status_condition($status_col, $where_status)
                ->$date_condition($date_col, [$where_date_start, $where_date_end])
                ->paginate(10);

            foreach ($fl_data as $val) {
            ?>
                <tr>
                    <td><?= $val->created_at ?></td>
                    <td>
                        <?= $val->title ?>
                    </td>
                    <td><span class="badge rounded-pill alert-<?php if ($val->status == 1) {
                                                                    echo 'success';
                                                                } else if ($val->status == 0) {
                                                                    echo 'warning';
                                                                } else {
                                                                    echo 'danger';
                                                                } ?>"><?php if ($val->status == 1) {
                                                                            echo 'Approved';
                                                                        } else if ($val->status == 0) {
                                                                            echo 'Pending';
                                                                        } else {
                                                                            echo 'Rejected';
                                                                        } ?></span></td>
                    <td class="text-end">
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{url('krishi-fertilizers-post-view/'.$val->id)}}">View Post</a>
                                <a class="dropdown-item text-danger" href="{{url('krishi-fertilizers-post-delete/'.$val->id)}}">Delete</a>
                            </div>
                        </div>
                        <!-- dropdown //end -->
                    </td>
                </tr>
            <?php }
        } else {
            echo '<center>No Data found</center>';
        }
    }

    public function fertilizer_update(Request $request)
    {
        $update_id = $request->update_id;
        $data = DB::table('fertilizers')->where(['id' => $update_id])->first();
        $title = $request->title;
        $price = $request->price;
        $pincode = $request->pincode;

        if ($image1 = $request->file('image1')) {
            $image1 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image1')->getClientOriginalName();
            $ext = $request->file('image1')->getClientOriginalExtension();

            $request->file('image1')->storeAs('public/fertilizers', $image1);
        } else {
            $image1 = $data->image1;
        }
        if ($image2 = $request->file('image2')) {
            $image2 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image2')->getClientOriginalName();
            $ext = $request->file('image2')->getClientOriginalExtension();

            $request->file('image2')->storeAs('public/fertilizers', $image2);
        } else {
            $image2 = $data->image2;
        }
        if ($image3 = $request->file('image3')) {
            $image3 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image3')->getClientOriginalName();
            $ext = $request->file('image3')->getClientOriginalExtension();
            $request->file('image3')->storeAs('public/fertilizers', $image3);
        } else {
            $image3 = $data->image3;
        }

        $update = DB::table('fertilizers')->where(['id' => $update_id])->update(['image1' => $image1, 'image2' => $image2, 'image3' => $image3, 'price' => $price, 'pincode' => $pincode, 'title' => $title]);
        if ($update) {
            return redirect('krishi-fertilizers-post-view/' . $update_id)->with('success', 'Fertilizer Updated Successfully');
        } else {
            return redirect('krishi-fertilizers-post-view/' . $update_id)->with('failed', 'Something went wrong');
        }
    }


    /******** tyre *************/













    public function tyre_brand(Request $request)
    {
        $arr = [];
        $arr = DB::table('brand')->where(['status' => 1, 'category_id' => 7])->get();
        return view('admin.tyre.brand', ['get' => $arr]);
    }

    public function tyre_brand_submit(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required'
        ]);
        $brand_name = $request->brand_name;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/brands', $file);
        } else {
            $file = '';
        }
        $insert = DB::table('brand')->insert(['category_id' => 7, 'name' => $brand_name, 'logo' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-tyre-brand')->with('success', 'Brand Added Successfully');
        } else {
            return redirect('krishi-tyre-brand')->with('failed', 'Failed! Something Went Wrong');
        }
    }

    public function tyre_brand_edit(Request $request)
    {
        $id = $request->id;

        $arr = [];
        $arr = DB::table('brand')->where(['status' => 1, 'category_id' => 7])->get();

        $edit_data = DB::table('brand')->where(['id' => $id])->first();
        return view('admin.tyre.brand_edit', ['edit_data' => $edit_data, 'get' => $arr]);
    }

    public function tyre_brand_update(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required'
        ]);
        $brand_id = $request->brand_id;
        $brand_name = $request->brand_name;

        $b_arr = DB::table('brand')->where(['id' => $brand_id])->first();
        $logo = $b_arr->logo;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/brands', $file);
        } else {
            $file = $logo;
        }

        $update = DB::table('brand')->where(['id' => $brand_id])->update(['name' => $brand_name, 'logo' => $file]);
        if ($update) {
            return redirect('krishi-tyre-brand-edit/' . $brand_id)->with('success', 'Brand Updated Successfully');
        } else {
            return redirect('krishi-tyre-brand-edit/' . $brand_id)->with('failed', 'Something went wrong');
        }
    }

    public function tyre_brand_delete(Request $request)
    {
        $id = $request->id;

        $model_count = DB::table('model')->where(['brand_id' => $id])->count();
        if ($model_count > 0) {
            return redirect('krishi-tyre-brand')->with('failed', 'First Delete Model');
        } else {
            $delete = DB::table('brand')->where(['id' => $id])->delete();
            if ($delete) {
                return redirect('krishi-tyre-brand')->with('success', 'Brand Deleted Successfully');
            } else {
                return redirect('krishi-tyre-brand')->with('failed', 'Failed');
            }
        }
    }

    public function tyre_model(Request $request)
    {
        $get = DB::table('model')->where(['status' => 1, 'company_id' => 7])->get();
        return view('admin.tyre.model', ['get' => $get]);
    }

    public function tyre_model_submit(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required'
        ]);
        $brand_id = $request->brand_id;
        $model = $request->model;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/model', $file);
        } else {
            $file = '';
        }

        $insert = DB::table('model')->insert(['company_id' => 7, 'brand_id' => $brand_id, 'model_name' => $model, 'icon' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-tyre-model')->with('success', 'Model Added Successfully');
        } else {
            return redirect('krishi-tyre-model')->with('failed', 'Something went wrong');
        }
    }

    public function tyre_model_edit(Request $request)
    {
        $id = $request->id;
        $edit_data = DB::table('model')->where(['id' => $id])->first();
        $get = DB::table('model')->where(['status' => 1, 'company_id' => 7])->get();

        return view('admin.tyre.model_edit', ['edit_data' => $edit_data, 'get' => $get]);
    }

    public function tyre_model_update(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required'
        ]);
        $model_id = $request->model_id;
        $brand_id = $request->brand_id;
        $model = $request->model;

        $m_arr = DB::table('model')->where(['id' => $model_id])->first();
        $icon = $m_arr->icon;

        if ($photo = $request->file('file')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('file')->getClientOriginalName();
            $ext = $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/images/model', $file);
        } else {
            $file = $icon;
        }

        $update = DB::table('model')->where(['id' => $model_id])->update(['brand_id' => $brand_id, 'model_name' => $model, 'icon' => $file, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($update) {
            return redirect('krishi-tyre-model-edit/' . $model_id)->with('success', 'Model Updated Successfully');
        } else {
            return redirect('krishi-tyre-model-edit/' . $model_id)->with('failed', 'Something went wrong');
        }
    }

    public function tyre_model_delete(Request $request)
    {
        $id = $request->id;

        $post_count = DB::table('tyres')->where(['model_id' => $id])->count();
        if ($post_count > 0) {
            return redirect('krishi-tyre-model')->with('failed', 'First Delete Post');
        } else {
            $delete = DB::table('model')->where(['id' => $id])->delete();
            if ($delete) {
                return redirect('krishi-tyre-model')->with('success', 'Brand Deleted Successfully');
            } else {
                return redirect('krishi-tyre-model')->with('failed', 'Failed');
            }
        }
    }

    public function tyre_specification()
    {
        $get =    DB::table('specifications')
            ->join('model', 'model.id', '=', 'specifications.model_id')
            ->where('model.company_id', 7)
            ->get('specifications.*');
        return view('admin.tyre.specification', ['get' => $get]);
    }



    public function tyre_specification_submit(Request $request)
    {
        $validatedData = $request->validate([
            'specification' => 'required',
            'value' => 'required'
        ]);
        $brand = $request->brand;
        $model = $request->model;
        $specification = $request->specification;
        $value = $request->value;

        $insert = DB::table('specifications')->insert(['model_id' => $model, 'spec_name' => $specification, 'value' => $value, 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        if ($insert) {
            return redirect('krishi-tyre-specification')->with('success', 'Specification added Successfully');
        } else {
            return redirect('krishi-tyre-specification')->with('failed', 'Something went wrong');
        }
    }


    public function tyre_specification_edit(Request $request)
    {
        $id = $request->id;
        $edit_data = DB::table('specifications')->where(['id' => $id])->first();
        $get =    DB::table('specifications')
            ->join('model', 'model.id', '=', 'specifications.model_id')
            ->where('model.company_id', 7)
            ->get('specifications.*');
        return view('admin.tyre.specification_edit', ['get' => $get, 'edit_data' => $edit_data]);
    }


    public function tyre_specification_update(Request $request)
    {
        $validatedData = $request->validate([
            'specification' => 'required',
            'value' => 'required'
        ]);
        $specification_id = $request->specification_id;
        $brand = $request->brand;
        $model = $request->model;
        $specification = $request->specification;
        $value = $request->value;

        $update = DB::table('specifications')->where(['id' => $specification_id])->update([
            'model_id' => $model, 'spec_name' => $specification, 'value' => $value, 'status' => 1, 'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($update) {
            return redirect('krishi-tyre-specification-edit/' . $specification_id)->with('success', 'Specification updated Successfully');
        } else {
            return redirect('krishi-tyre-specification-edit/' . $specification_id)->with('failed', 'Something went wrong');
        }
    }

    public function tyre_specification_delete(Request $request)
    {
        $id = $request->id;

        $delete = DB::table('specifications')->where(['id' => $id])->delete();
        if ($delete) {
            return redirect('krishi-tyre-specification')->with('success', 'Specification deleted Successfully');
        } else {
            return redirect('krishi-tyre-specification')->with('failed', 'Something went wrong');
        }
    }

    public function tyre_post_list()
    {
        return view('admin.tyre.post_list');
    }

    public function tyre_post_view(Request $request)
    {
        $id = $request->id;
        $arr = tyre_model::tyre_single($id, '');

        $post_lead_user = DB::table('seller_leads as s')
            ->select('u.name', 'u.mobile', 'u.user_type_id', 'u.zipcode')
            ->leftJoin('user as u', 'u.id', '=', 's.user_id')
            ->where('s.post_id', $id)
            ->where('s.category_id', 7)
            ->get();

        $offline_lead = OfflineLead::where(['post_id'=> $id , 'category_id'=> 7])->get();
        return view('admin.tyre.post_details', ['data' => $arr, 'post_lead_user' => $post_lead_user , 'offline_lead' => $offline_lead]);
    }

    public function tyre_status_change(Request $request)
    {
        $status = $request->status_change;
        $item_id = $request->item_id;
        if ($status == 'pending') {
            $status = 0;

            $user_id = DB::table('tyres')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_send = sms::post_pending($mobile, 1);
        } else if ($status == 'Approved') {
            $status = 1;

            $user_id = DB::table('tyres')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_approve = sms::post_approve($mobile, 1);

            /*$message = 'Your product has been approved and listed on Krishi Vikas Udyog. Now, your products are ready to reach a wider audience. | Krishi Vikas';
            	$encode_message = urlencode($message);
                $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$mobile.'&message='.$encode_message.'&format=json';
                $ch = curl_init();   
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
                curl_setopt($ch, CURLOPT_URL, $url);   
                $res = curl_exec($ch); */
        } else if ($status == 'sold') {
            $status = 4;
            $user_id = DB::table('tyres')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            // $notification_send = sms::post_pending($mobile,1);
        } else {
            $status = 2;

            $user_id = DB::table('tyres')->where(['id' => $item_id])->value('user_id');
            $mobile = DB::table('user')->where(['id' => $user_id])->value('mobile');

            $notification_reject = sms::post_reject($mobile, 1);
        }
        $update = DB::table('tyres')->where(['id' => $item_id])->update(['status' => $status]);




        if ($update > 0) {
            return response()->json(['success' => 'success', 'msg' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
        }
    }

    public function tyre_post_delete(Request $request)
    {
        $id = $request->id;

        $delete = DB::table('tyres')->where(['id' => $id])->delete();
        if ($delete) {
            return redirect('krishi-tyre-post-list')->with('success', 'Tyre Deleted Successfully');
        } else {
            return redirect('krishi-tyre-specification')->with('failed', 'Something went wrong');
        }
    }

    public function tyre_filter_data(Request $request)
    {
        $post_type = $request->post_type;
        $status = $request->status;
        $creater_at = $request->creater_at;


        if ($post_type != '') {
            $type_condition = 'where';
            $type_col = 'type';
            $where_type = $post_type;
        } else {
            $type_condition = 'orwhereIn';
            $type_col = 'type';
            $where_type = ['old', 'new'];
        }
        if ($status != '') {
            $status_condition = 'where';
            $status_col = 'status';
            $where_status = $status;
        } else {
            $status_condition = 'orwhere';
            $status_col = 'status';
            $where_status = '';
        }
        if ($creater_at != '') {
            $date_condition = 'whereBetween';
            $date_col = 'created_at';
            $where_date_start = date("Y-m-d 00:00:00", strtotime($creater_at));
            $where_date_end = date("Y-m-d 11:59:59", strtotime($creater_at));
        } else {
            $date_condition = 'orwhereBetween';
            $date_col = 'created_at';
            $where_date_start = '';
            $where_date_end = '';
        }


        $count = DB::table('tyres')->$type_condition($type_col, $where_type)->$status_condition($status_col, $where_status)->$date_condition($date_col, [$where_date_start, $where_date_end])->count();

        if ($count > 0) {
            $im_data = DB::table('tyres')
                ->$type_condition($type_col, $where_type)
                ->$status_condition($status_col, $where_status)
                ->$date_condition($date_col, [$where_date_start, $where_date_end])
                ->paginate(10);

            foreach ($im_data as $val) {
            ?>
                <tr>
                    <td><?= $val->created_at ?></td>
                    <td>
                        <?php
                        $brand = DB::table('brand')->where(['id' => $val->brand_id])->first();
                        echo $brand->name;
                        ?>
                    </td>
                    <td>
                        <?php
                        $brand = DB::table('model')->where(['id' => $val->model_id])->first();
                        echo $brand->model_name;
                        ?>
                    </td>
                    <td><?= $val->type ?></td>
                    <td><span class="badge rounded-pill alert-<?php if ($val->status == 1) {
                                                                    echo 'success';
                                                                } else if ($val->status == 0) {
                                                                    echo 'warning';
                                                                } else {
                                                                    echo 'danger';
                                                                } ?>"><?php if ($val->status == 1) {
                                                                            echo 'Approved';
                                                                        } else if ($val->status == 0) {
                                                                            echo 'Pending';
                                                                        } else {
                                                                            echo 'Rejected';
                                                                        } ?></span></td>
                    <td class="text-end">
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{url('krishi-tyre-post-view/'.$val->id)}}">View Post</a>
                                <a class="dropdown-item text-danger" href="{{url('krishi-tyre-post-delete/'.$val->id)}}">Delete</a>
                            </div>
                        </div>
                        <!-- dropdown //end -->
                    </td>
                </tr>
<?php }
        } else {
            echo '<center>No Data found</center>';
        }
    }

    public function tyre_update(Request $request)
    {
        $update_id = $request->update_id;

        $data = DB::table('tyres')->where(['id' => $update_id])->first();
        $type = $request->type;
        $title = $request->title;
        $price = $request->price;
        $pincode = $request->pincode;
        $brnad = $request->brnad;
        if ($request->model_id == '') {
            $model_id = $data->model_id;
        } else {
            $model_id = $request->model_id;
        }

        if ($image1 = $request->file('image1')) {
            $image1 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image1')->getClientOriginalName();
            $ext = $request->file('image1')->getClientOriginalExtension();

            $request->file('image1')->storeAs('public/tyre', $image1);
        } else {
            $image1 = $data->image1;
        }
        if ($image2 = $request->file('image2')) {
            $image2 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image2')->getClientOriginalName();
            $ext = $request->file('image2')->getClientOriginalExtension();

            $request->file('image2')->storeAs('public/tyre', $image2);
        } else {
            $image2 = $data->image2;
        }
        if ($image3 = $request->file('image3')) {
            $image3 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image3')->getClientOriginalName();
            $ext = $request->file('image3')->getClientOriginalExtension();
            $request->file('image3')->storeAs('public/tyre', $image3);
        } else {
            $image3 = $data->image3;
        }

        $update = DB::table('tyres')->where(['id' => $update_id])->update(['type' => $type, 'image1' => $image1, 'image2' => $image2, 'image3' => $image3, 'price' => $price, 'pincode' => $pincode, 'title' => $title]);
        if ($update) {
            return redirect('krishi-tyre-post-view/' . $update_id)->with('success', 'Tyres Updated Successfully');
        } else {
            return redirect('krishi-tyre-post-view/' . $update_id)->with('failed', 'Something went wrong');
        }
    }



    /* selelr */
    public function seller_list()
    {
        return view('admin.sellers_list');
    }

    /** Dibyendu Create on 13.09.2023 */
    public function get_seller_details()
    {

        $user       = DB::table('user')->orderBy('id', 'desc')->paginate(10);
        return view('admin.sellers_list', ['user' => $user]);
    }

    /** Dibyendu Create on 13.09.2023 */
    public function searchSeller(Request $request)
    {
        // dd("hi");
        $user = DB::table('user')->where('mobile', 'LIKE', '%' . $request->search_user_list . '%')
            ->orWhere('zipcode', 'LIKE', '%' . $request->search_user_list . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        //dd($user);

        return view('admin.sellers_list', ['user' => $user]);
    }


    public function seller_details(Request $request)
    {
        $id = $request->id;
        $user_data = DB::table('user')->where(['id' => $id])->first();
        $tractor_data = DB::table('tractor')->where(['user_id' => $id])->get();
        $goods_vehicle_data = DB::table('goods_vehicle')->where(['user_id' => $id])->get();
        $harvester_data = DB::table('harvester')->where(['user_id' => $id])->get();
        $implements_data = DB::table('implements')->where(['user_id' => $id])->get();
        $seeds_data = DB::table('seeds')->where(['user_id' => $id])->get();
        $pesticides_data = DB::table('pesticides')->where(['user_id' => $id])->get();
        $fertilizers_data = DB::table('fertilizers')->where(['user_id' => $id])->get();
        $tyres_data = DB::table('tyres')->where(['user_id' => $id])->get();
        return view('admin.seller_details', [
            'user_data' => $user_data, 'tractor_data' => $tractor_data, 'goods_vehicle_data' => $goods_vehicle_data, 'harvester_data' => $harvester_data,
            'implements_data' => $implements_data, 'seeds_data' => $seeds_data, 'pesticides_data' => $pesticides_data, 'fertilizers_data' => $fertilizers_data, 'tyres_data' => $tyres_data
        ]);
    }




    public function profile()
    {
        return view('admin.profile');
    }

    public function setting()
    {
        return view('admin.setting');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function login()
    {
        if (session()->has('admin-krishi')) {
            return redirect('krishi-dashboard');
        } else {
            return view('admin.login');
        }
    }

    public function login_submit(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $username = $request->username;
        $password = $request->password;

        $count = DB::table('admin')->where(['username' => $username, 'password' => $password, 'status' => 1])->count();
        if ($count > 0) {
            session()->put('admin-krishi', $username);
            return redirect('krishi-dashboard')->with('success', 'Login Successfully');
        } else {
            return redirect('krishi-login')->with('failed', 'Login Failed');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('krishi-login');
    }

    public function profile_submit(Request $request)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $phone = $request->phone;
        $dob = $request->dob;

        if ($photo = $request->file('photo')) {
            $file = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('photo')->getClientOriginalName();
            $ext = $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->storeAs('public/admin_photo/', $file);
        } else {
            $file = '';
        }

        $update = DB::table('admin')->where(['username' => session()->get('admin-krishi')])->update([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone_no' => $phone,
            'dob' => $dob,
            'photo' => $file
        ]);

        if ($update) {
            return redirect('krishi-profile')->with('success', 'Profile Submit Successfully');
        } else {
            return redirect('krishi-profile')->with('failed', 'Failed');
        }
    }




    public function dashboard_data(Request $request)
    {
        $category = $request->category;
        $post_type = $request->post_type;
        if ($category == "Tractor") {
            $table = "tractor";
        }
        if ($category == "Goods Vehicle") {
            $table = "goods_vehicle";
        }
        if ($category == "Harvester") {
            $table = "harvester";
        }
        if ($category == "Tyre") {
            $table = "tyres";
        }
        if ($category == "Seeds") {
            $table = "seeds";
        }
        if ($category == "Implements") {
            $table = "implements";
        }
        if ($category == "Pesticides") {
            $table = "pesticides";
        }
        if ($category == "Fertilizers") {
            $table = "fertilizers";
        }

        if ($post_type == 'all') {
            $post_type = "";
        } else if ($post_type == 'new') {
            $post_type = "new";
        } else if ($post_type == 'old') {
            $post_type = "old";
        } else if ($post_type == 'rent') {
            $post_type = "rent";
        }

        DB::table($table)->orderBy('id', 'desc')->skip(0)->take(20)->get();
    }




    public function push_notification()
    {

        return view('admin.push_notification.push_noti');
    }


    public function notification_schedule(Request $request)
    {
        $language = $request->language;
        $datepick = $request->datepick;
        $timepick = $request->timepick;
        $title    = $request->title;
        $description = $request->description;
        $image    = $request->image;
        $time = explode(':', $timepick);
        $hour = $time[0];
        $validatedData = $request->validate([
            'language' => 'required',
            'datepick' => 'required',
            'timepick' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        if ($photo = $request->file('image')) {
            $photo = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image')->getClientOriginalName();
            $ext = $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/push_notification', $photo);
            $img = asset("storage/push_notification/" . $photo);
        } else {
            $img = '';
        }

        $data = DB::table('push_notification')->insert(['tiltle' => $title, 'deception' => $description, 'img' => $img, 'language_id' => $language, 'status' => 0, 'date_time' => date('y-m-d H:i:s'), 'date' => $datepick, 'time' => $timepick, 'hour' => $hour]);
        if ($data) {
            session()->flash('success', 'Push Notification Added Successfully');
        } else {
            session()->flash('success', 'Failed!');
        }
        return redirect('push-notification');
    }

    public function notification_schedule_list()
    {
        $arr = DB::table('push_notification')->orderBy('id', 'desc')->get();
        return view('admin.push_notification.push_noti_list', ['arr' => $arr]);
    }

    public function push_notification_deactive(Request $request)
    {
        $id = $request->id;
        $update = DB::table('push_notification')->where(['id' => $id])->update(['status' => 3]);
        if ($update) {
            session()->flash('success', 'Deleted Successfully');
        } else {
            session()->flash('success', 'Deleted Successfully');
        }
        return redirect('notification-schedule-list');
    }

    public function push_notification_update(Request $request)
    {
        $id = $request->id;
        $data = DB::table('push_notification')->where(['id' => $id])->first();
        return view('admin.push_notification.push_noti', ['arr' => $data]);
    }

    public function notification_schedule_update(Request $request)
    {
        $sch_id = $request->sch_id;
        $language = $request->language;
        $datepick = $request->datepick;
        $timepick = $request->timepick;
        $title    = $request->title;
        $description = $request->description;
        $image    = $request->image;
        $time = explode(':', $timepick);
        $hour = $time[0];
        $validatedData = $request->validate([
            'language' => 'required',
            'datepick' => 'required',
            'timepick' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($photo = $request->file('image')) {
            $photo = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image')->getClientOriginalName();
            $ext = $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/push_notification', $photo);
            $img = asset("storage/push_notification/" . $photo);
        } else {
            $pdata = DB::table('push_notification')->where(['id' => $sch_id])->first();
            $img = $pdata->img;
        }

        $data = DB::table('push_notification')->where(['id' => $sch_id])->update(['tiltle' => $title, 'deception' => $description, 'img' => $img, 'language_id' => $language, 'status' => 0, 'date_time' => date('y-m-d H:i:s'), 'date' => $datepick, 'time' => $timepick, 'hour' => $hour]);
        if ($data) {
            session()->flash('success', 'Push Notification Updated Successfully');
        } else {
            session()->flash('success', 'Failed!');
        }
        return redirect('push-notification');
    }


    public function test1()
    {

        $id = 'ccsoKWz3RU-wGDU0-bfrms:APA91bEHsk0yVUclutLy25kj8VIB9P2RR4OKEINcVRvxLYnJ2HLFFHdvF9FI1GPomSVpf_4Q_PLGn3lnEo73ssjgzTbkIJ-7w2ekSspnAAhTa_ojfhLMEpgkHuFmbGfKhq1iGFpVKA4v';
        $message = 'abc';

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => array(
                $id
            ),
            'data' => array(
                "message" => $message
            )
        );


        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . "AAAAggkuf0U:APA91bFm8i9J1RBOV_CWq_EzZ8ytDME8NL_gZ4sqKNcpXbgQ8bQ5cFLN-9HMgKM_djMiAhBIqUGb75SV0itt_1Y56AOxE5xXPWDh2_SQH-J96lzZL4UpgVLjkUqKYXNxn-kh9VS55XaN",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);
    }


    public function referral_code_list()
    {
        $data = DB::table('referral_code')->where(['status' => 1])->paginate(10);
        return view('admin.referral_code_list', ['data' => $data]);
    }

    public function krishi_referral_code_user()
    {
        $data = DB::table('user')->where('referral_code', '<>', NULL)->paginate(10);
        return view('admin.userviareferral_code', ['user' => $data]);
    }

    public function transfer_to(Request $request)
    {
        //dd($request->all());
        $operation_to   = $request->operation_to;
        $operation_from = $request->operation_from;
        $operation_id   = $request->operation_id;

        if ($operation_from == 'tractor') {

            $tractor = DB::table('tractor')->where(['id' => $operation_id])->first();
            if ($operation_to == 'gv') {
                if ($tractor->title == NULL) {
                    $tractor->title = 'Good Vehicle';
                }

                $transer = DB::table('goods_vehicle')->insertGetId([
                    'category_id' => 3, 'user_id' => $tractor->user_id, 'set' => $tractor->set, 'type' => $tractor->type, 'brand_id' => 105, 'model_id' => 1049, 'year_of_purchase' => $tractor->year_of_purchase, 'title' => $tractor->title, 'rc_available' => $tractor->rc_available, 'noc_available' => $tractor->noc_available, 'registration_no' => $tractor->registration_no,
                    'description' => $tractor->description, 'left_image' => $tractor->left_image, 'right_image' => $tractor->right_image, 'front_image' => $tractor->front_image, 'back_image' => $tractor->back_image, 'meter_image' => $tractor->meter_image, 'tyre_image' => $tractor->tyre_image, 'price' => $tractor->price, 'rent_type' => $tractor->rent_type, 'is_negotiable' => $tractor->is_negotiable,
                    'pincode' => $tractor->pincode, 'country_id' => $tractor->country_id, 'state_id' => $tractor->state_id, 'district_id' => $tractor->district_id, 'city_id' => $tractor->city_id, 'latlong' => $tractor->latlong, 'status' => $tractor->status, 'created_at' => $tractor->created_at
                ]);
               // dd($transer);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($tractor->left_image != '') {
                    Storage::move('public/tractor/' . $tractor->left_image, 'public/goods_vehicle/' . $tractor->left_image);
                }
                if ($tractor->right_image != '') {
                    Storage::move('public/tractor/' . $tractor->right_image, 'public/goods_vehicle/' . $tractor->right_image);
                }
                if ($tractor->front_image != '') {
                    Storage::move('public/tractor/' . $tractor->front_image, 'public/goods_vehicle/' . $tractor->front_image);
                }
                if ($tractor->back_image != '') {
                    Storage::move('public/tractor/' . $tractor->back_image, 'public/goods_vehicle/' . $tractor->back_image);
                }
                if ($tractor->meter_image != '') {
                    Storage::move('public/tractor/' . $tractor->meter_image, 'public/goods_vehicle/' . $tractor->meter_image);
                }
                if ($tractor->tyre_image != '') {
                    Storage::move('public/tractor/' . $tractor->tyre_image, 'public/goods_vehicle/' . $tractor->tyre_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>3]);
                    }
                }

                DB::table('tractor')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'harvester') {
                if ($tractor->title == NULL) {
                    $tractor->title = 'harvester';
                }

                $transer = DB::table('harvester')->insertGetId([
                    'category_id' => 4, 'user_id' => $tractor->user_id, 'set' => $tractor->set, 'type' => $tractor->type, 'brand_id' => 106, 'model_id' => 1050, 'year_of_purchase' => $tractor->year_of_purchase, 'title' => $tractor->title,
                    'description' => $tractor->description, 'left_image' => $tractor->left_image, 'right_image' => $tractor->right_image, 'front_image' => $tractor->front_image, 'back_image' => $tractor->back_image, 'price' => $tractor->price, 'rent_type' => $tractor->rent_type, 'is_negotiable' => $tractor->is_negotiable,
                    'pincode' => $tractor->pincode, 'country_id' => $tractor->country_id, 'state_id' => $tractor->state_id, 'district_id' => $tractor->district_id, 'city_id' => $tractor->city_id, 'latlong' => $tractor->latlong, 'status' => $tractor->status, 'created_at' => $tractor->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($tractor->left_image != '') {
                    Storage::move('public/tractor/' . $tractor->left_image, 'public/harvester/' . $tractor->left_image);
                }
                if ($tractor->right_image != '') {
                    Storage::move('public/tractor/' . $tractor->right_image, 'public/harvester/' . $tractor->right_image);
                }
                if ($tractor->front_image != '') {
                    Storage::move('public/tractor/' . $tractor->front_image, 'public/harvester/' . $tractor->front_image);
                }
                if ($tractor->back_image != '') {
                    Storage::move('public/tractor/' . $tractor->back_image, 'public/harvester/' . $tractor->back_image);
                }
                if ($tractor->meter_image != '') {
                    Storage::move('public/tractor/' . $tractor->meter_image, 'public/harvester/' . $tractor->meter_image);
                }
                if ($tractor->tyre_image != '') {
                    Storage::move('public/tractor/' . $tractor->tyre_image, 'public/harvester/' . $tractor->tyre_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>4]);
                    }
                }
                

                DB::table('tractor')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'implements') {
                if ($tractor->title == NULL) {
                    $tractor->title = 'Implements';
                }

                $transer = DB::table('implements')->insertGetId([
                    'category_id' => 5, 'user_id' => $tractor->user_id, 'set' => $tractor->set, 'type' => $tractor->type, 'brand_id' => 103, 'model_id' => 1047, 'year_of_purchase' => $tractor->year_of_purchase, 'title' => $tractor->title,
                    'description' => $tractor->description, 'left_image' => $tractor->left_image, 'right_image' => $tractor->right_image, 'front_image' => $tractor->front_image, 'back_image' => $tractor->back_image, 'price' => $tractor->price, 'is_negotiable' => $tractor->is_negotiable,
                    'pincode' => $tractor->pincode, 'country_id' => $tractor->country_id, 'state_id' => $tractor->state_id, 'district_id' => $tractor->district_id, 'city_id' => $tractor->city_id, 'latlong' => $tractor->latlong, 'status' => $tractor->status, 'created_at' => $tractor->created_at
                ]);


                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($tractor->left_image != '') {
                    Storage::move('public/tractor/' . $tractor->left_image, 'public/implements/' . $tractor->left_image);
                }
                if ($tractor->right_image != '') {
                    Storage::move('public/tractor/' . $tractor->right_image, 'public/implements/' . $tractor->right_image);
                }
                if ($tractor->front_image != '') {
                    Storage::move('public/tractor/' . $tractor->front_image, 'public/implements/' . $tractor->front_image);
                }
                if ($tractor->back_image != '') {
                    Storage::move('public/tractor/' . $tractor->back_image, 'public/implements/' . $tractor->back_image);
                }
                if ($tractor->meter_image != '') {
                    Storage::move('public/tractor/' . $tractor->meter_image, 'public/implements/' . $tractor->meter_image);
                }
                if ($tractor->tyre_image != '') {
                    Storage::move('public/tractor/' . $tractor->tyre_image, 'public/implements/' . $tractor->tyre_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>5]);
                    }
                }
                
                DB::table('tractor')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'seeds') {

                if ($tractor->title == NULL) {
                    $tractor->title = 'Seeds';
                }

                $transer = DB::table('seeds')->insertGetId([
                    'category_id' => 6, 'user_id' => $tractor->user_id, 'title' => $tractor->title,
                    'description' => $tractor->description, 'image2' => $tractor->left_image, 'image3' => $tractor->right_image, 'image1' => $tractor->front_image, 'price' => $tractor->price, 'is_negotiable' => $tractor->is_negotiable,
                    'pincode' => $tractor->pincode, 'country_id' => $tractor->country_id, 'state_id' => $tractor->state_id, 'district_id' => $tractor->district_id, 'city_id' => $tractor->city_id, 'latlong' => $tractor->latlong, 'status' => $tractor->status, 'created_at' => $tractor->created_at
                ]);


                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($tractor->left_image != '') {
                    Storage::move('public/tractor/' . $tractor->left_image, 'public/seeds/' . $tractor->left_image);
                }
                if ($tractor->right_image != '') {
                    Storage::move('public/tractor/' . $tractor->right_image, 'public/seeds/' . $tractor->right_image);
                }
                if ($tractor->front_image != '') {
                    Storage::move('public/tractor/' . $tractor->front_image, 'public/seeds/' . $tractor->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/tractor/' . $item->back_image, 'public/seeds/' . $item->back_image);
                }
                if ($item->meter_image != '') {
                    Storage::move('public/tractor/' . $item->meter_image, 'public/seeds/' . $item->meter_image);
                }
                if ($item->tyre_image != '') {
                    Storage::move('public/tractor/' . $item->tyre_image, 'public/seeds/' . $item->tyre_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>6]);
                    }
                }

                DB::table('tractor')->where(['id' => $operation_id])->delete();

            } else if ($operation_to == 'pesticides') {

                if ($tractor->title == NULL) {
                    $tractor->title = 'Pesticides';
                }

                $transer = DB::table('pesticides')->insertGetId([
                    'category_id' => 8, 'user_id' => $tractor->user_id, 'title' => $tractor->title,
                    'description' => $tractor->description, 'image2' => $tractor->left_image, 'image3' => $tractor->right_image, 'image1' => $tractor->front_image, 'price' => $tractor->price, 'is_negotiable' => $tractor->is_negotiable,
                    'pincode' => $tractor->pincode, 'country_id' => $tractor->country_id, 'state_id' => $tractor->state_id, 'district_id' => $tractor->district_id, 'city_id' => $tractor->city_id, 'latlong' => $tractor->latlong, 'status' => $tractor->status, 'created_at' => $tractor->created_at
                ]);


                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($tractor->left_image != '') {
                    Storage::move('public/tractor/' . $tractor->left_image, 'public/pesticides/' . $tractor->left_image);
                }
                if ($tractor->right_image != '') {
                    Storage::move('public/tractor/' . $tractor->right_image, 'public/pesticides/' . $tractor->right_image);
                }
                if ($tractor->front_image != '') {
                    Storage::move('public/tractor/' . $tractor->front_image, 'public/pesticides/' . $tractor->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/tractor/' . $item->back_image, 'public/pesticides/' . $item->back_image);
                }
                if ($item->meter_image != '') {
                    Storage::move('public/tractor/' . $item->meter_image, 'public/pesticides/' . $item->meter_image);
                }
                if ($item->tyre_image != '') {
                    Storage::move('public/tractor/' . $item->tyre_image, 'public/pesticides/' . $item->tyre_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>8]);
                    }
                }
                
                DB::table('tractor')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'fertilizer') {

                if ($tractor->title == NULL) {
                    $tractor->title = 'Fertilizer';
                }

                $transer = DB::table('fertilizers')->insertGetId([
                    'category_id' => 9, 'user_id' => $tractor->user_id, 'title' => $tractor->title,
                    'description' => $tractor->description, 'image2' => $tractor->left_image, 'image3' => $tractor->right_image, 'image1' => $tractor->front_image, 'price' => $tractor->price, 'is_negotiable' => $tractor->is_negotiable,
                    'pincode' => $tractor->pincode, 'country_id' => $tractor->country_id, 'state_id' => $tractor->state_id, 'district_id' => $tractor->district_id, 'city_id' => $tractor->city_id, 'latlong' => $tractor->latlong, 'status' => $tractor->status, 'created_at' => $tractor->created_at
                ]);


                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($tractor->left_image != '') {
                    Storage::move('public/tractor/' . $tractor->left_image, 'public/fertilizers/' . $tractor->left_image);
                }
                if ($tractor->right_image != '') {
                    Storage::move('public/tractor/' . $tractor->right_image, 'public/fertilizers/' . $tractor->right_image);
                }
                if ($tractor->front_image != '') {
                    Storage::move('public/tractor/' . $tractor->front_image, 'public/fertilizers/' . $tractor->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/tractor/' . $item->back_image, 'public/fertilizers/' . $item->back_image);
                }
                if ($item->meter_image != '') {
                    Storage::move('public/tractor/' . $item->meter_image, 'public/fertilizers/' . $item->meter_image);
                }
                if ($item->tyre_image != '') {
                    Storage::move('public/tractor/' . $item->tyre_image, 'public/fertilizers/' . $item->tyre_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>9]);
                    }
                }

                DB::table('tractor')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'tyre') {

                if ($tractor->title == NULL) {
                    $tractor->title = 'Tyre';
                }

                $transer = DB::table('tyres')->insertGetId([
                    'category_id' => 7, 'user_id' => $tractor->user_id, 'type' => $tractor->type, 'brand_id' => 107, 'model_id' => 1052, 'year_of_purchase' => $tractor->year_of_purchase, 'title' => $tractor->title,
                    'description' => $tractor->description, 'image2' => $tractor->left_image, 'image3' => $tractor->right_image, 'image1' => $tractor->front_image, 'price' => $tractor->price, 'is_negotiable' => $tractor->is_negotiable,
                    'pincode' => $tractor->pincode, 'country_id' => $tractor->country_id, 'state_id' => $tractor->state_id, 'district_id' => $tractor->district_id, 'city_id' => $tractor->city_id, 'latlong' => $tractor->latlong, 'status' => $tractor->status, 'created_at' => $tractor->created_at
                ]);


                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($tractor->left_image != '') {
                    Storage::move('public/tractor/' . $tractor->left_image, 'public/tyre/' . $tractor->left_image);
                }
                if ($tractor->right_image != '') {
                    Storage::move('public/tractor/' . $tractor->right_image, 'public/tyre/' . $tractor->right_image);
                }
                if ($tractor->front_image != '') {
                    Storage::move('public/tractor/' . $tractor->front_image, 'public/tyre/' . $tractor->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/tractor/' . $item->back_image, 'public/tyre/' . $item->back_image);
                }
                if ($item->meter_image != '') {
                    Storage::move('public/tractor/' . $item->meter_image, 'public/tyre/' . $item->meter_image);
                }
                if ($item->tyre_image != '') {
                    Storage::move('public/tractor/' . $item->tyre_image, 'public/tyre/' . $item->tyre_image);
                }
                
                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 1])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>7]);
                    }
                }
                DB::table('tractor')->where(['id' => $operation_id])->delete();
            }

            if ($transer > 0) {
                return response()->json(['success' => 'success', 'msg' => 'Transfer successfully', 'goto' => asset('krishi-tractor-post-list')]);
            } else {
                return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
            }
        } else if ($operation_from == 'gv') {

            $item = DB::table('goods_vehicle')->where(['id' => $operation_id])->first();
            if ($operation_to == 'tractor') {
                if ($item->title == NULL) {
                    $item->title = 'Tractor';
                }
                $transer = DB::table('tractor')->insertGetId([
                    'category_id' => 1, 'user_id' => $item->user_id, 'set' => $item->set, 'type' => $item->type, 'brand_id' => 104, 'model_id' => 1048, 'year_of_purchase' => $item->year_of_purchase, 'title' => $item->title, 'rc_available' => $item->rc_available, 'noc_available' => $item->noc_available, 'registration_no' => $item->registration_no,
                    'description' => $item->description, 'left_image' => $item->left_image, 'right_image' => $item->right_image, 'front_image' => $item->front_image, 'back_image' => $item->back_image, 'meter_image' => $item->meter_image, 'tyre_image' => $item->tyre_image, 'price' => $item->price, 'rent_type' => $item->rent_type, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->left_image, 'public/tractor/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->right_image, 'public/tractor/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->front_image, 'public/tractor/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->back_image, 'public/tractor/' . $item->back_image);
                }
                if ($item->meter_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->meter_image, 'public/tractor/' . $item->meter_image);
                }
                if ($item->tyre_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->tyre_image, 'public/tractor/' . $item->tyre_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->get();
               
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>1]);
                    }
                }

                DB::table('goods_vehicle')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'harvester') {
                if ($item->title == NULL) {
                    $item->title = 'harvester';
                }
                $transer = DB::table('harvester')->insertGetId([
                    'category_id' => 4, 'user_id' => $item->user_id, 'set' => $item->set, 'type' => $item->type, 'brand_id' => 106, 'model_id' => 1050, 'year_of_purchase' => $item->year_of_purchase, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->left_image, 'right_image' => $item->right_image, 'front_image' => $item->front_image, 'back_image' => $item->back_image, 'price' => $item->price, 'rent_type' => $item->rent_type, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);


                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->left_image, 'public/harvester/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->right_image, 'public/harvester/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->front_image, 'public/harvester/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->back_image, 'public/harvester/' . $item->back_image);
                }
                if ($item->meter_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->meter_image, 'public/harvester/' . $item->meter_image);
                }
                if ($item->tyre_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->tyre_image, 'public/harvester/' . $item->tyre_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>4]);
                    }
                }

                DB::table('goods_vehicle')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'implements') {
                if ($item->title == NULL) {
                    $item->title = 'Implements';
                }
                $transer = DB::table('implements')->insertGetId([
                    'category_id' => 5, 'user_id' => $item->user_id, 'set' => $item->set, 'type' => $item->type, 'brand_id' => 103, 'model_id' => 1047, 'year_of_purchase' => $item->year_of_purchase, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->left_image, 'right_image' => $item->right_image, 'front_image' => $item->front_image, 'back_image' => $item->back_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->left_image, 'public/implements/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->right_image, 'public/implements/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->front_image, 'public/implements/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->back_image, 'public/implements/' . $item->back_image);
                }
                if ($item->meter_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->meter_image, 'public/implements/' . $item->meter_image);
                }
                if ($item->tyre_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->tyre_image, 'public/implements/' . $item->tyre_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>5]);
                    }
                }

                DB::table('goods_vehicle')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'seeds') {

                if ($item->title == NULL) {
                    $item->title = 'Seeds';
                }
                $transer = DB::table('seeds')->insertGetId([
                    'category_id' => 6, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->left_image, 'image3' => $item->right_image, 'image1' => $item->front_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->left_image, 'public/seeds/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->right_image, 'public/seeds/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->front_image, 'public/seeds/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->back_image, 'public/seeds/' . $item->back_image);
                }
                if ($item->meter_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->meter_image, 'public/seeds/' . $item->meter_image);
                }
                if ($item->tyre_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->tyre_image, 'public/seeds/' . $item->tyre_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>6]);
                    }
                }

                DB::table('goods_vehicle')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'pesticides') {

                if ($item->title == NULL) {
                    $item->title = 'Pesticides';
                }
                $transer = DB::table('pesticides')->insertGetId([
                    'category_id' => 8, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->left_image, 'image3' => $item->right_image, 'image1' => $item->front_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->left_image, 'public/pesticides/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->right_image, 'public/pesticides/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->front_image, 'public/pesticides/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->back_image, 'public/pesticides/' . $item->back_image);
                }
                if ($item->meter_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->meter_image, 'public/pesticides/' . $item->meter_image);
                }
                if ($item->tyre_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->tyre_image, 'public/pesticides/' . $item->tyre_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>8]);
                    }
                }

                DB::table('goods_vehicle')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'fertilizer') {

                if ($item->title == NULL) {
                    $item->title = 'Fertilizer';
                }
                $transer = DB::table('fertilizers')->insertGetId([
                    'category_id' => 9, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->left_image, 'image3' => $item->right_image, 'image1' => $item->front_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->left_image, 'public/fertilizers/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->right_image, 'public/fertilizers/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->front_image, 'public/fertilizers/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->back_image, 'public/fertilizers/' . $item->back_image);
                }
                if ($item->meter_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->meter_image, 'public/fertilizers/' . $item->meter_image);
                }
                if ($item->tyre_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->tyre_image, 'public/fertilizers/' . $item->tyre_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->count();
                if($offline_count  > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>9]);
                    }
                }

                DB::table('goods_vehicle')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'tyre') {

                if ($item->title == NULL) {
                    $item->title = 'Tyre';
                }
                $transer = DB::table('tyres')->insertGetId([
                    'category_id' => 7, 'user_id' => $item->user_id, 'type' => $item->type, 'brand_id' => 107, 'model_id' => 1052, 'year_of_purchase' => $item->year_of_purchase, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->left_image, 'image3' => $item->right_image, 'image1' => $item->front_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->left_image, 'public/tyre/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->right_image, 'public/tyre/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->front_image, 'public/tyre/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->back_image, 'public/tyre/' . $item->back_image);
                }
                if ($item->meter_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->meter_image, 'public/tyre/' . $item->meter_image);
                }
                if ($item->tyre_image != '') {
                    Storage::move('public/goods_vehicle/' . $item->tyre_image, 'public/tyre/' . $item->tyre_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 3])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>7]);
                    }
                }
                

                DB::table('goods_vehicle')->where(['id' => $operation_id])->delete();
            }

            if ($transer > 0) {
                return response()->json(['success' => 'success', 'msg' => 'Transfer successfully', 'goto' => asset('krishi-gv-post-list')]);
            } else {
                return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
            }
        } else if ($operation_from == 'harvester') {

            $item = DB::table('harvester')->where(['id' => $operation_id])->first();
            if ($operation_to == 'tractor') {
                if ($item->title == NULL) {
                    $item->title = 'Tractor';
                }
                $transer = DB::table('tractor')->insertGetId([
                    'category_id' => 1, 'user_id' => $item->user_id, 'set' => $item->set, 'type' => $item->type, 'brand_id' => 104, 'model_id' => 1048, 'year_of_purchase' => $item->year_of_purchase, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->left_image, 'right_image' => $item->right_image, 'front_image' => $item->front_image, 'back_image' => $item->back_image, 'price' => $item->price, 'rent_type' => $item->rent_type, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/harvester/' . $item->left_image, 'public/tractor/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/harvester/' . $item->right_image, 'public/tractor/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/harvester/' . $item->front_image, 'public/tractor/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/harvester/' . $item->back_image, 'public/tractor/' . $item->back_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>1]);
                    }
                }

                DB::table('harvester')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'gv') {
                if ($item->title == NULL) {
                    $item->title = 'Goods Vehicle';
                }
                $transer = DB::table('goods_vehicle')->insertGetId([
                    'category_id' => 3, 'user_id' => $item->user_id, 'set' => $item->set, 'type' => $item->type, 'brand_id' => 105, 'model_id' => 1049, 'year_of_purchase' => $item->year_of_purchase, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->left_image, 'right_image' => $item->right_image, 'front_image' => $item->front_image, 'back_image' => $item->back_image, 'price' => $item->price, 'rent_type' => $item->rent_type, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/harvester/' . $item->left_image, 'public/goods_vehicle/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/harvester/' . $item->right_image, 'public/goods_vehicle/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/harvester/' . $item->front_image, 'public/goods_vehicle/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/harvester/' . $item->back_image, 'public/goods_vehicle/' . $item->back_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->count();
                if( $offline_count> 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>3]);
                    }
                }

                DB::table('harvester')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'implements') {
                if ($item->title == NULL) {
                    $item->title = 'Implements';
                }
                $transer = DB::table('implements')->insertGetId([
                    'category_id' => 5, 'user_id' => $item->user_id, 'set' => $item->set, 'type' => $item->type, 'brand_id' => 103, 'model_id' => 1047, 'year_of_purchase' => $item->year_of_purchase, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->left_image, 'right_image' => $item->right_image, 'front_image' => $item->front_image, 'back_image' => $item->back_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/harvester/' . $item->left_image, 'public/implements/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/harvester/' . $item->right_image, 'public/implements/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/harvester/' . $item->front_image, 'public/implements/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/harvester/' . $item->back_image, 'public/implements/' . $item->back_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>5]);
                    }
                }
               
                DB::table('harvester')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'seeds') {

                if ($item->title == NULL) {
                    $item->title = 'Seeds';
                }

                $transer = DB::table('seeds')->insertGetId([
                    'category_id' => 6, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->left_image, 'image3' => $item->right_image, 'image1' => $item->front_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/harvester/' . $item->left_image, 'public/seeds/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/harvester/' . $item->right_image, 'public/seeds/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/harvester/' . $item->front_image, 'public/seeds/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/harvester/' . $item->back_image, 'public/seeds/' . $item->back_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->count();
                if($offline_count> 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>6]);
                    }
                }
                
                DB::table('harvester')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'pesticides') {

                if ($item->title == NULL) {
                    $item->title = 'Pesticides';
                }
                $transer = DB::table('pesticides')->insertGetId([
                    'category_id' => 8, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->left_image, 'image3' => $item->right_image, 'image1' => $item->front_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/harvester/' . $item->left_image, 'public/pesticides/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/harvester/' . $item->right_image, 'public/pesticides/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/harvester/' . $item->front_image, 'public/pesticides/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/harvester/' . $item->back_image, 'public/pesticides/' . $item->back_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>8]);
                    }
                }

                DB::table('harvester')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'fertilizer') {

                if ($item->title == NULL) {
                    $item->title = 'Fertilizer';
                }
                $transer = DB::table('fertilizers')->insertGetId([
                    'category_id' => 9, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->left_image, 'image3' => $item->right_image, 'image1' => $item->front_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/harvester/' . $item->left_image, 'public/fertilizers/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/harvester/' . $item->right_image, 'public/fertilizers/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/harvester/' . $item->front_image, 'public/fertilizers/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/harvester/' . $item->back_image, 'public/fertilizers/' . $item->back_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=> 9]);
                    }
                }

                DB::table('harvester')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'tyre') {

                if ($item->title == NULL) {
                    $item->title = 'Tyre';
                }
                $transer = DB::table('tyres')->insertGetId([
                    'category_id' => 7, 'user_id' => $item->user_id, 'type' => $item->type, 'brand_id' => 107, 'model_id' => 1052, 'year_of_purchase' => $item->year_of_purchase, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->left_image, 'image3' => $item->right_image, 'image1' => $item->front_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/harvester/' . $item->left_image, 'public/tyre/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/harvester/' . $item->right_image, 'public/tyre/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/harvester/' . $item->front_image, 'public/tyre/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/harvester/' . $item->back_image, 'public/tyre/' . $item->back_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 4])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>7]);
                    }
                }
                
                
                DB::table('harvester')->where(['id' => $operation_id])->delete();
            }

            if ($transer > 0) {
                return response()->json(['success' => 'success', 'msg' => 'Transfer successfully', 'goto' => asset('krishi-harvester-post-list')]);
            } else {
                return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
            }
        } else if ($operation_from == 'implements') {

            $item = DB::table('implements')->where(['id' => $operation_id])->first();
            if ($operation_to == 'tractor') {
                if ($item->title == NULL) {
                    $item->title = 'Tractor';
                }
                $transer = DB::table('tractor')->insertGetId([
                    'category_id' => 1, 'user_id' => $item->user_id, 'set' => $item->set, 'type' => $item->type, 'brand_id' => 104, 'model_id' => 1048, 'year_of_purchase' => $item->year_of_purchase, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->left_image, 'right_image' => $item->right_image, 'front_image' => $item->front_image, 'back_image' => $item->back_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/implements/' . $item->left_image, 'public/tractor/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/implements/' . $item->right_image, 'public/tractor/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/implements/' . $item->front_image, 'public/tractor/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/implements/' . $item->back_image, 'public/tractor/' . $item->back_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>1]);
                    }
                }

                DB::table('implements')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'gv') {
                if ($item->title == NULL) {
                    $item->title = 'Goods Vehicle';
                }
                $transer = DB::table('goods_vehicle')->insertGetId([
                    'category_id' => 3, 'user_id' => $item->user_id, 'set' => $item->set, 'type' => $item->type, 'brand_id' => 105, 'model_id' => 1049, 'year_of_purchase' => $item->year_of_purchase, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->left_image, 'right_image' => $item->right_image, 'front_image' => $item->front_image, 'back_image' => $item->back_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/implements/' . $item->left_image, 'public/goods_vehicle/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/implements/' . $item->right_image, 'public/goods_vehicle/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/implements/' . $item->front_image, 'public/goods_vehicle/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/implements/' . $item->back_image, 'public/goods_vehicle/' . $item->back_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>3]);
                    }
                }

                DB::table('implements')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'harvester') {
                if ($item->title == NULL) {
                    $item->title = 'Implements';
                }
                $transer = DB::table('harvester')->insertGetId([
                    'category_id' => 4, 'user_id' => $item->user_id, 'set' => $item->set, 'type' => $item->type, 'brand_id' => 106, 'model_id' => 1050, 'year_of_purchase' => $item->year_of_purchase, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->left_image, 'right_image' => $item->right_image, 'front_image' => $item->front_image, 'back_image' => $item->back_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/implements/' . $item->left_image, 'public/harvester/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/implements/' . $item->right_image, 'public/harvester/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/implements/' . $item->front_image, 'public/harvester/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/implements/' . $item->back_image, 'public/harvester/' . $item->back_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->count();
                if($offline_count  > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>4]);
                    }
                }

                DB::table('implements')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'seeds') {

                if ($item->title == NULL) {
                    $item->title = 'Seeds';
                }

                $transer = DB::table('seeds')->insertGetId([
                    'category_id' => 6, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->left_image, 'image3' => $item->right_image, 'image1' => $item->front_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/implements/' . $item->left_image, 'public/seeds/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/implements/' . $item->right_image, 'public/seeds/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/implements/' . $item->front_image, 'public/seeds/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/implements/' . $item->back_image, 'public/seeds/' . $item->back_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>6]);
                    }
                }
                
                DB::table('implements')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'pesticides') {

                if ($item->title == NULL) {
                    $item->title = 'Pesticides';
                }
                $transer = DB::table('pesticides')->insertGetId([
                    'category_id' => 8, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->left_image, 'image3' => $item->right_image, 'image1' => $item->front_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/implements/' . $item->left_image, 'public/pesticides/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/implements/' . $item->right_image, 'public/pesticides/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/implements/' . $item->front_image, 'public/pesticides/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/implements/' . $item->back_image, 'public/pesticides/' . $item->back_image);
                }
                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->count();
                if($offline_count >0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>8]);
                    }
                }
                DB::table('implements')->where(['id' => $operation_id])->delete();

            } else if ($operation_to == 'fertilizer') {

                if ($item->title == NULL) {
                    $item->title = 'Fertilizer';
                }
                $transer = DB::table('fertilizers')->insertGetId([
                    'category_id' => 9, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->left_image, 'image3' => $item->right_image, 'image1' => $item->front_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/implements/' . $item->left_image, 'public/fertilizers/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/implements/' . $item->right_image, 'public/fertilizers/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/implements/' . $item->front_image, 'public/fertilizers/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/implements/' . $item->back_image, 'public/fertilizers/' . $item->back_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->get();

                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>9]);
                    }

                }
                

                DB::table('implements')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'tyre') {

                if ($item->title == NULL) {
                    $item->title = 'Tyre';
                }
                $transer = DB::table('tyres')->insertGetId([
                    'category_id' => 7, 'user_id' => $item->user_id, 'type' => $item->type, 'brand_id' => 107, 'model_id' => 1052, 'year_of_purchase' => $item->year_of_purchase, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->left_image, 'image3' => $item->right_image, 'image1' => $item->front_image, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->left_image != '') {
                    Storage::move('public/implements/' . $item->left_image, 'public/tyre/' . $item->left_image);
                }
                if ($item->right_image != '') {
                    Storage::move('public/implements/' . $item->right_image, 'public/tyre/' . $item->right_image);
                }
                if ($item->front_image != '') {
                    Storage::move('public/implements/' . $item->front_image, 'public/tyre/' . $item->front_image);
                }
                if ($item->back_image != '') {
                    Storage::move('public/implements/' . $item->back_image, 'public/tyre/' . $item->back_image);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 5])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>7]);
                    }
                }
               

                DB::table('implements')->where(['id' => $operation_id])->delete();
            }

            if ($transer > 0) {
                return response()->json(['success' => 'success', 'msg' => 'Transfer successfully', 'goto' => asset('krishi-implements-post-list')]);
            } else {
                return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
            }
        } else if ($operation_from == 'seeds') {

            $item = DB::table('seeds')->where(['id' => $operation_id])->first();
            if ($operation_to == 'tractor') {
                if ($item->title == NULL) {
                    $item->title = 'Tractor';
                }
                $transer = DB::table('tractor')->insertGetId([
                    'category_id' => 1, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 104, 'model_id' => 1048, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/seeds/' . $item->image1, 'public/tractor/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/seeds/' . $item->image2, 'public/tractor/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/seeds/' . $item->image3, 'public/tractor/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>1]);
                    }
                }

                DB::table('seeds')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'gv') {
                if ($item->title == NULL) {
                    $item->title = 'Goods Vehicle';
                }
                $transer = DB::table('goods_vehicle')->insertGetId([
                    'category_id' => 3, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 105, 'model_id' => 1049, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/seeds/' . $item->image1, 'public/goods_vehicle/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/seeds/' . $item->image2, 'public/goods_vehicle/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/seeds/' . $item->image3, 'public/goods_vehicle/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>3]);
                    }
                }

                DB::table('seeds')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'harvester') {
                if ($item->title == NULL) {
                    $item->title = 'Harvester';
                }
                $transer = DB::table('harvester')->insertGetId([
                    'category_id' => 4, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 106, 'model_id' => 1050, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/seeds/' . $item->image1, 'public/harvester/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/seeds/' . $item->image2, 'public/harvester/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/seeds/' . $item->image3, 'public/harvester/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>4]);
                    }
                }
                
                DB::table('seeds')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'implements') {

                if ($item->title == NULL) {
                    $item->title = 'Implements';
                }
                $transer = DB::table('implements')->insertGetId([
                    'category_id' => 5, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 103, 'model_id' => 1047, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/seeds/' . $item->image1, 'public/implements/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/seeds/' . $item->image2, 'public/implements/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/seeds/' . $item->image3, 'public/implements/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>5]);
                    }
                }
                
                DB::table('seeds')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'pesticides') {

                if ($item->title == NULL) {
                    $item->title = 'Pesticides';
                }
                $transer = DB::table('pesticides')->insertGetId([
                    'category_id' => 8, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->image2, 'image3' => $item->image3, 'image1' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/seeds/' . $item->image1, 'public/pesticides/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/seeds/' . $item->image2, 'public/pesticides/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/seeds/' . $item->image3, 'public/pesticides/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>8]);
                    }
                }

                DB::table('seeds')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'fertilizer') {

                if ($item->title == NULL) {
                    $item->title = 'Fertilizer';
                }
                $transer = DB::table('fertilizers')->insertGetId([
                    'category_id' => 9, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->image2, 'image3' => $item->image3, 'image1' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/seeds/' . $item->image1, 'public/fertilizers/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/seeds/' . $item->image2, 'public/fertilizers/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/seeds/' . $item->image3, 'public/fertilizers/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>9]);
                    }
                }
                
                DB::table('seeds')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'tyre') {

                if ($item->title == NULL) {
                    $item->title = 'Tyre';
                }
                $transer = DB::table('tyres')->insertGetId([
                    'category_id' => 7, 'user_id' => $item->user_id, 'type' => 'old', 'brand_id' => 107, 'model_id' => 1052, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->image2, 'image3' => $item->image3, 'image1' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/seeds/' . $item->image1, 'public/tyre/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/seeds/' . $item->image2, 'public/tyre/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/seeds/' . $item->image3, 'public/tyre/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>7]);
                    }
                }

                DB::table('seeds')->where(['id' => $operation_id])->delete();
            }

            if ($transer > 0) {
                return response()->json(['success' => 'success', 'msg' => 'Transfer successfully', 'goto' => asset('krishi-seeds-post-list')]);
            } else {
                return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
            }
        } else if ($operation_from == 'pesticides') {

            $item = DB::table('pesticides')->where(['id' => $operation_id])->first();
            if ($operation_to == 'tractor') {
                if ($item->title == NULL) {
                    $item->title = 'Tractor';
                }
                $transer = DB::table('tractor')->insertGetId([
                    'category_id' => 1, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 104, 'model_id' => 1048, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/pesticides/' . $item->image1, 'public/tractor/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/pesticides/' . $item->image2, 'public/tractor/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/pesticides/' . $item->image3, 'public/tractor/' . $item->image3);
                }
                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 8])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 8])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>1]);
                    }
                }

                DB::table('pesticides')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'gv') {
                if ($item->title == NULL) {
                    $item->title = 'Goods Vehicle';
                }
                $transer = DB::table('goods_vehicle')->insertGetId([
                    'category_id' => 3, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 105, 'model_id' => 1049, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/pesticides/' . $item->image1, 'public/goods_vehicle/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/pesticides/' . $item->image2, 'public/goods_vehicle/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/pesticides/' . $item->image3, 'public/goods_vehicle/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 8])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 6])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>3]);
                    }
                }
                
                DB::table('pesticides')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'harvester') {
                if ($item->title == NULL) {
                    $item->title = 'Harvester';
                }

                $transer = DB::table('harvester')->insertGetId([
                    'category_id' => 4, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 106, 'model_id' => 1050, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/pesticides/' . $item->image1, 'public/harvester/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/pesticides/' . $item->image2, 'public/harvester/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/pesticides/' . $item->image3, 'public/harvester/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 8])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 8])->get();

                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=> 4]);
                    } 
                }

                DB::table('pesticides')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'implements') {

                if ($item->title == NULL) {
                    $item->title = 'Implements';
                }
                $transer = DB::table('implements')->insertGetId([
                    'category_id' => 5, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 103, 'model_id' => 1047, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/pesticides/' . $item->image1, 'public/implements/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/pesticides/' . $item->image2, 'public/implements/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/pesticides/' . $item->image3, 'public/implements/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 8])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 8])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>5]);
                    }
                }

                DB::table('pesticides')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'seeds') {

                if ($item->title == NULL) {
                    $item->title = 'Seeds';
                }
                $transer = DB::table('seeds')->insertGetId([
                    'category_id' => 6, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->image2, 'image3' => $item->image3, 'image1' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/pesticides/' . $item->image1, 'public/seeds/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/pesticides/' . $item->image2, 'public/seeds/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/pesticides/' . $item->image3, 'public/seeds/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 8])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 8])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id' => 6]);
                    }
                }

                DB::table('pesticides')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'fertilizer') {

                if ($item->title == NULL) {
                    $item->title = 'Fertilizer';
                }
                $transer = DB::table('fertilizers')->insertGetId([
                    'category_id' => 9, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->image2, 'image3' => $item->image3, 'image1' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/pesticides/' . $item->image1, 'public/fertilizers/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/pesticides/' . $item->image2, 'public/fertilizers/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/pesticides/' . $item->image3, 'public/fertilizers/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 8])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 8])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id' => 9]);
                    }
                }
                
                DB::table('pesticides')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'tyre') {

                if ($item->title == NULL) {
                    $item->title = 'Tyre';
                }
                $transer = DB::table('tyres')->insertGetId([
                    'category_id' => 7, 'user_id' => $item->user_id, 'type' => 'old', 'brand_id' => 107, 'model_id' => 1052, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->image2, 'image3' => $item->image3, 'image1' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/pesticides/' . $item->image1, 'public/tyre/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/pesticides/' . $item->image2, 'public/tyre/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/pesticides/' . $item->image3, 'public/tyre/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 8])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 8])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>7]);
                    }
                }

                DB::table('pesticides')->where(['id' => $operation_id])->delete();
            }

            if ($transer > 0) {
                return response()->json(['success' => 'success', 'msg' => 'Transfer successfully', 'goto' => asset('krishi-pesticides-post-list')]);
            } else {
                return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
            }
        } else if ($operation_from == 'fertilizer') {

            $item = DB::table('fertilizers')->where(['id' => $operation_id])->first();
            if ($operation_to == 'tractor') {
                if ($item->title == NULL) {
                    $item->title = 'Tractor';
                }
                $transer = DB::table('tractor')->insertGetId([
                    'category_id' => 1, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 104, 'model_id' => 1048, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/fertilizers/' . $item->image1, 'public/tractor/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/fertilizers/' . $item->image2, 'public/tractor/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/fertilizers/' . $item->image3, 'public/tractor/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>1]);
                    }
                }
             
                DB::table('fertilizers')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'gv') {
                if ($item->title == NULL) {
                    $item->title = 'Goods Vehicle';
                }
                $transer = DB::table('goods_vehicle')->insertGetId([
                    'category_id' => 3, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 105, 'model_id' => 1049, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/fertilizers/' . $item->image1, 'public/goods_vehicle/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/fertilizers/' . $item->image2, 'public/goods_vehicle/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/fertilizers/' . $item->image3, 'public/goods_vehicle/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>3]);
                    }
                }
                
                DB::table('fertilizers')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'harvester') {
                if ($item->title == NULL) {
                    $item->title = 'Harvester';
                }
                $transer = DB::table('harvester')->insertGetId([
                    'category_id' => 4, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 106, 'model_id' => 1050, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/fertilizers/' . $item->image1, 'public/harvester/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/fertilizers/' . $item->image2, 'public/harvester/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/fertilizers/' . $item->image3, 'public/harvester/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>4]);
                    }
                }
                
                DB::table('fertilizers')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'implements') {

                if ($item->title == NULL) {
                    $item->title = 'Implements';
                }
                $transer = DB::table('implements')->insertGetId([
                    'category_id' => 5, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 103, 'model_id' => 1047, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/fertilizers/' . $item->image1, 'public/implements/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/fertilizers/' . $item->image2, 'public/implements/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/fertilizers/' . $item->image3, 'public/implements/' . $item->image3);
                }
                
                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>5]);
                    }
                }

                DB::table('fertilizers')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'seeds') {

                if ($item->title == NULL) {
                    $item->title = 'Pesticides';
                }
                $transer = DB::table('seeds')->insertGetId([
                    'category_id' => 6, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->image2, 'image3' => $item->image3, 'image1' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/fertilizers/' . $item->image1, 'public/seeds/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/fertilizers/' . $item->image2, 'public/seeds/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/fertilizers/' . $item->image3, 'public/seeds/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>6]);
                    }
                }
               
                DB::table('fertilizers')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'pesticides') {

                if ($item->title == NULL) {
                    $item->title = 'pesticides';
                }
                $transer = DB::table('pesticides')->insertGetId([
                    'category_id' => 8, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->image2, 'image3' => $item->image3, 'image1' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/fertilizers/' . $item->image1, 'public/pesticides/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/fertilizers/' . $item->image2, 'public/pesticides/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/fertilizers/' . $item->image3, 'public/pesticides/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->count();
                if($offline_count > 0){
                     $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>3]);
                    }
                }
               
                DB::table('fertilizers')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'tyre') {

                if ($item->title == NULL) {
                    $item->title = 'Tyre';
                }
                $transer = DB::table('tyres')->insertGetId([
                    'category_id' => 7, 'user_id' => $item->user_id, 'type' => 'old', 'brand_id' => 107, 'model_id' => 1052, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->image2, 'image3' => $item->image3, 'image1' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/fertilizers/' . $item->image1, 'public/tyre/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/fertilizers/' . $item->image2, 'public/tyre/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/fertilizers/' . $item->image3, 'public/tyre/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 9])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>7]);
                    }
                }
                
                DB::table('fertilizers')->where(['id' => $operation_id])->delete();
            }

            if ($transer > 0) {
                return response()->json(['success' => 'success', 'msg' => 'Transfer successfully', 'goto' => asset('krishi-fertilizers-post-list')]);
            } else {
                return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
            }
        } else if ($operation_from == 'tyre') {

            $item = DB::table('tyres')->where(['id' => $operation_id])->first();
            if ($operation_to == 'tractor') {
                if ($item->title == NULL) {
                    $item->title = 'Tractor';
                }
                $transer = DB::table('tractor')->insertGetId([
                    'category_id' => 1, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 104, 'model_id' => 1048, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/tyre/' . $item->image1, 'public/tractor/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/tyre/' . $item->image2, 'public/tractor/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/tyre/' . $item->image3, 'public/tractor/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 7])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 7])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>1]);
                    }
                }

                DB::table('tyres')->where(['id' => $operation_id])->delete();

            } else if ($operation_to == 'gv') {
                if ($item->title == NULL) {
                    $item->title = 'Goods Vehicle';
                }
                $transer = DB::table('goods_vehicle')->insertGetId([
                    'category_id' => 3, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 105, 'model_id' => 1049, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/tyre/' . $item->image1, 'public/goods_vehicle/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/tyre/' . $item->image2, 'public/goods_vehicle/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/tyre/' . $item->image3, 'public/goods_vehicle/' . $item->image3);
                }

                $offline_count = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 7])->count();
                if($offline_count > 0){
                    $offline_lead = DB::table('offline_leads')->where(['post_id'=>$operation_id,'category_id' => 7])->get();
                    foreach ($offline_lead as $offline){
                        $update_offline = DB::table('offline_leads')->where('id',$offline->id)->update(['post_id'=> $transer , 'category_id'=>1]);
                    }
                }
               
                DB::table('tyres')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'harvester') {
                if ($item->title == NULL) {
                    $item->title = 'Implements';
                }
                $transer = DB::table('harvester')->insert([
                    'category_id' => 4, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 106, 'model_id' => 1050, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/tyre/' . $item->image1, 'public/harvester/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/tyre/' . $item->image2, 'public/harvester/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/tyre/' . $item->image3, 'public/harvester/' . $item->image3);
                }


                DB::table('tyres')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'implements') {

                if ($item->title == NULL) {
                    $item->title = 'Implements';
                }
                $transer = DB::table('implements')->insert([
                    'category_id' => 5, 'user_id' => $item->user_id, 'set' => 'rent', 'type' => 'old', 'brand_id' => 103, 'model_id' => 1047, 'title' => $item->title,
                    'description' => $item->description, 'left_image' => $item->image3, 'right_image' => $item->image2, 'front_image' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/tyre/' . $item->image1, 'public/implements/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/tyre/' . $item->image2, 'public/implements/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/tyre/' . $item->image3, 'public/implements/' . $item->image3);
                }


                DB::table('tyres')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'seeds') {

                if ($item->title == NULL) {
                    $item->title = 'seeds';
                }
                $transer = DB::table('seeds')->insert([
                    'category_id' => 6, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->image2, 'image3' => $item->image3, 'image1' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/tyre/' . $item->image1, 'public/seeds/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/tyre/' . $item->image2, 'public/seeds/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/tyre/' . $item->image3, 'public/seeds/' . $item->image3);
                }


                DB::table('tyres')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'pesticides') {

                if ($item->title == NULL) {
                    $item->title = 'pesticides';
                }
                $transer = DB::table('pesticides')->insert([
                    'category_id' => 8, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->image2, 'image3' => $item->image3, 'image1' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/tyre/' . $item->image1, 'public/pesticides/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/tyre/' . $item->image2, 'public/pesticides/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/tyre/' . $item->image3, 'public/pesticides/' . $item->image3);
                }


                DB::table('tyres')->where(['id' => $operation_id])->delete();
            } else if ($operation_to == 'fertilizer') {

                if ($item->title == NULL) {
                    $item->title = 'Fertilizer';
                }
                $transer = DB::table('fertilizers')->insert([
                    'category_id' => 9, 'user_id' => $item->user_id, 'title' => $item->title,
                    'description' => $item->description, 'image2' => $item->image2, 'image3' => $item->image3, 'image1' => $item->image1, 'price' => $item->price, 'is_negotiable' => $item->is_negotiable,
                    'pincode' => $item->pincode, 'country_id' => $item->country_id, 'state_id' => $item->state_id, 'district_id' => $item->district_id, 'city_id' => $item->city_id, 'latlong' => $item->latlong, 'status' => $item->status, 'created_at' => $item->created_at
                ]);

                //File::move(public_path('exist/test.png'), public_path('move/test_move.png'));
                if ($item->image1 != '') {
                    Storage::move('public/tyre/' . $item->image1, 'public/fertilizers/' . $item->image1);
                }
                if ($item->image2 != '') {
                    Storage::move('public/tyre/' . $item->image2, 'public/fertilizers/' . $item->image2);
                }
                if ($item->image3 != '') {
                    Storage::move('public/tyre/' . $item->image3, 'public/fertilizers/' . $item->image3);
                }


                DB::table('tyre')->where(['id' => $operation_id])->delete();
            }

            if ($transer > 0) {
                return response()->json(['success' => 'success', 'msg' => 'Transfer successfully', 'goto' => asset('krishi-tyre-post-list')]);
            } else {
                return response()->json(['success' => 'failed', 'msg' => 'Something went wrong']);
            }
        }
    }

    public function campaign_page()
    {
        return view('admin.campaign', ['counter' => 0, 'campaign_number' => '']);
    }

    public function campaign_submit(Request $request)
    {
        $campaign_number = $request->campaign_number;
        $campaign_number = str_replace(array("\r", "\n"), '', $campaign_number);
        $number_array = explode(',', str_replace(' ', '', $campaign_number));
        //$number_array = explode(',',trim($campaign_number));
        //print_r($number_array); ///exit;
        $query =  DB::table('user')->whereIn('mobile', $number_array)->count();
        return view('admin.campaign', ['counter' => $query, 'campaign_number' => $campaign_number]);
    }


    public function push_notification_send()
    {
        $id = 'cL03H50ySsGbabbWxU3usE:APA91bH2P-26v3tGFgvRsufRfTzWZBJARvgCVqNrMsuNhsJg9-rXeTmRXfSDz9s4pm3Q8TOK-TQjoGtIq-oPeuZT9FrAden7JSA_9mzSORDiF6Sws05Rt1MFnggahQxLwvxyaoHfR6aS';
        $message = 'abc';

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => array(
                $id
            ),
            'notification' => [
                'title' => 'test by server',
                'body' => 'subhabratasubhabratasubhabratasubhabratasub habratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabra tasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabratasubhabrata',
                'image' => 'https://krishivikas.com/assets/images/KV logo-01.png',

            ],
            'fcm_options' => [
                'link' => 'https://my-server/some-page',
            ],
            'data' => array(
                'click_action' => 'OPEN_SPECIFIC_PAGE',
                'url' => '/NotificationsPage'
            )
        );


        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . "AAAAggkuf0U:APA91bFBX11jYY_-0wGkxNL1D1CDlsFStOwl_1XP6W9P7nGzGKCvQPuiw7gYxJTGIl979OnB7puZ8msM4pPz7TslSjZysTyG0pZwTWH8PhriZO3sGt-a8u5UFiNJfyRh2M1h0f05jZl4",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);
    }

    // Start script for search user by mobile number
    public function searchUserMobile(Request $request)
    {
        $validatedData = $request->validate([
            'mobile_no' => 'required|regex:/[0-9]{10}/',
        ], [
            'mobile_no.required' => 'Please enter mobile number'
        ]);

        $userData = DB::table('user')->where('mobile', $request->mobile_no)->first();
       // $user_type_id = $userData->user_type_id;
      
        $marketerName = DB::table('user')->where('market_status', 1)->get();
        $packageName = DB::table('promotion_package')->get();
        if (!empty($userData) && $userData != null) {
            if($userData->user_type_id == 3 || $userData->user_type_id == 4){
                return view('admin.promotions.new_promotions', ['userData' => $userData, 'marketerName' => $marketerName, 'packageName' => $packageName]);
            }else{
                return redirect('new-promotion')->with('failed', 'Only Dealer and Exchager can be use.');
            }
        } 
        else {
            return redirect('new-promotion')->with('failed', 'Mobile number not exist.');
        }

    }

    /** Promotion Total Amount */
    public function promotionTotalAmount(Request $request){
       // dd($request->all());
        $package_price = $request->package_price;
        $type          = $request->type;
        $discount      = $request->discount;
        if(!empty($request->discount)){
            if($type == 'gst'){
                $cost        = $package_price * (18 / 100);
                $total       = $package_price + $cost ;
                $total_discount= ($total * $discount) / 100;

            }else if($type == 'cgst'){
                $cost = $package_price * (9 / 100);
                $total       = $package_price + $cost ;
                $total_discount = ($total * $discount) / 100;
    
            }else if($type == 'igst'){
                $cost = $package_price * (18 / 100);
                $total       = $package_price + $cost ;
                $total_discount = ($total * $discount) / 100;
            }

            $totalAmount = ($total - $total_discount);
     
            
        }else if(empty($request->discount)){
            if($type == 'gst'){
                $cost  = $package_price * (18 / 100);
                $totalAmount = $package_price + $cost ;
    
            }else if($type == 'cgst'){
                $cost  = $package_price * (9 / 100);
                $totalAmount = $package_price + $cost ;
    
            }else if($type == 'igst'){
                $cost  = $package_price * (18 / 100);
                $totalAmount = $package_price + $cost ;
            }
        }

        //dd($totalAmount);
        return response()->json(['total_amount' => $totalAmount]);
    }

    public function addPromotionCoupon(Request $request)
    {
        //dd($request->all());

        $validatedData = $request->validate([
            'package_name'     => 'required',
            'purchase_price'   => 'required',
            'down_payment'     => 'required',
            'transaction_type' => 'required',
            // 'promotion_days'   => 'required',
            // 'buffer_days'      => 'required',
            'market_user_id'   => 'required',
        ], [
            'package_name.required'     => 'Please select package name',
            'purchase_price.required'   => 'Please enter purchase price',
            'down_payment.required'     => 'Please enter down payment',
            'transaction_type.required' => 'Please select transaction type',
            // 'promotion_days.required'   => 'Please enter mobile number',
            // 'buffer_days.required'      => 'Please enter mobile number',
            'market_user_id.required'   => 'Please select user name',
        ]);
       // dd("hi");

        $marketerData = DB::table('user')->select('name')->where('id', $request->market_user_id)->first();
        $marketerName = explode(' ', $marketerData->name);
        $marketerFirstName = $marketerName[0];

        $packageNames = DB::table('promotion_package')->select('package_name')->where('id', $request->package_name)->first();
        $packDuration = DB::table('promotion_package')->select('duration')->where('id', $request->package_name)->first();

        $couponCode = 'KV-' . $marketerFirstName . '-' . $packageNames->package_name . '-' . $request->discount;

        $dateData =  Carbon::now();
        $startDate = date("Y-m-d H:i:s", strtotime($dateData));

        if (!empty($packDuration)) {
            $eDate       = $dateData->addDays($packDuration->duration);
            $dateDatas   = $eDate->format('Y-m-d H:i:s');
            $endDate     = date("Y-m-d H:i:s", strtotime($dateDatas));
            //dd($endDate);
        }

        if(!empty($request->promotion_days) && !empty($request->buffer_days))
        {
            $totalDateCarbon =  Carbon::now();
            if(!empty($request->promotion_days)){
            // dd($request->promotion_days);
                $totalDate            = $totalDateCarbon->addDays($request->promotion_days);
                $totalDatas           = $totalDate->format('Y-m-d H:i:s');
                $total_days_end_day   = date("Y-m-d H:i:s", strtotime($totalDatas));
            }

            $bufferDateCarbon =  Carbon::now();
            if(!empty($request->buffer_days)){
                $bufferStartDate         = $bufferDateCarbon->addDays($request->promotion_days + 1);
                $startDateBuffer         = $bufferStartDate->format('Y-m-d H:i:s');
                $buffer_days_start_day   = date("Y-m-d H:i:s", strtotime($startDateBuffer));
                
                $buffer_days_end_day     = date('Y-m-d H:i:s', strtotime($buffer_days_start_day . ' + ' . $request->buffer_days . ' days'));
                //dd($buffer_days_end_day);
            }
        }else{
           // dd("echo");
            $dateData =  Carbon::now();
            $startDate = date("Y-m-d H:i:s", strtotime($dateData));

            $total_days_end_day      = date("Y-m-d H:i:s", strtotime($dateData));
            $buffer_days_start_day   = date("Y-m-d H:i:s", strtotime($dateData));
            $buffer_days_end_day     = date("Y-m-d H:i:s", strtotime($dateData));
        }
        
        $date1 =  Carbon::now();
        $start_date = date("Y-m-d H:i:s", strtotime($date1));
        $financialYear = Subscription::getFinancialYear($start_date, "y"); //21-22 

        $getId = 0;
        $getId = DB::select("SELECT 
            LPAD(
                MAX(
                    CAST(
                        SUBSTRING(invoice_no, LENGTH('AECPL/OS-') + 1) AS UNSIGNED
                    )
                ),
                LENGTH(MAX(CAST(SUBSTRING(invoice_no, LENGTH('AECPL/OS-') + 1) AS UNSIGNED))), '0'
            ) AS max_invoice_number
                FROM (
                    SELECT invoice_no FROM promotion_coupons
                  ) AS combined_tables");

        $invoiceId = $getId[0]->max_invoice_number + 1;

        $types_of_interest = $request->types_of_interest;
        $purchasePrice     = $request->purchase_price;
        $discount          = $request->discount ? $request->discount:0;

        if ($types_of_interest == 'gst') {
            $gst = $purchasePrice * (18 / 100);
            $total       = ($purchasePrice + $gst);
            $total_price = ($total * $discount) / 100;
        } else {
            $gst = null;
        }
        if ($types_of_interest == 'cgst') {
            $cgst        = $purchasePrice * (9 / 100);
            $total       = ($purchasePrice + $cgst);
            $total_price = ($total * $discount) / 100;
        } else {
            $cgst = null;
        }
        if ($types_of_interest == 'sgst') {
            $sgst = $purchasePrice * (9 / 100);
            $total       = ($purchasePrice + $sgst);
            $total_price = ($total * $discount) / 100;
        } else {
            $sgst = null;
        }
        if ($types_of_interest == 'igst') {
            $igst = $purchasePrice * (18 / 100);
            $total       = ($purchasePrice + $igst);
            $total_price = ($total * $discount) / 100;
        } else {
            $igst = null;
        }

        $totalAmount = ($total - $total_price);
       // dd($totalAmount);
        if($totalAmount == $request->down_payment){
           // dd("clearing");
            $dueAmount = 0;
        }else{
          //  dd("due");
            $dueAmount   = ($totalAmount - $request->down_payment);
        }

        if(!empty($request->promotion_days) && !empty($request->buffer_days)){
            $promotion_days = $request->promotion_days;
            $buffer_days    = $request->buffer_days;
        }else{
            $promotion_days = 0;
            $buffer_days    = 0;
        }

        $data = [
            'user_id'               => $request->user_id,
            'coupon_code'           => $couponCode,
            'total_days'            => $promotion_days,
            'total_days_start_day'  => $startDate,
            'total_days_end_day'    => $total_days_end_day,
            'buffer_days'           => $buffer_days,
            'buffer_days_start_day' => $buffer_days_start_day,
            'buffer_days_end_day'   => $buffer_days_end_day,
            'start_date'            => $startDate,
            'end_date'              => $endDate,
            'purchase_price'        => $request->purchase_price,
            'downpayment_price'     => $request->down_payment,
            'discount'              => $discount,
            'package_id'            => $request->package_name,
            'transaction_type'      => $request->transaction_type,
            'transaction_id'        => $request->transaction_id,
            'order_id'              => $request->order_id,
            'gst'                   => $gst,
            'cgst'                  => $cgst,
            'sgst'                  => $sgst,
            'igst'                  => $igst,
            'invoice_no'            => "AECPL/OS-" . str_pad($invoiceId, 5, "0", STR_PAD_LEFT) . "/" . $financialYear,
            'marketer_user_id'      => $request->market_user_id,
            'total_amount'          => $request->total_amount,
            'due_amount'            => $dueAmount,
            'status'                => 1,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ];

        $insert = DB::table('promotion_coupons')->insertGetId($data);

        $promotion_coupons = DB::table('promotion_coupons')->where('id', $insert)->first();
        $package           = DB::table('promotion_package')->where('id', $promotion_coupons->package_id)->first();

        $seller_tag_id          = $package->seller_tag_id;
        $subscription_featue_id = $package->subscription_featue_id;
        $package_price          = $package->package_price;
        $no_of_products         = $package->no_of_products;
        $coupon_code            = $promotion_coupons->coupon_code;

        $subscription_id = DB::table('subscription_features')->where('id', $subscription_featue_id)->first()->subscription_id;
        $subscribeds_data = [
            'subscription_id'         => $subscription_id,
            'subscription_feature_id' => $subscription_featue_id,
            'package_id'              => $request->package_name,
            'coupon_id'               => $promotion_coupons->id,
            'coupon_type'             => 'promotion',
            'user_id'                 => $promotion_coupons->user_id,
            'price'                   => $package_price,
            'start_date'              => $promotion_coupons->start_date,
            'end_date'                => $promotion_coupons->end_date,
            'purchased_price'         => $promotion_coupons->purchase_price,
            'transaction_id'          => $promotion_coupons->transaction_id,
            'order_id'                => $promotion_coupons->order_id,
            'gst'                     => $promotion_coupons->gst,
            'sgst'                    => $promotion_coupons->sgst,
            'cgst'                    => $promotion_coupons->cgst,
            'igst'                    => $promotion_coupons->igst,
            'invoice_no'             => $promotion_coupons->invoice_no,
            'status'                 => 1,
            'created_at'             => $promotion_coupons->created_at,
            'updated_at'             => $promotion_coupons->updated_at,
        ];

        $insert_subscribeds = DB::table('subscribeds')->insertGetId($subscribeds_data);

        //Start script for insert data into invoice table
        $dataInvoice = [
            'invoice_type'      =>'promotion_boosts_admin',
            'invoice_name'      =>"AECPL/OS-" . str_pad($invoiceId, 5, "0", STR_PAD_LEFT) . "/" . $financialYear,
            'user_id'           => $request->user_id,
            'invoice_amount'    => $request->purchase_price,
            'downpayment_price' => $request->down_payment,
            'discount'          => $discount,
            'due_amount'        => $dueAmount,
            'start_date'        => $startDate,
            'end_date'          => $endDate,
            'package_id'        => $request->package_name,
            'gst'               => $gst,
            'cgst'              => $cgst,
            'sgst'              => $sgst,
            'igst'              => $igst,
            'status'            => 1,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];

        $insertInvoice = DB::table('invoice')->insert($dataInvoice);
        //End script for insert data into invoice table

        $promotion_tags_icon = DB::table('promotion_tags')->where('id',$seller_tag_id)->first()->tag_icon;
        //dd($promotion_tags_icon);

        $user = DB::table('user')->where('id', $request->user_id)->first();
        //dd($user);
        $user_id          = $user->id;
        $language         = $user->lamguage;
        $mobile           = $user->mobile;
        $limit_count      = $user->limit_count;
        $updateLimitCount = $limit_count+$no_of_products;

        $update_user = DB::table('user')->where('id', $request->user_id)->update(['limit_count' => $updateLimitCount ,'verify_tag'=> $promotion_tags_icon]);

        sms::offlinePaymentMembership($language,$coupon_code,$user_id,$mobile);

        if ($insert) {
            return redirect('promotion-list')->with('success', 'Promotion Coupon Added Successfully');
        } else {
            return redirect('promotion-list')->with('failed', 'Failed! Something Went Wrong');
        }
    }

    public function promotionInvoice(Request $request, $promotionId)
    {

        $promotion_details  = DB::table('promotion_coupons')->where('id', $promotionId)->first();
        //dd($promotion_details);

        $package_name = DB::table('promotion_package')->where('id', $promotion_details->package_id)->first()->package_name;

        $date           = date_create($promotion_details->start_date);
        $start_date     = date_format($date, "d/m/Y");
        $start_time     = date_format($date, "H:i:s");

        $date1          = date_create($promotion_details->end_date);
        $end_date       = date_format($date1, "d/m/Y");

        $user_details   = DB::table('user')->where('id', $promotion_details->user_id)->first();
        $state_name     = DB::table('state')->where('id', $user_details->state_id)->first()->state_name;
        $district_name  = DB::table('district')->where('id', $user_details->district_id)->first()->district_name;
        //$city_name      = DB::table('city')->where('id', $user_details->city_id)->first()->city_name;

        $purchase_price    = $promotion_details->purchase_price;
        $discount          = $promotion_details->discount;
        $downpayment_price = $promotion_details->downpayment_price;

        if (!empty($promotion_details->gst)) {
            $gst         = $promotion_details->gst;
            $total       = ($purchase_price + $gst);
            $total_price = ($total * $discount) / 100;
        } else if (!empty($promotion_details->cgst)) {
            $cgst         = $promotion_details->cgst;
            $total        = ($purchase_price + $cgst);
            $total_price  = ($total * $discount) / 100;
            //dd($total);
        } else if (!empty($promotion_details->sgst)) {
            $sgst         = $promotion_details->sgst;
            $total        = ($purchase_price + $sgst);
            $total_price  = ($total * $discount) / 100;
        } else if (!empty($promotion_details->igst)) {
            $igst         = $promotion_details->igst;
            $total        = ($purchase_price + $igst);
            $total_price  = ($total * $discount) / 100;
        }

        $totalAmount = ($total - $total_price);
        $dueAmount   = ($totalAmount - $downpayment_price);

        return view('admin.promotions.invoice', [
            'promotion_details' => $promotion_details,
            'start_date' => $start_date, 'start_time' => $start_time, 'end_date' => $end_date, 'user_details' => $user_details,
            'state_name' => $state_name, 'district_name' => $district_name, 'package_name' => $package_name,
            'total_price' => $totalAmount, 'discount' => $discount, 'purchase_price' => $purchase_price,
            'downpayment_price' => $downpayment_price, 'due_amount' => $dueAmount
        ]);
    }

    public function get_promotion_list()
    {
        $promotion_list = DB::table('promotion_coupons as pc')
            ->select('user.name', 'user.mobile', 'pc.coupon_code', 'pc.id','pc.due_amount' , 'pc.created_at')
            ->leftJoin('user', 'user.id', '=', 'pc.user_id')
            ->orderBy('pc.id', 'desc')
            ->get();

        // dd($protion_list);

        return view('admin.promotions.promotion_list', ['promotion_list' => $promotion_list]);
    }

    public function single_promotion_details($id)
    {
        // dd($id);
        $promotion = DB::table('promotion_coupons as pc')
            ->select(
                'user.name',
                'user.address',
                'user.user_type_id',
                'pp.package_name',
                'pc.purchase_price',
                'pc.transaction_type',
                'pc.total_days',
                'pc.buffer_days',
                'mu.name as marketer_user_name',
                'pc.downpayment_price',
                'pc.due_amount',
                's.state_name'
            )
            ->leftJoin('user', 'user.id', '=', 'pc.user_id')
            ->leftJoin('promotion_package as pp', 'pp.id', '=', 'pc.package_id')
            ->leftJoin('user as mu', 'mu.id', '=', 'pc.marketer_user_id')
            ->leftJoin('state as s', 's.id', '=', 'user.state_id')
            ->where('pc.id', $id)
           
            ->first();

        // dd($promotion);

        return view('admin.promotions.single-promotion-details', ['promotion' => $promotion]);
    }

    public function updateDueAmount(Request $request, $promotion_id)
    {
        //dd($request->due_amount);
        if (!empty($promotion_id) && !empty($request->due_amount))
        {
            $date1 =  Carbon::now();
            $start_date = date("Y-m-d H:i:s", strtotime($date1));
            $financialYear = Subscription::getFinancialYear($start_date, "y");
            $getId = 0;
            $getId = DB::select("SELECT 
            LPAD(
                MAX(
                    CAST(
                        SUBSTRING(invoice_no, LENGTH('AECPL/OS-') + 1) AS UNSIGNED
                    )
                ),
                LENGTH(MAX(CAST(SUBSTRING(invoice_no, LENGTH('AECPL/OS-') + 1) AS UNSIGNED))), '0'
            ) AS max_invoice_number
                FROM (
                    SELECT invoice_no FROM promotion_coupons
                  ) AS combined_tables");

            $invoiceId = $getId[0]->max_invoice_number + 1;

            $amount = $request->due_amount;
            $old_due_amount = DB::table('promotion_coupons')->where('id', $promotion_id)->first()->due_amount;

            $due_amount = ($old_due_amount - $amount );
            //dd($due_amount);

            $data = [
                'invoice_no' => "AECPL/OS-" . str_pad($invoiceId, 5, "0", STR_PAD_LEFT) . "/" . $financialYear,
                'due_amount' => $due_amount
            ];


            $update_due_amount = DB::table('promotion_coupons')->where('id', $promotion_id)->update($data);
        }

        $promotion = DB::table('promotion_coupons as pc')
        ->select(
            'user.name',
            'user.address',
            'user.user_type_id',
            'pp.package_name',
            'pc.purchase_price',
            'pc.transaction_type',
            'pc.total_days',
            'pc.buffer_days',
            'mu.name as marketer_user_name',
            'pc.downpayment_price',
            'pc.due_amount'
        )
        ->leftJoin('user', 'user.id', '=', 'pc.user_id')
        ->leftJoin('promotion_package as pp', 'pp.id', '=', 'pc.package_id')
        ->leftJoin('user as mu', 'mu.id', '=', 'pc.marketer_user_id')
        ->where('pc.id', $promotion_id)
        ->first();

   // return view('admin.promotions.single-promotion-details', ['promotion' => $promotion]);
    return redirect::to('single-promotion/'.$promotion_id);
    }


    public function getPackagePrice(Request $request)
    {
        $productId = $request->input('product_id');
        $package_price = DB::table('promotion_package')->where('id',$productId)->first()->package_price;
        if ($package_price) {
            return response()->json(['price' => $package_price]);
        } else {
            return response()->json(['error' => 'Package Price not found'], 404);
        }
    }

    public function editPromotion(Request $request , $promotionId){
        //dd($promotionId);
        $promotionDetails =  DB::table('promotion_coupons as pc')
        ->select('u.name as userName','u.mobile as userMobile' , 'u.user_type_id' , 'u.address as userAddress','s.state_name',
       'pc.downpayment_price','pc.due_amount','pp.package_name','pp.package_price','pc.discount','pc.transaction_type',
       'pc.transaction_id','pc.order_id','pc.gst','pc.cgst','pc.sgst','pc.igst','pc.total_days','pc.buffer_days','pc.total_amount',
       'us.name as marketUserName')
        ->leftJoin('user as u', 'u.id', '=', 'pc.user_id')
        ->leftJoin('user as us', 'us.id', '=', 'pc.marketer_user_id')
        ->leftJoin('promotion_package as pp', 'pp.id', '=', 'pc.package_id')
        ->leftJoin('state as s', 's.id', '=', 'u.state_id')
        ->where('pc.id',$promotionId)
        ->first();

       // dd($promotionDetails);

        return view('admin.promotions.edit_promotion' ,['promotionDetails'=>$promotionDetails]);

    }


    public function updatePromotion(Request $request , $promotionId){
       // dd($request->all());
        $settlement_amount = $request->settlement_amount;

        $promotion_details = DB::table('promotion_coupons')->where('id',$promotionId)->first();
        $due_amount        = $promotion_details->due_amount;
        $downpayment_price = $promotion_details->downpayment_price;
        $user_id           = $promotion_details->user_id;
        $total_days        = $promotion_details->total_days + $request->total_days;
        $buffer_days       = $promotion_details->buffer_days + $request->buffer_days;


        $update_due_amount = ($due_amount - $settlement_amount);
        $update_downpayment_price = ($downpayment_price + $settlement_amount);


        $totalDateCarbon      =  Carbon::now();
        $total_days_start_day = date("Y-m-d H:i:s", strtotime($totalDateCarbon));
        
        if(!empty($total_days)){
            $totalDate            = $totalDateCarbon->addDays($request->total_days);
            $totalDatas           = $totalDate->format('Y-m-d H:i:s');
            $total_days_end_day   = date("Y-m-d H:i:s", strtotime($totalDatas));
            // dd($total_days_end_day);
        }

        $bufferDateCarbon =  Carbon::now();
        if(!empty($buffer_days)){
            $bufferStartDate         = $bufferDateCarbon->addDays($request->total_days + 1);
            $startDateBuffer         = $bufferStartDate->format('Y-m-d H:i:s');
            $buffer_days_start_day   = date("Y-m-d H:i:s", strtotime($startDateBuffer));
            $buffer_days_end_day     = date('Y-m-d H:i:s', strtotime($buffer_days_start_day . ' + ' . $request->buffer_days . ' days'));

            //dd($buffer_days_end_day);
        }

        if($due_amount == $settlement_amount){
            $buffer_days = 0;
        }else{
            $buffer_days = $promotion_details->buffer_days;
        }

        $date1 =  Carbon::now();
        $start_date = date("Y-m-d H:i:s", strtotime($date1));
        $financialYear = Subscription::getFinancialYear($start_date, "y");
        $getId = 0;
        $getId = DB::select("SELECT 
        LPAD(
            MAX(
                CAST(
                    SUBSTRING(invoice_no, LENGTH('AECPL/OS-') + 1) AS UNSIGNED
                )
            ),
            LENGTH(MAX(CAST(SUBSTRING(invoice_no, LENGTH('AECPL/OS-') + 1) AS UNSIGNED))), '0'
        ) AS max_invoice_number
            FROM (
                SELECT invoice_no FROM promotion_coupons
              ) AS combined_tables");

        $invoiceId = $getId[0]->max_invoice_number + 1;

        $update_promotion_details = DB::table('promotion_coupons')->where('id',$promotionId)->update(
        [
            //'buffer_days'             => $buffer_days,
            'due_amount'              => $update_due_amount,
            'downpayment_price'       => $update_downpayment_price,
            'invoice_no'              => "AECPL/OS-" . str_pad($invoiceId, 5, "0", STR_PAD_LEFT) . "/" . $financialYear,
            'total_days'              => $total_days,
            'buffer_days'             => $buffer_days,
            'total_days_start_day'    => $total_days_start_day,
            'total_days_end_day'      => $total_days_end_day,
            'buffer_days_start_day'   => $buffer_days_start_day,
            'buffer_days_end_day'     => $buffer_days_end_day
        ]);

        $user = DB::table('user')->where('id', $user_id)->first();
        // $user_id          = $user->id;
        $language         = $user->lamguage;
        $mobile           = $user->mobile;
        $firebase_token   = $user->firebase_token;

        sms::dueClearOfflineMembership($language,$user_id,$firebase_token);

        return redirect::to('single-promotion/'.$promotionId);
    }
    // Get invoice
   // public function getInvoiceData(Request $request, $invoiceId)
    public function getInvoiceData(Request $request, $invoiceType, $invoiceId)
    {
        $invoiceData  = DB::table('invoice as inv')
                        ->select('inv.*', 'u.name as user_name', 'u.address', 'u.zipcode', 's.state_name', 'd.district_name', 'c.city_name', 'c.pincode', 'pp.package_name')
                        ->leftJoin('user as u', 'u.id','=','inv.user_id')
                        ->leftJoin('state as s', 's.id','=','u.state_id')
                        ->leftJoin('district as d', 'd.id','=','u.district_id')
                        ->leftJoin('city as c', 'c.id','=','u.city_id')
                        ->leftJoin('promotion_package as pp', 'pp.id','=','inv.package_id')
                        ->where('inv.id', $invoiceId)
                        ->where('invoice_type',$invoiceType)
                        ->first();

        $date           = date_create($invoiceData->start_date);
        $start_date     = date_format($date, "d/m/Y");
        $start_time     = date_format($date, "H:i:s");

        return view('admin.invoice_all', [
            'promotion_details' => $invoiceData->invoice_name,
            'start_date' => $invoiceData->start_date, 'start_time' => $start_time, 'end_date' => $invoiceData->end_date, 'user_name' => $invoiceData->user_name, 'address' => $invoiceData->address, 'zipcode' => $invoiceData->zipcode,
            'state_name' => $invoiceData->state_name, 'district_name' => $invoiceData->district_name, 'package_name' => $invoiceData->package_name,
            'total_price' => $invoiceData->invoice_amount, 'discount' => $invoiceData->discount, 'purchase_price' => $invoiceData->invoice_amount,
            'downpayment_price' => $invoiceData->downpayment_price, 'due_amount' => $invoiceData->due_amount, 
        ]);
    }


    public function getProductBoostsInvoiceData(Request $request,  $userId)
    {
       
        $subscribed_boosts_id = DB::table('subscribed_boosts')
        ->where('user_id', $userId)
        ->where('status', 1)
        ->orderBy('id', 'desc')
        ->first()->id;
        // dd($subscribed_boosts_id);
        $boost_details = DB::table('subscribed_boosts as sb')
            ->select(
                'u.name',
                'u.address',
                'u.zipcode',
                's.state_name',
                'd.district_name',
                'c.city_name',
                'sb.invoice_no',
                'sb.gst',
                'sb.sgst',
                'sb.cgst',
                'sb.igst',
                'sb.purchased_price',
                'sb.price',
                'sb.start_date',
                'sb.end_date',
                'sb.end_date'
            )
            ->leftJoin('user as u', 'u.id', '=', 'sb.user_id')
            ->leftJoin('state as s', 's.id', '=', 'u.state_id')
            ->leftJoin('district as d', 'd.id', '=', 'u.district_id')
            ->leftJoin('city as c', 'c.id', '=', 'u.city_id')
            ->where('sb.id', $subscribed_boosts_id)
            ->first();

        //dd($boost_details);

        $timeString = $boost_details->start_date;
        //dd($timeString);
        $time = new DateTime($timeString);
        $start_time = $time->format('g:i A');
        $start_date = $time->format('j F Y');

        $dateString = $boost_details->end_date;
        $date = new DateTime($dateString);
        $end_date = $date->format('j F Y');

        return view('admin.invoice', ['start_date' => $start_date, 'start_time' => $start_time, 'end_date' => $end_date, 'boost_details' => $boost_details]);
 
    }





}
