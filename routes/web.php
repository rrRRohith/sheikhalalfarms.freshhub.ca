<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('dom',function(){
    $domain = parse_url(request()->root())['host']; 
echo $domain;
});

Route::get('pdf',function(){
    $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML('<h1>Test</h1>');
    return $pdf->stream();
});

Route::get('/',function() {
    return View('layouts.nonmember');
})->name('login');
Route::get('forgotpassword',function() {
    return View('forgotpassword');
});
Route::post('forgotpassword','LoginController@forgotPasswordLink');
Route::get('resetpassword/{id}','LoginController@resetPassword');
Route::post('resetpassword','LoginController@resetPasswordStore');
Route::post('/','LoginController@authenticate');
Route::get('/logout','LoginController@logout');


Route::prefix('admin')->middleware('auth:admin')->group(function(){
    Route::get('/','AdminController@index');
    
    /******************** Customers **********************/
    
    Route::get('customers','Admin\CustomersController@index');
    Route::get('customers/defer', 'Admin\CustomersController@defer');
    Route::put('customers/{id}','Admin\CustomersController@update');
    Route::get('customers/{id}/price','Admin\CustomersController@priceList');
    Route::post('customers/{id}/price','Admin\CustomersController@updatePriceList');
    // Route::get('/search','Admin\SearchController@search');
    Route::get('/customers/search','Admin\CustomersController@search');
    Route::post('/customers/create', 'Admin\CustomersController@store');
    // Route::resource('/customers', 'Admin\CustomersController');
    // Route::get('/customers/getcust/{status?}','Admin\CustomersController@index');
    Route::get('/customers/changestatus/{id}/status','Admin\CustomersController@changeStatus');
    Route::get('customers/{id}/del','Admin\CustomersController@destroy');
    Route::get('customers/getdetails/{id}','Admin\CustomersController@getDetails');
    Route::get('customers/type/{id}','Admin\CustomerTypeController@getCustomers');
    Route::get('customers/getdues/{id}','Admin\CustomersController@getDues');
    /******************** Customertype **********************/
    
    Route::resource('/customertype', 'Admin\CustomerTypeController');
    // Route::get('customertype/getcust/{status?}','Admin\CustomersController@index');
    Route::get('customertype/{id}/del','Admin\CustomerTypeController@destroy');

    Route::post('customers/update-rate','Admin\CustomersController@updateRate');
    
    /******************** Staffs **********************/
    // Route::resource('/staffs', 'Admin\StaffsController');
    Route::get('staffs','Admin\StaffsController@index');
    Route::get('staffs/defer','Admin\StaffsController@defer');
    Route::get('staffs/create','Admin\StaffsController@create');
    Route::post('staffs','Admin\StaffsController@store');
    Route::put('staffs/{id}','Admin\StaffsController@update');
    Route::get('staffs/{id}/edit','Admin\StaffsController@edit');
    Route::get('/staffs/changestatus/{id}/status','Admin\StaffsController@changeStatus');
    Route::get('/staffs/{id}/del','Admin\StaffsController@destroy');

    /******************** Warehouse **********************/

    Route::resource('/warehouses', 'Admin\WarehousesController');
    Route::get('/warehouses/changestatus/{id}/status','Admin\WarehousesController@changeStatus');
    Route::get('/warehouses/{id}/del','Admin\WarehousesController@destroy');
    
    /******************** Inventories **********************/
    
    Route::get('/inventories/{id}/del','Admin\InventoriesController@destroy');
    Route::get('/getproduct','Admin\InventoriesController@getProducts');
    Route::get('inventories/current-stock', 'Admin\InventoriesController@stock'); 
    Route::post('updatestock','Admin\InventoriesController@updateStock');
    // Route::resource('/inventories', 'Admin\InventoriesController');
    Route::get('inventories','Admin\InventoriesController@index');
    Route::get('inventories/defer','Admin\InventoriesController@defer');
    // Route::get('inventories/create','Admin\InventoriesController@create');
    // Route::post('inventories','Admin\InventoriesController@store');
    // Route::get('inventories/{id}','Admin\InventoriesController@edit');
    // Route::post('inventories/{id}','Admin\InventoriesController@update');
    

    Route::get('/profile','AdminController@profile');
    Route::post('/profile','AdminController@updateprofile');
    Route::post('/changepassword','AdminController@changepassword');
    Route::get('/changepassword','AdminController@getchangepassword');
    
    
    /*********** Products routes **************/
    
    Route::get('/products/search/{type?}','Admin\ProductsController@search');
    // Route::resource('/products', 'Admin\ProductsController');
    Route::get('products','Admin\ProductsController@index');
    Route::put('products/{id}','Admin\ProductsController@update');
    Route::get('products/defer', 'Admin\ProductsController@defer');
    Route::post('/products/create', 'Admin\ProductsController@store');
    Route::post('/products/updatestock','Admin\ProductsController@updateStock');
    Route::get('/products/changestatus/{id}/status','Admin\ProductsController@changeStatus');
    Route::get('/products/{id}/del','Admin\ProductsController@destroy');
    Route::get('/products/getdetails/{id}','Admin\ProductsController@getDetails');
    Route::get('/products/getprices/{id}','Admin\ProductsController@getCustomerPrices');
    Route::get('categories/changestatus/{id}','Admin\CategoriesController@changeStatus');
    Route::resource('categories', 'Admin\CategoriesController');
    Route::get('/categories/{id}/del','Admin\CategoriesController@destroy');
    
    
    /***************** ORDER ROUTES **********************/
    
    
    Route::get('orders/change-status','Admin\OrdersController@orderStatus');
    Route::get('orders/detail/{id}','Admin\OrdersController@getOrder');
    Route::post('orders/create-po','Admin\OrdersController@createPO');
    Route::post('orders/create-invoice','Admin\OrdersController@createInvoice');

    Route::post('orders/edit-invoice','Admin\OrdersController@editInvoice');
    
    Route::post('orders/process-po','Admin\OrdersController@processPO');
    Route::post('orders/save-send-po','Admin\OrdersController@saveSendPO');
    Route::post('orders/save-send-inv','Admin\OrdersController@saveSendInv');
    Route::post('orders/checkmailinvoice','Admin\OrdersController@checkmailinvoice');
    Route::post('orders/sendinvoice','Admin\OrdersController@sendInvoice');

    Route::get('invoices/detail/{id}','Admin\OrdersController@getInvoice');
    
    Route::get("testurl",function(){
        return view('admin.order.invoice-mail');
    });
    
    Route::post('orders/edit-po','Admin\OrdersController@editPO');

    Route::get('orders/view-po/{id}','Admin\OrdersController@viewPO');    
    Route::get('orders/view-order/{id}','Admin\OrdersController@viewOrder');    
    
    // Route::resource('orders','Admin\OrdersController');
    Route::get('orders','Admin\OrdersController@index');
    Route::get('orders/defer','Admin\OrdersController@defer');
    Route::get('orders/{id}/edit','Admin\OrdersController@edit');
    Route::put('orders/{id}','Admin\OrdersController@update');
    Route::get('orders/getdetails/{id}','Admin\OrdersController@getdetails');
    Route::get('orders/getdetails1/{id}','Admin\OrdersController@getdetails1');
    Route::get('orders/getcustdetails/{id}','Admin\OrdersController@getcustdetails');
    Route::get('orders/getcustdetails1/{id}','Admin\OrdersController@getcustdetails1');
    Route::get('orders/changestatus/{id}','Admin\OrdersController@changeStatus');
    Route::get('orders/{id}/del','Admin\OrdersController@destroy');
    Route::get('orders/{id}/getpr','Admin\OrdersController@getpr');
    Route::get('orders/{id}/generateinvoice','Admin\OrdersController@generateinvoice');
    Route::get('orders/updatestatus/{id}/{status}','Admin\OrdersController@updateStatus');
    Route::get('orders/getstock/{id}','Admin\OrdersController@getStock');
    Route::get('orders/orderdetails/{id}','Admin\OrdersController@orderDetails');
    Route::get('orders/assigndriver/{id}/{driverid}','Admin\OrdersController@assignDriver');
    Route::post('orders/backorder','Admin\OrdersController@saveBackOrder');
    
    Route::get('order/picksheet/{id}','Admin\OrdersController@pickSheet');
    Route::get('order/printpicksheet/{id}','Admin\OrdersController@printPickSheet');

    /******************** Runsheets **********************/

    Route::get('runsheets','Admin\DeliveryController@runsheets');
    Route::get('runsheets/generate','Admin\DeliveryController@generateRunsheet');
    Route::post('runsheets/generate/submit','Admin\DeliveryController@saveRunsheet');
    Route::get('runsheets/view/{id}','Admin\DeliveryController@viewRunsheet');
    Route::get('runsheets/print/{id}','Admin\DeliveryController@printRunsheet');
    Route::get('generaterunsheet','Admin\DeliveryController@generaterunsheet1');
    Route::get('deliveries','Admin\DeliveryController@deliveries');
    Route::get('deliveries/remove','Admin\DeliveryController@remove');
    Route::get('deliveries/reassign','Admin\DeliveryController@reassign');
    Route::any('deliverylist','Admin\DeliveryController@deliverylist');
    Route::get('assigndriver','Admin\DeliveryController@assignDriver');
    Route::get('getorders','Admin\DeliveryController@getOrders');
    Route::get('runsheets/mail/{id}','Admin\DeliveryController@mailRunsheet');
    Route::get('deliveries/defer','Admin\DeliveryController@defer');
    
    Route::resource('routes','Admin\RoutesController');
    Route::get('routes/{id}/del','Admin\RoutesController@delete');

    Route::get('printrunsheet/{id}','Admin\OrdersController@printRunsheet');
    Route::post('generaterunsheet','Admin\OrdersController@saveRunsheet');
    Route::get('runsheet/{id}','Admin\OrdersController@runsheet');
    


    Route::get('backorders','Admin\OrdersController@backorder');
    Route::get('backorders/defer','Admin\OrdersController@backorderDefer');
    Route::get('backorders/{id}','Admin\OrdersController@viewBackorder');
    // Route::get('generatePDF/{id}','Admin\PrintController@invoiceToPdf');
    Route::get('backorders/convertbackorder/{id}','Admin\OrdersController@convertBackorder');
   // Route::get('runsheets','Admin\DeliveresController@runsheets');
    
    Route::get('generatepdf1','Admin\CintaOrdersController@generatePDF1');
    
    Route::post('order/makepayment','Admin\OrdersController@makepayment');
    Route::post('order/printorder','Admin\OrdersController@printOrder');
    Route::get('order/printorder2/{id}','Admin\OrdersController@printOrder2');
    Route::get('order/printorder/{id}','Admin\OrdersController@printOrder2');

    Route::resource('roles', 'Admin\RolesController');
    Route::resource('permissions', 'Admin\PermissionController');
    Route::resource('configuration', 'Admin\ConfigurationController');
    
    Route::get('report/customer','Admin\ReportController@customer');
    Route::get('report/product','Admin\ReportController@product');
    Route::get('report/sale','Admin\ReportController@sale');
    Route::get('report/orderlist','Admin\ReportController@orderList');
    Route::get('report/orderview','Admin\ReportController@orderView');
    
    Route::get('/emails','Admin\ConfigurationController@viewemail');
    Route::get('/compose','Admin\ConfigurationController@compose');
    Route::post('/compose','Admin\ConfigurationController@sendmail');
    Route::get('/messages','Admin\ConfigurationController@inbox');
    Route::get('/outbox','Admin\ConfigurationController@outbox');
    Route::get('/viewmessage/{id}','Admin\ConfigurationController@viewMessage');
    Route::get('/viewsentmessage/{id}','Admin\ConfigurationController@viewSentMessage');
    Route::get('/message/markasread/{id}','Admin\ConfigurationController@markasread');
    Route::get('/message/{id}/del/{type}','Admin\ConfigurationController@deleteemail');


    /******************** Unittypes **********************/
    // Route::resource('/unittype', 'Admin\UnitTypeController');
    Route::get('unittype/create','Admin\UnitTypeController@create');
    Route::post('unittype','Admin\UnitTypeController@store');
    Route::get('unittype/{id}/del','Admin\UnitTypeController@destroy');
    Route::get('unittype/{id}/edit','Admin\UnitTypeController@edit');
    Route::put('unittype/{id}','Admin\UnitTypeController@update');
    Route::get('unittype/changestatus/{id}','Admin\UnitTypeController@changeStatus');
    Route::get('weight','Admin\UnitTypeController@getWeight');
    Route::get('weight/changebase/{id}','Admin\UnitTypeController@changeBaseWeight');
    Route::get('/unittype','Admin\UnitTypeController@index');
    Route::get('/unittype/defer', 'Admin\UnitTypeController@defer');
    
    Route::get('invoices','Admin\OrdersController@invoices');
    Route::get('invoices/defer','Admin\OrdersController@deferinvoice');
    Route::get('invoices/{id}/del','Admin\OrdersController@deleteinvoice');
    
    Route::get('purchaseorders','Admin\OrdersController@purchseOrders');
    Route::get('purchaseorders/defer','Admin\OrdersController@deferPurchaseOrders');
    
    Route::get('orders/approveddetails/{id}','Admin\OrdersController@orderApprovedDetails');
    Route::get('printinvoice/{id}','Admin\PrintController@printInvoice');
    Route::post('printinvoice','Admin\PrintController@printIndInvoice');
    Route::get('generatePDF/{id}','Admin\PrintController@generatePDF');
    
    Route::get('invoices/getdetails/{id}','Admin\OrdersController@getInvDetails');
    Route::get('invoices/getcustdetails/{id}','Admin\OrdersController@getCustInvDetails');
    Route::post('invoices/makepayment','Admin\OrdersController@makepayment1');
    
    Route::post('invoices/cancel','Admin\OrdersController@cancelInvoice');

    Route::get('helpers/def-weight','Admin\HelperController@defWeight');
    Route::get('helpers/get-weight/{id}','Admin\HelperController@getWeight');
    Route::get('helpers/getweightprice/{id}','Admin\HelperController@getWeightAndPrice');
    Route::get('helpers/gettax','Admin\HelperController@getTax');
    Route::get('helpers/defweightvalue','Admin\HelperController@getdefValue');
    
    Route::get('deliveryview/{id}','Admin\DeliveryController@deliveryView');
    Route::post('orders/cancel','Admin\OrdersController@cancelOrder');

});

