<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\User;
use Validator;
use Crypt;
use Auth;
use Session;
use App\Vehicle;
use App\Driver;
class VehicleController extends Controller
{
    //add a vehicle
    public function addVehicle(){
        if(Session::get('loggin_status')==true){
            $vehicle = new Vehicle;
            $vehicle->vehicle_number = Input::get('number');
            $vehicle->zone_id = Input::get('zone_id');
            $vehicle->driver_id = Input::get('driver');
            $vehicle->save();
            //settingd the selecte driver isAssigned = true
            $driver = Driver::where('driver_id',$vehicle->driver_id)->first();
            $driver->isAssigned=1;
            $driver->save();
            return Redirect::to('/vehicles');
        }else{
            return Redirect::to('/login');
        }
    }

    //get vehicles assigned to the given customer's zone
    public function getCustomerZoneVehicles($customer_id){
        $vehicles=DB::table('customers')
            ->join('vehicles', 'customers.zone_id', '=', 'vehicles.customer_zone_id')
            ->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
            ->select('vehicles.*','drivers.driver_name')
            ->where('customer_id',$customer_id)
            ->where('vehicles.isAssigned',0)
            ->get();
        //dd($vehicles);
        print_r(json_encode($vehicles));
    }
}
