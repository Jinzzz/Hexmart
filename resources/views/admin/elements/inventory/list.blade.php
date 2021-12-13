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
                   <div class="card-body border">
                      <form action="{{route('admin.inventory')}}" method="GET"  enctype="multipart/form-data">
                         @csrf

                         <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                   <label class="form-label" >Product Category * </label>
                                   <select name="product_cat_id" required id="category" class="form-control"  >
                                    <option value="">--Select--</option>
                                    @foreach($category as $key)
                                        <option {{old('product_cat_id',request()->input('product_cat_id')) == $key->item_category_id ? 'selected':''}} value="{{ @$key->item_category_id }}">{{ @$key->category_name }}</option>
                                        @endforeach
                                     </select>
                               </div>
                            </div>
                         </div>
                         
                         <div class="col-md-12">
                            <div class="form-group">
                               <center>
                               <button type="submit" class="btn btn-raised btn-primary">
                               <i class="fa fa-check-square-o"></i> Filter</button>
                               <button type="reset" class="btn btn-raised btn-success">Reset</button>
                               <a href="{{route('admin.inventory')}}"  class="btn btn-info">Cancel</a>
                               </center>
                            </div>
                         </div>
                   </form>
                </div>
         
               <div class="card-body">
                       
                <div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                    <thead>
                      <tr>
                        <th class="wd-15p">S.No</th>
                        <th class="wd-15p">Product<br>Name</th>
                        <th class="wd-15p">Product<br>Category</th>
                        <th class="wd-15p">Current<br>Stock</th>

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
                        <td>{{$product->product_name}} 
                            @if($product->product_name != $product->variant_name)
                                @if (isset($product->variant_name))
                                    -
                                @endif
                                {{$product->variant_name}}
                            @endif
                        </td>
                        <td>
                          {{ @$product->itemCategoryData->category_name }}
                        </td>
                        <td id="td{{$product->product_variant_id}}">
                          @if($product->stock_count == 0)
                            Empty
                            @else
                            {{$product->stock_count}}
                          @endif
                        </td>
                        <td>
                            <input style="display:inline-block; width:70%;" type="number" id="stock_id{{$product->product_variant_id}}" class="form-control"   placeholder="New Stock ">
                            <a onclick="updateStock({{$product->product_variant_id}})" class="btn btn-icon btn-green"><i style="color:#ffffff;" class="fa fa-check" ></i></a>
                            <a onclick="resetStock({{$product->product_variant_id}})" class="btn btn-icon btn-red"><i style="color:#ffffff;" class="fa fa-rotate-left"></i></a>
                            <span id="status_msg{{$product->product_variant_id}}"></span>
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

  <script>

  function resetStock(product_variant_id)
  {
    $('#stock_id'+product_variant_id).val('');
    var _token = $('input[name="_token"]').val();
    $.ajax({
        url:"{{ route('admin.stock_reset') }}",
        method:"POST",
        data:{product_variant_id:product_variant_id, _token:_token},
        success:function(result)
        {
          //alert(result);
          if(result == 0)
          { 
            $('#td'+product_variant_id).html('Empty');
          $("#stock_id"+product_variant_id).val('');
               var $el = $("#td"+product_variant_id),
                    x = 400,
                    originalColor = $el.css("background-color");

                $el.css("background", "#4871cc9c");
                setTimeout(function(){
                  $el.css("background-color", originalColor);
                }, x);
          }
        }
    });
  }



  function updateStock(product_variant_id)
  {
        var updated_stock = $('#stock_id'+product_variant_id).val();
        var _token = $('input[name="_token"]').val();
          var current_stock =    $('#td'+product_variant_id).text();

    $.ajax({
        url:"{{ route('admin.stock_update') }}",
        method:"POST",
        data:{updated_stock:updated_stock,product_variant_id:product_variant_id, _token:_token},
        success:function(result)
        {
            if(result != "error"){
               // $('#status_msg'+product_variant_id).html('<label class="text-success">Stock Updated</label>');
                $("#status_msg"+product_variant_id).show().delay(1000).fadeOut();
                $("#stock_id"+product_variant_id).val('');

                if(result == 0){
                  $('#td'+product_variant_id).html('Empty');
                }else{
                  $('#td'+product_variant_id).html(result);
                }


              if(result > current_stock)
              {
                var $el = $("#td"+product_variant_id),
                    x = 400,
                    originalColor = $el.css("background-color");

               // $el.css("background", "#49e3428a");
                $el.css("background", "#4871cc9c");
                setTimeout(function(){
                  $el.css("background-color", originalColor);
                }, x);
              }
              else
              {
                var $el = $("#td"+product_variant_id),
                    x = 400,
                    originalColor = $el.css("background-color");

               // $el.css("background", "#d3202094");
                $el.css("background", "#4871cc9c");
                setTimeout(function(){
                  $el.css("background-color", originalColor);
                }, x);
              }

            }
            else
            {
                $("#stock_id"+product_variant_id).val('');
               var $el = $("#td"+product_variant_id),
                    x = 400,
                    originalColor = $el.css("background-color");

                $el.css("background", "#4871cc9c");
                setTimeout(function(){
                  $el.css("background-color", originalColor);
                }, x);
            }
        }
    });
}
  </script>

  @endsection
