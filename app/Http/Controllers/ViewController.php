<?php

namespace App\Http\Controllers;

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
			$view->zones_list = Zone::where('zone_type','customer')->get();
			return $view;
		}else{
			return Redirect::to('/login');
		}
	}

	public function addOrder(){
		if(Session::get('loggin_status')=='true'){
			$view = View::make('addOrder');
			return $view;
		}else{
			return Redirect::to('/login');
		}
	}

	public function customerZones(){
		if(Session::get('loggin_status')=='true'){
			$view = View::make('customerZones');
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
