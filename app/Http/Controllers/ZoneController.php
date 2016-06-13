<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\Zone;

class ZoneController extends Controller
{
	//add customer zone
	public function addCustomerZone(){
		$zone = new Zone;
		$zone->zone_type = 'customer';
		$zone->zone_name = Input::get('customer_zone');
		$zone->save();
		return Redirect::to('/customerZones');
	}

	//add vehicle zone
    public function addVehicleZone(){
    	$zone = new Zone;
		$zone->zone_type = 'vehicle';
		$zone->zone_name = Input::get('vehicle_zone');
		$zone->save();
		return Redirect::to('/vehicleZones');
    }

}
