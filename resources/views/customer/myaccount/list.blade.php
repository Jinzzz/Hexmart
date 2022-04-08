@include('layouts.header')
<section class="myorder-sec bg-gray">
   <div class="container-fluid">
      <div class="my-main-div">
         <div class="my-inner-div1">
            <div class="myacc-head">
               <h5>My Account</h5> </div>
            <div class="accont-row">
               <div class="myaccount-content">
                  <h5>@if(isset($user_details->customer_name)){{$user_details->customer_name}}@endif</h5>
                  <p>@if(isset($user_details->customer_mobile))+91{{$user_details->customer_mobile}}@endif</p>
                  <p>@if(isset($user_details->customer_email)){{$user_details->customer_email}}@endif</p>
               </div>
               <div class="editbtn">
                  <button> <a href="{{url('/customer/My_Account-Edit')}}"> Edit</a></button>
               </div>
            </div>
            <div class="accont-row">
               <div class="myaccount-content">
                  <h5>My Orders</h5>
                  <p>Last ordered</p>
                  <p>{{ date('j F  Y', strtotime($order->created_at)) }}</p>
               </div>
               <div class="editbtn">
                  <button> <a href="{{url('/customer/My-Orders')}}">View All</a></button>
               </div>
            </div>
            <div class="accont-row">
               <div class="myaccount-content">
                  <h5>My Addresses </h5>
                  <p>@if(isset($user_details->place)){{$user_details->place}}@endif</p>
                  <p>@if(isset($user_details->road)){{$user_details->road}}@endif</p>
               </div>
               <div class="editbtn">
                  <button> <a href="{{url('/customer/My-Account-Address')}}">View All</a></button>
               </div>
            </div>
         </div>
         <div class="my-inner-div2">
            <div class="account-c">
               <a href="">
                  <div class="conetnt-link">
                     <h5><i class="fa fa-cog" aria-hidden="true"></i> <span>Account Settings</span></h5> </div>
               </a>
               <div class="brline"></div>
               <a href="">
                  <div class="conetnt-link">
                     <h5><i class="fa fa-trash" aria-hidden="true"></i><span>Delete Account</span></h5> </div>
               </a>
               <div class="brline"></div>
               <a href="">
                  <div class="conetnt-link">
                     <h5><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></h5> </div>
               </a>
            </div>
         </div>
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>