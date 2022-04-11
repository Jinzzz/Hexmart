@include('layouts.header')
<section class="myorder-sec bg-gray">
   <div class="container-fluid">
      <div class="myorder-container">
         <div class="myoreder-details">
            <button class="btn btn-light" type="button" style="width:7%;float:right;"><a href="{{url('/customer/Invoice').'/'.$order->order_item_id}}">Download</a></button>
            <div class="orderdetal-div1">
               <h4>Order no. @if(isset($order->order_number)){{$order->order_number}}@endif</h4>
               <h4>Order Total &#8377;@if(isset($order->total_amount)){{$order->total_amount}}@endif</h4>
               <div class="orderdetal-innerdiv1">
                  <div class="orderdetal-date">
                     <div class="icon-c"> <i class="fa fa-calendar-o" aria-hidden="true"></i> </div>
                     <div class="datediv-sec"> <span>Order Date</span>
                        <p>{{ date('j F  Y', strtotime($order->created_at)) }}</p>
                     </div>
                  </div>
                  <div class="orderdetal-deliver">
                     <div class="icon-c"> <img src="{{URL::to('/assets/frontAssets/image/delivery-box-size.png')}}" class="img-fluid dlvry-img" alt=""> </div>
                     <div class="datediv-sec"> <span>Delivery by</span>
                        <p>Sat, 10th Apr </p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="orderdetal-div2">
               <div class="order-content"> <span><a href="{{url('/Order-Cancel').'/'.$order->order_item_id}}">Cancel</a></span> <span><a href="">Need help?</a></span> </div>
            </div>
         </div>
         <div class="myoreder-details">
               <div class="order-content"> <span style="font-weight:bold">Order Status : 
                  <?php
                   if($order->orderData->order_status_id==1)
                   {
                     echo "Pending";
                   }
                   elseif($order->orderData->order_status_id==2)
                   {
                      echo "Cancelled";
                   }
                   elseif($order->orderData->order_status_id==3)
                   {
                      echo "Confirmed";
                   }
                   elseif($order->orderData->order_status_id==4)
                   {
                     echo "Picking Completed";
                   }
                   elseif($order->orderData->order_status_id==5)
                   {
                     echo "Ready for Delivery";
                   }
                   elseif($order->orderData->order_status_id==6)
                   {
                     echo "Out for Delivery";
                   }
                   elseif($order->orderData->order_status_id==7)
                   {
                     echo "Delivered";
                   }
                   elseif($order->orderData->order_status_id==8)
                   {
                     echo "Return confirmed";
                   }
                   elseif($order->orderData->order_status_id==9)
                   {
                     echo "Return Completed";
                   }
                   else
                   {
                     echo "Order Placed";
                   }
                  ?></span> </div>
         </div>
         <!--items-->
         <div class="items-container">
            <div class="itemmain-div">
               <div class="iteminner-divcontent">
                  <h4>@if(isset($order->productVariantData->variant_name)){{$order->productVariantData->variant_name}}@endif</h4> <span> &#8377; @if(isset($order->productVariantData->variant_price_offer)){{$order->productVariantData->variant_price_offer}}@endif</span> </div>
               <div class="iteminner-divimg"> <img src="{{URL::to((new \App\Helpers\Helper)->productVarBaseImage($order->product_id,$order->product_variant_id))}}" class="img-fluid product-image" alt=""> </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>