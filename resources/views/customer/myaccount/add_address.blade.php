@include('layouts.header')
<section class="order-confirmed-sec bg-gray">
   <div class="container-fluid">
      <div class="addadress-page">
         <div class="checkout-frm">
            <form>
               <div class="row">
                  <div class="col-lg-6">
                     <input type="text" placeholder="Full Name" name="uname" required=""> </div>
                  <div class="col-lg-6">
                     <input type="tel" placeholder="Phone number" name="phonenumber" required=""> <a href="" class="addnumber"><span><i class="fa fa-plus" aria-hidden="true"></i> Add Alternate Phone Number</span></a> </div>
                  <div class="col-lg-6 col-6">
                     <input type="text" placeholder="Pincode" name="uname" required=""> </div>
                  <div class="col-lg-6 col-6">
                     <button class="myloction"><i class="fa fa-compass" aria-hidden="true"></i> Use my location</button>
                  </div>
                  <div class="col-lg-6 col-6">
                     <input type="text" placeholder="State" name="uname" required=""> </div>
                  <div class="col-lg-6 col-6">
                     <input type="text" placeholder="City" name="uname" required="">
                     <button type="submit" class="Search-btnfrm"><i class="fa fa-search"></i></button>
                  </div>
                  <div class="col-lg-6">
                     <input type="text" placeholder="House No, Building Name" name="uname" required=""> </div>
                  <div class="col-lg-6">
                     <input type="text" placeholder="Road name, Area, Colony" name="uname" required="">
                     <button type="submit" class="Search-btnfrm"><i class="fa fa-search"></i></button> <a href="" class="addnear"><span><i class="fa fa-plus" aria-hidden="true"></i> Add Nearby Famous Shop/Landmark</span></a> </div>
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
                           <br> </div>
                     </div>
                  </div>
               </div>
               <div class="text-center">
                  <button class="savebtn">Save Address</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>