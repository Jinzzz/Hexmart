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
                    <form action="{{route('admin.store_delivery_boy')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="form-label">Name *</label>
                            <input type="text" required class="form-control" name="delivery_boy_name" value="{{old('delivery_boy_name')}}" placeholder="Name">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="form-label">Phone *</label>
                            <input type="text" required class="form-control" name="delivery_boy_phone" value="{{old('delivery_boy_phone')}}" placeholder="Phone">
                            </div>
                        </div>
                        

                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="delivery_boy_email" value="{{old('delivery_boy_email')}}" placeholder="Email">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="form-label">Address *</label>
                            <textarea required class="form-control" name="delivery_boy_address"  placeholder="Address">{{old('delivery_boy_address')}}</textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="form-label">Password *</label>
                            <input type="text" class="form-control" name="password" value="{{old('password')}}" placeholder="Password" required>
                            </div>
                        </div>

                         <div class="col-md-6">
                            <div class="form-group">
                            <label class="form-label">Confirm Password *</label>
                            <input type="text" class="form-control" name="password_confirmation" value="{{old('password_confirmation')}}" placeholder="Confirm Password" required>
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
                                    <a class="btn btn-danger" href="{{ route('admin.delivery_boys') }}">Cancel</a>
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
@endsection
