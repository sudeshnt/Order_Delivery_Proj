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

Route::get('/{any}', function () {
	 return Redirect::to('/login');
});

/*get product in order*/
Route::get('/getProduct/{product_id}', 'ProductController@getProduct');

/*post requests*/
/*adding customer zone*/
Route::post('/addCustomerZone','ZoneController@addCustomerZone');

/*adding vehicle zone*/
Route::post('/addVehicleZone','ZoneController@addVehicleZone');

/*register an user*/
Route::post('/doRegister','UserController@doRegister');

/*authenticates an user*/
Route::post('/doLogin','UserController@doLogin');

/*authenticates an user*/
Route::get('/doLogout','UserController@doLogout');

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


