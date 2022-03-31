@include('layouts.header')
<!------------>
<section class="order-confirmed-sec">
   <div class="container-fluid">
      <div class="ordrconfrm-container">
         <div class="ordrconfrm">
            <div class="sign-up">
               <div class="signup-div text-center"> <img src="{{URL::to('/assets/frontAssets/image/sign-up.png')}}" class="img-fluid sign-up" alt=""> </div>
               <div class="signup-div-frm">
                  <form>
                     <div class="row">
                        <div class="col-lg-12">
                           <input type="text" placeholder="Full Name (Required)*" name="uname" required=""> </div>
                        <div class="col-lg-12">
                           <input type="tel" placeholder="Phone number (Required)*" name="phonenumber" required=""> </div>
                        <div class="col-lg-6 col-12">
                           <input type="text" placeholder="Pincode (Required)*" name="uname" required=""> </div>
                        <div class="col-lg-6 col-12">
                           <button class="myloction"><i class="fa fa-compass" aria-hidden="true"></i> Use my location</button>
                        </div>
                        <div class="col-lg-6 col-12">
                           <input type="text" placeholder="State (Required)*" name="uname" required=""> </div>
                        <div class="col-lg-6 col-12">
                           <input type="text" placeholder="City (Required)*" name="uname" required="">
                           <button type="submit" class="Search-btnfrm"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col-lg-12">
                           <input type="text" placeholder="House No, Building Name (Required)*" name="uname" required=""> </div>
                        <div class="col-lg-12">
                           <input type="text" placeholder="Road name, Area, Colony (Required)*" name="uname" required="">
                           <button type="submit" class="Search-btnfrm"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col-lg-6">
                           <p class="tadd">Types of address</p>
                           <div class="row">
                              <div class="col-lg-6 col-6 disc-radio">
                                 <input type="radio" id="" name="Home" value="">
                                 <label for="Home"><i class="fa fa-home" aria-hidden="true"></i> Home</label>
                              </div>
                              <div class="col-lg-6  col-6 disc-radio rty">
                                 <input type="radio" id="" name="Work" value="">
                                 <label for="Work"><i class="fa fa-building" aria-hidden="true"></i> Work</label>
                                 <br> </div>
                           </div>
                        </div>
                        <div class="col-lg-12 text-center">
                           <div class="btn-signup-div-frm">
                              <button>Save Address</button>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>