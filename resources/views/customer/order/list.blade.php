@include('layouts.header')
<section class="myorder-sec bg-gray">
   <div class="container-fluid">
      <div class="myorder-container">
         <div class="row">
            @foreach($order as $val)
            <div class="col-lg-12">
               <a href="{{url('customer/Order-Details').'/'.$val->order_item_id }}">
                  <div class="myorderconfrm-div">
                     <div class="myorderconfrm">
                        <h4>Order no. @if(isset($val->order_number)){{$val->order_number}}@endif</h4>
                        <div class="myorderdiv-ft">
                           <ul>
                              <li><i class="fa fa-calendar-o" aria-hidden="true"></i> <span>{{ date('j F  Y', strtotime($val->created_at)) }}</span></li>
                              <li> <img src="{{URL::to('/assets/frontAssets/image/delivery-box-size.png')}}" class="img-fluid dlvry-imgmyor" alt=""> <span>Delivery by Sat, 10th Apr</span></li>
                           </ul>
                        </div>
                     </div>
                     <div class="arrow-sec"> <span class="lnr lnr-chevron-right"></span> </div>
                  </div>
               </a>
            </div>
            @endforeach
         </div>
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>