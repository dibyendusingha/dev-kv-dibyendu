@extends('admin.layout.main')
@section('page-container')
<?php
use Illuminate\Support\Facades\DB;
//echo $url = Request::path();
if (isset($_GET['search_user_list'])) {
    $search_user_list = $_GET['search_user_list'];
}
?>


<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Referral Codes</h2>
    </div>
                


    <div class="card mb-4">
               
    <header class="card-header">
                        

    
                    </header>
                    <!-- card-header end// -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Referral Code</th>
                                        <th>Name</th>
                                        <th>Phone No.</th>
                                        <th>Email</th>
                                        <th>Details</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php
                                    foreach ($data as $val) {
                                    ?>
                                    <tr>
                                        <td width="40%">{{$val->referral_code}}</td>
                                        <td>{{$val->name}}</td>
                                        <td>{{$val->phone}}</td>
                                        <td>{{$val->email}}</td>
                                        <td>{{$val->details}}</td>
                                        
                                        <td><?php if ($val->status==1) {echo 'Active';} else {echo 'In Active';}?></td>
                                        
                                    </tr>
                                    <?php }  ?>


                                </tbody>
                            </table>
                            <!-- table-responsive.// -->
                        </div>
                    </div>
                    <!-- card-body end// -->
                </div>
                <!-- card end// -->
                <div class="pagination-area mt-15 mb-50">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-start">
                            {!! $data->links() !!}
                        </ul>
                    </nav>
                </div>
            </section>
            
@endsection
