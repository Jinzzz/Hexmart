@extends('admin.layouts.app')
@section('content')
<div class="row" id="user-profile">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            <div class="wideget-user">
          <h4>{{$pageTitle}}</h4>
                     <div class="row">
                  <div class="col-lg-6 col-md-12">
                     <div class="wideget-user-desc d-sm-flex">
                        <div class="wideget-user-img">
                           <input type="hidden" class="form-control" name="product_id" value="{{$product->product_id}}" >


                        </div>

                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="border-top">
            <div class="wideget-user-tab">
               <div class="tab-menu-heading">
                  <div class="tabs-menu1">
                     <ul class="nav">
                        <li class=""><a href="#tab-51" class="active show"
                           data-toggle="tab">Profile</a></li>
                        <li><a href="#tab-61" data-toggle="tab" class="">Images</a></li>
                        <li><a href="#tab-71" data-toggle="tab" class="">Product Variants</a></li>

                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <input type="hidden" name="product_id" value="{{$product->product_id}}">
      <div class="card">
         <div class="card-body">
            <div class="border-0">
               <div class="tab-content">
                  <div class="tab-pane active show" id="tab-51">
                     <div id="profile-log-switch">
                        <div class="media-heading">
                           <h5><strong>Product Information</strong></h5>
                        </div>
                        <div class="table-responsive ">
                           <table class="table row table-borderless">
                              <tbody class="col-lg-12 col-xl-6 p-0">
                                 <tr>
                                    <td><strong>Product Name:</strong> {{ $product->product_name}}</td>
                                 </tr>
                                 <tr>
                                    <td><strong>Product Code:</strong> {{ $product->product_code}}</td>
                                 </tr>
                                  <tr>
                                    <td><strong> Category:</strong> {{@$product->itemCategoryData->category_name}}</td>
                                 </tr>
                                 <tr>
                                    <td><strong> Type:</strong> 
                                       
                                       @if(@$product->product_type == 1)
                                       Product
                                       @else
                                       Service
                                       @endif

                                    </td>
                                 </tr>
                                 <tr>
                                    <td><strong>Product Brand:</strong> {{ @$product->brandData->brand_name}}</td>
                                 </tr>

                                <tr>
                                    <td><strong>Regular Price:</strong> {{ $product->product_price_regular}}</td>
                                 </tr>
                               <tr>
                                    <td><strong>Sale Price:</strong> {{ $product->product_price_offer}}</td>
                                </tr>

                                 <tr>
                                    <td><strong>Tax:</strong> {{ @$product->taxData->tax_name}}  {{ @$product->taxData->tax_value}} </td>
                                </tr>

                              </tbody>
                              <tbody class="col-lg-12 col-xl-6 p-0">

                                 <tr>
                                     <td><strong>Description:</strong> </td><td> {!! @$product->product_description!!}</td>
                                 </tr>
                          
                                 <tr>
                                    <td>
                                        <strong>Image:</strong>  <img data-toggle="modal" data-target="#viewModal{{$product->product_id}}"  
                                        src="{{asset( (new \App\Helpers\Helper)->productBaseImage($product->product_id))}}"  
                                        width="50" >
                                    </td>
                                 </tr>

                                 @php
                                 $stock_count_sum = (new \App\Helpers\Helper)->stockAvailable($product->product_id);
                                @endphp
                                <tr>
                                     <td><strong>Stock Count:</strong> {{ @$stock_count_sum}}</td>
                                </tr>
                              </tbody>
                           </table>


                           <center>
                       <a class="btn btn-cyan" href="{{route('admin.products') }}">Cancel</a>
                           </center>
                        </div>
                     </div>
                 </div>
                  <div class="tab-pane" id="tab-61">

                     <div id="profile-log-switch">
                        <div class="media-heading">
                           <h5><strong>Product Images</strong></h5>
                        </div><br>
                        <div class="table-responsive ">
                           <table  id="example5" class="table table-striped table-bordered">
                              <thead>
                                 <tr>
                                   <th class="wd-15p">SL.No</th>
                                    <th class="wd-15p">{{ __('Image') }}</th>
                                    <th class="wd-15p">{{ __('Product Variant') }}</th>
                                   <th class="wd-15p">{{ __('Base Image') }}</th>

                                 </tr>
                              </thead>
                               <tbody class="col-lg-12 col-xl-6 p-0">
                                 @php
                                 $i = 0;
                                 @endphp
                                @if(!$product_images->isEmpty())
                                 @foreach ($product_images as $product_image)
                                 @php
                                 $i++;
                                 @endphp
                                 <tr>
                                    <td>{{$i}}</td>
                                    @if($product_image->item_image_name)
                                    <td><img data-toggle="modal" data-target="#viewModal{{$product_image->product_image_id}}" src="{{asset('/assets/uploads/products/'.@$product_image->item_image_name)}}"  width="50" ></td>
                                    <td>{{@$product_image->productVariant->variant_name}}</td>
                                     <td><input type="checkbox"  @if (@$product_image->is_default == 1) checked @endif disabled "></td>
                                    @endif
                                 </tr>
                                 @endforeach
                                 @else
                                 <tr>
                                <td colspan="3"><center> No data available in the table</center></td>
                                  </tr>
                                  @endif
                              </tbody>
                           </table>
                           <center>
                           <a class="btn btn-cyan" href="{{ route('admin.products') }}">Cancel</a>
                           </center>
                        </div>
                     </div>
                  </div>


                  <div class="tab-pane" id="tab-71">

                     <div id="profile-log-switch">
                        <div class="media-heading">
                           <h5><strong>Product Variants</strong></h5>
                        </div><br>
                        <div class="table-responsive ">
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
                              @if(!$product_varients->isEmpty())
                                 @foreach ($product_varients as $value)
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
                                          <a  data-toggle="modal" data-target="#AttrModal{{$value->product_variant_id}}" class="text-white btn btn-sm btn-indigo">Attributes</a>
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
                           <center>
                           <a class="btn btn-cyan" href="{{ route('admin.products') }}">Cancel</a>
                           </center>
                        </div>
                     </div>
                  </div>


                  </div>

             </div>

</div>
</div>
</div>
</div>











@foreach($product_varients as $value)
<div class="modal fade" id="AttrModal{{$value->product_variant_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="example-Modal3">Variant Attributes</h5>
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
               
    
      </div>
   </div>
</div>
@endforeach 

@endsection
