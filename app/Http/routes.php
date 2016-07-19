<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*get requests*/
Route::get('/', 'ViewController@dashboard');

Route::get('/dashboard', 'ViewController@dashboard');
    
Route::get('/customers', 'ViewController@customers');

Route::get('/vehicles', 'ViewController@vehicles');

Route::get('/drivers', 'ViewController@drivers');

Route::get('/companies', 'ViewController@companies');

Route::get('/products', 'ViewController@products');

Route::get('/addOrder', 'ViewController@addOrder');

Route::get('/customerZones', 'ViewController@customerZones');

Route::get('/vehicleZones', 'ViewController@vehicleZones');

Route::get('/register', 'ViewController@register');
   
Route::get('/login', function () {
    return view('login',['message' => '']);
});

/*place an order*/
Route::get('/placeOrder', 'OrderController@placeOrder');

/*place an order*/
Route::get('/test', 'OrderController@test');

/*get product in order*/
Route::get('/getProduct/{product_id}', 'ProductController@getProduct');

/*get order details*/
Route::get('/getOrderDetails/{order_code}', 'OrderController@getOrderDetails');

/*authenticates an user*/
Route::get('/doLogout','UserController@doLogout');

/*generating invoice for order id*/
Route::get('/invoice/{order_code}','OrderController@generateInvoice');

/*view all orders*/
Route::get('/allOrders/{option}/{active_tab}','OrderController@getAllOrders');

/*get delivered Orders*/
Route::get('/deliverdOrders/{option}/{active_tab}','OrderController@getDeliverdOrders');

/*get not yet delivered Orders*/
Route::get('/notDeliveredOrders/{option}/{active_tab}','OrderController@getNotDeliveredOrders');

/*view damaged orders*/
Route::get('/damagedProducts','ViewController@damagedProducts');

/*get customer zone vehicles*/
Route::get('/getCustomerZoneVehicles/{customer_id}','VehicleController@getCustomerZoneVehicles');

/*get payments for a order*/
Route::get('/getOrderPayments/{order_code}','OrderController@getOrderPayments');

/*reset all vehicles*/
Route::get('/resetAllVehicles','VehicleController@resetAllVehicles');

/*assign vehicle to a customer zone*/
Route::get('/assignVehicleToCustomerZone/{vehicle_id}/{customer_zone_id}','VehicleController@assignVehicleToCustomerZone');

/*get orders of a product*/
Route::get('/getProductOrders/{product_id}','OrderController@getProductOrders');

/*get filtered orders of a product*/
Route::get('/getProductOrders/{start_date}/{end_date}/{product_id}','OrderController@getFilteredProductOrders');

/*add damaged Product*/
Route::get('/addNewDamagedProducts','ProductController@addNewDamagedProducts');

/*get Customer Orders*/
Route::get('/getCustomerOrders/{customer}','OrderController@getCustomerOrders');

/*get details for view Orders*/
Route::get('/viewOrder/{order_code}','OrderController@viewOrder');

/*reset password*/
Route::get('/resetPassword','UserController@resetPassword');

/*view recent orders*/
Route::get('/viewRecentOrders','OrderController@viewRecentOrders');

/*update seen by cashier*/
Route::get('/updateSeenByCashier','OrderController@updateSeenByCashier');

/*view reports*/
Route::get('/reports/{option}','OrderController@reports');

/*driver_tracking*/
Route::get('/driver_tracking/{start_date}/{end_date}','OrderController@driver_tracking');


Route::get('/{any}', function () {
	 return Redirect::to('/login');
});

/*post requests*/
/*adding customer zone*/
Route::post('/addCustomerZone','ZoneController@addCustomerZone');

/*adding vehicle zone*/
Route::post('/addVehicleZone','ZoneController@addVehicleZone');

/*register an user*/
Route::post('/doRegister','UserController@doRegister');

/*authenticates an user*/
Route::post('/doLogin','UserController@doLogin');

/*add a customer*/
Route::post('/addCustomer','CustomerController@addCustomer');

/*add a driver*/
Route::post('/addDriver','DriverController@addDriver');

/*add a vehicle*/
Route::post('/addVehicle','VehicleController@addVehicle');

/*add a company*/
Route::post('/addCompany','CompanyController@addCompany');

/*add a company*/
Route::post('/addProduct','ProductController@addProduct');

/*submit delivery*/
Route::post('/addDelivery','OrderController@addDelivery');

/*submit payment*/
Route::post('/addPayment','OrderController@addPayment');

/*add Stock for Existing Product*/
Route::post('/addStockExistingProduct','ProductController@addStockExistingProduct');

/*add existing product damages*/
Route::post('/addExistingDamaged','ProductController@addExistingDamaged');

/*add new product damages*/
Route::post('/addNewDamagedProducts','ProductController@addNewDamagedProducts');

/*check password*/
Route::post('/checkPassword','UserController@checkPassword');

/*set new password*/
Route::post('/setNewPassword','UserController@setNewPassword');









