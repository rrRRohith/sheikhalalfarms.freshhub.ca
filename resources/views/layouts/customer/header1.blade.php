<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="url" id="first_segment_url"
         content="admin.freshhub.ca//dashboard">
      <meta name="http_type" id="http_type" content="http://">
      <meta name="calendar" content="1">
      <meta name="calendar" id="page_calendar" content="1">
      <meta name="extension" content="">
      <meta name="base_url" content="http://admin.freshhub.ca" id="base_url"/>
      <meta name="csrf-token" content="VqrTYHLbqvpC5JpVxjjSD3hOft4NTqlfj62fdqPz"/>
      <meta name="route" content="dashboard.dashboardshow">
      <title>{{$title ?? 'Freshhub'}}</title>
      <!-- general css -->
      <link rel="stylesheet"
         href="/vendors/clarity-ui/css/clarity-ui.min.css?v=2.1">
      <link rel="stylesheet"
         href="/vendors/clarity-icons/css/clarity-icons.min.css?v=2.1">
      <script src="/vendors/custom-elements/js/custom-elements.min.js?v=2.1"></script>
      <script src="/vendors/clarity-icons/js/clarity-icons.min.js?v=2.1"></script>
      <!-- css files that related to this page -->
      <link rel="stylesheet" href="/vendors/inputmask/css/inputmask.min.css?v=2.1">
      <!-- custom css -->
      <link rel="stylesheet" href="/vendors/flaticon/css/flaticon.css?v=2.1">
      <link rel="stylesheet" href="/css/main.min.css?v=2.1">
      <!-- favicon css -->
      <link rel="shortcut icon" href="/img/favicon/favicon.ico?v=2.1"
         type="image/x-icon">
      <link rel="icon" href="/img/favicon/favicon.ico?v=2.1" type="image/x-icon">
   </head>
   <body  lang="en">
      <div class="main-container" id="app">
         <header class="header">
            <div class="header-align header-flex-reverse-between">
               <div class="header-brand">
                  <a href="#"><img class="header-brand-img" src="/img/logo.png"></a>
               </div>
               <div class="header-profile dropdown js-header-profile" data-url="/calendar/getnotification">
                  <a href="#">
                  <img class="header-profile-img"
                     src="{{asset('img/user.svg')}}">
                  <span class="header-profile-badge badge badge-green number js-notification-count"></span>
                  </a>
                  <div class="header-profile-dropdown-menu dropdown-menu">
                     <div class="header-flex-between header-not-notification border-b pb-1 js-switch-profile-dropdown ">
                        <div><a href="{{url('customer/profile')}}"
                           class="text-dark">{{Auth::user()->username}}</a></div>
                        <div class="header-flex-between">
                           <a href="{{url('customer/profile')}}" class="text-success">Profile</a>
                           <a href="/logout" class="text-danger ml-1">Logout</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="header-tab">
               <ul class="header-tab-box">
                  <li @if($title!="Dashboard") class="header-tab-item " @else class="header-tab-item active" @endif>
                  <a href="{{url('customer/dashboard')}}">
                  <img class="header-tab-img" src="{{asset('img/dashboard.svg')}}">
                  <span class="header-tab-text">Dashboard</span>
                  </a>
                  <div class="header-light"></div>
                  <div class="header-submenu header-flex-reverse-between  ">
                     <ul class="header-submenu-main header-flex-between">
                        <li class="header-submenu-main-item ">
                           <a @if($submenu=='Dashboard') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif
                           href="{{url('customer/dashboard')}}">Dashboard</a>
                        </li>
                        <li class="header-submenu-main-item ">
                           <a @if($submenu=='Profile') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif
                           href="{{url('customer/profile')}}">Profile</a>
                        </li>
                     </ul>
                  </div>
                  </li>
                  <!--<li @if($title!="Customers") class="header-tab-item " @else class="header-tab-item active" @endif>-->
                  <!--<a href="{{url('admin/customers')}}">-->
                  <!--<img class="header-tab-img" src="/img/customers.svg">-->
                  <!--<span class="header-tab-text">Customers</span>-->
                  <!--</a>-->
                  <!--<div class="header-light"></div>-->
                  <!--<div class="header-submenu header-flex-reverse-between header-submenu-hide">-->
                  <!--   <ul class="header-submenu-main header-flex-between">-->
                  <!--      <li class="header-submenu-main-item ">-->
                  <!--         <a @if($submenu=='All') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif-->
                  <!--         href="{{url('admin/customers')}}">All Customers</a>-->
                  <!--      </li>-->
                  <!--      <li class="header-submenu-main-item ">-->
                  <!--         <a @if($submenu=='Active') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif-->
                  <!--         href="{{url('admin/customers/getcust/1')}}">Active Customers</a>-->
                  <!--      </li>-->
                  <!--      <li class="header-submenu-main-item ">-->
                  <!--         <a @if($submenu=='Inactive') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif-->
                  <!--         href="{{url('admin/customers/getcust/0')}}">Inactive Customers</a>-->
                  <!--      </li>-->
                  <!--   </ul>-->
                  <!--</div>-->
                  <!--</li>-->
                  <!--<li @if($title!="Staffs") class="header-tab-item " @else class="header-tab-item active" @endif>-->
                  <!--<a href="{{url('admin/staffs')}}">-->
                  <!--<img class="header-tab-img" src="/img/support.svg">-->
                  <!--<span class="header-tab-text">Staffs</span>-->
                  <!--</a>-->
                  <!--<div class="header-light"></div>-->
                  <!--<div class="header-submenu header-flex-reverse-between header-submenu-hide">-->
                  <!--   <ul class="header-submenu-main header-flex-between">-->
                  <!--      @foreach($type as $t)-->
                  <!--      <li class="header-submenu-main-item">-->
                  <!--         <a @if($submenu==$t->slug) class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif-->
                  <!--         href="{{url('admin/staffs/type/'.$t->slug)}}">{{$t->name}}</a>-->
                  <!--      </li>-->
                  <!--      @endforeach-->
                  <!--   </ul>-->
                  <!--</div>-->
                  <!--</li>-->
                  <li @if($title!="Inventories") class="header-tab-item " @else class="header-tab-item active" @endif>
                  <a href="{{url('customer/inventories')}}">
                  <img class="header-tab-img" src="/img/products.svg">
                  <span class="header-tab-text">Inventories</span>
                  </a>
                  <div class="header-light"></div>
                  <div class="header-submenu header-flex-reverse-between header-submenu-hide">
                     <ul class="header-submenu-main header-flex-between">
                        <!--<li class="header-submenu-main-item">-->
                        <!--   <a @if($submenu=='Warehouses') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif-->
                        <!--   href="{{url('admin/warehouses')}}">Warehouses</a>-->
                        <!--</li>-->
                        <!--<li class="header-submenu-main-item">-->
                        <!--   <a @if($submenu=='Inventories') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif-->
                        <!--   href="{{url('admin/inventories')}}">Inventories</a>-->
                        <!--</li>-->
                        <li class="header-submenu-main-item">
                           <a @if($submenu=='Shop') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif
                           href="{{url('customer/inventories')}}">Shop</a>
                        </li>
                     </ul>
                  </div>
                  </li>
                  <!--<li  @if($title!="Products") class="header-tab-item " @else class="header-tab-item active" @endif>-->
                  <!--<a href="{{url('admin/products')}}">-->
                  <!--   <img class="header-tab-img" src="/img/products.svg">-->
                     <!--<img class="header-tab-img" src="/img/config.svg">-->
                  <!--   <span class="header-tab-text">Products</span>-->
                  <!--</a>-->
                  <!--<div class="header-light"></div>-->
                  <!--<div class="header-submenu header-flex-reverse-between header-submenu-hide">-->
                  <!--   <ul class="header-submenu-main header-flex-between">-->
                  <!--      <li class="header-submenu-main-item">-->
                  <!--         <a @if($submenu=='Categories') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif-->
                  <!--         href="{{url('admin/categories')}}">Categories</a>-->
                  <!--      </li>-->
                  <!--      <li class="header-submenu-main-item">-->
                  <!--         <a  @if($submenu=='Products') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif-->
                  <!--         href="{{url('admin/products')}}">Products</a>-->
                  <!--      </li>-->
                  <!--   </ul>-->
                  <!--</div>-->
                  <!--</li>-->
                  <li class="header-tab-item  ">
                     <a href="{{customer_url('orders')}}">
                     <img class="header-tab-img" src="{{asset('img/financial.svg')}}">
                     <span class="header-tab-text">Sales & Financials</span>
                     </a>
                     <div class="header-light"></div>
                     <div class="header-submenu header-flex-reverse-between header-submenu-hide">
                        <ul class="header-submenu-main header-flex-between">
                           <li class="header-submenu-main-item ">
                              <a class="header-submenu-main-link "
                                 href="">Pending Orders</a>
                           </li>
                           <li class="header-submenu-main-item">
                              <a class="header-submenu-main-link  "
                                 href="">All Orders</a>
                           </li>
                           <li class="header-submenu-main-item ">
                              <a class="header-submenu-main-link  "
                                 href="">Invoices</a>
                           </li>
                           <li class="header-submenu-main-item ">
                              <a class="header-submenu-main-link  "
                                 href="">Unpaid Invoices</a>
                           </li>
                        </ul>
                     </div>
                  </li>
                  <li  @if($title!="Messages") class="header-tab-item " @else class="header-tab-item active" @endif>
                  <a href="{{url('customer/messages')}}">
                  <img class="header-tab-img" src="{{asset('img/customers.svg')}}">
                  <span class="header-tab-text">Messages</span>
                  </a>
                  <div class="header-light"></div>
                  <div class="header-submenu header-flex-reverse-between header-submenu-hide">
                     <ul class="header-submenu-main header-flex-between">
                        <li class="header-submenu-main-item">
                           <a @if($submenu=='Inbox') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif
                           href="{{url('customer/messages')}}">Inbox</a>
                        </li>
                        <li class="header-submenu-main-item">
                           <a  @if($submenu=='Compose') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif
                           href="{{url('customer/compose')}}">Compose</a>
                        </li>
                        <li class="header-submenu-main-item">
                           <a  @if($submenu=='Outbox') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif
                           href="{{url('customer/outbox')}}">Outbox</a>
                        </li>
                     </ul>
                  </div>
                  </li>
                  <li  @if($title!="Configuration") class="header-tab-item " @else class="header-tab-item active" @endif>
                  <a href="{{url('customer/configuration')}}">
                  <img class="header-tab-img" src="{{asset('img/config.svg')}}">
                  <span class="header-tab-text">Configuration</span>
                  </a>
                  <div class="header-light"></div>
                  <div class="header-submenu header-flex-reverse-between header-submenu-hide">
                     <ul class="header-submenu-main header-flex-between">
                        <li class="header-submenu-main-item">
                           <a @if($submenu=='Settings') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif
                           href="{{url('customer/settings')}}">Settings</a>
                        </li>
                        <li class="header-submenu-main-item">
                           <a  @if($submenu=='Emails') class="header-submenu-main-link active" @else class="header-submenu-main-link " @endif
                           href="{{url('customer/emails')}}">Email</a>
                        </li>
                     </ul>
                  </div>
                  </li>
                  <li class="header-tab-item ">
                     <a href="">
                     <img class="header-tab-img" src="{{asset('img/reports.svg')}}">
                     <span class="header-tab-text">Reports</span>
                     </a>
                     <div class="header-light"></div>
                     <div class="header-submenu header-flex-reverse-between header-submenu-hide">
                        <ul class="header-submenu-main header-flex-between">
                        </ul>
                     </div>
                  </li>
               </ul>
            </div>
            <quick-search
               permission='{"delete_role":0,"view_role":0,"add_role":0,"edit_role":0,"view_Customer":0,"add_Customer":0,"edit_Customer":0,"delete_Customer":0,"view_Setting":0,"view_Inventory":0,"add_Inventory":0,"edit_Inventory":0,"delete_Inventory":0,"view_Lead":0,"add_Lead":0,"edit_Lead":0,"delete_Lead":0,"view_Opportunity":0,"add_Opportunity":0,"edit_Opportunity":0,"delete_Opportunity":0,"view_Document":0,"add_Document":0,"edit_Document":0,"delete_Document":0,"view_Reminder":0,"add_Reminder":0,"edit_Reminder":0,"delete_Reminder":0,"edit_Price":0,"view_Invoice":0,"add_Invoice":0,"edit_Invoice":0,"delete_Invoice":0,"view_Quote":0,"add_Quote":0,"edit_Quote":0,"delete_Quote":0,"allow_Discount":0,"view_Report":0,"add_Report":0,"edit_Report":0,"delete_Report":0,"view_PurchaseOrder":0,"add_PurchaseOrder":0,"edit_PurchaseOrder":0,"delete_PurchaseOrder":0,"view_SaleOrder":0,"add_SaleOrder":0,"edit_SaleOrder":0,"delete_SaleOrder":0,"Approve_Quote":0,"Approve_Invoice":0,"Delete_All_Notes":0,"Delete_Own_Notes":0,"view_SMS":0,"add_SMS":0,"edit_SMS":0,"delete_SMS":0,"view_OtherCalendar":0,"add_OpportunityNote":0,"view_BulkAction":0,"add_BulkAction":0,"edit_BulkAction":0,"delete_BulkAction":0,"view_Task":0,"add_Task":0,"edit_Task":0,"delete_Task":0,"view_Ticket":0,"cancel_Invoice":0,"add_Ticket":0,"edit_Ticket":0,"delete_Ticket":0,"view_Contract":0,"add_Contract":0,"edit_Contract":0,"delete_Contract":0,"show_Request_To_User":1}'
               url="http://admin.freshhub.ca">
            </quick-search>
         </header>
         @yield('contents')
      </div>
      <!-- Call Popup Section -->
      <div class="voip u-hide">
         <div class="voip-call">
            <div class="voip-heading">
               <div class="voip-heading-left">
                  <clr-icon shape="phone-handset" class="is-solid voip-heading-left-object"></clr-icon>
               </div>
               <div class="voip-heading-center">
                  <h6 class="voip-heading-center-top"></h6>
                  <small class="voip-heading-center-phone number"></small>
                  <small class="voip-heading-center-label"></small>
               </div>
               <div class="voip-heading-right">
                  <a href="#" class="voip-heading-close">
                     <clr-icon shape="times" class="is-solid"></clr-icon>
                  </a>
               </div>
            </div>
            <div class="voip-body">
               <a href="" id="opportunity-link" target="_blank"
                  class="btn voip-body-link ">New Opportunity</a>
               <a href="" target="_blank" id="customer-note-link"
                  class="btn voip-body-link">View Customer Details</a>
            </div>
         </div>
      </div>
      <!-- General Modal for bulk actions -->
      <div class="modal js-bulk-action-modal">
         <div class="modal-dialog" role="dialog" aria-hidden="true">
            <div class="modal-content">
               <div class="modal-header">
                  <button aria-label="Close" class="close" type="button" onClick="cancelModal()">
                     <clr-icon aria-hidden="true" shape="close"></clr-icon>
                  </button>
                  <h3 class="modal-title"></h3>
               </div>
               <div class="modal-body">
                  <p class="js-without-items">Select at least one item from list</p>
                  <p class="js-with-items" style="display: none;">Select at least one item from list</p>
               </div>
               <div class="modal-footer">
                  <button class="btn btn-default" type="button" onclick="cancelModal()">Ok</button>
                  <button class="btn btn-outline" type="button" onclick="cancelModal()"
                     style="display: none">Cancel</button>
                  <button class="btn btn-primary" type="button" onclick="submitModal()"
                     style="display: none">Ok</button>
               </div>
            </div>
         </div>
      </div>
      <div class="modal-backdrop" aria-hidden="true"></div>
      <!-- bulk actions form -->
      <form method="post" id="bulk-action-form">
         <input name="_method" type="hidden">
         <input type="hidden" name="_token" value="VqrTYHLbqvpC5JpVxjjSD3hOft4NTqlfj62fdqPz">
      </form>
      <div class="modal js-show-history-item ">
         <div class="modal-dialog" role="dialog" aria-hidden="true">
            <div class="modal-content">
               <div class="modal-header">
                  <button aria-label="Close" class="close" type="button" onClick="cancelModal()">
                     <clr-icon aria-hidden="true" shape="close"></clr-icon>
                  </button>
                  <div id="show-history-item"></div>
               </div>
            </div>
         </div>
      </div>
      <!-- General JS script library-->
      <script src="/js/app.js?id=6cb5d7cc395147fc2fd4"></script>
      <script src="/vendors/jquery/js/jquery.min.js?v=2.1"></script>
      <script src="/vendors/vue/js/vue.min.js?v=2.1"></script>
      <!-- JS Files that related to this page -->
      <script src="/vendors/inputmask/js/jquery.inputmask.bundle.min.js?v=2.1"></script>
      <script src="/vendors/chartjs-funnel/js/chart.funnel.min.js?v=2.1"></script>
      <!-- main shared script -->
      <script src="/js/main.min.js?v=2.1"></script>
      <!-- JS and script files that related to this page -->
      <script></script>
      <!-- General javascript -->
      <script>
         $(function () {
             $(".js-show-history-item").click(function () {
                 $("#show-history-item").html($(this).data('value'));
             })
         
             /**
              * ajax update notification
              */
             function htmlTpl(val, type, opportunity_id) {
                 return '<div class="header-profile-dropdown-action media" data-id="' + val['reminder_id'] + '">\
                             <img class="mr-1" src="' + baseUrl + '/img/' + (type === 1 ? 'notify-reminder.svg' : 'notify-notification.svg') + '" width="35">\
                             <div class="media-body">\
                                 <small class="text-success">\
                                     <clr-icon shape="check"></clr-icon>' + val['reminder_date'] + '\
                                 </small>\
                                 <p class="text-dark">' + val['reminder_title'] + '</p>\
                             </div>\
                             <a href="/opportunities/' + opportunity_id + '" class="header-profile-dropdown-status">\
                                 <clr-icon shape="check" class="text-success"></clr-icon>\
                             </a>\
                         </div>';
             }
         
             /**
              * Update Badge Count
              **/
             var reminderLen = 0,
                 notificationLen = 0;
         
             function updateCount() {
                 var len = reminderLen + notificationLen;
         
                 $('.js-switch-profile-dropdown').removeClass('header-not-notification');
         
                 // notification len
                 if (notificationLen > 0) {
                     $('.header-profile-nav-first-badge').show().text(notificationLen)
                 } else {
                     $('.header-profile-nav-first-badge').hide();
                     $('#notification_tab').find('.js-show-all').hide();
                     $('#notification_tab').find('.js-no-items').show();
                 }
         
                 // reminder len
                 if (reminderLen > 0) {
                     $('.header-profile-nav-last-badge').show().text(reminderLen)
                 } else {
                     $('.header-profile-nav-last-badge').hide();
                     $('#reminder_tab').find('.js-show-all').hide();
                     $('#reminder_tab').find('.js-no-items').show();
                 }
         
                 if (len > 0) {
                     $('.js-notification-count').show().text(len).parent('a').addClass('shake-animate');
                 } else {
                     $('.js-notification-count').hide().parent('a').removeClass('shake-animate');
                 }
         
                 var regex = new RegExp(/(?=\d+\))\d+/g);
                 var title = $('title').text();
                 if (regex.exec(title) !== null) {
                     title = title.replace(regex, len);
                     $('title').text(title);
                 } else {
                     $('title').prepend('(' + len + ') ');
                 }
             }
         
             var baseUrl = $.trim($('meta[name="base_url"]').attr('content') + '/');
             updateNotification(baseUrl);
             // set interval
             setInterval(function () {
                 updateNotification(baseUrl);
             }, 60000);
         
             // update notification
             function updateNotification(baseUrl) {
                 $.ajax({
                     type: 'GET',
                     url: $('.js-header-profile').attr('data-url'),
                     success: function (result) {
                         var notificationTab = $('.js-notification-wrapper #notification_tab'),
                             remindersTab = $('.js-notification-wrapper #reminder_tab'),
                             remindersWrapper = remindersTab.find('.header-profile-dropdown-overflow'),
                             notificationsWrapper = notificationTab.find('.header-profile-dropdown-overflow');
         
                         notificationsWrapper.empty();
                         remindersWrapper.empty();
                         // if notification exist , add animate and text
                         if (result.notifications.length || result.reminders.length) {
         
                             reminderLen = result.reminders.length;
                             notificationLen = result.notifications.length;
                             updateCount();
         
                             // generate reminders html
                             if (result.reminders.length) {
                                 remindersTab.find('.js-no-items').hide();
                                 remindersTab.find('.js-show-all').show();
         
                                 $.each(result.reminders, function (key, val) {
                                     if (val['opportunity_id'] > 0) {
                                         remindersWrapper.append(htmlTpl(val, 1, val['opportunity_id']));
                                     } else {
                                         remindersWrapper.append(htmlTpl(val, 1, '#'));
                                     }
                                 });
                             } else {
                                 remindersTab.find('.js-no-items').show();
                                 remindersTab.find('.js-show-all').hide();
                             }
         
                             // generate notifications html
                             if (result.notifications.length) {
                                 notificationTab.find('.js-no-items').hide();
                                 notificationTab.find('.js-show-all').show();
                                 $.each(result.notifications, function (key, val) {
                                     notificationsWrapper.append(htmlTpl(val, 2, val['opportunity_id']));
                                 });
                             } else {
                                 notificationTab.find('.js-no-items').show();
                                 notificationTab.find('.js-show-all').hide();
                             }
         
                         } else {
                             $('.js-switch-profile-dropdown').addClass('header-not-notification');
                             $('.js-notification-count').hide();
                             $('.js-notification-wrapper').hide();
                         }
                     },
                     error: function (err) {
                         console.log(err);
                     }
                 });
             }
         
             /**
              * Change Read Status
              */
             $(document).on('click', '.header-profile-dropdown-status', function (e) {
                 e.preventDefault();
                 var el = $(this).closest('.header-profile-dropdown-action'),
                     dataId = $(el).attr('data-id'),
                     _updateURL = '';
         
                 // Generate URL by which tab
                 if ($(this).parents('#notification_tab').length > 0) {
                     _updateURL = '/noificationrule/readnoificationrule/';
                 } else if ($(this).parents('#reminder_tab').length > 0) {
                     _updateURL = '/reminder/readreminder/';
                 }
         
                 el.fadeOut(500);
                 $.ajax({
                     url: _updateURL + dataId,
                     type: 'POST',
                     success: function (res) {
                         switch (el.closest('[role="tabpanel"]').attr('id')) {
                             case 'reminder_tab':
                                 reminderLen--;
                                 break;
                             case 'notification_tab':
                                 notificationLen--;
                                 break;
                             default:
                                 break;
                         }
                         updateCount();
                         el.remove();
                     },
                     error: function (err) {
                         el.fadeIn(500);
                         toast("An error occurred while connecting to the server");
                     }
                 })
             });
         
             /**
              * Change Read All Status
              */
             $(document).on('change', '.js-show-all [type="checkbox"]', function (e) {
                 e.preventDefault();
         
                 if ($(this).is(':checked')) {
                     var el = $(this).closest('[role="tabpanel"]');
                     var dataIds = el.find('.header-profile-dropdown-action').map(function (i) {
                         return $(this).attr('data-id');
                     });
                     var updateURL = '';
         
                     // Generate URL by which tab
                     if ($(this).parents('#notification_tab').length > 0) {
                         updateURL = '/noificationrule/readnoificationrule/';
                     } else if ($(this).parents('#reminder_tab').length > 0) {
                         updateURL = '/reminder/readreminder/';
                     }
         
                     el.find('.header-profile-dropdown-action').fadeOut(500);
                     $.ajax({
                         url: updateURL + dataIds.get().join(','),
                         type: 'POST',
                         success: function (res) {
                             el.find('.header-profile-dropdown-action').empty();
                             el.find('.js-no-items').show();
                             el.find('.js-show-all').hide();
         
                             switch (el.closest('[role="tabpanel"]').attr('id')) {
                                 case 'reminder_tab':
                                     reminderLen = 0;
                                     break;
                                 case 'notification_tab':
                                     notificationLen = 0;
                                     break;
                                 default:
                                     break;
                             }
                             updateCount();
                         },
                         error: function (err) {
                             el.find('.header-profile-dropdown-action').fadeIn(500);
                             toast("An error occurred while connecting to the server");
                         }
                     })
                 }
         
             });
         
         
             
             //voip call close
             $(document).on('click', '.voip-heading-close', function () {
                 $('body').find('.voip-call').addClass('voip-call-close');
             });
         
         
             $(document).on('click', '.call_number', function (e) {
                 var number = $(this).text();
                 $.ajax({
                     type: 'post',
                     url: '/contacts/call_number',
                     data: {number: number},
                     success: function (res) {
                         toastCall(res[0], res[1]);
                         console.log(res);
                     },
                     error: function (error) {
                         console.error(error);
                     }
                 })
             });
         
         });
         
      </script>
      <style>
         .form-error{
             color:#DD0000 !important;
         /*background:lightcoral;*/
         }
         .switch {
         position: relative;
         display: inline-block;
         width: 60px;
         height: 34px;
         }
         .switch input { 
         opacity: 0;
         width: 0;
         height: 0;
         }
         .slider {
         position: absolute;
         cursor: pointer;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         background-color: #ccc;
         -webkit-transition: .4s;
         transition: .4s;
         }
         .slider:before {
         position: absolute;
         content: "";
         height: 26px;
         width: 26px;
         left: 4px;
         bottom: 4px;
         background-color: white;
         -webkit-transition: .4s;
         transition: .4s;
         }
         input:checked + .slider {
         background-color: #2196F3;
         }
         input:focus + .slider {
         box-shadow: 0 0 1px #2196F3;
         }
         input:checked + .slider:before {
         -webkit-transform: translateX(26px);
         -ms-transform: translateX(26px);
         transform: translateX(26px);
         }
         /* Rounded sliders */
         .slider.round {
         border-radius: 34px;
         }
         .slider.round:before {
         border-radius: 50%;
         }
         
      </style>
   </body>
</html>