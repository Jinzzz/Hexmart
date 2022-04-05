@include('layouts.header')
<!------------>
<section class="order-confirmed-sec">
   <div class="container-fluid">
      <div class="ordrconfrm-container">
         <div class="ordrconfrm">
            <div class="sign-up">
               <div class="signup-div text-center"> <img src="{{URL::to('/assets/frontAssets/image/sign-up.png')}}" class="img-fluid sign-up" alt=""> </div>
               <div class="signup-div-frm">
                  <form method="POST" action="{{ url('/customer/Customer-Register') }}">
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
                        <div class="col-lg-12">
                           <input type="text" placeholder="Full Name (Required)*" name="name" required="" autocomplete="off"> 
                           @error('name')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                         <div class="col-lg-12">
                           <input type="email" placeholder="Email (Required)*" name="customer_email" required="" autocomplete="off">
                           @error('customer_email')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                            </div>  
                        <div class="col-lg-12">
                           <input type="tel" placeholder="Phone number (Required)*" name="customer_mobile" required="" autocomplete="off" pattern="[789][0-9]{9}" 
                                 title="Phone number with 7-9 and remaing 9 digit with 0-9"> 
                              @error('customer_mobile')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                        <div class="col-lg-6 col-12">
                           <input type="text" placeholder="Pincode (Required)*" name="pin" required="" autocomplete="off"> 
                        @error('pin')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                        <div class="col-lg-6 col-12">
                           <button class="myloction"><i class="fa fa-compass" aria-hidden="true"></i> Use my location</button>
                        </div>
                        <div class="col-lg-6 col-12">
                           <input type="text" placeholder="State (Required)*" name="state" required="" autocomplete="off"> 
                        @error('state')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                        <div class="col-lg-6 col-12">
                           <input type="text" placeholder="City (Required)*" name="city" required="" autocomplete="off" id="City">
                           @error('city')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                           <!-- <button type="submit" class="Search-btnfrm"><i class="fa fa-search"></i></button> -->
                        </div>
                        <div class="col-lg-12">
                           <input type="text" placeholder="House No, Building Name (Required)*" name="place" required="" autocomplete="off">
                           @error('place')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                            </div>
                        <div class="col-lg-12">
                           <input type="text" placeholder="Road name, Area, Colony (Required)*" name="road" required="" autocomplete="off" id="Road">
                           @error('road')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                           <!-- <button type="submit" class="Search-btnfrm"><i class="fa fa-search"></i></button> -->
                        </div>
                         <div class="col-lg-12">
                           <input type="password" placeholder="Password (Required)*" name="password" required="" autocomplete="off"> 
                        @error('password')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>  
                            <div class="col-lg-12">
                           <input type="password" placeholder="Confirm Password (Required)*" name="confirm_password" required="" autocomplete="off"> 
                        @error('confirm_password')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
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
                              <button type="submit">Save Address</button>
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClnXS4nZ1kcYja_YlOQaEpl-U3AOxBJlw&libraries=places&sensor=false"></script>

<script>
var input = document.getElementById('City');
var autocomplete = new google.maps.places.Autocomplete(input);
google.maps.event.addListener(autocomplete, 'place_changed',   function () {
var place = autocomplete.getPlace();
var lat = place.geometry.location.lat();
var long = place.geometry.location.lng();
});

var inputvalue = document.getElementById('Road');
var autocomplete = new google.maps.places.Autocomplete(inputvalue);
google.maps.event.addListener(autocomplete, 'place_changed',   function () {
var place = autocomplete.getPlace();
var lat = place.geometry.location.lat();
var long = place.geometry.location.lng();
// alert(lat + ", " + long);
});

</script>
<!-------end----->@include('layouts.footer') </body>
</html>