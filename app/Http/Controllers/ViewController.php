<?php

namespace App\Http\Controllers;

use App\Company;
use App\Customer;
use App\DamagedProduct;
use App\Order;
use App\Product;
use App\ProductsOnOrders;
use App\Vehicle;
use DateTime;
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

use Carbon\Carbon;

class ViewController extends Controller
{		
	public function dashboard(){
		if(Session::get('loggin_status')=='true'){
			$view = View::make('dashboard');
			//getting top
			$view->topOwedCustomers = DB::table('orders')
									->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
									->select('customers.*', DB::raw('SUM(orders.full_amount)-SUM(orders.paid_amount) as total_owe') )
									->groupBy('orders.customer_id')
									->havingRaw('total_owe > 0')
									->orderBy('total_owe','desc')
									->take(5)
									->get();
			$view->topOutofStockProducts = DB::table('products')
									->join('companies', 'products.company_id', '=', 'companies.company_id')
									->orderBy('available_amount','asc')
									->where('products.available_amount','<=',0)
									->take(5)
									->get();
			// getting counts of all
			$view->order_count = Order::count();
			$view->customer_count = Customer::count();
			$view->customer_zones_count = Zone::where('zone_type','customer')->count();
			$view->vehicle_count = Vehicle::count();
			$view->vehicle_zones_count = Zone::where('zone_type','vehicle')->count();
			$view->product_count = Product::count();
			$view->company_count = Company::count();

			//getting top drivers

			$allOrders = DB::table('orders')
									->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
									->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
									->select('orders.order_date','orders.driver_returned_time','vehicles.*','drivers.*')
									->where('orders.isDelivered',1)
									->get();
			$delivery_driver_list = Order::join('vehicles','vehicles.vehicle_id', '=', 'orders.vehicle_id')
										->join('drivers','drivers.driver_id', '=', 'vehicles.driver_id')
										->select('drivers.driver_id')->distinct()->get();
			$delivery_times = array();
			$driver_stats = array();
			foreach ($delivery_driver_list as $driver)
			{
				$delivery_times[$driver->driver_id] = array();
			}
			foreach($allOrders as $driver){
				array_push($delivery_times[$driver->driver_id],Carbon::parse($driver->order_date)->diffInSeconds(Carbon::parse($driver->driver_returned_time)));
				$seconds = ceil(array_sum($delivery_times[$driver->driver_id])/count($delivery_times[$driver->driver_id]));
				$driver_stats[$driver->driver_id]=[$seconds,(new \DateTime('@0'))->diff(new \DateTime("@$seconds"))->format('%a days, %h hours, %i minutes and %s seconds'),$driver->driver_name,$driver->vehicle_number,count($delivery_times[$driver->driver_id])];
			}
			asort($driver_stats);
			$view->bestDrivers = array_slice($driver_stats, 0, 5);

			//get unseen orders for cashier
			if(Session::get('role_id')==3){
				$view->recent_orders = DB::table('orders')
											->join('customers', 'customers.customer_id', '=', 'orders.customer_id')
											->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
											->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
											->select('orders.*', 'customers.*','vehicles.vehicle_number','drivers.driver_name')
											->where('orders.isSeenByCashier',0)
											->orderBy('orders.order_date','desc')
											->get();
				$view->recent_orders_count = count($view->recent_orders);
				//dd($view->recent_orders_count );
			}

			//getting units sold from each product
			$order_code_list = array();
			$order_codes = Order::select('order_code')
					->where('order_date','>=',date("Y-m-d"))
					->get();
			foreach($order_codes as $order_code) {
				array_push($order_code_list,$order_code->order_code);
			}
			$order_products=ProductsOnOrders::join('products','products_on_order.product_id', '=', 'products.product_id')
											->select('products.product_name','products_on_order.qty')
											->whereIn('order_code',$order_code_list)
											->get();
			$view->qty_of_products = array();
			$view->total_units_sold=0;
			foreach($order_products as $products_on_order) {
				if(array_key_exists($products_on_order->product_name, $view->qty_of_products)){
					$view->qty_of_products["$products_on_order->product_name"]+=$products_on_order->qty;
					$view->total_units_sold+=$products_on_order->qty;
				}else{
					$view->qty_of_products["$products_on_order->product_name"]=$products_on_order->qty;
					$view->total_units_sold+=$products_on_order->qty;
				}
			}
			arsort($view->qty_of_products);
			//dd($view->qty_of_products);

			return $view;
		}else{
			return Redirect::to('/login');
		}
	}

	function secondsToTime($seconds) {

	}

