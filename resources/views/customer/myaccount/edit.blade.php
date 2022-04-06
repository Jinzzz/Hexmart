@include('layouts.header')
<section class="myorder-sec bg-gray">
   <div class="container-fluid text-center">
      <div class="myacc-container">
         <div class="myaddress">
            <form class="myaccntfrm" action="{{url('/customer/Account-Update')}}" method="POST">
               @csrf
               <div class="row">
                  <div class="col-lg-12">
                     <input type="hidden" name="id" id="id" value="{{$user_details->customer_id}}">
                     <input type="text" name="name" placeholder="Name" required autocomplete="off" value="{{$user_details->customer_name}}"> </div>
                  <div class="col-lg-12">
                     <input type="tel" pattern="[789][0-9]{9}" title="Phone number with 7-9 and remaing 9 digit with 0-9" name="mobile" placeholder="Phone Number" required autocomplete="off" value="{{$user_details->customer_mobile}}"> </div>
                  <div class="col-lg-12">
                     <input type="email" name="email" placeholder="Email id" required autocomplete="off" value="{{$user_details->customer_email}}"> </div>
               </div>
            
            <div class="btnsupdatecamcel">
               <button type="submit">Update</button>
               <button type="submit"><a href="{{url()->previous()}}">Cancel</a></button>
            </div>
            </form>
         </div>
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>