@include('layouts.header')
<!------------>
<section class="cart-section checkout-section">
   <div class="container-fluid">
      <div class="cart-main-sec">
         <div class="cart-div1-sec">
            <div class="cart-top-loct">
               <div class="mycart">
                  <h6>Checkout</h6> </div>
               <div class="checkoutstp ord-sum">
                  <ol class="checkout-steps">
                     <li class="step step1 "><span class="number-chk"><i class="fa fa-check" aria-hidden="true"></i></span>Address</li>
                     <li class="divider"></li>
                     <li class="step step2 active"><span class="number-chk">2</span>Order Summary</li>
                     <li class="divider"></li>
                     <li class="step step3"><span class="number-chk">3</span>Payment</li>
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
               <div class="chng-or-add-addrs ">
                  <button>Change or Add Address</button>
               </div>
            </div>
          </br>
            <div class="container">
               <input type="hidden" name="p_id" value="{{$product->product_variant_id}}">
               <div class="addcart-sec">
                  <button class="buybtn Buynow" style="width:100%"><a href="{{ url('/Payment/'.$product->product_variant_id) }}">Proceed To Pay</a></button>
               </div>
            </div>
            <!----------------->
         </div>
         <div class="order-summ-right">
            <div class="discount-sec">
               <h5>Discount Code</h5>
               <form>
                  <input type="text" name="" placeholder="Enter Coupon codes">
                  <button class="aply-code">Apply</button>
               </form>
            </div>
            <div class="table-sec">
               <h4>PRICE DETAILS</h4>
               <table class="table tbl-sec">
                  <thead> </thead>
                  <tbody>
                     <tr>
                        <td>Price (@if(isset($count)){{$count}}@endif items)</td>
                        <td>&#8377;@if(isset($product->variant_price_offer)){{$product->variant_price_offer}}@endif</td>
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
                        <td>&#8377;@if(isset($product->variant_price_offer)){{$product->variant_price_offer}}@endif</td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="placeorder-sec ckout">
               <div class="prizetot">
                  <p>&#8377;@if(isset($product->variant_price_offer)){{$product->variant_price_offer}}@endif</p> <span class="pricdtail"><a href="">View price details</a></span> </div>
               <div class="placeholbtn">
                  <button>CHECKOUT</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>