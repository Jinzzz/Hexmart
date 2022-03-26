@include('layouts.header')
<!-----end------>
<section class="product-details-sec">
   <div class="container-fluid">
      <div class="pagediv-main">
         <div class="pagediv-main1">
            <div class="left-sec">
               <h4>Filter by</h4>
               <div class="pricerange">
                  <h5>Price </h5>
                  <section class="range-slider">
                     <input value="<?php echo $min;?>" min="<?php echo $min;?>" max="<?php echo $max;?>" step="" type="range">
                     <input value="<?php echo $max;?>" min="<?php echo $min;?>" max="<?php echo $max;?>" step="" type="range">
                     <div class="sminmax">
                        <div class="smin">Min <span class="rangeValues1"></span></div>
                        <div class="smin">Max <span class="rangeValues2"></span></div>
                     </div>
                  </section>
               </div>
               <div class="">
                  <div class="cccc">
                     <div class="accordion-wrap">
                        <div class="accordion-data">
                           <input type="checkbox" id="accordion-1" class="checkbox-label">
                           <label for="accordion-1">Processor</label>
                           <div class="accordion-content">
                              <form action="/action_page.php">
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i5</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i3</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i7</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for="">Ryzen 7 Quad Core</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Ryzen 5 Quad Core</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i9</label>
                                 <br>
                                 <br> </form>
                           </div>
                        </div>
                        <div class="accordion-data">
                           <input type="checkbox" id="accordion-2" class="checkbox-label">
                           <label for="accordion-2">Brand</label>
                           <div class="accordion-content">
                              <form action="/action_page.php">
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> HP</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Lenov0</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> vaio</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for="">Nokia</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> mi</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for="">MSI</label>
                                 <br>
                                 <br> </form>
                           </div>
                        </div>
                        <div class="accordion-data">
                           <input type="checkbox" id="accordion-3" class="checkbox-label">
                           <label for="accordion-3">Screen size</label>
                           <div class="accordion-content">
                              <form action="/action_page.php">
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i5</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i3</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i7</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for="">Ryzen 7 Quad Core</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Ryzen 5 Quad Core</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i9</label>
                                 <br>
                                 <br> </form>
                           </div>
                        </div>
                        <div class="accordion-data">
                           <input type="checkbox" id="accordion-4" class="checkbox-label">
                           <label for="accordion-4">Dedicated Graphics Memory</label>
                           <div class="accordion-content">
                              <form action="/action_page.php">
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i5</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i3</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i7</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for="">Ryzen 7 Quad Core</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Ryzen 5 Quad Core</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i9</label>
                                 <br>
                                 <br> </form>
                           </div>
                        </div>
                        <div class="accordion-data">
                           <input type="checkbox" id="accordion-5" class="checkbox-label">
                           <label for="accordion-5">Operating system</label>
                           <div class="accordion-content">
                              <form action="/action_page.php">
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i5</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i3</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i7</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for="">Ryzen 7 Quad Core</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Ryzen 5 Quad Core</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i9</label>
                                 <br>
                                 <br> </form>
                           </div>
                        </div>
                        <div class="accordion-data">
                           <input type="checkbox" id="accordion-6" class="checkbox-label">
                           <label for="accordion-6">Type </label>
                           <div class="accordion-content">
                              <form action="/action_page.php">
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i5</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i3</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i7</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for="">Ryzen 7 Quad Core</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Ryzen 5 Quad Core</label>
                                 <br>
                                 <input type="checkbox" id="" name="" value="">
                                 <label for=""> Core i9</label>
                                 <br>
                                 <br> </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="pagediv-main2">
            <div class="right-side">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="pagelinks">
                        <ul>
                           <li>Home <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></li>
                           <li>Electronics <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></li>
                           <li>Laptops</li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <div class="shorbylinks">
                        <ul>
                           <li>Sort By </li>
                           <li class="pr-active"><a href="{{URL::current()}}">Relevance </a></li>
                           <li><a href="{{URL::current()."?sort=price_popularity"}}">Popularity</a></li>
                           <li><a href="{{URL::current()."?sort=price_asc"}}">Price Low to High</a> </li>
                           <li><a href="{{URL::current()."?sort=price_dsc"}}">Price High to Low</a> </li>
                           <li><a href="{{URL::current()."?sort=price_newest"}}">Newest First</a></li>
                        </ul>
                     </div>
                  </div>
                  @foreach($mainsub_product_varient as $varient)
                  <div class="col-lg-12 ptre">
                     <div class="maindicproduct">
                        <div class="primag"> 
                          
                           <img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($varient->product_id,$varient->product_variant_id))}}"   width="50" >
                        </div>
                        <div class="prdetails">
                           <h3>{{$varient->variant_name}} </h3>
                           <ul>
                              
                              <li> @if(isset($varient->Productvarients[0]->product_description))
                              {!!  substr(strip_tags($varient->Productvarients[0]->product_description), 0, 100) !!}@endif</li>
                           </ul>

                        </div>
                        <div class="pramount">
                           <h5> {{$varient->variant_price_offer}}</h5> <span class="cutprice"><s>{{$varient->variant_price_regular}}</s></span><span class="offer"> 8% off</span>
                           <br>
                           <div class="pdt"><span class="rate-review">382 Ratings & 60 Reviews</span></div>
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
               <div class="pageination-div">
                  <div class="pageof"> <span></span> </div>
                  <div class="pagination-news-page">
                     <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li>
                               
                         {{ $mainsub_product_varient->appends(request()->input())->links()}}
                         
                         </li>
                        </ul>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</section>
<!-------end----->
<!----fotter--->@include('layouts.footer')
<!----script--------->

</body>

</html>