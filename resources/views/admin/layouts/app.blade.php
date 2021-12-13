<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      @include('admin.includes.head')
   </head>
   <body class="app sidebar-mini">
      <!-- GLOBAL-LOADER -->
      {{-- 
      <div id="global-loader">
         <img src="{{URL::to('/assets/images/loader.svg')}}" class="loader-img" alt="Loader">
      </div>
      --}}
      <!-- /GLOBAL-LOADER -->
      <div id="app" class="page">
         <div class="page-main">
            @include('admin.includes.sidebar')
            @include('admin.includes.header')
            @section('content')
            @show
            @include('admin.includes.footer')
         </div>
      </div>
   </body>
</html>