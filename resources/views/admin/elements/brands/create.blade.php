@extends('admin.layouts.app')
@section('content')
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <h3 class="mb-0 card-title">{{$pageTitle}}</h3>
            </div>
            <div class="card-body">
               @if ($message = Session::get('status'))
               <div class="alert alert-success">
                  <p>{{ $message }}</p>
               </div>
               @endif
            </div>
                <div class="col-lg-12">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{route('admin.store_brand')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="form-label">Brand</label>
                            <input type="text" class="form-control" name="brand_name" value="{{old('brand_name')}}" placeholder="Brand">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="form-label">Brand Icon</label>
                            <input type="file" class="form-control" accept="image/x-png,image/jpg,image/jpeg" required
                            name="brand_icon" value="{{old('brand_icon')}}" placeholder="Brand Icon">
                            </div>
                        </div>
                         

                            <div class="col-md-6">
                            <div class="form-group">
                            <div id="Category">
                            <select name="category[]" required="" class="form-control" >
                            <option value=""> Select Category</option>
                             @foreach($category as $key)
                             <option  value="{{$key->iltsc_id}}"> {{$key->iltsc_name }} </option>
                             @endforeach
                            </select>
                            </div>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                            <label class="form-label">Add more</label>
                            <button type="button" id="addCategory" class="btn btn-raised btn-success"> Add More</button>
                            </div>
                            </div>

                            <div class="col-md-2">
                                <label class="custom-switch">
                                    <input type="hidden" name="is_active" value=0 />
                                    <input type="checkbox" name="is_active"  checked value=1 class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Status</span>
                                </label>
                            </div>
                        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <center>
                                    <button type="submit" class="btn btn-raised btn-primary">
                                    <i class="fa fa-check-square-o"></i> Add</button>
                                    <button type="reset" class="btn btn-raised btn-success">Reset</button>
                                    <a class="btn btn-danger" href="{{ route('admin.brands') }}">Cancel</a>
                                    </center>
                                </div>
                            </div>

                        </div>

                        
                    </div>
                    {{-- <script src="{{ asset('vendor\unisharp\laravel-ckeditor/ckeditor.js')}}"></script>
                    <script>CKEDITOR.replace('brand_description');</script> --}}
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {
    var wrapper      = $("#Category"); //Fields wrapper
    var add_button   = $("#addCategory"); //Add button ID

    var x = 1; //initlal text box count


    $(add_button).click(function(e){ //on add input button click
    e.preventDefault();
    //max input box allowed
    x++; //text box increment
    $(wrapper).append('<div> <br> <label class="form-label"> Select Category</label><select name="category[]" required="" class="form-control" ><option value=""> Select Category</option>@foreach($category as $key)<option  value="{{$key->iltsc_id}}"> {{$key->iltsc_name }} </option>@endforeach</select> <a href="#" class="remove_field btn btn-info btn btn-sm">Remove</a></div>'); //add input box

    });



    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').remove(); x--;
    })
    });


</script>

@endsection
