@include('layouts.header')
<!------------>
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
                     <input type="hidden" name="product_id" value="{{$val->productVariantData->product_variant_id}}" id="product_id">
                     <input type="hidden" name="product_id" value="{{$val->productVariantData->product_id}}" id="product_id">
                     <input type="hidden" name="product_id" value="{{$val->productVariantData->variant_price_offer}}" id="product_id">
                     <!-- <div class="sss">
                        <select id="quantity" class="form-group quantity" name="quantity">
                           <option value="1">Qty: 1</option>
                           <option value="2">Qty: 2</option>
                           <option value="3">Qty: 3</option>
                           <option value="4">Qty: 4</option>
                           <option value="5">Qty: 5</option>
                           <option value="6">Qty: 6</option>
                           <option value="7">Qty: 7</option>
                           <option value="8">Qty: 8</option>
                           <option value="9">Qty: 9</option>
                           <option value="10">Qty: 10</option>
                        </select>
                     </div> -->
                     <label>Quantity</label>
                     <div class="container">

                     <input type="button" onclick="decrementValue()" value="-" />
                     <input type="text" name="quantity" value="1" maxlength="2" max="10" size="1" id="number" />
                     <input type="button" onclick="incrementValue()" value="+" />
                     </div>
                  </form>
               </div>

               
               
               <div class="remove">
                  <input type="hidden" name="product_id" value="{{$val->productVariantData->product_variant_id}}" id="product_id">
                  <a href="{{url('/remove_pcart').'/'.$val->productVariantData->product_variant_id}}">
                  <button class="CartRemove" type="submit"  id="removecartdetails"><i class="fa fa-trash" aria-hidden="true"></i> <span>Remove</span></button></a>
               </div>
               <!-- </form> -->
            </div>
            @endforeach
            <!----------------->
         </div>
         <div class="cart-div2-sec">
            <div class="table-sec">
               <h4>PRICE DETAILS</h4>
               <table class="table tbl-sec">
                  <thead> </thead>

                  <tbody>
                     @foreach($cart as $val)
                     @endforeach
                     <tr>
                        <td>Price (@if(isset($count)){{$count}}@endif items)</td>
                        <td>&#8377;@if(isset($total_price)){{$total_price}}@endif</td>
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
                        <td>&#8377;@if(isset($total_price)){{$total_price}}@endif</td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="placeorder-sec">
               <div class="prizetot">
                  <p>&#8377;@if(isset($total_price)){{$total_price}}@endif</p> <span class="pricdtail"><a href="">View price details</a></span> </div>
               <div class="placeholbtn">
                  <button type="button" class="btn " data-toggle="modal" data-target="#exampleModal">Place Order</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-------end----->
<script>
$(document).ready(function(){
  $(".CartRemove").click(function(){
    alert("The paragraph was clicked.");
  });
});
    </script>


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

<script type="text/javascript">
function incrementValue()
{
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    if(value<10){
        value++;
            document.getElementById('number').value = value;
    }
}
function decrementValue()
{
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    if(value>1){
        value--;
            document.getElementById('number').value = value;
    }

}
</script>
@include('layouts.footer') </body>

</html>