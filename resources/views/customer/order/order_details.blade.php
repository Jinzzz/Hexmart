@include('layouts.header')
<section class="myorder-sec bg-gray">
   <div class="container-fluid">
      <div class="myorder-container">
         <div class="myoreder-details">
            <div class="orderdetal-div1">
               <h4>Order no. @if(isset($order->order_number)){{$order->order_number}}@endif</h4>
               <h4>Order Total &#8377;@if(isset($order->total_amount)){{$order->total_amount}}@endif</h4>
               <div class="orderdetal-innerdiv1">
                  <div class="orderdetal-date">
                     <div class="icon-c"> <i class="fa fa-calendar-o" aria-hidden="true"></i> </div>
                     <div class="datediv-sec"> <span>Order Date</span>
                        <p>5th Apr 2021</p>
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
               <div class="order-content"> <span><a href="">Cancel</a></span> <span><a href="">Need help?</a></span> </div>
            </div>
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