Route::prefix('customer')->middleware('auth:customer')->group(function(){
    Route::get('/','CustomerController@index');
    Route::get('/dashboard','CustomerController@index');
    Route::get('/profile','CustomerController@profile');
    Route::post('/profile','CustomerController@updateprofile');
    Route::post('/changepassword','CustomerController@changepassword');
    Route::get('/inventories','CustomerController@inventories');
    Route::get('/messages','CustomerController@inbox');
    Route::get('/outbox','CustomerController@outbox');
    Route::get('/compose','CustomerController@compose');
    Route::post('/compose','CustomerController@sendmail');
    Route::get('/viewmessage/{id}','CustomerController@viewMessage');
    Route::get('/viewsentmessage/{id}','CustomerController@viewSentMessage');
    Route::get('/message/{id}/del/{type}','CustomerController@deleteemail');
    Route::get('/message/markasread/{id}','CustomerController@markasread');
    // Route::resource('orders', 'OrdersController');
    Route::get('orders','OrdersController@index');
    Route::get('orders/defer','OrdersController@defer');
    Route::get('orders/{id}/del','OrdersController@destroy');
    Route::get('orders/{id}/getpr','OrdersController@getpr');
    Route::get('orders/getdetails/{id}','OrdersController@getdetails');
    Route::get('orders/orderdetails/{id}','OrdersController@orderDetails');
    Route::get('orders/getcustdetails/{id}','OrdersController@getcustdetails');
    // Route::get('orders/{id}/generateinvoice','OrdersController@generateinvoice');
    Route::post('order/makepayment','OrdersController@makepayment');
    Route::post('orders/create-po','OrdersController@createPO');

    
    Route::post('order/printorder','OrdersController@printOrder');
    Route::get('order/printorder/{id}','OrdersController@printIndOrder');
    Route::get('generatePDF/{id}','PrintController@invoiceToPdf');
    Route::get('printinvoice/{id}','PrintController@printInvoice');
    
    
     
    Route::get('backorders/defer','OrdersController@backorderDefer'); 
    Route::get('backorders/{id}','OrdersController@viewBackorder');
    Route::get('backorders','OrdersController@backorders');
    Route::get('backorders/convertbackorder/{id}','OrdersController@covertBackorder');
    
    Route::get('changepassword','CustomerController@getchangepassword');
    // Route::post('changepassword','CustomerController@updatepassword');
    Route::get('/search','SearchController@search');
    Route::get('invoices','OrdersController@invoices');
    Route::get('invoices/defer','OrdersController@deferinvoice');
    Route::get('invoices/{id}/del','OrdersController@deleteinvoice');
    Route::get('invoices/{id}/generateinvoice','OrdersController@generateinvoice');
    
    Route::get('report/sale','ReportController@sale');
    Route::get('report/product','ReportController@product');
    
    Route::get('helpers/def-weight','HelperController@defWeight');
    Route::get('helpers/get-weight/{id}','HelperController@getWeight');
    Route::get('helpers/getweightprice/{id}','HelperController@getWeightAndPrice');
    Route::get('/products/search','OrdersController@search');
    
    Route::post('orders/edit-po','OrdersController@editPO');
    Route::get('orders/detail/{id}','OrdersController@getOrder');
    Route::post('orders/cancel','OrdersController@cancelOrder');

});

Route::get('demo',function() {
    return View('admin.demo');
});
Route::get('print','Admin\PrintController@print');
Route::get('admin/logout',function() {
	auth()->logout();
	return view('admin.logout');
});
Route::get('runsheet',function() {
    return view('admin.runsheet');
});



