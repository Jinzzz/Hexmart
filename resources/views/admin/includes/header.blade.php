<!-- Mobile Header -->
<div class="mobile-header">
   <div class="container-fluid">
      <div class="d-flex">
         <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a><!-- sidebar-toggle-->
         <a class="header-brand" href="index.html">
         <img src="{{URL::to('/assets/frontAssets/image/logo.png')}}" class="header-brand-img desktop-logo" alt="logo">
         <img src="{{URL::to('/assets/frontAssets/image/logo.png')}}" class="header-brand-img desktop-logo mobile-light" alt="logo">
         </a>
         <div class="d-flex order-lg-2 ml-auto header-right-icons">
            <button class="navbar-toggler navresponsive-toggler d-md-none" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
               aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon fe fe-more-vertical text-white"></span>
            </button>
            <div class="dropdown profile-1">
               <a href="#" data-toggle="dropdown" class="nav-link pr-2 leading-none d-flex">
               <span>
               <img src="{{URL::to('/assets/images/users/10.jpg')}}" alt="profile-user" class="avatar  profile-user brround cover-image">
               </span>
               </a>
               <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                  <div class="drop-heading">
                     <div class="text-center">
                        <h5 class="text-dark mb-0">Name</h5>
                        <small class="text-muted">Email</small>
                     </div>
                  </div>
                  <div class="dropdown-divider m-0"></div>
                  <a class="dropdown-item" href="#">
                  <i class="dropdown-icon mdi mdi-account-outline"></i> {{ __('Profile') }}
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="login.html">
                  <i class="dropdown-icon mdi  mdi-logout-variant"></i>{{ __('Sign out')}} 
                  </a>
               </div>
            </div>
            <div class="dropdown d-md-flex header-settings">
               <a href="#" class="nav-link icon " data-toggle="sidebar-right" data-target=".sidebar-right">
               <i class="fe fe-align-right"></i>
               </a>
            </div>
            <!-- SIDE-MENU -->
         </div>
      </div>
   </div>
</div>
<div class="mb-1 navbar navbar-expand-lg  responsive-navbar navbar-dark d-md-none bg-white">
   <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
      <div class="d-flex order-lg-2 ml-auto">
         {{-- <div class="dropdown d-sm-flex">
            <a href="#" class="nav-link icon" data-toggle="dropdown">
            <i class="fe fe-search"></i>
            </a>
            <div class="dropdown-menu header-search dropdown-menu-left">
               <div class="input-group w-100 p-2">
                  <input type="text" class="form-control " placeholder="Search....">
                  <div class="input-group-append ">
                     <button type="button" class="btn btn-primary ">
                     <i class="fa fa-search" aria-hidden="true"></i>
                     </button>
                  </div>
               </div>
            </div>
         </div> --}}
         <!-- SEARCH -->
{{--          <div class="dropdown d-md-flex">
            <a class="nav-link icon full-screen-link nav-link-bg">
            <i class="fe fe-maximize fullscreen-button"></i>
            </a>
         </div> --}}
         <!-- FULL-SCREEN -->
      </div>
   </div>
</div>
<!-- /Mobile Header -->
<!--app-content open-->
<div class="app-content">
<div class="side-app">
<!-- PAGE-HEADER -->
<div class="page-header">
   <a aria-label="Hide Sidebar" class="app-sidebar__toggle close-toggle" data-toggle="sidebar" href="#"></a><!-- sidebar-toggle-->
   <div>
      <h1 class="page-title">{{ __('Hex Mart') }}</h1>
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="#">Home</a></li>
         <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
      </ol>
   </div>
   <div class="d-flex  ml-auto header-right-icons header-search-icon">
     {{--  <div class="dropdown d-sm-flex">
         <a href="#" class="nav-link icon" data-toggle="dropdown">
         <i class="fe fe-search"></i>
         </a>
         <div class="dropdown-menu header-search dropdown-menu-left">
            <div class="input-group w-100 p-2">
               <input type="text" class="form-control " placeholder="Search....">
               <div class="input-group-append ">
                  <button type="button" class="btn btn-primary ">
                  <i class="fa fa-search" aria-hidden="true"></i>
                  </button>
               </div>
            </div>
         </div>
      </div> --}}
      <!-- SEARCH -->
      <div class="dropdown d-md-flex header-settings">
         <ul class="nav  nav-pills-circle" style="justify-content: center;">
        
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Logout">
               <a class="nav-link text-center m-2" href="{{ route('logout') }}" onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
                 <i class="fe fe-power"></i>
               </a>
               <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                 @csrf
               </form>
             </li>
             <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Profile">
               <a class="nav-link text-center m-2" href=" {{ route('admin.profile') }} " >
                 <i class="fe fe-user"></i>
               </a>
     
             </li>
          </ul>

         {{-- <a href="#" class="nav-link icon " data-toggle="sidebar-right" data-target=".sidebar-right">
         <i class="fe fe-align-right"></i>
         </a> --}}
      </div>
      <!-- SIDE-MENU -->
   </div>
</div>

<div id="global-loader" style="display:none;  margin: auto; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(243, 243, 243); z-index: 30001; opacity: 0.8;">
   <div class="dimmer active">
       <div class="lds-hourglass"></div>
   </div>
</div>
<!-- PAGE-HEADER END -->