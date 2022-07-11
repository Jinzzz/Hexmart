<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

   <!--/APP-SIDEBAR-->
   <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
   <aside class="app-sidebar">
      <div class="side-header">
         <a class="header-brand1 " href="#">
            <img src="{{URL::to('/assets/uploads/logo.png')}}" class="header-brand-img desktop-logo" alt="logo">
            <img src="{{URL::to('/assets/uploads/logo.png')}}" class="header-brand-img toggle-logo" alt="logo">
            <img src="{{URL::to('/assets/uploads/logo.png')}}" class="header-brand-img light-logo" alt="logo">
            <img src="{{URL::to('/assets/uploads/logo.png')}}" class="header-brand-img light-logo1" alt="logo">
            </a><!-- LOGO -->
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle ml-auto" data-toggle="sidebar" href="#"></a><!-- sidebar-toggle-->
         </div>
         <div class="app-sidebar__user">
            <div class="dropdown user-pro-body text-center">
               <div class="user-pic">
                  <img src="{{URL::to('/assets/uploads/admin.png')}}" alt="user-img" class="avatar-xl rounded-circle">
               </div>
               <div class="user-info">
                 {{--  <h6 class=" mb-0 text-dark">{{Auth::user()->name}}</h6> --}}
                  <span class="text-muted app-sidebar__user-name text-sm">{{  auth()->user()->name }}</span>
               </div>
            </div>
         </div>
       
         
         <ul class="side-menu">
            <li><h3>Main</h3></li>
            <li class="slide">
               <a class="side-menu__item" href="{{ route('admin.home') }}"><i class="side-menu__icon ti-shield"></i><span class="side-menu__label">Dashboard</span></a>
            </li>
            
            <li><h3>Components</h3></li>
            
            <li class="slide">
               <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-home"></i><span class="side-menu__label">{{ __('Masters') }}</span><i class="angle fa fa-angle-right"></i></a>
               <ul class="slide-menu">
                  <li><a class="slide-item" href="{{ route('admin.units') }}">{{ __('Units') }}</a></li>
                  <li><a class="slide-item" href="{{ route('admin.item_category') }}">{{ __('Category') }}</a></li>
                  <li><a class="slide-item" href="{{ route('admin.item_sub_category') }}">{{ __('Sub Category Level One') }}</a></li>
                  <li><a class="slide-item" href="{{ route('admin.iltsc') }}">{{ __('Sub Category Level Two') }}</a></li>
                  <li><a class="slide-item" href="{{ route('admin.brands') }}">{{ __('Brands') }}</a></li>
                  <li><a class="slide-item" href="{{ route('admin.list_taxes') }}">{{ __('Tax') }}</a></li>
                  <li><a class="slide-item" href="{{ route('admin.attribute_group') }}">{{ __('Attribute Group') }}</a></li>
                  <li><a class="slide-item" href="{{ route('admin.attribute_value') }}">{{ __('Attribute Value') }}</a></li>
                  <li><a class="slide-item" href="{{ route('admin.issues') }}">{{ __('Issues') }}</a></li>
               </ul>
            </li>

           
            

            <li class="slide">
               <a class="side-menu__item" href="{{ route('admin.customers') }}">
                  <i class="side-menu__icon ti-face-smile"></i>
                  <span class="side-menu__label">Customers</span></a>
            </li>


            <li class="slide">
               <a class="side-menu__item"  data-toggle="slide" href="#">
                  <i class="side-menu__icon fe fe-users"></i>
                  <span class="side-menu__label">{{ __('Customer Group') }}</span>
                  <i class="angle fa fa-angle-right"></i>
               </a>
               <ul class="slide-menu">
                  <li><a class="slide-item" href="{{ route('admin.customer_groups') }}">{{ __('Customers Groups') }}</a></li>
                  <li><a class="slide-item" href="{{ route('admin.customer_group_customers') }}">{{ __('Customer Group Customers') }}</a></li>
               </ul>
            </li>

            
            <li class="slide">
               <a class="side-menu__item"  data-toggle="slide" href="#">
                  <i class="side-menu__icon ti-package"></i>
                  <span class="side-menu__label">{{ __('Products') }}</span>
                  <i class="angle fa fa-angle-right"></i>
               </a>
               <ul class="slide-menu">
                  <li><a class="slide-item" href="{{ route('admin.products') }}">{{ __('Products') }}</a></li>
                  <li><a class="slide-item" href="{{ route('admin.inventory') }}">{{ __('Inventory') }}</a></li>
               </ul>
            </li>

            <li class="slide">
               <a class="side-menu__item" href="{{ route('admin.offers') }}">
                  <i class="side-menu__icon fa fa-tags"></i>
                  <span class="side-menu__label">Offer Zone</span></a>
            </li>

            <li class="slide">
               <a class="side-menu__item" href="{{ route('admin.orders') }}">
                  <i class="side-menu__icon fe fe-shopping-cart"></i>
                  <span class="side-menu__label">Orders</span></a>
            </li>

             <li class="slide">
               <a class="side-menu__item" href="{{ route('admin.delivery_boys') }}">
                  <i class="side-menu__icon  ti ti-truck"></i>
                  <span class="side-menu__label">Delivery Boys</span></a>
            </li>


             <li class="slide">
               <a class="side-menu__item"  data-toggle="slide" href="#">
                  <i class="side-menu__icon ti-gift"></i>
                  <span class="side-menu__label">{{ __('Loyalty Programs') }}</span>
                  <i class="angle fa fa-angle-right"></i>
               </a>
               <ul class="slide-menu">
                  <li><a class="slide-item" href="{{ route('admin.configure_points') }}">{{ __('Configure Points') }}</a></li>
                  <li><a class="slide-item" href="{{ route('admin.customer_rewards') }}">{{ __('Customer Rewards') }}</a></li>
               </ul>
            </li>


            <li class="slide">
               <a class="side-menu__item" href="{{ route('admin.list_coupon') }}">
                  <i class="side-menu__icon fe fe-grid"></i>
                  <span class="side-menu__label">Coupons</span></a>
            </li>

            <li class="slide">
               <a class="side-menu__item"  data-toggle="slide" href="#">
                  <i class="side-menu__icon ti-settings"></i>
                  <span class="side-menu__label">{{ __('Settings') }}</span>
                  <i class="angle fa fa-angle-right"></i>
               </a>
               <ul class="slide-menu">
                  <li><a class="slide-item" href="{{ route('admin.settings') }}">{{ __('Admin settings') }}</a></li>
                  <li><a class="slide-item" href="{{ route('admin.working_days') }}">{{ __('Working Days') }}</a></li>
               </ul>
            </li>

            <li class="slide">
               <a class="side-menu__item" href="{{ route('admin.customer_banners') }}">
                  <i class="side-menu__icon fe fe-airplay"></i>
                  <span class="side-menu__label">Customer Banner</span></a>
            </li>

         
            

            <li class="slide">
               <a class="side-menu__item" href="{{ route('admin.disputes') }}">
                  <i class="side-menu__icon  fe fe-alert-triangle"></i>
                  <span class="side-menu__label">Disputes</span></a>
            </li>
            
         </ul>
         
      </aside>
      <!--/APP-SIDEBAR-->