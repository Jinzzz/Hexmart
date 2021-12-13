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
               <form action="{{route('admin.store_cgc_assign')}}" method="POST"
                  enctype="multipart/form-data">
                  @csrf
                  <div class="row">

                    

                     <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">Customer Group *</label>
                           <select required class="form-control" name="customer_group_id" id="customer_group_id">
                              <option value="">Customer Group </option>
                                 @foreach ($customerGroups as $key)
                                 <option {{old('customer_group_id') == $key->customer_group_id ? 'selected':''}} value=" {{ $key->customer_group_id}} "> {{ $key->customer_group_name }}</option>
                                 @endforeach
                           </select>
                        </div>
                     </div> 

                     <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">Customer *</label>
                           <select required class="form-control" name="customer_id" id="customer_id">
                              <option value="">Customer</option>
                                 @foreach ($customers as $key)
                                 <option {{old('customer_id') == $key->customer_id ? 'selected':''}} value=" {{ $key->customer_id}} "> {{ $key->customer_name }} - {{ $key->customer_mobile }}</option>
                                 @endforeach
                           </select>
                        </div>
                     </div> 

                   
                     <div class="col-md-12">
                        <div class="form-group">
                           <center>
                           <button type="submit" class="btn btn-raised btn-primary">
                           <i class="fa fa-check-square-o"></i> Add</button>
                           <button type="reset" class="btn btn-raised btn-success">
                           Reset</button>
                           <a class="btn btn-danger" href="{{ route('admin.customer_group_customers') }}">Cancel</a>
                           </center>
                        </div>
                     </div>
                  </div>
                  {{-- <script src="{{ asset('vendor\unisharp\laravel-ckeditor/ckeditor.js')}}"></script> --}}
                  {{-- <script>CKEDITOR.replace('sub_category_description');</script> --}}
               </form>

      </div>
   </div>
</div>
</div>
</div>
@endsection
