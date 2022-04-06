@include('layouts.header')
<section class="order-confirmed-sec bg-gray">
   <div class="container-fluid">
      <div class="addresslist">
         <div class="address-bx"> <a href="add-address.html"><i class="fa fa-plus" aria-hidden="true"></i><h5>Add New Address</h5></a> </div>
         <div class="address-list-bx">
            <div class="addrss-list">
               <div class="name-addrs">
                  <h5>John Deo</h5><span class="add-home">home</span></div>
               <p>Address line 1</p>
               <p>address line 2</p>
            </div>
            <div class="dots">
               <div class="dropdown editdrop">
                  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> <a href=""><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a></button>
                  <ul class="dropdown-menu editdrp-menu">
                     <li><a href="{{url('/customer/Add-Address')}}">Edit</a></li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="address-list-bx">
            <div class="addrss-list">
               <div class="name-addrs">
                  <h5>John Deo</h5><span class="add-home">home</span></div>
               <p>Address line 1</p>
               <p>address line 2</p>
            </div>
            <div class="dots">
               <div class="dropdown editdrop">
                  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> <a href=""><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a></button>
                  <ul class="dropdown-menu editdrp-menu">
                     <li><a href="add-address.html">Edit</a></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>