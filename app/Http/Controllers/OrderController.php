<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\Payment;
use App\Product;
use App\ProductsOnOrders;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

use Session;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    //place order
    public function placeOrder(){
        $products_on_order = array();
        $order_date = $_GET['order_date'];
        $order_code = $_GET['order_code'];
        $full_amount = $_GET['full_amount'];
        $vehicle_id = $_GET['vehicle_id'];
        $customer = Customer::where('customer_id',$_GET['customer_id'])->first();
        // handling products in orders
        foreach ($_GET['products_on_order'] as $product_on_order) {
            //adding to products on order table
            $product_on_order_entry = new ProductsOnOrders();
            $product_on_order_entry->order_code = $order_code;
            $product_on_order_entry->product_id = $product_on_order["product_id"];
            $product_on_order_entry->qty = $product_on_order["qty"];
            $product_on_order_entry->save();
            //updating available amounts
            $product = Product::where('product_id',$product_on_order["product_id"])->first();
            DB::table('products')
                ->where('product_id',  $product->product_id)
                ->update(['available_amount' => $product->available_amount - $product_on_order["qty"]]);
        }
        $order = new Order();
        $order->order_code=$order_code;
        $order->order_date = $order_date;
        $order->customer_id=$customer->customer_id;
        $order->full_amount=$full_amount;
        $order->paid_amount=0;
        $order->isPaid=false;
        $order->vehicle_id=$vehicle_id;
        $order->isDelivered=false;
        $order->save();

        //assign vehicle
        DB::table('vehicles')
            ->where('vehicle_id',$vehicle_id)
            ->update(['isAssigned' => 1,'assigned_date' =>  date('Y-m-d H:i:s')]);

        /*return Redirect::to('/login');*/
        /*$view = View::make('invoice');
        return $view;*/
       // print_r(json_encode([$order_date,$order_code,$customer,$products_on_order,$paid_amount,$isPaid,$_GET['products_on_order']]));
        print_r(json_encode($order_code));

    }

    /*generate invoice*/
    public function generateInvoice($order_code){
        $view = View::make('invoice');
        $view->order_details = DB::table('orders')
            ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
            ->where('orders.order_code',$order_code)
            ->select('orders.*', 'customers.*')
            ->first();
        //$view->products_on_order = ProductsOnOrders::where('order_code',$order_code)->get();
        $view->products_on_order = DB::table('products_on_order')
            ->join('products', 'products_on_order.product_id', '=', 'products.product_id')
            ->where('products_on_order.order_code',$order_code)
            ->select('products_on_order.*', 'products.*')
            ->get();
        //dd($view->order_details,$view->products_on_order);
        return $view;

    }

    /*get all orders*/
    public function getAllOrders(){
        $view = View::make('allOrders');
        $view->allOrders = DB::table('orders')
            ->join('customers', 'customers.customer_id', '=', 'orders.customer_id')
            ->select('orders.*', 'customers.*')
            ->get();
        //dd($view->allOrders);
        return $view;
    }

    /*get order by order_code*/
    public function getOrderDetails($order_code){
        $order=DB::table('orders')
            ->join('customers', 'customers.customer_id', '=', 'orders.customer_id')
            ->select('orders.*', 'customers.*')
            ->where('order_code',$order_code)
            ->first();
        print_r(json_encode($order));
    }

    /*submit delivery*/
    public function addDelivery(){
        if(Session::get('loggin_status')==true){
            DB::table('orders')
                ->where('order_code',  Input::get('order_code'))
                ->update(['delivered_at' => Input::get('delivery_date'),'isDelivered'=>1,'whoReceived' => Input::get('whoReceived')]);
            return Redirect::to('/allOrders');
        }else{
            return Redirect::to('/login');
        }
    }

    /*submit payment*/
    public function addPayment(){
        if(Session::get('loggin_status')==true){
           //dd(Input::all());
            $payment = new Payment();
            $payment->order_code = Input::get('order_code');
            $payment->amount = Input::get('amount');
            $payment->payment_date = Input::get('payment_date');
            $payment->save();

            $order=Order::where('order_code',Input::get('order_code'))->first();
            if(Input::get('ispaid')=='true'){
                DB::table('orders')
                    ->where('order_code',  Input::get('order_code'))
                    ->update(['paid_amount' =>  $order->paid_amount+Input::get('amount'),'isPaid'=>1]);
            }
            else{
                DB::table('orders')
                    ->where('order_code',  Input::get('order_code'))
                    ->update(['paid_amount' =>  $order->paid_amount+Input::get('amount')]);
            }

            return Redirect::to('/allOrders');
        }else{
            return Redirect::to('/login');
        }
    }

    /*get payments to a given order*/
    public function getOrderPayments($order_code){
        if(Session::get('loggin_status')==true){
            $payments = Payment::where('order_code',$order_code)-> orderBy('payment_date', 'asc')->get();
            print_r(json_encode($payments));
        }else{
            return Redirect::to('/login');
        }
    }

    public function getCustomerOrders($customer){
        $customer_orders = Order::where('customer_id',$customer)->get();
        print_r(json_encode($customer_orders));
       // dd($customer_orders );
    }






}
