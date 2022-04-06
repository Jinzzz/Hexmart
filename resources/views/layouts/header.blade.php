<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}" />
   <link rel="stylesheet" href="{{URL::to('/assets/frontAssets/css/style.css')}}">
   <link rel="stylesheet" href="{{URL::to('/assets/frontAssets/css/bootstrap.css')}}">
   <link rel="stylesheet" href="{{URL::to('/assets/frontAssets/css/bootstrap.min.css')}}">
   <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="{{URL::to('/assets/frontAssets/css/responsive.css')}} ">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="preconnect" href="https://fonts.gstatic.com">
   <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;1,100&display=swap" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="{{URL::to('/assets/frontAssets/css/owl.carousel.min.css')}} ">
   <link rel="stylesheet" type="text/css" href="{{URL::to('/assets/frontAssets/css/owl.theme.default.min.css')}} ">
   <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
   <title>hexmart</title>
</head>

<body>
   <!------head-------->

   <head>
      <div class="container-fluid">
         <div class="topheader pt-3 pb-3">
            <div class="logo">
               <a href="index.html"> <img src="{{URL::to('/assets/frontAssets/image/logo.png')}}" class="img-fluid" alt=""></a>
            </div>
            <div class="top-searchbar">
               <form class="">
                  <input type="search" id="" class="Search-h form-control" placeholder="Search for product,brands and more">
                  <button type="submit" class="Search-btn"> <i class="fa fa-search"></i> </button>
               </form>
            </div>
            <div class="">
               <!-- <a href="{{url('/')}}" class="cart-head"> <i class="fa fa-home" aria-hidden="true" class="cart-top"></i> Home</a> -->
            </div>
            @if (Auth::guard('customer')->check())
            <div class="cart-account">
               <div class="dropdown d-down">
                  <button class="dropbtn">My Settings <i class="fa fa-angle-down" aria-hidden="true"></i></button>
                  <div class="dropdown-content drp-m"> 
                    <a href="{{url('/customer/My-Account')}}" >My Account</a>
                    <a href="{{url('/customer/My-Orders')}}" >My Orders</a>
                    <a href="{{url('/customer/wishlist')}}" >Wish List</a>
                     <a href="{{url('/customer/logout')}}" >logout</a> 
                     <!-- <a href="#">My Account</a>  -->
                  </div>
               </div>
            </div>
            @else
            <div class="cart-account">
               <div class="dropdown d-down pt-3">
                  <button class="dropbtn">My Account <i class="fa fa-angle-down" aria-hidden="true"></i></button>
                  <div class="dropdown-content drp-m"> 
                   <a href="{{url('/customer/register')}}">Register</a>
                   <a href="{{url('/customer/customer-login')}}">Login</a> 
                    
                  </div>
               </div>
            </div>
            @endif
            <div class="crt">
               <a href="{{url('/show-Cart')}}" class="cart-head"> <i class="fa fa-shopping-cart" aria-hidden="true" class="cart-top"></i>Cart<span class="badge badge-danger Cart-count"></span></a>
            </div>
         </div>
      </div>
      <!--------------end top header------->
      <nav class="main-nav-sec navbar navbar-expand-lg navbar-dark ">
         <div class="container-fluid">
            <button class="navbar-toggler menu-btn" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
            @inject('category', 'App\Models\admin\Mst_ItemCategory')

               <?php
               $navCategoryDetails = $category->select('item_category_id', 'category_name_slug', 'category_name', 'category_icon', 'category_description')
                ->where('is_active', 1)
                ->limit(5)
                ->get();
               ?>
            <div class="container collapse navbar-collapse" id="navbarNavDropdown">
               <ul class="navbar-nav">
                  <li class="nav-item active"> <a class="nav-link" href="#">TopOffers </a> </li> {{--
                  <li class="nav-item"><a class="nav-link" href="#"> Grocery </a></li>
                  <li class="nav-item"><a class="nav-link" href="#"> Mobiles </a></li> --}} @foreach ($navCategoryDetails as $cat)
                  <li class="nav-item dropdown has-megamenu"> <a class="nav-link dropdown-toggle" href="{{url('/home/product/'.$cat->category_name)}}" data-bs-toggle="dropdown"> {{ $cat->category_name }}  </a>
                     <div class="dropdown-menu  drop-list" aria-labelledby="navbarDropdownMenuLink">
                        <div class="roww"> @foreach (@$cat->itemSubCategoryL1Data as $subCatLOne)
                           <div class="column drp-list-content">
                              <a href="{{url('/home/subcatgeory').'/'.$subCatLOne->sub_category_name.'/'.$cat->category_name}}"><h3>{{ $subCatLOne->sub_category_name }}</h3></a>
                               @foreach ((new \App\Helpers\Helper)->itemSubCategoryL2Data($subCatLOne->item_sub_category_id) as $subCatLTwo) 
                              <a href="{{url('/home/mainsubcatgeory').'/'.$subCatLOne->sub_category_name.'/'.$cat->category_name.'/'.$subCatLTwo->iltsc_name}}">{{ $subCatLTwo->iltsc_name }}</a>
                               @endforeach </div> @endforeach </div>
                     </div>
                  </li> @endforeach {{--
                  <li class="nav-item dropdown has-megamenu"> <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"> Elecronics  </a>
                     <div class="dropdown-menu  drop-list" aria-labelledby="navbarDropdownMenuLink">
                        <div class="roww">
                           <div class="column drp-list-content">
                              <h3>Category 1</h3> <a href="#">Link 1</a> <a href="#">Link 2</a> <a href="#">Link 3</a> </div>
                           <div class="column drp-list-content">
                              <h3>Category 2</h3> <a href="#">Link 1</a> <a href="#">Link 2</a> <a href="#">Link 3</a> </div>
                        </div>
                     </div>
                  </li> --}} {{--
                  <li class="nav-item dropdown has-megamenu"> <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"> Home  </a>
                     <div class="dropdown-menu  drop-list" aria-labelledby="navbarDropdownMenuLink">
                        <div class="roww">
                           <div class="column drp-list-content">
                              <h3>Category 1</h3> <a href="#">Link 1</a> <a href="#">Link 2</a> <a href="#">Link 3</a> </div>
                           <div class="column drp-list-content">
                              <h3>Category 2</h3> <a href="#">Link 1</a> <a href="#">Link 2</a> <a href="#">Link 3</a> </div>
                           <div class="column drp-list-content">
                              <h3>Category 2</h3> <a href="#">Link 1</a> <a href="#">Link 2</a> <a href="#">Link 3</a> </div>
                        </div>
                     </div>
                  </li> --}} {{--
                  <li class="nav-item dropdown has-megamenu"> <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"> Appliances  </a>
                     <div class="dropdown-menu  drop-list" aria-labelledby="navbarDropdownMenuLink">
                        <div class="roww">
                           <div class="column drp-list-content">
                              <h3>Category 1</h3> <a href="#">Link 1</a> <a href="#">Link 2</a> <a href="#">Link 3</a> </div>
                           <div class="column drp-list-content">
                              <h3>Category 2</h3> <a href="#">Link 1</a> <a href="#">Link 2</a> <a href="#">Link 3</a> </div>
                        </div>
                     </div>
                  </li> --}} {{--
                  <li class="nav-item"><a class="nav-link" href="#"> Travel </a></li> --}} {{--
                  <li class="nav-item dropdown has-megamenu"> <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"> Beauty,Toys & More  </a>
                     <div class="dropdown-menu  drop-list" aria-labelledby="navbarDropdownMenuLink">
                        <div class="roww">
                           <div class="column drp-list-content">
                              <h3>Category 1</h3> <a href="#">Link 1</a> <a href="#">Link 2</a> <a href="#">Link 3</a> </div>
                           <div class="column drp-list-content">
                              <h3>Category 2</h3> <a href="#">Link 1</a> <a href="#">Link 2</a> <a href="#">Link 3</a> </div>
                           <div class="column drp-list-content">
                              <h3>Category 2</h3> <a href="#">Link 1</a> <a href="#">Link 2</a> <a href="#">Link 3</a> </div>
                           <div class="column drp-list-content">
                              <h3>Category 2</h3> <a href="#">Link 1</a> <a href="#">Link 2</a> <a href="#">Link 3</a> </div>
                        </div>
                     </div>
                  </li> --}} </ul>
            </div>
            <!-- navbar-collapse.// -->
         </div>
         <!-- container-fluid.// -->
      </nav>
      <!------------>
   <script src="{{URL::to('/assets/cart/js/cart.js')}} "></script>
