@include('layouts.header')
<!------------>
<section class="order-confirmed-sec bg-gray">
   <div class="container-fluid">
      <div class="whishlist-sec">
         <div class="">
            <div class="right-side">
               <div class="row">
                  @foreach($wish_list as $value)
                  <div class="col-lg-12 ptre">
                     <div class="maindicproduct">
                        <div class="primag"> 
                        <img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($value->productVariantData->product_id,$value->productVariantData->product_variant_id))}}" class="img-fluid">  </div>
                        <div class="prdetails">
                           <div class="wishlist-prize">
                              <h3>{{$value->productVariantData->variant_name}}</h3>
                              <div class="rating-wish"><span class="rate-review">382 Ratings & 60 Reviews</span></div>
                              <div class="pricewish">
                                 <h5>{{$value->productVariantData->variant_price_offer}}</h5> <span class="cutprice"><s>{{$value->productVariantData->variant_price_regular}}</s></span><span class="offer"> 8% off</span>
                                 <br> </div>
                           </div>
                           <div class="pramount removebtn">
                              <button><i class="fa fa-trash-o" aria-hidden="true"></i> <a href="{{url('/Remove_wishlist').'/'.$value->wish_list_id}}">Remove</a></button>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<!-------end----->@include('layouts.footer') </body>

</html>