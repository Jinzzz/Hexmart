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

                    
                    <form action="{{route('admin.update_brand',$brand->brand_id)}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if(isset($brand->brand_icon))
                    <img class="m-2" src="{{asset('assets/uploads/brand_icon/'.$brand->brand_icon)}}"  width="50" >
                    @endif
                    <div class="row">
                       

                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="form-label">Brand</label>
                            <input type="text" required class="form-control" name="brand_name" value="{{old('brand_name',$brand->brand_name)}}" placeholder="brand">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="form-label">Brand Icon</label>
                            <input type="file" class="form-control" accept="image/x-png,image/jpg,image/jpeg" 
                            name="brand_icon" value="{{old('brand_icon')}}" placeholder="brand Icon">
                            </div>
                        </div>
                        

                       

                            <div class="col-md-2">
                                <label class="custom-switch">
                                    <input type="hidden" name="is_active" value=0 />
                                    <input type="checkbox" name="is_active" @if ($brand->is_active == 1)
                                    checked
                                    @endif   value=1 class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Status</span>
                                </label>
                            </div>

                           
                        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <center>
                                    <button type="submit" class="btn btn-raised btn-primary">
                                    <i class="fa fa-check-square-o"></i> Update</button>
                                    <button type="reset" class="btn btn-raised btn-success">Reset</button>
                                    <a class="btn btn-danger" href="{{ route('admin.brands') }}">Cancel</a>
                                    </center>
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
@endsection
