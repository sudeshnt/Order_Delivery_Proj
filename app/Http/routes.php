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
