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
               <form action="{{route('admin.store_iltsc')}}" method="POST"
                  enctype="multipart/form-data">
                  @csrf
                  <div class="row">

                     <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" >Main Category </label>
                            <select name="cat_id"  id="category" class="form-control"  >
                                 <option value="">Main Category</option>
                                 @foreach($categories as $key)
                                 <option {{old('product_cat_id') == $key->item_category_id ? 'selected':''}} value="{{ @$key->item_category_id }}">{{ @$key->category_name }}</option>
                                 @endforeach
                            </select>
                        </div>
                     </div>

                    <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-label">Sub Category Level One *</label>
                           <select required class="form-control" name="item_sub_category_id" id="sub_category_id">
                              <option value="">Sub Category</option>
                                 @foreach ($sub_categories as $key)
                                 <option {{old('item_sub_category_id') == $key->item_sub_category_id ? 'selected':''}} value=" {{ $key->item_sub_category_id}} "> {{ $key->sub_category_name }}</option>
                                 @endforeach
                           </select>
                        </div>
                     </div> 

                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="form-label">Sub Category Level Two Name *</label>
                           <input required type="text" class="form-control" name="iltsc_name" value="{{old('iltsc_name')}}" placeholder="Sub Category">
                        </div>
                     </div>

                    
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">Sub Category Icon [150*150] </label>
                           <input  type="file" class="form-control" accept="image/x-png,image/jpg,image/jpeg" 
                           name="iltsc_icon" value="{{old('iltsc_icon')}}" placeholder="Sub Category Icon">
                        </div>
                     </div>

                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="form-label">Sub Category Description *</label>
                           <textarea  required class="form-control" id="iltsc_description" name="iltsc_description" rows="4" placeholder="Sub Category Description">{{old('iltsc_description')}}</textarea>
                        </div>
                        <div class="form-group">
                           <center>
                           <button type="submit" class="btn btn-raised btn-primary">
                           <i class="fa fa-check-square-o"></i> Add</button>
                           <button type="reset" class="btn btn-raised btn-success">
                           Reset</button>
                           <a class="btn btn-danger" href="{{ route('admin.iltsc') }}">Cancel</a>
                           </center>
                        </div>
                     </div>
                  </div>
                  {{-- <script src="{{ asset('vendor\unisharp\laravel-ckeditor/ckeditor.js')}}"></script> --}}
                  {{-- <script>CKEDITOR.replace('iltsc_description');</script> --}}
               </form>

      </div>
   </div>
</div>
</div>
</div>
<script>
    $(document).ready(function() {
    var pcc = 0;
      //  alert("dd");
       $('#category').change(function(){
         if(pcc != 0)
         { 
        var category_id = $(this).val();
       //alert(business_type_id);
        var _token= $('input[name="_token"]').val();
        //alert(_token);
        $.ajax({
          type:"GET",
          url:"{{ url('admin/ajax/get-sub-category') }}?item_category_id="+category_id,


          success:function(res){
           // alert(data);
            if(res){
            $('#sub_category_id').prop("diabled",false);
            $('#sub_category_id').empty();
            $('#sub_category_id').append('<option value="">Sub Category</option>');
            $.each(res,function(item_sub_category_id,sub_category_name)
            {
              $('#sub_category_id').append('<option value="'+item_sub_category_id+'">'+sub_category_name+'</option>');
            });

            }else
            {
              $('#sub_category_id').empty();

            }
            }

        });
         }else{
           pcc++;
         }
      });

    });
</script>
@endsection