	public function customers(){
		if(Session::get('loggin_status')=='true'){

			$view = View::make('customers');

			// generating owed customer Ids
			$owed_customer_list = DB::table('orders')
				->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
				->select('customers.customer_id', DB::raw('SUM(orders.full_amount) as total_sales') , DB::raw('SUM(orders.paid_amount) as total_paid'))
				->groupBy('orders.customer_id')
				->havingRaw('total_sales > total_paid')
				->get();
			$owed_customer_id_list = array();
			foreach($owed_customer_list as $owed_customer){
				array_push($owed_customer_id_list,$owed_customer->customer_id);
			}

			$view->allCustomers = DB::table('customers')
					->join('zones', 'customers.zone_id', '=', 'zones.zone_id')
					->select('customers.*', 'zones.zone_name')
					->get();

			//adding new attribute for owed customers isOwed = true
			foreach($view->allCustomers as $customer){
				if (in_array($customer->customer_id, $owed_customer_id_list)) {
					$customer->isOwed = true;
				}
				else{
					$customer->isOwed = false;
				}
			}

			$view->zones_list = Zone::where('zone_type','customer')->get();
			//get customer list that has due payments
			$view->owed_customer_list = DB::table('orders')
				->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
				->groupBy('orders.customer_id')
				->get();
			return $view;
		}else{
			return Redirect::to('/login');
		}
	}

	public function vehicles(){
		if(Session::get('loggin_status')=='true'){
			$view = View::make('vehicles');
			$view->allVehicles = DB::table('vehicles')
				->join('zones as vehicleZones', 'vehicles.zone_id', '=', 'vehicleZones.zone_id')
				->join('zones as customerZones', 'vehicles.customer_zone_id', '=', 'customerZones.zone_id')
				->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
				->select('vehicles.*', 'vehicleZones.zone_name' ,'customerZones.zone_name as customer_zone_name', 'drivers.driver_name')
				->get();
			$view->zones_list = Zone::where('zone_type','vehicle')->get();
			$view->driver_list = Driver::where('isAssigned',0)->get();
			//getting unassigned customer zones
			/*$assigned_customer_zones = DB::table('vehicles')
				 		               ->where('isAssigned',1)
									   ->select('vehicles.customer_zone_id')->get();
			$assigned_customer_zone_ids = array();
			foreach($assigned_customer_zones as $customer_zone)
				array_push($assigned_customer_zone_ids,$customer_zone->customer_zone_id);*/
			$view->customer_zones = DB::table('zones')
					->where('zone_type','customer')
					->get();
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
				->where('products.isDamaged',false)
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
			$view->vehicle_zones = DB::table('vehicles')
				->join('zones', 'vehicles.zone_id', '=', 'zones.zone_id')
				->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
				->select('vehicles.*', 'zones.zone_name','drivers.driver_name')
				->get();
			/*$view->vehicle_zones = DB::table('vehicles')
				->join('zones as vehicle_zone_table', 'vehicles.zone_id', '=', 'vehicle_zone_table.zone_id')
				->join('zones as customer_zone_table', 'vehicles.customer_zone_id', '=', 'customer_zone_table.zone_id')
				->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
				->select('vehicles.*', 'vehicle_zone_table.zone_name','customer_zone_table.zone_name as customer_zone_name','drivers.driver_name')
				->get();*/
			//dd($view->vehicle_zones);
			$vehicles = array();
			foreach ($view->vehicle_zones as $vehicle)
			{
				$vehicles[$vehicle->zone_name] = array();
			}
			foreach ($view->vehicle_zones as $vehicle)
			{
				array_push($vehicles[$vehicle->zone_name],$vehicle);
			}
			//dd($customers);
			$view->vehicles_in_each_zone = $vehicles;
			$view->index=0;
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

	//open damaged Products page
	public function damagedProducts(){
		if(Session::get('loggin_status')=='true'){

			$view = View::make('damagedProducts');
			$view->allProducts = Product::all();
			$view->allCompanies = Company::all();

			$view->allDamagedProducts = DB::table('damaged_products')
				->join('products', 'damaged_products.product_id', '=', 'products.product_id')
				->join('companies', 'products.company_id', '=', 'companies.company_id')
				->select('damaged_products.*', 'products.*','companies.company_name')
				->get();
			//dd();
			$all_damaged_in_each_company = array();
			foreach($view->allDamagedProducts as $damaged)
			{
				$all_damaged_in_each_company[$damaged->company_name] = array();
			}
			foreach ($view->allDamagedProducts as $damaged)
			{
				array_push($all_damaged_in_each_company[$damaged->company_name],$damaged);
			}
			//dd($customers);
			$view->all_damaged_in_each_company = $all_damaged_in_each_company;
			$view->index=0;

			return $view;
		}else{
			return Redirect::to('/login');
		}
	}
	
}
