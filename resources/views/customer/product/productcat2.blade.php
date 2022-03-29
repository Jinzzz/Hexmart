@include('layouts.header')
<!-----end------>
<meta name="csrf-token" content="{{ csrf_token() }}" />

<section class="product-details-sec">
   <div class="container-fluid">
      <div class="pagediv-main">
         <div class="pagediv-main1">
            <div class="left-sec">
               <h4>Filter by</h4>
               <div class="pricerange">
                  <h5>Price </h5>
                  <form action="{{URL::current('/')}}">
                     <!-- @csrf -->
                  <section class="range-slider">
                     <input value="<?php echo $min;?>" min="<?php echo $min;?>" max="<?php echo $max;?>" step="" type="range" id="min" name="min">
                     <input value="<?php echo $max;?>" min="<?php echo $min;?>" max="<?php echo $max;?>" step="" type="range" id="max" name="max">
                     <input type="hidden" id="name" name="name" value="<?php echo $name;?>" >
                     <input type="hidden" id="catname" name="catname" value="<?php echo $catname;?>" >
                     <input type="hidden" id="mainsubcat" name="mainsubcat" value="<?php echo $mainsubcat;?>" >

                     <div class="sminmax">
                        <div class="smin">Min <span class="rangeValues1"></span></div>
                        <div class="smin">Max <span class="rangeValues2"></span></div>
                     </div>
                  </section>
               </br>
               </br>
                <div class="col-md-12 text-center"><button type="submit" class="btn btn-primary" id="pricefilter">Price Filter</button></div>
                  </form>
               </div>
               <div class="">
                  <form action="{{URL::current('/')}}">
               <div class="cccc">
                  <div class="accordion-wrap">
                     <div class="accordion-data">
                        <input type="checkbox" id="accordion-1" class="checkbox-label">
                        <label for="accordion-1">Brand</label>
                        <div class="accordion-content">
                            @foreach($brand as $val)
                            @php
                                $checked=[];
                                if(isset($_GET['brand']))
                                {
                                 $checked=$_GET['brand'];
                                }
                            @endphp
                              <input class="checkbox" type="checkbox" name="brand[]" value="{{$val->brand_id}}" @if(in_array($val->brand_id,$checked)) checked @endif>
                              <label for=""> {{ucfirst($val->brand_name)}}</label>
                              <br> @endforeach
                              <br> 
                        </div>
                     </div>
                     <div class="accordion-data">
                        <input type="checkbox" id="accordion-2" class="checkbox-label">
                        <label for="accordion-2">Attribute</label>
                        <div class="accordion-content">
                           @foreach($attribute as $value)
                              <input type="checkbox" name="attribute[]" value="{{$value->attribute_group_id}}">
                              <label for=""> {{ucfirst($value->attribute_group)}}</label>
                              <br> @endforeach
                              <br> 
                        </div>
                     </div>

                  </div>

                     <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary" id="pricefilter">Apply Filter</button>
                     </div>
               </div>
               </form>
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
                            <li>{{ucfirst($catname)}} <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></li>
                           <li>{{ucfirst($name)}} </li>
                           <li>{{ucfirst($mainsubcat)}} </li>
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
                          
                           <a href="{{url('/productmainsubdetail').'/'.$name.'/'.$catname.'/'.$varient->variant_name.'/'.$mainsubcat}}"><img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($varient->product_id,$varient->product_variant_id))}}"   width="50" ></a>
                        </div>
                        <div class="prdetails">
                           <h3>{{ucfirst($varient->variant_name)}} </h3>
                           <ul>
                              
                              @if(isset($varient->Productvarients[0]->product_description))
                              {!!  substr(strip_tags($varient->Productvarients[0]->product_description), 0, 100) !!}@endif
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