<!doctype html>
<html lang="en" dir="ltr">
   <head>
      <head>
         <!-- META DATA -->
         <meta charset="UTF-8">
         <meta name="csrf-token" content="{{ csrf_token() }}">
         <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <!-- FAVICON -->
         <link rel="shortcut icon" type="image/x-icon" href="{{URL::to('/assets/uploads/favicon.png')}}" />
         <!-- TITLE -->
         <title>{{ __('Hex Mart | Administration') }}</title>
         <!-- BOOTSTRAP CSS -->
         <link href="{{URL::to('/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
         <!-- STYLE CSS -->
         <link href="{{URL::to('/assets/css/style.css')}}" rel="stylesheet"/>
         <link href="{{URL::to('/assets/css/skin-modes.css')}}" rel="stylesheet"/>
         <!-- SIDE-MENU CSS -->
         <link href="{{URL::to('/assets/plugins/sidemenu/closed-sidemenu.css')}}" rel="stylesheet">
         <!-- SINGLE-PAGE CSS -->
         <link href="{{URL::to('/assets/plugins/single-page/css/main.css')}}" rel="stylesheet" type="text/css">
         <!--C3 CHARTS CSS -->
         <link href="{{URL::to('/assets/plugins/charts-c3/c3-chart.css')}}" rel="stylesheet"/>
         <!-- CUSTOM SCROLL BAR CSS-->
         <link href="{{URL::to('/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>
         <!--- FONT-ICONS CSS -->
         <link href="{{URL::to('/assets/css/icons.css')}}" rel="stylesheet"/>
         <!-- COLOR SKIN CSS -->
         <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{URL::to('/assets/colors/color1.css')}}" />
      </head>
   </head>
   <body>
      <!-- BACKGROUND-IMAGE -->
      <div class="login-img">
         <!-- GLOABAL LOADER -->
         <div id="global-loader">
            <img src="{{URL::to('/assets/images/loader.svg')}}" class="loader-img" alt="Loader">
         </div>
         <!-- /GLOABAL LOADER -->
         <!-- PAGE -->
         <div class="page">
            <div class="">
               <!-- CONTAINER OPEN -->
               <div class="col col-login mx-auto">
                  <div class="text-center">
                     <img src="{{URL::to('/assets/front-end/image/logo-white.png')}}" class="header-brand-img" alt="">
                  </div>
               </div>
               <div class="container-login100">
                  <div class="wrap-login100 p-6" style="width:400px;">
                     <form method="POST" action="{{ route('login') }}" >
                        @csrf
                        <span class="login100-form-title">
                           {{ __('Admin Login') }}
                        </span>
                        @if(session('status'))
                        <div class="alert alert-success" id="err_msg">
                           <p>{{session('status')}}</p>
                        </div>
                        @endif
                        @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                        <p class="alert alert-danger">{{ $error }}</p>
                        @endforeach
                        @endif
                        @if (session()->has('message'))
                        <p class="alert alert-success">{{ session('message') }}</p>
                        @endif
                        <div class="wrap-input100 validate-input">
                           <input class="input100" id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" >
                           @error('name')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                        <div class="wrap-input100 validate-input">
                           <input class="input100" type="password" name="password" placeholder="Password" id="password" type="password" required autocomplete="current-password">
                           @error('password')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                           <span class="focus-input100"></span>
                        </div>
                        <div class="container-login100-form-btn">
                           <button type="submit" class="login100-form-btn btn-primary">
                           {{ __('Login') }}
                           </button>
                        </div>
                        <div class="container-login100-form-btn">
                           <button type="reset" class="login100-form-btn btn-danger">
                           {{ __('Clear') }}
                           </button><br>
                        </div>
                     </form>
                  </div>
               </div>
               <!-- CONTAINER CLOSED -->
            </div>
         </div>
         <!-- End PAGE -->
      </div>
      <!-- BACKGROUND-IMAGE CLOSED -->
      <!-- JQUERY JS -->
      <script src="{{URL::to('/assets/js/jquery-3.4.1.min.js')}}"></script>
      <!-- BOOTSTRAP JS -->
      <script src="{{URL::to('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{URL::to('/assets/plugins/bootstrap/js/popper.min.js')}}"></script>
      <!-- SPARKLINE JS -->
      <script src="{{URL::to('/assets/js/jquery.sparkline.min.js')}}"></script>
      <!-- CHART-CIRCLE JS -->
      <script src="{{URL::to('/assets/js/circle-progress.min.js')}}"></script>
      <!-- RATING STAR JS -->
      <script src="{{URL::to('/assets/plugins/rating/jquery.rating-stars.js')}}"></script>
      <!-- INPUT MASK JS -->
      <script src="{{URL::to('/assets/plugins/input-mask/jquery.mask.min.js')}}"></script>
      <!-- CUSTOM SCROLL BAR JS-->
      <script src="{{URL::to('/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
      <!-- CUSTOM JS-->
      <script src="{{URL::to('/assets/js/custom.js')}}"></script>
   </body>
</html>