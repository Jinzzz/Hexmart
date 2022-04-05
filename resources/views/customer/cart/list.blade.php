@include('layouts.header')
<!------------>
<head>
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
   <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>

<section class="cart-section">
   <div class="container-fluid">
      <div class="cart-main-sec">
         <div class="cart-div1-sec">
            <div class="cart-top-loct">
               <div class="mycart">
                  <h6>My Cart(@if(isset($count)){{$count}}@endif)</h6> </div>
               <div class="deliverto">
                  <form> <img src="{{URL::to('/assets/frontAssets/image/location.svg')}}">
                     <label for="cars">Deliver to</label>
                     <select id="">
                        <option value="volvo">Kozhikode-6736006</option>
                        <option value="saab">Kozhikode-6736011</option>
                        <option value="vw">Kozhikode-673601</option>
                     </select>
                  </form>
               </div>
            </div>
            @php
            $total=0;
            @endphp
            @foreach($cart as $val)
            <div class="cartproduct-sec">
               <div class="productname-sec">
                  <h4>@if(isset($val->productVariantData->variant_name)){{$val->productVariantData->variant_name}}@endif</h4> 
                  <div class="cartprice-pdct"> <span>&#8377;@if(isset($val->productVariantData->variant_price_offer)){{$val->productVariantData->variant_price_offer}}@endif</span> </div>
               </div>
               <div class="productimage-sec"> <img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($val->productVariantData->product_id,$val->productVariantData->product_variant_id))}}" class="img-fluid"> </div>
            </div>
            <!---------quantity remove----------->
            <div class="qunty-remove-sec">
               <div class="qunty">
                  <form>
                     
                     <label>Quantity</label>
                     <div class="sss">
                        <input type="hidden" name="customer_id" value="{{$val->customer_id}}" id="customer_id">
                        <input type="hidden" name="product_variant_id" value="{{$val->productVariantData->product_variant_id}}" id="product_variant_id">
                        <input type="hidden" name="cart_id" value="{{$val->cart_id}}" id="cart_id">
                        <select id="quantity" class="form-group" name="quantity" onchange="mycartFunction(this.value,<?php echo $val->cart_id?>,<?php echo $val->product_variant_id?>)">
                           <option value="1" <?php if($val->quantity==1) { echo "selected";}?>>Qty: 1</option>
                           <option value="2" <?php if($val->quantity==2) { echo "selected";}?>>Qty: 2</option>
                           <option value="3" <?php if($val->quantity==3) { echo "selected";}?>>Qty: 3</option>
                           <option value="4" <?php if($val->quantity==4) { echo "selected";}?>>Qty: 4</option>
                           <option value="5" <?php if($val->quantity==5) { echo "selected";}?>>Qty: 5</option>
                           <option value="6" <?php if($val->quantity==6) { echo "selected";}?>>Qty: 6</option>
                           <option value="7" <?php if($val->quantity==7) { echo "selected";}?>>Qty: 7</option>
                           <option value="8" <?php if($val->quantity==8) { echo "selected";}?>>Qty: 8</option>
                           <option value="9" <?php if($val->quantity==9) { echo "selected";}?>>Qty: 9</option>
                           <option value="10" <?php if($val->quantity==10) { echo "selected";}?>>Qty: 10</option>
                        </select>
                     </div>
                    
                  </form>
               </div>

               
               
               <div class="remove">
                  <a href="{{url('/remove_pcart').'/'.$val->productVariantData->product_variant_id}}">
                  <button class="CartRemove" type="submit"  id="removecartdetails"><i class="fa fa-trash" aria-hidden="true"></i> <span>Remove</span></button></a>
               </div>
               <!-- </form> -->
            </div>
            @php
            $total +=$val->productVariantData->variant_price_offer * $val->quantity;
            @endphp
            @endforeach
            <!----------------->
         </div>
         <div class="cart-div2-sec">
            <div class="table-sec">
               <h4>PRICE DETAILS</h4>
               <table class="table tbl-sec">
                  <thead> </thead>

                  <tbody>
                     
                     <tr>
                        <td>Price (@if(isset($count)){{$count}}@endif items)</td>
                        <td>&#8377;@if(isset($total)){{$total}}@endif</td>
                     </tr>
                     <tr>
                        <td>Discount</td>
                        <td>- &#8377; 0</td>
                     </tr>
                     <tr>
                        <td>Delivery Charges</td>
                        <td>FREE</td>
                     </tr>
                     <tr>
                        <td>Total Amount</td>
                        <td>&#8377;@if(isset($total)){{$total}}@endif</td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="placeorder-sec">
               <div class="prizetot">
                  <p>&#8377;@if(isset($total)){{$total}}@endif</p> <span class="pricdtail"><a href="">View price details</a></span> </div>
               <div class="placeholbtn">
                  <button type="button" class="btn "><a href="">Place Order</a></button>
                  <!-- <button type="button" class="btn " data-toggle="modal" data-target="#exampleModal">Place Order</button> -->
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-------end----->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header hhcls">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
         </div>
         <div class="row">
            <div class="modal-body form-con">
               <form class="login-form">
                  <div class="col-lg-12">
                     <label>Enter Email/Mobile number</label>
                     <input type="text" placeholder="" name="uname" required> </div>
                  <div class="col-lg-12">
                     <label>Enter Password</label>
                     <input type="password" placeholder="" name="psw" required> <a class=" pwsd frgtpsw " tabindex="-1"><span>Forgot?</span></a> </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <button type="submit" class="login-popupbtn">Login</button>
                     </div>
                     <div class="col-lg-6">
                        <button type="submit" class="sign-up-btn">Don't have an account? Sign up</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="{{URL::to('/assets/cart/js/cart.js')}} "></script>

<script>
function mycartFunction(getquantity,cart_id,product_variant_id) {
let quantity = getquantity;
let customer_id = document.getElementById("customer_id").value;
$.ajax({
         method:"POST",
         url:base_url+"/update_cart_quantity",
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data:{
            'quantity':quantity,
            'customer_id':customer_id,
            'cart_id':cart_id,
            'product_variant_id':product_variant_id,
         },
         dataType:"json",
         success:function(response)
         {  
            // console.log(response.status)
            if(response.status=="Availabile only one Product")
            {
             swal(response.status);

            }
            else
            {
            window.location.reload();
            }
         }
 });
}
</script>
@include('layouts.footer') </body>

</html>