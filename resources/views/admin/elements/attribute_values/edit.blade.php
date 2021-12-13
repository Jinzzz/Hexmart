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
                    <form action="{{route('admin.update_attribute_value',$attribute_value->attribute_value_id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                  <label class="form-label">Attribute Group *</label>
                                   <select required class="form-control" name="attribute_group_id" id="attribute_group_id">
                                      <option value="">Attribute Group</option>
                                         @foreach ($attribute_groups as $key)
                                         <option {{old('attribute_group_id',$attribute_value->attribute_group_id) == $key->attribute_group_id ? 'selected':''}} value=" {{ $key->attribute_group_id}} "> {{ $key->attribute_group }}</option>
                                         @endforeach
                                   </select>
                                </div>
                             </div> 


                            <div class="col-md-12">
                                <div class="form-group">
                                <label class="form-label">Attribute Value</label>
                                <input type="text" class="form-control" name="attribute_value" value="{{old('attribute_value',$attribute_value->attribute_value)}}" placeholder="Attribute Value">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="custom-switch">
                                    <input type="hidden" name="is_active" value=0 />
                                    <input type="checkbox" name="is_active" @if ($attribute_value->is_active == 1)
                                    checked
                                    @endif   value=1 class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Status</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <center>
                            <button type="submit" class="btn btn-raised btn-primary">
                            <i class="fa fa-check-square-o"></i> Add</button>
                            <button type="reset" class="btn btn-raised btn-success">Reset</button>
                            <a class="btn btn-danger" href="{{ route('admin.attribute_value') }}">Cancel</a>
                            </center>
                        </div>
                        
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
