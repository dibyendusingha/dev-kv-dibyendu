@extends('admin.layout.main')
@section('page-container')
<?php
use Illuminate\Support\Facades\DB;
?>
       
            <section class="content-main">
                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Post List</h2>
                    </div>
                </div>
                <div class="card mb-4">
                    <header class="card-header">
                        <div class="row align-items-center">
                            
                            <div class="col-md-2 col-6">
                                <input type="date" id="creater_at" class="form-control" />
                            </div>
                            <div class="col-md-2 col-6">
                                <select class="form-select" id="status" onChange="filter(this.value)">
                                    <option value="" selected>Status</option>
                                    <option value=1>Approve</option>
                                    <option value=2>Reject</option>
                                    <option value=0>Pending</option>
                                </select>
                            </div>
                        </div>
                    </header>
                    <!-- card-header end// -->
                    <div class="card-body">
                    			<div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Title</th>
                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Status</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_tbody">
                                            <?php
                                            $pesticides_arr = DB::table('pesticides')->orderBy('id','desc')->paginate(50);
                                            foreach ($pesticides_arr as $val) {
                                                $user = DB::table('user')->where(['id'=>$val->user_id])->first();
                                            ?>
                                            <tr>
                                                <td>{{$val->created_at}}</td>
                                                <td>
                                                {{$val->title}}
                                                </td>
                                                <td>
                                                    <?php if(!empty($user->name)){ ?>
                                                    {{$user->name}}
                                                    <?php }else{ echo "N/A"; }?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($user->mobile)){ ?>
                                                    {{$user->mobile}}
                                                    <?php }else{ echo "N/A"; }?>
                                                </td>
                                                <td><span class="badge rounded-pill alert-<?php if($val->status==1) {echo 'success';} 
                                                else if($val->status==0) {echo 'warning';} 
                                                else if($val->status==3) {echo 'secondary';} 
                                                else if($val->status==4) {echo 'info';}
                                                else {echo 'danger';}?>">
                                                    <?php if($val->status==1) {echo 'Approved';} 
                                                    else if($val->status==0) {echo 'Pending';} 
                                                    else if($val->status==3) {echo 'Disabled';} 
                                                    else if($val->status==4) {echo 'Sold';} 
                                                    else {echo 'Rejected';}?></span></td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{url('krishi-pesticides-post-view/'.$val->id)}}">View Post</a>
                                                            <!--<a class="dropdown-item text-danger" href="{{url('krishi-pesticides-post-delete/'.$val->id)}}">Delete</a>-->
                                                        </div>
                                                    </div>
                                                    <!-- dropdown //end -->
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                    </div>
                    <!-- card-body end// -->
                </div>
                <!-- card end// -->
                <div class="pagination-area mt-30 mb-50">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-start">
                            {!! $pesticides_arr->links() !!}
                        </ul>
                    </nav>
                </div>
            </section>
            <!-- content-main end// -->
            
            <script>
                function filter (x) {
                    var post_type = $('#post_type').val();
                    var status = $('#status').val();
                    var creater_at = $('#creater_at').val();
                    //alert(post_type);
                    //alert(status);
                    //alert(creater_at);
                    	$.ajax({
                		url:"/pesticides-filter-data",
                		type:"POST",
                		data:{
                		    "_token": "{{ csrf_token() }}",
                		    status:status,
                		    creater_at:creater_at
                		},
                		success:function(response){
                		    //alert(response);
                		    
                		    if (response) {
                		        $('#table_tbody').html(response);
                		    } 
                        
                        },
                	});  
                }
            </script>
@endsection
