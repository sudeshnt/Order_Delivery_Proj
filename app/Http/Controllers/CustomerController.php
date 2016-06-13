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
use App\Customer;

class CustomerController extends Controller
{
    //add a customer
    public function addCustomer(){

    	if(Session::get('loggin_status')==true){
    		$customer = new Customer;
    		$customer->customer_name=Input::get('name');
    		$customer->business_name=Input::get('bizz_name');
    		$customer->customer_address=Input::get('address');
    		$customer->zip=Input::get('zip');
    		$customer->customer_mobile=Input::get('mobile_no');
    		$customer->zone_id=Input::get('zone_id');
    		$customer->save();
			return Redirect::to('/customers');
		}else{
			return Redirect::to('/login');
		}

    }
}
