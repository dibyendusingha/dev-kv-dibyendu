@extends('admin.layout.main')
@section('page-container')




            <section class="content-main">
                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Push Notification</h2>
                        <p>Send Notification</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                  {{ session('success') }}
                                </div>
                            @elseif(session('failed'))
                                <div class="alert alert-danger" role="alert">
                                  {{ session('failed') }}
                                </div>
                            @endif
                            <div class="col-md-12">
                                
                                @if (isset($arr))
                                
                                
                                <form method="post" action="{{url('notification-schedule-update')}}" enctype="multipart/form-data">
                                 @csrf
                                 
                                 <input type="hidden" name="sch_id" value="{{$arr->id}}"/>
                                    <div class="mb-4 d-flex">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="language" id="english" value="1" <?php if ($arr->language_id==1){echo 'checked';}?> >
                                            <label class="form-check-label" for="individual">English</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="language" id="hindi" value="2" <?php if ($arr->language_id==2){echo 'checked';}?> >
                                            <label class="form-check-label" for="group">Hindi</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="language" id="bengali" value="3" <?php if ($arr->language_id==3){echo 'checked';} ?> >
                                            <label class="form-check-label" for="group">Bengali</label>
                                        </div>
                                        
                                        @if ($errors->has('language'))
                                            <span class="text-danger">{{ $errors->first('language') }}</span>
                                        @endif
        
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="title" class="form-label ">Add Date and Time</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <input type="date" id="datepick" name="datepick" class="form-control" value="{{$arr->date}}" {{ old('datepick') }}>
                                          
                                          <input type="time" id="timepick" name="timepick" class="form-control" value="{{$arr->time}}" {{ old('timepick') }}>
                                        </div>
                                        @if ($errors->has('datepick'))
                                            <span class="text-danger">{{ $errors->first('datepick') }}</span>
                                        @endif
                                        @if ($errors->has('timepick'))
                                            <span class="text-danger">{{ $errors->first('timepick') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{$arr->tiltle}}" {{ old('title') }}>
                                        @if ($errors->has('title'))
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea rows="6" id="editor" class="form-control" name="description" {{ old('description') }}>{{$arr->deception}}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="description" class="form-label">Add Image</label>
                                        <div class="text-center border rounded p-4">
                                            <input type="file" accept="image/*" onchange="loadFile(event)" class="form-control" name="image" >
                                            <img src="{{$arr->img}}" id="output" class="d-inline-block pt-5" width="250"/>
                                        </div>
                                        @if ($errors->has('image'))
                                            <span class="text-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="text-center w-100">
                                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                                    </div>
                                </form>
                                
                                @else  
                                
                                <form method="post" action="{{url('notification-schedule')}}" enctype="multipart/form-data">
                                 @csrf
                                    <div class="mb-4 d-flex">
                                        <!--<label for="product_name" class="form-label">Brand Name</label>-->
                                        <!--<input type="text" placeholder="Type here" class="form-control" id="brand_name" name="brand_name" />-->
                                        <!--@error('brand_name')-->
                                        <!--<div class="" style="color:red">{{ $message }}</div>-->
                                        <!--@enderror-->
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="language" id="english" value="1" {{ old('language') == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="individual">English</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="language" id="hindi" value="2" {{ old('language') == 2 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="group">Hindi</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="language" id="bengali" value="3" {{ old('language') == 3 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="group">Bengali</label>
                                        </div>
                                        
                                        @if ($errors->has('language'))
                                            <span class="text-danger">{{ $errors->first('language') }}</span>
                                        @endif
        
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="title" class="form-label ">Add Date and Time</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <input type="date" id="datepick" name="datepick" class="form-control" {{ old('datepick') }}>
                                          <input type="time" id="timepick" name="timepick" class="form-control" {{ old('timepick') }}>
                                        </div>
                                        @if ($errors->has('datepick'))
                                            <span class="text-danger">{{ $errors->first('datepick') }}</span>
                                        @endif
                                        @if ($errors->has('timepick'))
                                            <span class="text-danger">{{ $errors->first('timepick') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" {{ old('title') }}>
                                        @if ($errors->has('title'))
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea rows="6" id="editor" class="form-control" name="description" {{ old('description') }}>
                                            
                                        </textarea>
                                        @if ($errors->has('description'))
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="description" class="form-label">Add Image</label>
                                        <div class="text-center border rounded p-4">
                                            <input type="file" accept="image/*" onchange="loadFile(event)" class="form-control" name="image" >
                                            <img src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-image-512.png" id="output" class="d-inline-block pt-5" width="250"/>
                                        </div>
                                        @if ($errors->has('image'))
                                            <span class="text-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="text-center w-100">
                                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                                    </div>
                                </form>
                                
                                @endif
                                
                            </div>
                            
                            <!--<div class="col-md-8">-->
                            <!--    <div class="table-responsive">-->
                            <!--        <table class="table table-hover">-->
                            <!--            <thead>-->
                            <!--                <tr>-->
                            <!--                    <th class="text-center">-->
                            <!--                        <div class="form-check">-->
                            <!--                            <input class="form-check-input" type="checkbox" value="" />-->
                            <!--                        </div>-->
                            <!--                    </th>-->
                            <!--                    <th>userID</th>-->
                            <!--                    <th>Name</th>-->
                            <!--                    <th>Phone No.</th>-->
                            <!--                    <th>Zipcode</th>-->
                            <!--                </tr>-->
                            <!--            </thead>-->
                            <!--            <tbody>-->
                            <!--               
                                                
                            <!--            </tbody>-->
                            <!--        </table>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!-- .col// -->
                            
                        </div>
                        <!-- .row // -->
                    </div>
                    <!-- card body .// -->
                </div>
                <!-- card .// -->
            </section>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                
              $(document).ready(function() {
            $("#timepick").change(function() {
                let x = $(this).val();
                console.log(x);
            });
        });
                
            </script>

            <script>
                var loadFile = function(event) {
                    var reader = new FileReader();
                    reader.onload = function(){
                      var output = document.getElementById('output');
                      output.src = reader.result;
                    };
                    reader.readAsDataURL(event.target.files[0]);
                  };
            </script>
            
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js" integrity="sha512-BmM0/BQlqh02wuK5Gz9yrbe7VyIVwOzD1o40yi1IsTjriX/NGF37NyXHfmFzIlMmoSIBXgqDiG1VNU6kB5dBbA==" crossorigin="anonymous"></script>
            
@endsection