@include('layouts.header')
<!------------>
<section class="cart-section">
   <div class="container-fluid">
      <div class="cart-main-sec">
         <div class="cart-div1-sec">
            <div class="cart-top-loct">
               <div class="mycart">
                  <h6>My Cart(2)</h6> </div>
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
            <div class="cartproduct-sec">
               <div class="productname-sec">
                  <h4>HP 15 Ryzen 3 Dual Core 3200U - (4 GB/1 TB
                              HDD/Windows 10 Home) 15-db1069 AU Laptop
                           </h4> <span class="color-prdct">Black</span>
                  <div class="cartprice-pdct"> <span>&#8377; 8,002</span> </div>
               </div>
               <div class="productimage-sec"> <img src="{{URL::to('/assets/frontAssets/image/lap1.png')}}" class="img-fluid" alt=""> </div>
            </div>
            <!---------quantity remove----------->
            <div class="qunty-remove-sec">
               <div class="qunty">
                  <form>
                     <div class="sss">
                        <select id="" class="form-group">
                           <option value="">Qty: 1</option>
                           <option value="">Qty: 1</option>
                           <option value="">Qty: 1</option>
                        </select>
                     </div>
                  </form>
               </div>
               <div class="remove">
                  <button><i class="fa fa-trash" aria-hidden="true"></i> <span>Remove</span></button>
               </div>
            </div>
            
            <!----------------->
         </div>
         <div class="cart-div2-sec">
            <div class="table-sec">
               <h4>PRICE DETAILS</h4>
               <table class="table tbl-sec">
                  <thead> </thead>
                  <tbody>
                     <tr>
                        <td>Price (2 items)</td>
                        <td>&#8377;40,771</td>
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
                        <td>&#8377;40,771</td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="placeorder-sec">
               <div class="prizetot">
                  <p>&#8377;40,771</p> <span class="pricdtail"><a href="">View price details</a></span> </div>
               <div class="placeholbtn">
                  <button type="button" class="btn " data-toggle="modal" data-target="#exampleModal">Place Order</button>
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
</div> @include('layouts.footer') </body>

</html>