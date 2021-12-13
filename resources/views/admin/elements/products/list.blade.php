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
                    @if ($message = Session::get('err_status'))
                    <div class="alert alert-danger">
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
                        <a href="{{route('admin.create_product')}}" class="m-2 btn btn-block btn-info">
                            <i class="fa fa-plus"></i> Create Product
                        </a> 

                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="wd-15p">SL.No</th>
                                        <th class="wd-15p">{{ __('Product') }}</th>
                                        <th class="wd-15p">{{ __('Code') }}</th>
                                        <th class="wd-15p">{{ __('Price') }}</th>
                                        <th class="wd-15p">{{__('Image')}}</th>
                                        <th class="wd-15p">{{__('Stock')}}</th>
                                        <th class="wd-15p">{{__('Status')}}</th>
                                        <th class="wd-15p">{{__('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 0;
                                    @endphp
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{$product->product_name}}</td>
                                        <td>{{$product->product_code}}</td> 
                                        <td>{{$product->product_price_offer}}</td>
                                        <td>
                                            <img data-toggle="modal" data-target="#viewModal{{$product->product_id}}"  
                                            src="{{asset( (new \App\Helpers\Helper)->productBaseImage($product->product_id))}}"  
                                            width="50" >&nbsp;
                                        </td>
                                        <td>
                                      
                                        @php
                                            $stock_count_sum = (new \App\Helpers\Helper)->stockAvailable($product->product_id);
                                        @endphp
                                            <button type="button"  class="btn btn-sm @if(@$stock_count_sum <= 0) btn-danger @else btn-success @endif"> 
                                                @if($stock_count_sum <= 0)
                                                Outstock ( {{ $stock_count_sum }} )
                                                @else
                                                Instock ( {{ $stock_count_sum }} )
                                                @endif 
                                            </button>
                                        </form>
                                        </td>

                                        <td>
                                            <a style="color:white;" id="statusBtn{{$product->product_id}}" 
                                                onclick="changeStatus({{$product->product_id}})"  
                                                class="btn btn-sm @if($product->is_active == 0) btn-danger @else btn-success @endif"
                                            > 
                                                @if($product->is_active == 0)
                                                    Inactive
                                                @else
                                                    Active
                                                @endif
                                            </a>
                                        </td>
                                        
                                        <td>
                                            <form action="{{route('admin.destroy_product',$product->product_id)}}" method="POST">
                                                @csrf
                                                @method('POST')
                                            <a class="btn btn-sm btn-cyan" href="{{url('admin/product/edit/'.$product->product_id)}}">Edit</a> 
                                            <a class="btn btn-sm btn-cyan" href="{{url('admin/product/view/'.$product->product_id)}}">View</a> 
                                            <button type="submit" onclick="return confirm('Do you want to delete this item?');"  class="btn btn-sm btn-danger">Delete</button>
                                            <br> 
                                            <a class="mt-2 btn btn-sm btn-orange" href="{{url('admin/product-variant/list/'.$product->product_id)}}">Product Variant</a> 
                                            </form> 
                                        </td> 
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

  @foreach($products as $product)
  <div class="modal fade" id="viewModal{{$product->product_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
     <div class="modal-dialog" role="document">
        <div class="modal-content">
           <div class="modal-header">
              <h5 class="modal-title" id="example-Modal3">{{$pageTitle}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
           </div>
           <div class="modal-body">
            <img  src="{{asset('assets/uploads/products/'.$product->product_base_image)}}"  width="600" >
           </div>
           <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
           </div>
        </div>
     </div>
  </div>
@endforeach

</div>

   <script>
       function changeStatus(item_category_id)
{
   // $('#loaderCard').show();
  //  $('#example_tbody').hide();
  var stat = 0;
    var _token= $('input[name="_token"]').val();
    $.ajax({
        type:"GET",
        url:"{{ url('admin/ajax/change-status/product') }}?product_id="+item_category_id ,
        success:function(res){
            console.log(res);
            if(res == "active"){
                stat = 0;
                $("#statusBtn"+item_category_id).removeClass("btn-danger");
                $("#statusBtn"+item_category_id).addClass("btn-success");
                $( "#statusBtn"+item_category_id ).empty();
                $( "#statusBtn"+item_category_id ).text('Active');
            }
            else
            {
                stat = 1;
                $("#statusBtn"+item_category_id).removeClass("btn-success");
                $("#statusBtn"+item_category_id).addClass("btn-danger");
                $( "#statusBtn"+item_category_id ).empty();
                $( "#statusBtn"+item_category_id ).text('Inactive');
            }
        },
        complete: function(){
            $('#loaderCard').hide();
            $('#example_tbody').show();
            console.log(stat);
            if(stat == 0)
            {
                return $.growl.notice({
                message: "Status updated"
                });
            }
            else
            {
                return $.growl.warning({
                title: "Notice!",
                message: "Status updated"
                });
            }
        },
        fail: function(){

            return $.growl.error({
                title: "Oops!",
                message: "Something wen't wrong"
            }); 

            $('#loaderCard').hide();
            $('#example_tbody').show();
            $('#example_tbody').html('<tr>No data found.</tr>');
        },
    });
}
       
       </script>  
  @endsection
 