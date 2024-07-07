@extends('admin.layout.main')
@section('page-container')
<?php

use Illuminate\Support\Facades\DB;
?>

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Users Details</h2>
        </div>
    </div>
    <div class="card mb-4">

        <!-- card-header end// -->
        <div class="card-body">
            <form method="post" action="{{url('user-update',$user->id)}}">
                @csrf
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <label for="product_slug" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{$user->name}}" readonly>
                    </div>

                    <div class="mb-4 col-md-6">
                        <label for="product_slug" class="form-label">Mobile</label>
                        <input type="text" class="form-control" name="mobile" value="{{$user->mobile}}" readonly>
                    </div>

                    <div class="mb-4 col-md-6">
                        <label for="product_slug" class="form-label">Post Count</label>
                        <input type="number" class="form-control" name="user_post_count" value="{{$user->user_post_count}}" readonly>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="product_slug" class="form-label">Post Limit</label>
                        <input type="number" class="form-control" name="limit_count" value="{{$user->limit_count}}">
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">UPDATE</button>
                </div>
            </form>
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->

</section>
<!-- content-main end// -->

@endsection