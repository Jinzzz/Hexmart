@extends('admin.layouts.app')
@section('content')
 
   <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
      <div class="row">

         <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card">
               <a href="{{ route('admin.products') }}">
                    <div class="card-body text-center statistics-info">
                        <div class="counter-icon bg-primary mb-0 box-primary-shadow">
                            <i class="fa fa-product-hunt text-white"></i>
                        </div>
                        <h6 class="mt-4 mb-1">{{ __('Products') }}</h6>
                        <h2 class="mb-2 number-font">
                           {{ (new \App\Helpers\Helper)->totalProductCount() }}</h2>
                        <p class="text-muted">{{ __('Total Products ') }}</p>
                    </div>
               </a>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
         <div class="card">
            {{-- <a href="{{ url('store/today-order/list') }}"> --}}
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-warning mb-0 box-info-shadow">
                                    <i class="fe fe-trending-up text-white"></i>
                  </div>
                     <h6 class="mt-4 mb-1">{{ __('Today\'s Sales') }}</h6>
                     <h2 class="mb-2 number-font">	<i class="fa fa-rupee"></i> 
                        {{ (new \App\Helpers\Helper)->todaySales() }} 
                     </h2>
                     <p class="text-muted">{{ __('Today\'s Sales Amount ') }}</p>
                 </div>
            </a>
         </div>
     </div>


    <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
         <div class="card">
            {{-- <a href="{{ route('store.store_visit_reports') }}"> --}}
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-success mb-0 box-info-shadow">
                                    <i class="fe fe-trending-up text-white"></i>
                  </div>
                     <h6 class="mt-4 mb-1">{{ __('Today\'s Visit') }}</h6>
                     <h2 class="mb-2 number-font"> 
                        {{ (new \App\Helpers\Helper)->todayCustomerVisit() }} 
                     </h2>
                     <p class="text-muted">{{ __('Today\'s Customer Visit ') }}</p>
                 </div>
            </a>
         </div>
     </div>
     
     
      <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
         <div class="card">
            {{-- <a href="{{ route('store.store_visit_reports') }}"> --}}
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-primary mb-0 box-info-shadow">
                                    <i class="fe fe-trending-up text-white"></i>
                  </div>
                     <h6 class="mt-4 mb-1">{{ __('Weekly Visit') }}</h6>
                     <h2 class="mb-2 number-font"> 
                        {{ (new \App\Helpers\Helper)->weeklySales() }} 
                     </h2>
                     <p class="text-muted">{{ __('Weekly Customer Visit ') }}</p>
                 </div>
            </a>
         </div>
     </div>
     
     
    



        <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card">
               {{-- <a href="{{ route('store.current_issues') }}"> --}}
                  <div class="card-body text-center statistics-info">
                     <div class="counter-icon bg-warning mb-0 box-info-shadow">
													<i class="fa fa-comments text-white"></i>
							</div>
                        <h6 class="mt-4 mb-1">{{ __('Current Issues') }}</h6>
                        <h2 class="mb-2 number-font">
                           {{ (new \App\Helpers\Helper)->currentIssues() }} 
                        </h2>
                        <p class="text-muted">{{ __('Current Issues Count ') }}</p>
                    </div>
               </a>
            </div>
        </div>

         <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card">
               {{-- <a href="{{ route('store.new_issues') }}"> --}}
                  <div class="card-body text-center statistics-info">
                     <div class="counter-icon bg-danger mb-0 box-info-shadow">
													<i class="fa fa-comments text-white"></i>
							</div>
                        <h6 class="mt-4 mb-1">{{ __('New Issues') }}</h6>
                        <h2 class="mb-2 number-font">
                           {{ (new \App\Helpers\Helper)->newIssues() }} 
                        </h2>
                        <p class="text-muted">{{ __('New Issues Count') }}</p>
                    </div>
               </a>
            </div>
        </div>

  <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card">
               {{-- <a href="{{ route('store.list_product') }}"> --}}
                  <div class="card-body text-center statistics-info">
                     <div class="counter-icon bg-danger mb-0 box-info-shadow">
													<i class="fa fa-comments text-white"></i>
							</div>
                        <h6 class="mt-4 mb-1">{{ __(' Categories') }}</h6>
                        <h2 class="mb-2 number-font">
                           {{ (new \App\Helpers\Helper)->totalCategories() }} 
                        </h2>
                        <p class="text-muted">{{ __('Total Categories Count') }}</p>
                    </div>
               </a>
            </div>
        </div>


  <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card">
               {{-- <a href="{{ url('store/delivery-boys/list') }}"> --}}
                  <div class="card-body text-center statistics-info">
                     <div class="counter-icon bg-info mb-0 box-info-shadow">
													<i class="ti ti-truck text-white"></i>
							</div>
                        <h6 class="mt-4 mb-1">{{ __('Delivery Boys') }}</h6>
                        <h2 class="mb-2 number-font"> 
                           {{ (new \App\Helpers\Helper)->deliveryBoysCount() }} 
                        </h2>
                        <p class="text-muted">{{ __('Delivery Boys Count ') }}</p>
                    </div>
               </a>
            </div>
        </div>



      


   <!-- COL END -->
   {{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xl-6"> --}}


      <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
         <div class="card">
            {{-- <a href="{{ url('store/today-order/list') }}"> --}}
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-cyan mb-0 box-info-shadow">
                                    <i class="fa fa-calendar text-white"></i>
                  </div>
                     <h6 class="mt-4 mb-1">{{ __('Daily Sales') }}</h6>
                     <h2 class="mb-2 number-font">	 
                        {{ (new \App\Helpers\Helper)->dailySales() }} 
                     </h2>
                     <p class="text-muted">{{ __('Daily Sales Count ') }}</p>
                 </div>
            </a>
         </div>
     </div>




  <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card">
               {{-- <a href="{{ route('store.list_order') }}"> --}}
                  <div class="card-body text-center statistics-info">
                     <div class="counter-icon bg-info mb-0 box-info-shadow">
													<i class="fe fe-trending-up text-white"></i>
							</div>
                        <h6 class="mt-4 mb-1">{{ __('Total Sales') }}</h6>
                        <h2 class="mb-2 number-font">	<i class="fa fa-rupee"></i> 
                           {{ (new \App\Helpers\Helper)->totalSales() }} 
                        </h2>
                        <p class="text-muted">{{ __('Total Sales Amount ') }}</p>
                    </div>
               </a>
            </div>
        </div>
        
        
         <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
         <div class="card">
            {{-- <a href="{{ route('store.store_visit_reports') }}"> --}}
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-secondary mb-0 box-info-shadow">
                                    <i class="fe fe-trending-up text-white"></i>
                  </div>
                     <h6 class="mt-4 mb-1">{{ __('Monthly Visit') }}</h6>
                     <h2 class="mb-2 number-font"> 
                        {{ (new \App\Helpers\Helper)->monthlyVisit() }} 
                     </h2>
                     <p class="text-muted">{{ __('Monthly Customer Visit ') }}</p>
                 </div>
            </a>
         </div>
     </div>


        <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
         <div class="card">
            {{-- <a href="{{ route('store.list_disputes') }}"> --}}
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-primary mb-0 box-info-shadow">
                                    <i class="fa fa-comments text-white"></i>
                  </div>
                     <h6 class="mt-4 mb-1">{{ __('Issues') }}</h6>
                     <h2 class="mb-2 number-font">
                        {{ (new \App\Helpers\Helper)->totalIssues() }} 
                     </h2>
                     <p class="text-muted">{{ __('Total Issues ') }}</p>
                 </div>
            </a>
         </div>
     </div>

        <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
         <div class="card">
            {{-- <a href="{{ route('store.list_order') }}"> --}}
               <div class="card-body text-center statistics-info">
               <div class="counter-icon bg-secondary mb-0 box-secondary-shadow">
                  <i class="fe fe-codepen text-white"></i>
               </div>
               <h6 class="mt-4 mb-1">{{ __('Orders') }}</h6>
               <h2 class="mb-2 number-font">
                  {{ (new \App\Helpers\Helper)->totalOrder() }} 
               </h2>
               <p class="text-muted">{{ __('Total Orders') }}</p>
            </div>
            </a>
         </div>
      </div>

       
    </div>

  </div> 

    {{-- </div> --}}





</div>

</div>

<!-- ROW-1 END -->
</div>

</div>
<!-- CONTAINER END -->
</div>



<script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js"></script>
<script>
  // var firebaseConfig = {
  //    apiKey: "AIzaSyABJjLKVYHKL020Zdi8pbHsNS2ZLQ1Ka4Q",
  //   authDomain: "yellowstore-web-application.firebaseapp.com",
  //   projectId: "yellowstore-web-application",
  //   storageBucket: "yellowstore-web-application.appspot.com",
  //   messagingSenderId: "444886856017",
  //   appId: "1:444886856017:web:935481722416346323e370",
  //   measurementId: "G-VX5SKTNN3F"
  // };
      
  //   firebase.initializeApp(firebaseConfig);
  //   const messaging = firebase.messaging();
  
  // document.addEventListener("DOMContentLoaded", function(){

  //           messaging
  //           .requestPermission()
  //           .then(function () {
  //             //  console.log("working");
  //               return messaging.getToken({ vapidKey: 'BA6V328NpU3KBKusQbV067G1jKrBpypf1KmnNd21d5wt8gYmHDJIOFUvs0UeYGE1KvTrntnSTkBy3Otg0VQUFmc' });
  //           })
  //           .then(function(token) {
  //              // console.log(token);
  //    var _token = $('input[name="_token"]').val();

  //     $.ajax({
  //           url:"{{ url('store.saveBrowserToken') }}",
  //           method:"POST",
  //           data:{token:token, _token:_token},
  //           success:function(result)
  //           {
  //              // console.log(result);
  //           }
  //      })         
  
  //           }).catch(function (err) {
  //               console.log('User Chat Token Error'+ err);
  //           });
  // });      
  //   messaging.onMessage(function(payload) {
  //       const noteTitle = payload.notification.title;
  //       const noteOptions = {
  //           body: payload.notification.body,
  //           icon: payload.notification.icon,
  //       };
  //       new Notification(noteTitle, noteOptions);
  //   });
   
</script>

@endsection
