@include('layouts.header')
<section class="order-confirmed-sec bg-gray">
   <div class="container-fluid">
      <div class="addresslist">
         <div class="address-bx"> <a href="{{url('/customer/Add-Address-Details')}}"><i class="fa fa-plus" aria-hidden="true"></i><h5>Add New Address</h5></a> </div>
         <div class="address-list-bx">
            <div class="addrss-list">
               <div class="name-addrs">
                  <h5>{{ucfirst($customer->customer_name)}}</h5><span class="add-home">home</span></div>
               <p>{{$address->house}}</p>
               <p>{{$address->street}}</p>
            </div>
            <div class="dots">
               <div class="dropdown editdrop">
                  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> <a href=""><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a></button>
                  <ul class="dropdown-menu editdrp-menu">
                     <li><a href="{{url('/customer/Edit-Address')}}">Edit</a></li>
                  </ul>
               </div>
            </div>
         </div>
         @foreach($secondaryaddress as $key=>$value)
         <div class="address-list-bx">
            <div class="addrss-list">
               <div class="name-addrs">
                  <h5>{{$secondaryaddress[$key]->name}}</h5><span class="add-home">home</span></div>
               <p>{{$secondaryaddress[$key]->house}}</p>
               <p>{{$secondaryaddress[$key]->street}}</p>
            </div>
            <div class="dots">
               <div class="dropdown editdrop">
                  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> <a href=""><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a></button>
                  <ul class="dropdown-menu editdrp-menu">
                     <li><a href="{{url('/customer/Update-Address').'/'.$secondaryaddress[$key]->customer_address_id}}">Edit</a></li>
                  </ul>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>