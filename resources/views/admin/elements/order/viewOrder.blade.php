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
                <a class="float-right btn btn-cyan" href="{{ route('admin.orders') }}"><i class="fa fa-arrow-left"></i> Back</a>
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
             <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                  
                    <small class="float-right">Date: {{date('d-M-Y',strtotime($order->created_at))}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <!--<div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>Admin, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                  </address>
                </div>-->
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  Customer Details
                  <address>
                    <strong>{{$order->customerData->customer_name}}</strong><br>
                  <br>
                    Phone: {{$order->customerData->phone}}<br>
                    Email: {{$order->customerData->customer_email}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                 <b>Status:{{@$order->orderStatusData->status}}</b><br>
                  <br>
                  <b>Order ID:</b>{{$order->order_number}}<br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                     <th>#</th>
                      <th>Qty</th>
                      <th>Product</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                    @endphp
                    @foreach($order->orderItems as $item)
                    <tr>
                      <td>{{$loop->index+1}}</td>
                      <td>{{$item->quantity}}</td>
                      <td>{{$item->productData->product_name}}<span class="badge badge-sm badge-pill bg-green">{{$item->productVariantData->variant_name}}</span></td>
                      <td><i class="fa fa-inr" aria-hidden="true"></i> {{$item->total_amount}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
               <div class="col-6">
                 <!-- <p class="lead">Payment Methods:</p>
                  <img src="../../dist/img/credit/visa.png" alt="Visa">
                  <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                  <img src="../../dist/img/credit/american-express.png" alt="American Express">
                  <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p>-->
                </div>
                <!-- /.col -->
                <div class="col-6">
                 

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th></th>
                        <th style="width:50%">Subtotal:</th>
                        <td><i class="fa fa-inr" aria-hidden="true"></i> {{$order->order_total_amount}}</td>
                      </tr>
                      <tr>
                       <th></th>
                        <th>Tax </th>
                        <td><i class="fa fa-inr" aria-hidden="true"></i> 0.00</td>
                      </tr>
                      <tr>
                       <th></th>
                        <th>Shipping:</th>
                        <td><i class="fa fa-inr" aria-hidden="true"></i> 0.00</td>
                      </tr>
                      <tr>
                      <th></th>
                        <th>Total:</th>
                        <td><i class="fa fa-inr" aria-hidden="true"></i> {{$order->order_total_amount}}</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
              <!--  <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                  <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                  </button>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                  </button>
                </div>-->
              </div>
            </div>
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

