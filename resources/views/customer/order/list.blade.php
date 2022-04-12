@include('layouts.header')
<section class="myorder-sec bg-gray">
   <div class="container-fluid">
      <div class="myorder-container">
                  <form action="{{url('/customer/My-Orders')}}" method="GET">
                  <div class="myorderconfrm-div">
                  <div class="row">
                  <div class="col-md-12">
                  <div class="form-group">
                  <label class="form-label">Status</label>
                  <div id="storel"></div>
                  <select class="form-control" name="status"  id="status" required>
                  <option value=""> Select Status </option>
                  @foreach($status as $row)
                  <option value="{{$row->order_status_id}}"> {{$row->status}} </option>
                  @endforeach
                  </select>
                  </div>
                  </div>

                  </div>
                  <div class="row">
                  <div class="col-md-12">
                  <div class="form-group">
                  <label class="form-label">From Date</label>
                  <div id="storel"></div>
                  <input type="date" name="from_date" id="from_date"  required autocomplete="off" placeholder="dd/mm/yyyy" >
                  </div>
                  </div>        
                  </div>

                  <div class="row">
                  <div class="col-md-12">
                  <div class="form-group">
                  <label class="form-label">To Date</label>
                  <div id="storel"></div>
                  <input type="date" name="to_date" id="to_date"  required autocomplete="off" placeholder="dd/mm/yyyy" >
                  </div>
                  </div>        
                  </div>
                  <div class="row">
                  <button class="btn btn-primary mt-2" id="Filter" type="submit">Filter</button>&nbsp;&nbsp;
                  <button class="btn btn-warning" id="Cancel"><a href="{{url('/customer/My-Orders')}}">Cancel</a></button>
                  </div>
                  </div>
                  </form>
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
                              <li><span style="font-weight:bold">Order Status :
                                <?php
                                 if($val->orderData->order_status_id==1)
                                 {
                                   echo "Pending";
                                 }
                                 elseif($val->orderData->order_status_id==2)
                                 {
                                    echo "Cancelled";
                                 }
                                 elseif($val->orderData->order_status_id==3)
                                 {
                                    echo "Confirmed";
                                 }
                                 elseif($val->orderData->order_status_id==4)
                                 {
                                   echo "Picking Completed";
                                 }
                                 elseif($val->orderData->order_status_id==5)
                                 {
                                   echo "Ready for Delivery";
                                 }
                                 elseif($val->orderData->order_status_id==6)
                                 {
                                   echo "Out for Delivery";
                                 }
                                 elseif($val->orderData->order_status_id==7)
                                 {
                                   echo "Delivered";
                                 }
                                 elseif($val->orderData->order_status_id==8)
                                 {
                                   echo "Return confirmed";
                                 }
                                 elseif($val->orderData->order_status_id==9)
                                 {
                                   echo "Return Completed";
                                 }
                                 else
                                 {
                                   echo "Order Placed";
                                 }
                                ?></span></li>
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
