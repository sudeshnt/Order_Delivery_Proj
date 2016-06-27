<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\Product;
use App\ProductsOnOrders;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    //place order
    public function placeOrder(){
        $products_on_order = array();
        $order_date = $_GET['order_date'];
        $order_code = $_GET['order_code'];
        $full_amount = $_GET['full_amount'];
        $paid_amount = $_GET['paid_amount'];
        $isPaid = $_GET['isPaid'];
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

        /*$order->created_at = $order_date;*/
        $order->customer_id=$customer->customer_id;
        $order->full_amount=$full_amount;
        $order->paid_amount=$paid_amount;
        if($isPaid=='true')
            $order->isPaid=true;
        else
            $order->isPaid=false;
        $order->isDelivered=false;
        $order->save();

        /*return Redirect::to('/login');*/
        /*$view = View::make('invoice');
        return $view;*/
       // print_r(json_encode([$order_date,$order_code,$customer,$products_on_order,$paid_amount,$isPaid,$_GET['products_on_order']]));
        print_r(json_encode($order_code));

    }

    /*generate invoice*/
    public function generateInvoice(){
        $view = View::make('invoice');
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


}
