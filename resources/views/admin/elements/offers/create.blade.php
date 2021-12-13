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
                    <form action="{{route('admin.store_offer')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                       

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" >Main Category </label>
                                <select name="item_category_id"  id="category" class="form-control"  >
                                     <option value="">Main Category</option>
                                     @foreach($categories as $key)
                                     <option {{old('item_category_id') == $key->item_category_id ? 'selected':''}} value="{{ @$key->item_category_id }}">{{ @$key->category_name }}</option>
                                     @endforeach
                                </select>
                            </div>
                         </div>

                         <div class="col-md-4">
                            <div class="form-group">
                              <label class="form-label">Product *</label>
                               <select required class="form-control" name="product_variant_id" id="product_variant_id">
                                  <option value="">Product</option>
                                   
                               </select>
                            </div>
                         </div> 

                         <div class="col-md-4">
                            <div class="form-group">
                               <label class="form-label">Offer Price *</label>
                               <input required type="text" class="form-control" name="offer_price" value="{{old('offer_price')}}" placeholder="Offer Price">
                            </div>
                         </div>


                         <div class="col-md-6">
                            <div class="form-group">
                               <label class="form-label">From Date *</label>
                               <input required type="date" class="form-control" name="date_start" value="{{old('date_start')}}" placeholder="From Date">
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="form-group">
                               <label class="form-label">From Time *</label>
                               <input required type="time" class="form-control" name="time_start" value="{{old('time_start')}}" placeholder="From Time">
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="form-group">
                               <label class="form-label">Date End *</label>
                               <input required type="date" class="form-control" name="date_end" value="{{old('date_end')}}" placeholder="Date End">
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="form-group">
                               <label class="form-label">Time End *</label>
                               <input required type="time" class="form-control" name="time_end" value="{{old('time_end')}}" placeholder="Time End">
                            </div>
                         </div>

                         <div class="col-md-12">
                            <div class="form-group">
                               <label class="form-label">Link </label>
                               <textarea type="time" class="form-control" name="link" placeholder="Link">{{old('link')}}</textarea>
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
                                    <a class="btn btn-danger" href="{{ route('admin.offers') }}">Cancel</a>
                                    </center>
                                </div>
                            </div>

                        </div>

                        
                    </div>
                    {{-- <script src="{{ asset('vendor\unisharp\laravel-ckeditor/ckeditor.js')}}"></script>
                    <script>CKEDITOR.replace('offer_description');</script> --}}
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
          url:"{{ url('admin/ajax/get-product-by-category') }}?item_category_id="+category_id,


          success:function(res){
           // alert(data);
            if(res){
               // console.log(res);
            $('#product_variant_id').prop("diabled",false);
            $('#product_variant_id').empty();
            $('#product_variant_id').append('<option value="">Sub Category</option>');
            let c = 0;
            $.each(res,function(product_variant_id,product_name,variant_name)
            {
            
             $('#product_variant_id').append('<option value="'+res[c]['product_variant_id']+'">'+res[c]['product_name']+' '+res[c]['variant_name']+'</option>');
             c++;
            });

            }else
            {
              $('#product_variant_id').empty();

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
