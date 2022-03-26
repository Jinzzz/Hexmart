@include('layouts.header')

       <h3 style="text-align:center;font-weight: bold;"> No Products Fount</h3>


@include('layouts.footer')
<script src="{{URL::to('/assets/frontAssets/js/bootstrap.js')}} "></script>
<script src="{{URL::to('/assets/frontAssets/js/bootstrap.min.js')}} "></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
   document.getElementById("myDropdown1").classList.toggle("show");
}
// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
   if(!event.target.matches('.dropbtn1')) {
      var dropdowns = document.getElementsByClassName("dropdown-content1");
      var i;
      for(i = 0; i < dropdowns.length; i++) {
         var openDropdown = dropdowns[i];
         if(openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
         }
      }
   }
}
</script>
<script>
function getVals() {
   // Get slider values
   var parent = this.parentNode;
   var slides = parent.getElementsByTagName("input");
   var slide1 = parseFloat(slides[0].value);
   var slide2 = parseFloat(slides[1].value);
   // Neither slider will clip the other, so make sure we determine which is larger
   if(slide1 > slide2) {
      var tmp = slide2;
      slide2 = slide1;
      slide1 = tmp;
   }
   var displayElement = parent.getElementsByClassName("rangeValues1")[0];
   displayElement.innerHTML = "&#8377; " + slide1;
   var displayElement = parent.getElementsByClassName("rangeValues2")[0];
   displayElement.innerHTML = "&#8377;" + slide2;
}
window.onload = function() {
   // Initialize Sliders
   var sliderSections = document.getElementsByClassName("range-slider");
   for(var x = 0; x < sliderSections.length; x++) {
      var sliders = sliderSections[x].getElementsByTagName("input");
      for(var y = 0; y < sliders.length; y++) {
         if(sliders[y].type === "range") {
            sliders[y].oninput = getVals;
            // Manually trigger event first time to display values
            sliders[y].oninput();
         }
      }
   }
}
</script>
</body>

</html>