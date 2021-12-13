@extends('admin.layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
      <div class="card">
        <div class="row">
          <div class="col-12">
            
            
            @if ($message = Session::get('status'))
            <div class="alert alert-success">
              <p>{{ $message }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
            </div>
            @endif
            <div class="col-lg-12">
              @if ($errors->any())
              <div class="alert alert-danger">
                <strong>Whoops!</strong>
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

             <div class="card-header">
                        <h3 class="mb-0 card-title">{{$pageTitle}}</h3>
             </div>
                   
             
               <div class="card-body">
                <a class="btn btn-cyan btn-raised float-right mb-2" href="{{ route('admin.products') }}"><i class="fa fa-arrow-left"> Back</i></a>

                <div class="table-responsive">
                    <table  id="example" class="table table-striped table-bordered">
                          <thead>
                                 <tr>
                                 <th class="wd-15p">SL.No</th>
                                    <th class="wd-15p">{{ __('Variant Name') }}</th>
                                    <th class="wd-15p">{{ __('Sale Price') }}</th>
                                    <th class="wd-15p">{{ __('Offer Price') }}</th>
                                    <th class="wd-15p">{{ __('Image') }}</th>
                                    <th class="wd-15p">{{ __('Stock Count') }}</th>
                                    <th  class="wd-20p">{{__('Action')}}</th>
                                 </tr>
                              </thead>
                              <tbody class="col-lg-12 col-xl-6 p-0">
                                 @php
                                 $i = 0;
                                 @endphp
                              @if(!$product_variants->isEmpty())
                                 @foreach ($product_variants as $value)
                                 @php
                                 $i++;
                                 @endphp
                                 <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$value->variant_name}}</td>
                                    <td>{{$value->variant_price_regular}}</td>
                                    <td>{{$value->variant_price_offer}}</td>
                                    <td>
                                       <img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($value->product_id,$value->product_variant_id))}}"   width="50" >
                                    </td>
                                    <td>{{$value->stock_count}}</td>

                              <td>
                                 <form action="{{route('admin.destroy_product_variant',$value->product_variant_id)}}" method="POST">
                                    @csrf
                                    @method('POST')
                                    {{-- <a  data-toggle="modal" data-target="#AttrModal{{$value->product_variant_id}}" class="text-white btn btn-sm btn-indigo">Attributes</a> --}}
                                    <a href="{{ url('admin/product-variant/edit/'.$value->product_variant_id) }}" class="  text-white btn btn-sm btn-azure">Edit</a>
                                    <a  data-toggle="modal" data-target="#AddAttrModal{{$value->product_variant_id}}" class="  text-white btn btn-sm btn-yellow">Attributes</a>
                                    <br>
                                    <button type="submit" onclick="return confirm('Do you want to delete this item?');"  class="mt-2 btn btn-sm btn-danger">Delete</button>
                                 </form>
                                
                              </td>
                           </tr>
                           @endforeach
                           @else
                           <tr>
                        <td colspan="6"><center> No data available in the table</center></td>
                           </tr>
                           @endif
                        </tbody>
                     </table>
              </div>
            </div>
          </div>
        </div>
    
  </div>


  @foreach($product_variants as $value)
  <div class="modal fade" id="AddAttrModal{{$value->product_variant_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
     <div class="modal-dialog" role="document">
        <div class="modal-content">
           <div class="modal-header">
              <h5 class="modal-title" id="example-Modal3">Add Attributes</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
           </div>
           @php
                $var_atts = (new \App\Helpers\Helper)->variantArrtibutes($value->product_variant_id);
           @endphp
  
           <div class="modal-body">
            <table class="table table-striped table-bordered">
                 <thead>
                    <tr>
                    <th class="wd-15p">SL.No</th>
                       <th class="wd-15p">{{ __('Group Name') }}</th>
                       <th class="wd-15p">{{ __('Value Name') }}</th>
                    </tr>
                 </thead>
                 <tbody class="col-lg-12 col-xl-6 p-0">
                    @php
                    $i = 0;
                    @endphp
                    @if(!$var_atts->isEmpty())
                    @foreach ($var_atts as $val)
                       @php
                       $i++;
                       $attr_grp_name = \DB::table('mst__attribute_groups')->where('attribute_group_id',$val->attribute_group_id)->pluck('attribute_group');
                        $attr_val_name = \DB::table('mst__attribute_values')->where('attribute_value_id',$val->attribute_value_id)->pluck('attribute_value');
                       @endphp
                       <tr>
                          <td>{{$i}}</td>
                          <td>{{@$attr_grp_name[0]}}</td>
                          <td>{{@$attr_val_name[0]}}</td>
                         
                       </tr>
                    @endforeach
                    @else
                    <tr>
                 <td colspan="6"><center> No data available in the table</center></td>
                    </tr>
                    @endif
                 </tbody>
              </table>
           </div>
  
           <form action="{{ route('admin.add_attr_to_variant') }} " method="POST" enctype="multipart/form-data" >
            @csrf
             <div class="modal-body">
                <input type="hidden" name="product_variant_id" value="{{$value->product_variant_id}}">

                     <div  class=" row">
                           <div class="col-md-6">
                           <div class="form-group">
                              <label class="form-label">Attribute </label>
                              <select name="attr_grp_id"   class="attr_groupz form-control" >
                                 <option value="">Attribute</option>
                                 @foreach($attr_groups as $key)
                                 <option value="{{$key->attribute_group_id}}"> {{$key->attribute_group}} </option>
                                       @endforeach
                              </select>
                           </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="form-label">Value </label>
                                 <select name="attr_val_id" class="attr_valuez form-control" >
                                    <option value="">Value</option>
                                 </select>
                              </div>
                           </div>
                     </div>
            
                  
             </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-raised btn-primary">
               <i class="fa fa-check-square-o"></i> Add</button>
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
         </form>
             
                 
        </div>
     </div>
  </div>
  @endforeach
  
<script>
    
    var ac = 0;

$('.attr_groupz').change(function(){

// alert("hi");
// alert("dd");
 var attr_group_id = $(this).val();

 var _token= $('input[name="_token"]').val();
 //alert(_token);
 $.ajax({
   type:"GET",
   url:"{{ url('admin/ajax/get-attribute-value') }}?attribute_group_id="+attr_group_id,


   success:function(res){
     //alert(data);
     if(res){
     $('.attr_valuez').prop("diabled",false);
     $('.attr_valuez').empty();
     $('.attr_valuez').append('<option value="">Value</option>');
     $.each(res,function(attr_value_id,group_value)
     {
       $('.attr_valuez').append('<option value="'+attr_value_id+'">'+group_value+'</option>');
     });

     }else
     {
       $('.attr_valuez').empty();

     }
     }

 });

});

</script>

@endsection