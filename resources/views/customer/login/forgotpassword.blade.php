@include('layouts.header')
<section class="myorder-sec bg-gray">
   <div class="container-fluid text-center">
      <div class="myacc-container">
         <div class="myaddress">
            <form class="myaccntfrm" action="{{url('/customer/forgot-password-store')}}" method="POST">
               @csrf
               @if(session('status'))
                <div class="alert alert-success" id="err_msg">
                <p>{{session('status')}}</p>
                </div> @endif @if (count($errors) > 0) @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p> @endforeach @endif @if (session()->has('message'))
                <p class="alert alert-success">{{ session('message') }}</p> @endif
               <div class="row">
                  <div class="col-lg-12">
                     <input type="email" placeholder="Email (Required)*" name="customer_email" required="" autocomplete="off"> @error('customer_email') <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span> @enderror
                    </div>
                  
               </div>
            
            <div class="btnsupdatecamcel">
               <button type="submit">Send Password Link</button>
            </div>
            </form>
         </div>
      </div>
   </div>
</section>
<!-------end----->@include('layouts.footer') </body>

</html>