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
}
