@extends('master')

@section('content')
        <!-- Small boxes (Stat box) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
</section>
<div class="nav-tabs-custom">

    <div class="row" style="padding-top: 20px;">

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$order_count}}</h3>
                    <p>All Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('/allOrders')}}" class="small-box-footer">view all orders <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$customer_count}}<sup style="font-size: 16px">  from {{$customer_zones_count}} zones</sup></h3>
                    <p>All Customers</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-people"></i>
                </div>
                <a href="{{url('/customers')}}" class="small-box-footer">view all customers <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$vehicle_count}}<sup style="font-size: 16px">  from {{$vehicle_zones_count}} zones</sup></h3>
                    <p>All Vehicles</p>
                </div>
                <div class="icon">
                    <i class="ion ion-model-s"></i>
                </div>
                <a href="{{url('/vehicles')}}" class="small-box-footer">view all vehicles <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$product_count}}<sup style="font-size: 16px">  from {{$company_count}} companies</sup></h3>
                    <p>All Products</p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-cart"></i>
                </div>
                <a href="{{url('/products')}}" class="small-box-footer">view all products <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- ./col -->
    </div>

<!-- /.row -->

{{--tables--}}
    {{--table for unseen latest orders--}}
    @if(Session::get('role_id')==3)
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-info collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Recent Orders</h3>
                            @if(isset($recent_orders_count))
                                @if($recent_orders_count>0)
                                    <a style="margin-left: 10px" id="new_order_alert">
                                        <i class="fa fa-envelope-o" style="font-size: x-large;"></i>
                                        <span href="#" class="label label-success" data-widget="collapse" onclick="clickedNewOrders();" style="cursor: pointer;">{{$recent_orders_count}}</span>
                                    </a>
                                @else
                                <a style="margin-left: 10px" id="new_order_alert">
                                    <i class="fa fa-envelope-o" style="font-size: x-large;"></i>
                                    <span href="#" class="label label-danger"  style="cursor: pointer;">No Recent Orders</span>
                                </a>
                                @endif
                            @endif
                        <div class="box-tools pull-right" >
                            @if(isset($recent_orders_count))
                                @if($recent_orders_count>0)
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                @endif
                            @endif
                            {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="padding: 0px;">
                        <table class="table no-margin" id="recent_orders_table">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th style="width: 36px;">Order Code</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Balance</th>
                                <th style="width: 56px;">Payment Status</th>
                                <th style="width: 52px;">Delivery Status</th>
                                <th>Delivered By</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recent_orders as $order)
                                <tr>
                                    <td>{{$order->order_date}}</td>
                                    <td>{{$order->order_code}}</td>
                                    <td>{{$order->customer_name}}</td>
                                    <td>{{$order->full_amount}}</td>
                                    <td>{{$order->paid_amount}}</td>
                                    <td>{{$order->full_amount-$order->paid_amount}}</td>
                                    @if($order->isPaid)
                                        <td><span class="label label-success" style="font-size: small">Paid</span></td>
                                    @else
                                        <td><span class="label label-danger" style="font-size: small">Pending</span></td>
                                    @endif
                                    @if($order->isDelivered)
                                        <td><span class="label label-success" style="font-size: small">Delivered</span></td>
                                    @else
                                        <td><span class="label label-danger" style="font-size: small">Pending</span></td>
                                    @endif
                                    <td>{{$order->vehicle_number}} : {{$order->driver_name}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {{-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>--}}
                        <a href="{{url('/viewRecentOrders')}}" class="btn btn-sm btn-default btn-flat pull-right">View All Recent Orders</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        </div>
        @endif
        <!-- TABLE: LATEST ORDERS -->
    <div class="row">
        {{--top owing customers table--}}
        <div class="col-sm-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">TOP OWING CUSTOMERS</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th style="width:150px; text-align: center;">Customer</th>
                                <th style="text-align: center;">Email</th>
                                <th style="text-align: center;">Phone</th>
                                <th style="text-align: center;">Owing Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($topOwedCustomers as $customer)
                                <tr>
                                    <td>{{$customer->customer_name}}</td>
                                    <td>{{$customer->email}}</td>
                                    <td>{{$customer->customer_mobile}}</td>
                                    <td style="float: right;;"><span class="label label-danger" style="font-size: small;">₦ {{$customer->total_owe}}</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                   {{-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>--}}
                    <a href="{{url('/customers')}}" class="btn btn-sm btn-default btn-flat pull-right">View All Customers</a>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
        {{--top out of stock--}}
        <div class="col-sm-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">TOP OUT of STOCK PRODUCTS</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                       {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th style="text-align: center;">Code</th>
                                <th style="text-align: center;">Product</th>
                                <th style="text-align: center;">Company</th>
                                <th style="text-align: center;">Available Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($topOutofStockProducts as $product)
                                <tr>
                                    <td>{{$product->product_code}}</td>
                                    <td>{{$product->product_name}}</td>
                                    <td style="width:130px;;">{{$product->company_name}}</td>
                                    <td style="text-align: center;"><span class="label label-danger" style="font-size: small;">{{$product->available_amount}}</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    {{-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>--}}
                    <a href="{{url('/products')}}" class="btn btn-sm btn-default btn-flat pull-right">View All Products</a>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-7">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">TOP DRIVERS</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th style="text-align: center;">Driver</th>
                                <th style="text-align: center;">Vehicle Number</th>
                                <th style="text-align: center;">Number of Deliveries</th>
                                <th style="text-align: center;">Average time taken</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bestDrivers as $driver)
                                <tr>
                                    <td>{{$driver[2]}}</td>
                                    <td>{{$driver[3]}}</td>
                                    <td style="width:130px;;">{{$driver[4]}}</td>
                                    <td style="text-align: left;"><span class="label label-success" style="font-size: small;">{{$driver[1]}}</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    {{-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>--}}
                    <a href="{{url('/drivers')}}" class="btn btn-sm btn-default btn-flat pull-right">View All Drivers</a>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
        <div class="col-md-5" style="padding: 0px">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">PRODUCTS SOLD</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="products_table"  class="table no-margin">
                            <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Qty</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($qty_of_products as $key => $value)
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>{{$value}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    {{-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>--}}
                    <a href="{{url('/products')}}" class="btn btn-sm btn-default btn-flat pull-right">View All Products</a>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>
</div>
<!-- /.box -->
<script>

    $(function () {
        $('#recent_orders_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": true
        });
    });

    function clickedNewOrders(){
        $("#new_order_alert").hide();
    }

</script>
@endsection