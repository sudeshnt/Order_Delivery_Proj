<?php

namespace App\Http\Controllers;

use App\Driver;
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

class DriverController extends Controller
{
    //add driver
    public function addDriver(){
        if(Session::get('loggin_status')==true){
            $driver=new Driver;
            $driver->driver_name = Input::get('name');
            $driver->save();
            return Redirect::to('/drivers');
        }else{
            return Redirect::to('/login');
        }

    }
}
