@include('layouts.header')
<section class="order-confirmed-sec">
   <div class="container-fluid">
      <div class="ordrconfrm-container">
         <div class="ordrconfrm">
            <div class="success-checkmark">
               <div class="check-icon"> <span class="icon-line line-tip"></span> <span class="icon-line line-long"></span>
                  <div class="icon-circle"></div>
                  <div class="icon-fix"></div>
               </div>
            </div>
            <div class="order-con-content ">
               <h2>Hi @if(isset($name)){{$name}}@endif,</h2>
               <h3>Order successfully placed.</h3>
               <p>Your order will be delivered by Fri 16, Apr 2021</p>
               <p>We are pleased to confirm your order no @if(isset($order->order_number)){{$order->order_number}}@endif.</p>
               <p>Thank you for shopping with us!</p>
               <button class="mn-dorder">Manage your order</button>
            </div>
         </div>
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>