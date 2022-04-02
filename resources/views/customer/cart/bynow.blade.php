@include('layouts.header')
         <section class="cart-section checkout-section">
            <div class="container-fluid">
               <div class="cart-main-sec">
                  <div class="cart-div1-sec">
                     <div class="cart-top-loct">
                        <div class="mycart">
                           <h6>Checkout</h6>
                        </div>
                        <div class="checkoutstp">
                           <ol class="checkout-steps">
                              <li class="step step1 active"><span class="number-chk">1</span>Address</li>
                              <li class="divider"></li>
                              <li class="step step2"><span class="number-chk">2</span>Order Summary</li>
                              <li class="divider"></li>
                              <li class="step step3"><span class="number-chk">3</span>Payment</li>
                           </ol>
                        </div>
                     </div>
                     <!-------------------->
                     <div class="checkout-frm">
                        <form method="POST" action="{{ url('/Customer-checkout') }}">
                           <input type="hidden" name="id" value="{{$checkout_user->customer_id}}">
                           @csrf
                        @if(session('status'))
                        <div class="alert alert-success" id="err_msg">
                           <p>{{session('status')}}</p>
                        </div>
                        @endif
                        @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                        <p class="alert alert-danger">{{ $error }}</p>
                        @endforeach
                        @endif
                        @if (session()->has('message'))
                        <p class="alert alert-success">{{ session('message') }}</p>
                        @endif
                           <div class="row">
                              <div class="col-lg-6">
                                 <label>Name</label>
                                 <input type="text" placeholder="Full Name" name="name" required="" autocomplete="off" value="{{$checkout_user->customer_name}}">
                              </div>
                              <div class="col-lg-6">
                                 <label>Phone Number</label>
                                 <input type="tel" pattern="[789][0-9]{9}" 
                                 title="Phone number with 7-9 and remaing 9 digit with 0-9" placeholder="Phone number" name="customer_mobile" required="" autocomplete="off" value="{{$checkout_user->customer_mobile}}">
                                 <label>Alternate Phone Number</label>
                                 <input type="tel" pattern="[789][0-9]{9}" 
                                 title="Phone number with 7-9 and remaing 9 digit with 0-9" placeholder="Alternatuve Phone number" name="altcustomer_mobile"  autocomplete="off" value="@if(isset($checkout_user->altcustomer_mobile)){{$checkout_user->altcustomer_mobile}}@endif">
                                 <!-- <a href="" class="addnumber"><span><i class="fa fa-plus" aria-hidden="true"></i> Add Alternate Phone Number</span></a> -->
                              </div >
                              <div class="col-lg-6 col-6">
                                 <label>Pin Code</label>
                                 <input type="text" placeholder="Pincode" name="pin" required="" autocomplete="off" value="{{$checkout_user->pin}}">
                              </div>
                              <div class="col-lg-6 col-6">
                                 <button class="myloction"><i class="fa fa-compass" aria-hidden="true"></i> Use my location</button>
                              </div>
                              <div class="col-lg-6 col-6">
                                 <label>State</label>
                                 <input type="text" placeholder="State" name="state" required="" autocomplete="off" value="{{$checkout_user->state}}">
                              </div >
                              <div class="col-lg-6 col-6">
                                 <label>City</label>
                                 <input type="text" placeholder="City" name="city" required="" autocomplete="off" value="{{$checkout_user->city}}">
                                 <button type="submit" class="Search-btnfrm"><i class="fa fa-search"></i></button>
                              </div >
                              <div class="col-lg-6">
                                 <label>Address</label>
                                 <input type="text" placeholder="House No, Building Name" name="place" required="" autocomplete="off" value="{{$checkout_user->place}}">
                              </div >
                              <div class="col-lg-6">
                                 <label>Landmark</label>
                                 <input type="text" placeholder="Road name, Area, Colony" name="road" required="" autocomplete="off" value="{{$checkout_user->road}}">
                                 <button type="submit" class="Search-btnfrm"><i class="fa fa-search"></i></button>
                                 <a href="" class="addnear"><span><i class="fa fa-plus" aria-hidden="true"></i> Add Nearby Famous Shop/Landmark</span></a>
                              </div >

                              <div class="col-lg-6">
                                 <p class="tadd">Types of address</p>
                                 <div class="row">
                                    <div class="col-lg-4 col-6 disc-radio">
                                       <input type="radio" id="" name="Home" value="">
                                       <label for="Home"><i class="fa fa-home" aria-hidden="true"></i> Home</label>
                                    </div>
                                    <div class="col-lg-4  col-6 disc-radio rty">
                                       <input type="radio" id="" name="Work" value="">
                                       <label for="Work"><i class="fa fa-building" aria-hidden="true"></i> Work</label>
                                       <br>
                                    </div>
                                 </div>
                              </div>
                      


                           </div>
                           <div class="text-center">
                              <button class="savebtn" type="submit">Save Address</button>
                           </div>
                        </form>
                     </div>
                     <!----------------->
                  </div>
                  <div class="cart-div2-sec">
                     <div class="table-sec">
                        <h4>PRICE DETAILS</h4>
                        <table class="table tbl-sec">
                           <thead>
                           </thead>
                           <tbody>
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
                           <p>&#8377;@if(isset($total_price)){{$total_price}}@endif</p>
                           <span class="pricdtail"><a href="">View price details</a></span>
                        </div>
                        <div class="placeholbtn">
                           <button>Place Order</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-------end----->
        @include('layouts.footer')

   </body>
</html>