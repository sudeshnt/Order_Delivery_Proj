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
class UserController extends Controller
{
    //register an user
    public function doRegister(){

    	$view=View::make('register');
    	$view->user_already_exist=false;
    	$rules = array(
            'password' => 'required', // password can only be alphanumeric and has to be greater than 3 characters
        	'confirm_password' => 'required|same:password'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $view->message = "validation_failed";
            return $view->withErrors($validator);
        }
        else{
        	$user = new User;
    		$user_count = User::where('username', Input::get('username'))->count();
    		if($user_count==0){
    			$user->name=Input::get('name');
    			$user->username=Input::get('username');
    			$user->password=Crypt::encrypt(Input::get('password'));
    			$user->role_id=Input::get('role_id');
    			$user->save();
    			$view->message="register_success";
    			return $view;
    		}
    		else{

    		   $view->user_already_exist=true;
    		   return $view;
    		}
        }
    }

    //authenticates an user
    public function doLogin(){

    	$view = View::make('login');
    	$view->message = "";
    	// validate the info, create rules for the inputs
        $rules = array(
            'username'    => 'required', // make sure username is entered
            'password' => 'required', //  make sure password is entered
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('login')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            // attempt to do the login
        	$user = User::where('username',Input::get('username'))->first();
        	//user exists
	        	if($user!=null){
	        		//login successful
	        		if(Crypt::decrypt($user->password) == Input::get('password')){
	        			Session::put('users_id', $user->id);
		                Session::put('username', $user->username);
		                Session::put('users_name', $user->name);
		                Session::put('role_id', $user->role_id);
		                Session::put('loggin_status',true);
	        			return Redirect::to('/dashboard');
	        		}
	        		//login failed
	        		else{
						$view->message="incorrect_pw";
						return $view;
	        		}
	        	}
	        	//user doesn't exist
	        	else{
	        			$view->message="no_user";
	        			return $view;
	        	}
        }       
    }

    //logout an user
    public function doLogOut(){
    	Session::flush();
        return Redirect::to('/login');
    }
}
