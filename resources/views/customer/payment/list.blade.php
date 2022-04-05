@include('layouts.header')
<!------------>
<section class="cart-section checkout-section">
   <div class="container-fluid">
      <div class="cart-main-sec">
         <div class="cart-div1-sec">
            <div class="cart-top-loct">
               <div class="mycart">
                  <h6>Checkout</h6> </div>
               <div class="checkoutstp">
                  <ol class="checkout-steps">
                     <li class="step step1 "><span class="number-chk"><i class="fa fa-check" aria-hidden="true"></i></span>Address</li>
                     <li class="divider"></li>
                     <li class="step step2 "><span class="number-chk"><i class="fa fa-check" aria-hidden="true"></i></span>Order Summary</li>
                     <li class="divider"></li>
                     <li class="step step3 active"><span class="number-chk">3</span>Payment</li>
                  </ol>
               </div>
            </div>
            <!-------------------->
            <div class="checkout-frm-addresss">
               <div class="name-sec">
                  <h5>Username</h5> <span class="hm">{{$customer->customer_name}}</span> </div>
               <div class="address-sec"> <address>
                           <p>{{$customer->place}}</p>
                           <p>{{$customer->road}}</p>
                        </address> </div>
               <div class="add-phn"> <span>+91 {{$customer->customer_mobile}}</span> </div>
              
            </div>
            <form  action="{{url('/Payment_Store')}}" method="POST">
               @csrf
               <input type="hidden" name="customer_id" value="{{$customer->customer_id}}">
               <input type="hidden" name="p_id" value="{{$product->product_variant_id}}">
            <div class="form-check">
            <label for="usr" style="font-weight: bold;">Payment Type:</label>
            </br>
            @foreach($payment_type as $value)
           <input type="radio" id="Payment" name="Payment" value="{{$value->payment_type_id}}" required checked>{{$value->payment_type}}
           </br>
           @endforeach
            </div>
           </br>

            <div class="placeholbtn" style="width:100%">
            <button type="submit" class="PaymentOrderdetail">Continue</button>
            </div>
           </form>
           
            <!----------------->
         </div>
         <div class="order-summ-right">
            <div class="table-sec">
               <h4>PRICE DETAILS</h4>
               <table class="table tbl-sec">
                  <thead> </thead>
                  <tbody>
                     <tr>
                        <td>Price (@if(isset($count)){{$count}}@endif items)</td>
                        <td>&#8377;@if(isset($total_price)){{$total_price}}@endif</td>
                     </tr>
                     <tr>
                        <td>Discount</td>
                        <td>- &#8377; </td>
                     </tr>
                     <tr>
                        <td>Delivery Charges</td>
                        <td>FREE</td>
                     </tr>
                     <tr>
                        <td>Total Amount</td>
                        <td>&#8377;@if(isset($total_price)){{$total_price}}@endif</td>
                     </tr>
                  </tbody>
               </table>
            </div>
            
         </div>
      </div>
   </div>
</section>
<script src="{{URL::to('/assets/cart/js/cart.js')}} "></script>

<!-------end----->@include('layouts.footer') </body>

</html>