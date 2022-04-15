@include('layouts.header')
<!------------>
<head>
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
   <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>
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
                  <button><a href="{{url('/customer/checkoutAdd-Address-Details')}}">Change or Add Address</a></button>
               </div>
            </div>
          </br>
            <div class="container">
               <div class="addcart-sec">
                  <button class="buybtn Buynow" style="width:100%"><a href="{{ url('/CartPayment') }}">Proceed To Pay</a></button>
               </div>
            </div>
            <!----------------->
         </div>
         <div class="order-summ-right">
            <div class="discount-sec">
               <h5>Discount Code</h5>
               <div class="input-group">
                  <input type="text" name="coupon_code" id="coupon_code" placeholder="Enter Coupon codes" class="form-control coupon_code" autocomplete="off">
                  <div class="input-group-append">
                  <button class="btn btn-primary apply_coupon_btn" type="button" id="apply_coupon_btn" onclick="myCartCouponFunction(<?php echo $total_price;?>)">Apply</button>
               </div>
               </div>
               <small id="error_coupon" class="text-danger"></small>
            </div>
            <div class="table-sec">
               <h4>PRICE DETAILS</h4>
               <table class="table tbl-sec">
                  <thead> </thead>
                  <tbody>
                     <tr>
                        <td>Price (@if(isset($count)){{$count}}@endif items)</td>
                        <td>&#8377;<span class="total_price">@if(isset($total_price)){{$total_price}}@endif</span></td>
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
                        <td>&#8377;<span class="total_price">@if(isset($total_price)){{$total_price}}@endif</span></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="placeorder-sec ckout">
               <div class="prizetot">
                  <p>&#8377;<span class="total_price">@if(isset($total_price)){{$total_price}}@endif</span></p> <span class="pricdtail"><a href="">View price details</a></span> </div>
               <div class="placeholbtn">
                  <button>CHECKOUT</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script type="text/javascript">
      function myCartCouponFunction(price) {
      var coupon_code=$('.coupon_code').val();
      if($.trim(coupon_code).length==0)
      {
       error_coupon="Please Enter A Valid Coupon";
       $('#error_coupon').text(error_coupon);
      }
      else
      {
       error_coupon="";
       $('#error_coupon').text(error_coupon);
      }

      if(error_coupon!='')
      {
      return false;
      }

    $.ajax({
         method:"POST",
         url:base_url+"/customer/cartapply_couponcart",
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data:{
                'coupon_code':coupon_code,
                'price':price,
         },
         dataType:"json",
         success:function(response)
         {
            if(response.error_status=='error')
            {
             swal(response.status);
             console.log(response);
             $('.coupon_code').val('');
            }
            else
            {
               var discount_price=response.discount_price;
               var total_price=response.total_price;
               $('.coupon_code').prop('readOnly',true);
               $('.discount_price').text(discount_price);
               $('.total_price').text(total_price);

            }
             

         }
   });
  
}

</script>

<!-------end----->@include('layouts.footer') </body>

</html>