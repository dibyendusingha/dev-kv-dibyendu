@extends('admin.layout.main')
@section('page-container')
<?php
    use Illuminate\Support\Facades\DB;
?>

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">CROPS CATEGORY LIST</h2>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            @if(!empty($crops_category_list))
            @foreach($crops_category_list as $category)
           
            <div class="col-lg-5">
                <a href="{{url('crops-category-wish-product/'.$category->id)}}">
                    <div class="card card-body mb-4">
                        <article class="icontext">
                            <span class="icon icon-sm rounded-circle bg-primary-light">
                                <img src="{{$category->logo}}" alt="">
                            </span>
                            <div class="text">
                                <h6 class="mb-1 card-title">{{$category->crops_cat_name}}</h6>
                                <?php $category_count = DB::table('crops')->where('crops_category_id',$category->id)->count(); ?>
                                <span>{{$category_count}}</span>
                            </div>
                        </article>
                    </div>
                </a>
            </div>
       
            @endforeach
            @endif
            
        </div>
    </div>
    

</section>



@endsection