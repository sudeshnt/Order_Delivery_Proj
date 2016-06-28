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
Route::get('/allOrders','OrderController@getAllOrders');

/*submit payment*/
Route::get('/getCustomerZoneVehicles/{customer_id}','VehicleController@getCustomerZoneVehicles');

/*get payments for a order*/
Route::get('/getOrderPayments/{order_code}','OrderController@getOrderPayments');

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





