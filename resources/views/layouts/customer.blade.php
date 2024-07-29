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
   </head>
   <body>
   
   <div class="page-wrapper admin_page">
       <aside id="leftnav">
           
            <div class="logo">
                <img src="/img/freshhub_logo.png" class="header-logo" alt="Fresh Hub" title="Fresh Hub">
            </div>
            
            <p>Welcome {{$nameofuser}}</p>
        
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul>
                         <li class="nav-item"><a @if($submenu !="Dashboard") class="nav-link"  @else class="nav-link active" @endif href="{{customer_url('')}}">
                            Dashboard</a>
                        <!--<li class="nav-item dropdown"><a @if($title !="Dashboard") class="nav-link dropdown-toggle"  @else class="nav-link dropdown-toggle active" @endif href="{{admin_url('')}}" aria-current="page" role="button" data-bs-toggle="dropdown" aria-expanded="false">-->
                        <!--    Dashboard</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>-->
                        <!--    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">-->
                                 <!--<li><a @if($submenu=='Dashboard')  class="dropdown-item active" @else class="dropdown-item" @endif-->
                                 <!--      href="{{customer_url('')}}">Dashboard</a></li>-->
                                 <!--<li><a @if($submenu=='Profile')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{customer_url('profile')}}">Profile</a></li>-->
                                 <!-- <li><a @if($submenu=='Password')  class="dropdown-item active" @else class="dropdown-item" @endif-->
                                 <!--      href="{{customer_url('changepassword')}}">Change Password</a></li>-->
                            <!--</ul>-->
                        </li>
                        <li class="nav-item dropdown"><a  @if($title !="Order") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif  href="{{customer_url('orders')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sales & Financials</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <li><a @if($submenu=='Order')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{customer_url('orders')}}">All Orders</a></li>
                                 <li><a @if($submenu=='Invoice')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{customer_url('invoices')}}">Invoices</a></li>
                                 <li><a @if($submenu=='Backorder')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{customer_url('backorders')}}">Backorders</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown"><a  @if($title !="Message") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif href="{{customer_url('messages')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Messages</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <li><a @if($submenu=='Inbox')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{customer_url('messages')}}">Inbox</a></li>
                                 <li><a @if($submenu=='Compose')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{customer_url('compose')}}">Compose</a></li>
                                 <li><a @if($submenu=='Outbox')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{customer_url('outbox')}}">Sent Items</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown"><a @if($title !="Reports") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Reports</a><span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <li><a @if($submenu=='ReportBySale')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('customer/report/sale')}}">Sales</a></li>
                                 <li><a @if($submenu=='ReportByProduct')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('customer/report/product')}}">Products</a></li>
                            </ul>
                        </li>
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
                          
                          <div id="search" class="search headercolumn" style="display:none"><a href="#" class="search_button"><i class="fa fa-search"></i></a>
                          
                          <div class="togglesearch_form">
                              <form action="{{customer_url('search')}}" method="get">
                                   <input type="submit" value=""/>
                                    <input type="text" class="search-box" id="search-text" placeholder="Search" name="keyword" @if(isset(request()->keyword)) value="{{request()->keyword}}" @endif/>
                              
                               </form>
                        </div>
                          </div>
                          <div class="profile_notification headercolumn"><a href="#"><i class="fa fa-bell"></i></a></div>
                          <div class="settings headercolumn"><a href="#"><i class="fa fa-cog"></i></a></div>
                          <div class="profile_info headercolumn"><a href="#" class="profileoption_selector"><span class="profile_icon">{{substr($nameofuser,0,1)}}</span></a>
                          <div class="profileoption_window" style="display:none;">
                             <ul>
                                 <li><a href="{{customer_url('changepassword')}}">Change Password</a></li>
                                 <li> <a href="{{customer_url('profile')}}">Profile</a></li>
                                <li> <a href="{{admin_url('logout')}}">Logout</a></li>
                             </ul> 
                          </div>
                          </div>
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
    <script src="/js/extra.js"></script>
    <!-- JS and script files that related to this page -->
    <script>
    $(document).ready(function(){
        $("#menu-toggle").click(function(){
        $("#leftnav").toggle(300);
          $("main").css("width","100%");
         });
        $('.profileoption_selector').click(function() {
	$(this).next('.profileoption_window').slideToggle(0);
});
    });
     $(document).ready(function() {
     
    	$(".search_button").click(function() {
    	   $(".togglesearch_form").toggle();
    	   $("input[type='text']").focus();

    	 });
    	 $('body').delegate('.fh_link','click',function(e) {
        e.preventDefault();
    	$(this).next('.fh_dropdown').slideToggle(0);
    });
     
    });
  </script>
  <script>
$("#phone").inputmask({"mask": "(999) 999-9999"});
</script>
    <!-- General javascript -->
    @yield('bottom-scripts')
   </body>
</html>