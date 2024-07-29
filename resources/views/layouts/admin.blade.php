<?php $nameofuser = auth()->user()->firstname.' '.auth()->user()->lastname; ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="url" id="first_segment_url"  content="admin.freshhub.ca//dashboard">
      <meta name="http_type" id="http_type" content="http://">
      <meta name="calendar" content="1">
      <meta name="calendar" id="page_calendar" content="1">
      <meta name="extension" content="">
      <meta name="base_url" content="http://admin.freshhub.ca" id="base_url"/>
      <meta name="csrf-token" content="VqrTYHLbqvpC5JpVxjjSD3hOft4NTqlfj62fdqPz"/>
      <meta name="route" content="dashboard.dashboardshow">
      <title>@yield('title','Freshhub')</title>
      <!-- general css -->

      <script src="/vendors/custom-elements/js/custom-elements.min.js?v=2.1"></script>
      <script src="/vendors/custom-elements/js/custom-elements.min.js?v=2.1"></script>
      <!-- css files that related to this page -->
      <link rel="stylesheet" href="/vendors/inputmask/css/inputmask.min.css?v=2.1">
      <!-- custom css -->
      <link rel="stylesheet" href="/vendors/flaticon/css/flaticon.css?v=2.1">
      <link rel="stylesheet" href="/css/main.min.css?v=2.1">
    
      <script src="https://use.fontawesome.com/d807f6cf05.js"></script>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
      <!-- favicon css -->
      <link rel="shortcut icon" href="/img/favicon/favicon.ico?v=2.1" type="image/x-icon">
      <link rel="icon" href="/img/favicon/favicon.ico?v=2.1" type="image/x-icon">
      <link rel="stylesheet" href="/css/style.css">
      @stack('styles')
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" />
      <style>
 /*         .dropdown:hover .dropdown-menu {*/
 /*   display: block;*/
  
 /*}*/
      </style>
   </head>
   <body>
   <div class="page-wrapper admin_page">
       <aside id="leftnav">
           
            <div class="logo">
                <a href="{{admin_url('')}}"><img src="/img/freshhub_logo.png" class="header-logo" alt="Fresh Hub" title="Fresh Hub"></a>
            </div>
            
            <p class="user-welcome-text">Welcome {{$nameofuser}}</p>
        
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul>
                        <li class="nav-item"><a @if($submenu !="Dashboard") class="nav-link"  @else class="nav-link active" @endif href="{{admin_url('')}}">
                            Dashboard</a>
                            <!--<ul class="dropdown-menu" aria-labelledby="navbarDropdown">-->
                                 <!--<li><a @if($submenu=='Dashboard')  class="dropdown-item active" @else class="dropdown-item" @endif-->
                                 <!--      href="{{admin_url('')}}">Dashboard</a></li>-->
                                 <!--<li><a @if($submenu=='Profile')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('profile')}}">Profile</a></li>-->
                                 <!-- <li><a @if($submenu=='Password')  class="dropdown-item active" @else class="dropdown-item" @endif-->
                                 <!--      href="{{admin_url('changepassword')}}">Change Password</a></li>-->
                            <!--</ul>-->
                        </li>
                        @can('Order View')
                        <li class="nav-item dropdown"><a  @if($title !="Order") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif  href="{{admin_url('orders')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sales & Financials</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <li><a @if($submenu=='Order')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('orders')}}">All Orders</a></li>
                                 @can('Purchase Order View')<li><a @if($submenu=='Purchase')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('purchaseorders')}}">Purchase Orders</a></li>@endcan
                                 @can('Invoices View')<li><a @if($submenu=='Invoice')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('invoices')}}">Invoices</a></li>@endcan
                                @can('Backorder View')<li><a @if($submenu=='Backorder')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('backorders')}}">Backorders</a></li>@endcan
                                <!--<li><a @if($submenu=='Runsheet')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('runsheets')}}">Runsheets</a></li>-->
                                <!--<li><a @if($submenu=='Generate Runsheet')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('getrunsheet')}}">Generate Runsheet</a></li>-->
                            </ul>
                        </li>
                        @endcan
                        @can('Delivery')
                        <li class="nav-item dropdown"><a  @if($title !="Deliveries") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif  href="{{url('admin/deliveries')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Deliveries</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                
                                <li><a @if($submenu=='Deliveries')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('deliveries')}}">Deliveries</a></li>
                                @can('Assign Driver')<li><a @if($submenu=='Runsheet')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('generaterunsheet')}}">Assign Drivers</a></li>@endcan
                            </ul>
                        </li>
                        @endcan
                        @can('Customer View')
                        <li class="nav-item dropdown"><a @if($title !="Customers") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif  href="{{url('admin/customers')}}" aria-current="page" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Customers</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <li><a @if($submenu=='All')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/customers')}}">All Customers</a></li>
                                 <li><a @if($submenu=='Active')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/customers/getcust/1')}}">Active Customers</a></li>
                                 <li><a @if($submenu=='Inactive')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/customers/getcust/0')}}">Inactive Customers</a></li>
                                 <li><a @if($submenu=='customertype')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/customertype')}}">Customer Types</a></li>
                            </ul>
                        </li>
                        @endcan
                        @can('View Product')
                        <li class="nav-item dropdown"><a   @if($title !="Products") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif class="nav-link dropdown-toggle" href="{{url('admin/products')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 
                                 <li><a @if($submenu=='Products')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/products')}}">Products</a></li>
                                 @can('Category View')<li><a @if($submenu=='Category')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/categories')}}">Categories</a></li>@endcan
                            </ul>
                        </li>
                        @endcan
                        @can('Inventory View')
                        <li class="nav-item"><a @if($submenu !="Inventory") class="nav-link " @else class="nav-link active" @endif href="{{url('admin/inventories')}}">Inventories</a></li>
                        @endcan
                        <li class="nav-item dropdown"><a @if($title !="Reports") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Reports</a><span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <li><a @if($submenu=='ReportByCustomer')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/report/customer')}}">Customers</a></li>
                                 <li><a @if($submenu=='ReportBySale')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/report/sale')}}">Sales</a></li>
                                 <!--<li><a @if($submenu=='Emails')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/emails')}}">Emails</a></li>-->
                                 <li><a @if($submenu=='ReportByProduct')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/report/product')}}">Products</a></li>
                                 <!--<li><a @if($submenu=='Weight')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/weight')}}">Weight</a></li>-->
                            </ul>
                        </li>
                        @can('Staff View')
                        <li class="nav-item"><a @if($submenu !="Staffs") class="nav-link " @else class="nav-link active" @endif href="{{url('admin/staffs')}}">Staffs</a></li>
                        @endcan
                        <li class="nav-item dropdown"><a  @if($title !="Message") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif href="{{admin_url('messages')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Messages</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <li><a @if($submenu=='Inbox')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('messages')}}">Inbox</a></li>
                                 <li><a @if($submenu=='Compose')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('compose')}}">Compose</a></li>
                                 <li><a @if($submenu=='Outbox')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('outbox')}}">Sent Items</a></li>
                            </ul>
                        </li>
                        @can('Settings')
                        <li class="nav-item dropdown"><a  @if($title !="Settings") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif href="{{url('admin/configuration')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Configuration</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 @can('Settings')<li><a @if($submenu=='Configuration')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/configuration')}}">Settings</a></li>@endcan
                                 @can('Roles And Permissions')<li><a @if($submenu=='Roles')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/roles')}}">Roles & Permissions</a></li>@endcan
                                 <!--<li><a @if($submenu=='Emails')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/emails')}}">Emails</a></li>-->
                                @can('UnitType List')<li><a @if($submenu=='Unit Type')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/unittype')}}">Unit Types</a></li>@endcan
                                @can('Weight')<li><a @if($submenu=='Weight')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/weight')}}">Weight</a></li>@endcan
                            </ul>
                        </li>
                        @endcan
                       <!--<li class="nav-item dropdown"><a  @if($title !="Inventories") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif href="{{url('admin/inventories')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">-->
                       <!--     Inventories</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>-->
                       <!--     <ul class="dropdown-menu" aria-labelledby="navbarDropdown">-->
                                 <!--<li><a @if($submenu=='Warehouses')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/warehouses')}}">Warehouses</a></li>-->
                                 <!--<li><a @if($submenu=='Inventory')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/inventories')}}">Inventories</a></li>-->
                                 <!--<li><a @if($submenu=='Stock')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/inventories/current-stock')}}">Stock</a></li>-->
                       <!--     </ul>-->
                       <!-- </li>-->
                        
                        
                        <!--<li class="nav-item"><a @if($submenu !="Deliveries") class="nav-link " @else class="nav-link active" @endif href="{{admin_url('deliveries')}}">Deliveries</a></li>-->
                        
                        <!--<li class="nav-item"><a @if($submenu !="Deliveries") class="nav-link " @else class="nav-link active" @endif href="{{url('admin/deliveries')}}">Deliveries</a></li>-->
                        <!--<li class="nav-item"><a @if($submenu !="Routes") class="nav-link " @else class="nav-link active" @endif href="{{url('admin/routes')}}">Routes</a></li>-->
                        
                        
                        
                    </ul>  
                 </div>

            </nav>
       </aside>
       <main>
           
           <div class="page">
               <header>
                    <div class="headertop">
                      <div class="headertop-left"><div id="menu-toggle"><i class="fa fa-bars"></i></div></div>
                      <div class="headertop-right">
                          <div class="helpbutton headercolumn"><a href="#"><i class="fa fa-question-circle"></i> &nbsp; Help</a></div>
                          
                          <div id="search" class="search headercolumn"><a href="#" class="search_button"><i class="fa fa-search"></i></a>
                          <!-- <form action="{{admin_url('search')}}" method="get">-->
                          <!--<input type="text" id="search-text" name="keyword" @if(isset(request()->keyword)) value="{{request()->keyword}}" @endif>-->
                          <!--</form>-->
                          <div class="togglesearch_form">
                              <form action="{{admin_url('search')}}" method="get">
                                  <input type="submit" value=""/>
                                 <!--<input type="submit" value="Search"/>-->
                                    <input type="text" class="search-box" id="search-text" placeholder="Product name,Customer name or Category Name" name="keyword" @if(isset(request()->keyword)) value="{{request()->keyword}}" @endif/>
                              
                               </form>
                        </div>
                          </div>
                          <div class="profile_notification headercolumn"><a href="#"><i class="fa fa-bell"></i></a></div>
                          <div class="settings headercolumn"><a href="{{url('admin/configuration')}}"><i class="fa fa-cog"></i></a></div>
                        
                           <div class="profile_info headercolumn"><a href="#" class="profileoption_selector"><span class="profile_icon">{{substr($nameofuser,0,1)}}</span></a>
                          <div class="profileoption_window" style="display:none;">
                             <ul>
                                 <a href="{{admin_url('changepassword')}}"><li>Change Password</li></a>
                                 <a href="{{admin_url('profile')}}"><li>Profile</li></a>
                                 <a href="{{admin_url('logout')}}"><li>Logout</li></a>
                             </ul> 
                          </div>
                          </div>
                       <div class="clearfix"></div>
                      </div>
                   </div>
                   <div class="page_title">
                        <h2>@yield('page_title')</h2>
                    </div>
                    <div class="page_nav">
                        @yield('page_nav')
                    </div>
                   @yield('header')
               </header>
               
               <section class="page-contents">
                    @yield('contents')
               </section>
               
           </div>
           
           <footer>
               <p>Developed by <a href="https://indigitalgroup.ca/" target="_blank">INDigital Group</a></p>
           </footer>
      </main>
       
    </div>   

    <script src="/js/app.js?id=6cb5d7cc395147fc2fd4"></script>
    <script src="/vendors/jquery/js/jquery.min.js?v=2.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="/vendors/vue/js/vue.min.js?v=2.1"></script>
    <!-- JS Files that related to this page -->
    <script src="/vendors/inputmask/js/jquery.inputmask.bundle.min.js?v=2.1"></script>
    <script src="/vendors/chartjs-funnel/js/chart.funnel.min.js?v=2.1"></script>
    <!-- main shared script -->
    <script src="/js/main.min.js?v=2.1"></script>
    <script src="{{ asset('js/extra.js') }}"></script>
    <!-- JS and script files that related to this page -->
    <script>
    $(document).ready(function(){
        $("#menu-toggle").click(function(){
        $("#leftnav").toggle(300);
        $("main").css("width","100%");
         });

    });
  $('.profileoption_selector').click(function() {
	$(this).next('.profileoption_window').slideToggle(0);
}); 
    $(document).ready(function() {
    	$(".search_button").click(function() {
    	   $(".togglesearch_form").toggle();
    	   $("input[type='text']").focus();
    	});
    });
    
    $('body').delegate('.fh_link','click',function(e) {
        e.preventDefault();
    	$(this).next('.fh_dropdown').slideToggle(0);
    });
    
    
$( ".dropdown-menu" ).css('margin-top',0);
$( ".dropdown" )
  .mouseover(function() {
    $( this ).addClass('show').attr('aria-expanded',"true");
    $( this ).find('.dropdown-menu').addClass('show');
  })
  .mouseout(function() {
    $( this ).removeClass('show').attr('aria-expanded',"false");
    $( this ).find('.dropdown-menu').removeClass('show');
  });
  </script>
  <script>
$("#phone").inputmask({"mask": "(999) 999-9999"});
</script>
   
    <!-- General javascript -->
    @yield('bottom-scripts')
   </body>
</html>