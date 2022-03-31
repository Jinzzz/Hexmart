@include('layouts.header')
<!------------>
<!----------->
<head>
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
</head>
<section class="linkpage">
   <div class="container-fluid">
      <div class="pagelinks">
         <ul>
            <li>Home <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></li>
            <li>Electronics <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></li>
            <li>Laptops</li>
         </ul>
      </div>
   </div>
</section>
<section class="prdct-detail-sec">
   <div class="container-fluid">
      <div class="">
         <div class="product-detain-main-div ">
            <div class="product-detain-sub-div1">
               <div class="likeandshare-sec">
                  <div class="like-sec">
                     <div id="main-content">
                        <div>
                           <input type="checkbox" id="checkbox" class="wishcheckbox" />
                           <label for="checkbox">
                              <svg id="heart-svg" viewBox="467 392 58 57" xmlns="http://www.w3.org/2000/svg">
                                 <g id="Group" fill="none" fill-rule="evenodd" transform="translate(467 392)">
                                    <path d="M29.144 20.773c-.063-.13-4.227-8.67-11.44-2.59C7.63 28.795 28.94 43.256 29.143 43.394c.204-.138 21.513-14.6 11.44-25.213-7.214-6.08-11.377 2.46-11.44 2.59z" id="heart" fill="#AAB8C2" />
                                    <circle id="main-circ" fill="#E2264D" opacity="0" cx="29.5" cy="29.5" r="1.5" />
                                    <g id="grp7" opacity="0" transform="translate(7 6)">
                                       <circle id="oval1" fill="#9CD8C3" cx="2" cy="6" r="2" />
                                       <circle id="oval2" fill="#8CE8C3" cx="5" cy="2" r="2" /> </g>
                                    <g id="grp6" opacity="0" transform="translate(0 28)">
                                       <circle id="oval1" fill="#CC8EF5" cx="2" cy="7" r="2" />
                                       <circle id="oval2" fill="#91D2FA" cx="3" cy="2" r="2" /> </g>
                                    <g id="grp3" opacity="0" transform="translate(52 28)">
                                       <circle id="oval2" fill="#9CD8C3" cx="2" cy="7" r="2" />
                                       <circle id="oval1" fill="#8CE8C3" cx="4" cy="2" r="2" /> </g>
                                    <g id="grp2" opacity="0" transform="translate(44 6)">
                                       <circle id="oval2" fill="#CC8EF5" cx="5" cy="6" r="2" />
                                       <circle id="oval1" fill="#CC8EF5" cx="2" cy="2" r="2" /> </g>
                                    <g id="grp5" opacity="0" transform="translate(14 50)">
                                       <circle id="oval1" fill="#91D2FA" cx="6" cy="5" r="2" />
                                       <circle id="oval2" fill="#91D2FA" cx="2" cy="2" r="2" /> </g>
                                    <g id="grp4" opacity="0" transform="translate(35 50)">
                                       <circle id="oval1" fill="#F48EA7" cx="6" cy="5" r="2" />
                                       <circle id="oval2" fill="#F48EA7" cx="2" cy="2" r="2" /> </g>
                                    <g id="grp1" opacity="0" transform="translate(24)">
                                       <circle id="oval1" fill="#9FC7FA" cx="2.5" cy="3" r="2" />
                                       <circle id="oval2" fill="#9FC7FA" cx="7.5" cy="2" r="2" /> </g>
                                 </g>
                              </svg>
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="share-sec">
                     <div id="box">
                        <button id="btn"> <i class="fa fa-share" aria-hidden="true"></i> </button>
                        <ul id="list">
                           <li class="list-item">
                              <a class="list-item-link" href="#"> <i class="fa fa-facebook" aria-hidden="true"></i> </a>
                           </li>
                           <li class="list-item">
                              <a class="list-item-link" href="#"> <i class="fa fa-whatsapp" aria-hidden="true"></i> </a>
                           </li>
                           <li class="list-item">
                              <a class="list-item-link" href="#"> <i class="fa fa-instagram" aria-hidden="true"></i> </a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="tab">
                  <button class="tablinks" onclick="openCity(event, 'gadget1')" id="defaultOpen"><img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($product_varient->product_id,$product_varient->product_variant_id))}}" class="img-fluid"></button>
                  <!-- <button class="tablinks" onclick="openCity(event, 'gadget2')"><img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($product_varient->product_id,$product_varient->product_variant_id))}}" class="img-fluid"></button>
                           <button class="tablinks" onclick="openCity(event, 'gadget3')"><img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($product_varient->product_id,$product_varient->product_variant_id))}}" class="img-fluid"></button>
                           <button class="tablinks" onclick="openCity(event, 'gadget4')"><img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($product_varient->product_id,$product_varient->product_variant_id))}}" class="img-fluid"></button>
                           <button class="tablinks" onclick="openCity(event, 'gadget5')"><img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($product_varient->product_id,$product_varient->product_variant_id))}}" class="img-fluid"></button>
                           <button class="tablinks" onclick="openCity(event, 'gadget6')"><img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($product_varient->product_id,$product_varient->product_variant_id))}}" class="img-fluid"></button> -->
               </div>
               <div id="gadget1" class="tabcontent"> <img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($product_varient->product_id,$product_varient->product_variant_id))}}"> </div>
               <div id="gadget2" class="tabcontent"> <img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($product_varient->product_id,$product_varient->product_variant_id))}}" class="img-fluid"> </div>
               <div id="gadget3" class="tabcontent"> <img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($product_varient->product_id,$product_varient->product_variant_id))}}" class="img-fluid"> </div>
               <div id="gadget4" class="tabcontent"> <img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($product_varient->product_id,$product_varient->product_variant_id))}}" class="img-fluid"> </div>
               <div id="gadget5" class="tabcontent"> <img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($product_varient->product_id,$product_varient->product_variant_id))}}" class="img-fluid"> </div>
               <div id="gadget6" class="tabcontent"> <img src="{{asset( (new \App\Helpers\Helper)->productVarBaseImage($product_varient->product_id,$product_varient->product_variant_id))}}" class="img-fluid"> </div>
            </div>
            <div class="product-detain-sub-div2">
               <div class="product-details-coontent"> <span class="bbb">
                  <input type="hidden" class="productvariantid" name="productvariantid" id="productvariantid" value="{{$product_varient->product_variant_id}}">
                              <h3>{{ucwords($product_varient->variant_name)}}<span id="dots">...</span><span id="more"></span> </h3>
                  <button onclick="myFunction()" id="myBtn"> more</button>
                  </span>
                  <div class="rating"> <span class="rating-num">4.1 <i class="fa fa-star" aria-hidden="true"></i></span> <span class="rating-con">2,120 ratings</span> </div>
                  <div class="price-d-sec"> <span class="price-d">&#8377;{{$product_varient->variant_price_offer}} </span> <span class="cutprice"><s>134 500</s></span><span class="offer"> 8% off</span> </div>
                  <div class="addcart-sec">
                     <button class="addbtn addToButton">ADD TO CART</button>
                     <button class="buybtn">BUY NOW</button>
                  </div>
                  <div class="highlights-sec">
                     <h5>Highlights</h5>
                     <ul>
                        <li>@if(isset($product_varient->Productvarients[0]->product_description)) {!! strip_tags($product_varient->Productvarients[0]->product_description)!!}@endif </li>
                     </ul>
                     <div class="Details">
                        <a href=""> <span class="alldetails">All Details</span> <span class="aric"><i class="fa fa-angle-right" aria-hidden="true"></i></span> </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</section>
