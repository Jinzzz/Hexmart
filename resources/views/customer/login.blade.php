@include('layouts.header')
<!------------>
<section class="order-confirmed-sec">
   <div class="container-fluid">
      <div class="ordrconfrm-container">
         <div class="ordrconfrm">
            <div class="login-sec text-center">
               <div class="loginimgdiv"> <img src="{{URL::to('/assets/frontAssets/image/login-image.png')}}" class="img-fluid login-img" alt=""> </div>
               <div class="login-frm">
                  <form>
                     <div class="row">
                        <div class="col-lg-12">
                           <input type="" name="" placeholder="Enter Email/Mobile Number"> </div>
                        <div class="col-lg-12">
                           <input type="" name="" placeholder="Enter Password"> <a class="frgt"><span>forgot? </span></a> </div>
                     </div>
                  </form>
                  <div class="btns">
                     <button>Login</button>
                     <button class="signupbtn">Don't have an account?sign up</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>