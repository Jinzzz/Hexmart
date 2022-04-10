@include('layouts.header')
<section class="order-confirmed-sec bg-gray">
   <div class="container-fluid">
      <div class="addadress-page">
         <div class="checkout-frm">
            <form method="POST" action="{{ url('/customer/Store-Address') }}">
                           
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
                                 <input type="text" placeholder="Full Name" name="name" required="" autocomplete="off" >
                              </div>
                              <div class="col-lg-6">
                                 <label>Phone Number</label>
                                 <input type="tel" pattern="[789][0-9]{9}" 
                                 title="Phone number with 7-9 and remaing 9 digit with 0-9" placeholder="Phone number" name="customer_mobile" required="" autocomplete="off" >
                                 <!-- <label>Alternate Phone Number</label>
                                 <input type="tel" pattern="[789][0-9]{9}" 
                                 title="Phone number with 7-9 and remaing 9 digit with 0-9" placeholder="Alternatuve Phone number" name="altcustomer_mobile"  autocomplete="off" > -->
                                 <!-- <a href="" class="addnumber"><span><i class="fa fa-plus" aria-hidden="true"></i> Add Alternate Phone Number</span></a> -->
                              </div >
                              <div class="col-lg-6 col-6">
                                 <label>Pin Code</label>
                                 <input type="text" placeholder="Pincode" name="pin" required="" autocomplete="off" value="">
                              </div>
                              <div class="col-lg-6 col-6">
                                 <button class="myloction"><i class="fa fa-compass" aria-hidden="true"></i> Use my location</button>
                              </div>
                              <div class="col-lg-6 col-6">
                                 <label>State</label>
                                 <input type="text" placeholder="State" name="state" required="" autocomplete="off" >
                              </div >
                              <div class="col-lg-6 col-6">
                                 <label>City</label>
                                 <input type="text" placeholder="City" name="city" id="City" required="" autocomplete="off" >
                              </div >
                              <div class="col-lg-6">
                                 <label>Address</label>
                                 <input type="text" placeholder="House No, Building Name" name="place" required="" autocomplete="off" >
                              </div >
                              <div class="col-lg-6">
                                 <label>Landmark</label>
                                 <input type="text" placeholder="Road name, Area, Colony" name="road" required="" autocomplete="off" >
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
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>