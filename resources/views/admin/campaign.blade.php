
<?php
use Illuminate\Support\Facades\DB;
//echo $url = Request::path();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Krishivikas Digital Campaign</h2>
        <h3>{{$counter}}</h3>
    </div>
                


    <div class="card mb-4">
               
    <header class="card-header">
                        

    
                    </header>
                    <!-- card-header end// -->
                    <div class="card-body">
                        <form method="post" action="{{url('campaign')}}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">ENTER NUMBERS:</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" id="campaign_number" name="campaign_number" rows="10" placeholder="eg. 4567891231, 8957458521">{{$campaign_number}}</textarea>
                            </div>

                            <div class="publish-action mt-5 text-center">
                                <input type="submit" name="publish" value="SUBMIT" class="btn btn-success">
                            </div>
                            </form>
                    </div>
                    <!-- card-body end// -->
                </div>
                <!-- card end// -->
                
            </section>

