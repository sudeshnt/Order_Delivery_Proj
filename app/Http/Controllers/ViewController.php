<?php

namespace App\Http\Controllers;

use App\Company;
use App\Customer;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\User;
use Validator;
use Crypt;
use Auth;
use Session;
use App\Zone;
use DB;
use App\Driver;

class ViewController extends Controller
{		
	public function dashboard(){
		if(Session::get('loggin_status')=='true'){
			$view = View::make('dashboard');
			return $view;
		}else{
			return Redirect::to('/login');
		}
	}

	public function customers(){
		if(Session::get('loggin_status')=='true'){
			$view = View::make('customers');
			$view->allCustomers = DB::table('customers')
					->join('zones', 'customers.zone_id', '=', 'zones.zone_id')
					->select('customers.*', 'zones.zone_name')
					->get();
			$view->zones_list = Zone::where('zone_type','customer')->get();
			return $view;
		}else{
			return Redirect::to('/login');
		}
	}

	public function vehicles(){
		if(Session::get('loggin_status')=='true'){
			$view = View::make('vehicles');
			$view->allVehicles = DB::table('vehicles')
				->join('zones', 'vehicles.zone_id', '=', 'zones.zone_id')
				->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
				->select('vehicles.*', 'zones.zone_name' , 'drivers.driver_name')
				->get();
			$view->zones_list = Zone::where('zone_type','vehicle')->get();
			$view->driver_list = Driver::where('isAssigned',0)->get();
			return $view;
		}else{
			return Redirect::to('/login');
		}
	}

	public function drivers(){
		if(Session::get('loggin_status')=='true'){
			$view = View::make('drivers');
			$view->allDrivers = Driver::all();
			return $view;
		}else{
			return Redirect::to('/login');
		}
	}

	public function companies()
	{
		if (Session::get('loggin_status') == 'true') {
			$view = View::make('companies');
			$view->allCompanies = Company::all();
			return $view;
		} else {
			return Redirect::to('/login');
		}
	}

	public function products()
	{
		if (Session::get('loggin_status') == 'true') {
			$view = View::make('products');
			$view->allProducts = DB::table('products')
				->join('companies', 'products.company_id', '=', 'companies.company_id')
				->select('products.*', 'companies.company_name')
				->get();
			$view->allCompanies = Company::all();
			return $view;
		} else {
			return Redirect::to('/login');
		}
	}

	public function addOrder(){
		if(Session::get('loggin_status')=='true'){
			$view = View::make('addOrder');
			$view->allCustomers=Customer::all();
			$view->allProducts=DB::table('products')
				->join('companies', 'products.company_id', '=', 'companies.company_id')
				->select('products.*', 'companies.company_name')
				->get();
			return $view;
		}else{
			return Redirect::to('/login');
		}
	}

	public function customerZones(){
		if(Session::get('loggin_status')=='true'){
			$view = View::make('customerZones');
			$view->customer_zones = DB::table('customers')
				->join('zones', 'customers.zone_id', '=', 'zones.zone_id')
				->select('customers.*', 'zones.zone_name')
				->get();
			$customers = array();
			foreach ($view->customer_zones as $customer)
			{
				$customers[$customer->zone_name] = array();
			}
			foreach ($view->customer_zones as $customer)
			{
				array_push($customers[$customer->zone_name],$customer);
			}
			//dd($customers);
			$view->customers_in_each_zone = $customers;
			$view->index=0;
			return $view;
		}else{
			return Redirect::to('/login');
		}
	}

	public function vehicleZones(){
		if(Session::get('loggin_status')=='true'){
			$view = View::make('vehicleZones');
			return $view;
		}else{
			return Redirect::to('/login');
		}
	}

	public function register(){
		if(Session::get('loggin_status')=='true'){
			$view = View::make('register');
			$view->user_already_exist=false;
			$view->message="";
			return $view;
		}else{
			return Redirect::to('/login');
		}
	}
}
