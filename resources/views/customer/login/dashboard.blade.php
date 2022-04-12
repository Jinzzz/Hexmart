@include('layouts.header') 

<!-----end------>
         <div class="w3-content w3-display-container">
             @foreach ($sliderBanner as $b)
                <img class="mySlides" src="{{URL::to('/assets/uploads/customer_banners/'.$b->customer_banner)}} " style="width:100%">
             @endforeach
            {{-- <img class="mySlides" src="{{URL::to('/assets/frontAssets/image/banner-img2.jpg')}} " style="width:100%"> --}}
            <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
            <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
         </div>
         <!-----banner end-------------------> 
         <!---------shop by-------------->
         Welcome  {{$name}}

         <section class="bg-full">
            <div class="wrapper">
               <div class="container-fluid pb-5 pt-5">
                  <div class="row">
                     <div class="col-md-12 col-lg-6 col-12">
                        <div class="category1">
                           <div class="shop-head">
                              <h2>shop by category</h2>
                           </div>
                           <div class="row text-center">
                              @foreach ($categoryDetails as $cat)
                              <div class="col-md-4 col-sm-6 col-4 col-lg-4 pb-2 " data-aos="fade-up">
                                 <a href="{{ url('/categories/'.$cat->item_category_id.'/'.$cat->category_name_slug) }}">
                                    <img src="{{URL::to('assets/uploads/category_icon/'.$cat->category_icon)}} " class="img-fluid shop-item-icon" alt="">
                                    <h3 class="cat-head">{{ $cat->category_name }}</h3>
                                 </a>
                              </div>
                              @endforeach

                              {{-- <div class="col-md-4 col-sm-6 col-4 col-lg-4 pb-2 " data-aos="fade-up">
                                 <a href="">
                                    <img src="{{URL::to('/assets/frontAssets/image/cat-icon1.png')}} " class="img-fluid shop-item-icon" alt="">
                                    <h3 class="cat-head">Fashion</h3>
                                 </a>
                              </div>
                              <div class="col-md-4 col-sm-6 col-4 col-lg-4 pb-2 " data-aos="fade-up">
                                 <a href="">
                                    <img src="{{URL::to('/assets/frontAssets/image/cat-icon2.png')}} " class="img-fluid shop-item-icon" alt="">
                                    <h3 class="cat-head">Travel</h3>
                                 </a>
                              </div>
                              <div class="col-md-4 col-sm-6 col-4 col-lg-4 pb-2 " data-aos="fade-up">
                                 <a href="">
                                    <img src="{{URL::to('/assets/frontAssets/image/cat-icon3.png')}} " class="img-fluid shop-item-icon" alt="">
                                    <h3 class="cat-head">Entertainment</h3>
                                 </a>
                              </div>
                              <div class="col-md-4 col-sm-6 col-4 col-lg-4" data-aos="fade-up">
                                 <a href="">
                                    <img src="{{URL::to('/assets/frontAssets/image/cat-icon4.png')}} " class="img-fluid shop-item-icon" alt="">
                                    <h3 class="cat-head">Electronics</h3>
                                 </a>
                              </div>
                              <div class="col-md-4 col-sm-6 col-4 col-lg-4" data-aos="fade-up">
                                 <a href="">
                                    <img src="{{URL::to('/assets/frontAssets/image/cat-icon5.png')}} " class="img-fluid shop-item-icon" alt="">
                                    <h3 class="cat-head">Lifestyle</h3>
                                 </a>
                              </div> --}}
                              <div class="col-md-4 col-sm-6 col-4 col-lg-4" data-aos="fade-up">
                                 <a href="{{ url('/categories') }}">
                                    <img src="{{URL::to('/assets/frontAssets/image/cat-icon6.png')}} " class="img-fluid shop-item-icon" alt="">
                                    <h3 class="cat-head">View All</h3>
                                 </a>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 col-lg-6 col-12">
                        <div class="product-slid-container">
                           <div class="slider">

                              @foreach ($offerDetails as $offer)
                                 

                              <div class="slide">
                                 <div class="sec-imag">
                                    <img src="{{URL::to((new \App\Helpers\Helper)->productVarBaseImage(0,$offer->product_variant_id) )}}" class="img-fluid product-slid-img" alt="">
                                 </div>
                                 <div class="sec-content">
                                    <p class="product-slid-rs">From &#8377; {{ $offer->offer_price }}</p>
                                    <p class="product-slid-text">
                                       @if (@$offer->productVariantData->variant_name != @$offer->productVariantData->productData->product_name)
                                             @php
                                                $productFullName = @$offer->productVariantData->productData->product_name."-".@$offer->productVariantData->variant_name;
                                             @endphp
                                             {{ @$offer->productVariantData->productData->product_name }} {{ @$offer->productVariantData->variant_name }}
                                          @else
                                             {{ @$offer->productVariantData->variant_name }}
                                             @php
                                             $productFullName = @$offer->productVariantData->variant_name;
                                             @endphp
                                       @endif
                                    </p>
                                    <a href="{{ url('product-variant/'.$offer->product_variant_id."/".$productFullName) }}" class="shop-now-btn">Shop Now</a>
                                 </div>
                              </div>

                              @endforeach
                              

                              {{-- <div class="slide">
                                 <div class="sec-imag">
                                    <img src="{{URL::to('/assets/frontAssets/image/offer-img2.jpeg')}}" class="img-fluid product-slid-img" alt="">
                                 </div>
                                 <div class="sec-content">
                                    <p class="product-slid-rs">From &#8377;1890</p>
                                    <p class="product-slid-text">Office Study Table</p>
                                    <a href="" class="shop-now-btn">Shop Now</a>
                                 </div>
                              </div>

                              <div class="slide"  >
                                 <div class="sec-imag">
                                    <img src="{{URL::to('/assets/frontAssets/image/offer-img1.jpg')}}" class="img-fluid product-slid-img" alt="">
                                 </div>
                                 <div class="sec-content">
                                    <p class="product-slid-rs">From &#8377;1890</p>
                                    <p class="product-slid-text">Office Study Table</p>
                                    <a href="" class="shop-now-btn">Shop Now</a>
                                 </div>
                              </div>
                              <div class="slide" >
                                 <div class="sec-imag">
                                    <img src="{{URL::to('/assets/frontAssets/image/offer-img2.jpeg')}} " class="img-fluid product-slid-img" alt="">
                                 </div>
                                 <div class="sec-content">
                                    <p class="product-slid-rs">From &#8377;1890</p>
                                    <p class="product-slid-text">Office Study Table</p>
                                    <a href="" class="shop-now-btn">Shop Now</a>
                                 </div>
                              </div>
                              <div class="slide "  >
                                 <div class="sec-imag">
                                    <img src="{{URL::to('/assets/frontAssets/image/offer-img1.jpg')}} " class="img-fluid product-slid-img" alt="">
                                 </div>
                                 <div class="sec-content">
                                    <p class="product-slid-rs">From &#8377;1890</p>
                                    <p class="product-slid-text">Office Study Table</p>
                                    <a href="" class="shop-now-btn">Shop Now</a>
                                 </div>
                              </div>
                              <div class="slide"  >
                                 <div class="sec-imag">
                                    <img src="{{URL::to('/assets/frontAssets/image/offer-img2.jpeg')}} " class="img-fluid product-slid-img" alt="">
                                 </div>
                                 <div class="sec-content">
                                    <p class="product-slid-rs">From &#8377;1890</p>
                                    <p class="product-slid-text">Office Study Table</p>
                                    <a href="" class="shop-now-btn">Shop Now</a>
                                 </div>
                              </div>
                              <div class="slide"  >
                                 <div class="sec-imag">
                                    <img src="{{URL::to('/assets/frontAssets/image/offer-img1.jpg')}} " class="img-fluid product-slid-img" alt="">
                                 </div>
                                 <div class="sec-content">
                                    <p class="product-slid-rs">From &#8377;1890</p>
                                    <p class="product-slid-text">Office Study Table</p>
                                    <a href="" class="shop-now-btn">Shop Now</a>
                                 </div>
                              </div>
                              <div class="slide"  >
                                 <div class="sec-imag">
                                    <img src="{{URL::to('/assets/frontAssets/image/offer-img1.jpg')}} " class="img-fluid product-slid-img" alt="">
                                 </div>
                                 <div class="sec-content">
                                    <p class="product-slid-rs">From &#8377;1890</p>
                                    <p class="product-slid-text">Office Study Table</p>
                                    <a href="" class="shop-now-btn">Shop Now</a>
                                 </div>
                              </div>
                              <div class="slide"  >
                                 <div class="sec-imag">
                                    <img src="{{URL::to('/assets/frontAssets/image/offer-img1.jpeg')}} " class="img-fluid product-slid-img" alt="">
                                 </div>
                                 <div class="sec-content">
                                    <p class="product-slid-rs">From &#8377;1890</p>
                                    <p class="product-slid-text">Office Study Table</p>
                                    <a href="" class="shop-now-btn">Shop Now</a>
                                 </div>
                              </div> --}}
                           </div>
                           <h3 class="offer-sale">OFFER<br> SALE</h3>
                           <div class="controls">
                              <div id="back"><span class="lnr lnr-chevron-up"></span></div>
                              <div id="forvard"><span class="lnr lnr-chevron-down"></span></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-------end----->
         <!-----banner-sub--->
         <section class="bg-full">
            <div class="wrapper">
               <div class="container-fluid">
                  <img src="{{URL::to('/assets/frontAssets/image/offer-banner.jpg')}} " class="img-fluid">
               </div>
            </div>
         </section>
         <!--end--->
         <!---recent product--->
         <section class="recent-product-sec pt-5 pb4 bg-full">
            <div class="wrapper">
               <div class="container-fluid">
                  <h2>Recent products</h2>
                  <div class="row">
                     @foreach($recentAddedProducts as $product)

                     <div class="col-md-6 col-lg-3 col-6 col-padding pt-3 pb-4" data-aos="fade-up">
                        <a href="{{ url('/product/'.$product->product_variant_id."/".$product->product_name_slug."-".$product->variant_name_slug) }}">
                           <div class="box">
                              <img src="{{URL::to((new \App\Helpers\Helper)->productVarBaseImage($product->product_id,$product->product_variant_id))}} " class="img-fluid product-image" alt="">
                              <p>
                                 @if (@$product->productVariantData->variant_name != @$product->productVariantData->productData->product_name)
                                   
                                    {{ @$product->productVariantData->productData->product_name }} {{ @$product->productVariantData->variant_name }}
                                 @else
                                    {{ @$product->productVariantData->variant_name }}
                                   
                                 @endif
                              </p>
                              <span class="rating-reviews">{{ (new \App\Helpers\Helper)->findRatingCount($product->product_variant_id) }} Ratings & {{ (new \App\Helpers\Helper)->findReviewCount($product->product_variant_id)}} Reviews</span>
                              <span class="price">&#8377; {{ number_format($product->variant_price_offer, 2, '.', ',')   }}</span>
                           </div>
                        </a>
                     </div>

                     @endforeach

                    
                     {{-- <div class="col-md-6 col-lg-3 col-6 col-padding pt-3 pb-4" data-aos="fade-up">
                        <a href="">
                           <div class="box">
                              <img src="{{URL::to('/assets/frontAssets/image/pdt-img2.jpeg')}} " class="img-fluid product-image" alt="">
                              <p>Sony Alpha ILCE-6400L
                                 Mirrorless Camera with...
                              </p>
                              <span class="rating-reviews">184 Ratings & 36 Reviews</span>
                              <span class="price">&#8377; 79,999</span>
                           </div>
                        </a>
                     </div>
                     <div class="col-md-6 col-lg-3 col-6 col-padding pt-3 pb-4" data-aos="fade-up">
                        <a href="">
                           <div class="box">
                              <img src="{{URL::to('/assets/frontAssets/image/pdt-img3.jpeg')}} " class="img-fluid product-image" alt="">
                              <p>Sony Alpha ILCE-6400L
                                 Mirrorless Camera with...
                              </p>
                              <span class="rating-reviews">184 Ratings & 36 Reviews</span>
                              <span class="price">&#8377; 79,999</span>
                           </div>
                        </a>
                     </div>
                     <div class="col-md-6 col-lg-3 col-6 col-padding pt-3 pb-4" data-aos="fade-up">
                        <a href="">
                           <div class="box">
                              <img src="{{URL::to('/assets/frontAssets/image/pdt-img4.jpeg')}} " class="img-fluid product-image" alt="">
                              <p>Sony Alpha ILCE-6400L
                                 Mirrorless Camera with...
                              </p>
                              <span class="rating-reviews">184 Ratings & 36 Reviews</span>
                              <span class="price">&#8377; 79,999</span>
                           </div>
                        </a>
                     </div>
                     <div class="col-md-6 col-lg-3 col-6 col-padding  pb-4" data-aos="fade-up">
                        <a href="">
                           <div class="box">
                              <img src="{{URL::to('/assets/frontAssets/image/pdt-img5.jpeg')}} " class="img-fluid product-image" alt="">
                              <p>Sony Alpha ILCE-6400L
                                 Mirrorless Camera with...
                              </p>
                              <span class="rating-reviews">184 Ratings & 36 Reviews</span>
                              <span class="price">&#8377; 79,999</span>
                           </div>
                        </a>
                     </div>
                     <div class="col-md-6 col-lg-3 col-6 col-padding  pb-4" data-aos="fade-up">
                        <a href="">
                           <div class="box">
                              <img src="{{URL::to('/assets/frontAssets/image/pdt-img6.jpeg')}} " class="img-fluid product-image" alt="">
                              <p>Sony Alpha ILCE-6400L
                                 Mirrorless Camera with...
                              </p>
                              <span class="rating-reviews">184 Ratings & 36 Reviews</span>
                              <span class="price">&#8377; 79,999</span>
                           </div>
                        </a>
                     </div>
                     <div class="col-md-6 col-lg-3 col-6 col-padding  pb-4" data-aos="fade-up">
                        <a href="">
                           <div class="box">
                              <img src="{{URL::to('/assets/frontAssets/image/pdt-img7.jpeg')}} " class="img-fluid product-image" alt="">
                              <p>Sony Alpha ILCE-6400L
                                 Mirrorless Camera with...
                              </p>
                              <span class="rating-reviews">184 Ratings & 36 Reviews</span>
                              <span class="price">&#8377; 79,999</span>
                           </div>
                        </a>
                     </div>
                     <div class="col-md-6 col-lg-3 col-6 col-padding  pb-4" data-aos="fade-up">
                        <a href="">
                           <div class="box">
                              <img src="{{URL::to('/assets/frontAssets/image/pdt-img8.jpeg')}} " class="img-fluid product-image" alt="">
                              <p>Sony Alpha ILCE-6400L
                                 Mirrorless Camera with...
                              </p>
                              <span class="rating-reviews">184 Ratings & 36 Reviews</span>
                              <span class="price">&#8377; 79,999</span>
                           </div>
                        </a>
                     </div> --}}
                  </div>
               </div>
            </div>
         </section>
         <!----fotter--->
         <!----script--------->
         <script src="{{URL::to('/assets/frontAssets/js/bootstrap.js')}} "></script>
         <script src="{{URL::to('/assets/frontAssets/js/bootstrap.min.js')}} "></script>
         <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
         <script>
            var slideIndex = 1;
            showDivs(slideIndex);
            
            function plusDivs(n) {
              showDivs(slideIndex += n);
            }
            
            function showDivs(n) {
              var i;
              var x = document.getElementsByClassName("mySlides");
              if (n > x.length) {slideIndex = 1}
              if (n < 1) {slideIndex = x.length}
              for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";  
              }
              x[slideIndex-1].style.display = "block";  
            }
         </script>
         <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
         <script>
            AOS.init();
         </script>
         <script>
            document.addEventListener('DOMContentLoaded', function() {
            renderSlider('.slider');
            });
            
            const nextSlide = () => {  
            let activeSlide = document.querySelector('.slide--active');
            let nextSlide = activeSlide.nextElementSibling;
            if (nextSlide) {
            activeSlide.classList.remove('slide--active');
            nextSlide.classList.remove('next');
            nextSlide.classList.add('slide--active');
            renderSlides();
            renderBtns();
            }
            
            }
            
            const renderBtns = () => {
            let nextBtn = document.querySelector('#forvard');
            let prevBtn = document.querySelector('#back'); 
            
            let activeSlide = document.querySelector('.slide--active');
            let prevSlide = activeSlide.previousElementSibling;
            !prevSlide ? prevBtn.classList.add('disabled')
                     : prevBtn.classList.remove('disabled');
            
            let nextSlide = activeSlide.nextElementSibling;
            !nextSlide ? nextBtn.classList.add('disabled')
                     : nextBtn.classList.remove('disabled');
            }
            
            const prevSlide = () => {  
            let activeSlide = document.querySelector('.slide--active');
            let prevSlide = activeSlide.previousElementSibling;
            if (prevSlide) {
            activeSlide.classList.remove('slide--active');
            prevSlide.classList.remove('prev');
            prevSlide.classList.add('slide--active');
            renderSlides();
            renderBtns();
            }  
            }
            
            const renderSlides = () => {
            let slides = document.querySelectorAll('.slide');
            if (!slides) {
              return;
            }
            let activeSlide = document.querySelector('.slide--active');
            if (!activeSlide) {      
              activeSlide = slides.item(0);
              activeSlide.classList.add('slide--active');
            }
            [].forEach.call(slides, function(slide) {
              slide.classList.remove('prev', 'next')
            });
            
            let prevSlide = activeSlide.previousElementSibling;
            prevSlide && prevSlide.classList.add('prev');
            
            let nextSlide = activeSlide.nextElementSibling;
            nextSlide && nextSlide.classList.add('next');
            
            }
            
            const renderSlider = (element) => {
            const slider = document.querySelector(element);
            if (slider) {
            let nextButton = document.querySelector("#forvard");
            nextButton.addEventListener('click', function() {
              nextSlide();
            })
            
            let prevButton = document.querySelector("#back");
            prevButton.addEventListener('click', function() {
              prevSlide();
            })
            renderSlides();
            }
            }
            
            
         </script>
   </body>
</html>
@include('layouts.footer') 