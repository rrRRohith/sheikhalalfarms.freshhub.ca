<nav class="navbar navbar-expand-lg navbar-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul>
            <li class="nav-item dropdown"><a @if($title !="Dashboard") class="nav-link dropdown-toggle"  @else class="nav-link dropdown-toggle active" @endif href="{{admin_url('')}}" aria-current="page" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dashboard</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <li><a @if($submenu=='Dashboard')  class="dropdown-item active" @else class="dropdown-item" @endif
                           href="{{admin_url('')}}">Dashboard</a></li>
                     <li><a @if($submenu=='Profile')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('profile')}}">Profile</a></li>
                      <li><a @if($submenu=='Password')  class="dropdown-item active" @else class="dropdown-item" @endif
                           href="{{admin_url('changepassword')}}">Change Password</a></li>
                </ul>
            </li>
             <li class="nav-item dropdown"><a @if($title !="Customers") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif  href="{{url('admin/customers')}}" aria-current="page" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Customers</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <li><a @if($submenu=='All')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/customers')}}">All Customers</a></li>
                     <li><a @if($submenu=='Active')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/customers/getcust/1')}}">Active Customers</a></li>
                     <li><a @if($submenu=='Inactive')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/customers/getcust/0')}}">Inactive Customers</a></li>
                     <li><a @if($submenu=='customertype')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/customertype')}}">Customer Types</a></li>
                </ul>
            </li>
            <li class="nav-item"><a @if($submenu !="Staffs") class="nav-link " @else class="nav-link active" @endif href="{{url('admin/staffs')}}">Staffs</a></li>
         
           <li class="nav-item dropdown"><a  @if($title !="Inventories") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif href="{{url('admin/inventories')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Inventories</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <li><a @if($submenu=='Warehouses')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/warehouses')}}">Warehouses</a></li>
                     <li><a @if($submenu=='Inventory')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/inventories')}}">Inventories</a></li>
                     <li><a @if($submenu=='stock')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/inventories/current-stock')}}">Stock</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown"><a   @if($title !="Products") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif class="nav-link dropdown-toggle" href="{{url('admin/products')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Products</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <li><a @if($submenu=='Category')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/categories')}}">Categories</a></li>
                     <li><a @if($submenu=='Products')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/products')}}">Products</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown"><a  @if($title !="Order") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif  href="{{admin_url('orders')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Sales & Financials</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <li><a @if($submenu=='Order')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('orders')}}">All Orders</a></li>
                     <li><a @if($submenu=='Invoice')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('invoices')}}">Invoices</a></li>
                     <li><a @if($submenu=='Backorder')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('backorders')}}">Backorders</a></li>
                     <li><a @if($submenu=='GenerateInvoice')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('getrunsheet')}}">Generate Runsheet</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown"><a  @if($title !="Message") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif href="{{admin_url('messages')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Messages</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <li><a @if($submenu=='Inbox')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('messages')}}">Inbox</a></li>
                     <li><a @if($submenu=='Compose')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('compose')}}">Compose</a></li>
                     <li><a @if($submenu=='Outbox')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{admin_url('outbox')}}">Sent Items</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown"><a  @if($title !="Settings") class="nav-link dropdown-toggle" @else class="nav-link dropdown-toggle active" @endif href="{{url('admin/configuration')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Configuration</a> <span class="submenu_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <li><a @if($submenu=='Configuration')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/configuration')}}">Settings</a></li>
                     <li><a @if($submenu=='Roles')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/roles')}}">Roles & Permissions</a></li>
                     <li><a @if($submenu=='Emails')  class="dropdown-item active" @else class="dropdown-item" @endif href="{{url('admin/emails')}}">Emails</a></li>
                </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="#">Reports</a></li>
        </ul>  
     </div>

</nav>