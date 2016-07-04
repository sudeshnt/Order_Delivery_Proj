<?php

namespace App\Http\Controllers;

use App\DamagedProduct;
use App\Product;
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
use App\Customer;

class ProductController extends Controller
{
    public function addProduct(){
        if(Session::get('loggin_status')==true){
            $product=new Product();
            $product->product_name=Input::get('product_name');
            $product->product_code=Input::get('product_code');
            $product->available_amount=Input::get('product_amount');
            $product->unit_price=Input::get('product_unitprice');
            $product->company_id=Input::get('company_id');
            $product->isDamaged=false;
            $product->product_size=Input::get('product_size');
            $product->save();
            return Redirect::to('/products');
        }else{
            return Redirect::to('/login');
        }
    }

    public function getProduct($product_id){
        $product = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.company_id')
            ->select('products.*', 'companies.company_name')
            ->where('products.product_id',$product_id)
            ->first();
        print_r(json_encode($product));
    }

    //add Stock for Existing Product
    public function addStockExistingProduct(){
        $product = Product::where('product_id',Input::get('product_id'))->first();
        DB::table('products')
            ->where('product_id',Input::get('product_id'))
            ->update(['available_amount' => $product->available_amount+Input::get('added_amount')]);
        return Redirect::to('/products');
    }

    public function addExistingDamaged(){
        $product = Product::where('product_id',Input::get('product_id'))->first();
        DB::table('products')
            ->where('product_id',Input::get('product_id'))
            ->update(['available_amount' => $product->available_amount-Input::get('damaged_qty')]);

        //checking if damaged product is already existed
        $is_exist_damaged_product = DamagedProduct::where('product_id',Input::get('product_id'))->first();
        If($is_exist_damaged_product != ''){
            DB::table('damaged_products')
                ->where('product_id',Input::get('product_id'))
                ->update(['qty' => $is_exist_damaged_product->qty+Input::get('damaged_qty')]);
        }
        else{
            $damaged_product = new DamagedProduct();
            $damaged_product->product_id = Input::get('product_id');
            $damaged_product->qty = Input::get('damaged_qty');
            $damaged_product->save();
        }

        return Redirect::to('/products');
    }

    public function addNewDamagedProducts(){
        $product=new Product();
        $product->product_name=Input::get('product_name');
        $product->product_code=Input::get('product_code');
        $product->available_amount=0;
        $product->company_id=Input::get('company_id');
        $product->isDamaged=true;
        $product->product_size=Input::get('product_size');
        $product->save();

        $product_just_added = Product::where('product_code',Input::get('product_code'))->first();
        $damaged_product = new DamagedProduct();
        $damaged_product->product_id = $product_just_added->product_id;
        $damaged_product->qty = Input::get('damaged_amount');
        $damaged_product->save();
        return Redirect::to('/products');
    }
}