<!--end--->
<!---recent product--->
<section class="recent-product-sec pt-5 pb4 bg-full">
   <div class="wrapper">
      <div class="container-fluid">
         <h2>Recent products</h2>
         <div class="row"> @foreach($product as $value)
            <div class="col-md-6 col-lg-3 col-6 col-padding pt-3 pb-4" data-aos="fade-up">
               <a href="product-details.html">
                  <div class="box"> <img src="{{URL::to((new \App\Helpers\Helper)->productVarBaseImage($value->product_id,$value->product_variant_id))}}" class="img-fluid product-image" alt="">
                     <p>@if(isset($value->Productvarients[0]->product_description)) {!! substr(strip_tags($value->Productvarients[0]->product_description), 0, 100) !!}@endif </p> <span class="rating-reviews">184 Ratings & 36 Reviews</span> <span class="price">&#8377; {{$value->variant_price_offer}}</span> </div>
               </a>
            </div> @endforeach </div>
      </div>
</section> @include('layouts.footer')
<!----script--------->
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="{{URL::to('/assets/cart/js/cart.js')}} "></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
   showDivs(slideIndex += n);
}

function showDivs(n) {
   var i;
   var x = document.getElementsByClassName("mySlides");
   if(n > x.length) {
      slideIndex = 1
   }
   if(n < 1) {
      slideIndex = x.length
   }
   for(i = 0; i < x.length; i++) {
      x[i].style.display = "none";
   }
   x[slideIndex - 1].style.display = "block";
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
   if(nextSlide) {
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
   !prevSlide ? prevBtn.classList.add('disabled') : prevBtn.classList.remove('disabled');
   let nextSlide = activeSlide.nextElementSibling;
   !nextSlide ? nextBtn.classList.add('disabled') : nextBtn.classList.remove('disabled');
}
const prevSlide = () => {
   let activeSlide = document.querySelector('.slide--active');
   let prevSlide = activeSlide.previousElementSibling;
   if(prevSlide) {
      activeSlide.classList.remove('slide--active');
      prevSlide.classList.remove('prev');
      prevSlide.classList.add('slide--active');
      renderSlides();
      renderBtns();
   }
}
const renderSlides = () => {
   let slides = document.querySelectorAll('.slide');
   if(!slides) {
      return;
   }
   let activeSlide = document.querySelector('.slide--active');
   if(!activeSlide) {
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
   if(slider) {
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
<script>
function openCity(evt, cityName) {
   var i, tabcontent, tablinks;
   tabcontent = document.getElementsByClassName("tabcontent");
   for(i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
   }
   tablinks = document.getElementsByClassName("tablinks");
   for(i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
   }
   document.getElementById(cityName).style.display = "block";
   evt.currentTarget.className += " active";
}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
<script>
function myFunction() {
   var dots = document.getElementById("dots");
   var moreText = document.getElementById("more");
   var btnText = document.getElementById("myBtn");
   if(dots.style.display === "none") {
      dots.style.display = "inline";
      btnText.innerHTML = " more";
      moreText.style.display = "none";
   } else {
      dots.style.display = "none";
      btnText.innerHTML = " less";
      moreText.style.display = "inline";
   }
}
</script>
<script>
document.getElementById("btn").addEventListener("click", function() {
   document.getElementById("box").classList.toggle("act");
});
</script>
</body>

</html>