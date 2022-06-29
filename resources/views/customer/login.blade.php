@include('layouts.header')
<!------------>
<section class="order-confirmed-sec">
   <div class="container-fluid">
      <div class="ordrconfrm-container">
         <div class="ordrconfrm">
            <div class="login-sec text-center">
               <div class="loginimgdiv"> <img src="{{URL::to('/assets/frontAssets/image/login-image.png')}}" class="img-fluid login-img" alt=""> </div>
               <div class="login-frm">
                  <form method="POST" action="{{ url('/customer/customer-store') }}">
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
                           <input type="email" name="customer_email" placeholder="Enter Email/Mobile Number" required autocomplete="off" value="{{ old('customer_email') }}"> 
                            @error('customer_email')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                        <div class="col-lg-12">
                           <input type="password" name="password" placeholder="Enter Password" required autocomplete="off">
                           @error('password')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                           <span class="focus-input100"></span>
                            <a class="frgt" href="{{url('/customer/forgot-password')}}"><span>forgot? </span></a> </div>
                     </div>
                  
                  <div class="btns">
                     <button type="submit">Login</button>
                   
                  </div>
                  </form>
                  <div class="btns">
                     <button class="signupbtn"><a href="{{url('/customer/register')}}">Don't have an account?sign up</a></button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>