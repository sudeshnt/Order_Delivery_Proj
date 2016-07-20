<?php

namespace App\Http\Controllers;

use App\Customer;
use App\DamagedProduct;
use App\Order;
use App\Payment;
use App\Product;
use App\ProductsOnOrders;
use Carbon\Carbon;
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
        $isDelivered = $_GET['isDelivered'];

        //dd($isDelivered);
        $customer = Customer::where('customer_id',$_GET['customer_id'])->first();
        // handling products in orders
        foreach ($_GET['products_on_order'] as $product_on_order) {

            $product = Product::where('product_id',$product_on_order["product_id"])->first();

            //adding to products on order table
            $product_on_order_entry = new ProductsOnOrders();
            $product_on_order_entry->order_code = $order_code;
            $product_on_order_entry->product_id = $product_on_order["product_id"];
            $product_on_order_entry->qty = $product_on_order["qty"];
            //available amount after the order
            $product_on_order_entry->available_amount = $product->available_amount-$product_on_order["qty"];
            $product_on_order_entry->save();

            //updating available amounts
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
        $order->isDelivered=$isDelivered;
        if($isDelivered==1){
            $order->deliveryType = 'byHand';
            $order->delivered_at = $order_date;
            $order->whoReceived = $customer->customer_name;
        }else{
            $order->deliveryType = 'byVehicle';
        }
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
    /**
     * @param $option
     * @return mixed
     */
    function getProductOnOrder($order_codes){
        $order_products=ProductsOnOrders::join('products','products_on_order.product_id', '=', 'products.product_id')
            ->join('orders','products_on_order.order_code', '=', 'orders.order_code')
            ->select('orders.order_date','orders.order_code','products.product_name','products_on_order.qty')
            ->whereIn('products_on_order.order_code',$order_codes)
            ->get();
        return $order_products ;
    }

    public function getAllOrders($option,$active_tab){
        $view = View::make('allOrders');
        if($option=='all'){
            $view->allOrders = DB::table('orders')
                ->join('customers', 'customers.customer_id', '=', 'orders.customer_id')
                ->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
                ->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
                ->select('orders.*', 'customers.*','vehicles.vehicle_number','drivers.driver_name')
                ->orderBy('orders.order_date','desc')
                ->get();
           // dd($view->allOrders);
            $view->option='';
        }else{
            $dates = explode(",", $option);
            $startdate=$dates[0];
            $enddate=$dates[1];
            $view->allOrders = DB::table('orders')
                ->join('customers', 'customers.customer_id', '=', 'orders.customer_id')
                ->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
                ->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
                ->select('orders.*', 'customers.*','vehicles.vehicle_number','drivers.driver_name')
                ->orderBy('orders.order_date','desc')
                ->where('orders.order_date','>=',$startdate)
                ->where('orders.order_date','<=',$enddate)
                ->get();
            $view->option='Filtered ';
            $view->filteredDate = date('m/d/Y', strtotime(str_replace('-', '/', $startdate)))." - ".date('m/d/Y', strtotime(str_replace('-', '/', $enddate)));
        }
        if($view->allOrders != ''){
            $order_code_list = array();
            foreach($view->allOrders as $sale) {
                array_push($order_code_list,$sale->order_code);
            }
            $view->products_on_order=$this->getProductOnOrder($order_code_list);
        }
        $view->active_tab=$active_tab;
        return $view;
    }

    // get Deliverd Orders
    public function getDeliverdOrders($option,$active_tab){
        $view = View::make('allOrders');
        $view->allOrders = DB::table('orders')
            ->join('customers', 'customers.customer_id', '=', 'orders.customer_id')
            ->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
            ->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
            ->select('orders.*', 'customers.*','vehicles.vehicle_number','drivers.driver_name')
            ->where('orders.isDelivered',1)
            ->orderBy('orders.order_date','desc')
            ->get();
        if($view->allOrders != ''){
            $order_code_list = array();
            foreach($view->allOrders as $sale) {
                array_push($order_code_list,$sale->order_code);
            }
            $view->products_on_order=$this->getProductOnOrder($order_code_list);
        }
        $view->option = "Delivered ";
        //dd($view->allOrders);
        return $view;
    }

    //get Not Delivered Orders
    public function getNotDeliveredOrders($option,$active_tab){
        $view = View::make('allOrders');
        $view->allOrders = DB::table('orders')
            ->join('customers', 'customers.customer_id', '=', 'orders.customer_id')
            ->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
            ->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
            ->select('orders.*', 'customers.*','vehicles.vehicle_number','drivers.driver_name')
            ->where('orders.isDelivered',0)
            ->orderBy('orders.order_date','desc')
            ->get();
        if($view->allOrders != ''){
            $order_code_list = array();
            foreach($view->allOrders as $sale) {
                array_push($order_code_list,$sale->order_code);
            }
            $view->products_on_order=$this->getProductOnOrder($order_code_list);
        }
        $view->option='Not Delivered ';
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
                ->where('order_code',  Input::get('order_code_del'))
                ->update(['delivered_at' => Input::get('delivery_date'),'driver_returned_time' => Input::get('returned_date'),'isDelivered'=>1,'whoReceived' => Input::get('whoReceived')]);
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

    /*View Order*/
    public function viewOrder($order_code){
        $order_details = DB::table('orders')
            ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
            ->where('orders.order_code',$order_code)
            ->select('orders.*', 'customers.*')
            ->first();
        $products_on_order = DB::table('products_on_order')
            ->join('products', 'products_on_order.product_id', '=', 'products.product_id')
            ->where('products_on_order.order_code',$order_code)
            ->select('products_on_order.*', 'products.*')
            ->get();
        print_r(json_encode([$order_details,$products_on_order]));
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
        $customer_orders=DB::table('orders')
                            ->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
                            ->join('drivers','vehicles.driver_id','=','drivers.driver_id')
                            ->select('orders.*', 'vehicles.vehicle_number','drivers.driver_name')
                            ->where('orders.customer_id',$customer)
                            ->orderBy('orders.order_date', 'asc')
                            ->get();
        print_r(json_encode($customer_orders));
       // dd($customer_orders );
    }

    /*get orders of a given product in the past*/
    public function getProductOrders($product_id){

        $product_orders=DB::table('products_on_order')
                            ->join('orders', 'products_on_order.order_code', '=', 'orders.order_code')
                            ->join('products', 'products_on_order.product_id', '=', 'products.product_id')
                            ->join('customers','orders.customer_id','=','customers.customer_id')
                            ->select('products_on_order.*', 'orders.order_date','products.product_name','customers.customer_name')
                            ->where('products_on_order.product_id',$product_id)
                            ->orderBy('orders.order_date', 'desc')
                            ->get();
        print_r(json_encode($product_orders));
    }

    /*get filtered orders of a given product in a date range*/
    public function getFilteredProductOrders($start_date,$end_date,$product_id){
        $product_orders=DB::table('products_on_order')
            ->join('orders', 'products_on_order.order_code', '=', 'orders.order_code')
            ->join('products', 'products_on_order.product_id', '=', 'products.product_id')
            ->join('customers','orders.customer_id','=','customers.customer_id')
            ->select('products_on_order.*', 'orders.order_date','products.product_name','customers.customer_name')
            ->where('products_on_order.product_id',$product_id)
            ->where('orders.order_date','>=',$start_date)
            ->where('orders.order_date','<=',$end_date)
            ->orderBy('orders.order_date', 'desc')
            ->get();
        print_r(json_encode($product_orders));
    }

    //view recent orders
    public function viewRecentOrders(){
        $view = View::make('allOrders');
        $view->allOrders = DB::table('orders')
            ->join('customers', 'customers.customer_id', '=', 'orders.customer_id')
            ->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
            ->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
            ->select('orders.*', 'customers.*','vehicles.vehicle_number','drivers.driver_name')
            ->where('orders.isSeenByCashier',0)
            ->orderBy('orders.order_date','desc')
            ->get();

        DB::table('orders')
            ->update(['isSeenByCashier' =>  1]);
        //dd($view->allOrders);
        return $view;
    }
    // driver tracking
    public function driver_tracking($start_date,$end_date){

        $view = View::make('driver_tracking');
        if($start_date=="then" && $end_date="now"){
            $allOrders = DB::table('orders')
                ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
                ->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
                ->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
                ->join('products_on_order', 'orders.order_code', '=', 'products_on_order.order_code')
                ->select('orders.*','customers.customer_name','vehicles.*','drivers.*',DB::raw('count(products_on_order.qty) as num_product,SUM(products_on_order.qty) as total_qty'))
                ->groupBy('orders.order_code')
                ->where('orders.isDelivered',1)
                ->where('orders.deliveryType','byVehicle')
                ->get();

            $allOrdersNotDelivered = DB::table('orders')
                ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
                ->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
                ->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
                ->join('products_on_order', 'orders.order_code', '=', 'products_on_order.order_code')
                ->select('orders.*','customers.customer_name','vehicles.*','drivers.*',DB::raw('count(products_on_order.qty) as num_product,SUM(products_on_order.qty) as total_qty'))
                ->groupBy('orders.order_code')
                ->where('orders.isDelivered',0)
                ->where('orders.deliveryType','byVehicle')
                ->get();
        }
        else{
            $allOrders = DB::table('orders')
                ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
                ->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
                ->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
                ->join('products_on_order', 'orders.order_code', '=', 'products_on_order.order_code')
                ->select('orders.*','customers.customer_name','vehicles.*','drivers.*',DB::raw('count(products_on_order.qty) as num_product,SUM(products_on_order.qty) as total_qty'))
                ->groupBy('orders.order_code')
                ->where('orders.isDelivered',1)
                ->where('orders.deliveryType','byVehicle')
                ->where('orders.delivered_at','>=',$start_date)
                ->where('orders.delivered_at','<=',$end_date." 23:59:59")
                ->get();

            $allOrdersNotDelivered = DB::table('orders')
                ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
                ->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
                ->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
                ->join('products_on_order', 'orders.order_code', '=', 'products_on_order.order_code')
                ->select('orders.*','customers.customer_name','vehicles.*','drivers.*',DB::raw('count(products_on_order.qty) as num_product,SUM(products_on_order.qty) as total_qty'))
                ->groupBy('orders.order_code')
                ->where('orders.isDelivered',0)
                ->where('orders.deliveryType','byVehicle')
                ->where('orders.delivered_at','>=',$start_date)
                ->where('orders.delivered_at','<=',$end_date." 23:59:59")
                ->get();
            $view->filteredDate = date('m/d/Y', strtotime(str_replace('-', '/', $start_date)))." - ".date('m/d/Y', strtotime(str_replace('-', '/', $end_date)));
        }


        $grouped_into_drivers = array();
        foreach($allOrders as $driver_delivery){

            if(array_key_exists($driver_delivery->driver_name, $grouped_into_drivers)){

                array_push( $grouped_into_drivers[$driver_delivery->driver_name]["delivery_times"],Carbon::parse($driver_delivery->order_date)->diffInSeconds(Carbon::parse($driver_delivery->driver_returned_time)));
                $seconds = ceil(array_sum($grouped_into_drivers[$driver_delivery->driver_name]["delivery_times"])/count($grouped_into_drivers[$driver_delivery->driver_name]["delivery_times"]));
                $grouped_into_drivers[$driver_delivery->driver_name]["average_delivery_time_in_seconds"]=$seconds;
                $grouped_into_drivers[$driver_delivery->driver_name]["average_delivery_time"]=(new \DateTime('@0'))->diff(new \DateTime("@$seconds"))->format('%a days, %h hours, %i minutes and %s seconds');

                array_push($grouped_into_drivers[$driver_delivery->driver_name]["orders"],$driver_delivery);
                $grouped_into_drivers[$driver_delivery->driver_name]["number_of_orders"]=count($grouped_into_drivers[$driver_delivery->driver_name]["orders"]);
                $grouped_into_drivers[$driver_delivery->driver_name]["number_of_products_carried"]+=$driver_delivery->num_product;
                $grouped_into_drivers[$driver_delivery->driver_name]["number_of_units_carried"]+=$driver_delivery->total_qty;
            }else{
                $grouped_into_drivers[$driver_delivery->driver_name]["orders"] = array();
                $grouped_into_drivers[$driver_delivery->driver_name]["delivery_times"] = array();

                array_push( $grouped_into_drivers[$driver_delivery->driver_name]["delivery_times"],Carbon::parse($driver_delivery->order_date)->diffInSeconds(Carbon::parse($driver_delivery->driver_returned_time)));
                $seconds = ceil(array_sum($grouped_into_drivers[$driver_delivery->driver_name]["delivery_times"])/count($grouped_into_drivers[$driver_delivery->driver_name]["delivery_times"]));
                $grouped_into_drivers[$driver_delivery->driver_name]["average_delivery_time_in_seconds"]=$seconds;
                $grouped_into_drivers[$driver_delivery->driver_name]["average_delivery_time"]=(new \DateTime('@0'))->diff(new \DateTime("@$seconds"))->format('%a days, %h hours, %i minutes and %s seconds');


                array_push($grouped_into_drivers[$driver_delivery->driver_name]["orders"],$driver_delivery);
                $grouped_into_drivers[$driver_delivery->driver_name]["number_of_orders"]=count($grouped_into_drivers[$driver_delivery->driver_name]["orders"]);
                $grouped_into_drivers[$driver_delivery->driver_name]["number_of_products_carried"]=$driver_delivery->num_product;
                $grouped_into_drivers[$driver_delivery->driver_name]["number_of_units_carried"]=$driver_delivery->total_qty;
                $grouped_into_drivers[$driver_delivery->driver_name]["driver_name"]=$driver_delivery->driver_name;
            }

        }
        usort($grouped_into_drivers, function($a, $b) {
            return $b['number_of_orders'] - $a['number_of_orders'];
        });

        //based on highest number of deliveries
        $view->sorted_by_highest_number_of_deliveries = $grouped_into_drivers;

        usort($grouped_into_drivers, function($a, $b) {
            return $b['number_of_units_carried'] - $a['number_of_units_carried'];
        });

        //based on highest number of products carried
        $view->sorted_by_highest_number_of_units_carried = $grouped_into_drivers;

        // most responsive drivers
        usort($grouped_into_drivers, function($a, $b) {
            return $a['average_delivery_time_in_seconds'] - $b['average_delivery_time_in_seconds'];
        });
        $view->most_responsive = $grouped_into_drivers;
        $view->index=0;

        //for pending deliveries of each driver
        $non_delivered_grouped_into_drivers = array();
        foreach($allOrdersNotDelivered as $driver_pending_delivery){
            if(array_key_exists($driver_pending_delivery->driver_name, $non_delivered_grouped_into_drivers)){
                array_push( $non_delivered_grouped_into_drivers[$driver_pending_delivery->driver_name]["orders"],$driver_pending_delivery);
                $non_delivered_grouped_into_drivers[$driver_pending_delivery->driver_name]["order_count"]=count($non_delivered_grouped_into_drivers[$driver_pending_delivery->driver_name]["orders"]);
                $non_delivered_grouped_into_drivers[$driver_pending_delivery->driver_name]["driver_name"]=$driver_pending_delivery->driver_name;
            }
            else{
                $non_delivered_grouped_into_drivers[$driver_pending_delivery->driver_name]["orders"] = array();
                array_push( $non_delivered_grouped_into_drivers[$driver_pending_delivery->driver_name]["orders"],$driver_pending_delivery);
                $non_delivered_grouped_into_drivers[$driver_pending_delivery->driver_name]["order_count"]=count($non_delivered_grouped_into_drivers[$driver_pending_delivery->driver_name]["orders"]);
                $non_delivered_grouped_into_drivers[$driver_pending_delivery->driver_name]["driver_name"]=$driver_pending_delivery->driver_name;
            }
        }

        usort($non_delivered_grouped_into_drivers, function($a, $b) {
            return $b['order_count'] - $a['order_count'];
        });

        $view->pending_deliveries_grouped_by_driver = $non_delivered_grouped_into_drivers;
        //dd($view->pending_deliveries_grouped_by_driver);
        return $view;
        //dd($view->sorted_by_highest_number_of_deliveries,$view->sorted_by_highest_number_of_units_carried);
    }

    // view reports
    function reports($option){

        $view = View::make('reports');

        if($option == 'daily'){
            $startdate = date("Y-m-d");
            $enddate = date("Y-m-d H:i:s");
            $view->option = "Today's";
        }else if($option == 'monthly' || $option=='custom'){
            $startdate = date("Y-m-01");
            $enddate = date("Y-m-d H:i:s");
            $view->option = 'Monthly';

        }else{
            $dates = explode(",", $option);
            $startdate=$dates[0];
            $enddate=$dates[1];
            $view->option = 'Filtered';
            $view->filteredDate = date('m/d/Y', strtotime(str_replace('-', '/', $startdate)))." - ".date('m/d/Y', strtotime(str_replace('-', '/', $enddate)));
        }

        //get all orders made within range
        $view->allOrders = DB::table('orders')
                    ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
                    ->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
                    ->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
                    ->join('products_on_order', 'orders.order_code', '=', 'products_on_order.order_code')
                    ->select('orders.*','customers.customer_name','vehicles.*','drivers.*',DB::raw('count(products_on_order.qty) as num_product,SUM(products_on_order.qty) as total_qty'))
                    ->groupBy('orders.order_code')
                    ->where('orders.order_date','>=',$startdate)
                    ->where('orders.order_date','<=',$enddate)
                    ->get();
        // get all deliveries daily or monthly
        $view->allDeliveries = DB::table('orders')
                    ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
                    ->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.vehicle_id')
                    ->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
                    ->join('products_on_order', 'orders.order_code', '=', 'products_on_order.order_code')
                    ->select('orders.order_date','orders.order_code','orders.whoReceived','customers.customer_name','vehicles.vehicle_number','drivers.*',DB::raw('count(products_on_order.qty) as num_product,SUM(products_on_order.qty) as total_qty'))
                    ->groupBy('orders.order_code')
                    ->where('orders.delivered_at','>=',$startdate)
                    ->where('orders.delivered_at','<=',$enddate)
                    ->get();
        // sales wise , products wise , income wise reports

        $order_code_list = array();
        $view->total_sales = 0;
        $view->total_settled = 0;
        foreach($view->allOrders as $sale) {
            array_push($order_code_list,$sale->order_code);
            $view->total_sales+=$sale->full_amount;
            $view->total_settled+=$sale->paid_amount;
        }
        $view->total_due_payments = $view->total_sales-$view->total_settled;

        $order_products=ProductsOnOrders::join('products','products_on_order.product_id', '=', 'products.product_id')->select('products.product_name','products_on_order.qty')->whereIn('order_code',$order_code_list)->get();
        $view->qty_of_products = array();
        $view->total_units_sold=0;
        foreach($order_products as $products_on_order) {
            if(array_key_exists($products_on_order->product_name, $view->qty_of_products)){
                $view->qty_of_products["$products_on_order->product_name"]+=$products_on_order->qty;
                $view->total_units_sold+=$products_on_order->qty;
            }else{
                $view->qty_of_products["$products_on_order->product_name"]=$products_on_order->qty;
                $view->total_units_sold+=$products_on_order->qty;
            }
        }

        // getting payment reports
        $view->payment_reports = Payment::where('payment_date','>=',$startdate)->where('payment_date','<=',$enddate)->get();
        $view->total_income = 0;
        foreach($view->payment_reports as $payment) {
            $view->total_income+=$payment->amount;
        }

        return $view;
    }


}
