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
                <a class="float-right btn btn-cyan" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i> Back</a>
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
             
                    <form action="{{ route('admin.update_product_variant',$product_variant->product_variant_id) }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                                
                                <div class="form-body">
                                    <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Variant Name *</label>
                                    <input type="text" class="form-control" name="variant_name" value="{{old('variant_name',$product_variant->variant_name)}}" placeholder="Variant Name" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Regular Price* </label>
                                    <input step="0.01" type="number" class="form-control proVariant "   oninput="regularPriceChangeVar(0)"  
                                    name="product_varient_price"   id="var_regular_price0" value="{{ $product_variant->variant_price_regular }}" placeholder="Regular Price">
                                </div>
                            </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="form-label">Sale Price* </label>
                                      <input step="0.01" type="number" class="form-control proVariant"  oninput="salePriceChangeVar(0)"
                                      name="product_varient_offer_price"  id="var_sale_price0" value="{{ $product_variant->variant_price_offer }}" placeholder="Sale Price">
                                      <span style="color:red" id="sale_priceMsg0"> </span>
                                  </div>
                              </div>
                           
                                
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Images</label>
                                    <input type="file" multiple class="form-control" name="product_image[]" >
                                </div>
                            </div>
                                

                                <div class="col-md-12">
                                <div  class="form-group">
                                        <center>
                                    <button type="submit" id="submit" class="btn btn-raised btn-primary">
                                            <i class="fa fa-check-square-o"></i> Update</button>
                                            <button type="reset" class="btn btn-raised btn-success">
                                            Reset</button>
                                            <a class="btn btn-danger" href="{{ url()->previous() }}">Cancel</a>
                                        </center>
                                </div>  
                                    
                                </div>
                            </div>
                            
                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <script>
       
       

function regularPriceChangeVar(p){
    salePriceChangeVar(p);
}

function salePriceChangeVar(p)
{
    let salePrice = $('#var_sale_price'+p).val();
    let regularPrice = $('#var_regular_price'+p).val();
    
    if(parseFloat(salePrice) < 0)
    {
            $('#var_sale_price'+p).val(0);
    }
    
    if(parseFloat(regularPrice) < 0)
    {
            $('#var_regular_price'+p).val(0);
    }
    
    
    if(salePrice !== "")
    {
        if(regularPrice !== "")
        {
            if( parseFloat(salePrice) <= parseFloat(regularPrice))
            {
                $('#sale_priceMsg'+p).html('');
                $("#submit").attr("disabled", false);

            }
            else
            {
                $('#sale_priceMsg'+p).html('Sale price should be less than or equal to regular price');
                $("#submit").attr("disabled", true);
            }
        }
        else
        {
             $('#sale_priceMsg'+p).html('Regular price is empty');
             $("#submit").attr("disabled", true);

        }
    }
    else
    {
        $('#sale_priceMsg'+p).html('');
        $("#submit").attr("disabled", false);

    }
}
       
       </script> 
@endsection

