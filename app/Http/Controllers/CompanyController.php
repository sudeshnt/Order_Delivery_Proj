<?php

namespace App\Http\Controllers;

use App\Company;
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

class CompanyController extends Controller
{
    public function addCompany(){
        if(Session::get('loggin_status')==true){
            $company=new Company();
            $company->company_name = Input::get('company_name');
            $company->save();
            return Redirect::to('/companies');
        }else{
            return Redirect::to('/login');
        }
    }
}
